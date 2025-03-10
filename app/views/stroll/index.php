<main>
    <img src="images/stroll/banner/strollBanner.png" alt="A stroll through history banner image." class = "Stroll_Banner">
    <div class="container mt5">
        <div class="routeImage">
            <img src="pic_trulli.jpg" alt="A stroll through history route map.">
        </div>
        <div class="RouteDestinations">
            <?php
                foreach ($data['details'] as $destination) {
                    echo "<a href='/stroll/" . $destination->getStopNumber() . "'>" . $destination['name'] . "</p>";
                } 
            ?>
        </div>
    </div>
    <div class="container mt5">
        <h1>Tours</h1>
    </div>
    <div class="container text-center">
        <div class="row align-items-start languageSelectionBar">
            <div class="col languageSelectionBarButton"><button class="selected" data-callback='onSubmitLanguauge(English)'>English</button></div>

            <div class="col languageSelectionBarButton"><button data-callback='onSubmitLanguauge(Dutch)'>Dutch</button></div>

            <div class="col languageSelectionBarButton"><button data-callback='onSubmitLanguauge(Chinese)'>Chinese</button></div>
        </div>
    </div>
        
    <div class="container mt5">
        <div class="row align-items-start">
            <div class="col">
                <h2>Thursday</h2>
            </div>
        </div>
            <?php 
            if ($events != null) {  
                foreach ($events as $event) {  
                    if ($event["date"] == "Thursday") {
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
                    }
                
                foreach ($events as $event) { 
                    if ($event["date"] == "Thursday") {
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
                }
            }
            ?>
        </div>
    </div>
</main>