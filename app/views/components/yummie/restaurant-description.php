<div class="yummieDetail-tabcontent-box">
    <h1><? echo "Welcome at $restaurant->name" ?></h1>
    <p><? echo nl2br($restaurant->getReservationDescription()); ?></p>
    <p><? echo htmlspecialchars($restaurant->getStarRating()); ?></p>
</div>