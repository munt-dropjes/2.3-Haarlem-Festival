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
        try{
            $data['events'] = $this->strollService->getAll();
            $data['details'] = $this->strollService->getRoute();
        }catch(\Exception $e){
            $this->fourOFour();
        }
        $this->view('stroll/index', $data);

    }
}