<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// $router->post('/login', 'AuthController@login');
// $router->post('/register_company', 'AuthController@register_company');
// $router->post('/register_account', 'AuthController@register_account');
// $router->post('/register_account/check', 'AuthController@check_company');


//migrate
// $router->get('/migrate', function(){
//     Artisan::call('migrate');
// });
