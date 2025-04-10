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
        $this->view('home/index', $this->homeService->getContent());
    }

    public function wysiwig() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->homeService->saveContent($_POST['wysiwyg']);
        }
        $this->wysiwygService->render($this->homeService->getContent(), '/home/wysiwig');
    }
}