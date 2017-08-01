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
    Route::prefix('/reciters')->group(function () {
        Route::prefix('/{reciter}')->group(function () {
            Route::delete('/', 'RecitersController@destroy');
            Route::post('/', 'RecitersController@update');
            Route::get('/', 'RecitersController@show');
            Route::get('/album', 'AlbumsController@index');
            Route::post('/album', 'AlbumsController@store');
            Route::prefix('/{album_year}')->group(function () {
                Route::post('/update', 'AlbumsController@update');
                Route::get('/', 'AlbumsController@show');
            });
        });
        Route::post('/', 'RecitersController@store');
        Route::get('/', 'RecitersController@index');
    });
});
