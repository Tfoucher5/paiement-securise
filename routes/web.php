<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CarteCreditController;
use App\Http\Controllers\RemboursementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Protection contre le Brute Force pour les routes de connexion et d'authentification
Route::middleware('throttle:50000000,1')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    });

    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    // Ajouter d'autres routes d'authentification si nécessaire
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Protection contre le Brute Force pour les autres routes sensibles
Route::middleware(['auth', 'throttle:50000000,1'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes des paiements
    Route::resource('/paiement', PaiementController::class);

    // Routes des cartes de crédit
    Route::resource('/carte-credit', CarteCreditController::class);

    // Routes des remboursements
    Route::resource('/remboursement', RemboursementController::class);

});

require __DIR__.'/auth.php';
