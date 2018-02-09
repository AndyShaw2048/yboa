<?php
Route::get('/','IndexController@index');
Route::any('/register','RegisterController@index');
Route::post('/register','RegisterController@store');
Route::get('/logout','RegisterController@logout');
