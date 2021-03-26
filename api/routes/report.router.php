<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/reportAttendance', 'ReportController@reportAttendance');
});
$router->group(['middleware' => ['auth', 'superadmin']], function($router){
    $router->get('/statCompany', 'ReportController@statCompany');
    $router->get('/newCompany', 'ReportController@newCompany');
});
