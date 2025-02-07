<?php /*Template Name: Forget Password */ ?>
<?php if(is_user_logged_in()) {  wp_redirect(home_url('dashboard/')); exit; } ?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-validation.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/authentication.css">

<!-- END: Page CSS-->
    <style>        
        .auth-wrapper.auth-basic .auth-inner {
            max-width: 600px !important;
        }
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
    </style>
<!-- END: Head-->



<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">

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
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        <!-- Forgot Password basic -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="index.html" class="brand-logo">
                                    <!-- <img class="stnd skip-lazy default-logo dark-version" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">                                 -->
                                    <img class="dark-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">
                                    <img class="light-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-001.png') ?>"> 
                                </a>

                                <h4 class="card-title mb-1">Forgot Password? 🔒</h4>
                                <p class="card-text mb-2">Enter your email and we'll send you instructions to reset your password</p>

                                <form class="auth-forgot-password-form mt-2 basic_actions">
                                    <div class="mb-1">
                                        <label for="forgot-password-email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="forgot-password-email" name="recovery_email" placeholder="john@example.com" aria-describedby="forgot-password-email" tabindex="1" autofocus />
                                    </div>
                                    <input type="hidden" value="forgot_password" name="action">

                                    <button type="submit" class="btn btn-primary w-100" tabindex="2">Send reset link</button>
                                </form>

                                <p class="text-center mt-2">
                                    <a href="<?=  home_url('login') ?>"> <i data-feather="chevron-left"></i> Back to login </a>
                                </p>
                            </div>
                        </div>
                        <!-- /Forgot Password basic -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>



    <?php include "includes/scripts.php"; ?>

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/auth-forgot-password.js"></script> <!-- END: Page JS-->

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
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });
        
        // if(jQuery('html').hasClass('dark-layout')){
        //     jQuery('html').removeClass('dark-layout');
        // }
    </script>
</body>
<!-- END: Body-->

</html>