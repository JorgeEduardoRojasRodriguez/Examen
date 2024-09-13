<?php

use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// get, post, put, delete

Route::middleware(EnsureTokenIsValid::class)->group(function () {

    Route::group(['prefix' => 'contactos'], function () {
        Route::get('/', 'ContactosController@index');
        Route::post('/paginate', 'ContactosController@paginate');
        Route::post('/', 'ContactosController@store');
        Route::get('/{id}', 'ContactosController@show');
        Route::put('/{id}', 'ContactosController@update');
        Route::delete('/{id}', 'ContactosController@destroy');
    });

    Route::group(['prefix' => 'telefonos'], function () {
        Route::get('/', 'TelefonosController@index');
        Route::post('/', 'TelefonosController@store');
        Route::get('/{id}', 'TelefonosController@show');
        Route::put('/{id}', 'TelefonosController@update');
        Route::delete('/{id}', 'TelefonosController@destroy');
    });

    Route::group(['prefix' => 'emails'], function () {
        Route::get('/', 'EmailsController@index');
        Route::post('/', 'EmailsController@store');
        Route::get('/{id}', 'EmailsController@show');
        Route::put('/{id}', 'EmailsController@update');
        Route::delete('/{id}', 'EmailsController@destroy');
    });

    Route::group(['prefix' => 'direcciones'], function () {
        Route::get('/', 'DireccionesController@index');
        Route::post('/', 'DireccionesController@store');
        Route::get('/{id}', 'DireccionesController@show');
        Route::put('/{id}', 'DireccionesController@update');
        Route::delete('/{id}', 'DireccionesController@destroy');
    });
});