<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['api'])->group(base_path('routes/global/response.php'));
Route::middleware(['api'])->group(base_path('routes/api/auth.php'));
Route::middleware(['api', 'auth'])->prefix('admin')->as('admin.')->group(base_path('routes/api/admin.php'));
