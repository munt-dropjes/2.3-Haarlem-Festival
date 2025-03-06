<?php

use Bramus\Router\Router;

require_once __DIR__ . '/../Models/User.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$router->setNamespace('\Controllers');

// for cms routes, we will check for authentication
$router->before('GET|POST', '/cms/.*', function() {
    if (str_contains($_SERVER['REQUEST_URI'], '/cms/login') || str_contains($_SERVER['REQUEST_URI'], '/cms/logout')) {
        return;
    }
    
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

    $router->get('/createaccount', 'createaccountController@index');
    $router->post('/createaccount', 'createaccountController@create');
    $router->get('/login', 'LoginController@index');
    $router->post('/login', 'LoginController@login');
    $router->get('/logout', 'LogOutController@index');
	$router->get('/dance', 'DanceController@index');

    //cms
    $router->get('/cms', 'CmsController@index');
    $router->get('/cms/users', 'CmsUserController@index');
    $router->post('/cms/users/create', 'CmsUserController@create');
    $router->post('/cms/users/delete', 'CmsUserController@delete');
    $router->post('/cms/users/edit', 'CmsUserController@update');
    
// Run the router
$router->run();