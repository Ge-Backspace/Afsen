<?php

$router->get('/todayAttandance', 'CheckinController@todayAttandance');
$router->post('/checkin', 'CheckinController@checkin');
$router->get('/check', 'CheckinController@check');
$router->get('/attendance', 'CheckinController@attendance');
$router->get('/attendance/export', 'CheckinController@exportAttendance');
