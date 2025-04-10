<?php

namespace models;

class Ticket implements \JsonSerializable{
    private $ticketID;
    private $eventID;
    private $userID;
    private $qrCode;
    private $IsScanned;
    private $status;
    private $purchasedAt;
    private $eventName;
    private $eventDetails = [];

    public function __construct($ticketID, $eventID, $userID, $qrCode, $IsScanned, $status, $purchasedAt, $eventName, $eventDetails = []) {
        $this->ticketID = $ticketID;
        $this->eventID = $eventID;
        $this->userID = $userID;
        $this->qrCode = $qrCode;
        $this->IsScanned = $IsScanned;
        $this->status = $status;
        $this->purchasedAt = $purchasedAt;
        $this->eventName = $eventName;
        $this->eventDetails = $eventDetails;
    }

    public function jsonSerialize(): array {
        return [
            'ticketID' => $this->ticketID,
            'eventID' => $this->eventID,
            'userID' => $this->userID,
            'qrCode' => $this->qrCode,
            'IsScanned' => $this->IsScanned,
            'status' => $this->status,
            'purchasedAt' => $this->purchasedAt,
            'eventName' => $this->eventName,
            'eventDetails' => $this->eventDetails,
        ];
    }

    public static function unserialize(array $data): self {
        return new self(
            $data['ticketID'] ?? null,
            $data['eventID'] ?? null,
            $data['userID'] ?? null,
            $data['qrCode'] ?? null,
            $data['IsScanned'] ?? null,
            $data['status'] ?? null,
            $data['purchasedAt'] ?? null,
            $data['eventName'] ?? null,
            $data['eventDetails'] ?? []
        );
    }

    public function setIsScanned($IsScanned) {
        $this->IsScanned = $IsScanned;
    }
    public function getIsScanned() {
        return $this->IsScanned;
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