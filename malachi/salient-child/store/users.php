<?php /* Template Name: Registered Users */ ?>

<?php

if(in_array('administrator', wp_get_current_user()->roles)) { 

$registered_roles = array('vendor', 'customer');

$args = array(

    'role__in'    => isset($_GET['type']) && in_array($_GET['type'], $registered_roles) ?  $_GET['type'] : $registered_roles,

    'order'   => 'ASC'

);



$users = get_users($args);

$new_user_url = home_url('user-profile');

?>

<!-- BEGIN: Head-->



<?php include "includes/styles.php"; ?>



<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">

<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">

<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">

<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">

<style>

    td.cancelled {

        color: red !important;

        font-weight: bold;

    }

    td.active {

        color: green !important;

        font-weight: bold;

    }

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

                                    <form class="basic_actions">

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

                                        <th>Name</th>

                                        <th>Email & Username</th>

                                        <th>Account Status </th>

                                        <th>Email Status </th>

                                        <?= $_GET['type'] == 'vendor' ? '<th>Subscription Status </th>' : ''; ?>

                                        <?= $_GET['type'] == 'vendor' ? '<th>Reward Badges </th>' : ''; ?>

                                        <th>Actions </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    foreach ($users as $key => $user) {

                                        $account_status = get_user_meta($user->ID, 'account_status', true);

                                        $email_status = get_user_meta($user->ID, 'email_status', true);

                                        $fast_responses = get_user_meta($user->ID, 'fast_responses', true);

                                        $quick_shipping = get_user_meta($user->ID, 'quick_shipping', true);

                                        $subscription = get_user_meta($user->ID,'subscription_status', true);

                                        $name = get_user_meta($user->ID,'first_name', true);

                                        $user_type = get_user_meta($user->ID,'user_type', true);

                                    ?>



                                        <tr>

                                            <td><?= $user->ID ?></td>

                                            <td><?= $user_type ?></td>

                                            <td><?= !empty($name) ? $name : $user->display_name ?></td>

                                            <td>
                                                    <div class="d-flex justify-content-left align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <span class="emp_name text-truncate fw-bold"><?= $user->user_email ?></span>
                                                            <small class="emp_post text-truncate text-muted"><?= $user->user_login ?></small>
                                                        </div>
                                                    </div>
                                            </td>

                                            <td>

                                                <div class="d-flex flex-column">

                                                    <label class="form-check-label mb-50 user_status" for="account_switch"><?= $account_status ?></label>

                                                    <div class="form-check form-check-primary form-switch">

                                                        <input type="checkbox" class="form-check-input" data-id="<?= $user->ID ?>" id="account_switch" <?= $account_status == 'Active' ? 'checked' : '' ?>>

                                                    </div>

                                                </div>

                                            </td>

                                            <td><?= $email_status ?></td>

                                            <?php if($_GET['type'] == 'vendor') { ?>

                                            <td class="<?= $subscription ?>"><?= !empty($subscription) ? $subscription : 'Not Subscribed' ?></td>

                                           

                                            <td>

                                                <div class="form-check form-check-primary">

                                                    <input type="checkbox" name="quick_shipping" class="form-check-input assign_badges" id="quick_shipping_<?= $user->ID  ?>" name="quick_shipping" data-value="quick_shipping" data-id="<?= $user->ID ?>" <?=  $quick_shipping == 'true' ? 'checked' : '' ?> >

                                                    <label class="form-check-label" for="quick_shipping_<?= $user->ID  ?>">Quick Shipping</label>

                                                </div>

                                                <div class="form-check form-check-primary">

                                                    <input type="checkbox" name="fast_responses" class="form-check-input assign_badges" id="fast_responses_<?= $user->ID  ?>" name="fast_responses"  data-value="fast_responses" data-id="<?= $user->ID ?>" <?=   $fast_responses == 'true'  ? 'checked' : '' ?> >

                                                    <label class="form-check-label" for="fast_responses_<?= $user->ID  ?>">Fast Responses</label>

                                                </div>

                                            </td>

                                            <?php } ?>

                                            <td>

                                                <!-- <a href="#!" class="details" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Details">

                                                    <i data-feather='list'></i>

                                                </a> -->



                                                <a href="<?= home_url('user-profile/?id=' . $user->ID) ?>" class="item_edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit">

                                                    <i data-feather='edit'></i>



                                                </a>



                                                <a href="#!" class="delete_user" data-id="<?= $user->ID ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete">

                                                    <i data-feather='trash-2'></i>

                                                </a>



                                                <a href="#!" class="change_pass" data-id="<?= $user->ID ?>" data-bs-toggle="modal" data-bs-target="#change_password" data-bs-placement="top" title="" data-bs-original-title="Change Password" data-bs-toggle="tooltip">

                                                    <i data-feather='lock'></i>

                                                </a>





                                                <!-- <a href="#!" class="deactivate_account" data-id="<?= $user->ID ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Deactivate Account">

                                                    <i data-feather='pause'></i>

                                                </a> -->

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



        var new_user_url = "<?= $new_user_url ?>";

        var table = $('.datatables-basic').DataTable({



            // order: [[1, 'desc']],

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



                {

                    text: 'Add New User',

                    className: 'add-new btn btn-primary',

                    attr: {

                        // 'data-bs-toggle': 'modal',

                        // 'data-bs-target': '#addservicemodal'

                    },

                    init: function(api, node, config) {

                        $(node).removeClass('btn-secondary');

                    }

                }

            ],

        });



        $(document).on("click", ".add-new", function() {

            $(location).prop('href', new_user_url);

        });



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



        //Assign badges

        $(document).on("change", ".assign_badges", function(e) {

            var user_id = $(this).attr('data-id');

            var reward = $(this).attr('data-value');

            var status = $(this).prop('checked') ? 1 : 0;

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

                    action: 'assign_reward_badges',

                    user: user_id,

                    reward: reward,

                    status: status,

                },

                dataType: 'json',

                success: function(response) {

                    jQuery('body').waitMe('hide');

                    // console.log(response);

                    if (!response.status) {

                        toastr.error(response.message, response.title);

                    } else {

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

<?php } else { wp_redirect(home_url('dashboard/'));

} ?>