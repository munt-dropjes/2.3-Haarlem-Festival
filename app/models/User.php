<?php
namespace Models;

class User {
    private $UserID;
    private $Role;
    private $Name;
    private $Email;
    private $Password;
    private $Phone;
    private $Country;
    private $Verified;
    private $ResetToken;

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
        return $this->Password;
    }

    public function setPassword(string $password): self
    {
        $this->Password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function setPasswordOnLogin(string $password) :self
    {
        $this->Password = $password;
        return $this;
    }

    public function getPhone() {
        return $this->Phone;
    }

    public function setPhone($phone) {
        $this->Phone = $phone;
        return $this->Phone;
    }

    public function getCountry() {
        return $this->Country;
    }

    public function setCountry($country) {
        $this->Country = $country;
        return $this->Country;
    }

    public function getRole() {
        return $this->Role;
    }

    public function setRole($Role) {
        $this->Role = $Role;
        return $this->Role;
    }

    public function getVerified() {
        return $this->Verified;
    }

    public function setVerified($verified) {
        $this->Verified = $verified;
        return $this->Verified;
    }

    public function getResetToken() {
        return $this->ResetToken;
    }

    public function setResetToken($resetToken) {
        $this->ResetToken = $resetToken;
        return $this->ResetToken;
    }

}
?>