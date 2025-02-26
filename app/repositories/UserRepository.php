<?php

namespace Repositories;

use Exception;
use Models\User;

class UserRepository extends BaseRepository{
    // ~~Create~~
    public function insertUser($user) : User {
        try{
            $sql = "INSERT INTO Users (Role, Name, Email, Password, Phone, Country) 
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
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to create user: " . $user->email);
        }
    }

    // ~~Read~~
    public function getAllUsers($limit, $offset, $search) : array {
        try{
            $sql = "SELECT * 
                    FROM Users 
                    WHERE Name LIKE :search 
                    OR Email LIKE :search 
                    ORDER BY Email
                    LIMIT :limit 
                    OFFSET :offset";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->bindParam(':search', $search);

            $stmt->execute();
            
            $users = [];
            while($row = $stmt->fetch(\PDO::FETCH_OBJ)){
                $users[] = $this->createUser($row);
            }
            return $users;
        }
        catch(Exception $e){
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get all users");
        }
    }

    public function getUser($user): ?User
    {
        try{
            $email = $user->getEmail();
            $stmt = $this->connection->prepare("SELECT * FROM Users WHERE Email = :email");
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Models\User');
            $fetchedUser = $stmt->fetch();
            return $fetchedUser ?: null;
        }
        catch(Exception $e){
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get user: " . $user->email);
        }
    }

    public function countTotalUsers() : int {
        try{
            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM Users");
            $stmt->execute();
            return $stmt->fetchColumn();
        }
        catch(Exception $e){
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to count total users");
        }
    }

    public function checkEmail($user): bool
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM Users WHERE Email = ?");
            $stmt->execute([$user->getEmail()]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($user) {
                    return true;
            } else {
                    return false;
            }
        } 
        catch(Exception $e){
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to check email: " . $user->email);
        }
    }

    // ~~Update~~
    public function updateUser($user) : User {
        try{
            $sql = "UPDATE Users 
                    SET Role = ?, Name = ?, Email = ?, Password = ?, Phone = ?, Country = ?
                    WHERE Email = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                $user->getRole(),
                $user->getName(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getPhone(),
                $user->getCountry(),
                $user->getEmail()
            ]);
            return $this->getUser($user);
        }
        catch(Exception $e){
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to update user: " . $user->email);
        }
    }

    // ~~Delete~~
    public function deleteUser($email) : void {
        try{
            $sql = "DELETE FROM Users WHERE Email = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$email]);
        }
        catch(Exception $e){
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to delete user: " . $email);
        }
    }

}