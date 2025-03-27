// reservation-confirm.js

document.addEventListener("DOMContentLoaded", function () {
    const makeReservationButton = document.getElementById("submit-reservation");

    if (makeReservationButton) {
        makeReservationButton.addEventListener("click", function (event) {
            event.preventDefault();

            const adults = document.getElementById("adults").value;
            const children = document.getElementById("children").value;
            const day = document.getElementById("selected-day").value;
            const time = document.getElementById("selected-time").value;
            const extraInfo = document.getElementById("extra-info").value;
            const restaurantId = document.getElementById("restaurant-id").value;
            const csrfToken = document.querySelector("input[name='csrf_token']").value;

            // Toon gegevens
            document.getElementById("confirm-adults").textContent = adults;
            document.getElementById("confirm-children").textContent = children;
            document.getElementById("confirm-day").textContent = day;
            document.getElementById("confirm-time").textContent = time;
            document.getElementById("confirm-extra").textContent = extraInfo || "None";

            // Vul inputs
            document.getElementById("csrf-token").value = csrfToken;
            document.getElementById("confirm-restaurant-id").value = restaurantId;
            document.getElementById("confirm-adults-input").value = adults;
            document.getElementById("confirm-children-input").value = children;
            document.getElementById("confirm-day-input").value = day;
            document.getElementById("confirm-time-input").value = time;
            document.getElementById("confirm-extra-input").value = extraInfo;

            openTab(event, 'succes');
        });
    }
});
