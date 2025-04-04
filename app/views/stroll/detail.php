<main>

    <div class="stroll-swiper">
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php
                if (count($images) > 0) {
                    foreach ($images as $index => $image) {
                        $imagePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $image);
                        echo "
                            <div class='swiper-slide'>
                                <img src='$imagePath' class='d-block w-100' alt='Carousel image of $eventName'>
                            </div>";
                    }
                } else {
                    echo "
                        <div class='swiper-slide'>
                            <div class='d-flex justify-content-center align-items-center bg-light' style='height: 400px;'>
                                <p class='text-muted'>No images available for this location</p>
                            </div>
                        </div>";
                }
                ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>



    <div class="container" id="details">
        <div class="row" id="strollDetailsRow">
            <h1><?php echo $detail->getStopName(); ?></h1>
            <div class="col" id="strollDetailsCol">
                <?php
                $eventName = $detail->getStopName();
                $encodedEventName = str_replace(' ', '', $eventName);
                ?>
                <img src="/images/StrollDetails/<?php echo $encodedEventName; ?>/Map/<?php echo $detail->getMapName(); ?>" alt="Map of <?php echo $detail->getStopName(); ?> location" class="Stroll_Detail_Map">
                <p>Address: <?php echo $detail->getAddress(); ?></p>
            </div>
            <div class="col" id="strollDetaildescription">
                <p><?php echo $detail->getDescription(); ?></p>
            </div>
        </div>
    </div>
    <script src="strollSwiper.js"></script>
</main>