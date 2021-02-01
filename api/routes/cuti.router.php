<?php

$router->get('/cutis', 'CutiController@getCompanyCuti');
$router->post('/cuti', 'CutiController@addCuti');
$router->post('/cuti/{id}/update', 'CutiController@updateCuti');
$router->delete('/cuti/{id}/delete', 'CutiController@deleteCuti');
$router->post('/cuti/import', 'CutiController@importCuti');
$router->get('/cuti/export', 'CutiController@exportCuti');
