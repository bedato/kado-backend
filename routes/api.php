<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'namespace' => 'Api'], function () {
    Route::apiResources([
        'merchants' => 'MerchantsController',
        'colors' => 'ColorsController',
        'items' => 'ItemsController',
        'styles' => 'StylesController',
        'shapes' => 'ShapesController',
        'outfits' => 'OutfitsController'
    ]);

    Route::group(['prefix' => 'users'], function () {
        Route::get('', 'UsersController@index')->middleware('user');
        Route::post('', 'UsersController@store');
        Route::delete('users/{id}', 'UsersController@destroy');
    });

    Route::group(['middleware' => 'user'], function () {
        Route::get('posts', 'PostsController@index');
        Route::post('posts', 'PostsController@store');
        Route::delete('posts/{id}', 'PostsController@destroy');
    });
});
