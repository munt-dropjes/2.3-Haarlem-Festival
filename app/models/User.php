<?php
namespace Models;
class User {
    private $id;
    private $username;
    private $password;
    private $height;
    private $weight;
    private $age;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUserName(): string
    {
        return $this->username;
    }

    public function setUserName(string $userName): self
    {
        $this->username = $userName;

        return $this;
    }

    public function getPassword(): string
    {
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

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(string $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getAge(): string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }
}
?>