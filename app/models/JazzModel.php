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

    public function getFestivalDaysAndArtists() {
        $query = "
            SELECT festival_days.id AS day_id, festival_days.date, 
                   artists.name, artists.image
            FROM festival_days
            JOIN artists ON festival_days.id = artists.day_id
            ORDER BY festival_days.date, artists.name;
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal festival timetable op
    public function getFestivalTimetable() {
        $query = "
            SELECT festival_days.date, artists.name, artists.start_time, artists.end_time, artists.place
            FROM artists
            JOIN festival_days ON festival_days.id = artists.day_id
            ORDER BY festival_days.date, artists.place, artists.start_time;
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
