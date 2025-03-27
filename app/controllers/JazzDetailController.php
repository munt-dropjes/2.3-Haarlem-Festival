<?php

namespace Controllers;

use Services\JazzService;

class JazzDetailController extends Controller {
    private $jazzService;

    public function __construct() {
        $this->jazzService = new JazzService();
    }

    public function index($name) {
        $name = str_replace('+', ' ', $name);

        $artist = $this->jazzService->getArtistByName($name);

        if (!$artist) {
            http_response_code(404);
            echo "Artiest niet gevonden!";
            return;
        }

        $tickets = $this->jazzService->getAvailebleTicketsForArtist($name);

        $this->view('jazz/artistDetail', ['artist' => $artist, 'tickets' => $tickets]);
    }
}

?>