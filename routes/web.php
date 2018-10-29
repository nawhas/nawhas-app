<?php

Route::get('/{any}', function () {
    return view('layouts.vue');
})->where('any', '.*');

Auth::routes();
