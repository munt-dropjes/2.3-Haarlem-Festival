<?php

namespace Repositories;

use Models\ReservationModel;
use PDO;

class ReservationRepository extends BaseRepository {

    public function addReservation(ReservationModel $reservation): bool {
        $sql = "INSERT INTO restaurant_reservations (restaurant_id, adults, children, day, start_time, total_price, extra_information, created_at) 
                VALUES (:restaurant_id, :adults, :children, :day, :start_time, :total_price, :extra_information, NOW())";
        
        $stmt = $this->connection->prepare($sql);
        
        return $stmt->execute([
            ':restaurant_id' => $reservation->restaurant_id,
            ':adults' => $reservation->adults,
            ':children' => $reservation->children,
            ':day' => $reservation->day,
            ':start_time' => $reservation->start_time,
            ':total_price' => $reservation->total_price,
            ':extra_information' => $reservation->extra_information        
        ]);
    }

    public function getReservationsPerTimeslot(int $restaurantId, string $day): array {
        $query = "SELECT start_time, SUM(adults + children) AS total_reserved 
                  FROM restaurant_reservations 
                  WHERE restaurant_id = :restaurant_id AND day = :day
                  GROUP BY start_time";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':restaurant_id', $restaurantId, PDO::PARAM_INT);
        $stmt->bindParam(':day', $day, PDO::PARAM_STR);
        $stmt->execute();
        
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $occupiedSlots = [];
        foreach ($reservations as $slot) {
            $occupiedSlots[$slot['start_time']] = $slot['total_reserved'];
        }

        return $occupiedSlots;
    }
}
