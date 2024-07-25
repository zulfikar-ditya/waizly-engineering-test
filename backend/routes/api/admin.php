<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ArticleTagController;
use Illuminate\Support\Facades\Route;

Route::apiResource('article', ArticleController::class);
Route::apiResource('article-tag', ArticleTagController::class);
