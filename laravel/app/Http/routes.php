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



Route::get('about', 'PagesController@about');
Route::get('welcome','PagesController@welcome');
Route::get('tray','PagesController@tray');
Route::get('aboutLaravel','PagesController@aboutLaravel');
Route::post('tray','PagesController@welcome');
Route::post('welcome','PagesController@tray');

//Route::get('welcome/{id}','PagesController@welcome1');
Route::get('/', function () {
    return view('welcome');
	/*
	*/
});

