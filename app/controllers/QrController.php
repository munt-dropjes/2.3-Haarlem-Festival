<?php

namespace Controllers;

use Services\QrService;
use Exception;

class QrController extends Controller
{
    private $qrService;

    public function __construct()
    {
        $this->qrService = new QrService();
    }

    public function index()
    {
        if (isset($_GET['ticket'])) {
            try {
                $this->qrService->checkTicket($_GET['ticket']);
            } catch (Exception $e) {
                $this->view_clean('qr/index', ['error' => $e->getMessage()]);
                return;
            }
            $this->view('qr/index');
        }
        $this->view_clean('qr/index');
    }

    public function create()
    {
        $ticket = new \Models\Ticket(1, 2, 1, null, 1, time(), "Test", []);

        $qrCode = $this->qrService->createQrCode($ticket);

        $this->view_clean('qr/create', ['qr_code' => $qrCode]);
    }

}