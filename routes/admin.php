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

        // Dashboard - Réservé aux admins uniquement
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware('role:admin')
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Routes réservées aux ADMIN uniquement
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:admin')->group(function () {
            // Gestion des étudiants
            Route::resource('etudiants', EtudiantController::class);

            // Gestion des filières
            Route::resource('filieres', FiliereController::class);

            // Gestion des entreprises (admin voit toutes les entreprises)
            Route::resource('entreprises', EntrepriseController::class);

            // Gestion des catégories
            Route::resource('categories', CategorieController::class)
                ->parameters(['categories' => 'categorie']);

            // Gestion des messages
            Route::resource('messages', MessageController::class);

            // Paramètres généraux
            Route::resource('parametres', ParametreController::class);

            // Signalements
            Route::resource('signalements', SignalementController::class);

            // Statistiques
            Route::get('statistiques', [StatistiqueController::class, 'index'])
                ->name('statistiques.index');

            // Pages statiques
            Route::get('pages/home', [PageController::class, 'home'])
                ->name('pages.home');
            Route::post('pages/home', [PageController::class, 'updateHome'])
                ->name('pages.home.update');
        });

        /*
        |--------------------------------------------------------------------------
        | Routes accessibles aux ADMIN et ENTREPRISE
        |--------------------------------------------------------------------------
        */

        // ROUTES POUR LES OFFRES (avec protection spécifique)
        // Index - Liste des offres (filtrée automatiquement dans le contrôleur)
        Route::get('offres', [OffreController::class, 'index'])
            ->name('offres.index');

        // Create - Formulaire de création
        Route::get('offres/create', [OffreController::class, 'create'])
            ->name('offres.create');

        // Store - Enregistrement d'une nouvelle offre
        Route::post('offres', [OffreController::class, 'store'])
            ->name('offres.store');

        // Routes PROTÉGÉES par le middleware check.offre.access
        // Ces routes vérifient que l'entreprise possède bien l'offre
        Route::middleware(['check.offre.access'])->group(function () {
            // Show - Détails d'une offre
            Route::get('offres/{offre}', [OffreController::class, 'show'])
                ->name('offres.show');

            // Edit - Formulaire d'édition
            Route::get('offres/{offre}/edit', [OffreController::class, 'edit'])
                ->name('offres.edit');

            // Update - Mise à jour
            Route::put('offres/{offre}', [OffreController::class, 'update'])
                ->name('offres.update');
            Route::patch('offres/{offre}', [OffreController::class, 'update'])
                ->name('offres.update.patch');

            // Destroy - Suppression
            Route::delete('offres/{offre}', [OffreController::class, 'destroy'])
                ->name('offres.destroy');

            // Duplicate - Duplication d'une offre
            Route::post('offres/{offre}/duplicate', [OffreController::class, 'duplicate'])
                ->name('offres.duplicate');

            // Change Status - Changer le statut
            Route::patch('offres/{offre}/status/{status}', [OffreController::class, 'changeStatus'])
                ->name('offres.status');

            // Reset Views - Réinitialiser les vues
            Route::post('offres/{offre}/reset-views', [OffreController::class, 'resetViews'])
                ->name('offres.reset-views');
        });

        /*
|--------------------------------------------------------------------------
| Routes pour les candidatures
|--------------------------------------------------------------------------
*/

        Route::prefix('candidatures')
            ->name('candidatures.')
            ->controller(CandidatureController::class)
            ->group(function () {

                // Routes publiques (avec filtrage dans le contrôleur)
                Route::get('/', 'index')->name('index');
                Route::get('/export', 'export')->name('export');
                Route::get('/stats', 'stats')->name('stats');

                // Routes protégées par middleware
                Route::middleware(['check.candidature.access'])->group(function () {

                    // Consultation
                    Route::get('{candidature}', 'show')->name('show');
                    Route::get('{candidature}/cv', 'downloadCv')->name('download-cv');
                    Route::get('{candidature}/history', 'history')->name('history');

                    // Modifications
                    Route::patch('{candidature}/status', 'updateStatus')->name('status');
                    Route::delete('{candidature}', 'destroy')->name('destroy');

                    // Actions rapides
                    Route::post('{candidature}/accept', 'accept')->name('accept');
                    Route::post('{candidature}/reject', 'reject')->name('reject');
                    Route::post('{candidature}/pending', 'pending')->name('pending');

                    // Notes
                    Route::post('{candidature}/note', 'addNote')->name('add-note');
                });
            });
    });
