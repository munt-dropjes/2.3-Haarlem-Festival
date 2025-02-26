<?php

use Bramus\Router\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$router->setNamespace('\Controllers');

// for cms routes, we will check for authentication
$router->before('GET|POST', '/cms/.*', function() {
    if (str_contains($_SERVER['REQUEST_URI'], '/cms/login') || str_contains($_SERVER['REQUEST_URI'], '/cms/logout')) {
        return;
    }
    
    //uncomment this to enable authentication - kan pas na registration ticket
    // if (!isset($_SESSION['user'])) {
    //     header('Location: /login');
    //     exit();
    // }
});

// for more info visit: https://github.com/bramus/router
// route setup is like this:
// $router->get('/YOURPATH', 'YOURCONTROLLER@YOURFUNCTION');

// Add your routes here:
// default route
    //home
    $router->get('/', 'HomeController@index');
    $router->get('/home', 'HomeController@index');


    //cms
    $router->get('/cms', 'CmsController@index');
    $router->get('/cms/users', 'CmsController@users');

// Run the router
$router->run();