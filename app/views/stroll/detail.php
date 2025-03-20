<main>
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php
			$images = glob($serverPath . "/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE);
			foreach ($images as $index => $image) {
				$activeClass = $index === 0 ? 'active' : '';
				echo "<li data-target='#carouselExampleIndicators' data-slide-to='$index' class='$activeClass'></li>";
			}
			?>
		</ol>
		<div class="carousel-inner">
			<?php
			if (count($images) > 0) {
				foreach ($images as $index => $image) {
					$activeClass = $index === 0 ? 'active' : '';
					$imagePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $image);
					echo "
					<div class='carousel-item $activeClass'>
						<img src='$imagePath' class='d-block w-100' alt='Carousel image of $eventName'>
					</div>";
				}
			} else {
				echo "
				<div class='carousel-item active'>
					<div class='d-flex justify-content-center align-items-center bg-light' style='height: 400px;'>
						<p class='text-muted'>No images available for this location</p>
					</div>
				</div>";
			}
			?>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<div class="container" id="details">
		<div class="row" id="strollDetailsRow">
		<h1><?php echo $detail->getStopName(); ?></h1>
			<div class="col" id="strollDetailsCol">
				<?php
				$eventName = $detail->getStopName();
				$encodedEventName = str_replace(' ', '', $eventName);
				?>
				<img src="/images/StrollDetails/<?php echo $encodedEventName; ?>/Map/<?php echo $detail->getMapName();?>" alt="Map of <?php echo $detail->getStopName(); ?> location" class = "Stroll_Detail_Map">
				<p>Address: <?php echo $detail->getAddress(); ?></p>
			</div>
			<div class="col" id ="strollDetaildescription">
				<p><?php echo $detail->getDescription(); ?></p>
			</div>
		</div>
	</div>
</main>


