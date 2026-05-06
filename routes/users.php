<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Admin\UserManagementController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/users')
    ->name('admin.users.')
    ->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('{user}', [UserManagementController::class, 'show'])->name('show');

        Route::patch('{user}/status', [UserManagementController::class, 'updateStatus'])
            ->name('status');

        Route::patch('{user}/role', [UserManagementController::class, 'updateRole'])
            ->name('role');
    });