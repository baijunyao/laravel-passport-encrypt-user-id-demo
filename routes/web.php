<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| oauth
|--------------------------------------------------------------------------
*/
Route::prefix('oauth')->namespace('Oauth')->group(function () {
    Route::post('authorize', 'ApproveAuthorizationController@approve')->name('passport.authorizations.approve');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
