<?php

$router->post('/checkin', 'CheckinController@checkin');
$router->post('/checkout', 'CheckinController@checkout');
$router->get('/check/{user_id}', 'CheckinController@check');