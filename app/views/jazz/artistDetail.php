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
        class="img-fluid mb-4" style="width: 100vw; max-width: 100%; max-height: 317px; display: block;">
    <div class="container" style="display: flex; align-items: center;">
        <div style="width: 811px; margin-right: 20px;">
            <h2>A bit about <?= htmlspecialchars($artist->getName()) ?></h2>
            <p><?= htmlspecialchars($artist->getDescription()) ?></p>
        </div>
        <?php $fotocounter++; ?>
        <img src="/images/jazz/detail/<?= strtolower(str_replace(' ', '', $artist->getName())) ?>/<?= $fotocounter ?>.png"
            alt="<?= htmlspecialchars($artist->getName()) ?>" class="img-fluid mb-3" style="width: 811px; height: 377px; ">
    </div>

<!-- Artist Photo & Music Container -->
<div class="container-fluid py-4">
    <div class="row g-2 align-items-stretch">

        <!-- Artist Photo Container -->
        <div class="col-md-6" id="artist-photo-container">
            <div class="d-flex h-100 gap-1">
                <?php for ($i = 1; $i <= 2; $i++) {
                    $fotocounter++; ?>
                    <img src="/images/jazz/detail/<?= strtolower(str_replace(' ', '', $artist->getName())) ?>/<?= $fotocounter ?>.png"
                        alt="<?= htmlspecialchars($artist->getName()) ?>" class="img-fluid rounded object-fit-cover" id="artist-photo-<?= $i ?>" style="width: 48%; max-height: 360px; height: auto;">
                <?php } ?>
            </div>
        </div>

        <!-- Music Player Container -->
        <div class="col-md-6" id="music-player-container">
            <div class="d-flex flex-column h-100" style="gap: 5px;">
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

<div class="container" style="max-width: 1600px; "> 
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-custom" style="background-color: #FCFC7A; border-radius: 8px;">
        <div class="card-body">
          <h2 class="card-title text-center">Koop Tickets voor <?= htmlspecialchars($artist->getName()) ?></h2>
          <div class="bg-light p-3">
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</main>