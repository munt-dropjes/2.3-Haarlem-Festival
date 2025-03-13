<main>
    <div class="container mt-5">
        <a href="/jazz" class="btn btn-primary">Terug naar line-up</a>
        <h1><?= htmlspecialchars($artist['name']) ?></h1>
        <img src="/images/jazz/<?= htmlspecialchars($artist['image']) ?>" alt="<?= htmlspecialchars($artist['name']) ?>" class="img-fluid mb-4">
        
        <h3>Over de artiest</h3>
        <p><?= nl2br(htmlspecialchars($artist['description'])) ?></p>
        
        <h3>Bekend van</h3>
        <p><?= nl2br(htmlspecialchars($artist['known_for'])) ?></p>
        
        <h3>Beluister hun muziek</h3>
        <ul>
            <li><a href="<?= htmlspecialchars($artist['Song1Link']) ?>" target="_blank">Luister naar nummer 1</a></li>
            <li><a href="<?= htmlspecialchars($artist['Song2Link']) ?>" target="_blank">Luister naar nummer 2</a></li>
            <li><a href="<?= htmlspecialchars($artist['Song3Link']) ?>" target="_blank">Luister naar nummer 3</a></li>
        </ul>
    </div>
</main>
