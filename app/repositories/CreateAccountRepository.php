<?php
namespace App\Repositories;
use Repositories\BaseRepository;
class CreateAccountRepository extends BaseRepository
{
        function insert($user)
        {
                $stmt = $this->connection->prepare("INSERT INTO users (username, password, height,weight,age) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([
                $user->getUserName(),
                $user->getPassword(),
                $user->getHeight(),
                $user->getweight(),
                $user->getAge()
                ]);
        }
}
?>