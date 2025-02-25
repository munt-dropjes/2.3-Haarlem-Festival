<?php
namespace Controllers;

use Controllers\Controller;
use Services\CreateAccountService;
use Models\User;

class CreateAccountController extends Controller {
    private $accountService;

    

    function __construct()
        {
            $this->accountService = new CreateAccountService();
        }
    public function index() {
        $this->view('create-account/index');
    }  

    public function create() {
        echo "<script>console.log('CreateAccountController::create() method called');</script>";
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            $recaptcha_url= 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_secret = '6LfcK-IqAAAAANq23MOEd3F0eFD3vVPsr0Z1VTty';
            $recaptcha_response = $_POST['g-recaptcha-response'];

            $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
            
            $recaptcha = json_decode($recaptcha,true);

            if($recaptcha['success'] == 1 AND $recaptcha['score'] >= 0.5 AND $recaptcha['action'] == 'submit'){
                try{
                    $user = $this->createUser();
                    $this->accountService->insert($user);
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
        $email = htmlspecialchars($_POST['email']);
        $name = htmlspecialchars($_POST['firstname'] . ' ' . $_POST['surname']);
        $password = htmlspecialchars($_POST['password']);
        $phone = htmlspecialchars($_POST['phone']);
        $country = htmlspecialchars($_POST['country']);
        $user = new User($name,$email,$password, $phone, $country);
        return $user;
    }
}
?>