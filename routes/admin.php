<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Academique\EtudiantController;
use App\Http\Controllers\Admin\Academique\FiliereController;
use App\Http\Controllers\Admin\Entreprise\EntrepriseController;
use App\Http\Controllers\Admin\Entreprise\OffreController;
use App\Http\Controllers\Admin\Recrutement\CandidatureController;
use App\Http\Controllers\Admin\Referentiel\CategorieController;
use App\Http\Controllers\Admin\Communication\MessageController;
use App\Http\Controllers\Admin\Admin\ParametreController;
use App\Http\Controllers\Admin\Admin\SignalementController;
use App\Http\Controllers\Admin\StatistiqueController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('etudiants', EtudiantController::class);
        Route::resource('filieres', FiliereController::class);
        Route::resource('entreprises', EntrepriseController::class);
        Route::resource('offres', OffreController::class);
        Route::resource('candidatures', CandidatureController::class);
        Route::resource('categories', CategorieController::class);
        Route::resource('messages', MessageController::class);
        Route::resource('parametres', ParametreController::class);
        Route::resource('signalements', SignalementController::class);
        Route::get('statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
    });