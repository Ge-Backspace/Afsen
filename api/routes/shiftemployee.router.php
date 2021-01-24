<?php

$router->get('/shiftEmployees', 'ShiftEmployeeController@getShiftEmployee');
$router->get('/companyShiftEmployee', 'ShiftEmployeeController@getCompanyShiftEmployee');
$router->post('/shiftEmployee', 'ShiftEmployeeController@addShiftEmployee');
$router->post('/shiftEmployee/update/{id}', 'ShiftEmployeeController@updateShiftEmployee');
$router->delete('/shiftEmployee/delete/{id}', 'ShiftEmployeeController@deleteShiftEmployee');
