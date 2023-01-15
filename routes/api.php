<?php

use App\Http\Controllers\RuWordController;
use App\Http\Controllers\EngWordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('ru')->group(function ()
{
    Route::apiResource('words', RuWordController::class);
});

Route::prefix('en')->group(function ()
{
    Route::apiResource('words', EngWordController::class);
});