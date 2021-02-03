<?php

$router->get('/todayAttandance', 'CheckinController@todayAttandance');
$router->post('/checkin', 'CheckinController@checkin');
$router->get('/check', 'CheckinController@check');
$router->get('/attandance', 'CheckinController@attandance');
