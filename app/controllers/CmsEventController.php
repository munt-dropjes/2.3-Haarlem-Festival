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
        $event = new Event();
        $event->setName($_POST['name']);
        $event->setDescription($_POST['description']);
        $event->setDate($_POST['date']);
        $event->setTime($_POST['time']);
        $event->setDuration($_POST['duration']);
        $event->setLocation($_POST['location']);
        $event->setPrice($_POST['price']);	
        $event->setAvailableTickets($_POST['availableTickets']);
        $event->setCategory($_POST['category']);
        $this->eventService->insertEvent($event);

        $this->index();
    }

    //see above
    public function update(){
        $updateEvent = $this->eventService->getEventById($_POST['id']);
        $updateEvent->setName($_POST['name']);
        $updateEvent->setDescription($_POST['description']);
        $updateEvent->setDate($_POST['date']);
        $updateEvent->setTime($_POST['time']);
        $updateEvent->setDuration($_POST['duration']);
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