<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/lemburpermissions', 'LemburPermissionController@getLemburPermission');
    $router->post('/lemburpermission', 'LemburPermissionController@addLemburPermission');
    $router->post('/lemburpermission/{id}/update', 'LemburPermissionController@updateLemburPermission');
    $router->delete('/lemburpermission/{id}/delete', 'LemburPermissionController@deleteLemburPermission');
    $router->post('/lemburpermission/{id}/change', 'LemburPermissionController@changeStatusLemburPermission');
    // $router->post('/cutipermission/import', 'CutiPermissionController@importCutiPermission');
    // $router->get('/cutipermission/export', 'CutiPermissionController@exportCutiPermission');
});
