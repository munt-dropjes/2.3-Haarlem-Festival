
<div class="yummieDetail-tabcontent-box container py-5">
    <div class="row">
        <!-- Linkerzijde: Reserveringsinformatie -->
        <div class="col-md-6 p-4">
            <p><?= nl2br($restaurant->getReservationDescription()); ?></p>
        </div>

        <!-- Rechterzijde: Formulier -->
        <div class="col-md-6">
            <form id="reservation-form" class="p-4 rounded" style="background: #EDE1F2; border-radius: 3px;">
                <input type="hidden" name="restaurant_id" id="restaurant-id" value="<?= $restaurant->id; ?>">

                <!-- Aantal volwassenen -->
                <div class="mb-3">
                    <label for="adults" class="form-label">Adults</label>
                    <input type="number" id="adults" name="adults" class="form-control p-3 border border-dark"
                        placeholder="Number of adults" min="1" required
                        style="background: #F7D7FF; border-radius: 10px !important;">
                </div>

                <!-- Aantal kinderen -->
                <div class="mb-3">
                    <label for="children" class="form-label">Children</label>
                    <input type="number" id="children" name="children" class="form-control p-3 border border-dark"
                        placeholder="Number of children" min="0"
                        style="background: #F7D7FF; border-radius: 10px !important;">
                </div>

                <!-- Selecteer een dag -->
                <div class="mb-3">
                    <label class="form-label">Day</label>
                    <div class="d-flex gap-2">
                        <?php foreach ($restaurant->availableDays as $day): ?>
                            <button type="button" class="btn btn-day fw-bold" data-value="<?= $day; ?>"
                                style="background: #F700FF; color: white; border-radius: 10px; padding: 10px 20px;">
                                <?= $day; ?>
                            </button>
                        <?php endforeach; ?>
                        <input type="hidden" id="selected-day" name="day" required>
                    </div>
                </div>

                <!-- Selecteer een tijd -->
                <div class="mb-3">
                    <label class="form-label">Time</label>
                    <div class="d-flex gap-2 time-buttons-container">
                        <!-- ✅ Tijdsloten worden hier dynamisch toegevoegd via JavaScript -->
                    </div>
                    <input type="hidden" id="selected-time" name="start_time" required>
                </div>

                <!-- Extra informatie -->
                <div class="mb-3">
                    <label for="extra-info" class="form-label">Extra information</label>
                    <textarea id="extra-info" name="extra_info" class="form-control p-3 border border-dark" rows="3"
                        placeholder="Please enter your special requests or dietary restrictions here."
                        style="background: #F7D7FF; border-radius: 10px !important;"></textarea>
                </div>

                <!-- Submit knop -->
                <div class="text-center">
                    <button type="button" id="submit-reservation" class="btn yummieBtnPrimaryYellow"
                        style="height: 50px;">
                        MAKE RESERVATION
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>