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
})->name('home');

Route::post('/signup', [
	'uses' => 'UserController@postSignUp',
	'as' => 'signup'
]);

Route::post('/signin', [
	'uses' => 'UserController@postSignIn',
	'as' => 'signin'
]);

Route::get('/logout', [
	'uses' => 'UserController@getLogout',
	'as' => 'logout',
]);

Route::get('/account', [
	'uses' =>'UserController@getAccount',
	'as' => 'account'
]);

Route::post('/updateaccount', [
	'uses' =>'UserController@postSaveAccount',
	'as' => 'account.save'
]);

Route::get('/userimage/{filename}', [ 
	'uses' => 'UserController@getUserImage',
	'as' => 'account.image',
]);

Route::get('/dashboard', [
	'middleware' => 'auth',
	'uses' => 'PostController@getDashboard',
	'as' => 'dashboard',
]);

Route::post('/createpost', [
	'middleware' => 'auth',
	'uses' => 'PostController@postCreatePost',
	'as' => 'post.create',
]);

Route::get('/deletepost/{post_id}', [
	'middleware' => 'auth',
	'uses' => 'PostController@getDeletePost',
	'as' => 'post.delete',
]);

// Use the request object in the route
Route::post('/edit', [
	'uses' => 'PostController@postEditPost',
	'as' => 'edit'
]);

Route::post('/like', [
	'uses' => 'PostController@postLikePost',
	'as' => 'like',
]);
