<?php 
    /* Template Name: Reset Password */ 
if(is_user_logged_in()) { wp_redirect(home_url('main-dashboard/')); exit; } 

   get_header(); ?>
<div class="container_login">
    <div class="login-box">
        <h2>Reset password</h2>
        <form action="" class="forgot_form">
            <div class="input-box">
                <input type="number"  name="verification_code" placeholder="Verification Code">
            </div>
            <div class="input-box">
                <i toggle="#current-password-field" class="fa-solid fa-eye toggle_password"></i>
                <input type="password" id="current-password-field" name="password" placeholder="New Password">
            </div>
            <div class="input-box">
                <i toggle="#password-field" class="fa-solid fa-eye toggle_password"></i>
                <input type="password" id="password-field" name="password_re" placeholder="Confirm Password">
            </div>
            <input type="hidden" name="action" value="reset_password_custom">
            <button type="submit" id="submit" class="btn">Reset</button>
        </form>
    </div>

   
</div>
<style>
    .toggle_password {
        top: 12px !important;
        position: absolute !important;
        right: 20px;
    }
    .container_login {
        position: relative;
        width: 100%;
        height: 660px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    body[data-button-style*="slightly_rounded"] button[type=submit] {
        width: 100%;
        border-radius: 50px !important;
    }

    .container_login span {
        position: absolute;
        left: 0;
        width: 32px;
        height: 6px;
        background: #965327;
        border-radius: 8px;
        transform-origin: 128px;
        transform: scale(2.2) rotate(calc(var(--i) * (360deg / 50)));
        animation: animateBlink 3s linear infinite;
        animation-delay: calc(var(--i) * (3s / 50));
    }

    @keyframes animateBlink {
        0% {
            background: #55751a;
        }

        25% {
            background: #2c4766;
        }
    }

    .login-box {
        position: absolute;
        width: 400px;
        /* background: red; */
    }

    .login-box form {
        width: 100%;
        padding: 0 50px;
    }
    /*div#ajax-content-wrap {*/
    /*    justify-content: center;*/
    /*    align-items: center;*/
    /*}*/

    h2 {
        font-size: 2em;
        color: #55751a;
        text-align: center;
    }

    .input-box {
        position: relative;
        margin: 25px 0;
    }

    .input-box input {
        width: 100%;
        height: 50px;
        background: transparent;
        border: 2px solid #2c4766;
        outline: none;
        border-radius: 40px;
        font-size: 1em;
        color: #000;
        padding: 0 20px;
        transition: .5s ease;
    }

    .input-box input:focus,
    .input-box input:valid {
        border-color: #55751a;
    }

    .input-box label {
        position: absolute;
        top: 50%;
        left: 20px;
        transform: translateY(-50%);
        font-size: 1em;
        color: #000;
        pointer-events: none;
        transition: .5s ease;
    }

    .input-box input:focus~label,
    .input-box input:valid~label {
        top: 1px;
        font-size: .8em;
        background: #1f293a;
        padding: 0 6px;
        color: #fff;
    }

    .forgot-pass {
        margin: -15px 0 10px;
        text-align: center;
    }

    .forgot-pass a {
        font-size: .75em;
        color: #000;
        text-decoration: none;
    }

    .forgot-pass a:hover {
        text-decoration: underline;
    }

    .btn {
        width: 100%;
        height: 45px;
        background: #55751a;
        border: none;
        outline: none;
        border-radius: 40px;
        cursor: pointer;
        font-size: 1em;
        color: #1f293a;
        font-weight: 600;
    }

    .signup-link {
        margin: 20px 0 10px;
        text-align: center;
    }

    .signup-link a {
        font-size: 1em;
        color: #55751a;
        text-decoration: none;
        font-weight: 600;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }
    p{
    color: #000;
    font-size: .75rem;
    }
</style>
<script>
       	//forgot password
		jQuery(".forgot_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            
			var form = new FormData(this);	
			jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
			jQuery(this).find('button[type=submit]').prop('disabled',true);
			var thiss = jQuery(this);
			jQuery('body').waitMe({
                effect : 'bounce',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: form,
                dataType : 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                   // console.log(response);
				  
				   Swal.fire({
					title: response.title,
					text:  response.message,
					icon: response.icon,
					}).then((willDelete) => {
					if (response.redirect_url) {window.location.href = response.redirect_url;}
					}); 
				},
                error : function(errorThrown){
                   console.log(errorThrown);
                   jQuery('body').waitMe('hide');
               }
            });
        }); 
</script>
<?php  get_footer(); ?>