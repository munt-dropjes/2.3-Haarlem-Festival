<main class="yummieDetail-container">
    <div class="yummieDetail-backbutton">
        <a href="/yummie" class="yummieDetail-btn-back">Back</a>
    </div>

    <?php if (!empty($images)): ?>
        <div id="carouselExampleIndicators" class="carousel slide text-center" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach ($images as $index => $image): ?>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $index; ?>"
                        class="<?= $index === 0 ? 'active' : ''; ?>"></li>
                <?php endforeach; ?>
            </ol>
            <div class="carousel-inner">
                <?php foreach ($images as $index => $image): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                        <img class="d-block mx-auto" src="<?= $image; ?>" alt="Restaurant afbeelding">
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    <?php else: ?>
        <!-- Toon een standaard afbeelding als er geen foto's zijn -->
        <div class="yummieDetail-album-images d-flex justify-content-center">
            <img src="/images/yummie/default.jpg" alt="Restaurant album placeholder" class="img-fluid">
        </div>
    <?php endif; ?>

    <div class="yummieDetail-tab-buttons d-flex justify-content-center gap-1 p-4">
        <button class="yummieDetail-tab-button active" data-tab="information">Information</button>
        <button class="yummieDetail-tab-button" data-tab="menu">Menu</button>
        <button class="yummieDetail-tab-button" data-tab="location">Location</button>
        <button class="yummieDetail-tab-button" data-tab="reservation">Reservation</button>
    </div>

    <?php if (isset($message)): ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                <?= $message; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="container yummieDetail-tabcontainer">
        <div id="information" class="yummieDetail-tabcontent">
            <?php require_once __DIR__ . '../../components/yummie/restaurant-description.php'; ?>
        </div>
        <div id="menu" class="yummieDetail-tabcontent" style="display: none;">
            <?php require_once __DIR__ . '../../components/yummie/restaurant-menu.php'; ?>
        </div>
        <div id="location" class="yummieDetail-tabcontent" style="display: none;">
            <?php require_once __DIR__ . '../../components/yummie/restaurant-location.php'; ?>
        </div>
        <div id="reservation" class="yummieDetail-tabcontent" style="display: none;">
            <?php require_once __DIR__ . '../../components/yummie/restaurant-reservation.php'; ?>
        </div>
        <div id="succes" class="yummieDetail-tabcontent" style="display: none;">
            <?php require_once __DIR__ . '../../components/yummie/reservation-succes.php'; ?>
        </div>
    </div>
    <div class="yummieDetail-reservation-button">
        <button class="btn yummieBtnPrimaryGray ms-5" style="height: 60px; width: 200px;">Make reservation</button>
        <?php require_once __DIR__ . '../../components/yummie/restaurant-reservation.php'; ?>
    </div>
</main>

<script src="/js/common.js"></script>
<script src="/js/yummie-detail.js"></script>
<script src="/js/reservation-confirm.js"></script>