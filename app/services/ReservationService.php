<?php

namespace Services;

use Repositories\ReservationRepository;
use Repositories\YummieRepository;
use Models\ReservationModel;

class ReservationService {
    private $reservationRepository;
    private $restaurantRepository;

    public function __construct() {
        $this->reservationRepository = new ReservationRepository();
        $this->restaurantRepository = new YummieRepository();
    }

    public function getAvailableTimeSlots(int $restaurantId, string $day): array {
        $restaurant = $this->restaurantRepository->getRestaurantById($restaurantId);
        if (!$restaurant) {
            return ['error' => 'Restaurant not found'];
        }

        $max_capacity = $restaurant->sessions;
        $occupiedSlots = $this->reservationRepository->getReservationsPerTimeslot($restaurantId, $day);

        $availableSlots = [];
        foreach ($restaurant->timeSlots as $slot) {
            $start_time = $slot['start'];
            $reserved = $occupiedSlots[$start_time] ?? 0;
            $is_full = $reserved >= $max_capacity;

            $availableSlots[] = [
                'start_time' => $start_time,
                'is_full' => $is_full
            ];
        }

        return $availableSlots;
    }
    
    public static function calculateTotalPrice($restaurant, $adults, $children): float
    {
        $adultPrice = $restaurant->adult_price ?? 0;
        $childPrice = $restaurant->child_price ?? 0;
        
        return ($adults * $adultPrice) + ($children * $childPrice);
    }
    public function addReservation(ReservationModel $reservation): void
    {
        $this->reservationRepository->save($reservation);
    }
}



