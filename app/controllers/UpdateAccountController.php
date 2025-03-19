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
		try{
			$user = $_SESSION['user'];
			$oldPassword = $_POST['oldPassword'];
			$newUser = $this->createUser($user);
			if($newUser == null){
				$this->view('account/index', ['error' => 'Email already exists or password is incorrect']);
			}
			if(!$this->checkPassword($user, $oldPassword)){
				$this->view('account/index', ['error' => 'Password is incorrect']);
			}
			$this->userService->updateUser($newUser, $user->getEmail());
			$this->view('account/index');
		}
		catch(\Exception $e){
			$this->view('account/index', ['error' => $e->getMessage()]);
		}
	}	

	//checks the entered password against the users real password to verify the user
	private function checkPassword($user, $password) {
		if (password_verify($password, $user->getPassword())) {
			return true;
		}
		return false;
	}

	//verify the validity of the new password (checks if the new password has a minimum of 8 characters, a special character and a number)
	private function verifyNewPassword($password) {
		if (strlen($password) >= 8 && 
			preg_match('/[!@#$%^&*()_+=-{};:"<>,./?]/', $password) && 
			preg_match('/\d/', $password)
		) {
			return true;
		}
		return false;
	}

    private function createUser($user): User {
        $email = htmlspecialchars(strtolower($_POST['email']));
        $name = htmlspecialchars($_POST['firstname'] . ' ' . $_POST['surname']);
        $password = htmlspecialchars($_POST['password']);
		if (!$this->verifyNewPassword($password)) {
			throw new \Exception("Password must be at least 8 characters long");
		}
		$phone = htmlspecialchars($_POST['phone']);
        $country = htmlspecialchars($_POST['country']);
		if ($this->checkPassword($user, $password) && $this->checkEmail($user)) {
        	return $this->userService->updateExistingUser($user,$email, $name, $password, $phone, $country);
		}
		else{
			throw new \Exception("Email already exists or password is incorrect");
		}
    }

	private function checkEmail($user) {
		$check = $this->userService->getUserByEmail($user->getEmail());
		if ($check === null) {
			return true;
		}
		return false;
	}
}