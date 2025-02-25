<?php
namespace Controllers;
use Services\LoginService;
use Models\User;
use Controllers\Controller;

class LoginController extends Controller {
    private $loginService;
    function __construct()
        {
            $this->loginService = new LoginService();
        }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $email = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            $user = new User();
            $user->setUserName($email);
            $user->setPasswordOnLogin($password);
            try{
                $authenticatedUser = $this->loginService->check($user);

                if ($authenticatedUser) {
                    session_start();
                    $_SESSION['user'] = $authenticatedUser;
                    header("Location: /dashboard");
                    exit;
                } else {
                    $error = "Invalid email or password.";
                }
            }
            catch(\Exception $e){
                $this->view('login/login', ['error' => $e->getMessage()]);
            }
            
        }
        require __DIR__ . '/../views/login/login.php';
    }

}
?>