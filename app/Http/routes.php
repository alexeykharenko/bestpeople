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

/*
|	AUTH
*/
Route::group(['namespace' => 'Auth'], function() {
	Route::get('login', 'AuthController@getLogin');
	Route::post('login', 'AuthController@postLogin');
	Route::get('logout', 'AuthController@logout');

	Route::get('register', 'AuthController@getRegister');
	Route::post('register', 'AuthController@postRegister');
});

/*
|	USER
*/
Route::get('edit_profile', 'UserController@editUserData')->name('editProfile');
Route::put('edit_profile', 'UserController@updateUserData');

Route::get('profile/{userId}', 'UserController@profile');
Route::get('profile/{userId}/history', 'UserController@history');

Route::post('/vote', 'VoteController@vote');

Route::post('/comment', 'CommentController@add');
Route::get('/profile/{userId}/comments', 'CommentController@getAll');
Route::delete('/comment/{commentId}', 'CommentController@delete');
Route::post('/recover_comment/{commentId}', 'CommentController@recover');

/*
|	MAIN
*/
Route::get('/', 'MainController@index');
