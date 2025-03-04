<?php

namespace Models;

class StrollEvent {
    private $eventID;
    private $language;
    private $guide;
    private $familyTicketPrice;
    private $availableTickets;
    private $name;
    private $description;
    private $date;
    private $time;
    private $location;
    private $price;

    public function getEventID() {
        return $this->eventID;
    }

    public function setEventID($eventID) {
        $this->eventID = $eventID;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }

    public function getGuide() {
        return $this->guide;
    }

    public function setGuide($guide) {
        $this->guide = $guide;
    }

    public function getFamilyTicketPrice() {
        return $this->familyTicketPrice;
    }

    public function setFamilyTicketPrice($familyTicketPrice) {
        $this->familyTicketPrice = $familyTicketPrice;
    }

    public function getAvailableTickets() {
        return $this->availableTickets;
    }

    public function setAvailableTickets($availableTickets) {
        $this->availableTickets = $availableTickets;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }
}
?>