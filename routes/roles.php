<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Admin\RoleManagementController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/roles')
    ->name('admin.roles.')
    ->group(function () {
        Route::get('/', [RoleManagementController::class, 'index'])->name('index');
        Route::get('/create', [RoleManagementController::class, 'create'])->name('create');
        Route::post('/', [RoleManagementController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RoleManagementController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleManagementController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleManagementController::class, 'destroy'])->name('destroy');
    });