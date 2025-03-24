// yummie-detail.js

document.addEventListener("DOMContentLoaded", function () {
    const reservationButton = document.querySelector(".yummieDetail-reservation-button button");
    if (reservationButton) {
        reservationButton.addEventListener("click", function () {
            openTab('reservation');
        });
    }

    const dayButtons = document.querySelectorAll(".btn-day");
    const timeButtonsContainer = document.querySelector(".time-buttons-container");
    const selectedDayInput = document.getElementById("selected-day");
    const selectedTimeInput = document.getElementById("selected-time");
    const restaurantId = document.getElementById("restaurant-id")?.value;
    const submitButton = document.getElementById("submit-reservation");

    dayButtons.forEach(button => {
        button.addEventListener("click", function () {
            const selectedDay = this.dataset.value;
            selectedDayInput.value = selectedDay;

            dayButtons.forEach(btn => btn.classList.remove("form-btn-selected"));
            this.classList.add("form-btn-selected");

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/reservation/available-timeslots", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response;
                    try {
                        response = JSON.parse(xhr.responseText);
                    } catch (error) {
                        console.error("JSON parse error:", error, xhr.responseText);
                        return;
                    }

                    timeButtonsContainer.innerHTML = "";

                    if (response.timeslots.length === 0) {
                        timeButtonsContainer.innerHTML = "<p style='color: red;'>No available time slots.</p>";
                        return;
                    }

                    response.timeslots.forEach(slot => {
                        const btn = document.createElement("button");
                        btn.textContent = slot.start_time;
                        btn.className = `btn btn-time fw-bold ${slot.is_full ? 'disabled-time' : ''}`;
                        btn.dataset.value = slot.start_time;
                        btn.type = "button";

                        if (slot.is_full) {
                            btn.disabled = true;
                            btn.style.background = "#ccc";
                            btn.style.color = "#666";
                        } else {
                            btn.style.background = "#F700FF";
                            btn.style.color = "white";
                        }

                        btn.addEventListener("click", function () {
                            selectedTimeInput.value = this.dataset.value;
                            document.querySelectorAll(".btn-time").forEach(b => b.classList.remove("form-btn-selected"));
                            this.classList.add("form-btn-selected");
                        });

                        timeButtonsContainer.appendChild(btn);
                    });
                }
            };
            xhr.send(`restaurant_id=${restaurantId}&day=${selectedDay}`);
        });
    });

    if (submitButton) {
        submitButton.addEventListener("click", function () {
            if (!selectedDayInput.value) {
                alert("Please select a day.");
                return;
            }
            if (!selectedTimeInput.value) {
                alert("Please select a time.");
                return;
            }
            openTab('succes');
        });
    }
    // Voeg klikfunctionaliteit toe aan de tab-knoppen
    const tabButtons = document.querySelectorAll(".yummieDetail-tab-button");
    tabButtons.forEach(button => {
        button.addEventListener("click", function () {
            const tabName = this.dataset.tab;
            openTab(tabName);
        });
    });

    // Automatisch de juiste tab openen op basis van URL hash
    const hash = window.location.hash.replace("#", "");
    if (hash) {
        openTab(hash);
    } else {
        openTab("information"); // fallback
    }

});
