<?php

use App\Http\Controllers\Client\ArticleController;
use App\Http\Controllers\Client\ArticleTagController;
use Illuminate\Support\Facades\Route;

Route::get('article', [ArticleController::class, 'index'])->name('article.index');
Route::get('article/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('article-tag', [ArticleTagController::class, 'index'])->name('article-tag.index');
