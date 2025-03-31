<?php

namespace Models;

class Order {
    private int $OrderID;
    private int $UserID;
    private string $Status;
    private string $CreatedAt;
    private string $PaymentMethod;

    public function getOrderID() {
        return $this->OrderID;
    }
    public function getUserID() {
        return $this->UserID;
    }
    public function getStatus() {
        return $this->Status;
    }
    public function getCreatedAt() {
        return $this->CreatedAt;
    }
    public function getPaymentMethod() {
        return $this->PaymentMethod;
    }

    public function setOrderID($OrderID) {
        $this->OrderID = $OrderID;
        return $this->OrderID;
    }
    public function setUserID($UserID) {
        $this->UserID = $UserID;
        return $this->UserID;
    }
    public function setStatus($Status) {
        $this->Status = $Status;
        return $this->Status;
    }
    public function setCreatedAt($CreatedAt) {
        $this->CreatedAt = $CreatedAt;
        return $this->CreatedAt;
    }
    public function setPaymentMethod($PaymentMethod) {
        $this->PaymentMethod = $PaymentMethod;
        return $this->PaymentMethod;
    }
    
}