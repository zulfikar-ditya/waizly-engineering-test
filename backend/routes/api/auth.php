<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
