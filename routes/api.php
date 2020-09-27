<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'namespace' => 'Api'], function () {
    Route::apiResources([
        'merchants' => 'MerchantsController',
        'colors' => 'ColorsController',
        'items' => 'ItemsController',
        'styles' => 'StylesController',
        'shapes' => 'ShapesController'
    ]);

    Route::group(['prefix' => 'users'], function () {
        Route::get('', 'UsersController@index')->middleware('user');
        Route::post('', 'UsersController@store');
        Route::delete('users/{id}', 'UsersController@destroy');
    });
});
