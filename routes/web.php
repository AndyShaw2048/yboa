<?php

Route::any('/register','RegisterController@index');
Route::post('/register','RegisterController@store');
Route::get('/logout','RegisterController@logout');
Route::get('/yp','YunpianController@index');
