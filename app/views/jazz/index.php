<?php
// Databaseverbinding (Pas aan naar jouw instellingen)
$host = 'mysql';
$dbname = 'jazz';
$user = 'root';
$pass = 'secret123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}

// Haal alle dagen en artiesten op uit de database
$query = "
    SELECT festival_days.id AS day_id, festival_days.date, 
           artists.name, artists.image
    FROM festival_days
    JOIN artists ON festival_days.id = artists.day_id
    ORDER BY festival_days.date, artists.name;
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Data groeperen per dag
$festivalDays = [];
foreach ($results as $row) {
    $dayId = $row['day_id'];
    if (!isset($festivalDays[$dayId])) {
        $festivalDays[$dayId] = [
            'date' => $row['date'],
            'artists' => []
        ];
    }
    $festivalDays[$dayId]['artists'][] = [
        'name' => $row['name'],
        'image' => $row['image']
    ];
}
?>
<main>

    <div class="container-fluid p-0">
		<img src="images/jazz1.png" class="img-fluid w-100" alt="Plaatje Haarlem Jazz">
	</div>
    <div class="container mt-4 text-center" style="max-width: 1425px; margin: 0 auto;">
		<h1>JAZZ</h1>
		<p>Welcome to the Jazz side of the Festival, where everyone comes alive with music, and the city transforms into a stage for the enchantment of jazz. Haarlem Jazz, an annual highlight for music enthusiasts, brings the vibrant sounds of jazz, soul, and world music to historic squares and intimate venues. From swinging solos to sultry melodies – discover the raw power of live music in a truly unique setting. All performances of the first 3 days will be given at Patronaat (Zijlsingel 2, Haarlem)</p>
	</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Festival Line-up</h2>

    <div class="accordion" id="festivalAccordion" style="position: relative; z-index: 0;">
    <?php foreach ($festivalDays as $dayId => $info) { ?>
        <div class="accordion-item" style="background: none; border: none;">
            <h2 class="accordion-header" id="headingDay<?= $dayId ?>">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay<?= $dayId ?>" aria-expanded="true" style="background-color:rgb(251, 255, 0); border-radius: 10px 10px 0 0;">
                    Dag <?= $dayId ?> - <?= date("l d F", strtotime($info['date'])) ?>
                </button>
            </h2>
            <div id="collapseDay<?= $dayId ?>" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="artist-container">
                        <?php foreach ($info['artists'] as $artist) { ?>
                            <div class="artist-card">
                                <img src="images/<?= $artist['image'] ?>" alt="<?= $artist['name'] ?>" width="406" height="225">
                                <div class="artist-name"><?= strtoupper($artist['name']) ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <break style="padding: 10px;">   <!-- Dit is een break tussen de lagen/dagen voor ruimte --></break>
     <?php } ?>
    </div>
</div>
<div class="timetable-container" style="margin-top: 50px; padding: 20px; background-color: #e1fbff; border-radius: 10px;">
    <h2 class="text-center mb-4">Festival Timetable</h2>
    <div class="timetable" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
        <?php
        $query = "
            SELECT festival_days.date, artists.name, artists.start_time, artists.end_time
            FROM artists
            JOIN festival_days ON festival_days.id = artists.day_id
            ORDER BY festival_days.date, artists.start_time;
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $days = [];
        foreach ($results as $row) {
            $date = date("l d F", strtotime($row['date']));
            $days[$date][] = $row;
        }
        foreach ($days as $day => $performances) {
            echo "<div class='day-column' style='padding: 10px; background-color: #ffb6f0; border-radius: 10px;'>";
            echo "<h3 style='margin-bottom: 10px;'>$day</h3>";
            foreach ($performances as $performance) {
                echo "<div class='performance' style='background-color: #9e44d6; padding: 5px; margin-bottom: 5px; border-radius: 5px; color: white;'>";
                echo "<strong>{$performance['name']}</strong><br>";
                echo date('H:i', strtotime($performance['start_time'])) . " - " . date('H:i', strtotime($performance['end_time']));
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>
</main>