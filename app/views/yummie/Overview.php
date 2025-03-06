<body class="yummieOverview-body">

<!-- Hero afbeelding -->
<div class="yummieOverview-hero">
    <img src="hero.jpg" alt="Stadsgezicht">
</div>


<!-- Filterbalk -->
<div class="container my-4">
    <div class="row yummieOverview-filter-bar text-center p-3">
        <div class="col-md-2">
            <select id="filter-duration" class="form-select filter-dropdown">
                <option value="">Duration</option>
                <option value="1.5">1,5 h</option>
                <option value="2">2 h</option>
            </select>
        </div>
        <div class="col-md-2">
            <select id="filter-start-time" class="form-select filter-dropdown">
                <option value="">Start time</option>
                <option value="16:30">16:30</option>
                <option value="17:00">17:00</option>
                <option value="17:30">17:30</option>
                <option value="18:00">18:00</option>
            </select>
        </div>
        <div class="col-md-2">
            <select id="filter-cuisine" class="form-select filter-dropdown">
                <option value="">Cuisine</option>
                <option value="French">French</option>
                <option value="Dutch">Dutch</option>
                <option value="Fish and seafood">Fish and seafood</option>
                <option value="Modern">Modern</option>
                <option value="European">European</option>
                <option value="Vegan">Vegan</option>
            </select>
        </div>
        <div class="col-md-2">
            <select id="filter-rating" class="form-select filter-dropdown">
                <option value="">Rating</option>
                <option value="1">★☆☆☆☆</option>
                <option value="2">★★☆☆☆</option>
                <option value="3">★★★☆☆</option>
                <option value="4">★★★★☆</option>
                <option value="5">★★★★★</option>
            </select>
        </div>
        <div class="col-md-2">
            <select id="filter-cost" class="form-select filter-dropdown">
                <option value="">Cost</option>
                <option value="€">€</option>
                <option value="€€">€€</option>
            </select>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php foreach ($restaurants as $restaurant): ?>
            <div class="col-md-4 mb-4"> <!-- 3 per rij -->
                <div class="yummieOverview-card card">
                    <img src="<?= htmlspecialchars($restaurant->image); ?>" class="card-img-top" alt="<?= htmlspecialchars($restaurant->name); ?>">
                    <div class="yummieOverview-card-body">
                        <h5 class="card-title"><?= htmlspecialchars($restaurant->name); ?></h5>
                        <p><?= $restaurant->getStarRating(); ?></p>
                        <p><?= htmlspecialchars($restaurant->cuisine); ?></p>
                        <p>Opens at <?= date("H:i", strtotime($restaurant->open_time)); ?></p>
                        <div class="btn-group"> 
                            <button class="btn yummieOverview-reserve-btn">RESERVE</button>
                            <button class="btn yummieOverview-details-btn">DETAILS</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>







</body>
