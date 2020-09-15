<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api', 'namespace' => 'Api'], function () {
    Route::apiResources([
        'merchants' => 'MerchantsController',
    ]);

    Route::group(['prefix' => 'users'], function () {
        Route::get('', 'UsersController@index')->middleware('user');
        Route::post('', 'UsersController@store');
    });
});
