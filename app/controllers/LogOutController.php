<?php

namespace Controllers;

class LogOutController extends Controller {
    public function index() {
        session_start();
        session_destroy();
        $this->view('logout/logout');
        exit;
    }
}