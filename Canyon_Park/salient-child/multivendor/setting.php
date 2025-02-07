<?php /*Template Name: Profile Settings */ ?>
<?php
$user = wp_get_current_user();
$user_meta = get_user_meta( $user->ID );
$first_name = get_user_meta( $user->ID, 'first_name', true );
$last_name = get_user_meta( $user->ID, 'last_name', true );
$address = get_user_meta( $user->ID, 'address', true );
$about = get_user_meta( $user->ID, 'about', true );
$phone_number = get_user_meta( $user->ID, 'ph_num', true );
$profile_pic = get_user_meta( $user->ID, 'profile_pic', true );

?>

<?php include "includes/styles.php"; ?>

<!-- END: Head-->
<?php include "includes/header.php"; ?>
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-wizard.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
<!-- BEGIN: Body-->
<style>
	.toast-container .toast-message, .toast-close-button {
    color: #fff !important;
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
                                        <i data-feather='box'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Change Password</span>
                                        <span class="bs-stepper-subtitle">Change Your Account Password</span>
                                    </span>
                                </button>
                            </div>
                           
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
                                            <input type="text" name="phone_num" value="<?= $phone_number ?>" id="ph_num" class="form-control account-number-mask" placeholder="Phone Number" />
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

    <script>
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
    </script>
    
</body>
<!-- END: Body-->

</html>