<main id="jazzDetail">
    <div style="display: flex; align-items: center; width: 100%; margin-bottom: 20px;">
        <a href="/jazz" class="jazzbutton"
            style="position: absolute; left: 20px;margin-top: 20px;background-color: grey; color: white; border-radius: 0; padding: 10px 20px;">
            Terug naar line-up
        </a>
        <div style="flex-grow: 1; text-align: center;margin-top: 20px;">
            <h1 style="margin: 0;">
                <?= htmlspecialchars($artist->getName()) ?>
            </h1>
        </div>
    </div>
    <?php $fotocounter = 0; ?>
    <?php $fotocounter++; ?>
    <img src="/images/jazz/detail/<?= strtolower(str_replace(' ', '', $artist->getName())) ?>/<?= $fotocounter ?>.png"
        class="img-fluid mb-4" style="width: 100vw; max-width: 100%; display: block;">
    <div class="container" style="display: flex; align-items: center;">
        <div style="width: 50%; margin-right: 20px;">
            <h2>A bit about <?= htmlspecialchars($artist->getName()) ?></h2>
            <p><?= htmlspecialchars($artist->getDescription()) ?></p>
        </div>
        <?php $fotocounter++; ?>
        <img src="/images/jazz/detail/<?= strtolower(str_replace(' ', '', $artist->getName())) ?>/<?= $fotocounter ?>.png"
            alt="<?= htmlspecialchars($artist->getName()) ?>" class="img-fluid mb-3" style="max-width: 40%;">
    </div>


    <!-- Artist Photo Container -->
    <div class="artistfoto-container" style="max-width: 50%; display: flex; gap: 10px;">
        <div class="artist-photo" style="height: 300;">
            <?php for ($i = 1; $i <= 2; $i++) {
                $fotocounter++; ?>
                <img src="/images/jazz/detail/<?= strtolower(str_replace(' ', '', $artist->getName())) ?>/<?= $fotocounter ?>.png"
                    alt="<?= htmlspecialchars($artist->getName()) ?>" class="img-fluid rounded">
            <?php } ?>
        </div>
    </div>

    <div id="player" style="width: 50%; float: right;">
        <?php
        for ($i = 1; $i <= 3; $i++) {

            $method = "getSong{$i}Link";
            $link = $artist->$method();

            if ($link) {
                $link = htmlspecialchars($link);

                // Spotify embed
                if (strpos($link, 'spotify.com') !== false) {
                    $embedUrl = str_replace('open.spotify.com', 'embed.spotify.com', $link);
                    echo "<iframe src='$embedUrl' width='100%' height='166' frameborder='0' allowtransparency='true' allow='encrypted-media'></iframe>";
                }
                // SoundCloud embed
                elseif (strpos($link, 'soundcloud.com') !== false) {
                    echo "<iframe width='100%' height='166' scrolling='no' frameborder='no' allow='autoplay' src='https://w.soundcloud.com/player/?url=$link'></iframe>";
                } else {
                    echo "<p>Ongeldige link. Gebruik een geldige Spotify- of SoundCloud-link.</p>";
                }
            } else {
                echo "<p>Geen muzieklink beschikbaar.</p>";
            }
        }
        ?>
    </div>

</main>