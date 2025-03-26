<?php

namespace models;

class Ticket {
    private $ticketID;
    private $eventID;
    private $userID;
    private $qrCode;
    private $status;
    private $purchasedAt;
    private $eventName;
    private $eventDetails = [];

    public function __construct($ticketID, $eventID, $userID, $qrCode, $status, $purchasedAt, $eventName, $eventDetails = []) {
        $this->ticketID = $ticketID;
        $this->eventID = $eventID;
        $this->userID = $userID;
        $this->qrCode = $qrCode;
        $this->status = $status;
        $this->purchasedAt = $purchasedAt;
        $this->eventName = $eventName;
        $this->eventDetails = $eventDetails;
    }

    public function getTicketID() {
        return $this->ticketID;
    }

    public function getEventID() {
        return $this->eventID;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getQrCode() {
        return $this->qrCode;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getPurchasedAt() {
        return $this->purchasedAt;
    }

    public function getEventName() {
        return $this->eventName;
    }

    public function getEventDetails() {
        return $this->eventDetails;
    }

    public function addEventDetail($key, $value) {
        $this->eventDetails[$key] = $value;
    }

    public function getEventDetail($key) {
        return $this->eventDetails[$key] ?? null; // Return null if the key doesn't exist
    }

    public function setTicketID($ticketID) {
        $this->ticketID = $ticketID;
    }

    public function setEventID($eventID) {
        $this->eventID = $eventID;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function setQrCode($qrCode) {
        $this->qrCode = $qrCode;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setPurchasedAt($purchasedAt) {
        $this->purchasedAt = $purchasedAt;
    }

    public function setEventName($eventName) {
        $this->eventName = $eventName;
    }

    public function setEventDetails(array $eventDetails) {
        $this->eventDetails = $eventDetails;
    }
}
?>