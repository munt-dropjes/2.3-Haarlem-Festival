<main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Reset Password</h3>
                    </div>
                    <div class="panel-body">
                        <form action="/resetpassword/<?=$email?>/<?=$resetToken?>" method="post">
                            <input type="hidden" name="resetToken" value="<?php echo $resetToken; ?>">
                            <div class="form-group">
                                <?php if(isset($error)) { echo '<span class="help-block">' . $error . '</span>'; } ?>
                                <?php if(isset($message)) { echo '<span class="help-block">' . $message . '</span>'; } ?>
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                            </div>
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>