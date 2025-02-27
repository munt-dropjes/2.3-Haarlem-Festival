<?php

namespace Controllers;

use Services\UserService;
use Models\User;

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

        if (isset($_POST['delete'])) {
            $userService->deleteUser($_GET['delete']);
        }

        if (isset($_POST['edit'])) {
            $updateUser = new User();
            $updateUser->setRole($_POST['role']);
            $updateUser->setName($_POST['name']);
            $updateUser->setEmail($_POST['email']);
            $updateUser->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $updateUser->setPhone($_POST['phone']);
            $updateUser->setCountry($_POST['country']);
            $userService->updateUser($updateUser, $_POST['email']);
        }

        if (isset($_POST['create'])) {
            $user = new User();
            $user->setRole($_POST['role']);
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $user->setPhone($_POST['phone']);
            $user->setCountry($_POST['country']);
            $userService->insertUser($user);
        }

        // check if the limit and offset are valid
        if ((!is_numeric($offset) || !is_numeric($limit)) || ($offset < 0 || $limit < 1)) {
            $currentUri = $_SERVER['REQUEST_URI'];
            $search = explode('search=', $currentUri)[1] ?? "";
            header('Location: /cms/users?limit=10&offset=0&search=' . $search);
        }

        $this->view('cms/users', [
            'users' => $userService->getAllUsers($limit, $offset, $search),
            'totalEntries' => $userService->countTotalUsers(),
            'limit' => $limit,
            'offset' => $offset,
            'search' => $search
        ]);
    }
}