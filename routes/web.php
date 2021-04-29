<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
$router->get('/', 'Controller@index');
$router->post('/register', 'Controller@register');
$router->post('/login', 'Controller@login');
$router->get('/user/{id}', 'Controller@user');
$router->post('/forget','Controller@forgetPassword');
$router->post('/recovery','Controller@recovery');
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('logout', 'UserController@logout');
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');
    $router->get('delete/{id}', 'Controller@delete');
});
