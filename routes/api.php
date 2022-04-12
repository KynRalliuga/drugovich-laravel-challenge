<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CustomerController;

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

Route::middleware(['auth.jwt'])->group(function () {
    Route::prefix('group')->controller(GroupController::class)->group(function () {
        Route::get('/', 'get');
        Route::get('/{id}', 'getById');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
    });

    Route::prefix('customer')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'get');
        Route::get('/{id}', 'getById');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
    });
});
