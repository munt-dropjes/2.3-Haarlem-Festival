<?php

namespace Repositories;

use Models\Jazz;
use PDO;

class JazzRepository extends BaseRepository {

    public function getFestivalDaysAndArtists() {
        $sql = "
            SELECT E.Date AS date, A.Name AS name, A.ImageName AS image
            FROM Events E
            JOIN Jazz J ON E.EventID = J.EventID
            JOIN Artists A ON J.ArtistID = A.ArtistID
            WHERE E.Date IS NOT NULL
            ORDER BY E.Date, A.Name;
        ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $jazzArtists = [];
        foreach ($results as $row) {
            $jazz = new Jazz();
            $jazz->setDate($row['date']);
            $jazz->setName($row['name']);
            $jazz->setImage($row['image']);
            $jazzArtists[] = $jazz;
        }

        return $jazzArtists;
    }

    public function getFestivalTimetable() {
        $sql = "
            SELECT E.Date AS date, A.Name AS name, E.StartTime AS start_time, E.EndTime AS end_time, E.Location AS place
            FROM Events E
            JOIN Jazz J ON E.EventID = J.EventID
            JOIN Artists A ON J.ArtistID = A.ArtistID
            ORDER BY E.Date, E.Location, E.StartTime;
        ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $jazzTimetable = [];
        foreach ($results as $row) {
            $jazz = new Jazz();
            $jazz->setDate($row['date']);
            $jazz->setName($row['name']);
            $jazz->setStartTime($row['start_time']);
            $jazz->setEndTime($row['end_time']);
            $jazz->setPlace($row['place']);
            $jazzTimetable[] = $jazz;
        }

        return $jazzTimetable;
    }

    public function getArtistByName($name) {
        $sql = "
            SELECT A.Name AS name, A.ImageName AS image, A.About AS description,
                   A.KnownFor AS known_for, A.Song1Link, A.Song2Link, A.Song3Link
            FROM Artists A
            WHERE A.Name = :name
        ";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $jazzArtist = new Jazz();
            $jazzArtist->setName($result['name']);
            $jazzArtist->setImage($result['image']);
            $jazzArtist->setDescription($result['description']);
            $jazzArtist->setKnownFor($result['known_for']);
            $jazzArtist->setSong1Link($result['Song1Link']);
            $jazzArtist->setSong2Link($result['Song2Link']);
            $jazzArtist->setSong3Link($result['Song3Link']);
            return $jazzArtist;
        }

        return null;
    }
}

?>
