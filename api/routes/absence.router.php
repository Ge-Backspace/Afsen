<?php

$router->get('/todayAttendance', 'CheckinController@todayAttendance');
$router->post('/checkin', 'CheckinController@checkin');
$router->get('/check', 'CheckinController@check');
$router->get('/attendance', 'CheckinController@attendance');
$router->get('/attendance/export', 'CheckinController@exportAttendance');
