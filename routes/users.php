<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Admin\UserManagementController;


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/users')
    ->name('admin.users.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Liste utilisateurs
        |--------------------------------------------------------------------------
        */

        Route::get('/',
            [UserManagementController::class, 'index']
        )->name('index');





        Route::get('/create',
            [UserManagementController::class, 'create']
        )->name('create');


        Route::post('/',
            [UserManagementController::class, 'store']
        )->name('store');



        /*
        |--------------------------------------------------------------------------
        | Voir détail utilisateur
        |--------------------------------------------------------------------------
        */

        Route::get('/{user}',
            [UserManagementController::class, 'show']
        )->name('show');



        /*
        |--------------------------------------------------------------------------
        | Suppression individuelle
        |--------------------------------------------------------------------------
        */

        Route::delete('/{user}',
            [UserManagementController::class, 'destroy']
        )->name('destroy');



        /*
        |--------------------------------------------------------------------------
        | Gestion statut individuel
        |--------------------------------------------------------------------------
        */

        Route::patch('/{user}/status',
            [UserManagementController::class, 'updateStatus']
        )->name('status');



        /*
        |--------------------------------------------------------------------------
        | Gestion rôles individuels
        |--------------------------------------------------------------------------
        */

        Route::patch('/{user}/role',
            [UserManagementController::class, 'updateRole']
        )->name('role');



        /*
        |--------------------------------------------------------------------------
        | Actions multiples
        |--------------------------------------------------------------------------
        */

        Route::post('/bulk-delete',
            [UserManagementController::class, 'bulkDelete']
        )->name('bulkDelete');



        Route::post('/bulk-status',
            [UserManagementController::class, 'bulkStatus']
        )->name('bulkStatus');


    });
