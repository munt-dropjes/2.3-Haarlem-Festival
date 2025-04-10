<?php

namespace Controllers;

use Services\HomeService;
use Services\WysiwygService;

class HomeController extends Controller {
    private HomeService $homeService;
    private WysiwygService $wysiwygService;

    public function __construct() {
        $this->homeService = new HomeService();
        $this->wysiwygService = new WysiwygService();
    }

    public function index() {
        $this->view('home/index', ['homepage' => $this->homeService->getContent()]);
    }

    public function wysiwig() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->homeService->saveContent($_POST['wysiwyg']);
        }
        $homepage = $this->homeService->getContent();

        $this->wysiwygService->render($homepage->getData(), '/home/wysiwig');
    }
}