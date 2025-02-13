<?php
namespace App\Controllers;
use App\Models\User;
use Controllers\Controller;
use App\Service\CreateAccountService;

class CreateAccountController extends Controller {
    private $accountService;

    function __construct()
        {
            $this->accountService = new CreateAccountService();
        }
    public function index() {
        require __DIR__ . '/../views/create-account/create-account.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
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

            $this->accountService->insert($user);
        }
    }   
}
?>