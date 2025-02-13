<?php
namespace Models;
use enums\roleEnum;
class User {
    private $UserID;
    private $Role;
    private $Name;
    private $Email;
    private $password;
    private $verified;

    //for account creation
    public function __construct($Name, $Email, $password) {
        $this->Role = roleEnum::CUSTOMER;
        $this->Name = $Name;
        $this->Email = $Email;
        $this->password = $password;
    }


    public function getID() {
        return $this->UserID;
    }
    public function getName() {
        return $this->Name;
    }
    public function getEmail() {
        return $this->Email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getRole() {
        return $this->Role;
    }
    public function getVerified() {
        return $this->verified;
    }
}
?>