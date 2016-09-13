<?php

$app->get('/api/v1/users', [
    'as' => 'users.index',
    'uses' => 'UsersController@index'
]);

$app->post('/api/v1/users', [
    'as' => 'users.store',
    'uses' => 'UsersController@store'
]);

$app->post('/api/v1/users/{id}', [
    'as' => 'users.show',
    'uses' => 'UsersController@show'
]);