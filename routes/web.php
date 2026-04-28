<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OffreFrontController;
use App\Http\Controllers\Front\EntrepriseFrontController;
use App\Http\Controllers\Front\EtudiantFrontController;

Route::get('/', [HomeController::class, 'index'])->name('front.home');

Route::get('/offres', [OffreFrontController::class, 'index'])->name('front.offres.index');
Route::get('/offres/{offre}', [OffreFrontController::class, 'show'])->name('front.offres.show');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/entreprises', [EntrepriseFrontController::class, 'index'])->name('front.entreprises.index');
Route::get('/entreprises/{entreprise}', [EntrepriseFrontController::class, 'show'])->name('front.entreprises.show');

Route::get('/etudiants', [EtudiantFrontController::class, 'index'])->name('front.etudiants.index');
Route::get('/etudiants/{etudiant}', [EtudiantFrontController::class, 'show'])->name('front.etudiants.show');

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
