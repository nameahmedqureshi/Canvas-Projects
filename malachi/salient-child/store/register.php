<?php /*Template Name: Register */ ?>
<?php //if(is_user_logged_in()) {  wp_redirect(home_url('dashboard/')); exit; } ?>
<html class="loading" lang="en" data-textdirection="ltr">
    <!-- BEGIN: Head-->
    <?php include "includes/styles.php"; ?>
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->
     
    <style>

        /* .default-logo{
            height: 40px !important;
            text-indent: -9999px;
            max-width: none;
            width: auto;
        } */
        .brand-logo img {
            max-width: 140px !important;
            height: 30px;
        }
        img.dark-logo, img.light-logo{
            display: none;
        }
        
        html.light-layout.dark-layout img.dark-logo {
            display: none;
        }
        html.dark-layout img.light-logo, html.light-layout.dark-layout img.light-logo{
            display: block;
        }
        html.light-layout img.dark-logo {
            display: block;
        }

        .auth-wrapper.auth-basic .auth-inner {
            max-width: 600px !important;
        }

        div#card-element {
            padding: 20px;
            background: aliceblue;
            margin-bottom: 10px;
        }

		a:hover {
			color: #084025;
			text-decoration: none;
		}
        form.auth-register-form.mt-2.basic_actions .radio-group {
            display: flex;
            align-items: center;
        }
        form.auth-register-form.mt-2.basic_actions .radio-group label {
            margin-right: 30px;
            padding-left: 10px;
        }
        .dark-layout a:hover {
            color: #7d828e;
        }
        .dark-layout a {
            color: #fefffe;
        }
    </style>
    <!-- END: Head-->

    <body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        <!-- Register basic -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="<?= home_url() ?>" class="brand-logo">
                                    <!-- <img class="stnd skip-lazy default-logo dark-version" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">                                 -->
                                    <img class="dark-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">
                                    <img class="light-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-001.png') ?>"> 
                                </a>

                                <h4 class="card-title mb-1">Adventure starts here 🚀</h4>
                                <p class="card-text mb-2">Make your app management easy and fun!</p>

                                <form class="auth-register-form mt-2 signup">
                                    <div class="mb-1">
                                        <label class="form-label" for="register-username">Name</label>
                                        <input class="form-control" id="register-username" type="text" name="user_name" placeholder="johndoe" aria-describedby="register-username" autofocus="" tabindex="1" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="register-email">Email</label>
                                        <input class="form-control" id="register-email" type="email" name="user_email" placeholder="john@example.com" aria-describedby="register-email" tabindex="2" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="register-password">Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="register-password" type="password" name="password" placeholder="············" aria-describedby="register-password" tabindex="3" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="confirm-password">Confirm Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge validate-equalTo-blur" id="confirm-password" type="password" name="confirm_password" placeholder="············" aria-describedby="reset-password-new" tabindex="3" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>

                                    <div class="extra_fields" style="<?= $_GET['type'] == 'business' ? 'display:block' : 'display:none' ?>">
                                        <div class="mb-1">
                                            <label class="form-label business_name" for="register-bname">Business Name</label>
                                            <input class="form-control" id="register-bname" type="text" name="business_name" placeholder="johndoe" aria-describedby="register-username" autofocus="" tabindex="1" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label business_email" for="register-bemail">Business Email Address</label>
                                            <input class="form-control" id="register-bemail" type="email" name="business_email" placeholder="john@example.com" aria-describedby="register-username" autofocus="" tabindex="1" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label business_num" for="register-bcon">Business Contact No</label>
                                            <input class="form-control" id="register-bcon" type="tel" name="business_num" placeholder="(301) 735-5707" aria-describedby="register-username" autofocus="" tabindex="1" />
                                        </div>
                                      
                                    </div>

                                    <div class="extra_fields" style="<?= $_GET['type'] == 'seller' ? 'display:block' : 'display:none' ?>">
                                        <div class="mb-1">
                                            <label class="form-label business_name" for="register-bname">Shop Name</label>
                                            <input class="form-control" id="register-bname" type="text" name="business_name" placeholder="johndoe" aria-describedby="register-username" autofocus="" tabindex="1" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label business_email" for="register-bemail">Shop Email</label>
                                            <input class="form-control" id="register-bemail" type="email" name="business_email" placeholder="john@example.com" aria-describedby="register-username" autofocus="" tabindex="1" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label business_num" for="register-bcon">Seller Contact No</label>
                                            <input class="form-control" id="register-bcon" type="tel" name="business_num" placeholder="(301) 735-5707" aria-describedby="register-username" autofocus="" tabindex="1" />
                                        </div>
                                      
                                    </div>
                                   
                                    <div class="radio-group">
                                       

                                        <!-- <input type="checkbox" class="user_type form-check-input" id="business" name="user_type" value="business">
                                        <label class="radio selected" for="business">
                                            Sign up as a Business
                                        </label><br>
                                        
                                        <input type="checkbox" class="user_type form-check-input" id="vendor" name="user_type" value="vendor">
                                        <label class="radio" for="vendor">
                                            Sign up as a Seller
                                        </label> -->
                                        <?php if($_GET['type'] == 'seller'){ ?>
                                            <a href="<?= home_url('register?type=business') ?>">Sign up as a Business</a><br>
                                            <a href="<?= home_url('register') ?>">Sign up as a Customer</a>

                                        <?php } elseif($_GET['type'] == 'business') { ?>
                                            <a href="<?= home_url('register?type=seller') ?>">Sign up as a Seller</a><br>
                                            <a href="<?= home_url('register') ?>">Sign up as a Customer</a>

                                        <?php } else { ?>
                                            <a href="<?= home_url('register?type=seller') ?>">Sign up as a Seller</a><br>
                                            <a href="<?= home_url('register?type=business') ?>">Sign up as a Business</a>
                                        <?php } ?>
                                        
                                        <br><br>
                                    </div>

                                    <div class="radio-group subsribe_check" style="display:none">
                                        <input class="form-check-input"  type="checkbox" id="pay" name="subscribe">
                                        <label class="radio selected" for="pay">
                                            Buy Subscription
                                        </label><br><br>
                                    </div>
                                    <?php $subscription_data = get_option('subscription_data', true); ?>
                                    <span id="subscription_tooltip" style="display:none"> <?= $subscription_data['tooltip'] ?></span>
                                    <div id="card-element" style="display:none"></div> <!-- Stripe element -->
                                    
                                    <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="register-privacy-policy" type="checkbox" tabindex="4" />
                                            <label class="form-check-label" for="register-privacy-policy">I agree to<a href="#">&nbsp;privacy policy & terms</a></label>
                                        </div>
                                    </div>
                                    <input type="hidden" value="signup_user" name="action">
                                    <button type="submit" class="btn btn-primary w-100" tabindex="5">Sign up</button>
                                </form>

                                <p class="text-center mt-2"><span>Already have an account?</span><a href="<?= home_url('login') ?>"><span>&nbsp;Sign in instead</span></a></p>



                            </div>
                        </div>
                        <!-- /Register basic -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->


        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <?php include "includes/scripts.php"; ?>
        <?php 
            $test_credentials = get_field( 'test_credentials' , 'option');
            $publishable_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_private_key' , 'option') : get_field( 'live_stripe_private_key' , 'option');
        
        ?>
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/auth-register.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            if (!localStorage.getItem('light-layout-current-skin')) {
                // Default condition if the key does not exist
                const style = document.createElement('style');
                style.textContent = `
                    img.dark-logo {
                        display: block;
                    }
                `;
                document.head.appendChild(style);    
            } 
        </script>
        <script>

            // if(jQuery('html').hasClass('dark-layout')){
            //     jQuery('html').removeClass('dark-layout');
            // }

            var stripe;
            var cardElement;
            $(document).on('change', '#pay', function(e){
                if($(this).is(":checked") ){
                    // stripe 
                    var pub_key = "<?= $publishable_key ?>";
                    stripe = Stripe(pub_key);
                    var elements = stripe.elements();
                    cardElement = elements.create('card', {
                        hidePostalCode: true,
                    });
                    cardElement.mount('#card-element');
                    $('#subscription_tooltip').show();
                    $('#card-element').show();
                } else {
                    $('#subscription_tooltip').hide();
                    $('#card-element').hide();
                    $('#card-element').empty();
                }
            });


            $(document).on('change', '.user_type', function() {
                const $extraFields = $('.extra_fields');
                const $subscribeCheck = $('.subsribe_check');
                const $cardElement = $('#card-element');
                const $tooltip = $('#subscription_tooltip');
                const $userType = $(this);
                $('#pay').prop('checked',false);

                $extraFields.hide();
                $subscribeCheck.hide();
                $cardElement.hide();
                $tooltip.hide();
        
                // Show appropriate fields based on selected user type
                if ($userType.is(':checked')) {
                    $('.user_type').not(this).prop('checked', false); // unchecked if any 
                    $extraFields.show();

                    if ($userType.val() === 'business') {
                        $('.business_name').text('Business Name');
                        $('.business_email').text('Business Email Address');
                        $('.business_num').text('Business Contact No');
                    } else if ($userType.val() === 'vendor') {
                        $('.business_name').text('Seller Name');
                        $('.business_email').text('Seller Email Address');
                        $('.business_num').text('Seller Contact No');
                        $subscribeCheck.show();
                       
                    }
                } 
            });

            $(window).on('load', function() {
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            });

          

            jQuery(".signup").submit(function(e) {
                e.preventDefault();

                var form = new FormData(this);
                jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                jQuery(this).find('button[type=submit]').prop('disabled', true);
                var $form = jQuery(this);

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

                if (jQuery(this).find('input[name=subscribe]:checked').length === 0) {
                    return ajexCall(form, $form);
                }
                stripe.createToken(cardElement).then(function(result) {
                    if (result.error) {
                        Swal.fire({
                            title: "Error",
                            text: result.error.message,
                            icon: "error"
                        });
                        console.log(result.error);
                        $form.find('.fa-spinner').remove();
                        jQuery('body').waitMe('hide');
                        $form.find('button[type=submit]').prop('disabled', false);
                    } else {
            
                        form.append('stripeToken', result.token.id);
                        ajexCall(form, $form);
                    }
                });
            });
    

            function ajexCall(form, $form) {
                jQuery.ajax({
                    type: 'post',
                    url: '<?= admin_url('admin-ajax.php'); ?>',
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $form.find('.fa-spinner').remove();
                        jQuery('body').waitMe('hide');
                        $form.prop('disabled', false);
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
                    error: function(errorThrown) {
                        console.log(errorThrown);
                        $form.find('.fa-spinner').remove();
                        $form.prop('disabled', false);
                        jQuery('body').waitMe('hide');
                    }
                });
            }
        </script>
    </body>
    <!-- END: Body-->

</html>