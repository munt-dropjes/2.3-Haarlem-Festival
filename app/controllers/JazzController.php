<?php
namespace Controllers;
use Models\JazzModel;

class JazzController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new JazzModel();
    }

    public function index() {
        $festivalDaysData = $this->model->getFestivalDaysAndArtists();
        $timetable = $this->model->getFestivalTimetable();

        $festivalDays = [];
        foreach ($festivalDaysData as $row) {
            $day = $row['date'];
            if (!isset($festivalDays[$day])) {
                $festivalDays[$day] = [
                    'Date' => $row['date'],
                    'artists' => []
                ];
            }
            $festivalDays[$day]['artists'][] = [
                'name' => $row['name'],
                'image' => $row['image']
            ];
        }

        $this->view('jazz/index', [
            'festivalDays' => $festivalDays,
            'timetable' => $timetable
        ]);
    }
}