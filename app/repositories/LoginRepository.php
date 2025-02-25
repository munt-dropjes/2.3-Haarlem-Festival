<?php

namespace Repositories;

use Models\User;


class LoginRepository extends BaseRepository
{
    public function retrieveUser($user): ?User
    {
        $username = $user->getUserName();
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE username = :user_id");
        $stmt->bindParam(':user_id', $username, \PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'user');
        $fetchedUser = $stmt->fetch();
        return $fetchedUser ?: null;
    }
}