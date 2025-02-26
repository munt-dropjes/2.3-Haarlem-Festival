<?php

namespace Repositories;

use Exception;
use Models\User;

class UserRepository extends BaseRepository{
    // ~~Create~~
    public function create($user) : User {
        try{
            $sql = "INSERT INTO users (username, email, password) 
                    VALUES (:username, :email, :password)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => $user['password']
            ]);
            return $this->getUser($user['email']);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
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
            $stmt = $this->db->prepare($sql);
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

    // ~~Update~~

    // ~~Delete~~

}