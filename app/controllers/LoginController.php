<?php
namespace Controllers;
use Services\LoginService;
use Models\User;
use Controllers\Controller;
use Config\reCAPTCHAConfig;

class LoginController extends Controller {
    private $loginService;
    function __construct()
        {
            $this->loginService = new LoginService();
        }

    public function index() {
        $this->view('login/login');
    }

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
        
                    $user = new User();
                    $user->setEmail($email);
                    $user->setPasswordOnLogin($password);
                    try{
                        $authenticatedUser = $this->loginService->check($user);
        
                        if ($authenticatedUser) {
                            session_start();
                            $_SESSION['user'] = $authenticatedUser;
                            header('Location: /home');
                            exit;
                        } else {
                            $this->view('login/login', ['error' => 'Invalid email or password']);
                        }
                    }
                    catch(\Exception $e){
                        $this->view('login/login', ['error' => $e->getMessage()]);
                    }
                } catch (\Exception $e) {
                    $this->view('login/login', ['error' => $e->getMessage()]);
                }
            }
        }
    }
}
?>