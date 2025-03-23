    <div class="yummieDetail-tabcontent-box container">
        <h2>Confirm Your Reservation</h2>
        <p>Please check your reservation details before proceeding:</p>

        <ul>
            <li><strong>Number of adults:</strong> <span id="confirm-adults"></span></li>
            <li><strong>Number of children:</strong> <span id="confirm-children"></span></li>
            <li><strong>Day:</strong> <span id="confirm-day"></span></li>
            <li><strong>Time:</strong> <span id="confirm-time"></span></li>
            <li><strong>Extra Information:</strong> <span id="confirm-extra"></span></li>
        </ul>

        <form id="confirm-reservation-form" action="/reservation/process" method="POST">
            <input type="hidden" name="csrf_token" id="csrf-token">
            <input type="hidden" name="restaurant_id" id="confirm-restaurant-id">
            <input type="hidden" name="adults" id="confirm-adults-input">
            <input type="hidden" name="children" id="confirm-children-input">
            <input type="hidden" name="day" id="confirm-day-input">
            <input type="hidden" name="start_time" id="confirm-time-input">
            <input type="hidden" name="extra_info" id="confirm-extra-input">

            <button type="submit" class="btn btn-success">CONFIRM RESERVATION</button>
        </form>

        <button class="btn btn-danger" onclick="openTab(event, 'reservation')">CANCEL</button>
    </div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let makeReservationButton = document.getElementById("submit-reservation");

    if (makeReservationButton) {
        makeReservationButton.addEventListener("click", function (event) {
            event.preventDefault(); // ⛔ Voorkom standaard formulier-verzending

            // ✅ Haal waarden uit het formulier
            let adults = document.getElementById("adults").value;
            let children = document.getElementById("children").value;
            let day = document.getElementById("selected-day").value;
            let time = document.getElementById("selected-time").value;
            let extraInfo = document.getElementById("extra-info").value;
            let restaurantId = document.getElementById("restaurant-id").value;
            let csrfToken = document.querySelector("input[name='csrf_token']").value;

            // ✅ Toon ingevulde gegevens in de "Reservation Success" tab
            document.getElementById("confirm-adults").textContent = adults;
            document.getElementById("confirm-children").textContent = children;
            document.getElementById("confirm-day").textContent = day;
            document.getElementById("confirm-time").textContent = time;
            document.getElementById("confirm-extra").textContent = extraInfo || "None";

            // ✅ Vul de verborgen inputs voor de bevestiging
            document.getElementById("csrf-token").value = csrfToken;
            document.getElementById("confirm-restaurant-id").value = restaurantId;
            document.getElementById("confirm-adults-input").value = adults;
            document.getElementById("confirm-children-input").value = children;
            document.getElementById("confirm-day-input").value = day;
            document.getElementById("confirm-time-input").value = time;
            document.getElementById("confirm-extra-input").value = extraInfo;
        });
    }
});

// ✅ Functie om tabs te wisselen
function openTab(evt, tabName) {
    let tabcontent = document.getElementsByClassName("yummieDetail-tabcontent");
    for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    let tabbuttons = document.getElementsByClassName("yummieDetail-tab-button");
    for (let i = 0; i < tabbuttons.length; i++) {
        tabbuttons[i].classList.remove("active");
    }

    document.getElementById(tabName).style.display = "block";
}
</script>
