<?php

namespace Repositories;

use Exception;
use Models\User;

class UserRepository extends BaseRepository{
    // ~~Create~~
    public function create($user) : User {
        try{
            $sql = "INSERT INTO Users (role, name, email, password, phone, country) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                $user->getRole(),
                $user->getName(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getPhone(),
                $user->getCountry()
            ]);
            return $this->getUser($user['email']);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
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

    // ~~Read~~
    public function getAllUsers($limit, $offset, $search) : array {
        try{
            $sql = "SELECT * 
                    FROM users 
                    WHERE username LIKE :search 
                    OR email LIKE :search 
                    ORDER BY username
                    LIMIT :limit 
                    OFFSET :offset";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->bindParam(':search', $search);
            $stmt->execute();
            
            $users = [];
            while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                $users[] = $this->createUser($row);
            }
            return $users;
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

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

    // ~~Update~~

    // ~~Delete~~

}