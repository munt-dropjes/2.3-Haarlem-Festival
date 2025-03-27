<?php
/** @var \models\Artist $artist */
?>

<main id="dance-artist">
	<div class="top-image container-fluid p-0 mb-5">
		<img src="/images/dance/<?= $artist->getBannerImage() ?>" class="img-fluid w-100" alt="foto van artist">
		<a href="#schedule" class="buy-tickets button CTA">Buy Tickets</a>
	</div>

	<div class="container-md">
		<div class="career-highlights row mx-0 mb-4">
			<h2 class="col-12 text-center mb-2">Career Highlights</h2>

			<div class="col-12 col-sm-4">
				<img class="w-100" src="/images/dance/hardwell.png" alt="">
			</div>

			<div class="col-12 col-sm-8 d-flex align-items-center">
				<p class="fs-5"><?= $artist->getAbout() ?></p>
			</div>
		</div>

		<div class="most-known-for row mx-0 mb-4">
			<h2 class="col-12 text-center mb-2">Most Known For</h2>

			<div class="col-12 col-md-7 d-flex align-items-center">
				<p class="fs-5"><?= $artist->getKnownFor() ?></p>
			</div>

			<div class="col-12 col-md-5">
				<div class="d-flex flex-column gy-5 gap-3">
					<div class="row mx-0 align-items-center">
						<iframe style="border-radius:12px"
							src="https://open.spotify.com/embed/track/<?= $artist->getSong1Link() ?>?utm_source=generator&theme=0"
							width="100%" height="152" frameBorder="0" allowfullscreen=""
							allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
							loading="lazy"></iframe>
					</div>

					<div class="row mx-0 align-items-center">
						<iframe style="border-radius:12px"
							src="https://open.spotify.com/embed/track/<?= $artist->getSong2Link() ?>?utm_source=generator&theme=0"
							width="100%" height="152" frameBorder="0" allowfullscreen=""
							allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
							loading="lazy"></iframe>
					</div>

					<div class="row mx-0 align-items-center">
						<iframe style="border-radius:12px"
							src="https://open.spotify.com/embed/track/<?= $artist->getSong3Link() ?>?utm_source=generator&theme=0"
							width="100%" height="152" frameBorder="0" allowfullscreen=""
							allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
							loading="lazy"></iframe>
					</div>
				</div>
			</div>
		</div>

		<div class="schedule mb-4 overflow-x-auto">
			<h2 class="col-12 text-center mb-2">Schedule</h2>

			<div class="schedule-items pink-to-blue-rotated p-2">
				<div class="row mx-0 mb-2">
					<div class="col-1 px-2"><strong>Day</strong></div>
					<div class="col py-0 px-2 time-header text-center">14:00 uur</div>
					<div class="col py-0 px-2 time-header text-center">19:00 uur</div>
					<div class="col py-0 px-2 time-header text-center">21:00 uur</div>
					<div class="col py-0 px-2 time-header text-center">22:00 uur</div>
					<div class="col py-0 px-2 time-header text-center">23:00 uur</div>
				</div>

				<?php
				$days = ["Friday", "Saturday", "Sunday"];
				foreach ($days as $day): ?>
					<div class="events-container row mx-0 mb-3">
						<div class="col-1 px-2"><strong><?= $day ?></strong></div>
						<?php
						foreach (["14:00", "19:00", "21:00", "22:00", "23:00"] as $time):
							$event = array_filter($events, fn($e) => date('l', strtotime($e->getDate())) === $day && date("H:i", strtotime($e->getTime())) === $time);
							/** @var \Models\Event $event */

							echo '<div class="col py-0 px-2">';

							if (!empty($event)) {
								$event = reset($event);
								echo '<div class="event-box p-2 text-center">' . $event->getLocation() . '</div>';
							}

							echo '</div>';
						endforeach;

						echo '</div>';
				endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</main>