<?php if(!is_user_logged_in() ) { ?>
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
        padding: 20px 380px;
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="container_login">
    <img src="https://devu11.testdevlink.net/heather/wp-content/uploads/2024/05/Logo.png" alt="Heather Logo">
    <h1>Sign Up Your User Account</h1>
    <p>Register yourself by filling the form</p>
    <form id="msform">
        <div class="input-group">
            <label for="email">Email Address</label>
            <input type="email" name="user_email" placeholder="Email Address *" required/>
        </div>

        <div class="input-group">
            <label for="fname">First Name </label>
            <input type="text" name="fname" placeholder="First Name *" required/>
        </div>

        <div class="input-group">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" placeholder="Last Name *" required/>
        </div>

        <div class="input-group">
            <label for="lname">Contact No</label>
            <input type="tel" name="phno" placeholder="Contact No"/>
        </div>

        <div class="input-group">
            <label for="Password">Password</label>
            <i toggle="#password-field" class="fa-solid fa-eye toggle_password"></i>
            <input type="password" id="password-field" name="password" placeholder="Password" required>
        </div>

        <div class="input-group">
            <label for=" Confirm Password">Confirm Password</label>
            <i toggle="#cpwd-password-field" class="fa-solid fa-eye toggle_password"></i>
            <input type="password" id="cpwd-password-field" name="password_re" placeholder="Confirm Password" required>
        </div>
    
        <input type="hidden" name="action" value="signup_user">
        <button type="submit" class="btn">Register</button>
        <div class="container-links">
            <a href="<?= home_url('login/')?>" class="create-account">Already Account? Login</a>
        </div>
    </form>
</div>
 
<?php get_footer(); ?>
<script>
    jQuery(document).ready(function(){
    
       

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        
        jQuery(".next").click(function(){
            
            current_fs = jQuery(this).parent();
            next_fs = jQuery(this).parent().next();
            
            //Add Class Active
            jQuery("#progressbar li").eq(jQuery("fieldset").index(next_fs)).addClass("active");
            
            //show the next fieldset
            next_fs.show(); 
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;
        
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                }, 
                duration: 600
            });
        });
        
        jQuery(".previous").click(function(){
            
            current_fs = jQuery(this).parent();
            previous_fs = jQuery(this).parent().prev();
            
            //Remove class active
            jQuery("#progressbar li").eq(jQuery("fieldset").index(current_fs)).removeClass("active");
            
            //show the previous fieldset
            previous_fs.show();
        
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;
        
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                }, 
                duration: 600
            });
        });
        

        //signup user
        jQuery("#msform").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = new FormData(this);
            // console.log('form', form);
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
                url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                data: form, // Use FormData directly
                dataType : 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                    if(!response.status){
                    Swal.fire({
                        title: response.title,
                        text:  response.message,
                        icon: response.icon,
                        })
                    }
                    else{
                        Swal.fire({
                            title: response.title,
                            text:  response.message,
                            icon: response.icon,
                            showConfirmButton: false,
                            })
                    if(response.auto_redirect){
                        window.location.href = response.redirect_url;
                    }
                    } 
                },
                error : function(errorThrown){ 
                    jQuery('body').waitMe('hide');
                    console.log(errorThrown);
                }
            });
            
           
        }); 
        
    });
    
</script>
<?php  } else { 
    echo '<script>
    window.location.href = "' . home_url('/') . '";
    </script>';


} ?>