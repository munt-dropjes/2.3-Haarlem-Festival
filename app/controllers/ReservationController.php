<?php

namespace Controllers;

use Repositories\ReservationRepository;
use Services\ReservationService;
use Repositories\YummieRepository;
use Models\ReservationModel;

class ReservationController extends Controller
{
    private ReservationService $reservationService;
    private ReservationRepository $reservationRepository;
    private YummieRepository $yummieRepository;

    public function __construct()
    {
        $this->reservationService = new ReservationService();
        $this->reservationRepository = new ReservationRepository();
        $this->yummieRepository = new YummieRepository();
    }

    // ✅ Haal beschikbare tijdsloten op via de service
    public function getAvailableTimeSlots(): void
    {
        header('Content-Type: application/json');

        $restaurantId = $_POST['restaurant_id'] ?? null;
        $day = $_POST['day'] ?? null;

        if (!$restaurantId || !$day) {
            echo json_encode(['error' => 'Missing parameters']);
            exit;
        }

        $availableSlots = $this->reservationService->getAvailableTimeSlots((int) $restaurantId, $day);
        echo json_encode(['timeslots' => $availableSlots]);
        exit;
    }

    // ✅ Verwerk een reservering
    public function processReservation(): void
    {
        $restaurant = $this->yummieRepository->getRestaurantById($_POST['restaurant_id']);
        if (!$restaurant) {
            echo json_encode(['error' => 'Restaurant not found.']);
            return;
        }

        $images = $this->yummieRepository->getImagesByRestaurantId($restaurant->id);

        
        // ✅ Sla de reservering op in de database
        $reservation = new ReservationModel();
        $reservation->restaurant_id = $_POST['restaurant_id'];
        $reservation->adults = $_POST['adults'];
        $reservation->children = $_POST['children'];
        $reservation->day = $_POST['day'];
        $reservation->start_time = $_POST['start_time'];
        $reservation->total_price = ReservationService::calculateTotalPrice($restaurant, $_POST['adults'], $_POST['children']);
        $reservation->extra_information = $_POST['extra_info'];
        
        $this->reservationRepository->addReservation($reservation);

        $this->view('yummie/detail', [
            'restaurant' => $restaurant,
            'menuItems' => $restaurant->menu_items,
            'images' => $images,
            'message' => 'Reservation successful!'
        ]);
    }

}
