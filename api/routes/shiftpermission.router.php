<?php

$router->get('/shiftpermissions', 'ShiftPermissionController@getShiftPermission');
$router->post('/shiftpermission', 'ShiftPermissionController@addShiftPermission');
$router->post('/shiftpermission/{id}/update', 'ShiftPermissionController@updateShiftPermission');
$router->delete('/shiftpermission/{id}/delete', 'ShiftPermissionController@deleteShiftPermission');
$router->post('/shiftpermission/{id}/change', 'ShiftPermissionController@changeStatusShiftPermission');
$router->post('/shiftpermission/import', 'ShiftPermissionController@importShiftPermission');
$router->get('/shiftpermission/export', 'ShiftPermissionController@exportShiftPermission');
