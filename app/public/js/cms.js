//for the cms user edit modal
function loadEditUserModalCMS(modalID) {
    var updateUserModal = document.getElementById(modalID);

    if (!updateUserModal){
        console.error('No modal found with the ID: ' + modalID);
        return;
    }

    console.error('Modal found with the ID: ' + modalID);

    updateUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        if (!button) return;

        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var email = button.getAttribute('data-email');
        var oldEmail = button.getAttribute('data-oldEmail');
        var password = button.getAttribute('data-password');
        var phone = button.getAttribute('data-phone');
        var country = button.getAttribute('data-country');
        var role = button.getAttribute('data-role');

        var modalIDInput = updateUserModal.querySelector('#id');
        var modalNameInput = updateUserModal.querySelector('#name');
        var modalEmailInput = updateUserModal.querySelector('#email');
        var modalOldEmailInput = updateUserModal.querySelector('#oldEmail');
        var modalPasswordInput = updateUserModal.querySelector('#password');
        var modalPhoneInput = updateUserModal.querySelector('#phone');
        var modalCountryInput = updateUserModal.querySelector('#country');
        var modalRoleSelect = updateUserModal.querySelector('#role');

        if (modalIDInput) modalIDInput.value = id;
        if (modalNameInput) modalNameInput.value = name;
        if (modalEmailInput) modalEmailInput.value = email;
        if (modalOldEmailInput) modalOldEmailInput.value = oldEmail;
        if (modalPasswordInput) modalPasswordInput.value = password;
        if (modalPhoneInput) modalPhoneInput.value = phone;
        if (modalCountryInput) modalCountryInput.value = country;
        if (modalRoleSelect) modalRoleSelect.value = role;
    });
}

//for the cms user delete modal
function loadDeleteUserModalCMS(modalID) {
    var deleteUserModal = document.getElementById(modalID);

    if (!deleteUserModal){
        console.error('No modal found with the ID: ' + modalID);
        return;
    }

    console.error('Modal found with the ID: ' + modalID);

    deleteUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        if (!button) return;

        var name = button.getAttribute('data-name');
        var email = button.getAttribute('data-email');
        var phone = button.getAttribute('data-phone');
        var country = button.getAttribute('data-country');
        var role = button.getAttribute('data-role');

        var modalNameInput = deleteUserModal.querySelector('#name');
        var modalEmailInput = deleteUserModal.querySelector('#email');
        var modalPhoneInput = deleteUserModal.querySelector('#phone');
        var modalCountryInput = deleteUserModal.querySelector('#country');
        var modalRoleSelect = deleteUserModal.querySelector('#role');

        if (modalNameInput) modalNameInput.value = name;
        if (modalEmailInput) modalEmailInput.value = email;
        if (modalPhoneInput) modalPhoneInput.value = phone;
        if (modalCountryInput) modalCountryInput.value = country;
        if (modalRoleSelect) modalRoleSelect.value = role;
    });
}

//for the cms event edit modal
function loadEditEventModalCMS(modalID) {
    var updateEventModal = document.getElementById(modalID);

    if (!updateEventModal){
        console.error('No modal found with the ID: ' + modalID);
        return;
    }

    console.error('Modal found with the ID: ' + modalID);

    updateEventModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        if (!button) return;

        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var description = button.getAttribute('data-description');
        var date = button.getAttribute('data-date');
        var time = button.getAttribute('data-time');
        var duration = button.getAttribute('data-duration');
        var location = button.getAttribute('data-location');
        var price = button.getAttribute('data-price');
        var category = button.getAttribute('data-category');

        var modalIDInput = updateEventModal.querySelector('#id');
        var modalNameInput = updateEventModal.querySelector('#name');
        var modalDescriptionInput = updateEventModal.querySelector('#description');
        var modalDateInput = updateEventModal.querySelector('#date');
        var modalTimeInput = updateEventModal.querySelector('#time');
        var modalDurationInput = updateEventModal.querySelector('#duration');
        var modalLocationInput = updateEventModal.querySelector('#location');
        var modalPriceInput = updateEventModal.querySelector('#price');
        var modalCategorySelect = updateEventModal.querySelector('#role');

        if (modalIDInput) modalIDInput.value = id;
        if (modalNameInput) modalNameInput.value = name;
        if (modalDescriptionInput) modalDescriptionInput.value = description;
        if (modalDateInput) modalDateInput.value = date;
        if (modalTimeInput) modalTimeInput.value = time;
        if (modalDurationInput) modalDurationInput.value = duration;
        if (modalLocationInput) modalLocationInput.value = location;
        if (modalPriceInput) modalPriceInput.value = price;
        if (modalCategorySelect) modalCategorySelect.value = category;
    });
}

//for the cms event delete modal
function loadDeleteEventModalCMS(modalID) {
    var deleteEventModal = document.getElementById(modalID);

    if (!deleteEventModal){
        console.error('No modal found with the ID: ' + modalID);
        return;
    }

    console.error('Modal found with the ID: ' + modalID);

    deleteEventModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        if (!button) return;

        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');

        var modalIdInput = deleteEventModal.querySelector('#id');
        var modalNameInput = deleteEventModal.querySelector('#name');

        if (modalIdInput) modalIdInput.value = id;
        if (modalNameInput) modalNameInput.value = name;
    });
}
