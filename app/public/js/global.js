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

document.addEventListener('DOMContentLoaded', function () {
    setupLanguageSelection();
});

/////////////////////////////


var swiper = new Swiper(".swiper", {
	slidesPerView: 1,
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