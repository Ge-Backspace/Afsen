<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/shiftEmployees', 'ShiftEmployeeController@getShiftEmployee');
    $router->get('/companyShiftEmployee', 'ShiftEmployeeController@getCompanyShiftEmployee');
    $router->post('/shiftEmployee', 'ShiftEmployeeController@addShiftEmployee');
    $router->post('/shiftEmployee/{id}/update', 'ShiftEmployeeController@updateShiftEmployee');
    $router->delete('/shiftEmployee/{id}/delete', 'ShiftEmployeeController@deleteShiftEmployee');
    $router->post('/shiftEmployee/import', 'ShiftEmployeeController@importShiftEmployee');
    $router->get('/shiftEmployee/export', 'ShiftEmployeeController@exportShiftEmployee');
});
