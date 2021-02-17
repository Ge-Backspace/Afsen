<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/reportAttendance', 'ReportController@reportAttendance');
});
