<?php
namespace Controllers;

use Controllers\Controller;
use Services\UserService;
use Models\User;
use Services\MailerService;

class UpdateAccountController extends Controller {

	private $userService;

	public function __construct() {
		$this->userService = new UserService();
	}

	public function index() {
		if (session_status() == PHP_SESSION_NONE) {
			$this->fourOFour();
		}
		else if(!isset($_SESSION['user'])){
			$this->fourOFour();
			exit();
		}
		else{
			echo session_status();
			$user = $_SESSION['user'];
			$this->view('account/index', $user);
		}
	}

	public function updateAccount(){
		$oldEmail = $_SESSION['user']->getEmail();
		$oldPassword = $_SESSION['user']->getPassword();
		$user = $_SESSION['user'];
		$newUser = $this->createUser($user);
		
		$this->userService->updateUser($newUser, $oldEmail);
		$this->view('account/index');
	}

    private function createUser($user): User {
        $email = htmlspecialchars(strtolower($_POST['email']));
        $name = htmlspecialchars($_POST['firstname'] . ' ' . $_POST['surname']);
        $password = htmlspecialchars($_POST['password']);
        $phone = htmlspecialchars($_POST['phone']);
        $country = htmlspecialchars($_POST['country']);
		if ($this->checkPassword($user, $password) && $this->checkEmail($user, $email)) {
        	return $this->userService->updateExistingUser($user,$email, $name, $password, $phone, $country);
		}
		else{
			throw new \Exception("Email already exists or password is incorrect");
		}
    }

	private function checkPassword($user, $password) {
		if (password_verify($password, $user->getPassword())) {
			return true;
		}
		return false;
	}

	private function checkEmail($user, $oldEmail) {
		$check = $this->userService->getUserByEmail($user->getEmail());
		if ($check === null) {
			return true;
		}
		return false;
	}
}