<?php function login_account(){ ?>
<?php  if(!is_user_logged_in() ){ ?>
<style>
    .select2-container--default .select2-selection--multiple.select2-selection.select2-selection--multiple {
        background: transparent;
        margin-bottom: -20px;
        border: 1px solid #77119f;
        padding: 9px 0px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: transparent;
        border: 1px solid #a62dd5;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: inline;
        list-style: none;
        padding: 0;
        margin-left: 0;
    }

    textarea.select2-search__field::placeholder {
        color: #d6cbdc;
        font-size: 15px;
        line-height:14px;
        font-family: 'Open Sans';
    }
    .toggle_password {
        top: 36px !important;
        float: right;
        margin-right: 3%;
        color: black;
    }

    #create_acc input::Placeholder {font-family: 'Open Sans';font-size: 15px;}
</style>
<section class="register">
    <div class="container">
        <div class="row  wpb_row vc_row-fluid vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="login">
            <form class="service_order login">
                <div class="col span_6">
                    <label for="first_name">Email or Username *</label><br>
                    <input type="text" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="col span_6">
                    <label for="last_name">Password *</label>
                    <i toggle="#password-field" class="fa-solid fa-eye toggle_password"></i>
                    <input type="password" id="password-field" name="password" placeholder="********" required>
                </div>
                <div class="col span_12">
                    <input type="checkbox" id="remember" name="remember" value="remember">
                    <label for="remember">Remember me</label>
                    <a href="<?= home_url('forget-password/') ?>" class="forget_pass">Forgot Password</a>
                </div>
                <div class="col span_12">
                    <p class="account">Don't have an account?<a href="<?= home_url(isset($_GET['redirect']) ? 'create-account/?redirect='.$_GET['redirect'] : "create-account/") ?>" class="forget_pass">Create Account</a></p>
                </div>
                <div class="col span_12">
                        <input type="hidden" value="login_user" name="action">
                    <input class="button" type="submit" value="Login" />
                </div>
            </form>   
        </div>
    </div>
</section>
<script>

        // PASSWORD SHOW HIDE
        jQuery(".toggle_password").click(function() {
            
            jQuery(this).toggleClass("fa-eye fa-eye-slash");
            var input = jQuery(jQuery(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        var redirect_url = "<?= isset($_GET['redirect']) ? $_GET['redirect'] : "" ?>"
        jQuery(".login").submit(function(e) {
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
                        // Swal.fire({
                        //     title: response.title,
                        //     text:  response.message,
                        //     icon: response.icon,
                        // }).then((willDelete) => {
                        if (response.redirect_url) {window.location.href = redirect_url ? redirect_url : response.redirect_url;}
                        // }); 
                    
                    } 
            },
            error: function(errorThrown) {
                console.log(errorThrown);
                jQuery('body').waitMe('hide');
            }
        });
    });
</script>
<?php } else {
wp_redirect(home_url('/'));
} 
} 
add_shortcode('login_account', 'login_account');
?>