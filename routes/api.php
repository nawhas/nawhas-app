<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
    Route::prefix('reciters')->group(function () {
        Route::get('/', 'RecitersController@index');
        Route::post('/', 'RecitersController@store');
        Route::get('/{reciter}', 'RecitersController@show');
        Route::put('/{reciter}', 'RecitersController@update');
        Route::patch('/{reciter}', 'RecitersController@update');
        Route::delete('/{reciter}', 'RecitersController@destroy');
    });

    // Album Routes
    Route::prefix('reciters/{reciter}/albums')->group(function () {
        Route::get('/', 'AlbumsController@index');
        Route::post('/', 'AlbumsController@store');
        Route::get('/{album}', 'AlbumsController@show');
        Route::put('/{album}', 'AlbumsController@update');
        Route::patch('/{album}', 'AlbumsController@update');
        Route::delete('/{album}', 'AlbumsController@destroy');
    });
});
