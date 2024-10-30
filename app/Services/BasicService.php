<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\CarBooking;
use App\Models\Deposit;
use App\Models\DriverRideBooking;
use App\Models\Fund;
use App\Models\Package;
use App\Models\Transaction;
use App\Traits\Notify;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Support\Facades\Log;

class BasicService
{
    use Notify;

    public function setEnv($value)
    {
        $envPath = base_path('.env');
        $env = file($envPath);
        foreach ($env as $env_key => $env_value) {
            $entry = explode("=", $env_value, 2);
            $env[$env_key] = array_key_exists($entry[0], $value) ? $entry[0] . "=" . $value[$entry[0]] . "\n" : $env_value;
        }
        $fp = fopen($envPath, 'w');
        fwrite($fp, implode($env));
        fclose($fp);
    }

    public function preparePaymentUpgradation($deposit)
    {
        try {
            $notifable_users = $this->getNotifableUsers($deposit);
            if ($deposit->status == 0 || $deposit->status == 2) {
                $deposit->status = 1;
                $deposit->save();
                $user = $deposit->user;
                $depositable_allowed_types = [Booking::class , CarBooking::class , DriverRideBooking::class];
                if (in_array($deposit->depositable_type , $depositable_allowed_types)) {

                    $transaction = new Transaction();
                    $transaction->user_id = $deposit->user_id;
                    $transaction->amount = $deposit->payable_amount_in_base_currency;
                    $transaction->charge = $deposit->base_currency_charge;
                    $transaction->balance = $user->balance;
                    $transaction->trx_type = '+';
                    $transaction->remarks = 'payment Via ' . optional($deposit->gateway)->name;
                    $deposit->transactional()->save($transaction);
                    $deposit->save();

                    $response = $deposit->depositable;
                    $response->status = 1;
                    $response->save();
                    $params = [
                        'package_title' => $response->getBookedItemTitle()
                    ];

                    $action = [
                        "link" => route('user.booking.list'),
                        "icon" => "fa fa-money-bill-alt text-white"
                    ];
                    $this->sendMailSms($deposit->user, 'BOOKING_REQUEST_SEND', $params);
                    $this->userPushNotification($deposit->user, 'BOOKING_REQUEST_SEND', $params, $action);
                    $this->userFirebasePushNotification($deposit->user, 'BOOKING_REQUEST_SEND', $params);

                    $params = [
                        'user' => optional($deposit->user)->username,
                        'package_title' => $response->getBookedItemTitle(),
                    ];
                    $actionAdmin = [
                        "user" => optional($deposit->user)->firstname . ' ' . optional($deposit->user)->lastname,
                        "image" => getFile(optional($deposit->user)->image_driver, optional($deposit->user)->image),
                        "link" => "#",
                        "icon" => "fas fa-ticket-alt text-white"
                    ];
                    $notifable_users = $this->getNotifableUsers($deposit);
                    $this->adminMail('BOOKING_REQUEST_SEND_ADMIN', $params, $action , notifiables:$notifable_users);
                    $this->adminPushNotification('BOOKING_REQUEST_SEND_ADMIN', $params, $actionAdmin , notiables:$notifable_users);
                    $this->adminFirebasePushNotification('BOOKING_REQUEST_SEND_ADMIN', $params , notiables:$notifable_users);
                }

                return true;
            }
        } catch (\Exception $e) {
            Log::error('ERROR IN preparePaymentUpgradation: ' . $e->getMessage());
            dd($e);
        }
    }

    private function getNotifableUsers(Deposit $deposit)
    {
        $admins = Admin::getNotifableUsers();
        $users = $deposit->depositable->getNotifableUsers();
        return collect($admins)->merge($users);
    }

    public function cryptoQR($wallet, $amount, $crypto = null)
    {
        $cryptoQr = $wallet . "?amount=" . $amount;
        return "https://quickchart.io/chart?cht=qr&chl=$cryptoQr";
    }
}
