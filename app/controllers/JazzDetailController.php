<?php

namespace Controllers;

use Repositories\JazzRepository;

class JazzDetailController extends Controller {
    private $jazzRepository;

    public function __construct() {
        $this->jazzRepository = new JazzRepository();
    }

    public function index($name) {
           $name = str_replace('+', ' ', $name);
            
            $artist = $this->jazzRepository->getArtistByName($name);
        
            if (!$artist) {
                http_response_code(404);
                echo "Artiest niet gevonden!";
                return;
            }
        
            $this->view('jazz/artistDetail', ['artist' => $artist]);
        }
        
}

?>
