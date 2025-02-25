<?php

namespace Repositories;

use Models\User;


class LoginRepository extends BaseRepository
{
    public function retrieveUser($user): ?User
    {
        $email = $user->getEmail();
        $stmt = $this->connection->prepare("SELECT * FROM Users WHERE Email = :email");
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Models\User');
        $fetchedUser = $stmt->fetch();
        return $fetchedUser ?: null;
    }
}