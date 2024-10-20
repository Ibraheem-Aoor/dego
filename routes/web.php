<?php

use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\ManualRecaptchaController;
use App\Http\Controllers\khaltiPaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InAppNotificationController;
use App\Http\Controllers\User\SupportTicketController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CarCheckoutController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\User\VerificationController;
use App\Http\Controllers\User\SubscriberController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\FavouriteListController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\User\KycVerificationController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\SocialiteController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

$basicControl = basicControl();
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('lang', $locale);
    return redirect()->back();
})->name('language');

Route::get('maintenance-mode', function () {
    if (!basicControl()->is_maintenance_mode) {
        return redirect(route('page'));
    }
    $data['maintenanceMode'] = \App\Models\MaintenanceMode::first();
    return view(template() . 'maintenance', $data);
})->name('maintenance');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPassword'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset')->middleware('guest');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.update');

Route::get('instruction/page', function () {
    return view('instruction-page');
})->name('instructionPage');

Route::group(['middleware' => ['maintenanceMode']], function () use ($basicControl) {
    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');
    });

    Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {

        Route::get('check', [VerificationController::class, 'check'])->name('check');
        Route::get('resend_code', [VerificationController::class, 'resendCode'])->name('resend.code');
        Route::post('mail-verify', [VerificationController::class, 'mailVerify'])->name('mail.verify');
        Route::post('sms-verify', [VerificationController::class, 'smsVerify'])->name('sms.verify');
        Route::post('twoFA-Verify', [VerificationController::class, 'twoFAverify'])->name('twoFA-Verify');

        Route::middleware('userCheck')->group(function () {
            Route::middleware('kyc')->group(function () {
                Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
                Route::post('save-token', [HomeController::class, 'saveToken'])->name('save.token');

                Route::get('notification-permission/list', [NotificationController::class, 'index'])->name('notification.permission.list');
                Route::post('notification-perission/update', [NotificationController::class, 'notificationSettingsChanges'])->name('notification.permission');

                Route::get('twostep-security', [HomeController::class, 'twoStepSecurity'])->name('twostep.security');
                Route::post('twoStep-enable', [HomeController::class, 'twoStepEnable'])->name('twoStepEnable');
                Route::post('twoStep-disable', [HomeController::class, 'twoStepDisable'])->name('twoStepDisable');

                /* ===== Push Notification ===== */
                Route::get('push-notification-show', [InAppNotificationController::class, 'show'])->name('push.notification.show');
                Route::get('push.notification.readAll', [InAppNotificationController::class, 'readAll'])->name('push.notification.readAll');
                Route::get('push-notification-readAt/{id}', [InAppNotificationController::class, 'readAt'])->name('push.notification.readAt');

                Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
                    Route::get('/', [SupportTicketController::class, 'index'])->name('list');
                    Route::get('/create', [SupportTicketController::class, 'create'])->name('create');
                    Route::post('/create', [SupportTicketController::class, 'store'])->name('store');
                    Route::get('/view/{ticket}', [SupportTicketController::class, 'ticketView'])->name('view');
                    Route::put('/reply/{ticket}', [SupportTicketController::class, 'reply'])->name('reply');
                    Route::get('/download/{ticket}', [SupportTicketController::class, 'download'])->name('download');
                    Route::get('/close/{id}', [SupportTicketController::class, 'close'])->name('close');
                });


                Route::any('package-checkout/{slug}/{uid?}', [CheckoutController::class, 'checkoutForm'])->name('checkout.form');
                Route::any('package/checkout-form/travelers-details', [CheckoutController::class, 'checkoutTravelersDetails'])->name('checkout.form.travelers.details');

                Route::get('package/checkout-form/travelers-details/{uid}', [CheckoutController::class, 'getTravel'])->name('checkout.get.travel');

                Route::post('package/checkout-form/payment', [CheckoutController::class, 'checkoutTravelersPayment'])->name('checkout.form.travelers.payment');
                Route::get('package/checkout/form/{uid}', [CheckoutController::class, 'checkoutPaymentForm'])->name('checkout.payment.form');


                Route::get('payment-supported-currency', [CheckoutController::class, 'paymentSupportedCurrency'])->name('payment.supported.currency');
                Route::get('payment-check-amount', [CheckoutController::class, 'checkAmount'])->name('payment.check-amount');
                Route::any('package/make-payment', [CheckoutController::class, 'makePayment'])->name('make.payment');
                Route::get('coupon/check', [CheckoutController::class, 'checkCoupon'])->name('coupon.check');
                Route::any('date/update', [CheckoutController::class, 'dateUpdate'])->name('date.update');
                // User Car Booking Routes
                Route::prefix('car')->as('car.')->group(function () {
                    Route::post('/cehckout-form/{id}', [CarCheckoutController::class, 'checkoutForm'])->name('checkout.form');
                    Route::post('checkout/payment/{id}', [CarCheckoutController::class, 'storeBookingForPayment'])->name('checkout.form.store_booking');
                    Route::post('checkout/payment/{id}', [CarCheckoutController::class, 'checkoutPaymentForm'])->name('checkout.form.payment.form');


                });

            });

            Route::get('verification/kyc', [KycVerificationController::class, 'kyc'])->name('verification.kyc');
            Route::get('verification/kyc-form/{id}', [KycVerificationController::class, 'kycForm'])->name('verification.kyc.form');
            Route::post('verification/kyc-form/submit', [KycVerificationController::class, 'verificationSubmit'])->name('kyc.verification.submit');
            Route::get('verification/kyc/history', [KycVerificationController::class, 'history'])->name('verification.kyc.history');
            Route::get('profile/kyc-settings', [HomeController::class, 'kycSettings'])->name('kyc.settings');
            Route::get('profile/kyc-details', [KycVerificationController::class, 'kycFormDetails'])->name('kycFrom.details');

            Route::get('profile', [HomeController::class, 'profile'])->name('profile');
            Route::post('profile-update', [HomeController::class, 'profileUpdate'])->name('profile.update');
            Route::post('profile-update/image', [HomeController::class, 'profileUpdateImage'])->name('profile.update.image');
            Route::post('update/password', [HomeController::class, 'updatePassword'])->name('updatePassword');

            Route::get('profile/notification-settings', [HomeController::class, 'notificationSettings'])->name('notification.settings');
            Route::get('profile/change-password', [HomeController::class, 'changePassword'])->name('change.password');

            Route::post('add-review/store', [ReviewController::class, 'Store'])->name('review.store');

            Route::get('booking', [BookingController::class, 'bookingList'])->name('booking.list');
            Route::get('favourite-list', [FavouriteListController::class, 'favouriteList'])->name('favourite.list');

            Route::get('package/reaction', [FavouriteListController::class, 'packageReaction'])->name('package.reaction');
            Route::get('review/reaction', [ReviewController::class, 'reviewReaction'])->name('review.reaction');
            Route::get('destination/reaction', [FavouriteListController::class, 'destinationReaction'])->name('destination.reaction');

            Route::post('states', [HomeController::class, 'fetchState'])->name('fetch.state');
            Route::post('cities', [HomeController::class, 'fetchCity'])->name('fetch.city');


            Route::get('payment-logs', [HomeController::class, 'paymentLog'])->name('fund.index');
        });
    });

    Route::get('captcha', [ManualRecaptchaController::class, 'reCaptCha'])->name('captcha');
    Route::post('subscribe', [SubscriberController::class, 'subscribe'])->name('subscribe');

    /* Manage User Deposit */
    Route::get('supported-currency', [DepositController::class, 'supportedCurrency'])->name('supported.currency');
    Route::post('payment-request', [DepositController::class, 'paymentRequest'])->name('payment.request');
    Route::get('deposit-check-amount', [DepositController::class, 'checkAmount'])->name('deposit.checkAmount');

    Route::get('payment-process/{trx_id}', [PaymentController::class, 'depositConfirm'])->name('payment.process');
    Route::post('addFundConfirm/{trx_id}', [PaymentController::class, 'fromSubmit'])->name('addFund.fromSubmit');
    Route::match(['get', 'post'], 'success', [PaymentController::class, 'success'])->name('success');
    Route::match(['get', 'post'], 'failed', [PaymentController::class, 'failed'])->name('failed');

    Route::post('khalti/payment/verify/{trx}', [\App\Http\Controllers\khaltiPaymentController::class, 'verifyPayment'])->name('khalti.verifyPayment');
    Route::post('khalti/payment/store', [khaltiPaymentController::class, 'storePayment'])->name('khalti.storePayment');

    Route::get('blogs', [FrontendController::class, 'blogList'])->name('blog');
    Route::get('blog/{slug}', [FrontendController::class, 'blogDetails'])->name('blog.details');

    Route::get('destinations', [DestinationController::class, 'destinationList'])->name('destination');
    Route::any('destination/track-visitor', [FrontendController::class, 'trackVisitor'])->name('destination.track');

    Route::post('contact/send', [FrontendController::class, 'contact'])->name('contact.send');

    // Packages
    Route::get('packages', [PackageController::class, 'packageList'])->name('package');
    Route::get('package/{slug}', [PackageController::class, 'packageDetails'])->name('package.details')->middleware('packageVisitor');
    Route::get('package-search', [PackageController::class, 'packageSearch'])->name('package.search');
    // Cars
    Route::prefix('cars')->as('car.')->group(function () {
        Route::get('/', [CarController::class, 'carList'])->name('index');
        Route::get('details/{car}', [CarController::class, 'carDetails'])->name('details');
        // Route::get('package-search', [PackageController::class, 'packageSearch'])->name('package.search');
    });

    Route::get('live-data', [FrontendController::class, 'liveData'])->name('live.data');

    Route::get('auth/{socialite}', [SocialiteController::class, 'socialiteLogin'])->name('socialiteLogin');
    Route::get('auth/callback/{socialite}', [SocialiteController::class, 'socialiteCallback'])->name('socialiteCallback');

    Auth::routes();
    /*= Frontend Manage Controller =*/
    Route::get("/{slug?}", [FrontendController::class, 'page'])->name('page');

    /*= Language Controller =*/
    Route::get('/language/{code?}', [FrontendController::class, 'language'])->name('language');
});


