<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Academique\EtudiantController;
use App\Http\Controllers\Admin\Academique\FiliereController;
use App\Http\Controllers\Admin\Entreprise\EntrepriseController;
use App\Http\Controllers\Admin\Entreprise\OffreController as EntrepriseOffreController;
use App\Http\Controllers\Admin\OffreController as AdminOffreController;
use App\Http\Controllers\Admin\Recrutement\CandidatureController;
use App\Http\Controllers\Admin\Referentiel\CategorieController;
use App\Http\Controllers\Admin\Communication\MessageController;
use App\Http\Controllers\Admin\Admin\ParametreController;
use App\Http\Controllers\Admin\Admin\SignalementController;
use App\Http\Controllers\Admin\StatistiqueController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\CompetenceController;
use App\Http\Controllers\Admin\EntretienController;
use App\Http\Controllers\Admin\FavoriController;
use App\Http\Controllers\Admin\PublicProfileController;
use App\Http\Controllers\Admin\MonProfilController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin|entreprise|etudiant']) // ← ajouter etudiant ici
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware('role:admin')
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Routes réservées aux ADMIN uniquement
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:admin')->group(function () {
            Route::resource('etudiants', EtudiantController::class);
            Route::resource('filieres', FiliereController::class);
            Route::resource('entreprises', EntrepriseController::class);
            Route::resource('categories', CategorieController::class)
                ->parameters(['categories' => 'categorie']);
            Route::resource('messages', MessageController::class);
            // Remplacer Route::resource('parametres', ParametreController::class) par :
            Route::get('parametres', [ParametreController::class, 'index'])
                ->name('parametres.index');
            Route::post('parametres', [ParametreController::class, 'update'])
                ->name('parametres.update');
            Route::post('parametres/maintenance', [ParametreController::class, 'toggleMaintenance'])
                ->name('parametres.maintenance');
            Route::resource('signalements', SignalementController::class);

            Route::get('statistiques', [StatistiqueController::class, 'index'])
                ->name('statistiques.index');

            Route::get('pages/home', [PageController::class, 'home'])
                ->name('pages.home');
            Route::post('pages/home', [PageController::class, 'updateHome'])
                ->name('pages.home.update');

            Route::resource('competences', CompetenceController::class);
        });

        /*
        |--------------------------------------------------------------------------
        | Routes accessibles aux ADMIN et ENTREPRISE
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:admin|entreprise')->group(function () {

            // Offres
            Route::get('offres', [AdminOffreController::class, 'index'])->name('offres.index');
            Route::get('offres/create', [AdminOffreController::class, 'create'])->name('offres.create');
            Route::post('offres', [AdminOffreController::class, 'store'])->name('offres.store');

            Route::middleware(['check.offre.access'])->group(function () {
                Route::get('offres/{offre}', [AdminOffreController::class, 'show'])->name('offres.show');
                Route::get('offres/{offre}/edit', [AdminOffreController::class, 'edit'])->name('offres.edit');
                Route::put('offres/{offre}', [AdminOffreController::class, 'update'])->name('offres.update');
                Route::patch('offres/{offre}', [AdminOffreController::class, 'update'])->name('offres.update.patch');
                Route::delete('offres/{offre}', [AdminOffreController::class, 'destroy'])->name('offres.destroy');
                Route::post('offres/{offre}/duplicate', [EntrepriseOffreController::class, 'duplicate'])->name('offres.duplicate');
                Route::patch('offres/{offre}/status/{status}', [EntrepriseOffreController::class, 'changeStatus'])->name('offres.status');
                Route::post('offres/{offre}/reset-views', [EntrepriseOffreController::class, 'resetViews'])->name('offres.reset-views');
            });

            // Candidatures
            Route::prefix('candidatures')
                ->name('candidatures.')
                ->controller(CandidatureController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/export', 'export')->name('export');
                    Route::get('/stats', 'stats')->name('stats');

                    Route::middleware(['check.candidature.access'])->group(function () {
                        Route::get('{candidature}', 'show')->name('show');
                        Route::get('{candidature}/cv', 'downloadCv')->name('download-cv');
                        Route::get('{candidature}/history', 'history')->name('history');
                        Route::patch('{candidature}/status', 'updateStatus')->name('status');
                        Route::delete('{candidature}', 'destroy')->name('destroy');
                        Route::post('{candidature}/accept', 'accept')->name('accept');
                        Route::post('{candidature}/reject', 'reject')->name('reject');
                        Route::post('{candidature}/pending', 'pending')->name('pending');
                        Route::post('{candidature}/note', 'addNote')->name('add-note');
                    });
                });

            Route::resource('entretiens', EntretienController::class);
        });

        /*
        |--------------------------------------------------------------------------
        | Routes réservées aux ÉTUDIANTS uniquement
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:etudiant')->group(function () {

            // Mon profil
            Route::get('mon-profil', [MonProfilController::class, 'index'])
                ->name('mon-profil.index');
            Route::patch('mon-profil', [MonProfilController::class, 'update'])
                ->name('mon-profil.update');

            // Compétences du profil
            Route::post('mon-profil/competences', [MonProfilController::class, 'ajouterCompetence'])
                ->name('mon-profil.competences.store');
            Route::patch('mon-profil/competences/{competence}', [MonProfilController::class, 'updateCompetence'])
                ->name('mon-profil.competences.update');
            Route::delete('mon-profil/competences/{competence}', [MonProfilController::class, 'retirerCompetence'])
                ->name('mon-profil.competences.destroy');

            // Visibilité
            Route::patch('mon-profil/toggle-cv', [MonProfilController::class, 'toggleCvPublic'])
                ->name('mon-profil.toggle-cv');
            Route::patch('mon-profil/toggle-lettre', [MonProfilController::class, 'toggleLettrePublic'])
                ->name('mon-profil.toggle-lettre');

            // Favoris
            Route::get('favoris', [FavoriController::class, 'index'])->name('favoris.index');
            Route::post('favoris', [FavoriController::class, 'store'])->name('favoris.store');
            Route::delete('favoris/{favori}', [FavoriController::class, 'destroy'])->name('favoris.destroy');





Route::get('mon-profil-public', [PublicProfileController::class, 'monProfil'])
        ->name('mon-profil-public.index');

    Route::post('mon-profil-public/cv', [PublicProfileController::class, 'storeCv'])
        ->name('mon-profil-public.cv.store');
    Route::patch('mon-profil-public/cv/{cv}/principal', [PublicProfileController::class, 'setCvPrincipal'])
        ->name('mon-profil-public.cv.principal');
    Route::delete('mon-profil-public/cv/{cv}', [PublicProfileController::class, 'destroyCv'])
        ->name('mon-profil-public.cv.destroy');

    Route::patch('mon-profil-public/toggle-cv', [PublicProfileController::class, 'toggleMonCv'])
        ->name('mon-profil-public.toggle-cv');
    Route::patch('mon-profil-public/toggle-lettre', [PublicProfileController::class, 'toggleMaLettre'])
        ->name('mon-profil-public.toggle-lettre');
    Route::patch('mon-profil-public/toggle-photo', [PublicProfileController::class, 'togglePhoto'])
        ->name('mon-profil-public.toggle-photo');







        });
    });
