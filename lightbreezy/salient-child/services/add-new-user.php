<?php /* Template Name: Add New User */ ?>
<?php
if (isset($_GET['id'])) {
    $user =  get_user_by('id', $_GET['id']);
    $f_name = get_user_meta($user->ID, 'first_name', true);
    $l_name = get_user_meta($user->ID, 'last_name', true);
    $number = get_user_meta($user->ID, 'phone', true);
    $profile_pic = get_user_meta( $user->ID, 'profile_pic', true );

    $user_email = $user->user_email;
    $account_status = get_user_meta($user->ID, 'account_status', true);
    if (!in_array('administrator', $user->roles)) {
                   
        if ($account_status == "Not Active") {
           wp_logout(  );
           wp_redirect(home_url('/login-account'));
            exit;
        }
    }

}
// echo "<pre>";
// var_dump($user);
?>

<?php include "includes/styles.php"; ?>

<style>
    .form-control:disabled {
        background-color: #efefef;
    }
</style>

<?php include "includes/header.php"; ?>

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->

    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <?php include "includes/manu.php"; ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">

            <div class="content-body">

                <!-- Basic Vertical form layout section start -->

                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form form-vertical basic_actions" enctype="multipart/form-data">

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

                                            <div class="col-md-4  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">First Name</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $f_name  ?>" name="first_name" placeholder="First Name" />

                                                </div>

                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">Last Name</label>
                                                    <input type="text" id="l-name" class="form-control" value="<?= $l_name  ?>" name="last_name" placeholder="Last Name" />

                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <div class="mb-1">
                                                    <label for="login-email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="<?= isset($_GET['id']) ? $user_email : '' ?>" id="login-email" name="email" placeholder="john@example.com" />
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <div class="mb-1">
                                                    <label for="login-email" class="form-label">Phone NUmber</label>
                                                    <input type="number" class="form-control" value="<?= isset($_GET['id']) ? $number : '' ?>" id="login_number" name="phone" placeholder="Phone Number" />
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <label class="form-label" for="password">New Password</label>

                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input type="password" class="form-control form-control-merge" id="reset-password-new" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-new" tabindex="2" autofocus />
                                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <label class="form-label" for="reset-password-confirm">Confirm Password</label>

                                                <div class="input-group input-group-merge form-password-toggle">

                                                    <input type="password" class="form-control form-control-merge" id="reset-password-confirm" name="password_re" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-confirm" tabindex="3" />
                                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-6  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="website-vertical">Profile image</label>
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' id="imageUpload" name="profile_image" accept="image/png, image/jpeg" />
                                                            <label for="imageUpload">
                                                                <i data-feather='edit' style="width: 33px; height: 29px;"></i>
                                                            </label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="imagePreview" style="background-image: url('<?= get_stylesheet_directory_uri()  ?>/store/assets/images/no-preview.png')">
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>
                                            </div> -->

                                            <div class="col-12">
                                                <?php if (isset($_GET['id'])) { ?>
                                                    <input type="hidden" value="<?= $_GET['id'] ?>" name="user_id">
                                                    <input type="hidden" value="update_user_profile" name="action">
                                                <?php  } else { ?>
                                                    <input type="hidden" value="add_user" name="action">


                                                <?php  } ?>

                                                <button type="submit" class="btn btn-primary me-1"><?= isset($_GET['id']) ? 'Edit' : 'Submit'  ?></button>
                                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Basic Vertical form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>



    <?php include "includes/scripts.php"; ?>


</body>
<!-- END: Body-->

</html>