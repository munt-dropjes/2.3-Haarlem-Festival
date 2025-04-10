<?php

namespace Controllers;

use Services\QrService;
use Exception;
use Models\Ticket;

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
        $ticket = $this->createTicket(); 
        $qrCode = $this->qrService->createQrCode($ticket);

        $this->view_clean('qr/create', ['qr_code' => $qrCode]);
    }

    public function checkTicket()
    {
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!isset($input['ticket'])) {
                echo json_encode(['status' => 'error', 'message' => 'No ticket provided']);
                return;
            }

            $ticket = $input['ticket'];
            $result = $this->qrService->checkTicket($ticket);
            echo json_encode($result);
            echo json_encode(['status' => $result]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    //creates fake qr ticket
    private function createTicket(): Ticket {
        $ticketID = 1; 
        $eventID = 1; 
        $userID = 1; 
        $qrCode = ''; 
        $IsScanned = '0';
        $status = 'Valid'; 
        $purchasedAt = date('d-m-Y H:i:s');
        $eventName = 'Haarlem Festival Event'; 
        $eventDetails = [
            'Date' => date('d-m-Y', strtotime('+7 days')),
            'Time' => '20:00', 
            'Location' => 'Haarlem Grote Markt', 
            'Duration' => '2 hours' 
        ];
        return new Ticket($ticketID, $eventID, $userID, $qrCode,$IsScanned, $status, $purchasedAt, $eventName, $eventDetails);
    }

}