<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Admin\SanctionController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/sanctions')
    ->name('admin.sanctions.')
    ->group(function () {
        Route::get('/', [SanctionController::class, 'index'])->name('index');
        Route::get('/create', [SanctionController::class, 'create'])->name('create');
        Route::post('/', [SanctionController::class, 'store'])->name('store');
        Route::get('/{sanction}', [SanctionController::class, 'show'])->name('show');
        Route::delete('/{sanction}', [SanctionController::class, 'destroy'])->name('destroy');
    });