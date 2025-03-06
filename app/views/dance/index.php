<main id="dance">
	<div class="top-image container-fluid p-0">
		<img src="images/dance/dance-festival.png" class="img-fluid w-100" alt="plaatje kerk haarlem">
	</div>

	<div class="container-lg pt-5">
		<div id="artist">
			<div class="container bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">Artists</p>
			</div>

			<div class="swiper mt-3">
				<div class="swiper-wrapper">
					<?php for ($i = 0; $i <= 10; $i++): ?>
						<a href="hardwell" class="swiper-slide swiper-slide-normal card overflow-hidden">
							<div class="image-container position-relative">
								<img class="card-image-top" src="images/dance/hardwell.png" alt="">
								<i>Hardwell</i>
							</div>
						</a>
					<?php endfor; ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div id="friday" class="mt-5">
			<div class="container bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">Friday</p>
			</div>

			<div class="swiper mt-3">
				<div class="swiper-wrapper">
					<?php for ($i = 0; $i <= 10; $i++): ?>
						<div class="swiper-slide swiper-slide-extended card overflow-hidden">
							<div class="image-container position-relative">
								<img clang="card-img-top" src="images/dance/hardwell.png" alt="">
								<i>hardwell</i>
							</div>

							<div class="card-body pt-0">
								<button class="CTA my-3 py-2 px-5">Buy</button>
								<p class="card-text">Duration: </p>
								<p class="card-text">Tickets avilable: </p>
								<p class="card-text">Price: </p>
							</div>

						</div>
					<?php endfor; ?>
				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div id="saturday" class="mt-5">
			<div class="container bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">Saturday</p>
			</div>

			<div class="swiper mt-3">
				<div class="swiper-wrapper">
					<?php for ($i = 0; $i <= 10; $i++): ?>
						<div class="swiper-slide swiper-slide-extended card overflow-hidden">
							<div class="image-container position-relative">
								<img clang="card-img-top" src="images/dance/hardwell.png" alt="">
								<i>hardwell</i>
							</div>

							<div class="card-body pt-0">
								<button class="CTA my-3 py-2 px-5">Buy</button>
								<p class="card-text">Duration: </p>
								<p class="card-text">Tickets avilable: </p>
								<p class="card-text">Price: </p>
							</div>

						</div>
					<?php endfor; ?>
				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div id="sunday" class="mt-5">
			<div class="container bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">Sunday</p>
			</div>

			<div class="swiper mt-3">
				<div class="swiper-wrapper">
					<?php for ($i = 0; $i <= 10; $i++): ?>
						<div class="swiper-slide swiper-slide-extended card overflow-hidden">
							<div class="image-container position-relative">
								<img clang="card-img-top" src="images/dance/hardwell.png" alt="">
								<i>hardwell</i>
							</div>

							<div class="card-body pt-0">
								<button class="CTA my-3 py-2 px-5">Buy</button>
								<p class="card-text">Duration: </p>
								<p class="card-text">Tickets avilable: </p>
								<p class="card-text">Price: </p>
							</div>

						</div>
					<?php endfor; ?>
				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div id="all-access" class="mt-5">
			<div class="container bg-secondary p-3 text-center rounded-5">
				<p class="m-0 text-white fs-2">All Access Pass</p>
			</div>

			<div class="swiper mt-3">
				<div class="swiper-wrapper">
					<?php for ($i = 0; $i <= 10; $i++): ?>
						<div class="swiper-slide swiper-slide-normal card overflow-hidden">
							<div class="image-container position-relative">
								<img clang="card-img-top" src="images/dance/hardwell.png" alt="">
								<i>hardwell</i>
							</div>
						</div>
					<?php endfor; ?>
				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>

	<script>
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
	</script>

	<style>
		#dance .swiper {
			width: 100%;
			height: 100%;
			user-select: none;
		}

		#dance .swiper-slide-normal {
			height: 150px;
		}

		#dance .swiper-slide-extended {
			height: calc(150px + 50px + 1rem * 2);
			background-color: var(--background-color);
			transition: height 0.5s;
		}

		#dance .swiper-slide-normal img {
			display: block;
			width: 100%;
			height: 100%;
			object-fit: cover;

			/* border-radius: 1rem; */
		}

		#dance .image-container {
			display: block;
			width: 100%;
			height: 150px;
		}

		#dance .image-container img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		#dance .swiper-slide-normal i,
		#dance .swiper-slide-extended i {
			color: #fff;
			background-color: rgba(0, 0, 0, 0.5);
			font-size: 1.5rem;
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;

			display: none;
			justify-content: center;
			align-items: center;

			border-radius: 1rem;
		}

		#dance .swiper-slide:hover i,
		#dance .swiper-slide-extended:hover i {
			display: flex;
		}

		#dance .swiper-slide-extended button {
			width: 100%;
			height: 50px;
		}

		#dance .swiper-slide-extended:hover {
			height: 350px;
		}

		#dance .swiper-pagination {
			position: unset;
		}
	</style>
</main>