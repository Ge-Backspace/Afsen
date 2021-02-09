<?php

$router->get('/offices', 'OfficeController@getCompanyOffice');
$router->post('/office', 'OfficeController@addOffice');
$router->post('/office/{id}/update', 'OfficeController@updateOffice');
$router->delete('/office/{id}/delete', 'OfficeController@deleteOffice');
