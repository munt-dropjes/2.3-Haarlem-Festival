<?php

namespace Controllers;

use Services\StrollService;

class StrollDetailController extends Controller {
    private $strollService;

    public function __construct() {
        $this->strollService = new StrollService();
    }
    public function index() {
        $detailIndex = $_GET["detailPage"];
        $data = $this->strollService->getDetail($detailIndex);
        $this->view('stroll/detail', $data);
    }
}