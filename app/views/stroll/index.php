<main>
    <img src="images/stroll/banner/strollBanner.png" alt="A stroll through history banner image." class = "Stroll_Banner">
    <div class="container" id="strollLocations">
        <div class="row align-items-center">
        <h1>Locations</h1>
            <div class="col">   
                <div class="routeImage">
                    <img src="images/stroll/map/map.png" alt="A stroll through history route map.">
                </div>  
            </div>
            <div class="col">
                <div class="RouteDestinations">
                    <?php
                        foreach ($data['details'] as $destination) {
                            if ($destination->getBreakLocation()) { 
                                echo "<br><p class='StrollStopNumber'>" . $destination->getStopNumber() . ".  " . "<a href='/stroll/detail?location=" . $destination->getStopNumber() . "'>" . $destination->getStopName() . " (Break location)" ."</a></p><br>";
                            }
                            else{
                            echo "<p class='StrollStopNumber'>" . $destination->getStopNumber() . ".  " . "<a href='/stroll/detail?location=" . $destination->getStopNumber() . "'>" . $destination->getStopName() . "</a></p>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="strollTours">
        <div class="container mt5">
            <h1>Tours</h1>
        </div>
        <div class="container">
            <div class="row align-items-start languageSelectionBar">
                <div class="col languageSelectionBarButton zen-dots-regular"><button class="selected" data-language="English">English</button></div>
                <div class="col languageSelectionBarButton zen-dots-regular"><button data-language="Dutch">Dutch</button></div>
                <div class="col languageSelectionBarButton zen-dots-regular"><button data-language="Chinese">Chinese</button></div>
            </div>
        </div>
        
        <div class="container mt-5 strollEvents">
            <?php
            $days = ['Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($days as $day) {
                echo "<div class='row align-items-start'><div class='col'><h2>$day</h2></div></div>";
                if ($events != null) {
                    $filteredEvents = array_filter($events, function ($event) use ($day) {
                        return date('l', strtotime($event->getDate())) == $day;
                    });
                    
                    // Maintain the sorting by time
                    usort($filteredEvents, function ($a, $b) {
                        return strtotime($a->getTime()) - strtotime($b->getTime());
                    });
                    
                    if (count($filteredEvents) > 0) {
                        // Create a flex container for horizontal display
                        echo "<div class='d-flex flex-row flex-nowrap overflow-auto'>";
                        foreach ($filteredEvents as $event) {
                            ?>
                            <div class="card event-card me-3" style="min-width: 18rem; max-width: 18rem;" data-language="<?php echo $event->getLanguage(); ?>">
                                <img src="images/stroll/tourcovers/<?php echo $event->getLanguage(); ?>.png" alt="Image of <?php echo $event->getName(); ?>">
                                <div class="card-body">
                                    <p class="card-text">Time: <?php echo $event->getTime(); ?></p>
                                    <p class="card-text">Language: <?php echo $event->getLanguage(); ?></p>
                                    <p class="card-text">Start Location: <?php echo $event->getLocation(); ?></p>
                                    <p class="card-text">Guide: <?php echo $event->getGuide(); ?></p>
                                    <p class="card-text">Tickets Available: <?php echo $event->getAvailableTickets(); ?></p>
                                    <select class="form-select">
                                        <?php if ($event->getAvailableTickets() == 0) { ?>
                                            <option value="" selected disabled>No tickets available</option>
                                        <?php }else {?>
                                            <option value="" selected disabled>Select option</option>
                                            <option value="regular">Regular Price: €<?php echo $event->getPrice(); ?></option>
                                            <option value="family">Family Price: €<?php echo $event->getFamilyTicketPrice(); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                        }
                        echo "</div>";
                    }
                } else {
                    echo "<p>No events available</p>";
                }
            }
            ?>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setupLanguageSelection();
        });
    </script>
</main>