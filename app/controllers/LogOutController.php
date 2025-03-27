<?php

namespace Controllers;

class LogOutController extends Controller {
    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $this->view('logout/logout');
        exit;
    }
}