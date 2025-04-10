<?php

namespace Repositories;

use Exception;
use PDO;
use Models\Event;

class EventRepository extends BaseRepository {
    // ~~Create~~
    public function insertEvent($event) : Event {
        try {
            $sql = "INSERT INTO Events (Name, Description, StartTime, EndTime, Location, Price, Category, TotalTickets, ImageName) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                $event->getName(),
                $event->getDescription(),
                $event->getStartTime(),
                $event->getEndTime(),
                $event->getLocation(),
                $event->getPrice(),
                $event->getCategory(),
                $event->getTotalTickets(),
                "placeholder.jpg"
            ]);
            return $this->getEvent($event);
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to create event: " . $event->name);
        }
    }

    // ~~Read~~
    public function getAllEvents($limit, $offset, $search) : array {
        try {
            $sql = "SELECT * 
                    FROM Events 
                    WHERE ( 
                        UPPER(Name) LIKE UPPER(CONCAT('%', :search, '%'))
                        OR UPPER(Description) LIKE UPPER(CONCAT('%', :search, '%')) 
                        OR UPPER(Location) LIKE UPPER(CONCAT('%', :search, '%'))
                        OR UPPER(Category) LIKE UPPER(CONCAT('%', :search, '%'))
                    )
                    ORDER BY StartTime
                    LIMIT :limit
                    OFFSET :offset;";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':search', $search, PDO::PARAM_STR);

            $stmt->execute();
            $obj = $stmt->fetchAll(PDO::FETCH_CLASS, 'Models\Event');
            return $obj;
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get all events");
        }
    }

    public function getEventById($id): ?Event {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Events WHERE EventID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Models\Event');
            $fetchedEvent = $stmt->fetch();
            return $fetchedEvent ?: null;
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get event by id: " . $id);
        }
    }

    public function getEvent($event) : ?Event
    {
        try {
            $name = $event->getName();
            $stmt = $this->connection->prepare("SELECT * FROM Events WHERE Name = :name");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Models\Event');
            $fetchedEvent = $stmt->fetch();
            return $fetchedEvent ?: null;
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get event by id: " . $id);
        }
    }

    public function countTotalEvents() : int {
        try {
            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM Events");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to count total events");
        }
    }

    // ~~Update~~
    public function updateEvent($event) : Event {
        try {
            $sql = "UPDATE Events 
                    SET Name = ?, Description = ?, StartTime = ?, EndTime = ?, Location = ?, Price = ?, Category = ?
                    WHERE EventID = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                $event->getName(),
                $event->getDescription(),
                $event->getStartTime(),
                $event->getEndTime(),
                $event->getLocation(),
                $event->getPrice(),
                $event->getCategory(),
                $event->getEventID()
            ]);
            return $this->getEventById($event->getEventID());
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to update event: " . $event->name);
        }
    }

    // ~~Delete~~
    public function deleteEvent($id) : void {
        try {
            $stmt = $this->connection->prepare("DELETE FROM Events WHERE EventID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to delete event with id: " . $id);
        }
    }

}