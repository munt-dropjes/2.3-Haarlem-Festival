<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);
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
    if (!isset($_SESSION['user'])) {
        header('Location: /cms');
        exit();
    }

    if ($_SESSION['user']->getRole() != 'Administrator') {
        header('Location: /home');
        exit();
    }
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

    $router->get('/stroll/detail', 'StrollDetailController@index');
	  $router->get('/dance', 'DanceController@index');
      $router->get('/jazz', 'JazzController@index');
      $router->get('/jazz/artist/{name}', 'JazzDetailController@index');


    $router->get('/stroll/detail', 'StrollController@detail');
	$router->get('/dance', 'DanceController@index');
	$router->get('/dance/{artist}', 'DanceController@artist');


    //cms
    $router->get('/cms', 'CmsController@index');
    $router->post('/cms', 'CmsController@login');
    $router->get('/cms/users', 'CmsUserController@index');
    $router->post('/cms/users/create', 'CmsUserController@create');
    $router->post('/cms/users/delete', 'CmsUserController@delete');
    $router->post('/cms/users/edit', 'CmsUserController@update');
    $router->get('/cms/events', 'CmsEventController@index');
    $router->post('/cms/events/create', 'CmsEventController@create');
    $router->post('/cms/events/delete', 'CmsEventController@delete');
    $router->post('/cms/events/edit', 'CmsEventController@update');
    $router->get('/cms/orders', 'CmsOrderController@index');

    //payment with stripe / shoppingcart routes
    $router->get('/checkout', 'PaymentController@createSession');
    $router->get('/checkout/complete', 'PaymentController@success');
    $router->get('/checkout/cancel', 'PaymentController@cancel');
    $router->post('/checkout/webhook', 'PaymentController@webhook');    

// Run the router
$router->run();