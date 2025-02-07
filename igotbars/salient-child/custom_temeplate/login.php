<?php /* Template Name: login */ ?>
<?php if(!is_user_logged_in()){ ?>
<?php get_header();  ?>
<section class="main_loging">
    <div class="container main-content">
        <div class="custom_row" id="login">
            <div class="col_5">
                <form class="login_form">
                    <div class="input-group">
                        <label for="email">Username Or Email Address:</label><br>
                        <input type="text" id="email" name="user_email">
                    </div><br>
                    <div class="input-group pass">
                        <label for="password">Password:</label><br>
                        <input type="password" id="password-field" name="password">
                        <span class="input-group-addon"><i toggle="#password-field"  class="fa fa-eye-slash toggle_password" aria-hidden="true"></i></span>
                    </div><br>
                    <div class="input-group Remember_me">
                        <div class="rem_first">
                            <input type="checkbox" id="remember_me" name="remember" value="remember_me">
                            <label for="remember_me">Remember me</label><br>
                        </div>
                        <div class="rem_second">
                            <a href="<?= home_url('forgot-password')  ?>">Reset Password?</a>
                        </div>
                    </div><br>
                    <button type="submit">Log in</button>
                </form>
            </div>
            <div class="col_7">
                <img src="https://devu10.testdevlink.net/Envision/wp-content/uploads/2024/03/Spreadsheets-cuate-1.png">
            </div>
        </div>
    </div>
</section>
<?php get_footer(); } else { 
    wp_redirect(home_url('dashboard'));
 } ?>