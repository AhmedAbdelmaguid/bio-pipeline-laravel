<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Rotte Profilo Utente (Laravel Breeze)
|--------------------------------------------------------------------------
|
| Questo file gestisce tutte le operazioni relative al profilo dell’utente
| autenticato: visualizzazione, aggiornamento dati e cancellazione account.
|
| Tutte queste rotte sono protette dal middleware "auth",
| quindi solo un utente loggato può accedervi.
|
*/

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Modifica Profilo
    |--------------------------------------------------------------------------
    |
    | Mostra la pagina di modifica del profilo (username, email, password, ecc.)
    |
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    /*
    |--------------------------------------------------------------------------
    | Aggiorna Profilo
    |--------------------------------------------------------------------------
    |
    | Gestisce l’invio del form per aggiornare i dati dell’utente.
    |
    */
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | Cancella Account
    |--------------------------------------------------------------------------
    |
    | Permette all’utente di eliminare il proprio account in modo permanente.
    |
    */
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
