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
                                    <form class="form form-vertical edit_user">

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


                                            <div class="col-12">
                                               
                                                <input type="hidden" value="<?= $_GET['id'] ?>" name="user_id">
                                                <input type="hidden" value="update_user_profile" name="action">
                                            
                                                <button type="submit" class="btn btn-primary me-1"> Update</button>
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
        //update user
        $(".edit_user").submit(function(e) {
            e.preventDefault();
            var form = new FormData(this);
            var thiss = jQuery(this);
            jQuery('body').waitMe({
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
            jQuery.ajax({
                type: 'post',
                url: "<?= admin_url('admin-ajax.php') ?>",
                data: form,
                dataType: 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function(response) {
                    jQuery('body').waitMe('hide');
                    if (!response.status) {
                        toastr.error(response.message, response.title);
                    }                   
                    
                    else {
                        toastr.success(response.message, response.title);
                    }
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                    jQuery('body').waitMe('hide');
                }
            });
           
        });
    </script>

</body>
<!-- END: Body-->

</html>
<?php } else { wp_redirect(home_url('/'));
} ?>