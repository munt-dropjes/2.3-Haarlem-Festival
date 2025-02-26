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
    document.getElementById('accountBar').classList.toggle('active');
}