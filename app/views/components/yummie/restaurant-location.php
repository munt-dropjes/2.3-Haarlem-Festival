<div class="yummieDetail-tabcontent-box container">
    <div class="row">
        <!-- Linkerkant: Openingstijden & Adres -->
        <div class="col-md-6 d-flex flex-column justify-content-center">
            <div class="location-info p-4">
                <h1 class="location-title">Opening Hours</h1>
                <table class="table table-borderless" style="width: 300px;">
                    <tbody>
                    <tr>
                            <td>Thursday</td>
                            <td><?= $restaurant->open_time ?? 'Closed'; ?> - <?= $restaurant->close_time ?? 'Closed'; ?></td>
                        </tr>
                        <tr>
                            <td>Friday</td>
                            <td><?= $restaurant->open_time ?? 'Closed'; ?> - <?= $restaurant->close_time ?? 'Closed'; ?></td>
                        </tr>
                        <tr>
                            <td>Saturday</td>
                            <td><?= $restaurant->open_time ?? 'Closed'; ?> - <?= $restaurant->close_time ?? 'Closed'; ?></td>
                        </tr>
                        <tr>
                            <td>Sunday</td>
                            <td><?= $restaurant->open_time ?? 'Closed'; ?> - <?= $restaurant->close_time ?? 'Closed'; ?></td>
                        </tr>
                    </tbody>
                </table>
                <p class="address mt-4">
                    <?= $restaurant->address ?? ''; ?><br>
                    <?= $restaurant->zipcode ?? ''; ?><br>
                    <?= $restaurant->city ?? ''; ?>
                </p>
            </div>
        </div>

        <!-- Rechterkant: Google Maps -->
        <div class="col-md-6 d-flex align-items-center p-4">
            <div class="map-container w-100">
                <iframe 
                    src="<?= $restaurant->mapLink ?? ''; ?>"
                    width="100%" height="350" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</div>
