<?php

namespace Controllers;

use Repositories\JazzRepository;

class JazzController extends Controller {
    private $jazzRepository;

    public function __construct() {
        $this->jazzRepository = new JazzRepository();
    }

    public function index() {
        $festivalDaysData = $this->jazzRepository->getFestivalDaysAndArtists();
        $timetable = $this->jazzRepository->getFestivalTimetable();

        $festivalDays = [];
        foreach ($festivalDaysData as $jazz) {
            $day = $jazz->getDate();
            if (!isset($festivalDays[$day])) {
                $festivalDays[$day] = [
                    'Date' => $day,
                    'artists' => []
                ];
            }
            $festivalDays[$day]['artists'][] = [
                'name' => $jazz->getName(),
                'image' => $jazz->getImage()
            ];
        }

        $this->view('jazz/index', [
            'festivalDays' => $festivalDays,
            'timetable' => $timetable
        ]);
    }
}

?>
