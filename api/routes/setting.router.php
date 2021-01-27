<?php

$router->get('/getName', 'EmployeeController@getName');
$router->get('/todayShiftEmployee', 'ShiftEmployeeController@getTodayShiftEmployee');
$router->get('/optionPosition', 'PositionController@optionPosition');
