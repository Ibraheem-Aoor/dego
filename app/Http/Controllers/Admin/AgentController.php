<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UserAllRecordDeleteJob;
use App\Models\Booking;
use App\Models\Country;
use App\Models\Deposit;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserKyc;
use App\Models\UserLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\Traits\Upload;
use App\Traits\Notify;
use Exception;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Agent;
use App\Models\Company;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class AgentController extends Controller
{
    use Upload, Notify;

    public function index()
    {
        $data['basic'] = basicControl();

        $agent_record = \Cache::get('agent_record');
        if (!$agent_record) {
            $agent_record = Agent::withTrashed()->selectRaw('COUNT(id) AS totalUserWithTrashed')
                ->selectRaw('COUNT(CASE WHEN deleted_at IS NULL THEN id END) AS totalUser')
                ->selectRaw('(COUNT(CASE WHEN deleted_at IS NULL THEN id END) / COUNT(id)) * 100 AS totalUserPercentage')
                ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS activeUser')
                ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS activeUserPercentage')
                ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS todayJoin')
                ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) / COUNT(id)) * 100 AS todayJoinPercentage')
                ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS deactivateUser')
                ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS deactivateUserPercentage')
                ->get()
                ->toArray();
            \Cache::put('agent_record', $agent_record);
        }
        $data['languages'] = Language::all();
        $data['allCountry'] = Country::where('status', 1)->get();
        return view('admin.agent_management.list', $data, compact('agent_record'));

    }

    public function search(Request $request)
    {

        $search = $request->search['value'];
        $filterStatus = $request->filterStatus;
        $filterName = $request->filterName;
        $filterEmailVerification = $request->filterEmailVerification;
        $filterSMSVerification = $request->filterSMSVerification;
        $filterTwoFaSecurity = $request->filterTwoFaVerification;

        $users = Agent::query()->orderBy('id', 'DESC')
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('email', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            })
            ->when(isset($filterName) && !empty($filterName), function ($query) use ($filterName) {
                return $query->where('username', 'LIKE', "%{$filterName}%")
                    ->orWhere('name', 'LIKE', "%{$filterName}%");
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus == 'all') {
                    return $query->where('status', '!=', null);
                }
                return $query->where('status', $filterStatus);
            })
            ->when(isset($filterEmailVerification) && !empty($filterEmailVerification), function ($query) use ($filterEmailVerification) {
                return $query->where('email_verification', $filterEmailVerification);
            })
            ->when(isset($filterSMSVerification) && !empty($filterSMSVerification), function ($query) use ($filterSMSVerification) {
                return $query->where('sms_verification', $filterSMSVerification);
            })
            ->when(isset($filterTwoFaSecurity) && !empty($filterTwoFaSecurity), function ($query) use ($filterTwoFaSecurity) {
                return $query->where('two_fa_verify', $filterTwoFaSecurity);
            });

        return DataTables::of($users)
            ->addColumn('checkbox', function ($item) {
                return ' <input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';
            })
            ->addColumn('name', function ($item) {
                $url = route('admin.agents.view.profile', $item->id);
                return '<a class="d-flex align-items-center me-2" href="' . $url . '">
                                <div class="flex-shrink-0">
                                  ' . $item->profilePicture() . '
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . $item->name . '</h5>
                                  <span class="fs-6 text-body">@' . $item->username . '</span>
                                </div>
                              </a>';

            })
            ->addColumn('email-phone', function ($item) {
                return '<span class="d-block h5 mb-0">' . $item->email . '</span>
                            <span class="d-block fs-5">' . $item->phone . '</span>';
            })
            ->addColumn('country', function ($item) {
                return $item->country ?? 'N/A';
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 1) {
                    return '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Active') . '
                  </span>';

                } else {
                    return '<span class="badge bg-soft-danger text-danger">
                    <span class="legend-indicator bg-danger"></span>' . trans('Inactive') . '
                  </span>';
                }
            })
            ->addColumn('last login', function ($item) {
                return diffForHumans($item->last_login);
            })
            ->addColumn('action', function ($item) {
                $editUrl = route('admin.agents.edit', $item->id);
                $viewProfile = route('admin.agents.view.profile', $item->id);
                return '<div class="btn-group" role="group">
                      <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-pencil-fill me-1"></i> ' . trans("Edit") . '
                      </a>
                    <div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                       <a class="dropdown-item" href="' . $viewProfile . '">
                          <i class="bi-eye-fill dropdown-item-icon"></i> ' . trans("View Profile") . '
                        </a>
                          <a class="dropdown-item" href="' . route('admin.agents.send.email', $item->id) . '"> <i
                                class="bi-envelope dropdown-item-icon"></i> ' . trans("Send Mail") . ' </a>
                          <a class="dropdown-item loginAccount d-none" href="javascript:void(0)"
                           data-route="' . route('admin.login.as.user', $item->id) . '"
                           data-bs-toggle="modal" data-bs-target="#loginAsUserModal">
                            <i class="bi bi-box-arrow-in-right dropdown-item-icon"></i>
                           ' . trans("Login As User") . '
                        </a>
                      </div>
                    </div>
                  </div>';
            })->rawColumns(['action', 'checkbox', 'name', 'email-phone', 'status'])
            ->make(true);
    }


    /**
     * Delete multiple user accounts
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Agent.');
            return response()->json(['error' => 1]);
        } else {
            Agent::whereIn('id', $request->strIds)->get()->map(function ($user) {
                if(!$user->companies->isEmpty() && !($user->companies()->whereHas('bookings')->orWhereHas('carBookings')->exists())){
                    $user->delete();
                }
            });
            Cache::forget('agent_record');
            session()->flash('success', 'Agent has been deleted successfully');
            return response()->json(['success' => 1]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userEdit($id)
    {
        $data['languages'] = Language::all();
        $data['basicControl'] = basicControl();
        // $data['userLoginInfo'] = UserLogin::where('user_id', $id)->orderBy('id', 'desc')->limit(5)->get();
        $data['email_update_route'] = route('admin.agents.email.update', $id);
        $data['username_update_route'] = route('admin.agents.username.update', $id);
        $data['password_update_route'] = route('admin.agents.password.update', $id);
        $data['allCountry'] = config('country');

        $data['user'] = Agent::findOrFail($id);
        return view('admin.agent_management.edit_user', $data);
    }

    public function userUpdate(Request $request, $id)
    {

        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });
        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'phone' => 'required|unique:agents,phone,' . $id,
            'status' => 'nullable|integer|in:0,1',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
            'country' => 'required|string|min:2|max:100',
            // 'language_id' => Rule::in($languages),
        ]);


        $user = Agent::where('id', $id)->firstOr(function () {
            throw new \Exception('User not found!');
        });
        if ($request->hasFile('image')) {
            try {
                $image = $this->fileUpload($request->image, config('filelocation.profileImage.path'), null, null, 'webp', 60, $user->image, $user->image_driver);
                if ($image) {
                    $profileImage = $image['path'];
                    $driver = $image['driver'];
                }
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        try {
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'country' => $request->country,

                'image' => $profileImage ?? $user->image,
                'image_driver' => $driver ?? $user->image_driver,
                'status' => $request->status
            ]);

            return back()->with('success', 'Basic Information Updated Successfully.');
        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }
    }


    public function passwordUpdate(Request $request, $id)
    {
        $request->validate([
            'newPassword' => 'required|min:5|same:confirmNewPassword',
        ]);
        try {
            $user = Agent::where('id', $id)->firstOr(function () {
                throw new \Exception('User not found!');
            });

            $user->update([
                'password' => bcrypt($request->newPassword)
            ]);

            return back()->with('success', 'Password Updated Successfully.');

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }
    }

    public function EmailUpdate(Request $request, $id)
    {
        $request->validate([
            'new_email' => 'required|email:rfc,dns|unique:agents,email,' . $id
        ]);

        try {
            $user = Agent::where('id', $id)->firstOr(function () {
                throw new \Exception('User not found!');
            });

            $user->update([
                'email' => $request->new_email,
            ]);

            return back()->with('success', 'Email Updated Successfully.');

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function usernameUpdate(Request $request, $id)
    {


        $request->validate([
            'username' => 'required|unique:agents,username,' . $id
        ]);

        try {
            $user = Agent::where('id', $id)->firstOr(function () {
                throw new \Exception('User not found!');
            });

            $user->update([
                'username' => $request->username,
            ]);

            return back()->with('success', 'Username Updated Successfully.');

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }

    }




    public function userDelete(Request $request, $id)
    {
        try {
            $user = Agent::where('id', $id)->firstOr(function () {
                throw new \Exception('User not found!');
            });
            if(!$user->companies->isEmpty() && !($user->companies()->whereHas('bookings')->orWhereHas('carBookings')->exists())){
                $user->delete();
            }
            Cache::forget('agent_record');
            return redirect()->route('admin.agentss')->with('success', 'User Account Deleted Successfully.');

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }
    }

    public function agentAdd()
    {
        $data['allCountry'] = config('country');
        return view('admin.agent_management.add_user', $data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'username' => 'required|string|unique:agents,username|min:2|max:255',
            'email' => 'required|email:rfc,dns|unique:agents,email|min:2|max:255',
            'phone' => 'required|string|unique:agents,phone|min:2|max:20',
            'status' => 'nullable|integer|in:0,1',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            try {
                $image = $this->fileUpload($request->image, config('filelocation.profileImage.path'), null, null, 'webp', 60);
                if ($image) {
                    $profileImage = $image['path'];
                    $driver = $image['driver'];
                }
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        try {
            $response = Agent::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'image' => $profileImage ?? null,
                'image_driver' => $driver ?? 'local',
                'status' => $request->status
            ]);

            if (!$response) {
                throw new Exception('Something went wrong, Please try again.');
            }
            Cache::forget('agent_record');
            return $this->userCreateSuccessMessage($response->id);

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }
    }

    public function userCreateSuccessMessage($id)
    {
        $data['user'] = Agent::findOrFail($id);
        session()->flash('success', 'Agent created successfully');
        return view('admin.agent_management.components.user_add_success_message', $data);
    }

    public function userViewProfile($id)
    {
        $data['user'] = Agent::findOrFail($id);
        $data['basic'] = basicControl();


        return view('admin.agent_management.user_view_profile', $data);
    }

    public function companies($id)
    {
        $data['user'] = Agent::findOrFail($id);
        return view('admin.agent_management.companies', $data);
    }


    public function companiesSearch(Request $request, Agent $agent)
    {
        try{

            $search = $request->search['value'];

            $companies = Company::query()
            ->whereBelongsTo($agent)
            ->when(isset($search), function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            });
            return DataTables::of($companies)
            ->addColumn('no', function ($item) {
                static $counter = 1;
                $counter++;
                return $counter;
            })
            ->addColumn('name', function ($item) {
                return $item->name;
            })
            ->addColumn('packages', function ($item) {
                return $item->packages()?->count() ?? 'N/A';
            })
            ->addColumn('country', function ($item) {
                return $item->country ?? 'N/A';
            })
            ->addColumn('date-time' , function ($item) {
                return $item->created_at->format('d M, Y h:i A');
            })->rawColumns(['no', 'name', 'packages', 'country', 'date-time'])
            ->make(true);
        }catch(Exception $exp){
            dd($exp);
        }

    }



    public function blockProfile(Request $request, $id)
    {
        try {
            $user = Agent::where('id', $id)->firstOr(function () {
                throw new \Exception('No User found.');
            });

            $user->update([
                'status' => 0
            ]);

            return back()->with('success', 'Block Profile Successfully');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function mailAllUser()
    {
        return view('admin.agent_management.mail_all_user');
    }

    public function sendEmail($id)
    {
        try {
            $user = Agent::where('id', $id)->firstOr(function () {
                throw new \Exception('No User found.');
            });
            return view('admin.agent_management.send_mail_form', compact('user'));
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function sendMailUser(Request $request, $id = null)
    {
        $request->validate([
            'subject' => 'required|min:5',
            'description' => 'required|min:10',
        ]);

        try {

            $user = Agent::query()->findOrFail($id);

            $subject = $request->subject;
            $template = $request->description;

            if (isset($user)) {
                Mail::to($user)->send(new SendMail(basicControl()->sender_email, $subject, $template));
            } else {
                $users = Agent::all();
                foreach ($users as $user) {
                    Mail::to($user)->queue(new SendMail(basicControl()->sender_email, $subject, $template));
                }
            }

            return back()->with('success', 'Email Sent Successfully');

        } catch (\Exception $exception) {
            dd($exception);
            return back()->with('error', $exception->getMessage());
        }
    }


}
