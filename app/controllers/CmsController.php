<?php

namespace Controllers;

use Config\reCAPTCHAConfig;
use Services\UserService;
use Models\User;

class CmsController extends Controller {
    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function index() {
        $this->view('cms/index');
    }

    //"geleend" van LoginController
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $recaptcha_url= 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_secret = reCAPTCHAConfig::secret;
            $recaptcha_response = $_POST['g-recaptcha-response'];

            $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
            
            $recaptcha = json_decode($recaptcha,true);

            if($recaptcha['success'] == 1 AND $recaptcha['score'] >= 0.5 AND $recaptcha['action'] == 'submit'){
                try{
                    $email = htmlspecialchars(strtolower($_POST['email']));
                    $password = htmlspecialchars($_POST['password']);
                    try{
                        $authenticatedUser = $this->userService->login($email, $password);
                        if ($authenticatedUser) {
                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                            $_SESSION['user'] = $authenticatedUser;
                            header('Location: /cms/users');
                            exit;
                        } else {
                            $this->view('cms/index', ['error' => 'Invalid email or password']);
                        }
                    }
                    catch(\Exception $e){
                        $this->view('cms/index', ['error' => $e->getMessage()]);
                    }
                } catch (\Exception $e) {
                    $this->view('cms/index', ['error' => 'Invalid captcha']);
                }
            }
        }
    }
}