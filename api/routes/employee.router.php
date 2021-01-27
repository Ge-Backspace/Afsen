<?php

$router->get('/employees', 'EmployeeController@getEmployee');
$router->post('/employee', 'EmployeeController@addEmployee');
$router->post('/employee/{id}', 'EmployeeController@updateEmployee');
$router->delete('/employee/{id}', 'EmployeeController@deleteEmployee');
