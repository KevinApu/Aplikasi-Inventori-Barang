<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BarangMasukController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    // mengerah ke form
    Route::get('login', [LoginUserController::class, 'create'])
        ->name('login');
    // dari form            
    Route::post('login', [LoginUserController::class, 'store']);

});

Route::get('/password-toggle', function () {
    return view('auth.password-toggle');
});


Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
