<?php
namespace Controllers;
use Models\JazzModel;

class JazzController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new JazzModel();
    }

    public function index() {
        $festivalDays = $this->model->getFestivalDaysAndArtists();
        $timetable = $this->model->getFestivalTimetable();
        $this->view('jazz/index', [
            'festivalDays' => $festivalDays,
            'timetable' => $timetable
        ]);
    }
}
