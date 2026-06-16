<?php

use App\Http\Controllers\Front\AlerteOffreController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/mes-alertes', [AlerteOffreController::class, 'index'])
        ->name('front.alertes.index');

    Route::post('/mes-alertes', [AlerteOffreController::class, 'store'])
        ->name('front.alertes.store');

    Route::post('/mes-alertes/toggle', [AlerteOffreController::class, 'toggle'])
        ->name('front.alertes.toggle');

    Route::delete('/mes-alertes', [AlerteOffreController::class, 'destroy'])
        ->name('front.alertes.destroy');
});
