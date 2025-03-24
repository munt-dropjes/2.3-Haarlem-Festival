<?php

namespace Controllers;

use Services\YummieService;

class YummieController extends Controller
{
    private YummieService $service;

    public function __construct()
    {
        $this->service = new YummieService(); 
    }

    public function index()
    {
        $filters = $_GET; // Haal actieve filters op uit de URL

        // Haal gefilterde restaurants op
        $restaurants = empty($filters)
            ? $this->service->getAllRestaurants()
            : $this->service->getFilteredRestaurants($filters);

        // **⏩ Check of het een AJAX-request is**
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            include __DIR__ . '/../views/components/yummie/restaurant-list.php'; // 🚀 Alleen de restaurantlijst verversen!
            exit;
        }

        // **Normale pagina-aanroep: laad alles in**
        $durations = $this->service->getUniqueDurations();
        $openTimes = $this->service->getUniqueOpenTimes();
        $cuisines = $this->service->getUniqueCuisines();
        $costs = $this->service->getUniqueCosts();
        $ratings = $this->service->getUniqueRatings();

        // **Geef alles door aan de view**
        $this->view('yummie/overview', [
            'restaurants' => $restaurants,
            'durations' => $durations,
            'openTimes' => $openTimes,
            'cuisines' => $cuisines,
            'costs' => $costs,
            'ratings' => $ratings
        ]);
    }


    public function getRestaurantById($id)
    {
        $restaurant = $this->service->getRestaurantById((int) $id);

        if (!$restaurant) {
            http_response_code(404);
            echo "Restaurant not found.";
            return;
        }

        $images = $this->service->getImagesByRestaurantId($restaurant->id);

        $this->view('yummie/detail', ['restaurant' => $restaurant, 'menuItems' => $restaurant->menu_items, 'images' => $images]);
    }
}





