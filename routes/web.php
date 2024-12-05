<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Enregistrer un paiement
    Route::post('/paiement', [PaiementController::class, 'enregistrerPaiement'])->name('paiement.enregistrer');

    // Afficher les paiements d'un utilisateur
    Route::get('/paiements', [PaiementController::class, 'afficherPaiements'])->name('paiements.index');

    // Rembourser un paiement (administrateur uniquement)
    Route::delete('/paiements/{paiement}', [PaiementController::class, 'rembourserPaiement'])->name('paiement.rembourser');
});

require __DIR__.'/auth.php';
