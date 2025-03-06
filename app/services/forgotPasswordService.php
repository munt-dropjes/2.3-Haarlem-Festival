<?php

namespace Services;

use Models\User;

class ForgotPasswordService {
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    public function getUser(string $email): ?User {
        return $this->userService->getUserByEmail($email);
    }

    public function createResetToken(User $user): void {
        $user->setResetToken(bin2hex(random_bytes(32)));
        $this->userService->updateUser($user, $user->getId());
    }
}