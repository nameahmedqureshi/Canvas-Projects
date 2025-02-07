<?php /*Template Name: Profile Settings */ ?>
<?php
$user = wp_get_current_user();
$usermeta = get_user_meta( $user->ID );
$profile_pic = get_user_meta( $user->ID, 'profile_pic', true );

$subscription = get_user_meta($user->ID,'membership_status', true);
// $subscription_data = get_option('subscription_data', true);
?>

<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>


<!-- END: Head-->
<?php include "includes/header.php"; ?>
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-wizard.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
 <!-- Include the PayPal JavaScript SDK -->
 <script src="https://www.paypal.com/sdk/js?client-id=AdiwKv4R1Szdgmh5TPtuZ1lucw4_tVzxAJU35CNq5lVVUtbJg0clRT4SK1k4BE49ZksusSKKMx_GZ4kw&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
<!-- BEGIN: Body-->

<style>

    .inactive_subs_div h6 {
        padding-top: 10px;
    }

    div#card-element {
        padding: 15px;
        margin-bottom: 10px;
        background: aliceblue;
    }
    .active_subs_div {
        text-align: center;
        background: #d9be6d ;
        width: 30%;
        color: white;
    }
        
	.bs-stepper .bs-stepper-header .step.crossed .step-trigger .bs-stepper-box {
		color: #d9be6d  !important;
	}
    .dark-layout .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-box {
            color: #babfc7 !important;
        }
        .bs-stepper .bs-stepper-header .step.crossed .step-trigger .bs-stepper-box {
            color: #d9be6d  !important;
        }

        .dark-layout .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-box {
            background-color: #d9be6d  !important;
        }
        .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-box {
            background-color: #d9be6d  !important;
        }
        .dark-layout .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-label .bs-stepper-title {
            color: #b4b7bd !important;
        }
        .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-label .bs-stepper-title{
            color: #6e6b7b !important;

        }
</style>

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
   
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
   <?php include "includes/manu.php"; ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <section class="modern-vertical-wizard">
                    <div class="bs-stepper vertical wizard-modern modern-vertical-wizard-example">
                        <div class="bs-stepper-header">
                            <div class="step" data-target="#account-details-vertical-modern" role="tab" id="account-details-vertical-modern-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='settings'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Edit Profile</span>
                                        <span class="bs-stepper-subtitle">Edit Your Profile</span>
                                    </span>
                                </button>
                            </div>

                            <div class="step" data-target="#change-password" role="tab" id="change-password-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='key'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Change Password</span>
                                        <span class="bs-stepper-subtitle">Change Your Account Password</span>
                                    </span>
                                </button>
                            </div>

                            <?php if( in_array('service_directory', wp_get_current_user()->roles)){ ?>
                            
                                <div class="step" data-target="#subscribe" role="tab" id="subscribe-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">
                                            <i data-feather='credit-card'></i>
                                        </span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">Subscribe</span>
                                            <span class="bs-stepper-subtitle">Manage your subscription</span>
                                        </span>
                                    </button>
                                </div>

                            <?php } ?>
                          
                        </div>
                        
                        <div class="bs-stepper-content">                              
                            <div id="account-details-vertical-modern" class="content" role="tabpanel" aria-labelledby="account-details-vertical-modern-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">Profile Edit</h5>
                                    <small class="text-muted">Change your profile details here.</small>
                                </div>

                                <form class="profile_edit">
                                    <div class="row">
                                        <div class="d-flex mt-75">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' id="imageUpload" name="profile_pic" accept="image/png, image/jpeg" />
                                                    <label for="imageUpload">
                                                        <i data-feather='edit' style="width: 33px; height: 29px;"></i>
                                                    </label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview" style="background-image: url('<?= !empty($profile_pic) ? wp_get_attachment_url($profile_pic) : $directory_url.'/assets/images/no-preview.png' ?>')">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="first_name">First Name</label>
                                            <input type="text" name="first_name" value="<?= $usermeta['first_name'][0] ?>" id="first_name" class="form-control" placeholder="First Name" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="last_name">Last Name</label>
                                            <input type="text" name="last_name" value="<?= $usermeta['last_name'][0]  ?>" id="last_name" class="form-control" placeholder="Last Name" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="accountEmail">Email Address</label>
                                            <input type="email" name="user_email" value="<?= $user->user_email ?>" id="accountEmail" class="form-control" placeholder="Email Address" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="ph_num">Phone Number</label>
                                            <input type="tel" name="phone" value="<?= $usermeta['phone'][0]  ?>" id="ph_num" class="form-control account-number-mask" placeholder="Phone Number" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="ph_num">Phone Number</label>
                                            <input type="text" name="address" value="<?= $usermeta['address'][0]  ?>" id="ph_num" class="form-control" placeholder="Address" />
                                        </div>
                                        
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <input type="hidden" name="action" value="update_profile">
                                        <button class="btn btn-primary btn-next" type="submit">
                                            <span class="align-middle d-sm-inline-block d-none">Update</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div id="change-password" class="content" role="tabpanel" aria-labelledby="change-password-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">Change Account Password</h5>
                                    <small class="text-muted">Change your account password here.</small>
                                </div>
                                <form class="profile_edit">
                                    <div class="row">
                                        <div class="mb-1">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="reset-password-new">Old Password</label>
                                            </div>
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input type="password" class="form-control form-control-merge" id="reset-password-new" name="old_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-new" tabindex="2" autofocus />
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="reset-password-confirm">New Password</label>
                                            </div>
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input type="password" class="form-control form-control-merge" id="reset-password-confirm" name="new_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-confirm" tabindex="3" />
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="d-flex justify-content-between">
                                        <input type="hidden" name="action" value="password_change">
                                        <button class="btn btn-primary btn-next" type="submit">
                                            <span class="align-middle d-sm-inline-block d-none">Change Password</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <?php if( in_array('service_directory', wp_get_current_user()->roles)){ ?>

                                <div id="subscribe" class="content" role="tabpanel" aria-labelledby="subscribe-trigger">
                                    <?php if($subscription == 'active'){ ?>
                                        <div class="content-header">
                                            <h5 class="mb-0">Current plan</h5>
                                        </div>
                                        <div class="row">
                                           
                                            <!-- <div class="card-header border-bottom">
                                                <h4 class="card-title">Current plan</h4>
                                            </div> -->
                                            <div class="card-body my-2 py-25">
                                                
                                                <div class="col-md-6">
                                                    <div class="mb-2 pb-50">
                                                        <h5>Your Current Plan is <strong>All in one</strong></h5>
                                                    </div>
                                                    
                                                    <div class="mb-1">
                                                        <h5>$250.00 Per Year</h5>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12">
                                                    <input type="hidden" name="user_id" value="<?= $user->ID ?>">
                                                    <button id="cancel_subscription" data-id="<?= $user->ID ?>" type="button"class="btn btn-outline-danger cancel-subscription mt-1 waves-effect">Cancel Subscription</button>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                    <div class="inactive_subs_div">
                                        <div class="content-header">
                                            <h5 class="mb-0">Get Your Subscription</h5>
                                            <!-- <h6><?= $subscription_data['tooltip'] ?></h6> -->
                                            <h6>Subscription Price: $250.00</h6>
                                        </div>

                                        <form class="subscribe_plan">
                                            
                                            <div id="card-element"></div> 

                                            <div class="d-flex justify-content-between">
                                                <input type="hidden" name="action" value="renew_subscription">
                                                <button class="btn btn-primary btn-next" type="submit">
                                                    <span class="align-middle d-sm-inline-block d-none">Subscribe</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <?php } ?>

                                </div>

                            <?php } ?>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

   

    <?php include "includes/scripts.php"; ?>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/form-wizard.js"></script>

    <script src="<?= $directory_url ?>/app-assets/js/core/app-menu.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <?php 
        $test_credentials = get_field( 'test_credentials' , 'option');
        $publishable_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_private_key' , 'option') : get_field( 'live_stripe_private_key' , 'option');
        
    ?>
    <script>
       
       var membership_status = "<?= $subscription ?>";
       <?php if(in_array('service_directory', wp_get_current_user()->roles)){ ?>

       if(membership_status != 'active'){
            // stripe 
            var pub_key = "<?= $publishable_key ?>";
            var stripe = Stripe(pub_key);
            var elements = stripe.elements();
            var cardElement = elements.create('card', {
                hidePostalCode: true,
            });
            cardElement.mount('#card-element');
        }
        <?php } ?>

        toastr.options = {
            "closeButton": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "2000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $(".profile_edit").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = new FormData(this);
            // console.log('form', form);
            $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            $(this).find('button[type=submit]').prop('disabled', true);
            var thiss = $(this);
            $('body').waitMe({
                effect: 'bounce',
                text: '',
                bg: 'rgba(255,255,255,0.90)',
                color: '#000',
                maxSize: '',
                waitTime: -1,
                textPos: 'vertical',
                fontSize: '',
                source: '',
            });
            $.ajax({
                type: 'post',
                url: "<?= admin_url('admin-ajax.php')  ?>",
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.fa.fa-spinner.fa-spin').remove();
                    $('body').waitMe('hide');
                    $(thiss).find('button[type=submit]').prop('disabled', false);
                    $('.bs-stepper-header .step').removeClass('crossed, active');
                    $('.bs-stepper-content .content').removeClass('active');
                    var attr_id = thiss.parents('.content').attr('id');
                    $('.bs-stepper-header').find('[data-target="#' + attr_id + '"]').addClass('active');
                    thiss.parents('.content').addClass('active');

                    if (!response.status) {
                            toastr.error(response.message, response.title);
                    } else{
                        toastr.success(response.message, response.title);
                        if(response.password_change){
                            window.location.href = response.redirect_url;
                        }
                        $('#query').val('');
                    } 
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                    $('body').waitMe('hide');
                }
            });
        });

        $(".subscribe_plan").submit(function(e) {
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
            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Handle error
                    toastr.error(result.error.message, "Error");
                 
                    console.log(result.error);
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled',false); 
                    return;
                } else {
                    // Attach the token or source to the form data
                    form.append('stripeToken', result.token.id);
                    jQuery.ajax({
                        type: 'post',
                        url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                        data: form, // Use FormData directly
                        dataType : 'json',
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('.fa.fa-spinner.fa-spin').remove();
                            $('body').waitMe('hide');
                            $(thiss).find('button[type=submit]').prop('disabled', false);
                            $('.bs-stepper-header .step').removeClass('crossed, active');
                            $('.bs-stepper-content .content').removeClass('active');
                            var attr_id = thiss.parents('.content').attr('id');
                            $('.bs-stepper-header').find('[data-target="#' + attr_id + '"]').addClass('active');
                            thiss.parents('.content').addClass('active');
                            //  console.log(response);
                            if (!response.status) {
                                toastr.error(response.message, response.title);
                                
                            } else{
                                toastr.success(response.message, response.title);
                                if (response.redirect_url) {window.location.href = response.redirect_url;}                

                            } 
                        },
                        error : function(errorThrown){ 
                            jQuery('body').waitMe('hide');
                            console.log(errorThrown);
                        }
                    });
                }
            }); 
        }); 

        $(document).on("click", "#cancel_subscription", function(e){
            e.preventDefault(); 
            // alert();    
            user_id = jQuery(this).data('id');
            // console.log('form', form);
            jQuery(this).find('button[type=button]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            jQuery(this).find('button[type=button]').prop('disabled',true);
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
                data: {
                    action: 'cancel_membership',
                    user_id : user_id
                },
                dataType : 'json',
                success: function(response) {
                    $('.fa.fa-spinner.fa-spin').remove();
                    $('body').waitMe('hide');
                    $(thiss).find('button[type=submit]').prop('disabled', false);
                    $('.bs-stepper-header .step').removeClass('crossed, active');
                    $('.bs-stepper-content .content').removeClass('active');
                    var attr_id = thiss.parents('.content').attr('id');
                    $('.bs-stepper-header').find('[data-target="#' + attr_id + '"]').addClass('active');
                    thiss.parents('.content').addClass('active');
                    //  console.log(response);
                    if (!response.status) {
                        toastr.error(response.message, response.title);
                        
                    } else{
                        toastr.success(response.message, response.title);    
                        if (response.redirect_url) {window.location.href = response.redirect_url;}                
                    } 
                },
                error : function(errorThrown){ 
                    jQuery('body').waitMe('hide');
                    console.log(errorThrown);
                }
            });
        });

    </script>
    
</body>
<!-- END: Body-->

</html>