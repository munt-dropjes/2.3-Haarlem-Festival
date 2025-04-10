<?php

namespace Models;

class StrollEvent {
    private $eventID;
    private $language;
    private $guide;
    private $familyTicketPrice;
    private int $TotalTickets;
	private int $SoldTickets;
    private $name;
    private $description;
    private $date;
    private $time;
    private $location;
    private $price;
    private $startTime;
    private $endTime;
    private $imageName;
    private $category;

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
        return round($this->familyTicketPrice, 2);
    }

    public function setFamilyTicketPrice($familyTicketPrice) {
        $this->familyTicketPrice = $familyTicketPrice;
    }

    public function setTotalTickets($TotalTickets) {
        $this->TotalTickets = $TotalTickets;
    }

    public function setSoldTickets($SoldTickets) {
        $this->SoldTickets = $SoldTickets;
    }

    public function getAvailableTickets(): int
	{
		$AvailableTickets = $this->TotalTickets - $this->SoldTickets;
		return $AvailableTickets < 0 ? 0 : $AvailableTickets;
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
        $formattedTime = date('H:i', strtotime($this->time));
        return $formattedTime;
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


    public function getStartTime() {
        return $this->startTime;
    }

    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }
    public function getEndTime() {
        return $this->endTime;
    }

    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }

    public function getImageName() {
        return $this->imageName;
    }
    public function setImageName($imageName) {
        $this->imageName = $imageName;
    }
    public function getCategory() {
        return $this->category;
    }
    public function setCategory($category) {
        $this->category = $category;
    }
}
?>