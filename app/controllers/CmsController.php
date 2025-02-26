<?php

namespace Controllers;

use Services\UserService;

class CmsController extends Controller {

    // all cms routes will be automically checked for authentication

    public function index() {
        $this->view('cms/index');
    }

    public function users() {
        $userService = new UserService();
        $limit = $_GET['limit'] ?? 10;
        $offset = $_GET['offset'] ?? 0;
        $search = $_GET['search'] ?? '';

        // check if the limit and offset are valid
        if ((!is_numeric($offset) || !is_numeric($limit)) || ($offset < 0 || $limit < 1)) {
            $currentUri = $_SERVER['REQUEST_URI'];
            $search = explode('search=', $currentUri)[1] ?? "";
            header('Location: /cms/users?limit=10&offset=0&search=' . $search);
        }

        $this->view('cms/users', [
            'users' => $this->userService->getAllUsers(),
            'totalEntries' => $this->userService->countTotalUsers(),
            'limit' => $limit,
            'offset' => $offset,
            'search' => $search
        ]);
    }
}