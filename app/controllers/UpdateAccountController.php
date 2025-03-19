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
			$data['user'] = $user;
			$this->view('account/updateaccount', $data);
		}
	}

	public function updateAccount(){
		try{
			$user = $_SESSION['user'];
			$oldPassword = $_POST['oldPassword'];
			$newUser = $this->createUser($user);
			if($newUser == null){
				$this->view('account/updateaccount', ['error' => 'Email already exists or password is incorrect']);
			}
			if(!$this->checkPassword($user, $oldPassword)){
				$this->view('account/updateaccount', ['error' => 'Password is incorrect']);
			}
			$this->userService->updateUser($newUser, $user->getEmail());
			$_SESSION['user'] = $newUser;
			$this->view('account/updateaccount', ['success' => 'Account updated successfully']);
		}
		catch(\Exception $e){
			$this->view('account/updateaccount', ['error' => $e->getMessage()]);
		}
	}	

    private function createUser($user): User {
        $email = htmlspecialchars(strtolower($_POST['email']));
        $name = htmlspecialchars($_POST['firstname'] . ' ' . $_POST['surname']);
        $newpassword = htmlspecialchars($_POST['newpassword']);
		$newpasswordConfirm = htmlspecialchars($_POST['newpasswordconfirm']);
		if ($newpassword == "" && $newpasswordConfirm == "") {
			$newpassword = $user->getPassword();
			$newpasswordConfirm = $user->getPassword();
		}
		if ($newpassword != $newpasswordConfirm) {
			throw new \Exception("New passwords do not match");
		}
		if (!$this->verifyNewPassword($newpassword)) {
			throw new \Exception("Password must be at least 8 characters long");
		}
		$currentPassword = htmlspecialchars($_POST['currentpassword']);
		$phone = htmlspecialchars($_POST['phone']);
        $country = htmlspecialchars($_POST['country']);
		if ($this->checkPassword($user, $currentPassword) && $this->checkEmail($user)) {
        	return $this->userService->updateExistingUser($user,$email, $name, $newpassword, $phone, $country);
		}
		else{
			throw new \Exception("Email already exists or password is incorrect");
		}
    }




	//all the checks :)


	//check if the email is already in use
	private function checkEmail($user) {
		$check = $this->userService->getUserByEmail($user->getEmail());
		if ($check === null) {
			return true;
		}
		return false;
	}

	//checks the entered password against the users real password to verify the user
	private function checkPassword($user, $currentPassword) {
		if (password_verify($currentPassword, $user->getPassword())) {
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
}