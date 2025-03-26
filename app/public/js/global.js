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

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            buttons.forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');
            const selectedLanguage = this.getAttribute('data-language');
            const url = new URL(window.location.href);
            url.searchParams.set('language', selectedLanguage);
            window.location.href = url.toString();
        });
    });
    const urlParams = new URLSearchParams(window.location.search);
    const currentLanguage = urlParams.get('language') || 'English';
    buttons.forEach(button => {
        if (button.getAttribute('data-language') === currentLanguage) {
            button.classList.add('selected');
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    setupLanguageSelection();
});



document.addEventListener('DOMContentLoaded', function () {
    
    const strollSwiperElement = document.querySelector('.stroll-swiper .swiper');
    if (strollSwiperElement) {
        const strollSwiper = new Swiper(strollSwiperElement, {
            slidesPerView: 3, 
            centeredSlides: true, 
            loop: true, 
            navigation: {
                nextEl: '.stroll-swiper .swiper-button-next', 
                prevEl: '.stroll-swiper .swiper-button-prev',
            },
            on: {
                init: function () {
                    updateStrollSlideStyles(); 
                },
                slideChangeTransitionEnd: function () {
                    updateStrollSlideStyles(); 
                },
            },
        });

        function updateStrollSlideStyles() {
            document.querySelectorAll('.stroll-swiper .swiper-slide').forEach(slide => {
                slide.classList.remove('center-slide', 'prev-slide', 'next-slide');
            });

            const activeSlide = document.querySelector('.stroll-swiper .swiper-slide.swiper-slide-active');
            if (activeSlide) {
                activeSlide.classList.add('center-slide');
            }

            const prevSlide = activeSlide.previousElementSibling || activeSlide.parentElement.lastElementChild;
            if (prevSlide) {
                prevSlide.classList.add('prev-slide');
            }

            const nextSlide = activeSlide.nextElementSibling || activeSlide.parentElement.firstElementChild;
            if (nextSlide) {
                nextSlide.classList.add('next-slide');
            }
        }
        strollSwiper.emit('init');
    }
});
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
(function(window) {
    // Ensure Stripe is available
    if (typeof Stripe === 'undefined') {
        console.error('Stripe.js is not loaded');
        return;
    }

    // Stripe initialization
    const stripePayment = {
        stripe: Stripe('pk_test_51R67PHCQMRACvY5RjFwUVmY6iv5rQPQN01H2mLgD2wJr1hKe4jcgPUX7hWEmPPK2nnHuvNHqfG3Eo1gQVeiA6z0y001sUcmIZR'),
        elements: null,

        initialize: function() {
            const clientSecret = "<?php echo $clientSecret; ?>";

            this.elements = this.stripe.elements({
                clientSecret
            });

            const paymentElementOptions = {
                layout: "accordion",
            };

            const paymentElement = this.elements.create("payment", paymentElementOptions);
            paymentElement.mount("#payment-element");
        },

        handleSubmit: async function(e) {
            e.preventDefault();
            this.setLoading(true);

            try {
                const { error } = await this.stripe.confirmPayment({
                    elements: this.elements,
                    confirmParams: {
                        return_url: `${window.location.origin}/checkout/complete`,
                    },
                });

                if (error.type === "card_error" || error.type === "validation_error") {
                    this.showMessage(error.message);
                } else {
                    this.showMessage("An unexpected error occurred.");
                }
            } catch (err) {
                this.showMessage("An unexpected error occurred.");
            } finally {
                this.setLoading(false);
            }
        },

        showMessage: function(messageText) {
            const messageContainer = document.querySelector("#payment-message");
            
            if (!messageContainer) return;

            messageContainer.classList.remove("hidden");
            messageContainer.textContent = messageText;

            setTimeout(function() {
                messageContainer.classList.add("hidden");
                messageContainer.textContent = "";
            }, 4000);
        },

        setLoading: function(isLoading) {
            const submitBtn = document.querySelector("#submit");
            const spinner = document.querySelector("#spinner");
            const buttonText = document.querySelector("#button-text");

            if (!submitBtn || !spinner || !buttonText) return;

            if (isLoading) {
                submitBtn.disabled = true;
                spinner.classList.remove("hidden");
                buttonText.classList.add("hidden");
            } else {
                submitBtn.disabled = false;
                spinner.classList.add("hidden");
                buttonText.classList.remove("hidden");
            }
        },

        init: function() {
            const paymentForm = document.querySelector("#payment-form");
            
            if (!paymentForm) return;

            this.initialize();
            paymentForm.addEventListener("submit", this.handleSubmit.bind(this));
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => stripePayment.init());
    } else {
        stripePayment.init();
    }

})(window);



/////////////////////////////