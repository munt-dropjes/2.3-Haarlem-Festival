<?php
namespace Repositories;
use Repositories\BaseRepository;
class CreateAccountRepository extends BaseRepository
{
        function insert($user)
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

        function checkEmail($user): bool
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
?>