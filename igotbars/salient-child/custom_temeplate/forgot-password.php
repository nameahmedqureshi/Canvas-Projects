<?php /* Template Name: Forgot Password */  ?>
<?php  get_header(); ?>

<section class="main_loging">
    <div class="container main-content">
        <div class="custom_row" id="login">
            <div class="col_5">
                <form class="security_actions">

                    <div class="input-group">
                        <label for="">Email Address</label><br>
                        <input type="email"  name="recovery_email" placeholder="Enter your email here" required>
                    </div><br>

                    <input type="hidden" name="action" value="forgot_password">
                    <button type="submit" id="submit">Continue</button>
                </form>
            </div>
            <div class="col_7">
                <img src="https://devu10.testdevlink.net/Envision/wp-content/uploads/2024/03/Spreadsheets-cuate-1.png">
            </div>
        </div>
    </div>
</section>
<?php  get_footer(); ?>