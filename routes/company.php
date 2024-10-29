<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\PackageCategoryController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Company\CarBookingController;
use App\Http\Controllers\Company\CarController;
use App\Http\Controllers\Company\DashboardController;
use Illuminate\Support\Facades\Route;

#---------- AUTH ROUTES ---------#
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest:company');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request')
    ->middleware('guest:agent');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset')->middleware('guest:agent');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.reset.update');

Route::middleware('auth:company')->group(function () {

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('save-token', [DashboardController::class, 'saveToken'])->name('save.token');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('save-token', [DashboardController::class, 'saveToken'])->name('save.token');
    // Dashboard Statistics
    Route::get('dashboard/monthly-deposit-withdraw', [DashboardController::class, 'monthlyDepositWithdraw'])->name('monthly.deposit.withdraw');
    Route::get('dashboard/chartUserRecords', [DashboardController::class, 'chartUserRecords'])->name('chartUserRecords');
    Route::get('dashboard/chartTicketRecords', [DashboardController::class, 'chartTicketRecords'])->name('chartTicketRecords');
    Route::get('dashboard/chartKycRecords', [DashboardController::class, 'chartKycRecords'])->name('chartKycRecords');
    Route::get('dashboard/chartTransactionRecords', [DashboardController::class, 'chartTransactionRecords'])->name('chartTransactionRecords');
    Route::get('dashboard/chartLoginHistory', [DashboardController::class, 'chartLoginHistory'])->name(name: 'chartLoginHistory');
    Route::get('dashboard/booking-hsitory', [DashboardController::class, 'totalBooking'])->name('booking.History');


    // Destination Moudle

    Route::get('all-destination', [DestinationController::class, 'list'])->name('all.destination');
    Route::get('destination/add', [DestinationController::class, 'add'])->name('destination.add');
    Route::post('destination/store', [DestinationController::class, 'store'])->name('destination.store');
    Route::get('destination/{id}/edit', [DestinationController::class, 'edit'])->name('destination.edit');
    Route::any('destination/{id}/update', [DestinationController::class, 'update'])->name('destination.update');
    Route::any('destination/{id}/delete', [DestinationController::class, 'delete'])->name('destination.delete');
    Route::post('states', [DestinationController::class, 'fetchState'])->name('fetch.state');
    Route::post('cities', [DestinationController::class, 'fetchCity'])->name('fetch.city');
    Route::get('all-destination/search', [DestinationController::class, 'search'])->name('all.destination.search');
    Route::any('destination/delete-multiple', [DestinationController::class, 'deleteMultiple'])->name('destination.delete.multiple');
    Route::any('destination/{id}/status', [DestinationController::class, 'status'])->name('destination.status');
    Route::any('destination/inactive-multiple', [DestinationController::class, 'inactiveMultiple'])->name('destination.inactiveMultiple');


    Route::get('all-package-category', [PackageCategoryController::class, 'list'])->name('all.package.category');
    Route::get('all-package-category/search', [PackageCategoryController::class, 'search'])->name('all.package.category.search');
    Route::get('package-category/add', [PackageCategoryController::class, 'add'])->name('package.category.add');
    Route::post('package-category/store', [PackageCategoryController::class, 'store'])->name('package.category.store');
    Route::get('package-category/{id}/edit', [PackageCategoryController::class, 'edit'])->name('package.category.edit');
    Route::any('package-category/{id}/update', [PackageCategoryController::class, 'update'])->name('package.category.update');
    Route::any('package-category/{id}/delete', [PackageCategoryController::class, 'delete'])->name('package.category.delete');
    Route::any('package-category/delete-multiple', [PackageCategoryController::class, 'deleteMultiple'])->name('package.category.delete.multiple');
    Route::any('package-category/{id}/status', [PackageCategoryController::class, 'status'])->name('packageCategory.status');
    Route::any('package-category/inactive-multiple', [PackageCategoryController::class, 'inactiveMultiple'])->name('packageCategory.inactiveMultiple');


    Route::get('all-package', [PackageController::class, 'list'])->name('all.package');
    Route::get('all-package/search', [PackageController::class, 'search'])->name('all.package.search');
    Route::get('package/add', [PackageController::class, 'add'])->name('package.add');
    Route::post('package/store', [PackageController::class, 'store'])->name('package.store');
    Route::get('package/{id}/edit', [PackageController::class, 'edit'])->name('package.edit');
    Route::any('package/{id}/update', [PackageController::class, 'update'])->name('package.update');
    Route::any('package/{id}/delete', [PackageController::class, 'delete'])->name('package.delete');
    Route::any('package/delete-multiple', [PackageController::class, 'deleteMultiple'])->name('package.delete.multiple');
    Route::any('package/{id}/discount', [PackageController::class, 'discount'])->name('package.discount');
    Route::any('package/{id}/status', [PackageController::class, 'status'])->name('package.status');
    Route::any('package/inactive-multiple', [PackageController::class, 'inactiveMultiple'])->name('package.inactiveMultiple');
    Route::get('package/seo/{id}', [PackageController::class, 'packageSEO'])->name('package.seo');
    Route::post('package/seo/update/{id}', [PackageController::class, 'packageSeoUpdate'])->name('package.seo.update');



    Route::get('all-booking/{status?}', [BookingController::class, 'all_booking'])->name('all.booking');
    Route::get('all-booking-search', [BookingController::class, 'all_booking_search'])->name('all.booking.search');
    Route::post('booking/completed/{id}', [BookingController::class, 'complete'])->name('booking.action');
    Route::get('booking-edit/{id}', [BookingController::class, 'bookingEdit'])->name('booking.edit');
    Route::post('booking-edit/traveller-update', [BookingController::class, 'travellerUpdate'])->name('traveller.update');
    Route::get('booking-refund/{id}', [BookingController::class, 'bookingRefund'])->name('booking.refund');
    Route::post('booking-update', [BookingController::class, 'bookingUpdate'])->name('booking.update');
    Route::any('booking/refund-multiple', [BookingController::class, 'refundMultiple'])->name('booking.refund.multiple');
    Route::any('booking/completed-multiple', [BookingController::class, 'completedMultiple'])->name('booking.completed.multiple');

    Route::get('package-booking', [BookingController::class, 'totalBooking'])->name('package.booking.History');
    Route::get('package/visitor-history', [BookingController::class, 'visitorHistory'])->name('package.visitor.history');
    Route::get('destiantion/top-visited', [BookingController::class, 'topVisitedDestination'])->name('top.visited.destination');


    // Car Bookings
    Route::prefix('car')->as('car.')->group(function () {
        Route::get('list', [CarController::class, 'list'])->name('list');
        Route::get('add', [CarController::class, 'add'])->name('add');
        Route::post('store', [CarController::class, 'store'])->name('store');
        Route::get('edit/{car}', [CarController::class, 'edit'])->name('edit');
        Route::post('update/{car}', [CarController::class, 'update'])->name('update');
        Route::get('status/{car}', [CarController::class, 'status'])->name('status');
        Route::get('search', [CarController::class, 'search'])->name('search');
        Route::any('delete-multiple', [CarController::class, 'deleteMultiple'])->name('delete.multiple');
        Route::any('inactive-multiple', [CarController::class, 'inactiveMultiple'])->name('inactive.multiple');
        Route::prefix('booking')->as('booking.')->group(function () {
            Route::get('all-bookings', [CarBookingController::class, 'all_booking'])->name('all');
            Route::get('all-bookings/search', [CarBookingController::class, 'all_booking_search'])->name('search');
            Route::get('edit/{id}', [CarBookingController::class, 'bookingEdit'])->name('edit');
            Route::get('refund/{id}', [CarBookingController::class, 'bookingRefund'])->name('refund');
            Route::post('completed/{id}', [CarBookingController::class, 'complete'])->name('action');
            Route::any('booking/refund-multiple', [CarBookingController::class, 'refundMultiple'])->name('refund.multiple');
            Route::any('booking/completed-multiple', [CarBookingController::class, 'completedMultiple'])->name('completed.multiple');


        });
    });
});

