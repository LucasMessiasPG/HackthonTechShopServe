<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','ContatosController@index');
Route::get('/multi','WhatsAppController@multi');

Route::group(['prefix'=>'/api/v1'],function(){
    Route::group(['prefix'=>'contato'],function(){
        Route::get('/get/{id}','ContatosController@get');
        Route::post('/create','ContatosController@store');
        Route::post('/filter','ContatosController@filter');
        Route::post('/update/{id}','ContatosController@update');
        Route::get('/delete/{id}','ContatosController@destroy');
    });
    Route::group(['prefix'=>'message'],function(){
        Route::get('/get/{id}','MessageController@get');
        Route::post('/create','MessageController@store');
        Route::post('/filter','MessageController@filter');
        Route::post('/update/{id}','MessageController@update');
        Route::get('/delete/{id}','MessageController@destroy');
    });

    Route::group(['prefix'=>'message'],function(){
        Route::post('send','WhatsAppController@enviar');
    });
});
