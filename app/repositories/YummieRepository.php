<?php

namespace Repositories;

use Models\YummieModel;

class YummieRepository extends BaseRepository {

    public function getAllRestaurants(array $params = []): array {
        $sql = "SELECT * FROM restaurants WHERE 1=1";
        $queryParams = [];

        if (!empty($params['cuisine'])) {
            $sql .= " AND cuisine LIKE :cuisine";
            $queryParams[':cuisine'] = "%" . $params['cuisine'] . "%";
        }
        if (!empty($params['rating'])) {
            $sql .= " AND rating = :rating";
            $queryParams[':rating'] = (int)$params['rating'];
        }
        if (!empty($params['start_time'])) {
            $sql .= " AND open_time = :start_time";
            $queryParams[':start_time'] = $params['start_time'];
        }
        if (!empty($params['cost'])) {
            $sql .= " AND cost = :cost";
            $queryParams[':cost'] = $params['cost'];
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($queryParams);
        $restaurants = [];

        while ($row = $stmt->fetch()) {
            $restaurants[] = new YummieModel(
                $row['id'],
                $row['name'],
                $row['rating'],
                $row['cuisine'],
                $row['open_time'],
                $row['image']
            );
        }

        return $restaurants;
    }
}
