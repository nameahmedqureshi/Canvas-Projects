<?php 
    /* Template Name: Forgot Password */ 
 if(is_user_logged_in()) { wp_redirect(home_url('main-dashboard/')); exit; } 
   get_header(); ?>
<div class="container_login">
    <div class="login-box">
        <h2>Reset your password</h2>
        <form action="" class="forgot_form">
            <div class="input-box">
                <input type="email" name="recovery_email"  required>
                <label>Email</label>
            </div>
            <input type="hidden" name="action" value="forgot_password">
            <button type="submit" id="submit" class="btn">Forgot</button>
        </form>
    </div>

    <span style="--i:0;"></span>
    <span style="--i:1;"></span>
    <span style="--i:2;"></span>
    <span style="--i:3;"></span>
    <span style="--i:4;"></span>
    <span style="--i:5;"></span>
    <span style="--i:6;"></span>
    <span style="--i:7;"></span>
    <span style="--i:8;"></span>
    <span style="--i:9;"></span>
    <span style="--i:10;"></span>
    <span style="--i:11;"></span>
    <span style="--i:12;"></span>
    <span style="--i:13;"></span>
    <span style="--i:14;"></span>
    <span style="--i:15;"></span>
    <span style="--i:16;"></span>
    <span style="--i:17;"></span>
    <span style="--i:18;"></span>
    <span style="--i:19;"></span>
    <span style="--i:20;"></span>
    <span style="--i:21;"></span>
    <span style="--i:22;"></span>
    <span style="--i:23;"></span>
    <span style="--i:24;"></span>
    <span style="--i:25;"></span>
    <span style="--i:26;"></span>
    <span style="--i:27;"></span>
    <span style="--i:28;"></span>
    <span style="--i:29;"></span>
    <span style="--i:30;"></span>
    <span style="--i:31;"></span>
    <span style="--i:32;"></span>
    <span style="--i:33;"></span>
    <span style="--i:34;"></span>
    <span style="--i:35;"></span>
    <span style="--i:36;"></span>
    <span style="--i:37;"></span>
    <span style="--i:38;"></span>
    <span style="--i:39;"></span>
    <span style="--i:40;"></span>
    <span style="--i:41;"></span>
    <span style="--i:42;"></span>
    <span style="--i:43;"></span>
    <span style="--i:44;"></span>
    <span style="--i:45;"></span>
    <span style="--i:46;"></span>
    <span style="--i:47;"></span>
    <span style="--i:48;"></span>
    <span style="--i:49;"></span>
</div>
<style>
    .toggle_password {
        top: 12px !important;
        position: absolute !important;
        right: 20px;
    }
    .container_login {
        position: relative;
        width: 256px;
        height: 256px;
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
    div#ajax-content-wrap {
        justify-content: center;
        align-items: center;
    }

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