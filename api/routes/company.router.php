<?php

$router->group(['middleware' => 'auth'], function($router){
    $router->get('/company', 'CompanyController@getCompany');
    // $router->get('/companies', 'CompanyController@getAllCompanies');
    $router->post('/company/{id}/update', 'CompanyController@updateCompany');
    // $router->delete('/company/{id}/delete', 'CompanyController@deleteCompany');
});
