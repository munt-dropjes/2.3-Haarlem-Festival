<?php
namespace Controllers;

use Controllers\Controller;
use Services\UserService;
use Models\User;
use Services\MailerService;

class AccountController extends Controller {

	private $userservice;

	public function __construct() {
		$this->userservice = new UserService();
	}

	public function index() {
		$this->view('account/index');
	}

}