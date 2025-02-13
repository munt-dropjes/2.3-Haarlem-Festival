<?php
namespace Controllers;

use Controllers\Controller;
use Service\CreateAccountService;
use Models\User;

class CreateAccountController extends Controller {
    private $accountService;

    function __construct()
        {
            $this->accountService = new CreateAccountService();
        }
    public function index() {
        echo 'hi';
        $this->view('create-account/index');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $this->createUser();
            $this->accountService->insert($user);
        }
    }  
    
    private function createUser(): User {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $height = htmlspecialchars($_POST['height']);
        $weight = htmlspecialchars($_POST['weight']);
        $age = htmlspecialchars($_POST['age']);
        
        $user = new User();
        $user->setUserName($email);
        $user->setPassword($password);
        $user->setHeight($height);
        $user->setWeight($weight);
        $user->setAge($age);
        return $user;
    }
}
?>