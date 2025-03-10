<?php

namespace Controllers;

use Services\StrollService;
use Models\StrollDetail;

class StrollController extends Controller {
    private $strollService;

    public function __construct() {
        $this->strollService = new StrollService();
    }
    public function index() {
        $data['events'] = $this->strollService->getAll();
        $data['details'] = $this->strollService->getRoute();
        $this->view('stroll/index', $data);

    }
}