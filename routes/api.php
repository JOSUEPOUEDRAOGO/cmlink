<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route utilisateur authentifié
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes broadcasting auth (pour les canaux privés Pusher)
Route::post('/broadcasting/auth', function (Request $request) {
    return broadcast()->auth($request);
})->middleware('auth');
