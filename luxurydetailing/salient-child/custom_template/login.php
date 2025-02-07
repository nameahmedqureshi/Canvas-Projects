<?php
// /* Template Name: new login */
// get_header();

?>

<style>
   
   /* button.guest {
        background-color: #f2e47c;
        text-transform: uppercase !important;
        letter-spacing: 2px;
        font-size: 16px;
        font-weight: 500;
        width: 50%;
    } */


    /* button.registerbtn {
        width: 49%;
    } */



    button.btn {
        width: 59%;
        font-size: 14px !important;
    }


    form.form.login_form .form-check .input-check {
        width: 64%;
        display: flex;
    }

    form.form.login_form .form-check .input-check input#remember-me {
        margin: 0px 10px 0px 0px;
    }
    button.btn.btn-primary.forget_pass {
        width: 39%;
        padding: 13px;
        background: #f2e47c;
        text-decoration: unset;
        border: unset;
        font-size: 17px !important;
        font-weight: 400;
        text-transform: uppercase;
    }
    .auth-reset-password-form button {
        color: #000;
        margin-top: 10px;
    }
    .auth-reset-password-form {
        padding: 60px;
    }
    .auth-forgot-password-form button.btn {
        margin-top: 20px;
        text-align: center;
        width: 100%;
        color: #000;
    }
    .forget_pass {
        cursor: pointer;
        text-decoration: underline;
        font-weight: 600;
    }
    .form-check {
        display: inline-flex;
        padding: 10px;
    }
    .auth-forgot-password-form p.loign.dsec {
        margin-top: 10px;
    }

    .form-check input#remember-me {
        margin-left: 0;
        width: 10% !important;
    }
        .auth-forgot-password-form {
        padding: 60px;
    }

    .form-check label.form-check-label {
        width: 55%;
        text-align: left;
    }
    form.form.login_form .input {
         width: 46% !important;
    }
    select#classification:disabled {
        background: rgb(0 0 0 / 34%);
        opacity: 0.3;
    } 

</style>
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="form-box">
            <i class="fa fa-times close" aria-hidden="true"></i>

            <form class="form register_form basic_actions">
                <span class="title">Sign up</span>
                <span class="subtitle">Create a free account with your email.</span>
                <div class="form-container">
                    <input type="text"  name ="first_name" class="input" placeholder="First Name">
                    <input type="text"  name ="last_name" class="input" placeholder="Last Name">
                    <input type="email" name="email" class="input" placeholder="Primary Email">
                    <input type="tel" name="number" class="input" placeholder="Phone Number">
                    <input type="text" name="college" class="input" placeholder="College/Unit">
                    <select name="type" id="type" class="type">
                        <option value="student" >Student</option>
						<option value="faculty" >Faculty/Staff</option>
                        <option value="admin" >Admin</option>
                        <option value="vendor" >Vendors</option>
                        <option value="other" >Other</option>
                    </select>
                    <div class="input_field panther_id">
                        <!-- <label>Panther ID number</label> -->
                        <input type="text" name="panther_id" placeholder="Panther ID Number" class="input_space" required />
                    </div>
                    <div class="input_field select_option Cassification">
                        <!-- <label>Classification</label> -->
                        <select name="classification" id="classification" class="input_space">
                        <!-- <option disabled >Select Option</option> -->
                        <option value="freshman">Freshman</option>
                        <option value="sophomore">Sophomore</option>
                        <option value="jr">Jr</option>
                        <option value="sr">Sr</option>
                        </select>
                        <div class="select_arrow"></div>
                    </div>
                    <!-- <input type="date" name="birthday" class="input" placeholder="Birthday"> -->
                    <!-- <input type="text" name="birthday" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Birthday" class="input" max="<?= date('Y-m-d'); ?>"> -->
                    <div class="password_div">
                        <i toggle="#password-field1" class="fa-solid fa-eye toggle_password"></i>
                        <input type="password" id="password-field1" name="password" class="input password" placeholder="Password">
                    </div>
                </div>
                <p class="loign dsec">Please Click Here For <span id="login_btn">Login</span></p>
                <input type="hidden" value="signup_user" name="action">
                <!-- <div class="form-container"> -->
                    <button class="registerbtn" type="submit">Register</button>
                    <!-- <button class="guest" type="button" book_type="" service_id="">Guest Checkout</button> -->
                <!-- </div> -->
               
            </form>

            <form class="form login_form basic_actions">
                <span class="title">Login</span>
                <div class="form-container">
                    <input type="text" name="email" class="input" placeholder="Email">
                    <div class="password_div">
                        <i toggle="#password-field2" class="fa-solid fa-eye toggle_password"></i>
                        <input type="password"  id="password-field2" name="password" class="input password" placeholder="Password">
                    </div>
                </div>
                <div class="form-check">
					<div class=input-check>
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" tabindex="3" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
					</div>
                    <p class="forget_pass">Forgot Password?</p>
                </div>
                <p class="loign dsec">If You Need Registration, Please Click Here <span id="register_btn">Register</span></p>
                <input type="hidden" value="login_user" name="action">
                <button type="submit">Login</button>
            </form>

            <form class="auth-forgot-password-form mt-2 basic_actions">
                <div class="mb-1">
                    <label for="forgot-password-email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="forgot-password-email" name="recovery_email" placeholder="john@example.com"  autofocus />
                </div>
                <input type="hidden" value="forgot_password" name="action">
                <p class="loign dsec">If You Need Registeration Please Register Here <span id="register_btn">Register</span></p>

                <button type="submit" class="btn btn-primary rest_link w-100" tabindex="2">Send reset link</button>
            </form>

            <form class="auth-reset-password-form mt-2 basic_actions">
                <div class="mb-1">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="verification-code">Verification Code</label>
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="number" class="form-control form-control-merge" id="verification-code" name="recovery_code" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="verification-code" tabindex="1" autofocus />
                    </div>
                </div>
                <div class="mb-1">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="reset-password-new">New Password</label>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <i toggle="#password-field3" class="fa-solid fa-eye toggle_password"></i>
                        <input type="password" class="form-control form-control-merge" id="password-field3" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-new" tabindex="2" autofocus />
                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    </div>
                </div>
                <div class="mb-1">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="reset-password-confirm">Confirm Password</label>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <i toggle="#password-field4" class="fa-solid fa-eye toggle_password"></i>
                        <input type="password" class="form-control form-control-merge" id="password-field4" name="password_re" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-confirm" tabindex="3" />
                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    </div>
                </div>
                <input type="hidden" value="reset_password_custom" name="action">
                <p class="loign dsec">If You Need Registeration Please Register Here <span id="register_btn">Register</span></p>
                <button type="button" class="btn btn-primary forget_pass w-100" tabindex="3">back</button>
                <button type="submit" class="btn set_password btn-primary w-100" tabindex="3">Set New Password</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

jQuery('#type').change(function(e) {
    var value = jQuery(this).val();
    jQuery('#classification').prop('disabled', true)
    if (value == 'student') {
        jQuery('#classification').prop('disabled', false)
    }
});
    var homeUrl = "<?= home_url('/'); ?>";
    var servicesUrl = "<?= home_url('our-services-2/'); ?>";
    jQuery(".basic_actions").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = new FormData(this);
        // console.log('form', form);
        jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        jQuery(this).find('button[type=submit]').prop('disabled', true);
        var thiss = jQuery(this);
        jQuery('body').waitMe({
            effect: 'bounce',
            text: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            waitTime: -1,
            textPos: 'vertical',
            fontSize: '',
            source: '',
        });
        jQuery.ajax({
            type: 'post',
            url: "<?= admin_url('admin-ajax.php')  ?>",
            data: form,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                jQuery('.fa.fa-spinner.fa-spin').remove();
                jQuery('body').waitMe('hide');
                jQuery(thiss).find('button[type=submit]').prop('disabled', false);
                //  console.log(response);
                if (!response.status) {
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: response.icon,
                    })

                } else{
                    
                    var url = window.location.href == homeUrl ? servicesUrl : response.redirect_url;
                    var url = window.location.href == servicesUrl ? homeUrl : url;
                    
                        if (response.auto_redirect) {window.location.href = url;}
                        else{ 
                            Swal.fire({
                                title: response.title,
                                text:  response.message,
                                icon: response.icon,
                            }).then((willDelete) => {
                            if (url) {window.location.href = url;}
                            }); 
                        }
                    
                } 
            },
            error: function(errorThrown) {
                console.log(errorThrown);
                jQuery('body').waitMe('hide');
            }
        });
    });
</script>
<?php //get_footer(); ?>  