<?php
/** @var \Models\User $user */
?>
<main>
	<div class="container">
		<form>
			<h1>Checkout</h1>
			<div class="mb-3">
				<label for="username" class="form-label">Full name:<span class="required">*</span></label>
				<input type="text" class="form-control" id="username" name="username" value="<?= $user->getName() ?>"
					required>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email:<span class="required">*</span></label>
				<input type="email" class="form-control" id="email" name="email" value="<?= $user->getEmail() ?>"
					required>
			</div>
			<div class="mb-3">
				<label for="phone" class="form-label">Phone:<span class="required">*</span></label>
				<input type="tel" class="form-control" id="phone" name="phone" value="<?= $user->getPhone() ?>"
					required>
			</div>

			<div class="mb-3">
				<label for="country" class="form-label">Country:</label><span class="required">*</span>

				<!--Oh god why-->
				<select id="country" name="country" class="form-control">
					<?php foreach ($countries as $country): ?>
						<option value="<?= $country ?>" <?= $country == $user->getCountry() ? 'selected' : '' ?>><?= $country ?>
						</option>
					<?php endforeach; ?>
				</select>
		</form>
		<hr>


		<form id="payment-form">
			<div id="payment-element">
				<!--Stripe.js injects the Payment Element-->
			</div>
			<button id="submit" class="g-recaptcha submitbtn btn w-100">
				<div class="spinner hidden" id="spinner"></div>
				<span id="button-text">Place order</span>
			</button>
			<div id="payment-message" class="hidden"></div>
		</form>
	</div>

	<script>
		const stripe = Stripe('pk_test_51R67PHCQMRACvY5RjFwUVmY6iv5rQPQN01H2mLgD2wJr1hKe4jcgPUX7hWEmPPK2nnHuvNHqfG3Eo1gQVeiA6z0y001sUcmIZR');

		let elements;

		initialize();

		document
			.querySelector("#payment-form")
			.addEventListener("submit", handleSubmit);

		// Fetches a payment intent and captures the client secret
		async function initialize() {
			const clientSecret = "<?php echo $clientSecret; ?>";

			elements = stripe.elements({
				clientSecret
			});

			const paymentElementOptions = {
				layout: "accordion",
			};

			const paymentElement = elements.create("payment", paymentElementOptions);
			paymentElement.mount("#payment-element");
		}

		async function handleSubmit(e) {
			e.preventDefault();
			setLoading(true);

			const {
				error
			} = await stripe.confirmPayment({
				elements,
				confirmParams: {
					return_url: `${window.location.origin}/checkout/complete`,
				},
			});

			// This point will only be reached if there is an immediate error when
			// confirming the payment. Otherwise, your customer will be redirected to
			// your `return_url`. For some payment methods like iDEAL, your customer will
			// be redirected to an intermediate site first to authorize the payment, then
			// redirected to the `return_url`.
			if (error.type === "card_error" || error.type === "validation_error") {
				showMessage(error.message);
			} else {
				showMessage("An unexpected error occurred.");
			}

			setLoading(false);
		}

		// ------- UI helpers -------

		function showMessage(messageText) {
			const messageContainer = document.querySelector("#payment-message");

			messageContainer.classList.remove("hidden");
			messageContainer.textContent = messageText;

			setTimeout(function () {
				messageContainer.classList.add("hidden");
				messageContainer.textContent = "";
			}, 4000);
		}

		// Show a spinner on payment submission
		function setLoading(isLoading) {
			if (isLoading) {
				// Disable the button and show a spinner
				document.querySelector("#submit").disabled = true;
				document.querySelector("#spinner").classList.remove("hidden");
				document.querySelector("#button-text").classList.add("hidden");
			} else {
				document.querySelector("#submit").disabled = false;
				document.querySelector("#spinner").classList.add("hidden");
				document.querySelector("#button-text").classList.remove("hidden");
			}
		}
	</script>




</main>