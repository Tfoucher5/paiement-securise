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
Route::middleware('throttle:3,1')->group(function () {
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
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes des paiements
    Route::get('/paiement', [PaiementController::class, 'index'])->name('paiement.index');
    Route::get('/paiement/create', [PaiementController::class, 'create'])->name('paiement.create');
    Route::post('/paiement', [PaiementController::class, 'store'])
        ->name('paiement.store')
        ->middleware('throttle:2,1');

    // Routes des cartes de crédit
    Route::get('/carte-credit', [CarteCreditController::class, 'index'])->name('carte-credit.index');
    Route::get('/carte-credit/create', [CarteCreditController::class, 'create'])->name('carte-credit.create');
    Route::delete('/carte-credit/destroy/{carteCredit}', [CarteCreditController::class, 'destroy'])->name('carte-credit.destroy');
    Route::post('/carte-credit', [CarteCreditController::class, 'store'])
        ->name('carte-credit.store')
        ->middleware('throttle:2,1');


    // Routes des remboursements
    Route::get('/remboursement', [RemboursementController::class, 'index'])->name('remboursement.index');
    Route::get('/remboursement/create', [RemboursementController::class, 'create'])->name('remboursement.create');
    Route::post('/remboursement', [RemboursementController::class, 'store'])
        ->name('remboursement.store')
        ->middleware('throttle:3,1');

});

// Routes du profil accessibles sans throttling supplémentaire
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';
