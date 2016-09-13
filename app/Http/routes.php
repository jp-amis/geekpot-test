<?php

// list all users
$app->get('/api/v1/users', 'UsersController@index');
// register new user
$app->post('/api/v1/users', 'UsersController@store');