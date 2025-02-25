<?php

namespace Services;

use Models\User;
use Repositories\LoginRepository;

class LoginService {
    private $repository;

    public function __construct() {
        $this->repository = new LoginRepository();
    }

    public function check(User $user) {
        if (empty($user->getEmail()) || empty($user->getPassword())) {
            throw new \InvalidArgumentException("Username and password cannot be empty.");
        }
        $dbUser = $this->repository->retrieveUser($user);
        if ($dbUser === null) {
            throw new \InvalidArgumentException("User not found.");
        }
        if (password_verify($user->getPassword(), $dbUser->getPassword())) {
            return $dbUser; 
        }
        return null;
    }
}
?>