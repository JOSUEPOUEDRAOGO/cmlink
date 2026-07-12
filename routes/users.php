<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Admin\UserManagementController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/users')
    ->name('admin.users.')
    ->group(function () {

        Route::get('/', [UserManagementController::class, 'index'])->name('index');

        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');

        Route::get('/{user}', [UserManagementController::class, 'show'])->name('show');

        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');

        Route::patch('/{user}/status', [UserManagementController::class, 'updateStatus'])->name('status');

        Route::patch('/{user}/role', [UserManagementController::class, 'updateRole'])->name('role');

        // ← Nouveau
        Route::patch('/{user}/permissions', [UserManagementController::class, 'updatePermissions'])->name('permissions');

        Route::post('/bulk-delete', [UserManagementController::class, 'bulkDelete'])->name('bulkDelete');
        Route::post('/bulk-status', [UserManagementController::class, 'bulkStatus'])->name('bulkStatus');

    });
