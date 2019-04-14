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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('logout', 'AuthController@logout');
Route::namespace('Api')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', 'UsersController@show');
    });

    // reciter routes
    Route::prefix('reciters')->group(function () {
        Route::get('/', 'RecitersController@index');
        Route::post('/', 'RecitersController@store');
        Route::get('/{reciter}', 'RecitersController@show');
        Route::post('/{reciter}', 'RecitersController@update');
        Route::patch('/{reciter}', 'RecitersController@update');
        Route::delete('/{reciter}', 'RecitersController@destroy');
    });

    // Album Routes
    Route::prefix('reciters/{reciter}/albums')->group(function () {
        Route::get('/', 'AlbumsController@index');
        Route::post('/', 'AlbumsController@store');
        Route::get('/{album}', 'AlbumsController@show');
        Route::post('/{album}', 'AlbumsController@update');
        Route::patch('/{album}', 'AlbumsController@update');
        Route::delete('/{album}', 'AlbumsController@destroy');
    });

    // tracks routes
    Route::prefix('reciters/{reciter}/albums/{album}/tracks')->group(function () {
        Route::get('/', 'TracksController@index');
        Route::post('/', 'TracksController@store');
        Route::get('/{track}', 'TracksController@show');
        Route::put('/{track}', 'TracksController@update');
        Route::patch('/{track}', 'TracksController@update');
        Route::post('/{track}', 'TracksController@update');
        Route::delete('/{track}', 'TracksController@destroy');
    });

    // lyrics routes
    Route::prefix('reciters/{reciter}/albums/{album}/tracks/{track}/lyrics')->group(function () {
        Route::get('/', 'LyricsController@index');
        Route::post('/', 'LyricsController@store');
        Route::get('/{lyric}', 'LyricsController@show');
        Route::put('/{lyric}', 'LyricsController@update');
        Route::patch('/{lyric}', 'LyricsController@update');
        Route::post('/{lyric}', 'LyricsController@update');
        Route::delete('/{lyric}', 'LyricsController@destroy');
    });

    // Language Routes
    Route::prefix('languages')->group(function () {
        Route::get('/', 'LanguagesController@index');
    });

    // Popular Routes
    Route::prefix('popular')->group(function () {
        Route::get('/reciters', 'PopularEntitiesController@reciters');
        Route::get('/albums', 'PopularEntitiesController@albums');
        Route::get('/tracks', 'PopularEntitiesController@tracks');
    });
});
