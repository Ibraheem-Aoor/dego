<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Deposit;
use App\Models\DestinationVisitor;
use App\Models\DriverRide;
use App\Models\DriverRideBooking;
use App\Models\PackageVisitor;
use App\Models\Payout;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserKyc;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    use Upload, Notify;

    public function index()
    {
        $data['firebaseNotify'] = config('firebase');
        $data['latestUser'] = User::latest()->limit(5)->get();
        $statistics['schedule'] = $this->dayList();

        $bookingSummary = DriverRideBooking::selectRaw('COUNT(*) as booking_count, SUM(total_price) as total_amount')
            ->first();
        $data['booking'] = $bookingSummary->booking_count;
        $data['totalAmount'] = $bookingSummary->total_amount;

        $destinationVisitor = DestinationVisitor::selectRaw('
                        COUNT(*) as totalVisitor,
                        SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as VisitorToday,
                        COUNT(DISTINCT CASE WHEN DATE(created_at) = CURDATE() THEN ip_address END) as uniqueVisitor,
                        SUM(CASE WHEN DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN 1 ELSE 0 END) as visitorsYesterday
                    ')->first();


        $data['totalDestinationVisitor'] = $destinationVisitor->totalVisitor;
        $data['destinationVisitorToday'] = $destinationVisitor->VisitorToday;
        $data['uniqueDestinationVisitor'] = $destinationVisitor->uniqueVisitor;
        $visitorsYesterday = $destinationVisitor->visitorsYesterday;
        $data['growthDestinationVisitor'] = ($visitorsYesterday > 0) ? (($data['totalDestinationVisitor'] - $visitorsYesterday) / $visitorsYesterday * 100) : 0;

        return view('driver.dashboard-alternative', $data, compact("statistics"));
    }
    public function monthlyDepositWithdraw(Request $request)
    {
        $keyDataset = $request->keyDataset;
        $dailyDeposit = $this->dayList();
        $auth_driver = getAuthUser('driver');
        Deposit::query()->where('depositable_type', DriverRideBooking::class)
            ->whereHasMorph('depositable', DriverRideBooking::class, function ($query) use ($auth_driver) {
                $query->whereBelongsTo($auth_driver);
            })->when($keyDataset == '0', function ($query) {
                $query->whereMonth('created_at', Carbon::now()->month);
            })
            ->when($keyDataset == '1', function ($query) {
                $lastMonth = Carbon::now()->subMonth();
                $query->whereMonth('created_at', $lastMonth->month);
            })
            ->select(
                DB::raw('SUM(payable_amount_in_base_currency) as totalDeposit'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get()->map(function ($item) use ($dailyDeposit) {
                $dailyDeposit->put($item['date'], $item['totalDeposit']);
            });
        return response()->json([
            "totalDeposit" => currencyPosition($dailyDeposit->sum()),
            "dailyDeposit" => $dailyDeposit,
        ]);
    }

    public function saveToken(Request $request)
    {
        $admin = Auth::guard('driver')
            ->fireBaseToken()
            ->create([
                'token' => $request->token,
            ]);
        return response()->json([
            'msg' => 'token saved successfully.',
        ]);
    }


    public function dayList()
    {
        $totalDays = Carbon::now()->endOfMonth()->format('d');
        $daysByMonth = [];
        for ($i = 1; $i <= $totalDays; $i++) {
            array_push($daysByMonth, ['Day ' . sprintf("%02d", $i) => 0]);
        }

        return collect($daysByMonth)->collapse();
    }

    protected function followupGrap($todaysRecords, $lastDayRecords = 0)
    {

        if (0 < $lastDayRecords) {
            $percentageIncrease = (($todaysRecords - $lastDayRecords) / $lastDayRecords) * 100;
        } else {
            $percentageIncrease = 0;
        }
        if ($percentageIncrease > 0) {
            $class = "bg-soft-success text-success";
        } elseif ($percentageIncrease < 0) {
            $class = "bg-soft-danger text-danger";
        } else {
            $class = "bg-soft-secondary text-body";
        }

        return [
            'class' => $class,
            'percentage' => round($percentageIncrease, 2)
        ];
    }

    public function chartTransactionRecords()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $auth_driver = getAuthUser('driver');

        $transaction = collect(Transaction::query()->whereHasMorph('transactional', Deposit::class, function ($deposit) use ($auth_driver) {
            $deposit->whereHasMorph('depositable', DriverRideBooking::class, function ($ride) use ($auth_driver) {
                $ride->whereBelongsTo($auth_driver);
            });
        })->selectRaw('COUNT(id) AS totalTransaction')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS currentDateTransactionCount')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) THEN id END) AS previousDateTransactionCount')
            ->whereRaw('YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())')
            ->get()
            ->toArray())
            ->collapse();

        $followupGrap = $this->followupGrap($transaction['currentDateTransactionCount'], $transaction['previousDateTransactionCount']);
        $transaction->put('followupGrapClass', $followupGrap['class']);
        $transaction->put('followupGrap', $followupGrap['percentage']);


        $current_month_data = Transaction::query()
            ->whereHasMorph(
                'transactional',
                Deposit::class,
                function ($deposit) use ($auth_driver) {
                    $deposit->whereHasMorph(
                        'depositable',
                        DriverRideBooking::class,
                        function ($ride) use ($auth_driver) {
                            $ride->whereBelongsTo($auth_driver);
                        }
                    );
                }
            )
            ->select(DB::raw('DATE_FORMAT(created_at,"%e %b") as date'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $currentMonth)
            ->orderBy('created_at', 'asc')
            ->groupBy('date')
            ->get();

        $current_month_data_dates = $current_month_data->pluck('date');
        $current_month_datas = $current_month_data->pluck('count');
        $transaction['chartPercentageIncDec'] = fractionNumber($transaction['totalTransaction'] - $transaction['currentDateTransactionCount'], false);
        return response()->json(['transactionRecord' => $transaction, 'current_month_data_dates' => $current_month_data_dates, 'current_month_datas' => $current_month_datas]);
    }


    public function totalBooking()
    {
        $currentMonth = now()->format('Y-m');
        $auth_driver = getAuthUser('driver');
        $propertyBooking = DriverRideBooking::query()->whereBelongsTo($auth_driver)->select(
            DB::raw('DAY(created_at) as day'),
            DB::raw('COUNT(*) as total_sales'),
            DB::raw('SUM(total_price) as total_amount')
        )
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth'")
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        $data['labels'] = [];
        $data['TotalUnit'] = [];
        $data['totalPrice'] = [];

        $lastDayOfMonth = now()->endOfMonth()->format('d');

        for ($day = 1; $day <= $lastDayOfMonth; $day++) {
            $found = $propertyBooking->firstWhere('day', $day);

            if ($found) {
                $data['labels'][] = 'Day ' . $day;
                $data['TotalUnit'][] = $found->total_sales;
                $data['totalPrice'][] = $found->total_amount;
            } else {
                $data['labels'][] = 'Day ' . $day;
                $data['TotalUnit'][] = 0;
                $data['totalPrice'][] = 0;
            }
        }

        return response()->json([
            'labels' => $data['labels'],
            'Unit' => $data['TotalUnit'],
            'Price' => $data['totalPrice'],
        ]);
    }





}
