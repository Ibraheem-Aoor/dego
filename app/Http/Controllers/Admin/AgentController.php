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
                $url = route('admin.user.view.profile', $item->id);
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
            session()->flash('error', 'You do not select User.');
            return response()->json(['error' => 1]);
        } else {
            Agent::whereIn('id', $request->strIds)->get()->map(function ($user) {
                UserAllRecordDeleteJob::dispatch($user);
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
        // $data['userLoginInfo'] = UserLogin::where('user_id', $id)->orderBy('id', 'desc')->limit(5)->get();
        $data['email_update_route'] = route('admin.agents.email.update', $id);
        $data['username_update_route'] = route('admin.agents.username.update', $id);
        $data['password_update_route'] = route('admin.agents.password.update', $id);

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

    public function updateBalanceUpdate(Request $request, $id)
    {


        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        try {

            $user = Agent::where('id', $id)->firstOr(function () {
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
            $user = Agent::where('id', $id)->firstOr(function () {
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
            $user = Agent::where('id', $id)->firstOr(function () {
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
            $user = Agent::where('id', $id)->firstOr(function () {
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
            return redirect()->route('admin.user.create.success.message', $response->id)->with('success', 'User created successfully');

        } catch (\Exception $exp) {
            return back()->with('error', $exp->getMessage());
        }
    }

    public function userCreateSuccessMessage($id)
    {
        $data['user'] = Agent::findOrFail($id);
        return view('admin.agent_management.components.user_add_success_message', $data);
    }

    public function userViewProfile($id)
    {
        $data['user'] = Agent::findOrFail($id);
        $data['basic'] = basicControl();


        return view('admin.agent_management.user_view_profile', $data);
    }

    public function transaction($id)
    {
        $user = Agent::findOrFail($id);
        return view('admin.agent_management.transactions', compact('user'));
    }

    public function userTransactionSearch(Request $request, $id)
    {

        $search = $request->search['value'];

        $filterTransactionId = $request->filterTransactionID;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $transaction = Transaction::with('user')
            ->where('user_id', $id)
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('trx_id', 'LIKE', "%{$search}%")
                        ->orWhere('remarks', 'LIKE', "%{$search}%");
                });
            })
            ->when(!empty($request->filterDate) && $endDate == null, function ($query) use ($startDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $query->whereDate('created_at', $startDate);
            })
            ->when(!empty($request->filterDate) && $endDate != null, function ($query) use ($startDate, $endDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $endDate = Carbon::createFromFormat('d/m/Y', trim($endDate));
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when(!empty($filterTransactionId), function ($query) use ($filterTransactionId) {
                return $query->where('trx_id', $filterTransactionId);
            })
            ->orderBy('id', 'DESC')
            ->get();


        return DataTables::of($transaction)
            ->addColumn('no', function () {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('trx', function ($item) {
                return $item->trx_id;
            })
            ->addColumn('amount', function ($item) {
                $statusClass = $item->trx_type == '+' ? 'text-success' : 'text-danger';
                return "<h6 class='mb-0 $statusClass '>" . $item->trx_type . ' ' . currencyPosition($item->amount) . "</h6>";

            })
            ->addColumn('charge', function ($item) {
                return currencyPosition($item->charge);

            })
            ->addColumn('remarks', function ($item) {
                return $item->remarks;
            })
            ->addColumn('date-time', function ($item) {
                return dateTime($item->created_at, 'd M Y h:i A');
            })
            ->rawColumns(['amount', 'charge'])
            ->make(true);
    }


    public function payment($id)
    {
        $data['user'] = Agent::findOrFail($id);
        $data['methods'] = Gateway::where('status', 1)->orderBy('sort_by', 'asc')->get();

        return view('admin.agent_management.payment_log', $data);
    }
    public function booking($id)
    {
        $data['user'] = Agent::with('booking')->findOrFail($id);
        return view('admin.agent_management.booking_log', $data);
    }
    public function userBookingSearch(Request $request, $id)
    {
        $search = $request->search['value'];
        $filterStatus = $request->filterStatus;
        $filterStart = $request->filterStartDate;
        $filterEnd = $request->filterEndDate;
        $filterName = $request->filterName;
        $filterPackageName = $request->filterPackageName;
        $filterBookingId = $request->filterBookingId;


        $Bookings = Booking::query()->with(['user', 'depositable.gateway:id,name,image,driver'])
            ->orderBy('id', 'DESC')
            ->whereIn('status', [1, 2, 4])
            ->where('user_id', $id)
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('package_title', 'LIKE', "%{$search}%")
                        ->orWhere('total_price', 'LIKE', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('firstname', 'LIKE', "%{$search}%")
                                ->orWhere('lastname', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->when(!empty($filterPackageName), function ($query) use ($filterPackageName) {
                $query->where('package_title', 'LIKE', "%{$filterPackageName}%");
            })
            ->when(!empty($filterBookingId), function ($query) use ($filterBookingId) {
                $query->where('trx_id', 'LIKE', "%{$filterBookingId}%");
            })
            ->when(!empty($filterName), function ($query) use ($filterName) {
                $query->whereHas('user', function ($q) use ($filterName) {
                    $q->where('firstname', 'LIKE', "%{$filterName}%")
                        ->orWhere('lastname', 'LIKE', "%{$filterName}%");
                });
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus == 'all') {
                    return $query->where('status', '!=', null);
                }
                if ($filterStatus == '5') {
                    return $query->where('date', '<', now());
                }
                return $query->where('status', $filterStatus)->where('date', '>', now());
            })
            ->when(isset($filterStart) && !empty($filterStart), function ($query) use ($filterStart) {
                return $query->whereDate('created_at', '>=', $filterStart);
            })
            ->when(isset($filterEnd) && !empty($filterEnd), function ($query) use ($filterEnd) {
                return $query->whereDate('created_at', '<=', $filterEnd);
            });

        return DataTables::of($Bookings)
            ->addColumn('checkbox', function ($item) {
                return ' <input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';
            })
            ->addColumn('booking-id', function ($item) {
                return $item->trx_id;
            })
            ->addColumn('date', function ($item) {
                return dateTime($item->date) ?? 'N/A';
            })
            ->addColumn('duration', function ($item) {
                return $item->duration . ' Days';
            })
            ->addColumn('price', function ($item) {
                return currencyPosition($item->total_price) ?? 'N/A';

            })
            ->addColumn('package', function ($item) {
                $image = optional($item->package)->thumb;
                if (!$image) {
                    $firstLetter = substr($item->package_title, 0, 1);
                    return '<div class="avatar avatar-sm avatar-soft-primary avatar-circle d-flex justify-content-start gap-2 w-100">
                                <span class="avatar-initials">' . $firstLetter . '</span>
                                <p class="avatar-initials ms-3">' . $item->title . '</p>
                            </div>';

                } else {
                    $url = getFile(optional($item->package)->thumb_driver, optional($item->package)->thumb);

                    return '<a class="d-flex align-items-center me-2" href="javascript:void(0)">
                                <div class="flex-shrink-0">
                                  <div class="avatar avatar-sm avatar-circle">
                                        <img class="avatar-img" src="' . $url . '" alt="Image Description">
                                  </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . Str::limit($item->package_title, 30) . '</h5>
                                </div>
                              </a>';

                }
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 4) {
                    return '<span class="badge bg-soft-secondary text-secondary">
                    <span class="legend-indicator bg-secondary"></span>' . trans('Refunded') . '
                  </span>';
                } elseif ($item->status == 2) {
                    return '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Completed') . '
                  </span>';
                } elseif ($item->status == 1 && strtotime($item->date) > strtotime(date('Y-m-d'))) {
                    return '<span class="badge bg-soft-warning text-warning">
                    <span class="legend-indicator bg-warning"></span>' . trans('Pending') . '
                  </span>';
                } elseif ($item->status == 0) {
                    return '<span class="badge bg-soft-warning text-warning">
                    <span class="legend-indicator bg-warning"></span>' . trans('Payment Pending') . '
                  </span>';
                } elseif (strtotime($item->date) < strtotime(date('Y-m-d'))) {
                    return '<span class="badge bg-soft-danger text-danger">
                        <span class="legend-indicator bg-danger"></span>' . trans('Expired') . '
                    </span>';
                }
            })
            ->addColumn('create-at', function ($item) {
                return dateTime($item->created_at);
            })
            ->addColumn('action', function ($item) {
                $editUrl = route('admin.booking.edit', $item->id);
                $refundUrl = route('admin.booking.refund', $item->id);
                $actionUrl = route('admin.booking.action', $item->id);

                $dropdownMenu = '';
                if ($item->status == 1 && $item->date > now()) {
                    $dropdownMenu = '
                    <div class="btn-group">
                        <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                            <a class="dropdown-item refundBtn" href="javascript:void(0)"
                                data-route="' . $refundUrl . '"
                                data-bs-toggle="modal" data-bs-target="#refundModal">
                                <i class="bi bi-arrow-up-circle"></i>
                                ' . trans("Refund") . '
                            </a>';

                    $username = $item->firstname . ' ' . $item->lastname;
                    $dropdownMenu .= '
                        <a class="dropdown-item actionBtn" href="javascript:void(0)"
                            data-route="' . $actionUrl . '"
                            data-bs-toggle="modal"
                            data-bs-target="#Confirm"
                            data-amount="' . currencyPosition($item->total_price) . '"
                            data-id="' . $item->id . '"
                            data-user="' . $username . '"
                            data-trx_id = " ' . $item->trx_id . ' "
                            data-paid_date = " ' . dateTime($item->created_at) . ' "

                            >
                            <i class="bi bi-check-square"></i>
                            ' . trans("Confirm") . '
                        </a>';
                    $dropdownMenu .= '</div>
                        </div>';
                }

                return '
                <div class="btn-group" role="group">
                    <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-eye me-1"></i> ' . trans("View") . '
                    </a>
                    ' . $dropdownMenu . '
                </div>';
            })
            ->rawColumns(['action', 'checkbox', 'create-at', 'booking-id', 'package', 'status', 'duration', 'date', 'price'])
            ->make(true);
    }
    public function userPaymentSearch(Request $request, $id)
    {
        $filterTransactionId = $request->filterTransactionID;
        $filterStatus = $request->filterStatus;
        $filterMethod = $request->filterMethod;
        $basicControl = basicControl();
        $search = $request->search['value'];

        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $funds = Deposit::with('user', 'gateway')
            ->where('user_id', $id)
            ->where('status', '!=', 0)
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(function ($subquery) use ($search) {
                    $subquery->where('transaction', 'LIKE', "%$search%")
                        ->orWhereHas('gateway', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%$search%");
                        });
                });
            })
            ->when(!empty($filterTransactionId), function ($query) use ($filterTransactionId) {
                return $query->where('trx_id', $filterTransactionId);
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus == "all") {
                    return $query->where('status', '!=', null);
                }
                return $query->where('status', $filterStatus);
            })
            ->when(isset($filterMethod), function ($query) use ($filterMethod) {
                return $query->whereHas('gateway', function ($subQuery) use ($filterMethod) {
                    if ($filterMethod == "all") {
                        $subQuery->where('id', '!=', null);
                    } else {
                        $subQuery->where('id', $filterMethod);
                    }
                });
            })
            ->when(!empty($request->filterDate) && $endDate == null, function ($query) use ($startDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $query->whereDate('created_at', $startDate);
            })
            ->when(!empty($request->filterDate) && $endDate != null, function ($query) use ($startDate, $endDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $endDate = Carbon::createFromFormat('d/m/Y', trim($endDate));
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->latest()
            ->get();


        return DataTables::of($funds)
            ->addColumn('no', function ($item) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('trx', function ($item) {
                return $item->trx_id;
            })
            ->addColumn('method', function ($item) {
                return '<a class="d-flex align-items-center me-2" href="javascript:void(0)">
                                <div class="flex-shrink-0">
                                  ' . $item->picture() . '
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . optional($item->gateway)->name . '</h5>
                                </div>
                              </a>';
            })
            ->addColumn('amount', function ($item) {
                $statusClass = $item->getStatusClass();
                return "<h6 class='mb-0 $statusClass '>" . fractionNumber(getAmount($item->amount)) . ' ' . $item->payment_method_currency . "</h6>";
            })
            ->addColumn('charge', function ($item) {
                return "<span class='text-danger'>" . fractionNumber(getAmount($item->percentage_charge) + getAmount($item->fixed_charge)) . ' ' . $item->payment_method_currency . "</span>";
            })
            ->addColumn('payable', function ($item) {
                return "<h6>" . currencyPosition($item->payable_amount_in_base_currency) . "</h6>";
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 0) {
                    return '<span class="badge bg-soft-warning text-warning">' . trans('Pending') . '</span>';
                } else if ($item->status == 1) {
                    return '<span class="badge bg-soft-success text-success">' . trans('Successful') . '</span>';
                } else if ($item->status == 2) {
                    return '<span class="badge bg-soft-warning text-warning">' . trans('Pending') . '</span>';
                } else if ($item->status == 3) {
                    return '<span class="badge bg-soft-danger text-danger">' . trans('Cancel') . '</span>';
                }
            })
            ->addColumn('date', function ($item) {
                return dateTime($item->created_at, 'd M Y h:i A');
            })
            ->addColumn('action', function ($item) use ($basicControl) {

                $details = null;
                if ($item->information) {
                    $details = [];
                    foreach ($item->information as $k => $v) {
                        if ($v->type == "file") {
                            $details[kebab2Title($k)] = [
                                'type' => $v->type,
                                'field_name' => $v->field_name,
                                'field_value' => getFile(config('filesystems.default'), $v->field_value),
                            ];
                        } else {
                            $details[kebab2Title($k)] = [
                                'type' => $v->type,
                                'field_name' => $v->field_name,
                                'field_value' => @$v->field_value ?? $v->field_name
                            ];
                        }
                    }
                }

                if (optional($item->gateway)->id > 999) {
                    $icon = $item->status == 2 ? 'pencil' : 'eye';
                    $detailsJson = !empty($details) ? json_encode($details) : '{}';

                    return "<button type='button' class='btn btn-white btn-sm edit_btn' data-bs-target='#accountInvoiceReceiptModal'
                        data-detailsinfo='$detailsJson'
                        data-id='$item->id'
                        data-feedback='$item->note'
                        data-amount='" . currencyPosition(getAmount($item->amount)) . "'
                        data-method='" . optional($item->gateway)->name . "'
                        data-gatewayimage='" . getFile(optional($item->gateway)->driver, optional($item->gateway)->image) . "'
                        data-datepaid='" . dateTime($item->created_at) . "'
                        data-status='$item->status'
                        data-username='" . optional($item->user)->username . "'
                        data-action='" . route('admin.payment.action', $item->id) . "'
                        data-bs-toggle='modal'
                        data-bs-target='#accountInvoiceReceiptModal'>
                        <i class='bi-$icon fill me-1'></i>
                    </button>";
                } else {
                    return '-';
                }
            })
            ->rawColumns(['method', 'amount', 'charge', 'payable', 'status', 'action'])
            ->make(true);
    }
    public function userKyc($id)
    {
        try {
            $data['user'] = Agent::where('id', $id)->firstOr(function () {
                throw new Exception('No User found.');
            });
            return view('admin.agent_management.user_kyc', $data);
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function KycSearch(Request $request, $id)
    {
        $filterVerificationType = $request->filterVerificationType;
        $filterStatus = $request->filterStatus;

        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $transaction = UserKyc::with('user')
            ->where('user_id', $id)
            ->orderBy('id', 'DESC')
            ->when(!empty($filterVerificationType), function ($query) use ($filterVerificationType) {
                return $query->where('kyc_type', $filterVerificationType);
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus == "all") {
                    return $query->where('status', '!=', null);
                }
                return $query->where('status', $filterStatus);
            })
            ->when(!empty($request->filterDate) && $endDate == null, function ($query) use ($startDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $query->whereDate('created_at', $startDate);
            })
            ->when(!empty($request->filterDate) && $endDate != null, function ($query) use ($startDate, $endDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $endDate = Carbon::createFromFormat('d/m/Y', trim($endDate));
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->get();

        return DataTables::of($transaction)
            ->addColumn('no', function () {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('verification type', function ($item) {
                return $item->kyc_type;

            })
            ->addColumn('status', function ($item) {
                if ($item->status == 0) {
                    return '<span class="badge bg-soft-warning text-warning">' . trans('Pending') . '</span>';
                } else if ($item->status == 1) {
                    return '<span class="badge bg-soft-success text-success">' . trans('Verified') . '</span>';
                } else if ($item->status == 2) {
                    return '<span class="badge bg-soft-danger text-danger">' . trans('Rejected') . '</span>';
                }
            })
            ->addColumn('date', function ($item) {
                return dateTime($item->created_at);

            })
            ->addColumn('action', function ($item) {
                $url = route('admin.kyc.view', $item->id);
                return '<a href="' . $url . '" class="btn btn-white btn-sm">
                    <i class="bi-eye-fill me-1"></i>
                  </a>';
            })
            ->rawColumns(['name', 'status', 'action'])
            ->make(true);
    }


    public function loginAsUser($id)
    {
        Auth::guard('web')->loginUsingId($id);
        return redirect()->route('user.dashboard');
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
