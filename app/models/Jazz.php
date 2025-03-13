<?php
namespace Models;
use PDO;

class Jazz {
    private $pdo;

    public function __construct() {
        require __DIR__ . '/../dbconfig.php';

        try {
            $this->pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Fout bij verbinden met database: " . $e->getMessage());
        }
    }

    public function getFestivalDaysAndArtists() {
        $query = "
            SELECT E.Date AS date, A.Name AS name, A.ImageName AS image
            FROM Events E
            JOIN Jazz J ON E.EventID = J.EventID
            JOIN Artists A ON J.ArtistID = A.ArtistID
            WHERE E.Date IS NOT NULL
            ORDER BY E.Date, A.Name;
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFestivalTimetable() {
        $query = "
            SELECT E.Date AS date, A.Name AS name, E.StartTime AS start_time, E.EndTime AS end_time, E.Location AS place
            FROM Events E
            JOIN Jazz J ON E.EventID = J.EventID
            JOIN Artists A ON J.ArtistID = A.ArtistID
            ORDER BY E.Date, E.Location, E.StartTime;
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
