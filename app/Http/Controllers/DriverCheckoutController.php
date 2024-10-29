<?php

namespace App\Http\Controllers;

use App\Exceptions\DateNotAvailable;
use App\Http\Requests\Car\ProcceedToCheckoutRequest;
use App\Http\Requests\Car\StoreBookingInfoForPaymentRequest;
use App\Http\Requests\Driver\ProccedToCheckout;
use App\Models\Booking;
use App\Models\Car;
use App\Models\CarBooking;
use App\Models\Coupon;
use App\Models\Deposit;
use App\Models\Driver;
use App\Models\DriverRide;
use App\Models\DriverRideBooking;
use App\Models\Gateway;
use App\Models\InstantSave;
use App\Models\Package;
use App\Models\Page;
use App\Models\Transaction;
use App\Traits\Notify;
use App\Traits\PaymentValidationCheck;
use App\Traits\Upload;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use PhpParser\Node\Expr\New_;
use Throwable;

class DriverCheckoutController extends Controller
{
    use Upload, Notify, PaymentValidationCheck;
    protected $model;
    public function __construct()
    {
        $this->model = new Driver();
    }


    public function checkoutForm(ProccedToCheckout $request, $id, $booking_id = null)
    {
        try {
            // Check Dates Before This Function Call
            $data = $request->toArray();
            $data['total_price'] = $this->model::getTotalPriceFromRequest($request , decrypt($id));
            $data['user'] = Auth::user();
            $data['object'] = $this->model::query()->where('id', decrypt($id))->firstOr(function () {
                throw new \Exception(__('The Driver was not found.'));
            });
            // booking instant being created here because it might be editable in next steps.
            $data['instant'] = $this->initBooking($data, $booking_id);
            return redirect()->route('user.driver.checkout.form.payment.form', encrypt($data['instant']->id));

        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', $e->getMessage());
        }
    }




    /**
     * Initialize a booking record if it does not exist based on the provided data.
     *
     * @param array $data The data array containing object which is 'car' and user information.
     * @param int|null $booking_id The ID of the booking record (optional).
     */
    private function initBooking(array $data, $booking_id = null): DriverRideBooking
    {
        $booking_id  = isset($booking_id) ? decrypt($booking_id) : null;
        $instant = DriverRideBooking::firstOrCreate([
            'id' => $booking_id,
        ],[
            'driver_id' => $data['object']->id,
            'user_id' => $data['user']->id,
            'status' => 0, // not paid
            'total_price' => $data['total_price'],
            'fname' => $data['user']->firstname,
            'lname' => $data['user']->lastname,
            'email' => $data['user']->email,
            'phone' => $data['user']->phone_code . $data['user']->phone,
            'postal_code' => $data['user']->zip_code,
            'city' => $data['user']->city,
            'state' => $data['user']->state,
            'country' => $data['user']->country,
            'address_one' => $data['user']->address_one,
            'address_two' => $data['user']->address_two,
            'date' => $data['date'],
        ]);
        return $instant;
    }




    public function paymentSupportedCurrency(Request $request)
    {
        $gateway = Gateway::where('id', $request->gateway)->first();
        if (!$gateway) {
            return redirect([
                'success' => false,
                'message' => 'Gateway is Missing.'
            ]);
        }
        return response([
            'success' => true,
            'data' => $gateway->supported_currency,
            'currencyType' => $gateway->currency_type,
            'currency' => $gateway->receivable_currencies[0]->name ?? $gateway->receivable_currencies[0]->currency,
            'min_amount' => $gateway->receivable_currencies[0]->min_limit,
        ]);
    }



    public function checkAmount(Request $request)
    {
        if ($request->ajax()) {
            $amount = $request->amount;
            $selectedCurrency = $request->selected_currency;
            $selectGateway = $request->select_gateway;
            $selectedCryptoCurrency = $request->selectedCryptoCurrency;
            $data = $this->checkAmountValidate($amount, $selectedCurrency, $selectGateway, $selectedCryptoCurrency);
            return response()->json($data);
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }






    public function checkoutPaymentForm($id)
    {
        try {
            $data['user'] = getAuthUser('web');
            $data['instant'] = DriverRideBooking::where('id', decrypt($id))->firstOr(function () {
                throw new \Exception();
            });
            $data['gateway'] = Gateway::where('status', 1)->orderBy('sort_by', 'asc')->get();
            $data['object'] = $data['instant']->driver;
            return view(template() . 'checkout.driver.checkout_form', $data);
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', $e->getMessage());
        }
    }




    public function makePayment(Request $request)
    {
        try {

            $amount = $request->amount;
            $gateway = $request->gateway_id;
            $currency = $request->supported_currency ?? $request->base_currency;
            $cryptoCurrency = $request->supported_crypto_currency;
            $booking = DriverRideBooking::where('id', $request->booking)
            ->where('user_id', getAuthUser('web')->id)->firstOr(function () {
                throw new \Exception('The booking record was not found.');
            });
            $locked = DriverRideBooking::where('driver_id', $booking->driver_id)
            ->where('date', $booking->date)
            ->where('status', '!=', 0)
            ->lockForUpdate()
            ->first();
            if ($locked) {
                throw new DateNotAvailable('This date is already booked for this driver.');
            }

            $checkAmount = $this->checkAmountValidate($amount, $currency, $gateway, $cryptoCurrency);
            $checkAmountValidate = $this->validationCheck($checkAmount['amount'], $gateway, $currency, $cryptoCurrency);
            if ($checkAmountValidate['status'] == 'error') {
                return back()->with('error', $checkAmountValidate['msg']);
            }
            $deposit = Deposit::create([
                'user_id' => Auth::user()->id,
                'depositable_type' => DriverRideBooking::class,
                'depositable_id' => $booking->id,
                'payment_method_id' => $checkAmountValidate['data']['gateway_id'],
                'payment_method_currency' => $checkAmountValidate['data']['currency'],
                'amount' => $checkAmountValidate['data']['payable_amount'],
                'percentage_charge' => $checkAmountValidate['data']['percentage_charge'],
                'fixed_charge' => $checkAmountValidate['data']['fixed_charge'],
                'payable_amount' => $checkAmountValidate['data']['payable_amount'],
                'base_currency_charge' => $checkAmountValidate['data']['base_currency_charge'],
                'payable_amount_in_base_currency' => $checkAmountValidate['data']['payable_amount_base_in_currency'],
                'status' => 0,
            ]);

            return redirect(route('payment.process', $deposit->trx_id));
        }
        catch (DateNotAvailable $e) {
            dd($e);

            Log::error('ERROR in DriverCheckoutController@makePayment: ' . $e->getMessage());
            return back()->with('error', __($e->getMessage()));
        }
        catch (\Exception $e) {
            dd($e);
            Log::error('ERROR in DriverCheckoutController@makePayment: ' . $e->getMessage());
            return back()->with('error', __('Something went wrong'));
        }

    }


    public function checkAmountValidate($amount, $selectedCurrency, $selectGateway, $selectedCryptoCurrency = null)
    {
        $selectGateway = Gateway::where('id', $selectGateway)->where('status', 1)->first();
        if (!$selectGateway) {
            return ['status' => false, 'message' => "Payment method not available for this transaction"];
        }

        if ($selectGateway->currency_type == 1) {
            $selectedCurrency = array_search($selectedCurrency, $selectGateway->supported_currency);
            if ($selectedCurrency !== false) {
                $selectedPayCurrency = $selectGateway->supported_currency[$selectedCurrency];
            } else {
                return ['status' => false, 'message' => "Please choose the currency you'd like to use for payment"];
            }
        }

        if ($selectGateway->currency_type == 0) {
            $selectedCurrency = array_search($selectedCryptoCurrency, $selectGateway->supported_currency);
            if ($selectedCurrency !== false) {
                $selectedPayCurrency = $selectGateway->supported_currency[$selectedCurrency];
            } else {
                return ['status' => false, 'message' => "Please choose the currency you'd like to use for payment"];
            }
        }

        if ($selectGateway) {
            $receivableCurrencies = $selectGateway->receivable_currencies;
            if (is_array($receivableCurrencies)) {
                if ($selectGateway->id < 999) {
                    $currencyInfo = collect($receivableCurrencies)->where('name', $selectedPayCurrency)->first();
                } else {
                    if ($selectGateway->currency_type == 1) {
                        $currencyInfo = collect($receivableCurrencies)->where('currency', $selectedPayCurrency)->first();
                    } else {
                        $currencyInfo = collect($receivableCurrencies)->where('currency', $selectedCryptoCurrency)->first();
                    }
                }
            } else {
                return null;
            }
        }


        $currencyType = $selectGateway->currency_type;
        $limit = $currencyType == 0 ? 8 : 2;
        $amount = getAmount($amount, $limit);
        $status = false;

        if ($currencyInfo) {
            $percentage = $currencyInfo->percentage_charge;
            $amount_in_selected_currency = getAmount($amount * $currencyInfo->conversion_rate, $limit);
            $percentage_charge = getAmount(($amount_in_selected_currency * $percentage) / 100, $limit);
            $fixed_charge = getAmount($currencyInfo->fixed_charge, $limit);
            $min_limit = getAmount($currencyInfo->min_limit, $limit);
            $max_limit = getAmount($currencyInfo->max_limit, $limit);
            $charge = getAmount($percentage_charge + $fixed_charge, $limit);
        }

        $basicControl = basicControl();
        $charge_in_base_currency = getAmount($charge / $currencyInfo->conversion_rate ?? 1, $limit);
        $payable_amount_in_base_currency = getAmount($amount + $charge_in_base_currency, $limit);
        $charge_amount_in_selected_currency = getAmount($charge);
        $payable_amount_in_selected_currency = getAmount($amount_in_selected_currency + $charge_amount_in_selected_currency, $limit);

        if ($amount < $min_limit || $amount > $max_limit) {
            $message = "minimum payment $min_limit and maximum payment limit $max_limit";
        } else {
            $status = true;
            $message = "Amount : $amount" . " " . $selectedPayCurrency;
        }

        $data['status'] = $status;
        $data['message'] = $message;
        $data['fixed_charge'] = $fixed_charge;
        $data['percentage_charge'] = $percentage_charge;
        $data['min_limit'] = $min_limit;
        $data['max_limit'] = $max_limit;
        $data['payable_amount'] = $payable_amount_in_selected_currency;
        $data['charge'] = $charge_amount_in_selected_currency;
        $data['amount'] = $amount_in_selected_currency;
        $data['conversion_rate'] = $currencyInfo->conversion_rate ?? 1;
        $data['amount_in_base_currency'] = $payable_amount_in_base_currency;
        $data['currency'] = ($selectGateway->currency_type == 1) ? ($currencyInfo->name ?? $currencyInfo->currency) : "USD";
        $data['base_currency'] = $basicControl->base_currency;
        $data['currency_limit'] = $limit;

        return $data;
    }


}
