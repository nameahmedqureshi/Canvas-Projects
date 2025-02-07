<?php /*Template Name: Profile Settings */ ?>
<?php
$user = wp_get_current_user();
$user_meta = get_user_meta( $user->ID );
$first_name = get_user_meta( $user->ID, 'first_name', true );
$last_name = get_user_meta( $user->ID, 'last_name', true );
$address = get_user_meta( $user->ID, 'address', true );
$about = get_user_meta( $user->ID, 'about', true );
$phone_number = get_user_meta( $user->ID, 'phone_num', true );
$profile_pic = get_user_meta( $user->ID, 'profile_pic', true );
$stripe_details = get_user_meta($user->ID, 'stripe_details', true);
$bank_details =  get_user_meta($user->ID, 'bank_details', true);
$store_details = get_user_meta($user->ID,'store_details', true);
$subscription = get_user_meta($user->ID,'subscription_status', true);
$subscription_data = get_option('subscription_data', true);
$test_credentials = get_field( 'test_credentials' , 'option');
$publishable_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_private_key' , 'option') : get_field( 'live_stripe_private_key' , 'option');
?>

<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>


<!-- END: Head-->
<?php include "includes/header.php"; ?>
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-wizard.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
<!-- BEGIN: Body-->

<style>

    .inactive_subs_div h6 {
        padding-top: 10px;
    }

    #store-information .avatar-upload {
        position: relative;
        max-width: 1105px;
    }

    #store-information .avatar-upload .avatar-preview {
        width: 850px;
        height: 400px;
        position: relative;
        border-radius: unset;
        border: unset;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    }
    #store-information .avatar-upload .avatar-preview > div {
        width: 850px;
        height: 400px;
        border-radius: unset;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }


    div#card-element {
        padding: 15px;
        margin-bottom: 10px;
        background: aliceblue;
    }
    .active_subs_div {
        text-align: center;
        background: #084025;
        width: 30%;
        color: white;
    }
        
	.bs-stepper .bs-stepper-header .step.crossed .step-trigger .bs-stepper-box {
		color: #084025 !important;
	}
    .dark-layout .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-box {
        color: #babfc7 !important;
    }
    .bs-stepper .bs-stepper-header .step.crossed .step-trigger .bs-stepper-box {
        color: #084025 !important;
    }

    .dark-layout .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-box {
        background-color: #084025 !important;
    }
    .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-box {
        background-color: #084025 !important;
    }
    .dark-layout .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-label .bs-stepper-title {
        color: #b4b7bd !important;
    }
    .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-label .bs-stepper-title{
        color: #6e6b7b !important;

    }
    div#preview {
        display: flex;
        flex-wrap: wrap;
    }

    .img-container {
        width: 25%;
        margin: auto;
        display: table;
        margin-top: 30px;
    }

    button.remove-btn {
        margin: auto;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        /* border-bottom: 4px solid #b02818; */
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
        display: table;
        margin-top: 26px;
    }

    .img-preview {
        margin: auto;
        display: table;
    }

    .img-preview img {
        width: 150px;
        height: 150px;
        object-fit: cover;
    }

    button.sub{
        margin-top: 20px;
    }

    button#addImageButton {
        width: 20%;
        margin-left: 10px;
        color: #fff;
        background: #084025;
        border: none;
        padding: 10px;
        border-radius: 4px;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }
    .file-upload, .multiple  {
     /*             background-color: #ffffff; */
         width: 100%;
         margin: 0 auto;
         padding: 20px 0px 20px 0px;
     }

     .file-upload-btn {
         width: 100%;
         margin: 0;
         color: #fff;
         background: #084025;
         border: none;
         padding: 10px;
         border-radius: 4px;
         /* border-bottom: 4px solid #15824B; */
         transition: all .2s ease;
         outline: none;
         text-transform: uppercase;
         font-weight: 700;
     }

     .file-upload-btn:hover {
         /* background: #1AA059; */
         color: #ffffff;
         transition: all .2s ease;
         cursor: pointer;
     }

     .file-upload-btn:active {
         border: 0;
         transition: all .2s ease;
     }

     .file-upload-content {
         display: none;
         text-align: center;
     }

     .file-upload-input {
         position: absolute;
         margin: 0;
         padding: 0;
         width: 100%;
         height: 100%;
         outline: none;
         opacity: 0;
         cursor: pointer;
     }

     .image-upload-wrap {
         margin-top: 20px;
         border: 4px dashed #577226;
         position: relative;
     }

     input#fileInput, input#stlfileInput {
         display: none;
     }


     .image-title-wrap {
         padding: 0 15px 15px 15px;
         color: #222;
     }

     .drag-text {
         text-align: center;
     }

     .drag-text h3 {
         font-weight: 100;
         text-transform: uppercase;
         color: #15824B;
         padding: 60px 0;
     }

     .file-upload-image {
         max-height: 200px;
         max-width: 200px;
         margin: auto;
         padding: 20px;
     }

     .remove-image {
         width: 120px;
         margin: 0;
         color: #fff;
         background: #cd4535;
         border: none;
         padding: 10px;
         border-radius: 4px;
         border-bottom: 4px solid #b02818;
         transition: all .2s ease;
         outline: none;
         text-transform: uppercase;
         font-weight: 700;
     }

     .remove-image:hover {
         background: #c13b2a;
         color: #ffffff;
         transition: all .2s ease;
         cursor: pointer;
     }

     .remove-image:active {
         border: 0;
         transition: all .2s ease;
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

                            <?php if( in_array('vendor', wp_get_current_user()->roles)){ ?>

                                <div class="step" data-target="#contact-support" role="tab" id="contact-support-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">
                                            <i data-feather='mail'></i>
                                        </span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">Contact Support</span>
                                            <span class="bs-stepper-subtitle">Contact Us</span>
                                        </span>
                                    </button>
                                </div>
                            
                                <div class="step" data-target="#bank-account" role="tab" id="bank-account-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">
                                            <i data-feather='dollar-sign'></i>
                                        </span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">Payout Details</span>
                                            <span class="bs-stepper-subtitle">Payout Details Here</span>
                                        </span>
                                    </button>
                                </div>

                                <div class="step" data-target="#store-information" role="tab" id="store-information-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">
                                            <i data-feather='dribbble'></i>
                                        </span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">Store Information</span>
                                            <span class="bs-stepper-subtitle">Store Information Here</span>
                                        </span>
                                    </button>
                                </div>
                            
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
                                        <div class="mb-1 col-md-12">
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
                                            <input type="text" name="first_name" value="<?= $first_name ?>" id="first_name" class="form-control" placeholder="First Name" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="last_name">Last Name</label>
                                            <input type="text" name="last_name" value="<?= $last_name ?>" id="last_name" class="form-control" placeholder="Last Name" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="accountEmail">Email Address</label>
                                            <input type="email" name="user_email" value="<?= $user->user_email ?>" id="accountEmail" class="form-control" placeholder="Email Address" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="ph_num">Phone Number</label>
                                            <input type="tel" name="phone_num" value="<?= $phone_number ?>" id="ph_num" class="form-control account-number-mask" placeholder="Phone Number" />
                                        </div>
                                        <!-- <div class="mb-1 col-md-6">
                                            <label class="form-label" for="ph_num">Username</label>
                                            <input type="text" name="user_login" value="<?= $user->user_login ?>" id="ph_num" class="form-control account-number-mask" placeholder="Username" disabled/>
                                            <small>Usernames cannot be changed.</small>
                                        </div> -->
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="address">Address</label>
                                            <input type="text" name="address" value="<?= $address ?>" id="address" class="form-control" placeholder="Address" />
                                        </div>
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="about">About</label>
                                            <textarea class="form-control" name="about" id="about" rows="3" placeholder="About"><?= $about ?></textarea>
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

                            <?php if( in_array('vendor', wp_get_current_user()->roles)){ ?>

                                <div id="contact-support" class="content" role="tabpanel" aria-labelledby="contact-support-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Support</h5>
                                        <small class="text-muted">Enter Your Questions Here.</small>
                                    </div>
                                    <form class="profile_edit">
                                        <div class="row">
                                            <div class="mb-1 col-md-12">
                                                <!-- <label class="form-label" for="query">Question</label> -->
                                                <textarea class="form-control" name="query" id="query" rows="6"></textarea>
                                            </div>

                                            <div class="col-12">
                                                <!-- <h2>Upload Images</h2> -->
                                                <div class="multiple">
                                                    <button type="button" id="addImageButton">Add Images</button>
                                                    <div class="drag-drop-box" style="display:block">
                                                        <input type="file" id="fileInput" name="images[]" accept="image/*" multiple>
                                                        <!-- <p class="multipile_desc">Click Button To Add Image</p> -->
                                                    </div>
                                                    <div id="preview"></div>
                                                </div>
                                            </div>





                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <input type="hidden" name="action" value="send_query">
                                            <button class="btn btn-primary sub btn-next" type="submit">
                                                <span class="align-middle d-sm-inline-block d-none">Submit</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div id="bank-account" class="content" role="tabpanel" aria-labelledby="bank-account-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Stripe Details</h5>
                                        <small class="text-muted">Enter your stripe details here.</small>
                                    </div>

                                    <form class="profile_edit">
                                        
                                        <div class="row">
                                            <div class="mb-1 col-md-12">
                                                <label class="form-label" for="secret_key">Stripe Secret Key *</label>
                                                <input type="text" name="secret_key" value="<?= !empty($stripe_details['secret_key']) ? $stripe_details['secret_key'] : '' ?>" id="secret_key" class="form-control" placeholder="Stripe Secret Key" />
                                            </div>
                                            <div class="mb-1 col-md-12">
                                                <label class="form-label" for="publishable_key">Stripe Publishable Key *</label>
                                                <input type="text" name="publishable_key" value="<?= !empty($stripe_details['publishable_key']) ? $stripe_details['publishable_key'] : ''  ?>" id="publishable_key" class="form-control" placeholder="Stripe Publishable Key" />
                                            </div>
                                        </div>
                                        <div class="content-header">
                                            <h5 class="mb-0">Bank Details</h5>
                                            <small class="text-muted">Enter your bank details here.</small>
                                        </div>
                                        <div class="row">
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="account_name">Bank Account Name *</label>
                                                <input type="text" name="account_name" value="<?=  !empty($bank_details['account_name']) ? $bank_details['account_name'] : '' ?>" id="account_name" class="form-control" placeholder="Bank Account Name" />
                                            </div>
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="account_number">Bank Account Number *</label>
                                                <input type="number" name="account_number" value="<?= !empty($bank_details['account_number']) ? $bank_details['account_number'] : '' ?>" id="account_number" class="form-control account-number-mask" placeholder="Bank Account Number" />
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <input type="hidden" name="action" value="payout_information">
                                            <button class="btn btn-primary btn-next" type="submit">
                                                <span class="align-middle d-sm-inline-block d-none">Update</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div id="store-information" class="content" role="tabpanel" aria-labelledby="store-information-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Store Information</h5>
                                        <small class="text-muted">Change your store details here.</small>
                                    </div>

                                    <form class="profile_edit">
                                        <div class="row">
                                            <div class="mb-1 col-md-12">
                                                <div class="avatar-upload">
                                                    <label class="form-label" for="store_banner">Store Banner Image</label>
                                                    <div class="avatar-edit">
                                                        <input type='file' id="store_banner" name="store_pic" accept="image/png, image/jpeg" />
                                                        <label for="store_banner">
                                                            <i data-feather='edit' style="width: 33px; height: 29px;"></i>
                                                        </label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview" style="background-image: url('<?= !empty($store_details['store_pic']) ? wp_get_attachment_url($store_details['store_pic']) : $directory_url.'/assets/images/no-preview.png' ?>')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-1 col-md-4">
                                                <label class="form-label" for="store_name">Store Name *</label>
                                                <input type="text" name="store_name" value="<?= !empty($store_details['store_name']) ?  $store_details['store_name'] : '' ?>" id="store_name" class="form-control" placeholder="Store Name" />
                                            </div>
                                            <div class="mb-1 col-md-4">
                                                <label class="form-label" for="store_email">Store Email Address *</label>
                                                <input type="email" name="store_email" value="<?= !empty($store_details['store_email']) ?  $store_details['store_email'] : '' ?>" id="store_email" class="form-control" placeholder="Store Email Address" />
                                            </div>
                                            <div class="mb-1 col-md-4">
                                                <label class="form-label" for="store_number">Store Phone Number</label>
                                                <input type="tel" name="store_number" value="<?= !empty($store_details['store_number']) ? $store_details['store_number'] : '' ?>" id="store_number" class="form-control" placeholder="Store Phone Number" />
                                            </div>
                                            <div class="mb-1 col-md-12">
                                                <label class="form-label" for="store_address">Store Address</label>
                                                <input type="text" name="store_address" value="<?= !empty($store_details['store_address']) ? $store_details['store_address'] : '' ?>" id="store_address" class="form-control" placeholder="Store Address" />
                                            </div>
                                            <div class="mb-1 col-md-12">
                                                <label class="form-label" for="store_about">Store About</label>
                                                <textarea class="form-control" name="store_about" id="store_about" rows="3" placeholder="Store About"><?= !empty($store_details['store_about']) ?  $store_details['store_about'] : ''?></textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <input type="hidden" name="action" value="update_store_profile">
                                            <button class="btn btn-primary btn-next" type="submit">
                                                <span class="align-middle d-sm-inline-block d-none">Update</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

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
                                                        <h5>$<?= number_format($subscription_data['monthly_price'] , 2) ?> Per Month</h5>
                                                        <span><?= $subscription_data['tooltip'] ?></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12">
                                                    <input type="hidden" name="user_id" value="<?= $user->ID ?>">
                                                    <button id="cancel_subscription" type="button"class="btn btn-outline-danger cancel-subscription mt-1 waves-effect">Cancel Subscription</button>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                    <div class="inactive_subs_div">
                                        <div class="content-header">
                                            <h5 class="mb-0">Get Your Subscription</h5>
                                            <h6><?= $subscription_data['tooltip'] ?></h6>
                                            <h6>Subscription Price: $<?= number_format($subscription_data['monthly_price'] , 2); ?></h6>
                                        </div>

                                        <form class="subscribe_plan">
                                            
                                            <div id="card-element"></div> <!-- Stripe element -->

                                            <div class="d-flex justify-content-between">
                                                <input type="hidden" name="action" value="subscribe_plan">
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

    <script>

        <?php if( in_array('vendor', wp_get_current_user()->roles)){ ?>
        // stripe 
        let subscription_status = "<?= $subscription ?>";
        let pub_key = "<?= $publishable_key ?>";
        let stripe = Stripe(pub_key);
        let elements = stripe.elements();
        cardElement = elements.create('card', {
            hidePostalCode: true,
        });
        subscription_status == 'active' ? '' : cardElement.mount('#card-element');

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
                        $('#preview').html('');
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
                    action: 'cancel_membership'
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

        
        $(document).on('change', '.file-upload-input', function(e) {
            var reader = new FileReader();
            var input = $(this);
            // console.log("input", input[0].files[0]);
            // console.log("files", input[0].files[0].name);

            reader.onload = function(e) {
                $('.image-upload-wrap').hide();

                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();

                //  $('.image-title').html(input[0].files[0].name);
            };
            reader.readAsDataURL(input[0].files[0]);

        });

        $('.image-upload-wrap').bind('dragover', function() {
            $('.image-upload-wrap').addClass('image-dropping');
        });

        $('.image-upload-wrap').bind('dragleave', function() {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    
        // $('#fileInput, #stlfileInput').change(function() {
        $(document).on('change', '#fileInput, #stlfileInput', function(e) {
            // alert(jQuery(e.target).is('#stlfileInput'));
            var files = $(this)[0].files;
            let trigger = jQuery(e.target).is('#stlfileInput') ? 'stlpreview' : 'preview';
            // alert('trigger', trigger);
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (file) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        var preview = '<div class="img-container"><div class="img-preview"><img src="' + event.target.result + '"></div><button type="button" class="remove-btn">Remove</button></div>';
                        $('#'+trigger).append(preview);
                    }

                    reader.readAsDataURL(file);
                }
            }
            if (jQuery(e.target).is('#stlfileInput')) {
                $('.stl-drag-drop-box').hide();
            } else {
                $('.drag-drop-box').hide();
            }

        });

        $('#preview').on('click', '.remove-btn', function() {
            $(this).parent('.img-container').remove();
            $('#fileInput').val(''); // Reset the file input if necessary
            if ($('#preview').html().trim() === '') {
                $('.drag-drop-box').show();
            }
        });

        $('#addImageButton').click(function() {
            $('#fileInput').click();
        });

    </script>
    
</body>
<!-- END: Body-->

</html>