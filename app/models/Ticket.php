<?php

namespace models;

class Ticket implements \JsonSerializable{
    private $ticketID;
    private $orderID;
    private $eventID;
    private $userID;
	private $IsFamilyTicket;
	private $Quantity;
    private $qrCode;
    private $IsScanned;
    private $status;
    private $purchasedAt;
	private $paymentStatus;
    private $eventName;
    private $eventDetails = [];
    private Event $event;
    public function __construct($ticketID, $orderID, $eventID, $userID, $IsFamilyTicket, $Quantity, $qrCode, $IsScanned, $status, $purchasedAt, $paymentStatus) {
		$this->ticketID = $ticketID;
		$this->orderID = $orderID;
		$this->eventID = $eventID;
		$this->userID = $userID;
		$this->IsFamilyTicket = $IsFamilyTicket;
		$this->Quantity = $Quantity;
		$this->qrCode = $qrCode;
		$this->IsScanned = $IsScanned;
		$this->status = $status;
		$this->purchasedAt = $purchasedAt;
		$this->paymentStatus = $paymentStatus;
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
            $data['TicketID'] ?? null,
			$data['OrderID']??null,
            $data['EventID'] ?? null,
            $data['UserID'] ?? null,
            $data['IsFamilyTicket'] ?? null,
			$data['Quantity'] ?? null,
            $data['QrCode'] ?? null,
            $data['IsScanned'] ?? null,
            $data['Status'] ?? null,
            $data['PurchasedAt'] ?? null,
			$data['PaymentStatus'] ?? null
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
	
	public function getEvent(): Event
	{
		return $this->event;
	}
	
	public function getAmount()
	{
		return $this->event->getPrice() * $this->Quantity;
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

	public function setEvent(Event $event)
	{
		$this->event = $event;
	}
}
?>