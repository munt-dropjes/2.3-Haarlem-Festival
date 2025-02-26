<main>
    <div class="container-fluid p-0">
		<img src="images/jazz1.png" class="img-fluid w-100" alt="plaatje kerk haarlem">
	</div>
    <div class="container mt-4 text-center" style="max-width: 1425px; margin: 0 auto;">
		<h1>JAZZ</h1>
		<p>Welcome to the Jazz side of the Festival, where everyone comes alive with music, and the city transforms into a stage for the enchantment of jazz. Haarlem Jazz, an annual highlight for music enthusiasts, brings the vibrant sounds of jazz, soul, and world music to historic squares and intimate venues. From swinging solos to sultry melodies – discover the raw power of live music in a truly unique setting. All performances of the first 3 days will be given at Patronaat (Zijlsingel 2, Haarlem)</p>
	</div>




    <div class="container mt-5">
    <h2 class="text-center mb-4">Festival Line-up</h2>

    <div class="accordion" id="festivalAccordion">
        <?php foreach ($festivalDays as $dayId => $info) { ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDay<?= $dayId ?>">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay<?= $dayId ?>" aria-expanded="true">
                        Dag <?= $dayId ?> - <?= date("l d F", strtotime($info['date'])) ?>
                    </button>
                </h2>
                <div id="collapseDay<?= $dayId ?>" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="artist-container">
                            <?php foreach ($info['artists'] as $artist) { ?>
                                <div class="artist-card">
                                    <img src="images/<?= $artist['image'] ?>" alt="<?= $artist['name'] ?>">
                                    <div class="artist-name"><?= strtoupper($artist['name']) ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>



</main>