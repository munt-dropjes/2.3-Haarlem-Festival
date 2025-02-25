<?php
namespace Models;
use Enums\roleEnum;
class User {
    private $UserID;
    private $Role;
    private $Name;
    private $Email;
    private $password;
    private $phone;
    private $country;
    private $verified;

    //for account creation
    public function __construct($Name, $Email, $password, $phone, $country) {
        $this->Role = roleEnum::CUSTOMER;
        $this->Name = $Name;
        $this->Email = $Email;
        $this->setPassword($password);
        $this->phone = $phone;
        $this->country = $country;
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

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function getPhone() {
        return $this->phone;
    }
    public function getCountry() {
        return $this->country;
    }
    public function getRole() {
        return $this->Role;
    }
    public function getVerified() {
        return $this->verified;
    }

}
?>