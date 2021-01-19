<?php

$router->get('/checkins', 'CheckinController@index');
$router->post('/checkin', 'CheckinController@checkin');
$router->post('/checkout', 'CheckinController@checkout');
$router->get('/check', 'CheckinController@check');
