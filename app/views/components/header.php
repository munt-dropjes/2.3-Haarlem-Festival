<header>
	<nav class="navbar d-flex justify-content-between align-items-center p-3">
		<div class="col-5">
			<button class="nav-button nav-item-icon border-0 rounded-circle p-3" onclick="toggleSidebar()">
				<i class="fa-solid fa-bars fs-2"></i>
			</button>
		</div>

		<a class="col-2 d-flex justify-content-center logo" href="">
			<img src="/assets/logo/logo.svg" alt="">
		</a>

		<div class="col-5 d-flex justify-content-end">
			<div class="d-flex gap-4">
				<a class="nav-button nav-item-icon border-0 rounded-circle p-3" href="#">
					<img src="/assets/icons/wishlist.svg" alt="">
				</a>

				<button class="nav-button nav-item-icon border-0 rounded-circle p-3" onclick="toggleAccountSidebar()">
					<i class="fa-solid fa-user fs-2"></i>
				</button>
			</div>
		</div>
	</nav>

	<div class="sidebar" id="sidebar">
		<a href="/">HOME</a>
		<a href="#">JAZZ</a>
		<a href="#">DANCE</a>
		<a href="#">FUNKY</a>
		<a href="/stroll">STROLL THROUGH HISTORY</a>
		<a href="#">MAGIC TEYLERS</a>
	</div>

	<div id="accountbar" class="accountbar">
		<?php if (isset($_SESSION['user'])): ?>
			<a href="/profile">Profile</a>
			<a href="/logout">Logout</a>
		<?php else: ?>
			<a href="/login">Login</a>
			<a href="/createaccount">Create Account</a>
		<?php endif; ?>
	</div>
</header>