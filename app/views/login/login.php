<!DOCTYPE html>
<html lang="en">

<body class="d-flex flex-column min-vh-100">

<main>
    <div class="container mt-5 create-account-container">
      <h2 class="text-center">Login</h2>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>
      <form method="POST" id="login-form">

      <div class="mb-3">
            <label for="email" class="form-label">Email:<span class="required">*</span></label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password:<span class="required">*</span></label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <div class="mb-3">
        <button class="g-recaptcha submitbtn btn w-100"
            data-sitekey="6LfcK-IqAAAAABEgGDE2OeMJVkk3GhJariYfb9qY"
            data-callback='onSubmitLogin'
            data-action='submit' 
            type="submit" 
            class="">Login</button>
        </div>
        <div class="row">
          <div class="mb-3 col-6">
            <a href="/createaccount" class="submitbtn btn w-100">Create Account</a>
          </div>
          <div class="mb-3 col-6">
            <a href="/forgotpassword" class="submitbtn btn w-100">Forgot Password</a>
          </div>
        </div>
      </form>
    </div>
  </main>
    
</body>
</html>