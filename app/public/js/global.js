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

document.addEventListener('DOMContentLoaded', function() {
	const buttons = document.querySelectorAll('.languageSelectionBarButton button');
	
	buttons.forEach(button => {
		button.addEventListener('click', function() {
			buttons.forEach(btn => btn.classList.remove('selected'));
			this.classList.add('selected');
		});
	});
});