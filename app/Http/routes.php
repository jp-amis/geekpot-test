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

$app->delete('/api/v1/users/{id}', [
    'middleware' => 'authToken',
    'as' => 'users.delete',
    'uses' => 'UsersController@delete'
]);

$app->patch('/api/v1/users/{id}', [
    'middleware' => 'authToken',
    'as' => 'users.patch',
    'uses' => 'UsersController@update'
]);

$app->post('/api/v1/users/{id}/revoke_access', [
    'middleware' => 'authToken',
    'as' => 'users.revoke_access',
    'uses' => 'UsersController@revoke_access'
]);

// Resources
$app->get('/api/v1/resources', [
    'middleware' => 'authToken',
    'as' => 'resources',
    'uses' => 'ResourcesController@index'
]);