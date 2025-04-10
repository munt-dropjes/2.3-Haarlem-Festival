<?php

namespace Services;

use Repositories\InvoiceRepository;

class InvoiceService {
    private $invoiceRepository;

    public function __construct()
    {
        $this->invoiceRepository = new InvoiceRepository();
    }

    public function getInvoiceByOrderID($orderID)
    {
        return $this->invoiceRepository->GetInvoiceByOrderID($orderID);
    }
    
    public function insertInvoice($invoice){
        return $this->invoiceRepository->insertInvoice($invoice);
    }

    public function updatePaymentDate($orderID, $paymentDate){
        return $this->invoiceRepository->updatePaymentDate($orderID, $paymentDate);
    }
}