<?php

$router->get('/company', 'CompanyController@getCompany');
$router->get('/companies', 'CompanyController@getAllCompanies');
$router->post('/company/update/{id}', 'CompanyController@updateCompany');
$router->delete('/company/delete/{id}', 'CompanyController@deleteCompany');
