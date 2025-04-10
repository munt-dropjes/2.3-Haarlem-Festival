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
            $input = $this->parseJson(file_get_contents('php://input'));

            if (!isset($input['ticket'])) {
                echo json_encode(['status' => 'error', 'message' => 'No ticket provided']);
                return;
            }

            $ticket = $input['ticket'];
            $result = $this->qrService->checkTicket($ticket);
            echo json_encode(['status' => $result]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function parseJson($input) {
        $trimmedInput = trim($input);
    
        $decoded = json_decode($trimmedInput, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Error parsing JSON: " . json_last_error_msg() . "\n";
            
            $lastIndex = strrpos($trimmedInput, '}');
            $validJson = substr($trimmedInput, 0, $lastIndex + 1);
            
            $decoded = json_decode($validJson, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                echo "Valid JSON extracted and parsed successfully.\n";
                return $decoded;
            }
        }
    
        return $decoded;
    }


    //creates fake qr ticket
    private function createTicket(): Ticket {
        $ticketID = 1; 
        $eventID = 1; 
        $userID = 1; 
        $qrCode = null; 
        $IsScanned = 0;
        $status = "Valid"; 
        $purchasedAt = date('d-m-Y H:i:s');
        $eventName = "Haarlem Festival Event"; 
        $eventDetails = [
            "Date" => date('d-m-Y', strtotime('+7 days')),
            "Time" => "20:00", 
            "Location" => "Haarlem Grote Markt", 
            "Duration" => "2 hours" 
        ];
        return new Ticket($ticketID, $eventID, $userID, $qrCode,$IsScanned, $status, $purchasedAt, $eventName, $eventDetails);
    }

}