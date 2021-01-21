<?php

$router->get('/schedules', 'ScheduleController@getAllCompanySchedule');
$router->post('/schedule', 'ScheduleController@addSchedule');
$router->post('/schedule/update/{id}', 'ScheduleController@updateSchedule');
$router->delete('/schedule/delete/{id}', 'ScheduleController@deleteSchedule');
