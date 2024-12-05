<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CarteCreditController;
use App\Http\Controllers\RemboursementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login ');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('paiement', PaiementController::class);
    Route::resource('carte-credit', CarteCreditController::class);
    Route::resource('remboursement', RemboursementController::class);

});

require __DIR__.'/auth.php';
