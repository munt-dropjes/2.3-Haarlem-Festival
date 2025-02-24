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
        try{
            $user = $this->createUser();
            $this->accountService->insert($user);
            $this->view('create-account/success');
        } catch (\Exception $e) {
            $this->view('create-account/index', ['error' => $e->getMessage()]);
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