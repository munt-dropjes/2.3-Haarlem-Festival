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

    //everything account related
    $router->get('/createaccount', 'createaccountController@index');
    $router->post('/createaccount', 'createaccountController@create');
    $router->get('/login', 'LoginController@index');
    $router->post('/login', 'LoginController@login');
    $router->get('/logout', 'LogOutController@index');
    $router->get('/forgotpassword', 'ForgotPasswordController@index');
    $router->post('/forgotpassword', 'ForgotPasswordController@index');
    $router->get('/resetpassword/{email}/{resetToken}', 'ForgotPasswordController@reset');
    $router->post('/resetpassword/{email}/{resetToken}', 'ForgotPasswordController@reset');
    $router->get('/updateaccount', 'UpdateAccountController@index');
    $router->post('/updateaccount', 'UpdateAccountController@updateAccount');
	
    //events
    $router->get('/stroll', 'StrollController@index');
    $router->get('/stroll/detail', 'StrollController@detail');
	  $router->get('/dance', 'DanceController@index');
	  $router->get('/dance/{artist}', 'DanceController@artist');

    //cms
    $router->get('/cms', 'CmsController@index');
    $router->get('/cms/users', 'CmsUserController@index');
    $router->post('/cms/users/create', 'CmsUserController@create');
    $router->post('/cms/users/delete', 'CmsUserController@delete');
    $router->post('/cms/users/edit', 'CmsUserController@update');
    
// Run the router
$router->run();