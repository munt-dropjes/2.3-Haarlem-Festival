<?php

namespace Repositories;

use Models\StrollEvent;
use Models\StrollDetail;
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
        $sql = "SELECT 
                s.EventID,
                s.Language,
                s.Guide,
                s.FamilyTicketPrice,
                e.Name,
                e.Description,
                e.StartTime,
                e.EndTime,
                e.Location,
                e.Price,
                e.AvailableTickets,
                e.ImageName,
                e.Category
            FROM Stroll s
            JOIN Events e ON s.EventID = e.EventID
            WHERE e.Category = 'A Stroll through History'";

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
            $strollEvent->setStartTime($row['StartTime']);
            $strollEvent->setEndTime($row['EndTime']);
            $strollEvent->setLocation($row['Location']);
            $strollEvent->setPrice($row['Price']);
            $strollEvent->setAvailableTickets($row['AvailableTickets']);
            $strollEvent->setImageName($row['ImageName']);
            $strollEvent->setCategory($row['Category']);
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

    public function updateAvailableTickets($eventID, $availableTickets)
    {
        $sql = "UPDATE Events SET AvailableTickets = :AvailableTickets WHERE EventID = :EventID AND Category = :category";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':EventID', $eventID);
        $stmt->bindValue(':category', 'A Stroll through History');
        $stmt->bindValue(':AvailableTickets', $availableTickets);
        $stmt->execute();
    }

    public function delete(StrollEvent $event)
    {
        $sql = "DELETE FROM Stroll WHERE EventID = :EventID";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':EventID', $event->getEventID());
        $stmt->execute();
    }

    public function getRoute()
    {
        $sql = "SELECT 
                EventID,
                StopNumber,
                StopName,
                Description,
                Adress AS Address,
                BreakLocation,
                mapName
            FROM StrollDetail";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($results) {
            $strollDetails = [];
            foreach ($results as $row) {
                $strollDetail = new StrollDetail();
                $strollDetail->setEventId($row['EventID']);
                $strollDetail->setStopNumber($row['StopNumber']);
                $strollDetail->setStopName($row['StopName']);
                $strollDetail->setDescription($row['Description']);
                $strollDetail->setAddress($row['Address']); // Corrected column alias
                $strollDetail->setBreakLocation($row['BreakLocation']);
                $strollDetail->setMapName($row['mapName']);
                $strollDetails[] = $strollDetail;
            }
            return $strollDetails;
        }
        return null;
    }

    public function getDetail($strollDetailStopNumber)
    {
        $sql = "SELECT * FROM StrollDetail WHERE StopNumber = :Stop";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':Stop', $strollDetailStopNumber);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $strollDetail = new StrollDetail();
            $strollDetail->setEventId($result['EventID']);
            $strollDetail->setStopNumber($result['StopNumber']);
            $strollDetail->setStopName($result['StopName']);
            $strollDetail->setDescription($result['Description']);
            $strollDetail->setAddress($result['Adress']);
            $strollDetail->setBreakLocation($result['BreakLocation']);
            $strollDetail->setMapName($result['mapName']);
            return $strollDetail;
        }

        return null;
    }
}
