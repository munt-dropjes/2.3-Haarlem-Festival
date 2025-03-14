<?php

namespace Models;

class Jazz {
    private $date;
    private $name;
    private $image;
    private $startTime;
    private $endTime;
    private $place;
    private $description;
    private $knownFor;
    private $song1Link;
    private $song2Link;
    private $song3Link;

    // Getters en Setters
    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
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

    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getKnownFor() {
        return $this->knownFor;
    }

    public function setKnownFor($knownFor) {
        $this->knownFor = $knownFor;
    }

    public function getSong1Link() {
        return $this->song1Link;
    }

    public function setSong1Link($song1Link) {
        $this->song1Link = $song1Link;
    }

    public function getSong2Link() {
        return $this->song2Link;
    }

    public function setSong2Link($song2Link) {
        $this->song2Link = $song2Link;
    }

    public function getSong3Link() {
        return $this->song3Link;
    }

    public function setSong3Link($song3Link) {
        $this->song3Link = $song3Link;
    }
}

?>
