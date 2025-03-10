<main>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            $eventName = $detail->getStopName();
            $encodedEventName = str_replace(' ', '', $eventName); // Remove spaces from the event name
            $imagesPath = __DIR__ . "images/strollDetails/$encodedEventName/Carousel/*.{jpg,jpeg,png,gif}";
            $images = glob($imagesPath, GLOB_BRACE);

            foreach ($images as $index => $image) {
                $activeClass = $index === 0 ? 'active' : '';
                echo "<li data-target='#carouselExampleIndicators' data-slide-to='$index' class='$activeClass'></li>";
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php
            foreach ($images as $index => $image) {
                $activeClass = $index === 0 ? 'active' : '';
                $imagePath = str_replace(__DIR__ . '/../../public/', '', $image);
                echo "
                <div class='carousel-item $activeClass'>
                    <img src='/$imagePath' class='d-block w-100' alt='...'>
                </div>";
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="RouteDestinations">
        <h1><?php echo $detail->getStopName(); ?></h1>

        <img src="images/StrollDetails/Grotemarkt/Map/map.png" alt="Map of <?php echo $detail->getStopName(); ?> location">
        <p>Address: <?php echo $detail->getAddress(); ?></p>
        <p><?php echo $detail->getDescription(); ?></p>
    </div>
</main>

<!-- Add Bootstrap CSS and JS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>