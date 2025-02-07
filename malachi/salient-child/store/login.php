<?php /*Template Name: Login */ ?>

<?php if(is_user_logged_in()) {  wp_redirect(home_url('dashboard/')); exit; } ?>

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

                                <a href="<?= home_url() ?>" class="brand-logo">

                                    <!-- <img class="stnd skip-lazy default-logo dark-version" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">                                 -->

                                    <img class="dark-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">

                                    <img class="light-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-001.png') ?>"> 

                                </a>



                                <h4 class="card-title mb-1">Welcome to Portal! 👋</h4>

                                <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>



                                <form class="auth-login-form mt-2 login">

                                    <div class="mb-1">

                                        <label for="login-email" class="form-label">Email</label>

                                        <input type="email" class="form-control" id="login-email" name="user_email" placeholder="Email" aria-describedby="login-email" tabindex="1" autofocus />

                                    </div>



                                    <div class="mb-1">

                                        <div class="d-flex justify-content-between">

                                            <label class="form-label" for="login-password">Password</label>

                                            <a href="<?= home_url('forget-password') ?>">

                                                <small>Forgot Password?</small>

                                            </a>

                                        </div>

                                        <div class="input-group input-group-merge form-password-toggle">

                                            <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />

                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>

                                        </div>

                                    </div>

                                    <div class="mb-1">

                                        <div class="form-check">

                                            <input class="form-check-input" type="checkbox" id="remember-me" name="remember" tabindex="3" />

                                            <label class="form-check-label" for="remember-me"> Remember Me </label>

                                        </div>

                                    </div>

                                    <input type="hidden" value="login_user" name="action">

                                    <button type="submit" class="btn btn-primary w-100" tabindex="4">Sign in</button>

                                </form>



                                <p class="text-center mt-2">

                                    <span>New on our platform?</span>

                                    <a href="<?= home_url('register') ?>">

                                        <span>Create an account</span>

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

        })



        //if(jQuery('html').hasClass('dark-layout')){

          //  jQuery('html').removeClass('dark-layout');

        //}



        $(".login").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = new FormData(this);

            // console.log('form', form);

            $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');

            $(this).find('button[type=submit]').prop('disabled', true);

            var thiss = $(this);

            $('body').waitMe({

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

                    //  console.log(response);

                    if (!response.status) {

                        Swal.fire({

                            title: response.title,

                            text: response.message,

                            icon: response.icon,

                        }).then((willDelete) => {

                                if (response.redirect_url) {window.location.href = response.redirect_url;}

                                }); 





                    } else{

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

                    $(thiss).find('button[type=submit]').prop('disabled', false);

                    $('body').waitMe('hide');

                }

            });

        });

    </script>

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



</body>

<!-- END: Body-->



</html>