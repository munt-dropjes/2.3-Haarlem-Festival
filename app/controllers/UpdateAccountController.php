<?php
namespace Controllers;

use Controllers\Controller;
use Services\UserService;
use Models\User;
use Services\MailerService;

class UpdateAccountController extends Controller {

	private $userService;
	private $mailerService;

	public function __construct() {
		$this->userService = new UserService();
		$this->mailerService = new MailerService();
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
			$user = $_SESSION['user'];
			$data['user'] = $user;
			$this->view('account/updateaccount', $data);
		}
	}



	public function updateAccount() {
		try {
			$user = $_SESSION['user'];
			$currentPassword = $_POST['currentpassword'];
			if (!$this->checkPassword($user, $currentPassword)) {
				$data['error'] = 'Password is incorrect';
				$data['user'] = $user;
				$this->view('account/updateaccount', $data);
				return; 
			}
			$email = htmlspecialchars(strtolower($_POST['email']));
			$currentEmail = $user->getEmail();
			if (!$email == $currentEmail) {
				if(!$this->checkEmail($email)) {
					$data['error'] = 'Email already exists';
					$data['user'] = $user;
					$this->view('account/updateaccount', $data);
					return;
				}
			}
			$newUser = $this->createUser($user, $currentPassword);
			if ($newUser == null) {
				$data['error'] = 'Failed to update account';
				$data['user'] = $user;
				$this->view('account/updateaccount', $data);
				return; 
			}
			$this->userService->updateUser($newUser, $user->getEmail());
			$_SESSION['user'] = $newUser;
			$data['success'] = 'Account updated successfully';
			$data['user'] = $newUser;
			$this->mailerService->sendMail($user->getEmail(), $user->getName(), 'Account Updated', 'Your account has been updated successfully!');
			$this->view('account/updateaccount', $data);
		}
		catch(\Exception $e) {
			$data['error'] = $e->getMessage();
			$data['user'] = $user;
			$this->view('account/updateaccount', $data);
		}
	}

	private function createUser($user, $currentPassword): ?User {
		$email = htmlspecialchars(strtolower($_POST['email']));
		$name = htmlspecialchars($_POST['firstname'] . ' ' . $_POST['surname']);
		$newpassword = htmlspecialchars($_POST['newpassword']);
		$newpasswordConfirm = htmlspecialchars($_POST['newpasswordconfirm']);
		$phone = htmlspecialchars($_POST['phone']);
		$country = htmlspecialchars($_POST['country']);
		
		if ($newpassword == "" && $newpasswordConfirm == "") {
			$newpassword = $currentPassword;
			$newpasswordConfirm = $currentPassword;
		} else if ($newpassword != $newpasswordConfirm) {
			throw new \Exception("New passwords do not match");
		} else if (!$this->verifyNewPassword($newpassword)) {
			throw new \Exception("Password must be at least 8 characters long, contain a special character and a number");
		}
		
		if ($email != $user->getEmail()) {
			$check = $this->userService->getUserByEmail($email);
			if ($check !== null) {
				throw new \Exception("Email already exists");
			}
		}
		
		return $this->userService->updateExistingUser($user, $email, $name, $newpassword, $phone, $country);
	}

	//all the checks :)

	//check if the email is already in use
	private function checkEmail($email) {
		$check = $this->userService->getUserByEmail($email);
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
			preg_match('/[!@#$%^&*()_+=\-{};:"<>,.\/?]/', $password) && 
			preg_match('/\d/', $password)
		) {
			return true;
		}
		return false;
	}
}