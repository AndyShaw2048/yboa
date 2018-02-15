<?php
Route::get('/','IndexController@index');
Route::any('/register','RegisterController@index');
Route::post('/register','RegisterController@store');
Route::get('/logout','RegisterController@logout');
Route::get('/help','HelpController@index');
Route::post('/help/getcontent','HelpController@getContent');
Route::get('/help/create','HelpController@create');