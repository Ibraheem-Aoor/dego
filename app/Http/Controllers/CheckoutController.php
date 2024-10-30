<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\CarBooking;
use App\Models\Coupon;
use App\Models\Deposit;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use PhpParser\Node\Expr\New_;

class CheckoutController extends Controller
{
    use Upload, Notify, PaymentValidationCheck;

    public function checkoutForm(Request $request, $slug, $uid = null)
    {
        try {
            $data['pageSeo'] = Page::where('home_name', 'packages')
                ->select('page_title', 'name', 'breadcrumb_image', 'breadcrumb_image_driver', 'breadcrumb_status',
                    'meta_title', 'meta_keywords', 'meta_description', 'og_description', 'meta_robots',
                    'meta_image', 'meta_image_driver')
                ->where('template_name', basicControl()->theme ?? 'relaxation')
                ->first();

            $user = Auth::user();
            $data['package'] = Package::with('category:id,name')->where('slug', $slug)->firstOr(function () {
                throw new \Exception('The package was not found.');
            });
            $instant = null;
            if ($uid && $data['package']) {
                $instant = Booking::where('uid', $uid)->where('status', 0)->firstOr(function () {
                    throw new \Exception('The booking record was not found.');
                });
            }

            $data['spaceAttribute'] = $data['package']->getBookingsSpaceAttribute($data['package']->id);

            if (isset($request->date) && isset($request->totalInfant) && isset($request->totalChildren) && isset($request->totalAdult)) {
                $totalPerson = $request->totalAdult + $request->totalInfant + $request->totalChildren;
                foreach ($data['spaceAttribute'] as $space) {
                    if ($space['date'] === $request->date) {
                        if ($totalPerson > $space['space']) {
                            return back()->with('error', 'You can book only ' . $space['space'] . ' person(s) for this date.');
                        }
                        break;
                    }
                }

                $adultTotalPrice = ($request->totalAdult ?? 0) * $data['package']->adult_price;
                $childrenTotalPrice = ($request->totalChildren ?? 0) * $data['package']->children_Price;
                $infantTotalPrice = ($request->totalInfant ?? 0) * $data['package']->infant_price;

                $totalPrice = $adultTotalPrice + $childrenTotalPrice + $infantTotalPrice;

                if ($data['package']->discount == 1) {
                    $type = $data['package']->discount_type;

                    if ($type == 0) {
                        $totalPrice = $totalPrice - (($totalPrice * $data['package']->discount_amount) / 100);
                    } elseif ($type == 1) {
                        $totalPrice = $totalPrice - $data['package']->discount_amount;
                    }
                }
            }

            if (!$instant) {
                $instant = new Booking();
                $instant->date = $request->date;
                $instant->total_price = $totalPrice;
                $instant->total_adult = $request->totalAdult;
                $instant->total_children = $request->totalChildren;
                $instant->total_infant = $request->totalInfant;
                $instant->total_person = $totalPerson;
                $instant->package_id = $data['package']->id;
                $instant->package_title = $data['package']->title;
                $instant->duration = $data['package']->duration;
                $instant->start_price = $data['package']->adult_price;
                $instant->startPoint = $data['package']->start_point;
                $instant->startMessage = $data['package']->startMessage;
                $instant->endPoint = $data['package']->end_point;
                $instant->endMessage = $data['package']->endMessage;
                $instant->fname = $user->firstname;
                $instant->lname = $user->lastname;
                $instant->email = $user->email;
                $instant->phone = $user->phone_code . $user->phone;
                $instant->postal_code = $user->zip_code;
                $instant->city = $user->city;
                $instant->state = $user->state;
                $instant->country = $user->country;
                $instant->address_one = $user->addressOne;
                $instant->address_two = $user->addressTwo;
                $instant->user_id = $user->id;
                $instant->save();
            }

            return view(template() . 'checkout.userInfo', $data, compact('instant'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function paymentSupportedCurrency(Request $request)
    {
        $gateway = Gateway::where('id', $request->gateway)->first();
        if (!$gateway){
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

    public function checkoutTravelersDetails(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address_one' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
        ]);

        $package = Package::with('category:id,name')->where('slug', $request->package)->first();
        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package Not Found.',
            ]);
        }
        $instant = Booking::where('id', $request->booking)->where('status', 0)->first();
        if (!$instant) {
            return response()->json([
                'success' => false,
                'message' => 'Booking Not Found.',
            ]);
        }
        $instant->fname = $request->fname;
        $instant->lname = $request->lname;
        $instant->email = $request->email;
        $instant->phone = $request->phone;
        $instant->address_one = $request->address_one;
        $instant->address_two = $request->address_two;
        $instant->city = $request->city;
        $instant->state = $request->state;
        $instant->country = $request->country;
        $instant->postal_code = $request->postalCode;
        $instant->message = $request->message;
        $instant->date = $request->date;
        $instant->company_id = $package->company_id;

        $instant->save();

        return response()->json([
            'success' => true,
            'package' => $package,
            'instant' => $instant,
        ]);
    }

    public function getTravel($uid)
    {
        try {
            $instant = Booking::where('uid', $uid)->firstOr(function () {
                throw new \Exception('The booking record was not found.');
            });
            $package = Package::with('category:id,name')->where('id', $instant->package_id)->firstOr(function () {
                throw new \Exception('The package was not found.');
            });
            $pageSeo = Page::where('home_name', 'packages')
                ->select('page_title', 'name', 'breadcrumb_image', 'breadcrumb_image_driver', 'breadcrumb_status',
                    'meta_title', 'meta_keywords', 'meta_description', 'og_description', 'meta_robots',
                    'meta_image', 'meta_image_driver')
                ->where('template_name', basicControl()->theme ?? 'relaxation')
                ->first();
            return view(template() . 'checkout.travelerInfo', compact('package', 'pageSeo', 'instant'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function checkoutTravelersPayment(Request $request)
    {
        $messages = [
            'fname_adult.*.required' => 'Please enter the first name for adult.',
            'fname_adult.*.string' => 'The first name for adults must be a string.',
            'fname_adult.*.max' => 'The first name for adults cannot exceed 255 characters.',
            'lname_adult.*.required' => 'Please enter the last name for adult.',
            'lname_adult.*.string' => 'The last name for adults must be a string.',
            'lname_adult.*.max' => 'The last name for adults cannot exceed 255 characters.',
            'date_adult.*.required' => 'Please enter the birth date for adult.',
            'date_adult.*.date' => 'The birth date for adults must be a valid date.',
            'fname_child.*.required' => 'Please enter the first name for child.',
            'fname_child.*.string' => 'The first name for children must be a string.',
            'fname_child.*.max' => 'The first name for children cannot exceed 255 characters.',
            'lname_child.*.required' => 'Please enter the last name for child.',
            'lname_child.*.string' => 'The last name for children must be a string.',
            'lname_child.*.max' => 'The last name for children cannot exceed 255 characters.',
            'date_child.*.required' => 'Please enter the birth date for child.',
            'date_child.*.date' => 'The birth date for children must be a valid date.',
            'fname_infant.*.required' => 'Please enter the first name for infant.',
            'fname_infant.*.string' => 'The first name for infants must be a string.',
            'fname_infant.*.max' => 'The first name for infants cannot exceed 255 characters.',
            'lname_infant.*.required' => 'Please enter the last name for infant.',
            'lname_infant.*.string' => 'The last name for infants must be a string.',
            'lname_infant.*.max' => 'The last name for infants cannot exceed 255 characters.',
            'date_infant.*.required' => 'Please enter the birth date for infant.',
            'date_infant.*.date' => 'The birth date for infants must be a valid date.',
        ];

        $request->validate([
            'fname_adult.*' => 'required|string|max:255',
            'lname_adult.*' => 'required|string|max:255',
            'date_adult.*' => 'required|date',
            'fname_child.*' => 'required|string|max:255',
            'lname_child.*' => 'required|string|max:255',
            'date_child.*' => 'required|date',
            'fname_infant.*' => 'required|string|max:255',
            'lname_infant.*' => 'required|string|max:255',
            'date_infant.*' => 'required|date',
        ], $messages);

        $instant = Booking::where('id', $request->booking)->first();
        if (!$instant) {
            return response()->json([
                'success' => false,
                'message' => 'Booking Not Found.',
            ]);
        }
        if ($request->filled(['fname_adult', 'lname_adult', 'date_adult'])) {
            $instant->adult_info = $this->formatTravelerInfo($request->fname_adult, $request->lname_adult, $request->date_adult);
        }

        if ($request->filled(['fname_child', 'lname_child', 'date_child'])) {
            $instant->child_info = $this->formatTravelerInfo($request->fname_child, $request->lname_child, $request->date_child);
        }

        if ($request->filled(['fname_infant', 'lname_infant', 'date_infant'])) {
            $instant->infant_info = $this->formatTravelerInfo($request->fname_infant, $request->lname_infant, $request->date_infant);
        }

        $instant->save();

        return response()->json([
            'success' => true,
            'instant' => $instant,
        ]);

    }

    public function checkoutPaymentForm($uid)
    {
        try {
            $instant = Booking::where('uid', $uid)->firstOr(function () {
                throw new \Exception('The booking record was not found.');
            });
            $data['package'] = Package::with('category:id,name')->where('id', $instant->package_id)->firstOr(function () {
                throw new \Exception('The package was not found.');
            });
            $data['pageSeo'] = Page::where('home_name', 'packages')
                ->select('page_title', 'name', 'breadcrumb_image', 'breadcrumb_image_driver', 'breadcrumb_status',
                    'meta_title', 'meta_keywords', 'meta_description', 'og_description', 'meta_robots',
                    'meta_image', 'meta_image_driver')
                ->where('template_name', basicControl()->theme ?? 'relaxation')
                ->first();
            $data['gateway'] = Gateway::where('status', 1)->orderBy('sort_by', 'asc')->get();

            return view(template() . 'checkout.checkout_form', array_merge($data, ['instant' => $instant]));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    private function formatTravelerInfo($firstNames, $lastNames, $birthDates)
    {
        return array_map(function ($firstName, $lastName, $birthDate) {
            return [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'full_name' => $firstName . ' ' . $lastName,
                'birth_date' => $birthDate
            ];
        }, $firstNames, $lastNames, $birthDates);
    }


    public function makePayment(Request $request)
    {
        try {
            $amount = $request->amount;
            $gateway = $request->gateway_id;
            $currency = $request->supported_currency ?? $request->base_currency;
            $cryptoCurrency = $request->supported_crypto_currency;
            $booking = Booking::where('id', $request->booking)->firstOr(function () {
                throw new \Exception('The booking record was not found.');
            });

            $checkAmount = $this->checkAmountValidate($amount, $currency, $gateway, $cryptoCurrency);
            $checkAmountValidate = $this->validationCheck($checkAmount['amount'], $gateway, $currency, $cryptoCurrency);
            if ($checkAmountValidate['status'] == 'error') {
                return back()->with('error', $checkAmountValidate['msg']);
            }
            $deposit = Deposit::create([
                'user_id' => Auth::user()->id,
                'depositable_type' => Booking::class,
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
            return back()->with('error', $e->getMessage());
        }

    }

    public function checkCoupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required|string',
        ]);

        $couponCode = $request->input('coupon');
        $amount = $request->input('amount');
        $instantSave = $request->input('instantId');
        $coupon = Coupon::whereRaw('BINARY coupon_code = ?', [$couponCode])->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not found.',
            ], 404);
        }

        $instant = Booking::find($instantSave);

        $currentDate = now();
        $endDate = Carbon::createFromFormat('Y-m-d', $coupon->end_date);

        if ($instant->coupon != 1) {
            if ($currentDate->gt($endDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon validity expired.',
                ], 404);
            }

            $package = Package::where('id', $instant->package_id)->where('status', 1)->first();

            if (!$package) {
                return response()->json([
                    'success' => false,
                    'message' => 'Package not found.',
                ], 404);
            }

            if ($package->discount == 0) {
                $discount = ($coupon->discount_type == 0) ? $coupon->discount : ($amount * $coupon->discount) / 100;

                $instant->coupon = 1;
                $instant->cupon_number = $coupon->coupon_code;
                $instant->cupon_status = $coupon->discount_type;
                $instant->discount_amount = $discount;
                $instant->total_price = $instant->total_price - $discount;
                $instant->save();

                return response()->json([
                    'success' => true,
                    'data' => $instant,
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Coupon not allowed for this package.',
            ], 404);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not allowed for this package.',
            ], 404);
        }

    }

    public function dateUpdate(Request $request)
    {
        $id = $request->input('id');
        $date = $request->input('date');
        $instant = Booking::where('id', $id)->first();
        if (!$instant) {
            return response()->json(['error' => 'Booking with id ' . $id . ' not found'], 404);
        }
        $formatted_date = date('Y-m-d', strtotime($date));

        $instant->date = $formatted_date;
        $instant->save();

        return response()->json(['message' => 'Date updated successfully']);
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
