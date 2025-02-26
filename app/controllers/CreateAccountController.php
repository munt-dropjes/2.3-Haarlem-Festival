<?php
namespace Controllers;

use Controllers\Controller;
use Services\CreateAccountService;
use Models\User;
use Enums\roleEnum;
use Services\MailerService;
use Config\reCAPTCHAConfig;
use Services\UserService;

class CreateAccountController extends Controller {
    private $mailerService;
    private $userService;

    function __construct()
        {
            $this->mailerService = new MailerService();
            $this->userService = new UserService();
        }
    public function index() {
        $this->view('create-account/index');
    }  

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            $recaptcha_url= 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_secret = reCAPTCHAConfig::secret;
            $recaptcha_response = $_POST['g-recaptcha-response'];

            $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
            
            $recaptcha = json_decode($recaptcha,true);

            if($recaptcha['success'] == 1 AND $recaptcha['score'] >= 0.5 AND $recaptcha['action'] == 'submit'){
                try{
                    $user = $this->createUser();
                    $this->userService->insert($user);
                    $this->mailerService->sendMail($user->getEmail(), $user->getName(), 'Account Created', 'Your account has been created successfully!');
                    $this->view('create-account/success');
                } catch (\Exception $e) {
                    $this->view('create-account/index', ['error' => $e->getMessage()]);
                }
            } else {
                $this->view('create-account/index', ['error' => 'Please complete the reCAPTCHA']);
            }
        }
    }
    
    private function createUser(): User {
        $email = htmlspecialchars(strtolower($_POST['email']));
        $name = htmlspecialchars($_POST['firstname'] . ' ' . $_POST['surname']);
        $password = htmlspecialchars($_POST['password']);
        $phone = htmlspecialchars($_POST['phone']);
        $country = htmlspecialchars($_POST['country']);
        return $this->userService->create($email, $name, $password, $phone, $country);
    }
}
?>