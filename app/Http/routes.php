<?php

// Auth
$app->post('/api/v1/auth', [
    'as' => 'auth.index',
    'uses' => 'AuthController@index'
]);

// Users
$app->get('/api/v1/users', [
    'middleware' => 'authToken',
    'as' => 'users.index',
    'uses' => 'UsersController@index'
]);

$app->post('/api/v1/users', [
    'as' => 'users.store',
    'uses' => 'UsersController@store'
]);

$app->get('/api/v1/users/{id}', [
    'middleware' => 'authToken',
    'as' => 'users.show',
    'uses' => 'UsersController@show'
]);