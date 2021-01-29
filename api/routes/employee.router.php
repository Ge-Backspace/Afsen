<?php

$router->get('/employees', 'EmployeeController@getEmployee');
$router->post('/employee', 'EmployeeController@addEmployee');
$router->post('/employee/{id}/update', 'EmployeeController@updateEmployee');
$router->delete('/employee/{id}/delete', 'EmployeeController@deleteEmployee');
$router->post('/employee/import', 'EmployeeController@importEmployee');
$router->get('/employee/export', 'EmployeeController@exportEmployee');
