<?php

namespace Controllers;

use Services\UserService;
use Models\User;

class CmsUserController extends Controller {
    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    // all cms routes will be automically checked for authentication
    public function index() {
        $limit = $_GET['limit'] ?? 10;
        $offset = $_GET['offset'] ?? 0;
        $search = $_GET['search'] ?? '';

        // check if the limit and offset are valid
        if ((!is_numeric($offset) || !is_numeric($limit)) || ($offset < 0 || $limit < 1)) {
            $currentUri = $_SERVER['REQUEST_URI'];
            $search = explode('search=', $currentUri)[1] ?? "";
            header('Location: /cms/users?limit=10&offset=0&search=' . $search);
        }

        $this->view('cms/users/index', [
            'users' => $this->userService->getAllUsers($limit, $offset, $search),
            'totalEntries' => $this->userService->countTotalUsers(),
            'limit' => $limit,
            'offset' => $offset,
            'search' => $search
        ]);
    }

    public function create(){
        if (!isset($_POST['create'])) {
            header('Location: /cms/users');
        }

        $user = new User();
        $user->setRole($_POST['role']);
        $user->setName($_POST['name']);
        $user->setEmail($_POST['email']);
        $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
        $user->setPhone($_POST['phone']);
        $user->setCountry($_POST['country']);
        $this->userService->insertUser($user);
    }

    public function update(){
        if (!isset($_POST['edit'])) {
            header('Location: /cms/users');
        }

        $updateUser = new User();
        $updateUser->setRole($_POST['role']);
        $updateUser->setName($_POST['name']);
        $updateUser->setEmail($_POST['email']);
        $updateUser->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
        $updateUser->setPhone($_POST['phone']);
        $updateUser->setCountry($_POST['country']);
        $this->userService->updateUser($updateUser, $_POST['email']);
    }

    public function delete(){
        if (!isset($_POST['delete'])) {
            header('Location: /cms/users');
        }

        $this->userService->deleteUser($_GET['delete']);
    }
}