<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotte di autenticazione (Laravel Breeze)
|--------------------------------------------------------------------------
|
| Questo file definisce tutte le rotte legate all’autenticazione:
| - Registrazione
| - Login / Logout
| - Reset password
| - Conferma password
| - Verifica email
|
| Sono divise in due gruppi principali:
|   - 'guest'  → accessibili solo se l’utente NON è loggato
|   - 'auth'   → accessibili solo se l’utente È loggato
|
*/

/*
|--------------------------------------------------------------------------
| ROTTE PER GLI OSPITI (guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Registrazione
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Recupero password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Reset password con token
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

/*
|--------------------------------------------------------------------------
| ROTTE PER UTENTI AUTENTICATI (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Pagina per richiedere verifica email
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Link di verifica email inviato
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Reinvia notifica di verifica
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Conferma password prima di operazioni sensibili
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Aggiornamento password da profilo
    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
