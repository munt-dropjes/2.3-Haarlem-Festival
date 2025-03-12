<main>
    <div class="container-fluid p-0">
        <img src="images/jazz1.png" class="img-fluid w-100" alt="Plaatje Haarlem Jazz">
    </div>
    <div class="container mt-4 text-center" style="max-width: 1425px;">
        <h1>JAZZ</h1>
        <p>Welcome to the Jazz side of the Festival, where everyone comes alive with music, and the city transforms into a stage for the enchantment of jazz. Haarlem Jazz, an annual highlight for music enthusiasts, brings the vibrant sounds of jazz, soul, and world music to historic squares and intimate venues. From swinging solos to sultry melodies – discover the raw power of live music in a truly unique setting. All performances of the first 3 days will be given at Patronaat (Zijlsingel 2, Haarlem)</p>
    </div>

    <div class="container mt-5">
    <h2 class="text-center mb-4">Festival Line-up</h2>

    <div class="accordion" id="festivalAccordion" style="position: relative; z-index: 0;">
    <?php foreach ($festivalDays as $dayId => $info) { ?>
        <div class="accordion-item" style="background: none; border: none;">
            <h2 class="accordion-header" id="headingDay<?= $dayId ?>">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay<?= $dayId ?>" aria-expanded="true" style="background-color:rgb(251, 255, 0); border-radius: 10px 10px 0 0; ">
                    Dag <?= $dayId ?> -<?= date("l d F", strtotime($info['Date'])) ?>
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
<div class="jazz-overview-timetable-container">
        <h2 class="jazz-overview-text-center mb-4">Festival Timetable</h2>
        <div class="jazz-overview-timetable">
            <?php
            $days = [];
            foreach ($timetable as $row) {
                $date = date("l d F", strtotime($row['date']));
                $days[$date][] = $row;
            }

            foreach ($days as $day => $performances) {
                $places = [];
                foreach ($performances as $performance) {
                    $places[$performance['place']][] = $performance;
                }
            ?>
                <div class='jazz-overview-day-column'>
                    <h3><?= $day ?></h3>
                    <?php foreach ($places as $place => $placePerformances) { ?>
                        <div class="jazz-overview-place-section">
                            <div class="jazz-overview-place">
                                <strong><?= $place ?></strong>
                            </div>
                            <div class="jazz-overview-performance-grid">
                                <?php foreach ($placePerformances as $performance) { ?>
                                    <div class='jazz-overview-performance'>
                                        <strong><?= $performance['name'] ?></strong><br>
                                        <?= date('H:i', strtotime($performance['start_time'])) . " - " . date('H:i', strtotime($performance['end_time'])) ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

</main>
