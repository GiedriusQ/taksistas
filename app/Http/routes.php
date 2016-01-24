<?php

Route::group(['prefix' => 'api'], function () {
    Route::post('register', 'ApiController@postRegister');
    Route::post('login', 'ApiController@postLogin');
    Route::group(['middleware' => 'api_key'], function () {
        Route::get('games', 'ApiController@getGames');
        Route::post('games', 'ApiController@postGame');
        Route::get('games/{game}', 'ApiController@getGame');
        Route::post('games/{game}', 'ApiController@postMove');
    });
});

Route::get('/', function () {
    return view('game');
});