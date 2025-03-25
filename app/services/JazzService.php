<?php

namespace Services;

use Repositories\JazzRepository;

class JazzService {
    private $jazzRepository;

    public function __construct() {
        $this->jazzRepository = new JazzRepository();
    }

    public function getFestivalDaysAndArtists() {
        return $this->jazzRepository->getFestivalDaysAndArtists();
    }

    public function getFestivalTimetable() {
        return $this->jazzRepository->getFestivalTimetable();
    }

    public function getArtistByName($name) {
        return $this->jazzRepository->getArtistByName($name);
    }

    public function getAvailebleTicketsForArtist($name) {
        return $this->jazzRepository->getAvailebleTicketsForArtist($name);
    }
}

?>
