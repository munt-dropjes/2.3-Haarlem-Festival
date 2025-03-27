<?php

namespace Controllers;

use Controllers\Controller;
use Services\ForgotPasswordService;
use Services\UserService;
use Services\MailerService;
use Exception;

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
        if(!isset($_POST['email'])) {
            $this->view('forgotPassword/index');
            return;
        }

        $email = htmlspecialchars(strtolower($_POST['email']));
        try {
            $user = $this->userService->getUserByEmail($email);
            if (!$user) {
                $this->view('forgotPassword/index', ['error' => 'No user found with that email']);
                return;
            }
            $this->forgotPasswordService->createResetToken($user);
            $this->mailerService->sendMail($user->getEmail(), $user->getName(), 'Password Reset', 'Please click the following link to reset your password: <a href="' . $_SERVER['HTTP_HOST'] . '/resetpassword/' . $user->getEmail() . '/' . $user->getResetToken() . '">Reset Password</a>');
            $this->view('forgotPassword/index', ['message' => 'Password reset email sent']);
        } catch(Exception $e) {
            $this->view('forgotPassword/index', ['error' => $e->getMessage()]);
        }
    }  

    public function reset($email, $resetToken) {
        if(isset($_POST['password']) && isset($_POST['confirmPassword'])) {
            $password = htmlspecialchars($_POST['password']);
            $confirmPassword = htmlspecialchars($_POST['confirmPassword']);
            if($password == $confirmPassword) {
                try {
                    $user = $this->userService->getUserByEmail($email);
                    if($user->getResetToken() == $resetToken && strtotime($user->getResetTokenExpiration()) > time()) {
                        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
                        $user->setResetToken(null);
                        $user->setResetTokenExpiration(null);
                        $this->userService->updateUser($user, $user->getId());
                        $this->view('login/login', ['error' => 'Password reset successfully']);
                    } else {
                        $this->view('forgotPassword/reset', ['error' => 'Invalid reset token']);
                    }
                } catch(Exception $e) {
                    $this->view('forgotPassword/reset', ['error' => $e->getMessage()]);
                }
            } else {
                $this->view('forgotPassword/reset', ['error' => 'Passwords do not match']);
            }
        } else {
            $this->view('forgotPassword/reset', ['resetToken' => $resetToken, 'email' => $email]);
        }
    }
}