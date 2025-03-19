<main id="dance">
	<div class="top-image container-fluid p-0">
		<img src="/images/dance/dance-festival.png" class="img-fluid w-100" alt="plaatje kerk haarlem">
	</div>

	<div class="container-lg pt-5">
		<div id="artist">
			<div class="bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">Artists</p>
			</div>

			<div class="dance-swiper mt-3">
				<div class="swiper-wrapper">
					<?php foreach ($artists as $artist):
						/** @var \Models\Artist $artist */ ?>
						<a href="/dance/hardwell" class="swiper-slide swiper-slide-normal card overflow-hidden rounded-4">
							<div class="image-container position-relative">
								<img class="ArtistImage card-image-top" src="/images/dance/<?= $artist->getImageName() ?>"
									alt="">
								<i class="text-center fw-bold d-none"><?= $artist->getName() ?></i>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div id="friday" class="mt-5">
			<div class="bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">Friday</p>
			</div>

			<div class="dance-swiper mt-3">
				<div class="swiper-wrapper">
					<?php foreach ($FridayEvents as $event):
						/** @var \Models\Event $event */ ?>
						<div class="swiper-slide swiper-slide-extended card overflow-hidden rounded-4">
							<div class="image-container position-relative">
								<img clang="EventImage card-img-top" src="/images/dance/<?= $event->getImageName() ?>"
									alt="foto van <?= $event->getName() ?>">
								<i class="text-center fw-bold d-none"><?= $event->getName() ?></i>
							</div>

							<div class="card-body pt-0 fw-bold">
								<button class="CTA my-3 py-2 px-5">Buy</button>
								<p class="card-text">Duration: <?= $event->getDuration() ?></p>
								<p class="card-text">Tickets avilable: <?= $event->getAvailableTickets() ?></p>
								<p class="card-text">Price: &euro;<?= $event->getPrice() ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div id="saturday" class="mt-5">
			<div class="bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">Saturday</p>
			</div>

			<div class="dance-swiper mt-3">
				<div class="swiper-wrapper">
					<?php foreach ($SaturdayEvents as $event):
						/** @var \Models\Event $event */ ?>
						<div class="swiper-slide swiper-slide-extended card overflow-hidden rounded-4">
							<div class="image-container position-relative">
								<img clang="EventImage card-img-top" src="/images/dance/<?= $event->getImageName() ?>"
									alt="foto van <?= $event->getName() ?>">
								<i class="text-center fw-bold d-none"><?= $event->getName() ?></i>
							</div>

							<div class="card-body pt-0 fw-bold">
								<button class="CTA my-3 py-2 px-5">Buy</button>
								<p class="card-text">Duration: <?= $event->getDuration() ?></p>
								<p class="card-text">Tickets avilable: <?= $event->getAvailableTickets() ?></p>
								<p class="card-text">Price: &euro;<?= $event->getPrice() ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div id="sunday" class="mt-5">
			<div class="bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">Sunday</p>
			</div>

			<div class="dance-swiper mt-3">
				<div class="swiper-wrapper">
					<?php foreach ($SundayEvents as $event):
						/** @var \Models\Event $event */ ?>
						<div class="swiper-slide swiper-slide-extended card overflow-hidden rounded-4">
							<div class="image-container position-relative">
								<img clang="EventImage card-img-top" src="/images/dance/<?= $event->getImageName() ?>"
									alt="foto van <?= $event->getName() ?>">
								<i class="text-center fw-bold d-none"><?= $event->getName() ?></i>
							</div>

							<div class="card-body pt-0 fw-bold">
								<button class="CTA my-3 py-2 px-5">Buy</button>
								<p class="card-text">Duration: <?= $event->getDuration() ?></p>
								<p class="card-text">Tickets avilable: <?= $event->getAvailableTickets() ?></p>
								<p class="card-text">Price: &euro;<?= $event->getPrice() ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div id="all-access" class="mt-5">
			<div class="bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">All Access Pass</p>
			</div>

			<div class="dance-swiper mt-3">
				<div class="swiper-wrapper">
					<?php foreach ($AllAccessPass as $event):
						/** @var \Models\Event $event */ ?>
						<div class="event-button-hover swiper-slide swiper-slide-normal card overflow-hidden rounded-4">
							<div class="image-container position-relative">
								<img clang="card-img-top" src="/images/dance/<?= $event->getImageName() ?>"
									alt="All Access Pass">
								<i class="text-center fw-bold">
									<span>
										<?= date('l', strtotime($event->getDate())) ?>
									</span>
									<span>
										&euro;<?= $event->getPrice() ?>
									</span>
								</i>
								<button class="CTA py-2 px-5">Buy</button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>
</main>