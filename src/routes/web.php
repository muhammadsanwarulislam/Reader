<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'Centerpoint\Reader\Http\Controllers'], function() {
    Route::get('index','ReaderController@index');
});