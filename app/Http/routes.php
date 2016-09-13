<?php

// Auth
$app->post('/api/v1/auth', [
    'as' => 'auth',
    'uses' => 'AuthController@index'
]);

// Users
$app->get('/api/v1/users', [
    'as' => 'users.index',
    'uses' => 'UsersController@index'
]);

$app->post('/api/v1/users', [
    'as' => 'users.store',
    'uses' => 'UsersController@store'
]);

$app->get('/api/v1/users/{id}', [
    'as' => 'users.show',
    'uses' => 'UsersController@show'
]);