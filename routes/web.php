<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OffreFrontController;
use App\Http\Controllers\Front\EntrepriseFrontController;
use App\Http\Controllers\Front\EtudiantFrontController;
use App\Http\Controllers\Front\CandidatureController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Front\FooterController;

$user = Auth::user();

Route::get('/', [HomeController::class, 'index'])->name('front.home');

Route::get('/offres', [OffreFrontController::class, 'index'])->name('front.offres.index');
Route::get('/offres/{offre}', [OffreFrontController::class, 'show'])->name('front.offres.show');

Route::get('/entreprises', [EntrepriseFrontController::class, 'index'])->name('front.entreprises.index');
Route::get('/entreprises/{entreprise}', [EntrepriseFrontController::class, 'show'])->name('front.entreprises.show');

Route::get('/etudiants', [EtudiantFrontController::class, 'index'])->name('front.etudiants.index');
Route::get('/etudiants/{etudiant}', [EtudiantFrontController::class, 'show'])->name('front.etudiants.show');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('entreprise')) {
        return redirect()->route('admin.offres.index');
    }

    if ($user->hasRole('etudiant')) {
        return redirect()->route('front.offres.index');
    }

    return redirect()->route('front.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:etudiant|admin'])->group(function () {
    Route::get('/offres/{offre}/postuler', [CandidatureController::class, 'create'])
        ->name('front.offres.apply');

    Route::post('/offres/{offre}/postuler', [CandidatureController::class, 'store'])
        ->name('front.offres.postuler');
});

Route::controller(FooterController::class)->group(function () {

    Route::get('/cgu', 'cgu')->name('cgu');

    Route::get('/politique-de-confidentialite', 'pdc')->name('pdc');

    Route::get('/support', 'support')->name('support');

});
Route::get('/legal/{slug}', [FooterController::class, 'show'])
    ->name('legal.show');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/users.php';
require __DIR__.'/roles.php';
require __DIR__.'/sanctions.php';
require __DIR__ . '/candidatures.php';
require __DIR__.'/publics.php';
require __DIR__.'/api.php';
require __DIR__.'/alertes.php';
