<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/user', 'UserController@user');
    $router->get('/users', 'UserController@index');
    $router->get('/user/{id}/show', 'UserController@show');
    $router->delete('/user/{id}/delete', 'UserController@destroy');
    $router->post('/user/store', 'UserController@store');
    $router->post('/user/{id}/update', 'UserController@update');
    $router->post('/user/{id}/profile', 'UserController@profile');
});
