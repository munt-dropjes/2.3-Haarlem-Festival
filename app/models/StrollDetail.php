<?php

namespace Models;

class StrollDetail {
    private $eventId;
    private $stopNumber;
    private $stopName;
    private $description;
    private $address;
    private $breakLocation;

    // Getters
    public function getEventId() {
        return $this->eventId;
    }

    public function getStopNumber() {
        return $this->stopNumber;
    }

    public function getStopName() {
        return $this->stopName;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getBreakLocation() {
        return $this->breakLocation;
    }

    // Setters
    public function setEventId($eventId) {
        $this->eventId = $eventId;
    }

    public function setStopNumber($stopNumber) {
        $this->stopNumber = $stopNumber;
    }

    public function setStopName($stopName) {
        $this->stopName = $stopName;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setBreakLocation($breakLocation) {
        $this->breakLocation = $breakLocation;
    }
}
?>