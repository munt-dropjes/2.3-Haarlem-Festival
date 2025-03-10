<main>
    <div class="container-fluid p-0">
        <img src="images/jazz1.png" class="img-fluid w-100" alt="Plaatje Haarlem Jazz">
    </div>
    <div class="container mt-4 text-center" style="max-width: 1425px;">
        <h1>JAZZ</h1>
        <p>Welkom bij de Jazz-kant van het Festival...</p>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Festival Line-up</h2>
        <div class="accordion" id="festivalAccordion">
            <?php foreach ($festivalDays as $dayId => $info) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDay<?= $dayId ?>">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay<?= $dayId ?>">
                            Dag <?= $dayId ?> - <?= date("l d F", strtotime($info['Date'])) ?>
                        </button>
                    </h2>
                    <div id="collapseDay<?= $dayId ?>" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <?php foreach ($info['artists'] as $artist) { ?>
                                <div class="artist-card">
                                    <img src="images/<?= $artist['image'] ?>" alt="<?= $artist['name'] ?>">
                                    <div><?= strtoupper($artist['name']) ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="jazz-overview-timetable-container">
        <h2 class="text-center mb-4">Festival Timetable</h2>
        <?php foreach ($timetable as $performance) { ?>
            <div>
                <strong><?= $performance['name'] ?></strong>
                <?= $performance['start_time'] ?> @ <?= $performance['place'] ?>
            </div>
        <?php } ?>
    </div>
</main>
