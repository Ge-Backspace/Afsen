<?php

$router->get('/positions', 'PositionController@getPosition');
$router->post('/position', 'PositionController@addPosition');
$router->put('/position/{id}', 'PositionController@updatePosition');
$router->delete('/position/{id}', 'PositionController@deletePosition');
