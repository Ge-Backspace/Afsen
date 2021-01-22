<?php

$router->get('/getTodayShiftEmployee', 'ShiftEmployeeController@getTodayShiftEmployee');
$router->get('/getShiftEmployee', 'ShiftEmployeeController@getShiftEmployee');
$router->get('/getCompanyShiftEmployee', 'ShiftEmployeeController@getCompanyShiftEmployee');
$router->post('/addShiftEmployee', 'ShiftEmployeeController@addShiftEmployee');
$router->post('/updateShiftEmployee', 'ShiftEmployeeController@updateShiftEmployee');
$router->delete('/deleteShiftEmployee', 'ShiftEmployeeController@deleteShiftEmployee');
