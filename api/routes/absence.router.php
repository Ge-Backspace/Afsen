<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/todayAttendance', 'CheckinController@todayAttendance');
    $router->get('/attendances', 'CheckinController@attendance');
    $router->post('/checkin', 'CheckinController@checkin');
    $router->get('/check', 'CheckinController@check');
    $router->get('/attendance/export', 'CheckinController@exportAttendance');
    $router->post('/specialcheckin', 'CheckinController@specialCheckin');
});
