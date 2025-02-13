<?php

namespace Controllers;

use Services\YummieService;
use Repositories\YummieRepository;

class YummieController extends Controller {
    private YummieService $service;

    public function __construct() {
        $repository = new YummieRepository();
        $this->service = new YummieService($repository);
    }

    public function index() {
        $filters = $_GET ?? [];

        // ✅ Check of er filters zijn geselecteerd
        if (empty(array_filter($filters))) {
            $restaurants = $this->service->getAllRestaurants();
        } else {
            $restaurants = $this->service->getFilteredRestaurants($filters);
        }


        $this->view('yummie/overview', ['restaurants' => $restaurants]);
    }
}
