<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/getName', 'EmployeeController@getName');
    $router->get('/getEmployee', 'SettingController@getEmployee');
    $router->get('/getCoordinate', 'OfficeController@getCoordinateOffice');
    $router->get('/todayShiftEmployee', 'ShiftEmployeeController@getTodayShiftEmployee');
    $router->get('/optionPosition', 'SettingController@optionPosition');
    $router->get('/optionEmployee', 'SettingController@optionEmployee');
    $router->get('/optionShift', 'SettingController@optionShift');
    $router->get('/optionCuti', 'SettingController@optionCuti');
    $router->get('/optionShiftEmployee', 'SettingController@optionShiftEmployee');
    $router->post('/test', 'TestController@test');
});
