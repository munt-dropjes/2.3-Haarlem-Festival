<?php

namespace Repositories;

use Models\User;


class UserRepository extends BaseRepository
{
    public function retrieveUser($email): ?User
    {
        $stmt = $this->connection->prepare("SELECT * FROM Users WHERE Email = :email");
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Models\User');
        $fetchedUser = $stmt->fetch();
        return $fetchedUser ?: null;
    }

    public function insert($user)
        {
                $stmt = $this->connection->prepare("INSERT INTO Users (role, name, email, password, phone, country) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                $user->getRole(),
                $user->getName(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getPhone(),
                $user->getCountry()
                ]);
        }

    public function checkEmail($user): bool
        {
                $stmt = $this->connection->prepare("SELECT * FROM Users WHERE email = ?");
                $stmt->execute([$user->getEmail()]);
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($user) {
                        return true;
                } else {
                        return false;
                }
        }
}