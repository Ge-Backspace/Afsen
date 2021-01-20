<?php

$router->get('/employees', 'EmployeeController@getEmployee');
$router->post('/employee', 'EmployeeController@addEmployee');
$router->put('/employee/{id}', 'EmployeeController@updateEmployee');
$router->delete('/employee/{id}', 'EmployeeController@deleteEmployee');
