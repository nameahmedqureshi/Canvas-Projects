<?php /* Template Name: Add New User */ ?>
<?php
if(in_array('administrator', wp_get_current_user(  )->roles)) {

if (isset($_GET['id'])) {
    $user =  get_user_by('id', $_GET['id']);
    $f_name = get_user_meta($user->ID, 'first_name', true);
    $l_name = get_user_meta($user->ID, 'last_name', true);
    $ph_num = get_user_meta($user->ID, 'ph_num', true);
    $user_email = $user->user_email;
}
// var_dump($user->roles[0]);
?>
<?php include "includes/styles.php"; ?>

<style>
    .form-control:disabled {
        background-color: #efefef;
    }
	section#basic-vertical-layouts .card-body form.form.form-vertical.basic_actions .col-12 button {
    margin-top: 10px;
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
                                            <div class="col-md-6  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">First Name *</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $f_name  ?>" name="f_name" placeholder="First Name" />

                                                </div>

                                            </div>

                                            <div class="col-md-6 mb-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">Last Name</label>
                                                    <input type="text" id="l-name" class="form-control" value="<?= $l_name  ?>" name="l_name" placeholder="Last Name" />

                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-1">
                                                <div class="mb-1">
                                                    <label for="login-email" class="form-label">Email *</label>
                                                    <input type="email" class="form-control" value="<?= isset($_GET['id']) ? $user_email : '' ?>" id="login-email" name="user_email" placeholder="john@example.com" />
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-1">
                                                <div class="mb-1">
                                                    <label for="ph-num" class="form-label">Phone Number</label>
                                                    <input type="tel" class="form-control" value="<?= isset($_GET['id']) ? $ph_num : '' ?>" id="ph-num" name="ph_num" placeholder="Phone Number" />
                                                </div>
                                            </div>


                                            <?php if(!isset($_GET['id'])){ ?>
                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="password">Password *</label>

                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input type="password" class="form-control form-control-merge" id="reset-password-new" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-new" tabindex="2" autofocus />
                                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="reset-password-confirm">Confirm Password *</label>

                                                <div class="input-group input-group-merge form-password-toggle">

                                                    <input type="password" class="form-control form-control-merge" id="reset-password-confirm" name="password_re" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="reset-password-confirm" tabindex="3" />
                                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                </div>
                                            </div>

                                            <?php } ?>

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
<?php } else { wp_redirect(home_url('/'));
} ?>