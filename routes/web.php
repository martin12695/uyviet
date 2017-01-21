<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@initPage');
Route::get('/location', 'HomeController@findItem');
Route::post('/getInfoShop', 'HomeController@getInfoShop');
Route::get('/getdistrict', 'HomeController@getDistrictList');
Route::get('/getward', 'HomeController@getWardList');
Route::post('/login', 'HomeController@doLogin');
Route::get('/logout', 'HomeController@doLogout');
Route::post('/doEdit', 'HomeController@doEditMarker');
Route::get('/editMarker', 'HomeController@editMarkerUI');