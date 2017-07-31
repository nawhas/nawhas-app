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
        Route::delete('/{reciter}','RecitersController@destroy');
        Route::post('/{reciter}','RecitersController@update');
        Route::get('/{reciter}', 'RecitersController@show');
        Route::post('/','RecitersController@store');
        Route::get('/', 'RecitersController@index');
    });

    Route::prefix('/album')->group(function () {

    });
});
