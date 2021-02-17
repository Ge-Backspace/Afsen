<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/shifts', 'ShiftController@getCompanyShift');
    $router->post('/shift', 'ShiftController@addShift');
    $router->post('/shift/{id}/update', 'ShiftController@updateShift');
    $router->delete('/shift/{id}/delete', 'ShiftController@deleteShift');
    $router->post('/shift/import', 'ShiftController@importShift');
    $router->get('/shift/export', 'ShiftController@exportShift');
});
