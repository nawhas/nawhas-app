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

    Route::prefix('reciters/{reciter}/albums/{album}/tracks')->group(function () {
        Route::get('/', 'TracksController@index');
        Route::post('/', 'TracksController@store');
        Route::get('/{track}', 'TracksController@show');
        Route::put('/{track}', 'TracksController@update');
        Route::patch('/{track}', 'TracksController@update');
        Route::delete('/{track}', 'TracksController@destroy');
    });

    Route::prefix('reciters/{reciter}/albums/{album}/tracks/{track}/lyrics')->group(function () {
        Route::get('/', 'LyricsController@index');
        Route::post('/', 'LyricsController@store');
        Route::get('/{lyric}', 'LyricsController@show');
        Route::put('/{lyric}', 'LyricsController@update');
        Route::patch('/{lyric}', 'LyricsController@update');
        Route::delete('/{lyric}', 'LyricsController@destroy');
    });

    Route::prefix('popular')->group(function () {
        Route::get('/reciters', 'LyricsController@index');
    });
});
