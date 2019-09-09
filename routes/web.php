<?php
Route::get('/', function () {
    return view('welcome');
});

// Catch all route
Route::get('/{all}', function () {
    return view('welcome');
});

Route::get('/api/organizations', 'OrganizationController@index');

Route::get('/api/connections', 'ConnectionController@index');
Route::post('/api/connections', 'ConnectionController@store');
