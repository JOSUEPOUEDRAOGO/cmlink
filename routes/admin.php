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
use App\Http\Controllers\Admin\PageController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin|entreprise'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware('role:admin')
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Admin uniquement
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:admin')->group(function () {
            Route::resource('etudiants', EtudiantController::class);
            Route::resource('filieres', FiliereController::class);
            Route::resource('entreprises', EntrepriseController::class);

            Route::resource('categories', CategorieController::class)
                ->parameters([
                    'categories' => 'categorie',
                ]);

            Route::resource('messages', MessageController::class);
            Route::resource('parametres', ParametreController::class);
            Route::resource('signalements', SignalementController::class);

            Route::get('statistiques', [StatistiqueController::class, 'index'])
                ->name('statistiques.index');

            Route::get('pages/home', [PageController::class, 'home'])
                ->name('pages.home');

            Route::post('pages/home', [PageController::class, 'updateHome'])
                ->name('pages.home.update');
        });

        /*
        |--------------------------------------------------------------------------
        | Admin + Entreprise
        |--------------------------------------------------------------------------
        */
        Route::resource('offres', OffreController::class);

        Route::patch('candidatures/{candidature}/status', [CandidatureController::class, 'updateStatus'])
            ->name('candidatures.status');

        Route::resource('candidatures', CandidatureController::class)
            ->only(['index', 'show', 'destroy']);
    });