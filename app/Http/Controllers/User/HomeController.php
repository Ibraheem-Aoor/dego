<?php

namespace App\Http\Controllers\User;


use App\Helpers\GoogleAuthenticator;
use App\Helpers\UserSystemInfo;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\City;
use App\Models\Country;
use App\Models\Deposit;
use App\Models\FavouriteList;
use App\Models\Gateway;
use App\Models\Kyc;
use App\Models\Language;
use App\Models\State;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\CurrentPassword;
use App\Rules\PhoneLength;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;


class HomeController extends Controller
{
    use Upload, Notify;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function saveToken(Request $request)
    {
        try {
            Auth::user()
                ->fireBaseToken()
                ->create([
                    'token' => $request->token,
                ]);
            return response()->json([
                'msg' => 'token saved successfully.',
            ]);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function index(Request $request)
    {
        $data['user'] = Auth::user();
        $data['firebaseNotify'] = config('firebase');
        $data['totalTransaction'] = Transaction::where('user_id', auth()->id())->count();
        $data['totalTicket'] = SupportTicket::where('user_id', auth()->id())->count();
        $data = Booking::where('user_id', auth()->id())
            ->whereIn('status', [1, 2, 4])
            ->selectRaw('COUNT(*) as totalBooking, SUM(total_price) as totalBookingPrice')
            ->first();

        $data['totalBooking'] = $data->totalBooking;
        $data['totalBookingPrice'] = $data->totalBookingPrice ?? 0;

        $data['favouriteList'] = FavouriteList::with('package:id,thumb,thumb_driver,title,slug,adult_price')
            ->whereHas('package')
            ->where('user_id', auth()->id())
            ->when($request->filled('from_date'), function ($query) {
                $query->whereDate('created_at', '>=', request()->from_date);
            })
            ->when($request->filled('to_date'), function ($query) {
                $query->whereDate('created_at', '<=', request()->to_date);
            })
            ->when($request->filled('title'), function ($query) {
                $query->whereHas('package', function ($q) {
                    $q->where('title', 'like', '%' . request()->title . '%');
                });
            })
            ->where('reaction', 1)
            ->latest()
            ->paginate(basicControl()->user_paginate);

        return view(template() . 'user.dashboard', $data);
    }


    public function profile()
    {
        try {
            $data['languages'] = Language::select('id', 'name', 'short_name')->get();
            $data['countries'] = Country::select('id', 'name')->where('status', 1)->orderBy('name', 'ASC')->get();

            return view(template() . 'user.profile.my_profile', $data);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

    }

    public function notificationSettings()
    {
        $data['languages'] = Language::all();
        return view(template() . 'user.profile.partials.notification_settings', $data);
    }

    public function changePassword()
    {
        return view(template() . 'user.profile.partials.password');
    }

    public function kycSettings()
    {
        $data['languages'] = Language::all();
        $data['countries'] = Country::where('status', 1)->get();
        $data['kyc'] = Kyc::where('status', 1)->get();

        return view(template() . 'user.profile.partials.kyc_settings', $data);
    }

    public function profileUpdateImage(Request $request)
    {
        $allowedExtensions = array('jpg', 'png', 'jpeg');
        $image = $request->image;
        $this->validate($request, [
            'image' => [
                'required',
                'max:4096',
                function ($fail) use ($image, $allowedExtensions) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (($image->getSize() / 1000000) > 4) {
                        throw ValidationException::withMessages(['image' => "Images MAX  4MB ALLOW!"]);
                    }
                    if (!in_array($ext, $allowedExtensions)) {
                        throw ValidationException::withMessages(['image' => "Only png, jpg, jpeg images are allowed"]);
                    }
                }
            ]
        ]);
        $user = Auth::user();
        if ($request->hasFile('image')) {
            $image = $this->fileUpload($request->image, config('filelocation.userProfile.path'), null, null, 'webp', 60, $user->image, $user->image_driver);
            if ($image) {
                $profileImage = $image['path'];
                $ImageDriver = $image['driver'];
            }
        }
        $user->image = $profileImage ?? $user->image;
        $user->image_driver = $ImageDriver ?? $user->image_driver;
        $user->save();
        return back()->with('success', 'Updated Successfully.');
    }

    public function profileUpdate(Request $request)
    {
        $phoneLength = 15;
        foreach (config('country') as $country) {
            if ($country['phone_code'] == $request->code) {
                $phoneLength = $country['phoneLength'];
                break;
            }
        }

        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });
        throw_if(!$languages, 'Language not found.');

        $req = $request->except('_method', '_token');
        $user = Auth::user();
        $rules = [
            'fname' => 'required|string|min:1|max:100',
            'lname' => 'required|string|min:1|max:100',
            'email' => 'required|email:rfc,dns',
            'phone' => ['required', 'string', Rule::unique('users', 'phone')->ignore($user->id), new PhoneLength($phoneLength)],
            'address' => 'required|string|min:2|max:500',
            'country' => 'required',
            'language' => Rule::in($languages),
        ];
        $message = [
            'fname.required' => 'First name field is required',
            'lname.required' => 'Last name field is required',
        ];

        $validator = Validator::make($req, $rules, $message);
        if ($validator->fails()) {
            $validator->errors()->add('profile', '1');
            return back()->withErrors($validator)->withInput();
        }
        try {

            $country = Country::select(['id', 'name'])->where('id', $req['country'])->firstOr(function () {
                throw new \Exception('Country not found.');
            });
            if ($request['state']) {
                $state = State::select(['id', 'name'])->where('id', $req['state'])->orWhere('name', $req['state'])->firstOr(function () {
                    throw new \Exception('State not found.');
                });
            }
            if ($request['city']) {
                $city = City::select(['id', 'name'])->where('id', $req['city'])->orWhere('name', $req['city'])->firstOr(function () {
                    throw new \Exception('City not found.');
                });
            }

            $basicControl = basicControl();

            $response = $user->update([
                'language_id' => $req['language'],
                'firstname' => $req['fname'],
                'lastname' => $req['lname'],
                'email' => $req['email'],
                'email_verification' => (auth()->user()->email != $req['email'] && $basicControl->email_verification) ? 0 : 1,
                'phone' => $req['phone'],
                'sms_verification' => (auth()->user()->phone != $req['phone'] && $basicControl->sms_verification) ? 0 : 1,
                'phone_code' => $req['code'],
                'country_code' => strtoupper($req['countryCode']),
                'address_one' => $req['address'],
                'zip_code' => $req['zipcode'],
                'country' => $country->name,
                'state' => $state->name ,
                'city' => $city->name,
                'about_me' => $req['about'],
            ]);

            throw_if(!$response, 'Something went wrong, While updating profile data');
            return back()->with('success', 'Profile updated Successfully.');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function updatePassword(Request $request)
    {

        $rules = [
            'current_password' => ['required', new CurrentPassword()],
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        try {
            $user->password = bcrypt($request->password);
            $user->save();

            return back()->with('success', 'Password Changes successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function twoStepSecurity()
    {
        $basic = basicControl();
        $user = auth()->user();

        $google2fa = new Google2FA();
        $secret = $user->two_fa_code ?? $this->generateSecretKeyForUser($user);

        // Generate QR code URL
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            auth()->user()->username,
            $basic->site_title,
            $secret
        );

        return view($this->theme . 'user.twoFA.index', compact('secret', 'qrCodeUrl'));

    }

    private function generateSecretKeyForUser(User $user)
    {
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        $user->update(['two_fa_code' => $secret]);

        return $secret;
    }

    public function twoStepEnable(Request $request)
    {
        $user = $this->user;
        $secret = auth()->user()->two_fa_code;
        if (!$request->code) {
            return back()->with('error', 'Authenticator code is required');
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret, $request->code);
        if ($valid) {
            $user['two_fa'] = 1;
            $user['two_fa_verify'] = 1;
            $user->save();

            $this->mail($user, 'TWO_STEP_ENABLED', [
                'action' => 'Enabled',
                'code' => $user->two_fa_code,
                'ip' => request()->ip(),
                'browser' => UserSystemInfo::get_browsers() . ', ' . UserSystemInfo::get_os(),
                'time' => date('d M, Y h:i:s A'),
            ]);

            return back()->with('success', 'Google Authenticator Has Been Enabled.');
        } else {

            return back()->with('error', 'Wrong Verification Code.');
        }
    }


    public function twoStepDisable(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Incorrect password. Please try again.');
        }


        $user = $this->user;
        auth()->user()->update([
            'two_fa' => 0,
            'two_fa_verify' => 1,
            //   'two_fa_code' => null, // Optionally clear the stored secret
        ]);

        return back()->with('success', 'Two-step authentication disabled successfully.');

    }

    public function fetchState(Request $request)
    {
        $data['states'] = State::where('country_id', $request->country_id)->where('status', 1)
            ->get(["name", "id"]);
        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where('state_id', $request->state_id)->where('status', 1)
            ->get(["name", "id"]);
        return response()->json($data);
    }

    public function paymentLog()
    {
        $data['logs'] = Deposit::with(['gateway:id,name,image,driver'])
            ->where('user_id', Auth::id())
            ->whereIn('status', [1, 2, 3])
            ->latest()->paginate(basicControl()->paginate);

        return view($this->theme . 'user.fund.index', $data);
    }

}
