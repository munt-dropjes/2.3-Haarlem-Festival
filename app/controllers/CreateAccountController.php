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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $this->createUser();
            $this->accountService->insert($user);
        }
    }  
    
    private function createUser(): User {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $name = htmlspecialchars($_POST['firstname'] . ' ' . $_POST['surname']);
        $user = new User($name,$email,$password);
        return $user;
    }
}
?>