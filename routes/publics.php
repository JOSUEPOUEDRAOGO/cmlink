<?php

use App\Http\Controllers\Admin\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin|entreprise'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/profils-publics', [PublicProfileController::class, 'index'])
            ->name('profils-publics.index');

        Route::get('/profils-publics/{etudiant}/cv', [PublicProfileController::class, 'downloadCv'])
            ->name('profils-publics.download-cv');

        Route::get('/profils-publics/{etudiant}/lettre', [PublicProfileController::class, 'viewLettre'])
            ->name('profils-publics.lettre');
    });
