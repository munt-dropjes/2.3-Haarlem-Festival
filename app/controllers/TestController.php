<?php

namespace Controllers;

use Services\pdfService;
use Services\MailerService;
use Models\Ticket;
use Models\Invoice;


class TestController extends Controller
{

    private $pdfService;
    private $mailerService;

    public function __construct() {
        $this->pdfService = new pdfService();
        $this->mailerService = new MailerService();
    }

    //this is for testing the pdf and email stuff
    public function index()
    {
        $ticket = $this->createTicket();
        $invoice = $this->createInvoice();

        $pdf1 = $this->pdfService->generateTicketPDF($ticket);
        $pdf2 = $this->pdfService->generateInvoicePDF($invoice);
        

        //fix this, don't save, just keep in system memory
        $ticketFilePath = sys_get_temp_dir() . '/Ticket.pdf';
        $invoiceFilePath = sys_get_temp_dir() . '/Invoice.pdf';
        file_put_contents($ticketFilePath, $pdf1);
        file_put_contents($invoiceFilePath, $pdf2);

        $attachment = [$ticketFilePath, $invoiceFilePath];
        $this->sendEmail($attachment);

        unlink($ticketFilePath);
        unlink($invoiceFilePath);

        $this->downloadPDF($pdf1, 'Ticket.pdf');
        $this->downloadPDF($pdf2, 'Invoice.pdf');
    }
    private function sendEmail($attachment) {
        $this->mailerService->sendMail('toast3347@gmail.com', 'test', 'test', 'test', $attachment);
    }

    private function createTicket() {
        $ticketID = rand(1000, 9999); 
        $eventID = rand(1, 100); 
        $userID = rand(1, 1000); 
        $qrCode = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Ticket-' . $ticketID; 
        $status = 'Valid'; 
        $purchasedAt = date('d-m-Y H:i:s');
        $eventName = 'Haarlem Festival Event'; 
        $eventDetails = [
            'Date' => date('d-m-Y', strtotime('+7 days')), // Event date 7 days from now
            'Time' => '20:00', 
            'Location' => 'Haarlem Grote Markt', 
            'Duration' => '2 hours' 
        ];
        return new Ticket($ticketID, $eventID, $userID, $qrCode, $status, $purchasedAt, $eventName, $eventDetails);
    }

    private function createInvoice() {
        $invoiceNumber = 'INV-' . rand(1000, 9999); 
        $invoiceDate = date('d-m-Y'); 
        $clientName = 'John Doe';
        $phoneNumber = '0612345678'; 
        $address = '123 Fake Street, Haarlem'; 
        $emailAddress = 'johndoe@example.com'; 
        $subtotal = rand(50, 500); 
        $vat21 = $subtotal * 0.21; 
        $vat9 = $subtotal * 0.09; 
        $totalAmount = $subtotal + $vat21 + $vat9; 
        $paymentDate = date('Y-m-d', strtotime('+14 days')); 

        return new Invoice($invoiceNumber, $invoiceDate, $clientName, $phoneNumber, $address, $emailAddress, $subtotal, $vat21, $vat9, $totalAmount, $paymentDate);
    }



    private function downloadPDF($pdfContent, $fileName) {
        // Clear any previous output
        if (ob_get_length()) {
            ob_end_clean();
        }
    
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . strlen($pdfContent));
        echo $pdfContent;
        exit;
    }

    //downloading the generated ticket to change styling
    public function downloadTicket()
    {
        $ticket = $this->createTicket(); // Generate a ticket
        $pdfContent = $this->pdfService->generateTicketPDF($ticket); // Generate the PDF
        $this->downloadPDF($pdfContent, 'Ticket.pdf'); // Trigger the download
    }

    //downloading the generated invoice to change styling
    public function downloadInvoice()
    {
        $invoice = $this->createInvoice(); // Generate an invoice
        $pdfContent = $this->pdfService->generateInvoicePDF($invoice); // Generate the PDF
        $this->downloadPDF($pdfContent, 'Invoice.pdf'); // Trigger the download
    }
}


