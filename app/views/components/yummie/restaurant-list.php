<div class="row gx-2 gx-lg-5 gy-4">
    <?php foreach ($restaurants as $restaurant): ?>
        <div class="col-md-4 mb-4">
            <div class="yummieOverview-card card">
                <img src="images/yummie/<?= htmlspecialchars($restaurant->image); ?>" class="card-img-top"
                    alt="<?= htmlspecialchars($restaurant->name); ?>">
                <div class="yummieOverview-card-body">
                    <h5 class="card-title"><?= htmlspecialchars($restaurant->name); ?></h5>
                    <p><?= $restaurant->getStarRating(); ?></p>
                    <p><?= htmlspecialchars($restaurant->getCuisines()); ?></p>
                    <p>Opens at <?= htmlspecialchars_decode($restaurant->open_time); ?></p>
                    <div class="d-flex justify-content-between">
                        <a href="/yummie/<?= $restaurant->id; ?>#reservation"
                            class="btn yummieBtnPrimaryYellow px-lg-4 px-xl-5">RESERVE</a>
                        <a href="/yummie/<?= $restaurant->id; ?>"
                            class="btn yummieBtnPrimaryGray px-lg-4 px-xl-5">DETAILS</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>