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

try {
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
} catch (error) {
	console.log("Failed to load swiperJS: " + error);
}

document.addEventListener("DOMContentLoaded", function () {
	document.querySelectorAll(".select-all").forEach(function (control) {
		control.addEventListener("click", function () {
			fetch(`/shopping-cart/select-all`, {
				method: "GET"
			})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						document.querySelectorAll(".add-to-selected").forEach(function (control) {
							control.setAttribute("data-selected", true);
							selectButtonChange(control, true)
						});
					} else {
						alert("Failed to update cart.");
					}
				})
				.catch(error => console.error("Error:", error));
		});
	});

	document.querySelectorAll(".pay-for-selected").forEach(function (control) {
		control.addEventListener("click", function () {
			fetch(`/shopping-cart/pay-for-selected`, {
				method: "GET"
			})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						ticketQuantity = newQuantity;
						quantitySpan.textContent = newQuantity;
					} else {
						alert("Failed to update cart.");
					}
				})
				.catch(error => console.error("Error:", error));
		});
	});

	document.querySelectorAll(".quantity-control").forEach(function (control) {
		// Get the main element of the ticket
		let ticket = control.closest(".ticket");

		// Get the ticket quantity controls
		let quantitySpan = control.querySelector(".quantity");
		let increaseBtn = control.querySelector(".btn-increase");
		let decreaseBtn = control.querySelector(".btn-decrease");

		// Get the ticket information
		let itemId = ticket.getAttribute("data-item-id");
		let cartId = ticket.getAttribute("data-cart-id");
		let eventId = ticket.getAttribute("data-event-id");
		let ticketQuantity = ticket.getAttribute("data-quantity");
		let ticketPrice = ticket.getAttribute("data-price");

		function updateQuantity(newQuantity) {
			fetch(`/shopping-cart/update-quantity/${itemId}/${newQuantity}`, {
				method: "GET"
			})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						ticketQuantity = newQuantity;
						quantitySpan.textContent = newQuantity;
					} else {
						alert("Failed to update cart.");
					}
				})
				.catch(error => console.error("Error:", error));
		}

		function removeItem() {
			fetch(`/shopping-cart/remove-item/${itemId}`, {
				method: "GET"
			})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						ticket.remove();
					} else {
						alert("Failed to remove item from cart.");
					}
				})
				.catch(error => console.error("Error:", error));
		}

		increaseBtn.addEventListener("click", function () {
			let currentQuantity = parseInt(quantitySpan.textContent, 10);
			let newQuantity = currentQuantity + 1;
			updateQuantity(newQuantity);
		});

		decreaseBtn.addEventListener("click", function () {
			let currentQuantity = parseInt(quantitySpan.textContent, 10);
			if (currentQuantity > 1) {
				let newQuantity = currentQuantity - 1;
				updateQuantity(newQuantity);
			}
			else {
				removeItem();
			}
		});
	});

	document.querySelectorAll(".add-to-selected").forEach(function (control) {
		let ticket = control.closest(".ticket");

		let itemId = ticket.getAttribute("data-item-id");

		function changeSelected(selected) {
			fetch(`/shopping-cart/select-item/${itemId}/${!selected}`, {
				method: "PATCH"
			})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						control.setAttribute("data-selected", !selected);

						selectButtonChange(control, !selected)
					} else {
						alert("Failed to update cart.");
					}
				})
				.catch(error => console.error("Error:", error));
		}

		control.addEventListener("click", function () {
			let dataSelected = control.getAttribute("data-selected") === "true";
			changeSelected(dataSelected);
		})
	});

	function selectButtonChange(element, selected) {
		if (selected) {
			element.textContent = "Remove from shopping cart"
			element.classList.remove("btn-success");
			element.classList.add("btn-danger");
		} else {
			element.textContent = "Add to shopping cart"
			element.classList.remove("btn-danger");
			element.classList.add("btn-success");
		}
	}
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

// Add items to shopping cart
function addToCart(itemId, quantity = 1, isFamilyTicket = false) {
	fetch(`/shopping-cart/add-item/${itemId}/${quantity}/${isFamilyTicket}`, {
		method: "GET"
	})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				alert("Item added to cart!");
			} else {
				alert("Failed to add item to cart.");
			}
		})
		.catch(error => console.error("Error:", error));
}