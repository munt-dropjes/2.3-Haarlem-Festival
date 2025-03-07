<?php

namespace Controllers;

use Controllers\Controller;
use Services\ForgotPasswordService;
use Services\UserService;
use Services\MailerService;

class ForgotPasswordController extends Controller {
    private $forgotPasswordService;
    private $userService;
    private $mailerService;

    function __construct()
        {
            $this->forgotPasswordService = new ForgotPasswordService();
            $this->userService = new UserService();
            $this->mailerService = new MailerService();
        }
    public function index() {
        $email = htmlspecialchars(strtolower($_POST['email']));
        $user = $this->userService->getUserByEmail($email);
        if ($user) {
            $this->forgotPasswordService->createResetToken($user);
            $this->mailerService->sendMail($user->getEmail(), $user->getName(), 'Password Reset', 'Please click the following link to reset your password: ' . $_SERVER['HTTP_HOST'] . '/resetpassword/' . $user->getResetToken());
            $this->view('forgotPassword/success');
        } else {
            $this->view('forgotPassword/index', ['error' => 'No user found with that email address']);
        }
    }  

    public function reset($resetToken) {
        
        if ($user) {
            $this->view('forgotPassword/reset', ['resetToken' => $resetToken]);
        } else {
            $this->view('forgotPassword/reset', ['error' => 'Invalid reset token']);
        }
    }
}