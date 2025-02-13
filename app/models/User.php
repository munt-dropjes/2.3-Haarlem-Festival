<?php
namespace Models;
class User {
    private $UserID;
    private $Role;
    private $Name;
    private $Email;
    private $password;
    private $verified;

    public function __construct($UserID, $Role, $Name, $Email, $password, $createdAt) {
        $this->UserID = $UserID;
        $this->Role = $Role;
        $this->Name = $Name;
        $this->Email = $Email;
        $this->password = $password;
        $this->createdAt = $createdAt;
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