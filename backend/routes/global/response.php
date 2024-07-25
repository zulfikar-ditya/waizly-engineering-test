<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Response File Routes
|--------------------------------------------------------------------------
|
| Here is where you can register response file routes.
|
*/

Route::get('files/{file_name}', [\App\Http\Controllers\Response\ResponseController::class, 'handleResponseFile'])->name('response-file');
