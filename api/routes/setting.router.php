<?php

$router->get('/getName', 'EmployeeController@getName');
$router->get('/getCoordinate', 'CompanyController@getCoorditaneCompany');
$router->get('/todayShiftEmployee', 'ShiftEmployeeController@getTodayShiftEmployee');
$router->get('/optionPosition', 'SettingController@optionPosition');
$router->get('/optionEmployee', 'SettingController@optionEmployee');
$router->get('/optionShift', 'SettingController@optionShift');
