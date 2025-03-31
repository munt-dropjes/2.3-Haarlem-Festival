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