<?php

namespace Repositories;

use Models\Home;
use PDO;

class HomeRepository extends BaseRepository
{
    public function getContent(): Home
    {
        try {
			$sql = "SELECT * FROM HomePage";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Models\Home');
            $homepage = $stmt->fetch();
            return $homepage ?: null;
		} catch (Exception $e) {
			throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get the homepage");
		}
    }

    public function saveContent(string $data): void
    {
        try {
            $sql = "UPDATE HomePage SET data = :data WHERE id = 1";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':data', $data, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to save the homepage content");
        }
    }
}