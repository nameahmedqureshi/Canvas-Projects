<?php /* Template Name: Email Verify */ ?>

<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/authentication.css">
<!-- END: Page CSS-->

<!-- END: Head-->

<style>
    button.btn.btn-primary.w-100.waves-effect.waves-float.waves-light {
        margin-top: 10px;
    }
    .default-logo{
        height: 100px !important;
        text-indent: -9999px;
        max-width: none;
        width: auto;
    }
    
    .auth-wrapper.auth-basic .auth-inner {
        max-width: 600px !important;
    }
</style>

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
                        <!-- two steps verification basic-->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="<?= home_url() ?>" class="brand-logo">
                                    <img class="stnd skip-lazy default-logo dark-version" alt="Kainamo" src="<?= home_url()?>/wp-content/uploads/2024/10/FF-01-001-2048x1328.png">                                

                                </a>

                                <h2 class="card-title fw-bolder mb-1">Email Verification 💬</h2>
                                <p class="card-text mb-75">
                                    We sent a verification code to your email address. Enter the code from the email in the field below.
                                </p>


                                <form class="mt-2 basic_actions">
                                    <h6>Type your 6 digit verification code</h6>
                                    <div class="auth-input-wrapper d-flex align-items-center justify-content-between">
                                        <input type="number" name="verification_code" placeholder="Verification Code" class="form-control height-30 text-center" maxlength="6" autofocus="" />
                                   
                                    </div>
                                    <input type="hidden" name="action" value="verify_email">
                                    <button type="submit" class="btn btn-primary w-100" tabindex="4">Verify</button>
                                    <button type="button" class="btn btn-primary w-100 resend_code" tabindex="4">Resend Code</button>
                                </form>

                                <!-- <p class="text-center mt-2">
                                    <span>Didn’t get the code?</span><a href="Javascript:void(0)"><span>&nbsp;Resend</span></a>
                                    <span>or</span>
                                    <a href="Javascript:void(0)"><span>&nbsp;Call Us</span></a>
                                </p> -->
                            </div>
                        </div>
                        <!-- /two steps verification basic -->
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
    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/auth-two-steps.js"></script>
    <!-- END: Page JS-->
    <script>

        
        if(jQuery('html').hasClass('dark-layout')){
            jQuery('html').removeClass('dark-layout');
        }

        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });

        function getCookie(name) {
            let cookieValue = null;
            if (document.cookie && document.cookie !== '') {
                const cookies = document.cookie.split(';');
                for (let i = 0; i < cookies.length; i++) {
                    const cookie = cookies[i].trim();
                    if (cookie.substring(0, name.length + 1) === (name + '=')) {
                        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                        break;
                    }
                }
            }
            return cookieValue;
        }

        $(".resend_code").click(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var verific_user_id = getCookie('verific_user_id');
            if(verific_user_id == ''){
                alert("User not found");
                return false;
            }
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
                data: {
                    action: 'resend_email_verific_code',
                    verific_user_id: verific_user_id
                },
                dataType: 'json',
              
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
</body>
<!-- END: Body-->

</html>