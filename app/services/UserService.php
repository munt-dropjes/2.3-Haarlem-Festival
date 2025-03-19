<?php

namespace Services;

use Exception;
use Models\User;
use Repositories\UserRepository;
use Enums\roleEnum;

class UserService {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    // ~~Create~~
    public function insertUser($user) : User {
        if ($this->userRepository->checkEmail($user)){
            throw new Exception("Email already exists");
        }
        return $this->userRepository->insertUser($user);        
    }

    // ~~Read~~
    public function getAllUsers($limit, $offset, $search) : array {
        return $this->userRepository->getAllUsers($limit, $offset, $search);
    }

    public function getUserByEmail($email) : User {
        return $this->userRepository->getUserByEmail($email);
    }

    //rename validateandgetuser
    private function validateAndGetUser(User $user) {
        if (empty($user->getEmail()) || empty($user->getPassword())) {
            throw new \InvalidArgumentException("Email and password cannot be empty.");
        }
        $dbUser = $this->userRepository->getUser($user);
        if ($dbUser === null) {
            throw new \InvalidArgumentException("User not found.");
        }
        if (password_verify($user->getPassword(), $dbUser->getPassword())) {
            return $dbUser; 
        }
        return null;
    }

    public function countTotalUsers() : int {
        return $this->userRepository->countTotalUsers();
    }

    // ~~Update~~
    public function updateUser($user, $id) : User {
        return $this->userRepository->updateUser($user, $id);
    }

    // ~~Delete~~
    public function deleteUser($email) : void {
        $this->userRepository->deleteUser($email);
    }

    public function login($email, $password) {
        $user = new User();
        $user->setEmail($email);
        $user->setPasswordOnLogin($password);
        $authenticatedUser = $this->validateAndGetUser($user);
        return $authenticatedUser;
    }

    // ~~Rest of the methods~~
    public function create($email, $name, $password, $phone, $country) {
        $user = new User();
        $user->setRole(roleEnum::CUSTOMER);
        $user->setEmail($email);
        $user->setName($name);
        $user->setPassword($password);
        $user->setPhone($phone);
        $user->setCountry($country); 
        return $user;
    }

    public function updateExistingUser($user, $email, $name, $password, $phone, $country) {
        $user->setEmail($email);
        $user->setName($name);
        $user->setPassword($password);
        $user->setPhone($phone);
        $user->setCountry($country); 
        return $user;
    }
}
?>
