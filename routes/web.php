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

Route::get('facebook/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('facebook/callback', 'Auth\LoginController@handleProviderCallback');
Auth::routes();

Route::get('kitlogin', 'Auth\LoginController@login');
Route::post('kitlogin', 'Auth\KitLoginController@kit');

Route::get('/home', 'HomeController@index')->name('home');
