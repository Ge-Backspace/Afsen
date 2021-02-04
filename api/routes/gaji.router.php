<?php

$router->get('/gajis', 'GajiController@getCompanyGaji');
$router->post('/gaji', 'GajiController@addGaji');
$router->post('/gaji/{id}/update', 'GajiController@updateGaji');
$router->delete('/gaji/{id}/delete', 'GajiController@deleteGaji');
$router->post('/gaji/import', 'GajiController@importGaji');
$router->get('/gaji/export', 'GajiController@exportGaji');
