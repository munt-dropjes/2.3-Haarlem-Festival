<?php

namespace Controllers;

use Services\ReservationService;
use Models\ReservationModel;
use Services\YummieService;

class ReservationController extends Controller
{
    private $reservationService;
    private $yummieService;

    public function __construct()
    {
        $this->reservationService = new ReservationService();
        $this->yummieService = new YummieService();
    }

    // ✅ Haal beschikbare tijdsloten op via de service
    public function getAvailableTimeSlots(): void
    {
        header('Content-Type: application/json');

        $restaurantId = $_POST['restaurant_id'] ?? null;
        $day = $_POST['day'] ?? null;

        if (!$restaurantId || !$day) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            exit;
        }
        
        $availableSlots = $this->reservationService->getAvailableTimeSlots((int) $restaurantId, $day);
        echo json_encode(['timeslots' => $availableSlots]);
        exit;
    }

    // ✅ Verwerk een reservering
    public function processReservation($restaurantId): void
    {
        $restaurant = $this->yummieService->getRestaurantById($restaurantId);
        if (!$restaurant) {
            echo json_encode(['error' => 'Restaurant not found.']);
            return;
        }

        $images = $this->yummieService->getImagesByRestaurantId($restaurant->id);


        // ✅ Sla de reservering op in de database
        $reservation = new ReservationModel();
        $reservation->restaurant_id = $_POST['restaurant_id'];
        $reservation->adults = $_POST['adults'];
        $reservation->children = $_POST['children'];
        $reservation->day = $_POST['day'];
        $reservation->start_time = $_POST['start_time'];
        $reservation->total_price = ReservationService::calculateTotalPrice($restaurant, $_POST['adults'], $_POST['children']);
        $reservation->extra_information = $_POST['extra_info'];

        $this->reservationService->addReservation($reservation);

        $this->view('yummie/detail', [
            'restaurant' => $restaurant,
            'menuItems' => $restaurant->menu_items,
            'images' => $images,
            'message' => 'Reservation successful!'
        ]);
    }

}
