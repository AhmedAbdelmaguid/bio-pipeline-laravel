<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Qui registriamo tutte le rotte web dell'applicazione.
| Laravel Breeze gestisce l'autenticazione e il profilo utente,
| mentre noi aggiungiamo la dashboard e la gestione dei progetti.
|
*/

/*
|--------------------------------------------------------------------------
| Home Pubblica
|--------------------------------------------------------------------------
|
| Questa è la pagina iniziale del sito, visibile a tutti.
| Mostra la view "welcome.blade.php" che include i link a Login/Register
| se le rotte di autenticazione sono definite.
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Area Autenticata (protetta da login e email verificata)
|--------------------------------------------------------------------------
|
| Tutte le rotte all’interno di questo gruppo richiedono che
| l’utente sia autenticato e, se necessario, abbia verificato l’email.
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    |
    | Mostra la dashboard personale dell’utente autenticato.
    | Il controller è "invocabile" (usa il metodo __invoke()).
    |
    */
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Gestione Progetti
    |--------------------------------------------------------------------------
    |
    | CRUD completa dei progetti appartenenti all’utente loggato.
    | Verranno create automaticamente tutte le rotte:
    |   GET     /projects           → index
    |   GET     /projects/create    → create
    |   POST    /projects           → store
    |   GET     /projects/{id}      → show
    |   GET     /projects/{id}/edit → edit
    |   PUT     /projects/{id}      → update
    |   DELETE  /projects/{id}      → destroy
    |
    */
    Route::resource('projects', ProjectController::class);
    // Salvataggio pipeline (JSON) di un progetto
    Route::put('/projects/{project}/pipeline', [ProjectController::class, 'pipeline'])->name('projects.pipeline');

    /*
    |--------------------------------------------------------------------------
    | Gestione Profilo Utente
    |--------------------------------------------------------------------------
    |
    | Permette di modificare nome utente, password o cancellare l’account.
    | Queste rotte sono collegate al ProfileController generato da Breeze.
    |
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rotte di Autenticazione (Breeze)
|--------------------------------------------------------------------------
|
| Includiamo tutte le rotte di login, registrazione, reset password,
| verifica email e logout generate automaticamente da Laravel Breeze.
|
*/

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Rotte di Gestione Profilo (Breeze)
|--------------------------------------------------------------------------
|
| Includiamo anche il file "profile.php" che gestisce
| le operazioni sul profilo utente (edit/update/delete).
|
*/

require __DIR__ . '/profile.php';
