<main id="shopping-cart" class="container-xxl mt-5">
	<h1 class="w-100">Cart</h1>

	<section class="container-fluid row">
		<section class="shopping-cart-items mt-4 container col-8">
			<?php
			foreach ($ShoppingCartItems as $item):
				/** @var \Models\ShoppingCartItem $item */
				?>
				<div class="ticket row align-items-center gap-3 rounded-3 p-3 bg-white m-0 mb-5 position-relative"
					data-item-id="<?= $item->getItemID() ?>" data-cart-id="<?= $item->getCartID() ?>"
					data-event-id="<?= $item->getEventID() ?>" data-quantity="<?= $item->getQuantity() ?>"
					data-price="<?= $item->getEvent()->getPrice() ?>">

					<div class="col-12 col-md-4 p-0">
						<img src="/images/<?= $item->getEvent()->getImageName() ?>" class="img-fluid ticket-image rounded-3"
							alt="<?= $item->getEvent()->getName() ?>">
					</div>

					<div class="col rounded-3 row ticket-info p-4 mx-0 position-static">
						<div class="col-12 col-md-7">
							<h3 class="fw-bold"><?= $item->getEvent()->getName() ?></h3>
							<p>&#128205; <?= $item->getEvent()->getLocation() ?></p>
							<p>&#128197;
								<!-- Friday 27 July 18:00-22:00 -->
								<?= date('l j F', strtotime($item->getEvent()->getDate())) ?>
								<?= date('H:i', strtotime($item->getEvent()->getStartTime())) ?>
								<!-- if duration is more than 0, add "- [time when it ends]" -->
								<?php if ($item->getEvent()->getDuration() > 0): ?>
									-
									<?= date('H:i', strtotime($item->getEvent()->getEndTime())) ?>
								<?php endif; ?>
							</p>
						</div>

						<div class="col d-flex flex-row justify-content-center align-items-center">
							<!-- <p class="price">&euro;
								<?= number_format($item->getEvent()->getPrice(), 2) ?>
							</p> -->

							<div class="d-flex align-items-center gap-3">
								<span class="price fw-bold">
									&euro; <?= number_format($item->getEvent()->getPrice(), 2) ?>
								</span>

								<div class="quantity-control d-flex align-items-center">
									<button class="btn btn-increase rounded-circle p-0 fw-bold">+</button>
									<span class="mx-2 fw-bold quantity"><?= $item->getQuantity() ?></span>
									<button class="btn btn-decrease rounded-circle p-0 fw-bold">−</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			endforeach;
			?>

			<hr class="border-4 border-dark">

			<?php
			$totalPrice = 0;
			foreach ($ShoppingCartItems as $item) {
				$totalPrice += $item->getEvent()->getPrice() * $item->getQuantity();
			}
			?>
			<p class="text-end fw-bold fs-3">Total: &euro; <?= number_format($totalPrice, 2) ?></p>
		</section>

		<section class="col-4">
			<?php require_once __DIR__ . './../payment/index.php'; ?>
		</section>
	</section>
</main>