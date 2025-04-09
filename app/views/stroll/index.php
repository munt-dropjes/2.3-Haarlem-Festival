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
                <?php
                $selectedLanguage = $_GET['language'] ?? 'English';
                $languages = ['English', 'Dutch', 'Chinese'];
                foreach ($languages as $language) {
                    $isSelected = ($language === $selectedLanguage) ? 'selected' : '';
                    echo "<div class='col languageSelectionBarButton zen-dots-regular'>
                            <button class='$isSelected' data-language='$language'>$language</button>
                          </div>";
                }
                ?>
            </div>
        </div>
        
        <div class="container mt-5 strollEvents">
            <?php
            $days = ['Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($days as $day) {
                echo "<div class='row align-items-start'><div class='col'><h2>$day</h2></div></div>";
                if ($events != null) {
                    $filteredEvents = array_filter($events, function ($event) use ($day, $selectedLanguage) {
                        return date('l', strtotime($event->getStartTime())) == $day && $event->getLanguage() === $selectedLanguage;
                    });
                    
                    // Maintain the sorting by time
                    usort($filteredEvents, function ($a, $b) {
                        return strtotime($a->getStartTime()) - strtotime($b->getStartTime());
                    });
                    
                    if (count($filteredEvents) > 0) {
                        // Create a flex container for horizontal display
                        echo "<div class='d-flex flex-row flex-nowrap overflow-auto'>";
                        $cardCount = 0;
                        foreach ($filteredEvents as $event) {
                            ?>
                            
                            <div class="card event-card me-3" data-language="<?php echo $event->getLanguage(); ?>">
                                <img src="images/stroll/tourcovers/<?php echo $event->getLanguage(); ?>.png" alt="Image of <?php echo $event->getName(); ?>">
                                <div class="card-body">
                                    <p class="card-text">Time: <?php echo date('H:i', strtotime($event->getStartTime())); ?></p>
                                    <p class="card-text">Language: <?php echo $event->getLanguage(); ?></p>
                                    <p class="card-text">Start Location: <?php echo $event->getLocation(); ?></p>
                                    <p class="card-text">Guide: <?php echo $event->getGuide(); ?></p>
                                    <p class="card-text">Tickets Available: <?php echo $event->getAvailableTickets(); ?></p>
                                    
                                    <?php if ($event->getAvailableTickets() == 0) { ?>
                                        <p>No tickets available</p>
                                    <?php } else { ?>
                                        <select class="form-select" onchange="toggleBuyButton(this, <?= $event->getEventID(); ?>)">
                                            <option value="" selected disabled>Select option</option>
                                            <option value="regular">Regular Price: €<?php echo number_format($event->getPrice(), 2, '.', ''); ?></option>
                                            <option value="family">Family Price: €<?php echo number_format($event->getFamilyTicketPrice(), 2, '.', ''); ?></option>
                                        </select>
                                        <button id="buy-button-<?= $event->getEventID(); ?>" class="btn btn-primary stollBuyBtn" style="display: none;" onclick="addToCart(<?= $event->getEventID(); ?>, 1, false)">Buy</button>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php 
                            $cardCount++;
                            if ($cardCount % 3 == 0) {
                                echo "</div><div class='d-flex flex-row flex-nowrap overflow-auto'>";
                            }
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
    <script src="global.js"></script>
</main>