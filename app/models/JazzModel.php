<?php
namespace Models;
use PDO;

class JazzModel {
    private $pdo;

    public function __construct() {
        // Laad de configuratie
        require __DIR__ . '/../dbconfig.php'; // Laad de dbconfig

        // Gebruik de variabelen uit dbconfig.php
        try {
            $this->pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Fout bij verbinden met database: " . $e->getMessage());
        }
    }

    // Haal festivaldagen en artiesten op
    public function getFestivalDaysAndArtists() {
        $query = "
            SELECT e.EventID AS day_id, e.Date, 
                   a.Name AS name, a.ImageName AS image
            FROM Events e
            JOIN Jazz j ON e.EventID = j.EventID
            JOIN Artists a ON j.ArtistID = a.ArtistID
            WHERE a.Category = 'Jazz'
            ORDER BY e.Date, a.Name;
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal festival timetable op
    public function getFestivalTimetable() {
        $query = "
            SELECT e.Date, a.Name, e.Time AS start_time, e.Location AS place
            FROM Events e
            JOIN Jazz j ON e.EventID = j.EventID
            JOIN Artists a ON j.ArtistID = a.ArtistID
            WHERE a.Category = 'Jazz'
            ORDER BY e.Date, e.Location, e.Time;
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
