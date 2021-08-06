<?php

use Illuminate\Support\Facades\Route;

Route::name('dummy-vpos.')
    ->prefix(config('dummy-vpos.route_prefix'))
    ->group(function () {
        Route::get('', 'DummyVpos\Http\DummyVposController@showConfirmation')->name('show');
        Route::post('', 'DummyVpos\Http\DummyVposController@checkConfirmation')->name('check');
    });
