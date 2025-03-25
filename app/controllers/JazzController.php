<?php

namespace Controllers;

use Services\JazzService;

class JazzController extends Controller {
    private $jazzService;

    public function __construct() {
        $this->jazzService = new JazzService();
    }

    public function index() {
        $festivalDaysData = $this->jazzService->getFestivalDaysAndArtists();
        $timetable = $this->jazzService->getFestivalTimetable();

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