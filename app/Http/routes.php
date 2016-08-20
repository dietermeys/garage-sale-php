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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::resource('products', 'ProductsController');
Route::get('/products/images/{id}/delete', 'ProductsController@deleteImage');

Route::resource('messages', 'MessagesController', ['except' => [
    'create', 'edit'
]]);
Route::group(['prefix' => 'messages'], function () {
    Route::get('/{recipientId}/show', [
        'as' => 'messages.conversations',
        'uses' => 'MessagesController@showConversations'
    ]);
    Route::get('/{recipientId}/create', [
        'as' => 'messages.create',
        'uses' => 'MessagesController@create'
    ]);
});