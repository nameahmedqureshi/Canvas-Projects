<?php /* Template Name: Registered Users */ ?>
<?php
$registered_roles = array('farmer', 'supplier', 'restaurant');
$args = array(
    'role__in'    => isset($_GET['type']) && in_array($_GET['type'], $registered_roles) ?  $_GET['type'] : $registered_roles,
    'order'   => 'ASC'
);

$users = get_users($args);
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>

<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
<style>
    .dt-buttons button {
        border: 1px solid #82868b !important;
        background-color: transparent;
        color: #82868b;
        padding: 0.386rem 1.2rem;
        font-weight: 500;
        font-size: 1rem;
        border-radius: 0.358rem;
    }

    .dt-buttons button:hover {
        color: #fff;
        background-color: #7367f0;
        border-color: #7367f0;
    }

    button.dt-button.add-new.btn.btn-primary {
        padding: 10px;
    }
</style>
<!-- END: Head-->
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
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="app-user-list">

                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h4 class="card-title">Registered Users</h4>
                        </div>


                        <!--Change Password Modal -->
                        <div class="modal fade text-start" id="change_password" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel33">Change Password</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form class="change_password">
                                        <div class="modal-body">

                                            <label>Password: </label>
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Change</button>
                                        </div>
                                        <input type="hidden" class="user_id" name="user_id" value="">
                                        <input type="hidden" name="action" value="change_password">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Type</th>
                                        <th>Username</th>
                                        <th>Email </th>
                                        <th>Phone</th>
                                        <th>Plan</th>
                                        <th>Subscription</th>
                                        <th>Status </th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($users as $key => $user) {
                                        $account_status = get_user_meta($user->ID, 'account_status', true);
                                        $email_status = get_user_meta($user->ID, 'email_status', true);
                                        $subscription_plan = get_user_meta($user->ID, 'subscription_plan', true);
                                        $membership_status = get_user_meta($user->ID, 'membership_status', true);
                                        $user_type = get_user_meta($user->ID, 'user_type', true);
                                        $ph_num = get_user_meta($user->ID, 'ph_num', true);
                                        $stripe_subscription_id = get_user_meta($user->ID, 'stripe_subscription_id', true);
                                    ?>

                                        <tr>
                                            <td><?= $user->ID ?></td>
                                            <td><?= $user_type == 'vendor' ? 'supplier' : $user_type  ?></td>
                                            <td><?= $user->display_name ?></td>
                                            <td><?= $user->user_email ?></td>
                                            <td><?= !empty($ph_num) ? $ph_num : '----' ?></td>
                                            <td><?= $user_type.'-'.$subscription_plan ?></td>
                                            <td><?= $membership_status ?></td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <label class="form-check-label mb-50 user_status" for="account_switch"><?= $account_status ?></label>
                                                    <div class="form-check form-check-primary form-switch">
                                                        <input type="checkbox" class="form-check-input" data-id="<?= $user->ID ?>" id="account_switch" <?= $account_status == 'Active' ? 'checked' : '' ?>>
                                                    </div>
                                                </div>
                                            </td>
                                           
                                            <td>
                                                <!-- <a href="#!" class="details" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Details">
                                                    <i data-feather='list'></i>
                                                </a> -->

                                                <a href="<?= home_url('edit-user/?id=' . $user->ID) ?>" class="item_edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit">
                                                    <i data-feather='edit'></i>
                                                </a>
                                                <a href="#!" class="delete_user" data-id="<?= $user->ID ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete">
                                                    <i data-feather='trash-2'></i>
                                                </a>

                                                <a href="#!" class="change_pass" data-id="<?= $user->ID ?>" data-bs-toggle="modal" data-bs-target="#change_password" data-bs-placement="top" title="" data-bs-original-title="Change Password">
                                                    <i data-feather='lock'></i>
                                                </a>


                                                <!-- <a href="#!" class="cancel_membership" user-id="<?= $user->ID ?>" data-id="<?= $stripe_subscription_id ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Cancel Membership">
                                                    <i data-feather='pause'></i>
                                                </a>  -->
                                            </td>
                                        </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>



    <?php include "includes/scripts.php"; ?>

    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/components/components-modals.js"></script>


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

        var table = $('.datatables-basic').DataTable({

            order: [[0, 'desc']],
            dom: '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
                '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            // language: {
            //     sLengthMenu: 'Show _MENU_',
            //     search: 'Search',
            //     searchPlaceholder: 'Search..'
            // },
            // Buttons with Dropdown
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',

                // {
                //     text: 'Add New User',
                //     className: 'add-new btn btn-primary',
                //     attr: {
                //         // 'data-bs-toggle': 'modal',
                //         // 'data-bs-target': '#addservicemodal'
                //     },
                //     init: function(api, node, config) {
                //         $(node).removeClass('btn-secondary');
                //     }
                // }
            ],
        });

        // $(document).on("click", ".add-new", function() {
        //     $(location).prop('href', new_user_url);
        // });

        $(document).on("click", ".change_pass", function() {
            var user_id = $(this).attr('data-id');
            $('.user_id').val(user_id);
        });

        table.on('draw', function() {
            feather.replace({
                width: 14,
                height: 14
            });
        });


        //delete user
        $(document).on("click", ".delete_user", function(e) {
            if (confirm("Are you sure?")) {
                var user_id = $(this).attr('data-id');
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
                    data: {
                        action: 'delete_user',
                        user: user_id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        jQuery('body').waitMe('hide');
                        // console.log(response);
                        toastr.success("Success");
                        // Swal.fire({
                        //     icon: response.icon,
                        //     title: response.title,
                        //     text: response.message,
                        // });
                        if (response.status) {
                            thiss.parents('tr').fadeOut(1000);
                        }
                    },
                    error: function(errorThrown) {
                        console.log(errorThrown);
                        jQuery('body').waitMe('hide');
                    }
                });
            }
            return false;
        });

        //cancel membership
        $(document).on("click", ".cancel_membership", function(e) {
            if (confirm("Are you sure?")) {
                var stripe_subscription_id = $(this).attr('data-id');
                var user_id = $(this).attr('user-id');
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
                    data: {
                        action: 'cancel_membership',
                        stripe_subscription_id: stripe_subscription_id,
                        user_id: user_id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        jQuery('body').waitMe('hide');
                        // console.log(response);
                        if (!response.status) {
                            toastr.error(response.message, response.title);
                        }else {
                            toastr.success(response.message, response.title);

                        }
                     
                    },
                    error: function(errorThrown) {
                        console.log(errorThrown);
                        jQuery('body').waitMe('hide');
                    }
                });
            }
            return false;
        });

        // change_password
        $(".change_password").submit(function(e) {
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

      

        //deactivate account
        $(document).on("change", "#account_switch", function(e) {
            var user_id = $(this).attr('data-id');
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
                data: {
                    action: 'deactivate_account',
                    user: user_id,
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('body').waitMe('hide');
                    // console.log(response);
                    toastr.success("Success");
                    // Swal.fire({
                    //     icon: response.icon,
                    //     title: response.title,
                    //     text: response.message,
                    // });
                    if (response.status) {
                        thiss.parents('tr').find('.user_status').text(response.account_status);
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