<?php if(is_user_logged_in() ) {
    echo '<script>
    window.location.href = "' . home_url('main-dashboard') . '";
    </script>';
} ?>

<div class="container_login">
    <img src="<?= home_url() ?>/wp-content/uploads/2024/05/Logo.png" alt="Heather Logo">
    <h1>Welcome to Portal! 👋</h1>
    <p>Please sign-in to your account and start the adventure</p>
    <form id="login_form">
        <div class="input-group">
            <label for="email">Email Address</label>
            <input type="text" id="email" name="user_email" placeholder="Enter Email Address" required>
        </div>
        <div class="input-group">
            <i toggle="#password-field" class="fa-solid fa-eye toggle_password"></i>
            <label for="password">Password</label>
            <input type="password" id="password-field" name="password" placeholder="********">
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="remember-me" name="remember">
            <label for="remember-me">Remember Me</label>
        </div>
        <button type="submit" class="btn">Sign in</button>
        <div class="container-links">
            <a href="<?= home_url('forget-password/')?>" class="forgot-password">Forgot Password?</a>
            <a href="<?= home_url('register/')?>" class="create-account">New on our platform? Create an account</a>
        </div>
       
    </form>
</div>
<style>
    .toggle_password {
        top: 38px !important;
        float: right;
        margin-right: 3%;
        color: black;
    }

    .container-links {
        display: flex;
        column-gap: 10%;
        padding: 10px 5px;
    }

    label {
        display: flex;
    }
    button.btn {
        cursor: pointer;
        border: 1px solid #ffffff !important;
        background-color: #000000 !important;
        color: #ffffff !important;
        padding: 0.786rem 1.5rem;
        font-size: 1rem;
        border-radius: 0.358rem;
        line-height: 1;
        width: 100% !important;
    }
   
 
    .container_login {
		background-color: #000000;
		/* padding: 20px 380px; */
		/* max-width: 582px; */
		display: table;
		margin: auto;
		border-radius: 10px;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
		text-align: center;
	}
    .container_login img {
        width: 100px;
    }
    .container_login h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    .container_login p {
        font-size: 14px;
        margin-bottom: 20px;
    }
    .input-group {
        margin-bottom: 20px;
    }
    .input-group input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: none;
        border-radius: 5px;
        background-color: #ffff;
    }
    .input-group input:focus {
        outline: none;
        box-shadow: 0 0 5px #4CAF50;
    }
    .btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn:hover {
        background-color: #45a049;
    }
    .checkbox-group {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .checkbox-group input {
        margin-right: 10px;
    }
    .forgot-password, .create-account {
        display: block;
        color: #ffffff;
        text-decoration: none;
        margin-bottom: 10px;
    }
    .forgot-password:hover, .create-account:hover {
        text-decoration: underline;
    }
</style>
<script>
         jQuery("#login_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
          //  alert("works");
            var form = jQuery(this).serialize();
            console.log('form', form);
            jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            jQuery(this).find('button[type=submit]').prop('disabled',true);
            var thiss = jQuery(this);
            // jQuery('body').waitMe({
            //     effect : 'bounce',
            //     text : '',
            //     bg : 'rgba(255,255,255,0.7)',
            //     color : '#000',
            //     maxSize : '',
            //     waitTime : -1,
            //     textPos : 'vertical',
            //     fontSize : '',
            //     source : '',
            // });
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: {
                    action: 'login_user',
                    form_data: form
                },
                dataType : 'json',
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    // jQuery('body').waitMe('hide');
					jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                    console.log(response);
                    if(!response.status){
						Swal.fire({
							title: response.title,
							text:  response.message,
							icon: response.icon,
							})
					}
                    else{
						if (response.auto_redirect) {window.location.href = response.redirect_url;}
						else{ 
							Swal.fire({
								title: response.title,
								text:  response.message,
								icon: response.icon,
								
							  }).then((willDelete) => {
							  if (response.redirect_url) {window.location.href = response.redirect_url;}
							}); 
						}
					
					} 
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                //    jQuery('body').waitMe('hide');
               }
            });
        }); 
</script>