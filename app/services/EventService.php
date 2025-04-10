<?php

namespace Services;

use Exception;
use Models\Event;
use Repositories\EventRepository;

class EventService {
    private $eventRepository;

    public function __construct() {
        $this->eventRepository = new EventRepository();
    }

    // ~~Create~~
    public function insertEvent($event) : Event {
        return $this->eventRepository->insertEvent($event);        
    }

    // ~~Read~~
    public function getAllEvents($limit, $offset, $search) : array {
        return $this->eventRepository->getAllEvents($limit, $offset, $search);
    }

    public function getEventById($id) : Event {
        return $this->eventRepository->getEventById($id);
    }

    public function countTotalEvents() : int {
        return $this->eventRepository->countTotalEvents();
    }

    public function getAvailibility($eventId) : boolval {
        $event = $this->eventRepository->getEventById($eventId);
        if ($event == null) {
            throw new Exception("Event not found", 404);
        }
        if ($event->getAvailableTickets() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // ~~Update~~
    public function updateEvent($event) : Event {
        return $this->eventRepository->updateEvent($event);
    }

    // ~~Delete~~
    public function deleteEvent($id) : void {
        $this->eventRepository->deleteEvent($id);
    }

}