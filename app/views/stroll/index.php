<main>
    <div class="container mt5">
        <div class="routeImage">
            <img src="pic_trulli.jpg" alt="A stroll through history route map.">
        </div>
        <div class="RouteDestinations">
            <?php
                foreach ($destinations as $destination) {
                    echo "<a href='/stroll/" . $destination['name'] . "'>" . $destination['name'] . "</p>";
                } 
            ?>
        </div>
    </div>

    <div class="container text-center">
        <div class="row align-items-start languageSelectionBar">
            <div class="col languageSelectionBarButton"><button class="selected" data-callback='onSubmitLanguauge(English)'>English</button></div>

            <div class="col languageSelectionBarButton"><button data-callback='onSubmitLanguauge(Dutch)'>Dutch</button></div>

            <div class="col languageSelectionBarButton"><button data-callback='onSubmitLanguauge(Chinese)'>Chinese</button></div>
        </div>
    </div>

    <div class="container mt5">
    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2Fwww.google.com%2F&choe=UTF-8" title="Link to Google.com" />
        <div class="row align-items-start">
            <?php 
                foreach ($events as $event) {  
                    ?>
                    <div class="card">
                        <img src="<?php echo $event['image']; ?>" alt="Image of <?php echo $event['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $event['name']; ?></h5>
                            <p class="card-text"><?php echo $event['description']; ?></p>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</main>