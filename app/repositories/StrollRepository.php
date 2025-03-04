<?php

namespace Repositories;

use Models\StrollEvent;
use PDO;

class StrollRepository extends BaseRepository
{
    public function create(StrollEvent $event)
    {
        $sql = "INSERT INTO Stroll (EventID, Language, Guide, FamilyTicketPrice) VALUES (:EventID, :Language, :Guide, :FamilyTicketPrice)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':EventID', $event->getEventID());
        $stmt->bindValue(':Language', $event->getLanguage());
        $stmt->bindValue(':Guide', $event->getGuide());
        $stmt->bindValue(':FamilyTicketPrice', $event->getFamilyTicketPrice());
        $stmt->execute();
    }

    public function getAll()
    {
        $sql = "SELECT s.*, e.Name, e.Description, e.Date, e.Time, e.Location, e.Price, e.AvailableTickets 
                FROM Stroll s 
                JOIN Events e ON s.EventID = e.EventID";
        $stmt = $this->connection->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $strollEvents = [];
        foreach ($results as $row) {
            $strollEvent = new StrollEvent();
            $strollEvent->setEventID($row['EventID']);
            $strollEvent->setLanguage($row['Language']);
            $strollEvent->setGuide($row['Guide']);
            $strollEvent->setFamilyTicketPrice($row['FamilyTicketPrice']);
            $strollEvent->setName($row['Name']);
            $strollEvent->setDescription($row['Description']);
            $strollEvent->setDate($row['Date']);
            $strollEvent->setTime($row['Time']);
            $strollEvent->setLocation($row['Location']);
            $strollEvent->setPrice($row['Price']);
            $strollEvent->setAvailableTickets($row['AvailableTickets']);
            $strollEvents[] = $strollEvent;
        }

        return $strollEvents;
    }

    public function update(StrollEvent $event)
    {
        $sql = "UPDATE Stroll SET Language = :Language, Guide = :Guide, FamilyTicketPrice = :FamilyTicketPrice WHERE EventID = :EventID";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':EventID', $event->getEventID());
        $stmt->bindValue(':Language', $event->getLanguage());
        $stmt->bindValue(':Guide', $event->getGuide());
        $stmt->bindValue(':FamilyTicketPrice', $event->getFamilyTicketPrice());
        $stmt->execute();
    }

    public function delete(StrollEvent $event)
    {
        $sql = "DELETE FROM Stroll WHERE EventID = :EventID";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':EventID', $event->getEventID());
        $stmt->execute();
    }
}
?>