<?php

namespace Repositories;

use Models\MenuItemModel;
use Models\YummieModel;
use PDO;

class YummieRepository extends BaseRepository
{

    public function getAllRestaurants(array $params = []): array
    {
        $sql = "SELECT * FROM restaurants WHERE 1=1";
        $queryParams = [];

        if (!empty($params['duration'])) {
            $sql .= " AND duration = :duration";
            $queryParams[':duration'] = (float) $params['duration'];
        }

        if (!empty($params['cuisine'])) {
            $sql .= " AND JSON_CONTAINS(cuisine, :cuisine)"; // 🚀 FIX: JSON CONTAINS
            $queryParams[':cuisine'] = json_encode($params['cuisine']); // 🚀 JSON-encoderen
        }

        if (!empty($params['rating'])) {
            $sql .= " AND rating = :rating";
            $queryParams[':rating'] = (int) $params['rating'];
        }

        if (!empty($params['open_time'])) {
            $sql .= " AND open_time = :open_time";
            $queryParams[':open_time'] = $params['open_time'];
        }

        if (!empty($params['cost'])) {
            $sql .= " AND cost = :cost";
            $queryParams[':cost'] = (float) $params['cost'];
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($queryParams);
        $restaurants = [];

        while ($row = $stmt->fetch()) {
            $row['cuisine'] = json_decode($row['cuisine'], true) ?: []; // 🚀 FIX: JSON omzetten naar array

            $menu_items = $this->getMenuItemsByRestaurantId($row['id']); // 🚀 FIX: Menu-items ophalen

            $restaurants[] = new YummieModel(
                $row['id'],
                $row['name'],
                $row['rating'],
                $row['cuisine'],
                $row['seats'],
                $row['open_time'],
                (float) $row['duration'],
                $row['duration'],
                $row['sessions'],
                $row['cost'],
                $row['image'],
                $row['address'],
                $row['city'],
                $row['zipcode'],
                $row['map_link'],
                $row['extra_info_menu'],
                $menu_items
            );
        }

        return $restaurants;
    }

    public function getRestaurantById(int $id): ?YummieModel
    {
        $sql = "SELECT * FROM restaurants WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        $row['cuisine'] = json_decode($row['cuisine'], true) ?: []; // 🚀 FIX: JSON omzetten naar array

        $menu_items = $this->getMenuItemsByRestaurantId($id); // 🚀 FIX: Menu-items ophalen

        return new YummieModel(
            $row['id'],
            $row['name'],
            $row['rating'],
            $row['cuisine'],
            $row['seats'],
            $row['open_time'],
            $row['close_time'],
            $row['duration'],
            $row['sessions'],
            $row['cost'],
            $row['image'],
            $row['address'],
            $row['city'],
            $row['zipcode'],
            $row['map_link'],
            $row['extra_info_menu'],
            $menu_items
        );
    }
    public function getMenuItemsByRestaurantId(int $restaurantId): array
    {
        $sql = "SELECT id, name, description, category FROM menu_items WHERE restaurant_id = :restaurant_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':restaurant_id' => $restaurantId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, MenuItemModel::class);
    }
    public function getUniqueDurations(): array
    {
        $stmt = $this->connection->query("SELECT DISTINCT duration FROM restaurants ORDER BY duration ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getUniqueOpenTimes(): array
    {
        $stmt = $this->connection->query("SELECT DISTINCT open_time FROM restaurants ORDER BY open_time ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getUniqueCuisines(): array
    {
        $stmt = $this->connection->query("
        SELECT DISTINCT json_table.cuisine
        FROM restaurants,
        JSON_TABLE(cuisine, '$[*]' COLUMNS (cuisine VARCHAR(255) PATH '$')) AS json_table
        ORDER BY json_table.cuisine ASC
    ");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getUniqueCosts(): array
    {
        $stmt = $this->connection->query("SELECT DISTINCT cost FROM restaurants ORDER BY cost ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getUniqueRatings(): array {
        $stmt = $this->connection->query("SELECT DISTINCT rating FROM restaurants ORDER BY rating ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getImagesByRestaurantId(int $restaurantId): array {
        $stmt = $this->connection->prepare("SELECT image_path FROM restaurant_images WHERE restaurant_id = :restaurantId");
        $stmt->execute([':restaurantId' => $restaurantId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

}
