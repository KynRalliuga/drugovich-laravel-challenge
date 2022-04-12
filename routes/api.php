<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\GroupController;

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

Route::prefix('manager')->group(function () {
    Route::controller(ManagerController::class)->group(function () {
        Route::post('/login', 'authenticate');
    });
});

Route::middleware(['auth.jwt'])->prefix('group')->group(function () {
    Route::controller(GroupController::class)->group(function () {
        Route::get('/', 'get');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
    });
});
