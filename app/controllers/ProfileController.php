<?php

namespace Controllers;

use Services\TicketService;


class ProfileController extends Controller
{
    private $ticketService;
    public function __construct()
    {
        $this->ticketService = new TicketService();
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
        $userId = $_SESSION['user']->getId();
        $data['tickets'] = $this->ticketService->getTicketsByUserId($userId);
        $this->view('account/index', $data);
    }
}