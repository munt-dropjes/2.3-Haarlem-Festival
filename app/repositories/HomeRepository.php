<?php

namespace Repositories;

use Models\Home;

class HomeRepository extends BaseRepository
{
    public function getContent(): string
    {
        try {
			$sql = "SELECT * FROM HomePage";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
			$obj = $stmt->fetchAll(PDO::FETCH_CLASS, 'Models\Home');
			return $obj;
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