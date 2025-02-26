<?php

use Bramus\Router\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$router->setNamespace('\Controllers');

// for more info visit: https://github.com/bramus/router
// route setup is like this:
// $router->get('/YOURPATH', 'YOURCONTROLLER@YOURFUNCTION');

// Add your routes here:
// default route
    //home
    $router->get('/', 'HomeController@index');
    $router->get('/home', 'HomeController@index');
    $router->get('/jazz', 'JazzController@index');

// Run the router
$router->run();