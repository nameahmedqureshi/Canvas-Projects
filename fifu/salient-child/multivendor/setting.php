<?php /*Template Name: Profile Settings */ ?>


<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>
<style>         

    .switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
    margin-left: 10px;
    margin-right: 10px;
    }
    .toggle_plan_div {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
    }

    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 19px;
    width: 20px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
    div#card-element {
        padding: 20px;
        box-shadow: 0px 0px 5px 0px #80808087;
    }
    .sub {
        display: flex;
    }
    .sub label.radio {
        margin-bottom: 30px;
        width: 100%;
        height: 100%;
        padding: 20px;
    }

    .sub h4 {margin-bottom: 30px;}

    .sub p.price {
        margin-top: 10px;
    }

    .sub .radio.selected h4 {
        color: #fff;
    }

    .sub .radio.selected span {
        color: #fff;
    }
    * {
    margin: 0;
    padding: 0;
    }

    html {
        height: 100%;
    }

    /*Background color*/
    /* #grad1 {
        background-color: : #9C27B0;
        background-image: linear-gradient(120deg, #FF4081, #81D4FA);
    } */

    /*form styles*/
    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px;
    }

    #msform fieldset .form-card {
        background: white;
        border: 0 none;
        border-radius: 0px;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        padding: 20px 40px 30px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 20px 3%;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    /*Hide all except first fieldset*/
    #msform fieldset:not(:first-of-type) {
        display: none;
    }

    #msform fieldset .form-card {
        text-align: left;
        color: #9E9E9E;
    }

    #msform input, #msform textarea {
        padding: 0px 8px 4px 8px;
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        font-size: 16px;
        letter-spacing: 1px;
    }

    #msform input:focus, #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid #764020;
        outline-width: 0;
    }

    /*Blue Buttons*/
    #msform .action-button {
        width: 100px;
        background: #764020;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button:hover, #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #764020;
    }

    /*Previous Buttons*/
    #msform .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button-previous:hover, #msform .action-button-previous:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
    }

    /*Dropdown List Exp Date*/
    select.list-dt {
        border: none;
        outline: 0;
        border-bottom: 1px solid #ccc;
        padding: 2px 5px 3px 5px;
        margin: 2px;
    }

    select.list-dt:focus {
        border-bottom: 2px solid #764020;
    }

    /*The background card*/
    .card {
        z-index: 0;
        border: none;
        border-radius: 0.5rem;
        position: relative;
    }

    /*FieldSet headings*/
    .fs-title {
        font-size: 25px;
        color: #2C3E50;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left;
    }

    /*progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
        display: flex;
        justify-content: center;
    }

    #progressbar .active {
        color: #000000;
    }

    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        width: 25%;
        float: left;
        position: relative;
    }

    /*Icons in the ProgressBar*/
    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f023";
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f007";
    }

    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f09d";
    }

    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f00c";
    }

    /*ProgressBar before any progress*/
    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px;
    }

    /*ProgressBar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1;
    }

    /*Color number of the step and the connector before it*/
    #progressbar li.active:before, #progressbar li.active:after {
        background: #764020;
    }

    /*Imaged Radio Buttons*/
    .radio-group {
        position: relative;
        margin-bottom: 25px;
    }
     div#grad1 {
        width: 60%;
    }
     .radio p {
        padding-bottom: 0;
    }
     .radio.selected p {
        color: #fff;
    }

    .radio.selected i {
        color: #fff;
    }
    .radio-group input[type="radio" i] {
        display: none;
    }
    label.radio {
        margin-bottom: 30px;
    }

    .radio {
        display: inline-flex;
        width: 234px;
        height: 104px;
        border-radius: 0;
        background: #ffff;
        box-shadow: 0 1px 7px 2px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        cursor: pointer;
        margin: 8px 16px;
        text-align: center;
        align-items: center;
        justify-content: center;
    }
    .acount_type i {
        font-size: 25px;
    }

    .radio:hover {
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
    }

    .radio.selected {
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
        background: #764020;
    }

    /*Fit image in bootstrap div*/
    .fit-image{
        width: 100%;
        object-fit: cover;
    }
</style>

<!-- END: Head-->
<?php include "includes/header.php"; ?>
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-wizard.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
   
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <?php include "includes/manu.php"; ?>
    <!-- END: Main Menu-->

    <?php
    $user = wp_get_current_user();
    $user_meta = get_user_meta( $user->ID );
    $first_name = get_user_meta( $user->ID, 'first_name', true );
    $last_name = get_user_meta( $user->ID, 'last_name', true );
    $address = get_user_meta( $user->ID, 'store_address', true );
    $about = get_user_meta( $user->ID, 'about', true );
    $phone_number = get_user_meta( $user->ID, 'phone_num', true );
    $profile_pic = get_user_meta( $user->ID, 'profile_pic', true );
    $stripe_details = get_user_meta($user->ID, 'stripe_details', true);
    $bank_details =  get_user_meta($user->ID, 'bank_details', true);
    $store_details = get_user_meta($user->ID,'store_details', true);
    $membership_status = get_user_meta($user->ID, 'membership_status', true);
    $test_credentials = get_field( 'test_credentials' , 'option');
    $publishable_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_private_key' , 'option') : get_field( 'live_stripe_private_key' , 'option');

    ?>

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <section class="modern-vertical-wizard">
                    <?php  if( $membership_status != 'canceled'){  ?> 
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
                                        <i data-feather='box'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Change Password</span>
                                        <span class="bs-stepper-subtitle">Change Your Account Password</span>
                                    </span>
                                </button>
                            </div>

                            <?php if( !in_array('administrator', wp_get_current_user()->roles) && !in_array('restaurant', wp_get_current_user()->roles) ){ ?>
                            <div class="step" data-target="#contact-support" role="tab" id="contact-support-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='more-vertical'></i>
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
                                        <i data-feather='more-vertical'></i>
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
                                        <i data-feather='more-vertical'></i>
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
                                        <div class="mb-1 col-md-12">
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
                            <div id="contact-support" class="content" role="tabpanel" aria-labelledby="contact-support-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">Support</h5>
                                    <small class="text-muted">Enter Your Query Here.</small>
                                </div>
                                <form class="profile_edit">
                                    <div class="row">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="query">Query</label>
                                            <textarea class="form-control" name="query" id="query" rows="6"></textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <input type="hidden" name="action" value="send_query">
                                        <button class="btn btn-primary btn-next" type="submit">
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
                                            <label class="form-label" for="account_name">Bank Account Name</label>
                                            <input type="text" name="account_name" value="<?=  !empty($bank_details['account_name']) ? $bank_details['account_name'] : '' ?>" id="account_name" class="form-control" placeholder="Bank Account Name" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="account_number">Bank Account Number</label>
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
                                        <div class="d-flex mt-75">
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
                                            <label class="form-label" for="store_number">Store Phone Number *</label>
                                            <input type="text" name="store_number" value="<?= !empty($store_details['store_number']) ? $store_details['store_number'] : '' ?>" id="store_number" class="form-control" placeholder="Store Phone Number" />
                                        </div>
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="store_address">Store Address *</label>
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
                                <?php 
                                // $subscription = $userClass->check_subscription_status_from_stripe($user->ID);
                                //  $subscription = \Stripe\Subscription::retrieve($stripe_subscription_id);
                                //  var_dump($subscription);
                                if( $membership_status == 'active' || $membership_status == 'trialing'){ ?>
                                    <div class="content-header">
                                        <h5 class="mb-0">Current plan</h5>
                                    </div>
                                    <div class="row">
                                        <div class="card-body my-2 py-25">
                                            
                                            <div class="col-md-6">
                                                <div class="mb-2 pb-50">
                                                    <h5>Your Current Plan is <strong><?= $user_meta['subscription_plan'][0].'-'.$user_meta['user_type'][0] ?></strong></h5>
                                                </div>
                                                
                                                <div class="mb-1">
                                                    <h5>Plan Type: <?= $user_meta['plan_mode'][0] ?></h5>
                                                </div>
                                                <?php if( $membership_status == 'trialing'){ ?>
                                                <div class="mb-1">
                                                    <h5>Trail End: <?= $user_meta['membership_trail_end'][0] ?></h5>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            
                                            <div class="col-12">
                                                <button id="cancel_subscription" user-id="<?= $user->ID ?>" data-id="<?= $user_meta['stripe_subscription_id'][0] ?>" type="button"class="btn btn-outline-danger cancel_subscription mt-1 waves-effect">Cancel Subscription</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- Renew subscrition -->
                     <?php
                        if(in_array( 'supplier', $user->roles) ){
      
                            $basic_plan = get_option('supplier_basic_plan', true);
                            $advanced_plan = get_option('supplier_advanced_plan', true );
                            $premium_plan = get_option('supplier_premium_plan', true);
                        }
                        elseif(in_array( 'restaurant', $user->roles) ){
                           
                            $basic_plan = get_option('restaurant_basic_plan', true);
                            $advanced_plan = get_option('restaurant_advanced_plan', true);
                            $premium_plan = get_option('restaurant_premium_plan', true);
                        } 
                        else {
                         
                            $basic_plan = get_option('basic_plan', true);
                            $advanced_plan = get_option('advanced_plan', true);
                            $premium_plan = get_option('premium_plan', true);
                        }
                    ?>
                    <?php  if( $membership_status == 'canceled'){  ?> 
                    <form id="msform">
                        <fieldset>
                            <div class="form-card">
                                <h2 class="fs-title">Subscription</h2>
                                <div class="toggle_plan_div">
                                    <h6 class="ms-50 mb-0">Monthly</h6>
                                    <label class="switch">
                                        <input type="checkbox" name="plan_switcher" class="plan_switcher">
                                        <span class="slider round"></span>
                                    </label>
                                    <h6 class="ms-50 mb-0">Annually</h6>
                                </div>
                                <div id="plans">
                                    <!-- monthly plans -->
                                    <div class="radio-group sub monthly_plans">
                                        <input  type="radio" id="standard" name="subcription_plan" value="standard" checked>
                                        <label class="radio selected"  for="standard">
                                            <div class="acount_type">
                                                <h4><?= $basic_plan['plan_title'] ?></h4>
                                                <p><?= $basic_plan['short_desc'] ?></p>
                                                <p class="price">annum/monthly: £<span><?= $basic_plan['monthly_price']   ?></span></p>
                                            </div>
                                        </label>
                                        <input  type="radio" id="advanced" name="subcription_plan" value="advanced">
                                        <label class="radio"  for="advanced">
                                            <div class="acount_type">
                                                <h4><?= $advanced_plan['plan_title'] ?></h4>
                                                <p><?= $advanced_plan['short_desc'] ?></p>
                                                <p class="price">annum/monthly: £<span><?= $advanced_plan['monthly_price']  ?></span></p>
                                            </div>
                                        </label>
                                        <input  type="radio" id="premium" name="subcription_plan" value="premium">
                                        <label class="radio"  for="premium">
                                            <div class="acount_type">
                                                <h4><?= $premium_plan['plan_title']  ?></h4>
                                                <p><?= $premium_plan['short_desc'] ?></p>
                                                <p class="price">annum/monthly: £<span><?= $premium_plan['monthly_price']  ?></span></p>
                                            </div>
                                        </label>
                                        <br>
                                    </div>
                                    <!-- monthly plans -->

                                    <!-- Yearly plan -->
                                    <div class="radio-group sub annually_plans" style="display:none">
                                        <input  type="radio" id="yearly_standard" name="subcription_plan" value="standard" checked>
                                        <label class="radio selected"  for="yearly_standard">
                                            <div class="acount_type">
                                                <h4><?= $basic_plan['plan_title'] ?></h4>
                                                <p><?= $basic_plan['short_desc'] ?></p>
                                                <p class="price">annum/yearly: £<span><?= $basic_plan['annual_price']   ?></span></p>
                                            </div>
                                        </label>
                                        <input  type="radio" id="yearly_advanced" name="subcription_plan" value="advanced">
                                        <label class="radio"  for="yearly_advanced">
                                            <div class="acount_type">
                                                <h4><?= $advanced_plan['plan_title'] ?></h4>
                                                <p><?= $advanced_plan['short_desc'] ?></p>
                                                <p class="price">annum/yearly: £<span><?= $advanced_plan['annual_price']  ?></span></p>
                                            </div>
                                        </label>
                                        <input  type="radio" id="yearly_premium" name="subcription_plan" value="premium">
                                        <label class="radio"  for="yearly_premium">
                                            <div class="acount_type">
                                                <h4><?= $premium_plan['plan_title']  ?></h4>
                                                <p><?= $premium_plan['short_desc'] ?></p>
                                                <p class="price">annum/yearly: £<span><?= $premium_plan['annual_price']  ?></span></p>
                                            </div>
                                        </label>
                                        <br>
                                    </div>
                                    <!-- Yearly plan -->
                                </div> 
                                <div id="card-element"></div> 
                            </div>
                        </fieldset>
                        <input type="hidden" name="action" value="renew_subscription">
                        <button type="submit" class="action-button">Subscribe</button>
                    </form>
                    <?php } ?>
                    <!-- Renew subscrition -->
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

        var membershipstatus = "<?= $membership_status ?>";
        if(membershipstatus == 'canceled'){
            // stripe 
            var pub_key = "<?= $publishable_key ?>";
            var stripe = Stripe(pub_key);
            var elements = stripe.elements();
            var cardElement = elements.create('card', {
                hidePostalCode: true,
            });
            cardElement.mount('#card-element');
        }
       

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

        jQuery(document).on('click', '.radio-group .radio', function(){
            jQuery(this).parent().find('.radio').removeClass('selected');
            jQuery(this).addClass('selected');
        });

        jQuery(document).on('change', '.plan_switcher', function(){
            if(jQuery(this).is(':checked')) {
                jQuery('.annually_plans').show();
                jQuery('.monthly_plans').hide();
            }
            else {
                jQuery('.annually_plans').hide();
                jQuery('.monthly_plans').show();

            }
        });

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
                bg: 'rgba(255,255,255,0.8)',
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
            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Handle error
                    Swal.fire({
                        title: "Error",
                        text:  result.error.message,
                        icon: "error",
                    })
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
                }
            }); 
        }); 

        $(document).on("click", "#cancel_subscription", function(e) {
            if (confirm("Are you sure?")) {
                var stripe_subscription_id = $(this).attr('data-id');
                var user_id = $(this).attr('user-id');
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
                    url: "<?= admin_url('admin-ajax.php') ?>",
                    data: {
                        action: 'cancel_membership',
                        stripe_subscription_id: stripe_subscription_id,
                        user_id: user_id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        jQuery('body').waitMe('hide');
                        // console.log(response);
                        if (!response.status) {
                            toastr.error(response.message, response.title);
                        }else {
                            // toastr.success(response.message, response.title);
                            if(response.auto_redirect){
                                window.location.href = response.redirect_url;
                            }
                        }
                     
                    },
                    error: function(errorThrown) {
                        console.log(errorThrown);
                        jQuery('body').waitMe('hide');
                    }
                });
            }
            return false;
        });
    </script>
    
</body>
<!-- END: Body-->

</html>