<?php /*Template Name: Register */ ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/vendors.min.css">

<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/colors.css">
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/components.css">
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/themes/dark-layout.css">
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/themes/bordered-layout.css">
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/themes/semi-dark-layout.css">
<!-- END: Head-->
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/plugins/forms/form-validation.css">
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/pages/authentication.css">
<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css">

<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/assets/css/style.css">
<style>
    .user_type {
        display: none;
    }

    .radio-group {
        display: flex;
        justify-content: center;
    }

    .acount_type {
        padding: 10px 10px;
        background: #7367f0;
        color: #fff;
    }

    input[type="radio"]:checked+label .acount_type {
        background: #7367f0;
    }

    label.radio {
        text-align: center;
    }

    .acount_type {
        padding: 10px 10px;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0px 19px;
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
        background: #909090;
    }
</style>
<!-- END: Custom CSS-->
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->

    <!-- END: Header-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <!-- Brand logo--><a class="brand-logo" href="index.html">
                            <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                                <defs>
                                    <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                        <stop stop-color="#000000" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                    <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                        <g id="Group" transform="translate(400.000000, 178.000000)">
                                            <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill: currentColor"></path>
                                            <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                            <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                            <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                            <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <h2 class="brand-text text-primary ms-1">Vuexy</h2>
                        </a>
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/images/pages/register-v2.svg" alt="Register V2" /></div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Register-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bold mb-1">Adventure starts here 🚀</h2>
                                <p class="card-text mb-2">Make your app management easy and fun!</p>
                                <form class="auth-register-form mt-2 basic_actions">
                                    <div class="mb-1">
                                        <label class="form-label" for="register-username">Username</label>
                                        <input class="form-control" id="register-username" type="text" name="user_name" placeholder="johndoe" aria-describedby="register-username" autofocus="" tabindex="1" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="register-email">Email</label>
                                        <input class="form-control" id="register-email" type="text" name="user_email" placeholder="john@example.com" aria-describedby="register-email" tabindex="2" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="register-password">Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="register-password" type="password" name="password" placeholder="············" aria-describedby="register-password" tabindex="3" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="radio-group">
                                        <input type="radio" class="user_type" id="customer" name="user_type" value="customer" checked><label class="radio selected" for="customer">
                                            <div class="acount_type"><i data-feather='user'></i></div>
                                            <p>Customer</p>
                                        </label>
                                        <input type="radio" class="user_type" id="seller" name="user_type" value="seller"><label class="radio" for="seller">
                                            <div class="acount_type"><i data-feather='user'></i></div>
                                            <p>Seller</p>
                                        </label>
                                        <input type="radio" class="user_type" id="vendor" name="user_type" value="vendor"><label class="radio" for="vendor">
                                            <div class="acount_type"><i data-feather='user'></i></div>
                                            <p>Vendor</p>
                                        </label>
                                        <br>
                                    </div>
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
                        <!-- /Register-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>



    <?php include "includes/scripts.php"; ?>
    <!-- <script src="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/js/scripts/pages/auth-register.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>


    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>

</body>
<!-- END: Body-->

</html>