<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\ProcceedToCheckoutRequest;
use App\Http\Requests\Car\StoreBookingInfoForPaymentRequest;
use App\Models\Booking;
use App\Models\Car;
use App\Models\CarBooking;
use App\Models\Coupon;
use App\Models\Deposit;
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

class CarCheckoutController extends Controller
{
    use Upload, Notify, PaymentValidationCheck;

    public function checkoutForm(ProcceedToCheckoutRequest $request, $id, $booking_id = null)
    {
        try {
            // Check Dates Before This Function Call
            $data = $this->getBookingDatesData($request->date);
            $data['user'] = Auth::user();
            $data['object'] = Car::query()->where('id', decrypt($id))->firstOr(function () {
                throw new \Exception(__('The Car was not found.'));
            });
            // booking instant being created here because it might be editable in next steps.
            $data['instant'] = $this->initBooking($data, $booking_id);
            return view(template() . 'checkout.car.userInfo', $data);
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
    private function initBooking(array $data, $booking_id = null): CarBooking
    {
        $instant = CarBooking::when(isset($booking_id), function ($query) use ($booking_id) {
            $query->where('id', decrypt($booking_id));
        })->first();
        if (!$instant) {
            $instant = CarBooking::query()->create([
                'car_id' => $data['object']->id,
                'user_id' => $data['user']->id,
                'company_id' => $data['object']->company_id,
                'status' => 0,
                'total_price' => $data['object']->rent_price * $data['days_count'],
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
            ]);
        }
        $this->syncBookingWithItsDates($data['booking_dates'], $instant);
        return $instant;
    }

    /**
     * Prepare an array of booking dates data.
     *
     * @param string $dates
     *
     * @return array
     */
    private function getBookingDatesData(string $dates): array
    {
        $data['booking_dates'] = array_map('trim', explode(',', $dates));
        $data['booking_dates_label'] = getBookingDatesLabel($data['booking_dates']);
        $data['days_count'] = count($data['booking_dates']);
        return $data;
    }

    public function updateDate(ProcceedToCheckoutRequest $request)
    {
        try {
            $date = $this->getBookingDatesData($request->date);
            $car_booking = CarBooking::where('id', decrypt($request->id))->firstOrFail();
            $this->syncBookingWithItsDates($date['booking_dates'], $car_booking);
            if ($request->has(key: 'is_update_in_checkout') && $request->is_update_in_checkout) {
                $dates = implode(',', $car_booking->bookingDates()->pluck('date')->toArray());
                $edit_userinfo_url = route('user.car.checkout.form', ['id' => encrypt($car_booking->car_id), 'booking_id' => encrypt($car_booking->id), 'date' => $dates]);
                return response()->json(['status' => true, 'edit_userinfo_url' => $edit_userinfo_url]);
            }
            return response()->json(['status' => true]);
        } catch (Throwable $e) {
            dd($e);
            Log::error('ERROR in CarCheckoutController@updateDate: ' . $e->getMessage());
            return response()->json(['success' => false]);
        }
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


    /**
     * Store the booking information for payment.
     *
     * @param StoreBookingInfoForPaymentRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBookingForPayment(StoreBookingInfoForPaymentRequest $request, $id, $booking_id)
    {
        try {
            $car = Car::query()->where('id', decrypt($id))->firstOr(function () {
                throw new Exception();
            });
            $data = $this->getCarBookingData($request, $car);
            $car_booking = CarBooking::query()->findOrFail(decrypt($booking_id));
            $car_booking->update($data);
            $data['car_booking'] = $car_booking;
            $this->syncBookingWithItsDates($data['booking_dates'], $car_booking);
            return redirect()->route('user.car.checkout.form.payment.form', encrypt($data['car_booking']->id));
        } catch (Throwable $e) {
            dd($e);
            Log::error('ERROR in CarCheckoutController@storeBookingForPayment: ' . $e->getMessage());
            return back()->with('error', __('Something went wrong'));
        }
    }

    private function syncBookingWithItsDates(array $booking_dates, CarBooking $car_booking)
    {
        $data_to_sync = [];
        if ($car_booking->bookingDates()->count() > 0) {
            $car_booking->bookingDates()?->delete();
        }
        foreach ($booking_dates as $date) {
            $data_to_sync[] = [
                'date' => \Carbon\Carbon::parse($date)->format('Y-m-d'),
                'car_booking_id' => $car_booking->id,
                'car_id' => $car_booking->car_id,
            ];
        }
        if(isset($data_to_sync))
        {
            $car_booking->bookingDates()->createMany($data_to_sync);
        }
    }

    /**
     * Create an array of data for creating a CarBooking model, given validated
     * request data and a Car model instance.
     *
     * @param StoreBookingInfoForPaymentRequest $request
     * @param Car $car
     *
     * @return array
     */
    private function getCarBookingData(StoreBookingInfoForPaymentRequest $request, $car): array
    {
        $request_data = $request->validated();
        $user = getAuthUser('web');
        $data = $this->getBookingDatesData($request->date);
        $data = array_merge($request_data, $data);
        $data['start_price'] = $car->rent_price;
        $data['total_price'] = $car->rent_price * $data['days_count'];
        $data['user_id'] = $user->id;
        $data['car_id'] = $car->id;
        return $data;
    }

    public function checkoutPaymentForm($id)
    {
        try {
            $data['user'] = getAuthUser('web');
            $data['instant'] = CarBooking::where('id', decrypt($id))->firstOr(function () {
                throw new \Exception();
            });
            $data['gateway'] = Gateway::where('status', 1)->orderBy('sort_by', 'asc')->get();
            $data['object'] = $data['instant']->car;
            $data['booking_dates'] = $data['instant']->bookingDates()->pluck('date')->toArray();
            $data['booking_dates_label'] = getBookingDatesLabel($data['booking_dates']);
            $data['days_count'] = count($data['booking_dates']);
            $data['date'] = implode(',', $data['instant']->bookingDates()->pluck('date')->toArray());

            return view(template() . 'checkout.car.checkout_form', $data);
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
            $booking = CarBooking::where('id', $request->booking)
                ->where('user_id', getAuthUser('web')->id)->firstOr(function () {
                    throw new \Exception('The booking record was not found.');
                });

            $checkAmount = $this->checkAmountValidate($amount, $currency, $gateway, $cryptoCurrency);
            $checkAmountValidate = $this->validationCheck($checkAmount['amount'], $gateway, $currency, $cryptoCurrency);
            if ($checkAmountValidate['status'] == 'error') {
                return back()->with('error', $checkAmountValidate['msg']);
            }
            $deposit = Deposit::create([
                'user_id' => Auth::user()->id,
                'depositable_type' => CarBooking::class,
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
        } catch (\Exception $e) {
            Log::error('ERROR in CarCheckoutController@makePayment: ' . $e->getMessage());
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
