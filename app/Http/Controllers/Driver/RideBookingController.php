<?php

namespace App\Http\Controllers\Driver;

use App\Models\Car;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\DriverRideBooking;
use App\Models\User;
use App\Traits\WithStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Str;
class RideBookingController extends BaseDriverController
{
    use Upload, WithStatus, Notify;

    protected $model;
    public function __construct()
    {
        $this->base_route_path .= 'ride.booking.';
        $this->base_view_path .= 'booking.';
        $this->model = new DriverRideBooking();

    }

    public function all_booking(Request $request, $status = null)
    {
        try {
            $query = $this->model::query()->selectRaw('
                    COUNT(CASE WHEN status IN (1, 2, 4) THEN 1 ELSE NULL END) as totalBooking,
                    SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as totalAcceptedBooking,
                    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as totalPendingBooking,
                    SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as totalRefundedBooking,
                    SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as createdToday
                ', [now()->startOfDay()])
                ->first();
            $data['totalBooking'] = $query->totalBooking;
            $data['totalAcceptedBooking'] = $query->totalAcceptedBooking;
            $data['totalPendingBooking'] = $query->totalPendingBooking;
            $data['totalRefundedBooking'] = $query->totalRefundedBooking;
            $data['totalCreatedToday'] = $query->createdToday;

            $data['totalAcceptedPercentage'] = ($data['totalBooking'] > 0) ? ($data['totalAcceptedBooking'] / $data['totalBooking']) * 100 : 0;
            $data['totalPendingPercentage'] = ($data['totalBooking'] > 0) ? ($data['totalPendingBooking'] / $data['totalBooking']) * 100 : 0;
            $data['totalRefundedBookingPercentage'] = ($data['totalBooking'] > 0 && $data['totalRefundedBooking'] > 0) ? ($data['totalRefundedBooking'] / $data['totalBooking']) * 100 : 0;
            $data['totalCreatedTodayPercentage'] = ($data['totalBooking'] > 0 && $data['totalCreatedToday'] > 0) ? ($data['totalCreatedToday'] / $data['totalBooking']) * 100 : 0;

            $data['car_id'] = $request->car;
            $data['status'] = $status ?? $request->query('status' , null);
            $data['base_route']  = $this->base_route_path;

            return view($this->base_view_path . 'all', $data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }


    public function all_booking_search(Request $request)
    {
        $search = $request->search['value'];
        $filterStatus = $request->filterStatus;
        $filterStart = $request->filterStartDate;
        $filterEnd = $request->filterEndDate;
        $filterName = $request->filterName;
        $car_id = $request->car_id;
        $status = $request->status;
        $filterPackageName = $request->filterPackageName;
        $filterBookingId = $request->filterBookingId;

        $Bookings = $this->model::query()->with(['driver', 'depositable.gateway:id,name,image,driver'])
            ->orderBy('id', 'DESC')
            // ->where('status', '!=', 0)
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('total_price', 'LIKE', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('firstname', 'LIKE', "%{$search}%")
                                ->orWhere('lastname', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->when(!empty($filterPackageName), function ($query) use ($filterPackageName) {
                $query->where('name', 'LIKE', "%{$filterPackageName}%");
            })
            ->when(!empty($filterName), function ($query) use ($filterName) {
                $query->whereHas('user', function ($q) use ($filterName) {
                    $q->where('firstname', 'LIKE', "%{$filterName}%")
                        ->orWhere('lastname', 'LIKE', "%{$filterName}%");
                });
            })
            ->when(!empty($filterBookingId), function ($query) use ($filterBookingId) {
                $query->where('trx_id', 'LIKE', "%{$filterBookingId}%");
            })
            ->when($status == 'all', function ($query) {
                return $query->whereIn('status', [1, 2, 4,0]);
            })
            ->when($status == 'pending', function ($query) {
                return $query->where('status', 1);
            })
            ->when($status == 'completed', function ($query) {
                return $query->where('status', 2);
            })
            ->when($status == 'refunded', function ($query) {
                return $query->where('status', 4);
            })
            ->when($status == 'expired', function ($query) {
                return $query->where('status', 1)->where('date' , '<' , now());
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus == 'all') {
                    return $query->where('status', '!=', null);
                }
                if ($filterStatus == '5') {
                    return $query->where($query->maxBookingDate(), '<', now());
                }
                return $query->where('status', $filterStatus)->where($query->maxBookingDate(), '>', now());
            })
            ->when(isset($filterStart) && !empty($filterStart), function ($query) use ($filterStart) {
                return $query->whereDate('date' , '>=', $filterStart);
            })
            ->when(isset($car_id) && !empty($car_id), function ($query) use ($car_id) {
                return $query->where('car_id', $car_id);
            })
            ->when(isset($filterEnd) && !empty($filterEnd), function ($query) use ($filterEnd) {
                return $query->whereDate('date' , '<=', $filterEnd);
            })->withConfirmedDeposit();

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
                return Carbon::parse($item->date)->toDateTimeString()    ?? 'N/A';
            })

            ->addColumn('price', function ($item) {
                return currencyPosition($item->total_price) ?? 'N/A';
            })
            ->addColumn('user', function ($item) {
                $url = route('admin.user.view.profile', $item->user->id);
                return '<a class="d-flex align-items-center me-2" href="' . $url . '">
                                <div class="flex-shrink-0">
                                  ' . $item->user->profilePicture() . '
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . $item->user->firstname . ' ' . $item->user->lastname . '</h5>
                                  <span class="fs-6 text-body">@' . $item->user->username . '</span>
                                </div>
                              </a>';

            })
            ->addColumn('status', function ($item) {
                if ($item->status == 4) {
                    return '<span class="badge bg-soft-secondary text-secondary">
                    <span class="legend-indicator bg-secondary"></span>' . trans(key: 'Refunded') . '
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
                } elseif ($item->date < now()->toDateTimeString()) {
                    return '<span class="badge bg-soft-danger text-danger">
                        <span class="legend-indicator bg-danger"></span>' . trans('Expired') . '
                    </span>';
                }
            })
            ->addColumn('create-at', function ($item) {
                return dateTime($item->created_at);
            })
            ->addColumn('action', function ($item) {
                $editUrl = route($this->base_route_path . 'edit', $item->id);
                $refundUrl = route($this->base_route_path . 'refund', $item->id);
                $actionUrl = route($this->base_route_path . 'action', $item->id);

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

                    $dropdownMenu .= '
                        <a class="dropdown-item actionBtn" href="javascript:void(0)"
                            data-action="' . $actionUrl . '"
                            data-bs-toggle="modal"
                            data-bs-target="#Confirm"
                            data-amount="' . currencyPosition($item->total_price) . '"
                            data-id="' . $item->id . '"
                            data-trx_id = " ' . $item->trx_id . ' "
                            data-paid_date = " ' . dateTime($item->created_at) . ' "
                            >
                            <i class="bi bi-check-square"></i>
                            ' . trans("Completed") . '
                        </a>';
                }

                $dropdownMenu .= '</div>
                    </div>';

                return '
                <div class="btn-group" role="group">
                    <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-eye me-1"></i> ' . trans("View") . '
                    </a>
                    ' . $dropdownMenu . '
                </div>';
            })
            ->rawColumns(['action', 'checkbox', 'create-at', 'user', 'booking-id', 'car', 'status', 'date', 'price'])
            ->make(true);
    }

    public function bookingEdit($id)
    {
        try {
            $data['booking'] = $this->model::with([
                'user' => function ($query) {
                    $query->select('id', 'image', 'image_driver', 'firstname', 'lastname', 'username', 'email', 'phone', 'phone_code')
                        ->withCount('booking');
                },
                'depositable' => function ($query) {
                    $query->select('id', 'depositable_id', 'depositable_type', 'base_currency_charge', 'payable_amount_in_base_currency', 'payment_method_currency', 'percentage_charge', 'payable_amount', 'fixed_charge');
                },
                'driver',
            ])
                ->where('id', $id)->firstOr(function () {
                    throw new \Exception('Booking Record not found.');
                });
            $data['auth_user'] = getAuthUser(getCurrentGuard());
            $data['base_route'] = $this->base_route_path;
            return view($this->base_view_path . 'edit', $data);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }
    public function bookingRefund($id)
    {
        try {
            $booking = $this->model::select(['id', 'status', 'date', 'user_id'])
                ->with('user:id,lastname,firstname,image,image_driver,language_id')
                ->where('id', $id)
                ->firstOr(function () {
                    throw new \Exception('Booking Record not found.');
                });

            if ($booking->status == 0 || $booking->status == 4) {
                return back()->with('error', 'Booking is not refundable.');
            }

            $booking->status = 4;
            $booking->save();

            $params = [
                'car' => $booking->car->name,
                'user' => optional($booking->user)->firstname . ' ' . optional($booking->user)->lastname,
            ];

            $action = [
                "link" => route('user.booking.list'),
                "icon" => "fa fa-money-bill-alt text-white"
            ];
            $this->sendMailSms($booking->user, 'BOOKING_PAYMENT_REFUNDED', $params);
            $this->userPushNotification($booking->user, 'BOOKING_PAYMENT_REFUNDED', $params, $action);
            $this->userFirebasePushNotification($booking->user, 'BOOKING_PAYMENT_REFUNDED', $params);

            return back()->with('success', 'Booking Refunded Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function complete(Request $request, $id)
    {
        try {
            $booking = $this->model::where('id', $id)->firstOr(function () {
                throw new \Exception('This Booking is not available now');
            });
            $user = User::where('id', $booking->user_id)->firstOr(function () {
                throw new \Exception('This User is not available now');
            });

            if ($request->status == 2) {
                $booking->status = 2;
                $booking->save();

                $msg = [
                    'car' => $booking->driver->car->name,
                    'status' => 'Approve',
                ];

                $action = [
                    "link" => route('user.booking.list'),
                    "icon" => "fa fa-money-bill-alt text-white"
                ];
                $this->userFirebasePushNotification($user, 'BOOKING_APPROVED', $msg);
                $this->userPushNotification($user, 'BOOKING_APPROVED', $msg, $action);
                $this->sendMailSms($user, 'BOOKING_APPROVED', $msg);
            }

            return back()->with('success', 'Booking has been completed.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }


    public function refundMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select any Booking.');
            return response()->json(['error' => 1]);
        }
        $updatedCount = $this->model::whereIn('id', $request->strIds)
            ->update(['status' => 4]);

        if ($updatedCount > 0) {
            session()->flash('success', 'Selected bookings updated successfully.');
            return response()->json(['success' => 1]);
        } else {
            session()->flash('error', 'No bookings were updated.');
            return response()->json(['error' => 1]);
        }
    }

    public function completedMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select any Booking.');
            return response()->json(['error' => 1]);
        }
        $updatedCount = $this->model::whereIn('id', $request->strIds)
            ->update(['status' => 2]);

        if ($updatedCount > 0) {
            session()->flash('success', 'Selected bookings updated successfully.');
            return response()->json(['success' => 1]);
        } else {
            session()->flash('error', 'No bookings were updated.');
            return response()->json(['error' => 1]);
        }
    }

}
