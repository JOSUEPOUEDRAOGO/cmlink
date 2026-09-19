<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

use App\Http\Middleware\CheckOffreAccess;
use App\Http\Middleware\CheckCandidatureAccess;
use App\Http\Middleware\TrackUserActivity;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:      __DIR__ . '/../routes/web.php',
        api:      __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health:   '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'role'                     => RoleMiddleware::class,
            'permission'               => PermissionMiddleware::class,
            'role_or_permission'       => RoleOrPermissionMiddleware::class,
            'check.offre.access'       => CheckOffreAccess::class,
            'check.candidature.access' => CheckCandidatureAccess::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Suivi de présence des utilisateurs
        |--------------------------------------------------------------------------
        |
        | Met à jour users.last_seen_at lorsqu'un utilisateur authentifié
        | effectue une requête sur le site.
        |
        */
        $middleware->web(append: [
            TrackUserActivity::class,
        ]);

        // Faire confiance au proxy Railway pour détecter le HTTPS
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
