<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
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
