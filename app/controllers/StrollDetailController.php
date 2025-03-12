<?php

namespace Controllers;

use Services\StrollService;
use Models\StrollDetail;

class StrollDetailController extends Controller {
    private $strollService;

    public function __construct() {
        $this->strollService = new StrollService();
    }

    public function index() {
        $detailIndex = $_GET["location"];
        $detail = $this->strollService->getDetail($detailIndex);
        $this->view('stroll/detail', ['detail' => $detail]);
    }
}
?>