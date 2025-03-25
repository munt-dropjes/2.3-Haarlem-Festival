<main id="jazzDetail">
    <div>
        <a href="/jazz" class="jazzbutton">
            Terug naar line-up
        </a>
        <div>
            <h1>
                <?= htmlspecialchars($artist->getName()) ?>
            </h1>
        </div>
    </div>
    <?php $fotocounter = 0; ?>
    <?php $fotocounter++; ?>
    <img src="/images/jazz/detail/<?= strtolower(str_replace(' ', '', $artist->getName())) ?>/<?= $fotocounter ?>.png"
        class="img-fluid mb-4">
    <div class="container">
        <div>
            <h2>A bit about <?= htmlspecialchars($artist->getName()) ?></h2>
            <p><?= htmlspecialchars($artist->getDescription()) ?></p>
        </div>
        <?php $fotocounter++; ?>
        <img src="/images/jazz/detail/<?= strtolower(str_replace(' ', '', $artist->getName())) ?>/<?= $fotocounter ?>.png"
            alt="<?= htmlspecialchars($artist->getName()) ?>" class="img-fluid mb-3">
    </div>

    <div class="container-fluid py-4">
        <div class="row g-2 align-items-stretch">

            <div class="col-md-6" id="artist-photo-container">
                <div class="d-flex h-100 gap-1">
                    <?php for ($i = 1; $i <= 2; $i++) {
                        $fotocounter++; ?>
                        <img src="/images/jazz/detail/<?= strtolower(str_replace(' ', '', $artist->getName())) ?>/<?= $fotocounter ?>.png"
                            alt="<?= htmlspecialchars($artist->getName()) ?>" class="img-fluid rounded object-fit-cover"
                            id="artist-photo-<?= $i ?>">
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-6" id="music-player-container">
                <div class="d-flex flex-column h-100">
                    <?php
                    for ($i = 1; $i <= 3; $i++) {

                        $method = "getSong{$i}Link";
                        $link = $artist->$method();

                        if ($link) {
                            $link = htmlspecialchars($link);

                            // Spotify embed
                            if (strpos($link, 'spotify.com') !== false) {
                                $embedUrl = str_replace('open.spotify.com', 'embed.spotify.com', $link);
                                echo "<iframe id='spotify-player-$i' src='$embedUrl' class='w-100' height='120' frameborder='0' allowtransparency='true' allow='encrypted-media'></iframe>";
                            }
                            // SoundCloud embed
                            elseif (strpos($link, 'soundcloud.com') !== false) {
                                echo "<iframe id='soundcloud-player-$i' class='w-100' height='120' scrolling='no' frameborder='no' allow='autoplay' src='https://w.soundcloud.com/player/?url=$link'></iframe>";
                            } else {
                                echo "<p id='invalid-link-$i'>Ongeldige link. Gebruik een geldige Spotify- of SoundCloud-link.</p>";
                            }
                        } else {
                            echo "<p id='no-link-$i'>Geen muzieklink beschikbaar.</p>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="ticket-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-custom">
                    <div class="card-body">
                        <h2 class="card-title text-center">Koop Tickets voor <?= htmlspecialchars($artist->getName()) ?>
                        </h2>
                        <div class="bg-light p-3">
                            <?php if (empty($tickets)): ?>
                                <p>Er zijn momenteel geen tickets beschikbaar.</p>
                            <?php else: ?>
                                <ul>
                                    <?php foreach ($tickets as $ticket): ?>
                                        <p>
                                            <?php
                                            $eventDate = new DateTime($ticket->getEventDate());
                                            $formattedDate = $eventDate->format('l F Y');
                                            $startTime = new DateTime($ticket->getStartTime());
                                            $formattedstartTime = $startTime->format('H:i');
                                            $endTime = new DateTime($ticket->getEndTime());
                                            $formattedendTime = $endTime->format('H:i');
                                            echo htmlspecialchars($formattedDate . ' - ' . $formattedstartTime . ' - ' . $formattedendTime . ' - €' . $ticket->getPrice());
                                            ?>
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </p>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>