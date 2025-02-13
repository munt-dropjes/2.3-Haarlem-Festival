<?php

namespace Repositories;

use PDOException;

class BaseRepository{
    protected $connection;

    public function __construct(){
        require __DIR__ . '/../dbconfig.php';

        try {
            $this->connection = new \PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}