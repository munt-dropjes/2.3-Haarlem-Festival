<?php

namespace models;

class Invoice {
    private $invoiceNumber;
    private $invoiceDate;
    private $clientName;
    private $phoneNumber;
    private $address;
    private $emailAddress;
    private $subtotal;
    private $vat21;
    private $vat9;
    private $totalAmount;
    private $paymentDate;

    public function __construct($invoiceNumber, $invoiceDate, $clientName, $phoneNumber, $address, $emailAddress, $subtotal, $vat21, $vat9, $totalAmount, $paymentDate) {
        $this->invoiceNumber = $invoiceNumber;
        $this->invoiceDate = $invoiceDate;
        $this->clientName = $clientName;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->emailAddress = $emailAddress;
        $this->subtotal = $subtotal;
        $this->vat21 = $vat21;
        $this->vat9 = $vat9;
        $this->totalAmount = $totalAmount;
        $this->paymentDate = $paymentDate;
    }

    public function getInvoiceNumber() {
        return $this->invoiceNumber;
    }

    public function getInvoiceDate() {
        return $this->invoiceDate;
    }

    public function getClientName() {
        return $this->clientName;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getEmailAddress() {
        return $this->emailAddress;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function getVat21() {
        return $this->vat21;
    }

    public function getVat9() {
        return $this->vat9;
    }

    public function getTotalAmount() {
        return $this->totalAmount;
    }

    public function getPaymentDate() {
        return $this->paymentDate;
    }

    public function setInvoiceNumber($invoiceNumber) {
        $this->invoiceNumber = $invoiceNumber;
    }

    public function setInvoiceDate($invoiceDate) {
        $this->invoiceDate = $invoiceDate;
    }

    public function setClientName($clientName) {
        $this->clientName = $clientName;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setEmailAddress($emailAddress) {
        $this->emailAddress = $emailAddress;
    }

    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    public function setVat21($vat21) {
        $this->vat21 = $vat21;
    }

    public function setVat9($vat9) {
        $this->vat9 = $vat9;
    }

    public function setTotalAmount($totalAmount) {
        $this->totalAmount = $totalAmount;
    }

    public function setPaymentDate($paymentDate) {
        $this->paymentDate = $paymentDate;
    }
}
?>