<main>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Forgot Password</h3>
					</div>
					<div class="panel-body">
						<form method="POST" action="/forgotpassword">
							<div class="form-group
								<?php if(isset($error)) { echo '<span class="help-block">' . $error . '</span>'; } ?>">
								<?php if(isset($message)) { echo '<span class="help-block">' . $message . '</span>'; } ?>
								<label for="email">Email</label>
								<input type="email" class="form-control" id="email" name="email" required>
							</div>
							<button type="submit" class="btn btn-primary">Send reset token</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>