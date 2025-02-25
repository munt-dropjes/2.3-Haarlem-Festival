<?php
namespace Models;

class User {
    private $UserID;
    private $Role;
    private $Name;
    private $Email;
    private $password;
    private $phone;
    private $country;
    private $verified;

    public function getID() {
        return $this->UserID;
    }
    public function getName() {
        return $this->Name;
    }

    public function setName($Name) {
        $this->Name = $Name;
        return $this->Name;
    }

    public function getEmail() {
        return $this->Email;
    }

    public function setEmail($Email) {
        $this->Email = $Email;
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

    public function setPasswordOnLogin(string $password) :self
    {
        $this->password = $password;
        return $this;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this->phone;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
        return $this->country;
    }

    public function getRole() {
        return $this->Role;
    }

    public function setRole($Role) {
        $this->Role = $Role;
        return $this->Role;
    }

    public function getVerified() {
        return $this->verified;
    }

    public function setVerified($verified) {
        $this->verified = $verified;
        return $this->verified;
    }

}
?>