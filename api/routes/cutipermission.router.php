<?php

$router->get('/cutipermissions', 'CutiPermissionController@getCutiPermission');
$router->post('/cutipermission', 'CutiPermissionController@addCutiPermission');
$router->post('/cutipermission/{id}/update', 'CutiPermissionController@updateCutiPermission');
$router->delete('/cutipermission/{id}/delete', 'CutiPermissionController@deleteCutiPermission');
$router->post('/cutipermission/{id}/change', 'CutiPermissionController@changeStatusCutiPermission');
$router->post('/cutipermission/import', 'CutiPermissionController@importCutiPermission');
$router->get('/cutipermission/export', 'CutiPermissionController@exportCutiPermission');
