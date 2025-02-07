<?php /* Template Name: Edit User */ ?>
<?php
if(in_array('administrator', wp_get_current_user()->roles)) { 
if (isset($_GET['id'])) {
    $user =  get_user_by('id', $_GET['id']);
    $usermeta = get_user_meta($user->ID);
    $user_email = $user->user_email;
    $user_role = $user->roles[0];
}
// var_dump($user->roles[0]);
?>
<!-- BEGIN: Head-->
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
                                    <form class="form form-vertical basic_actions">
                                        <div class="row">
                                            <div class="col-md-6  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">First Name</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $usermeta['first_name'][0]  ?>" name="f_name" placeholder="First Name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">Last Name</label>
                                                    <input type="text" id="l-name" class="form-control" value="<?= $usermeta['last_name'][0] ?>" name="l_name" placeholder="Last Name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <div class="mb-1">
                                                    <label for="login-email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="<?= isset($_GET['id']) ? $user_email : '' ?>" id="login-email" name="user_email" placeholder="john@example.com" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">Phone</label>
                                                    <input type="text" id="l-name" class="form-control" value="<?= $usermeta['ph_num'][0]  ?>" name="ph_num" placeholder="Phone" />
                                                </div>
                                            </div>
                                            
                                           
                                           
                                            <div class="col-12" style="margin-top: 20px;">
                                                <input type="hidden" value="<?= $_GET['type'] ?>" name="type">
                                                <input type="hidden" value="<?= $_GET['id'] ?>" name="user_id">
                                                <input type="hidden" value="update_user_profile" name="action">
                                               
                                                <button type="submit" class="btn btn-primary me-1"><?= isset($_GET['id']) ? 'Update' : 'Submit'  ?></button>
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
<?php } else { wp_redirect(home_url('dashboard/'));
} ?>