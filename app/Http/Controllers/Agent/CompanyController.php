<?php

namespace App\Http\Controllers\Agent;

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
use Illuminate\Support\Facades\Cache;

class CompanyController extends Controller
{
    use Upload, Notify;

    public function index()
    {
        $data['basic'] = basicControl();

        $company_recored = \Cache::get('company_recored');
        if (!$company_recored) {
            $company_recored = Company::query()->whereBelongsTo(getAuthUser('agent'))->withTrashed()->selectRaw('COUNT(id) AS totalUserWithTrashed')
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
            \Cache::put('company_recored', $company_recored);
        }
        return view('agent.company_management.list', $data, compact('company_recored'));

    }

    public function search(Request $request)
    {

        $search = $request->search['value'];
        $filterStatus = $request->filterStatus;
        $filterName = $request->filterName;
        $filterEmailVerification = $request->filterEmailVerification;
        $filterSMSVerification = $request->filterSMSVerification;
        $filterTwoFaSecurity = $request->filterTwoFaVerification;

        $users = Company::query()->orderBy('id', 'DESC')
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
                $url = route('agent.company.view.profile', $item->id);
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
                $editUrl = route('agent.company.edit', $item->id);
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
                          <a class="dropdown-item" href="' . route('agent.company.send.email', $item->id) . '"> <i
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
            session()->flash('error', 'You do not select User.');
            return response()->json(['error' => 1]);
        } else {
            Company::whereIn('id', $request->strIds)->get()->map(function ($user) {
                // UserAllRecordDeleteJob::dispatch($user);
                $user->forceDelete();
            });
            session()->flash('success', 'User has been deleted successfully');
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
        $data['email_update_route'] = route('agent.company.email.update', $id);
        $data['username_update_route'] = route('agent.company.username.update', $id);
        $data['password_update_route'] = route('agent.company.password.update', $id);

        $data['user'] = Company::findOrFail($id);
        return view('agent.company_management.edit_user', $data);
    }

    public function userUpdate(Request $request, $id)
    {

        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });
        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'phone' => 'required|unique:companies,phone,' . $id,
            'status' => 'nullable|integer|in:0,1',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
            // 'language_id' => Rule::in($languages),
        ]);


        $user = Company::where('id', $id)->firstOr(function () {
            throw new \Exception('User not found!');
        });
        if ($request->hasFile('image')) {
            try {
                $image = $this->fileUpload($request->image, config('filelocation.companyImage.path'), null, null, 'webp', 60, $user->image, $user->image_driver);
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
            $user = Company::where('id', $id)->firstOr(function () {
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
            'new_email' => 'required|email:rfc,dns|unique:companies,email,' . $id
        ]);

        try {
            $user = Company::where('id', $id)->firstOr(function () {
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
            'username' => 'required|unique:companies,username,' . $id
        ]);

        try {
            $user = Company::where('id', $id)->firstOr(function () {
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

    public function updateBalanceUpdate(Request $request, $id)
    {


        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        try {

            $user = Company::where('id', $id)->firstOr(function () {
                throw new \Exception('User not found!');
            });

            if ($request->balance_operation == 1) {

                $user->balance += $request->amount;
                $user->save();

                $fund = new Fund();
                $fund->user_id = $user->id;
                $fund->percentage_charge = 0;
                $fund->fixed_charge = 0;
                $fund->charge = 0;
                $fund->amount = getAmount($request->amount);
                $fund->status = 1;
                $fund->save();

                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = getAmount($request->amount);
                $transaction->balance = getAmount($user->balance);
                $transaction->charge = 0;
                $transaction->trx_type = '+';
                $transaction->remarks = 'Add Balance';
                $transaction->trx_id = $fund->transaction;
                $fund->transactional()->save($transaction);

                $msg = [
                    'amount' => currencyPosition($fund->amount),
                    'main_balance' => currencyPosition($user->balance),
                    'transaction' => $transaction->trx_id
                ];

                $action = [
                    "link" => '#',
                    "icon" => "fa fa-money-bill-alt text-white"
                ];
                $firebaseAction = '#';
                $this->userFirebasePushNotification($user, 'ADD_BALANCE', $msg, $firebaseAction);
                $this->userPushNotification($user, 'ADD_BALANCE', $msg, $action);
                $this->sendMailSms($user, 'ADD_BALANCE', $msg);

                return redirect()->route('admin.user.transaction', $user->id)->with('success', 'Balance Updated Successfully.');

            } else {

                if ($request->amount > $user->balance) {
                    return back()->with('error', 'Insufficient Balance to deducted.');
                }
                $user->balance -= $request->amount;
                $user->save();

                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = getAmount($request->amount);
                $transaction->balance = $user->balance;
                $transaction->charge = 0;
                $transaction->trx_type = '-';
                $transaction->remarks = 'Deduction Balance';
                $transaction->save();

                $msg = [
                    'amount' => currencyPosition($request->amount),
                    'main_balance' => currencyPosition($user->balance),
                    'transaction' => $transaction->trx_id
                ];
                $action = [
                    "link" => route('user.transaction'),
                    "icon" => "fa fa-money-bill-alt text-white"
                ];
                $firebaseAction = route('user.transaction');
                $this->userFirebasePushNotification($user, 'DEDUCTED_BALANCE', $msg, $firebaseAction);
                $this->userPushNotification($user, 'DEDUCTED_BALANCE', $msg, $action);
                $this->sendMailSms($user, 'DEDUCTED_BALANCE', $msg);

                return redirect()->route('admin.user.transaction', $user->id)->with('success', 'Balance Updated Successfully.');

            }

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }

    }


    public function preferencesUpdate(Request $request, $id)
    {
        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });

        $request->validate([
            'language_id' => Rule::in($languages),
            'time_zone' => 'required|string|min:1|max:100',
            'email_verification' => 'nullable|integer|in:0,1',
            'sms_verification' => 'nullable|integer|in:0,1',
        ]);

        try {
            $user = Company::where('id', $id)->firstOr(function () {
                throw new \Exception('User not found!');
            });

            $user->update([
                'language_id' => $request->language_id,
                'time_zone' => $request->time_zone,
                'email_verification' => $request->email_verification,
                'sms_verification' => $request->sms_verification,
            ]);

            return back()->with('success', 'Preferences Updated Successfully.');

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }


    }

    public function userTwoFaUpdate(Request $request, $id)
    {
        try {
            $user = Company::where('id', $id)->firstOr(function () {
                throw new \Exception('User not found!');
            });
            $user->update([
                'two_fa_verify' => ($request->two_fa_security == 1) ? 0 : 1
            ]);

            return back()->with('success', 'Two Fa Security Updated Successfully.');

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }
    }

    public function userDelete(Request $request, $id)
    {
        try {
            $user = Company::where('id', $id)->firstOr(function () {
                throw new \Exception('User not found!');
            });

            UserAllRecordDeleteJob::dispatch($user);
            $user->forceDelete();
            return redirect()->route('admin.users')->with('success', 'User Account Deleted Successfully.');

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }
    }

    public function agentAdd()
    {
        $data['allCountry'] = config('country');
        return view('agent.company_management.add_user', $data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'username' => 'required|string|unique:companies,username|min:2|max:255',
            'email' => 'required|email:rfc,dns|unique:companies,email|min:2|max:255',
            'phone' => 'required|string|unique:companies,phone|min:2|max:20',
            'status' => 'nullable|integer|in:0,1',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            try {
                $image = $this->fileUpload($request->image, config('filelocation.companyImage.path'), null, null, 'webp', 60);
                if ($image) {
                    $profileImage = $image['path'];
                    $driver = $image['driver'];
                }
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        try {
            $response = Company::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'image' => $profileImage ?? null,
                'image_driver' => $driver ?? 'local',
                'status' => $request->status,
                'agent_id' => getAuthUser('agent')->id
            ]);

            if (!$response) {
                throw new Exception('Something went wrong, Please try again.');
            }
            Cache::forget('company_recored');
            return $this->userCreateSuccessMessage($response->id);

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }
    }

    public function userCreateSuccessMessage($id)
    {
        $data['user'] = Company::findOrFail($id);
        session()->flash('success', 'Company created successfully');
        return view('agent.company_management.components.user_add_success_message', $data);
    }

    public function userViewProfile($id)
    {
        $data['user'] = Company::findOrFail($id);
        $data['basic'] = basicControl();
        return view('agent.company_management.user_view_profile', $data);
    }




    public function payment($id)
    {
        $data['user'] = Company::findOrFail($id);
        $data['methods'] = Gateway::where('status', 1)->orderBy('sort_by', 'asc')->get();

        return view('agent.company_management.payment_log', $data);
    }
    public function booking($id)
    {
        $data['user'] = Company::with('booking')->findOrFail($id);
        return view('agent.company_management.booking_log', $data);
    }



    public function blockProfile(Request $request, $id)
    {
        try {

            $user = Company::where('id', $id)->firstOr(function () {
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
        return view('agent.company_management.mail_all_user');
    }

    public function sendEmail($id)
    {
        try {
            $user = Company::where('id', $id)->firstOr(function () {
                throw new \Exception('No User found.');
            });
            return view('agent.company_management.send_mail_form', compact('user'));
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

            $user = Company::query()->find($id);

            $subject = $request->subject;
            $template = $request->description;

            if (isset($user)) {
                Mail::to($user)->send(new SendMail(basicControl()->sender_email, $subject, $template));
            } else {
                $users = Company::all();
                foreach ($users as $user) {
                    Mail::to($user)->queue(new SendMail(basicControl()->sender_email, $subject, $template));
                }
            }

            return back()->with('success', 'Email Sent Successfully');

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


}
