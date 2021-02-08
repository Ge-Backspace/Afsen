<?php

$router->get('/getName', 'EmployeeController@getName');
$router->get('/getCoordinate', 'CompanyController@getCoorditaneCompany');
$router->get('/todayShiftEmployee', 'ShiftEmployeeController@getTodayShiftEmployee');
$router->get('/optionPosition', 'SettingController@optionPosition');
$router->get('/optionEmployee', 'SettingController@optionEmployee');
$router->get('/optionShift', 'SettingController@optionShift');
$router->get('/optionCuti', 'SettingController@optionCuti');
$router->get('/optionShiftEmployee', 'SettingController@optionShiftEmployee');
$router->get('/test', 'TestController@test');
