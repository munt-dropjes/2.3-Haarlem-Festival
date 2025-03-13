<main id="jazzDetail">
    <div style="display: flex; align-items: center; width: 100%; margin-bottom: 20px;">
        <a href="/jazz" class="jazzbutton"
            style="position: absolute; left: 20px;margin-top: 20px;background-color: grey; color: white; border-radius: 0; padding: 10px 20px;">
            Terug naar line-up
        </a>
        <div style="flex-grow: 1; text-align: center;margin-top: 20px;">
            <h1 style="margin: 0;">
                <?= htmlspecialchars($artist['name']) ?>
            </h1>
        </div>
    </div>
    <img src="/images/jazz/<?= htmlspecialchars($artist['image']) ?>" alt="<?= htmlspecialchars($artist['name']) ?>"
        class="img-fluid mb-4" style="width: 100vw; max-width: 100%; display: block;">
    <div class="container" style="display: flex; align-items: center;">
        <div style="width: 50%; margin-right: 20px;">
            <h2>A bit about <?= htmlspecialchars($artist['name']) ?></h2>
            <p><?= htmlspecialchars($artist['description']) ?></p>
        </div>
        <img src="/images/jazz/detail/<?= strtolower(str_replace(' ', '', $artist['name'])) ?>/1.png" alt="<?= htmlspecialchars($artist['name']) ?>"
            class="img-fluid mb-3" style="max-width: 40%;">
    </div>

</main>