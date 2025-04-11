<?php

namespace Controllers;

use Services\EventService;
use Models\Event;

class CmsEventController extends Controller {
    private $eventService;

    public function __construct() {
        $this->eventService = new EventService();
    }

    // all cms routes will be automically checked for authentication
    public function index() {
        $limit = $_GET['limit'] ?? 10;
        $offset = $_GET['offset'] ?? 0;
        $search = $_GET['search'] ?? '';

        // check if the limit and offset are valid
        //if not valid still search
        if ((!is_numeric($offset) || !is_numeric($limit)) || ($offset < 0 || $limit < 1)) {
            $currentUri = $_SERVER['REQUEST_URI'];
            $search = explode('search=', $currentUri)[1] ?? "";
            header('Location: /cms/events?limit=10&offset=0&search=' . $search);
        }

        $this->view('cms/events/index', [
            'events' => $this->eventService->getAllEvents($limit, $offset, $search),
            'totalEntries' => $this->eventService->countTotalEvents(),
            'limit' => $limit,
            'offset' => $offset,
            'search' => $search
        ]);
    }

    //add html special chars
    public function create(){
        $event = Event::unserialize($_POST);

        // If category is jazz or dance, ask also for artist
        if ($_POST['Category'] === 'jazz' || $_POST['Category'] === 'dance') {
            $artist = new \Models\Artist();
            $artist->setName($_POST['artistName']);
            $artist->setAbout($_POST['artistAbout']);
            $artist->setKnownFor($_POST['artistKnownFor']);
            $artist->setSong1Link($_POST['song1Link']);
            $artist->setSong2Link($_POST['song2Link']);
            $artist->setSong3Link($_POST['song3Link']);
            $artist->setImageName($_POST['artistImageName']);
            $artist->setCategory($_POST['artistCategory']);
            $artist->setBannerImage($_POST['bannerImage']);
            $this->eventService->insertArtist($artist);
            $event->setArtist($artist);
        }

        // If category is yummy, ask for food type, star rating, and menu
        if ($_POST['Category'] === 'yummy') {
            // create a new YummieModel object
            // post yummie data to the database
            // set the yummie object to the event
        }
        $event = $this->eventService->insertEvent($event);

        // If category is stroll, ask for language and guide
        if ($_POST['Category'] === 'stroll') {
            $strollEvent = new \Models\StrollEvent();
            $strollEvent->setEventID($event->getEventID());
            $strollEvent->setLanguage($_POST['language']);
            $strollEvent->setGuide($_POST['guide']);
            $strollEvent->setFamilyTicketPrice(60);
        }

        $this->index();
    }

    //see above
    public function update(){
		$updateEvent = $this->eventService->getEventById($_POST['id']);
        $updateEvent->setName($_POST['name']);
        $updateEvent->setDescription($_POST['description']);
        $updateEvent->setStartTime($_POST['starttime']);
        $updateEvent->setEndTime($_POST['endtime']);
        $updateEvent->setTotalTickets($_POST['totalTickets']);
        $updateEvent->setLocation($_POST['location']);
        $updateEvent->setPrice($_POST['price']);	
        $updateEvent->setCategory($_POST['category']);
        $this->eventService->updateEvent($updateEvent);
        $this->index();
    }


    //again
    public function delete(){
        $this->eventService->deleteEvent($_POST['id']);
        $this->index();
    }
}