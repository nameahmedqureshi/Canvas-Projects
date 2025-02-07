<?php /* Template Name: Add New User */ ?>
<?php
if (isset($_GET['id'])) {
    $user =  get_user_by('id', $_GET['id']);
    $f_name = get_user_meta($user->ID, 'first_name', true);
    $l_name = get_user_meta($user->ID, 'last_name', true);
    $user_email = $user->user_email;

    //  var_dump($user->roles[0]);
    $user_meta = get_user_meta( $user->ID );
    $number = get_user_meta($user->ID, 'number', true);
    $type = get_user_meta($user->ID, 'type', true);
//     $birthday = get_user_meta($user->ID, 'birthday', true);
	$classification = get_user_meta($user->ID, 'classification', true);
    $panther_id = get_user_meta($user->ID, 'panther_id', true);
    $college = get_user_meta($user->ID, 'college', true);
}
// var_dump($user->roles[0]);
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
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
                                    <form class="form form-vertical basic_actions" enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="col-md-3  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">First Name</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $f_name  ?>" name="first_name" placeholder="First Name" />

                                                </div>

                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">Last Name</label>
                                                    <input type="text" id="l-name" class="form-control" value="<?= $l_name  ?>" name="last_name" placeholder="Last Name" />

                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <div class="mb-1">
                                                    <label for="login-email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="<?= isset($_GET['id']) ? $user_email : '' ?>" id="login-email" name="email" placeholder="john@example.com" />
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title">College/Unit </label>
                                                    <input type="text" id="college" class="form-control" value="<?= $college  ?>" name="college" placeholder="College/Unit" />

                                                </div>
                                            </div>

                                            <div class="col-md-3 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="status">Type</label>
                                                    <select name="type" id="type" class="form-select" >
                                                        <option value="student" <?php if ($type == 'student') echo 'selected'; ?>>Student</option>
                                                        <option value="faculty" <?php if ($type == 'faculty') echo 'selected'; ?>>Faculty</option>
                                                        <option value="admin"   <?php if ($type == 'admin') echo 'selected'; ?>>Admin</option>
                                                        <option value="vendor" <?php if ($type == 'vendor') echo 'selected';  ?>>Vendors</option>
                                                        <option value="other" <?php if ($type == 'other') echo 'selected'; ?>>Other</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <div class="mb-1">
                                                    <label for="login-email" class="form-label">Phone Number</label>
                                                    <input type="tel" class="form-control" name="number" class="input" placeholder="Phone Number" value="<?= $number ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <div class="mb-1">
                                                    <label for="login-email" class="form-label">Panther id</label>
                                                    <input type="text" class="form-control" name="panther_id" class="input" value="<?= $panther_id ?>">
                                                </div>
                                            </div>
											
											 <div class="col-md-3 mb-1">
                                                <div class="mb-1">
                                                    <label for="login-email" class="form-label">Classification</label>
                                                    <select name="classification" id="classification" class="form-select" <?= $classification ? '' : 'disabled' ?>>
                                                        <option value="freshman" <?php if ($classification == 'freshman') echo 'selected'; ?>>Freshman</option>
                                                        <option value="sophomore" <?php if ($classification == 'sophomore') echo 'selected'; ?>>Sophomore</option>
                                                        <option value="jr"   <?php if ($classification == 'jr') echo 'selected'; ?>>Jr</option>
                                                        <option value="sr" <?php if ($classification == 'sr') echo 'selected';  ?>>Sr</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <?php if (isset($_GET['id'])) { ?>
                                                    <input type="hidden"  name="redirect" value="admin">
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
    <script>
        jQuery('#type').change(function(e) {
    var value = jQuery(this).val();
    jQuery('#classification').prop('disabled', true)
    if (value == 'student') {
        jQuery('#classification').prop('disabled', false)
    }
});
    </script>


</body>
<!-- END: Body-->

</html>