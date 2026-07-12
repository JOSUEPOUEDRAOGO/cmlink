<?php

use App\Http\Controllers\Admin\Admin\RoleManagementController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Page IAM principale
        Route::get('roles', [RoleManagementController::class, 'index'])
            ->name('roles.index');

        // Rôles
        Route::post('roles', [RoleManagementController::class, 'store'])
            ->name('roles.store');
        Route::patch('roles/{role}', [RoleManagementController::class, 'update'])
            ->name('roles.update');
        Route::delete('roles/{role}', [RoleManagementController::class, 'destroy'])
            ->name('roles.destroy');

        // Permissions
        Route::post('permissions', [RoleManagementController::class, 'storePermission'])
            ->name('permissions.store');
        Route::patch('permissions/{permission}', [RoleManagementController::class, 'updatePermission'])
            ->name('permissions.update');
        Route::delete('permissions/{permission}', [RoleManagementController::class, 'destroyPermission'])
            ->name('permissions.destroy');

        // Attribution / Retrait des accès
        Route::post('access/give', [RoleManagementController::class, 'giveAccess'])
            ->name('access.give');
        Route::post('access/revoke', [RoleManagementController::class, 'revokeAccess'])
            ->name('access.revoke');
    });
