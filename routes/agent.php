<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Agent\CompanyController;
use App\Http\Controllers\Agent\DashboardController;
use Illuminate\Support\Facades\Route;

#---------- AUTH ROUTES ---------#
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest:agent');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request')
    ->middleware('guest:agent');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset')->middleware('guest:agent');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.reset.update');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('save-token', [DashboardController::class, 'saveToken'])->name('save.token');


Route::prefix('companies')->as('company.')->group(function () {
    Route::get('list', [CompanyController::class, 'index'])->name('index');
    Route::get('add', [CompanyController::class, 'agentAdd'])->name('add');
    Route::post('store', [CompanyController::class, 'store'])->name('store');
    Route::get('search', [CompanyController::class, 'search'])->name('search');
    Route::post('delete-multiple', [CompanyController::class, 'deleteMultiple'])->name('delete.multiple');

    Route::get('edit/{id}', [CompanyController::class, 'userEdit'])->name('edit');
    Route::post('update/{id}', [CompanyController::class, 'userUpdate'])->name('update');
    Route::post('email/{id}', [CompanyController::class, 'EmailUpdate'])->name('email.update');
    Route::post('username/{id}', [CompanyController::class, 'usernameUpdate'])->name('username.update');
    Route::post('password/{id}', [CompanyController::class, 'passwordUpdate'])->name('password.update');
    Route::post('preferences/{id}', [CompanyController::class, 'preferencesUpdate'])->name('preferences.update');
    Route::get('view-profile/{id}', [CompanyController::class, 'userViewProfile'])->name('view.profile');
    Route::post('block-profile/{id}', [CompanyController::class, 'blockProfile'])->name('block.profile');
    Route::get('send-email/{id}', [CompanyController::class, 'sendEmail'])->name('send.email');
    Route::post('send-email/{id?}', [CompanyController::class, 'sendMailUser'])->name('email.send');
    Route::get('mail-all-user', [CompanyController::class, 'mailAllUser'])->name('mail.all.user');
});
