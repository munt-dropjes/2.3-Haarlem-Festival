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
    public function create($user) : User {
        return $this->userRepository->create($this->createUser(
            $user['email'],
            $user['name'],
            $user['password'],
            $user['phone'],
            $user['country']
        ));
    }

    public function insert($user) {
        if ($this->userRepository->checkEmail($user)){
            throw new \Exception("Email already exists");
        }
        $this->userRepository->insert($user);        
    }

    // ~~Read~~
    public function getAllUsers($limit, $offset, $search) : array {
        return $this->userRepository->getAllUsers($limit, $offset, $search);
    }

    private function GetUser(User $user) {
        if (empty($user->getEmail()) || empty($user->getPassword())) {
            throw new \InvalidArgumentException("Email and password cannot be empty.");
        }
        $dbUser = $this->userRepository->retrieveUser($user);
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
    public function update($user, $email) : User {
        return $this->userRepository->update($user);
    }

    // ~~Delete~~
    public function delete($email) : void {
        $this->userRepository->delete($email);
    }

    public function login($email, $password) {
        $user = new User();
        $user->setEmail($email);
        $user->setPasswordOnLogin($password);
        $authenticatedUser = $this->GetUser($user);
        return $authenticatedUser;
    }

    // ~~ Private Methods ~~

    private function createUser($email, $name, $password, $phone, $country) {
        $user = new User();
        $user->setRole(roleEnum::CUSTOMER);
        $user->setEmail($email);
        $user->setName($name);
        $user->setPassword($password);
        $user->setPhone($phone);
        $user->setCountry($country); 
        return $user;
    }
}
?>
