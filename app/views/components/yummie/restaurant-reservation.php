<?php
use Repositories\ReservationRepository;
$reservationRepo = new ReservationRepository();
$max_capacity = $restaurant->seats;
?>

<div class="yummieDetail-tabcontent-box container py-5">
    <div class="row">
        <!-- Linkerzijde: Reserveringsinformatie -->
        <div class="col-md-6 p-4">
            <h1>Reserve Your Table at <?= htmlspecialchars($restaurant->name); ?></h1>
            <p>
                Reservations are required to secure your spot during the Haarlem Festival.
                When booking through the Haarlem Festival website, a <strong>reservation fee</strong> of €10 per person
                will be charged.
                This fee will be deducted from your final bill when you visit our restaurant.
            </p>
            <p>
                Do you have special requests? Let us know when making your reservation!
                Whether it’s dietary preferences, allergies, or requirements like wheelchair accessibility,
                our team is here to ensure your experience is as enjoyable as possible.
            </p>
            <p>
                By clicking the <strong>“Submit Reservation”</strong> button, these products will be added to your
                personal wishlist.
                From the wishlist, you can proceed to payment.
            </p>
            <p>We look forward to welcoming you to <?= htmlspecialchars($restaurant->name); ?>!</p>
        </div>

        <!-- Rechterzijde: Formulier -->
        <div class="col-md-6">
            <form id="reservation-form" class="p-4 rounded"
                style="background: #EDE1F2; border-radius: 3px;">
                <input type="hidden" name="restaurant_id" id="restaurant-id"
                    value="<?= htmlspecialchars($restaurant->id); ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

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
                            <button type="button" class="btn btn-day fw-bold" data-value="<?= htmlspecialchars($day); ?>"
                                style="background: #F700FF; color: white; border-radius: 10px; padding: 10px 20px;">
                                <?= htmlspecialchars($day); ?>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let dayButtons = document.querySelectorAll(".btn-day");
        let timeButtonsContainer = document.querySelector(".time-buttons-container");
        let selectedDayInput = document.getElementById("selected-day");
        let selectedTimeInput = document.getElementById("selected-time");
        let restaurantId = document.getElementById("restaurant-id").value;
        let submitButton = document.getElementById("submit-reservation");

        // ✅ Voorkom dat knoppen standaard het formulier verzenden
        dayButtons.forEach(button => {
            button.addEventListener("click", function () {
                let selectedDay = this.dataset.value;
                selectedDayInput.value = selectedDay;

                // Maak de geselecteerde dag visueel duidelijk
                dayButtons.forEach(btn => btn.classList.remove("form-btn-selected"));
                this.classList.add("form-btn-selected");

                // ✅ Vraag beschikbare tijdsloten op via AJAX
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/reservation/available-timeslots", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let response;
                        try {
                            response = JSON.parse(xhr.responseText);
                        } catch (error) {
                            console.error("Fout bij JSON-parsing:", error, xhr.responseText);
                            return;
                        }

                        // ✅ Verwijder bestaande knoppen
                        timeButtonsContainer.innerHTML = "";

                        if (response.timeslots.length === 0) {
                            timeButtonsContainer.innerHTML = "<p style='color: red;'>No available time slots.</p>";
                            return;
                        }

                        // ✅ Maak nieuwe knoppen met de juiste beschikbaarheid
                        response.timeslots.forEach(slot => {
                            let btn = document.createElement("button");
                            btn.textContent = slot.start_time;
                            btn.className = `btn btn-time fw-bold ${slot.is_full ? 'disabled-time' : ''}`;
                            btn.dataset.value = slot.start_time;
                            btn.type = "button"; // ✅ Voorkomt dat het formulier verzendt

                            if (slot.is_full) {
                                btn.disabled = true;
                                btn.style.background = "#cccccc";
                                btn.style.color = "#666666";
                            } else {
                                btn.style.background = "#F700FF";
                                btn.style.color = "white";
                            }
                            timeButtonsContainer.appendChild(btn);

                            // ✅ Selecteer een tijdslot zonder het formulier te verzenden
                            btn.addEventListener("click", function () {
                                selectedTimeInput.value = this.dataset.value;
                                document.querySelectorAll(".btn-time").forEach(b => b.classList.remove("form-btn-selected"));
                                this.classList.add("form-btn-selected");
                            });
                        });
                    }
                };
                xhr.send(`restaurant_id=${restaurantId}&day=${selectedDay}`);
            });
        });

        // ✅ Formulier wordt pas verzonden als op "Make Reservation" wordt geklikt
        submitButton.addEventListener("click", function (event) {
            // ✅ Controleer of een tijd en dag zijn geselecteerd
            if (!selectedDayInput.value) {
                alert("Please select a day.");
                return;
            }
            if (!selectedTimeInput.value) {
                alert("Please select a time.");
                return;
            }

            openTab(event, 'succes');
        });
    });
</script>