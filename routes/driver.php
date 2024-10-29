<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Agent\CompanyController;
use App\Http\Controllers\Driver\CarController;
use App\Http\Controllers\Driver\DashboardController;
use App\Http\Controllers\Driver\PriceController;
use App\Http\Controllers\Driver\RideBookingController;
use App\Http\Controllers\Driver\RideController;
use Illuminate\Support\Facades\Route;

#---------- AUTH ROUTES ---------#
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest:driver');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request')
    ->middleware('guest:driver');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset')->middleware('guest:driver');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.reset.update');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('save-token', [DashboardController::class, 'saveToken'])->name('save.token');

    Route::get('dashboard/monthly-deposit-withdraw', [DashboardController::class, 'monthlyDepositWithdraw'])->name('monthly.deposit.withdraw');
    Route::get('dashboard/chartUserRecords', [DashboardController::class, 'chartUserRecords'])->name('chartUserRecords');
    Route::get('dashboard/chartTicketRecords', [DashboardController::class, 'chartTicketRecords'])->name('chartTicketRecords');
    Route::get('dashboard/chartKycRecords', [DashboardController::class, 'chartKycRecords'])->name('chartKycRecords');
    Route::get('dashboard/chartTransactionRecords', [DashboardController::class, 'chartTransactionRecords'])->name('chartTransactionRecords');
    Route::get('dashboard/chartLoginHistory', [DashboardController::class, 'chartLoginHistory'])->name('chartLoginHistory');
    Route::get('dashboard/ride-booking', [DashboardController::class, 'totalBooking'])->name('booking.History');

// Manage Price
Route::prefix('price')->as('price.')->group(function () {
    Route::get('index', [PriceController::class, 'index'])->name('index');
    Route::post('update', [PriceController::class, 'update'])->name('update');
});
// Manage Price
Route::prefix('car')->as('car.')->group(function () {
    Route::get('index', [CarController::class, 'index'])->name('index');
    Route::post('update', [CarController::class, 'update'])->name('update');
});

// Manage Ride Destinations
Route::prefix('ride')->as('ride.')->group(function () {
    Route::get('list', [RideController::class, 'index'])->name('index');
    Route::get('add/', [RideController::class, 'addOrEdit'])->name('add');
    Route::post('store', [RideController::class, 'storeOrUpdate'])->name('store');
    Route::get('edit/{id}', [RideController::class, 'addOrEdit'])->name('edit');
    Route::post('update/{id}', [RideController::class, 'storeOrUpdate'])->name('update');
    Route::get('search', [RideController::class, 'search'])->name('search');
    Route::post('delete-multiple', [RideController::class, 'deleteMultiple'])->name('delete.multiple');

    Route::post('email/{id}', [RideController::class, 'EmailUpdate'])->name('email.update');
    Route::post('username/{id}', [RideController::class, 'usernameUpdate'])->name('username.update');
    Route::post('password/{id}', [RideController::class, 'passwordUpdate'])->name('password.update');
    Route::post('preferences/{id}', [RideController::class, 'preferencesUpdate'])->name('preferences.update');
    Route::get('view-profile/{id}', [RideController::class, 'userViewProfile'])->name('view.profile');
    Route::post('block-profile/{id}', [RideController::class, 'blockProfile'])->name('block.profile');
    Route::get('send-email/{id}', [RideController::class, 'sendEmail'])->name('send.email');
    Route::post('send-email/{id?}', [RideController::class, 'sendMailUser'])->name('email.send');
    Route::get('mail-all-user', [RideController::class, 'mailAllUser'])->name('mail.all');
    // Ride Booking
    Route::prefix('booking')->as('booking.')->group(function () {
        Route::get('all-bookings', [RideBookingController::class, 'all_booking'])->name('all');
        Route::get('all-bookings/search', [RideBookingController::class, 'all_booking_search'])->name('search');
        Route::get('edit/{id}', [RideBookingController::class, 'bookingEdit'])->name('edit');
        Route::get('refund/{id}', [RideBookingController::class, 'bookingRefund'])->name('refund');
        Route::post('completed/{id}', [RideBookingController::class, 'complete'])->name('action');
        Route::any('booking/refund-multiple', [RideBookingController::class, 'refundMultiple'])->name('refund.multiple');
        Route::any('booking/completed-multiple', [RideBookingController::class, 'completedMultiple'])->name('completed.multiple');



    });
});


