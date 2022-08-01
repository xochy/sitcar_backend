<?php

use App\Http\Controllers\Api\LoginController;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

JsonApi::register('v1')->withNamespace('Api')->routes(function ($api) {
    $api->resource('users')->relationships(function ($api) {
        $api->hasMany('roles')->except('replace', 'add', 'remove');
    });

    $api->resource('roles')->relationships(function ($api) {
        $api->hasMany('users');
    });

    $api->resource('cars');

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('guest:sanctum')
        ->name('login');

    Route::post('/register', [RegisterController::class, 'register'])
        ->middleware('guest:sanctum')
        ->name('register');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [LoginController::class, 'logout'])
            ->name('logout');

        Route::get('/validateToken', [LoginController::class, 'validateToken'])
            ->name('validateToken');
    });
});
