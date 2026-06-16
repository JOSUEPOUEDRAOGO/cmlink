<?php

return [
    App\Providers\AppServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    App\Providers\ViewServiceProvider::class, // ← ViewServiceProvider en dernier
];
