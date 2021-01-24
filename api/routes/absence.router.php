<?php

$router->get('/todayCheckin', 'CheckinController@todayCheckin');
$router->post('/checkin', 'CheckinController@checkin');
$router->get('/check', 'CheckinController@check');
