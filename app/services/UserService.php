<?php
namespace Services;
use Models\User;
use Repositories\UserRepository;
use Enums\roleEnum;

class UserService {

    private $repository;

    public function __construct() {
        $this->repository = new UserRepository();
    }

    public function insert($user) {
        if ($this->repository->checkEmail($user)){
            throw new \Exception("Email already exists");
        }
        $this->repository->insert($user);        
    }
    
    public function login($email, $password) {
        $user = new User();
        $user->setEmail($email);
        $user->setPasswordOnLogin($password);
        $authenticatedUser = $this->GetUser($user);
        return $authenticatedUser;
    }

    private function GetUser(User $user) {
        if (empty($user->getEmail()) || empty($user->getPassword())) {
            throw new \InvalidArgumentException("Email and password cannot be empty.");
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
}
?>