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
Route::get('/products/{id}/favorite', 'ProductsController@toggleFavorite');

Route::resource('messages', 'MessagesController', ['except' => [
    'create', 'edit'
]]);
Route::get('/messages/{recipientId}/create', [
    'as' => 'messages.create',
    'uses' => 'MessagesController@create'
]);