<?php

use App\Http\Middleware\EnsureUrlIsValid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactosController;
use App\Http\Controllers\TelefonosController;
use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\EmailsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// get, post, put, delete

Route::middleware(EnsureUrlIsValid::class)->group(function () {

    Route::group(['prefix' => 'contactos'], function () {
        Route::get('/', [ContactosController::class, 'index']);
        Route::post('/paginated', [ContactosController::class, 'paginate']);
        Route::post('/', [ContactosController::class, 'store']);
        Route::get('/{id}', [ContactosController::class, 'show']);
        Route::put('/{id}', [ContactosController::class, 'update']);
        Route::delete('/{id}', [ContactosController::class, 'destroy']);
    });

    Route::group(['prefix' => 'telefonos'], function () {
        Route::get('/', [TelefonosController::class, 'index']);
        Route::post('/', [TelefonosController::class, 'store']);
        Route::get('/{id}', [TelefonosController::class, 'show']);
        Route::put('/{id}', [TelefonosController::class, 'update']);
        Route::delete('/{id}', [TelefonosController::class, 'destroy']);
    });

    Route::group(['prefix' => 'emails'], function () {
        Route::get('/', [EmailsController::class, 'index']);
        Route::post('/', [EmailsController::class, 'store']);
        Route::get('/{id}', [EmailsController::class, 'show']);
        Route::put('/{id}', [EmailsController::class, 'update']);
        Route::delete('/{id}', [EmailsController::class, 'destroy']);
    });

    Route::group(['prefix' => 'direcciones'], function () {
        Route::get('/', [DireccionesController::class, 'index']);
        Route::post('/', [DireccionesController::class, 'store']);
        Route::get('/{id}', [DireccionesController::class, 'show']);
        Route::put('/{id}', [DireccionesController::class, 'update']);
        Route::delete('/{id}', [DireccionesController::class, 'destroy']);
    });
});
