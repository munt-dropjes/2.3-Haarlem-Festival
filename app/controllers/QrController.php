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
        $qrcodes = $this->qrService->getAllQrCodes();

        if (isset($_GET['ticket'])) {
            try {
                $this->qrService->scanQrTicket($_GET['ticket']);
            } catch (Exception $e) {
                $this->view_clean('qr/index', ['error' => $e->getMessage()]);
                return;
            }
            $this->view('qr/index', ['qrcodes' => $qrcodes]);
        }
        $this->view_clean('qr/index', ['qrcodes' => $qrcodes]);
    }

    public function create()
    {
        $qrCode = $this->qrService->createQrCode('https://trello.com/b/CYN8S2k4/haarlem-festival');

        $this->view_clean('qr/create', ['qr_code' => $qrCode]);
    }

}