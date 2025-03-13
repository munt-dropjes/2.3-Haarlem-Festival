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


    public function detail() {
        $detailIndex = $_GET["location"];
        $detail = $this->strollService->getDetail($detailIndex);
        $eventName = $detail->getStopName();
		$encodedEventName = str_replace(' ', '', $eventName);
		$serverPath = $_SERVER['DOCUMENT_ROOT'] . "/images/StrollDetails/$encodedEventName/Carousel";
        $this->view('stroll/detail', ['detail' => $detail, 'serverPath' => $serverPath, 'eventName' => $eventName]);
    }
}