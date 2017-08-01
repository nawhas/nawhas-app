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
            //album routes
            Route::prefix('/albums')->group(function () {
                Route::post('/{album/update', 'AlbumsController@update');
                Route::delete('/{album}/destroy', 'AlbumsController@destroy');
                Route::get('/{album}', 'AlbumsController@show');
                Route::post('/add', 'AlbumsController@store');
                Route::get('/', 'AlbumsController@index');
            });
            //end album routes
            //{reciter} routes
            Route::delete('/', 'RecitersController@destroy');
            Route::put('/', 'RecitersController@update');
            Route::patch('/', 'RecitersController@update');
            Route::get('/', 'RecitersController@show');
            //end {reciter} routes
        });
        Route::post('/', 'RecitersController@store');
        Route::get('/', 'RecitersController@index');
    });
});
