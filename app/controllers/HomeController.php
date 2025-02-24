<?php

namespace Controllers;

class HomeController extends Controller {
    public function index() {
        $this->view('home/index');
    }
}