<?php /*Template Name: Reset Password */ ?>
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
                        <!-- Login basic -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="index.html" class="brand-logo">
                                    <!-- <img class="stnd skip-lazy default-logo dark-version" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">                                 -->
                                    <img class="dark-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">
                                    <img class="light-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-001.png') ?>"> 
                                </a>

                                <h4 class="card-title mb-1">Reset Your Password</h4>
                                <!-- <p class="card-text mb-2">Please sign-in to your account and start the adventure</p> -->

                                <form class="auth-reset-password-form mt-2 basic_actions">
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="verification-code">Verification Code</label>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <input type="number" class="form-control form-control-merge" id="verification-code" name="recovery_code" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="verification-code" tabindex="1" autofocus />
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="reset-password-new">New Password</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="reset-password-new" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-new" tabindex="2" autofocus />
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="reset-password-confirm">Confirm Password</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="reset-password-confirm" name="password_re" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-confirm" tabindex="3" />
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <input type="hidden" value="reset_password_custom" name="action">
                                    <button type="submit" class="btn btn-primary w-100" tabindex="3">Set New Password</button>
                                </form>

                                <p class="text-center mt-2">
                                    <span>New on our platform?</span>
                                    <a href="<?= home_url('login') ?>">
                                        <span>Back to login</span>
                                    </a>
                                </p>


                            </div>
                        </div>
                        <!-- /Login basic -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>



    <?php include "includes/scripts.php"; ?>


    <!-- BEGIN: Page JS-->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/auth-login.js"></script>
    <!-- END: Page JS-->
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });

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

        // if(jQuery('html').hasClass('dark-layout')){
        //     jQuery('html').removeClass('dark-layout');
        // }
    </script>
      
</body>
<!-- END: Body-->

</html>