function toggleSidebar() {
	document.getElementById("sidebar").classList.toggle('active');
}

// for the account creation reCAPTCHA
function onSubmit(token) {
	document.getElementById("create-account-form").submit();
}

// for the login reCAPTCHA
function onSubmitLogin(token) {
	document.getElementById("login-form").submit();
}


function toggleAccountSidebar() {
	document.getElementById('accountbar').classList.toggle('active');
}


//for the cms edit modal
function loadEditModalCMS(modalID) {
    var updateUserModal = document.getElementById(modalID);

    if (!updateUserModal) return;

    updateUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        if (!button) return;

        var name = button.getAttribute('data-name');
        var email = button.getAttribute('data-email');
        var phone = button.getAttribute('data-phone');
        var country = button.getAttribute('data-country');
        var role = button.getAttribute('data-role');

        var modalNameInput = updateUserModal.querySelector('#name');
        var modalEmailInput = updateUserModal.querySelector('#email');
        var modalPhoneInput = updateUserModal.querySelector('#phone');
        var modalCountryInput = updateUserModal.querySelector('#country');
        var modalRoleSelect = updateUserModal.querySelector('#role');

        if (modalNameInput) modalNameInput.value = name;
        if (modalEmailInput) modalEmailInput.value = email;
        if (modalPhoneInput) modalPhoneInput.value = phone;
        if (modalCountryInput) modalCountryInput.value = country;
        if (modalRoleSelect) modalRoleSelect.value = role;
    });
}



//for stroll language selection//
function setupLanguageSelection() {
    const buttons = document.querySelectorAll('.languageSelectionBarButton button');
    const cards = document.querySelectorAll('.event-card');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            buttons.forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');
            const selectedLanguage = this.getAttribute('data-language');
            cards.forEach(card => {
                if (card.getAttribute('data-language') === selectedLanguage) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    document.querySelector('.languageSelectionBarButton .selected').click();
}
/////////////////////////////


var swiper = new Swiper(".dance-swiper", {
	slidesPerView: 2,
	spaceBetween: 10,
	grabCursor: true,
	setWrapperSize: true,
	pagination: {
		el: ".swiper-pagination",
		clickable: true,
	},
	breakpoints: {
		640: {
			slidesPerView: 3,
			spaceBetween: 10,
		},
		768: {
			slidesPerView: 4,
			spaceBetween: 20,
		},
		1024: {
			slidesPerView: 5,
			spaceBetween: 20,
		},
	},
});



//stripe payment function
function initiateStripePayment(publicKey, amount, createSessionUrl) {
    const stripe = Stripe(publicKey);
    const handlePayment = async () => {
        try {
            const response = await fetch(createSessionUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ amount: amount }) 
            });
            if (!response.ok) {
                throw new Error('Failed to create a checkout session');
            }
            const session = await response.json();
            const result = await stripe.redirectToCheckout({ sessionId: session.id });
            if (result.error) {
                console.error('Stripe Checkout error:', result.error.message);
            }
        } catch (error) {
            console.error('Error initiating Stripe payment:', error);
        }
    };
    return handlePayment;
}
/////////////////////////////