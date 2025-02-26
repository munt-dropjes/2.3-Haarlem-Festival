<?php

namespace Services;

use Exception;
use Models\User;
use Repositories\UserRepository;

class UserService {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    // ~~Create~~
    public function create($user) : User {
        return $this->userRepository->create($user);
    }

    // ~~Read~~
    public function getAllUsers($limit, $offset, $search) : array {
        return $this->userRepository->getAllUsers($limit, $offset, $search);
    }

    public function getUser($email) : User {
        return $this->userRepository->getUser($email);
    }

    public function countTotalUsers() : int {
        return $this->userRepository->countTotalUsers();
    }

    // ~~Update~~
    public function update($user, $email) : User {
        return $this->userRepository->update($user);
    }

    // ~~Delete~~
    public function delete($email) : void {
        $this->userRepository->delete($email);
    }
}