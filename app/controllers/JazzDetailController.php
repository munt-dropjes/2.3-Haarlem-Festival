<?php
namespace Controllers;
use Models\JazzModel;

class JazzDetailController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new JazzModel();
    }

    public function index($name) {
        $artist = $this->model->getArtistByName(urldecode($name));

        if (!$artist) {
            http_response_code(404);
            echo "Artiest niet gevonden";
            return;
        }

        $this->view('jazz/artistDetail', ['artist' => $artist]);
    }
}
