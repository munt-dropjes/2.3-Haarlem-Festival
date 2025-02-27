<?php

namespace Controllers;

class StrollController extends Controller {
    public function index() {
        $this->view("stroll/index");
    }
}