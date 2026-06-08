<?php

use App\Http\Controllers\Recrutement\EtudiantCvController;
use App\Http\Controllers\Recrutement\LettreMotivationController;
use App\Http\Controllers\Recrutement\MesCandidaturesController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('candidatures')->name('candidatures.')->group(function () {
    // ========== Gestion du CV (store & update combinés) ==========
    Route::post('/cv', EtudiantCvController::class)->name('cv.store');
    Route::put('/cv', EtudiantCvController::class)->name('cv.update');
    Route::patch('/cv', EtudiantCvController::class)->name('cv.update.patch');

    // ========== Gestion de la lettre de motivation (store & update combinés) ==========
    Route::post('/lettre', LettreMotivationController::class)->name('lettre.store');
    Route::put('/lettre', LettreMotivationController::class)->name('lettre.update');
    Route::patch('/lettre', LettreMotivationController::class)->name('lettre.update.patch');
});

Route::middleware(['auth'])->prefix('mes-candidatures')->name('admin.mes-candidatures.')->group(function () {

    // Liste principale (toutes les candidatures)
    Route::get('/', [MesCandidaturesController::class, 'index'])->name('index');

    // Filtres par statut
    Route::get('/acceptees', [MesCandidaturesController::class, 'acceptees'])->name('acceptees');
    Route::get('/refusees', [MesCandidaturesController::class, 'refusees'])->name('refusees');
    Route::get('/attente', [MesCandidaturesController::class, 'enAttente'])->name('attente');

    // Gestion du CV
    Route::get('/cv', [MesCandidaturesController::class, 'cv'])->name('cv');
    Route::post('/cv', [MesCandidaturesController::class, 'storeCv'])->name('cv.store');
    Route::put('/cv', [MesCandidaturesController::class, 'updateCv'])->name('cv.update');
    Route::delete('/cv', [MesCandidaturesController::class, 'destroyCv'])->name('cv.destroy');

    // Gestion des lettres de motivation
    Route::get('/motivations', [MesCandidaturesController::class, 'motivations'])->name('motivations');
    Route::post('/motivations', [MesCandidaturesController::class, 'storeMotivation'])->name('motivations.store');
    Route::put('/motivations', [MesCandidaturesController::class, 'updateMotivation'])->name('motivations.update');
    Route::delete('/motivations', [MesCandidaturesController::class, 'destroyMotivation'])->name('motivations.destroy');

    // Détail d'une candidature
    Route::get('/candidature/{candidature}', [MesCandidaturesController::class, 'show'])->name('show');

    // Suppression d'une candidature (un seul DELETE)
    Route::delete('/candidature/{candidature}', [MesCandidaturesController::class, 'destroy'])->name('destroy');
    Route::patch('/cv/visibility', [MesCandidaturesController::class, 'updateCvVisibility'])->name('cv.visibility');
    // Gestion de la visibilité de la lettre de motivation
    Route::patch('/motivations/visibility', [MesCandidaturesController::class, 'updateMotivationVisibility'])->name('motivations.visibility');
});
