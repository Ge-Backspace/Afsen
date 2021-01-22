<?php

$router->get('/shifts', 'ShiftController@getCompanyShift');
$router->post('/shift', 'ShiftController@addShift');
$router->post('/shift/update/{id}', 'ShiftController@updateShift');
$router->delete('/shift/delete/{id}', 'ShiftController@deleteShift');
