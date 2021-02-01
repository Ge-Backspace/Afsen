<?php

$router->get('/statusPermissions', 'StatusPermissionController@getCompanyStatusPermission');
$router->post('/statusPermission', 'StatusPermissionController@addStatusPermission');
$router->post('/statusPermission/{id}/update', 'StatusPermissionController@updateStatusPermission');
$router->delete('/statusPermission/{id}/delete', 'StatusPermissionController@deleteStatusPermission');
$router->post('/statusPermission/import', 'StatusPermissionController@importStatusPermission');
$router->get('/statusPermission/export', 'StatusPermissionController@exportStatusPermission');
