<?php

namespace Models;

class Jazz {
    private $date;
    private $name;
    private $image;
    private $startTime;
    private $endTime;
    private $place;

    public function getDate() {
        return $this->date;
    }

    public function getName() {
        return $this->name;
    }

    public function getImage() {
        return $this->image;
    }

    public function getStartTime() {
        return $this->startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }

    public function getPlace() {
        return $this->place;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }

    public function setPlace($place) {
        $this->place = $place;
    }
}

?>
