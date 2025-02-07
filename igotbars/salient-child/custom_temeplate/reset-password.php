<?php /* Template Name: Reset Password*/  ?>
<?php get_header(); ?>

<section class="main_loging">
    <div class="container main-content">
        <div class="custom_row" id="login">
            <div class="col_5">
                <form class="security_actions">

                    <div class="input-group">
                        <label for="">Verification Code:</label><br>
                        <input type="number" name="verification_code" placeholder="Enter verification code">
                    </div><br>

                    <div class="input-group pass">
                        <label for="password">Password:</label><br>
                        <input type="password" id="current-password-field" name="password" placeholder="Enter your new password">
                        <span class="input-group-addon"><i toggle="#current-password-field"  class="fa fa-eye-slash toggle_password" aria-hidden="true"></i></span>
                    </div><br>

                    <div class="input-group pass">
                        <label for="password">Confirm Password:</label><br>
                        <input type="password" id="password-field" name="password_re" placeholder="Enter confirm password">
                        <span class="input-group-addon"><i toggle="#password-field"  class="fa fa-eye-slash toggle_password" aria-hidden="true"></i></span>
                    </div><br>
                    <input type="hidden" name="action" value="reset_password_custom" >
                    <button type="submit">Reset Password</button>
                </form>
            </div>
            <div class="col_7">
                <img src="https://devu10.testdevlink.net/Envision/wp-content/uploads/2024/03/Spreadsheets-cuate-1.png">
            </div>
        </div>
    </div>
</section>

<?php  get_footer(); ?>