<?php

$router->get('/cutiemployees', 'CutiEmployeeController@getCutiEmployee');
$router->post('/cutiemployee', 'CutiEmployeeController@addCutiEmployee');
$router->post('/cutiemployee/{id}/update', 'CutiEmployeeController@updateCutiEmployee');
$router->delete('/cutiemployee/{id}/delete', 'CutiEmployeeController@deleteCutiEmployee');
$router->post('/cutiemployee/import', 'CutiEmployeeController@importCutiEmployee');
$router->get('/cutiemployee/export', 'CutiEmployeeController@exportCutiEmployee');
