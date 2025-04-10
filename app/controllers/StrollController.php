<?php

namespace Controllers;

use Services\StrollService;
use Models\StrollDetail;
use Services\ShoppingCartService;

class StrollController extends Controller
{
    private $strollService;
    private $shoppingCartService;

    public function __construct()
    {
        $this->strollService = new StrollService();
        $this->shoppingCartService = new ShoppingCartService();
    }
    public function index()
    {
        try {
            $data['events'] = $this->strollService->getAll();
            $data['details'] = $this->strollService->getRoute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            //$this->fourOFour();
            return;
        }
        $this->view('stroll/index', $data);
    }


    public function detail()
    {
        $detailIndex = $_GET["location"];
        $detail = $this->strollService->getDetail($detailIndex);
        $eventName = $detail->getStopName();
        $encodedEventName = str_replace(' ', '', $eventName);
        $serverPath = $_SERVER['DOCUMENT_ROOT'] . "/images/StrollDetails/$encodedEventName/Carousel";
        $images = glob($serverPath . "/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE);
        $this->view('stroll/detail', ['detail' => $detail, 'images' => $images, 'eventName' => $eventName]);
    }
}
