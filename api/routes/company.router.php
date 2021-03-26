<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/company', 'CompanyController@getCompany');
    $router->post('/company/{id}/update', 'CompanyController@updateCompany');
});

$router->group(['middleware' => ['auth', 'superadmin']], function($router){
    $router->get('/companies', 'CompanyController@getAllCompanies');
    $router->delete('/company/{id}/delete', 'CompanyController@deleteCompany');
});
