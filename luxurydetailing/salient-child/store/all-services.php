<?php /* Template Name: All Services */ ?>
<?php

$type = [];
if ($_GET['type'] && !empty($_GET['type'])) {
   $type = [
        [
            'key' => 'service_type',
            'value' => $_GET['type'],  // Replace 'desired_value' with the value you want to filter by
            'compare' => '=',  // Comparison operator, can be '=', '!=', '>', '<', etc.
        ]
    ];
}
$args = array(
    'post_type' => 'services',
    'post_status' => 'any',
    'posts_per_page' => -1,
    'meta_query' => $type
);
$services = new WP_Query($args);
?>
<!-- <!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr"> -->
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <style>
        td.post_status {
            text-transform: capitalize;
        }
        img.file-image {
            height: 30px;
            width: 40px;
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
                            <h4 class="card-title">Services</h4>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Service</th>
                                        <th>Cars Price</th>
                                        <th>Truck Price</th>
                                        <th>Over Sized Price</th>
                                        <th>Single Price</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    
                                    foreach ($services->posts ?? [] as $key => $value) {
                                        $image =  get_the_post_thumbnail_url($value->ID);
                                        $post_categories = wp_get_post_terms($value->ID, 'services-category', array('fields' => 'names'));
										$service_type = get_post_meta($value->ID, 'service_type', true);
                                    ?>

                                        <tr>
                                            <td><?= $value->ID ?></td>
                                            <td><div class="d-flex justify-content-left align-items-center">
                                                    <div class="me-1"><img src="<?=  !empty($image) ? $image : $directory_url.'/assets/images/no-preview.png' ?>" alt="Avatar" width="32" height="32"></div>
                                                    <div class="d-flex flex-column">
                                                        <span class="emp_name text-truncate fw-bold"><?= get_the_title($value->ID) ?></span>
                                                        <small class="emp_post text-truncate text-muted"></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= empty(get_post_meta($value->ID, 'cars_price', true)) ? "-" : "$" . get_post_meta($value->ID, 'cars_price', true) ?></td>
                                            <td><?= empty(get_post_meta($value->ID, 'truck_price', true)) ? "-" : "$" . get_post_meta($value->ID, 'truck_price', true) ?></td>
                                            <td><?= empty(get_post_meta($value->ID, 'over_sized', true)) ? "-" : "$" . get_post_meta($value->ID, 'over_sized', true) ?></td>
                                            <td><?= empty(get_post_meta($value->ID, 'single_price', true)) ? "-" : "$" . get_post_meta($value->ID, 'single_price', true) ?></td>
                                            <td><?=  str_replace('_', ' ',$service_type == "special_service" ? 'Add-Ons' : $service_type)    ?></td>
                                            <td><?=  get_post_meta($value->ID, 'status', true)   ?></td>

                                            <td>
                                                <a href="<?= home_url('add-services?id='.$value->ID) ?>" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit value Detail">
                                                    <i data-feather='edit'></i>
                                                </a>

                                                <a href="#!" class="delete-record" data-id="<?= $value->ID ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete value">
                                                    <i data-feather='trash-2'></i>
                                                </a>
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
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
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
               
            ],
            });
            table.on('draw', function () {
            feather.replace({
                width: 14,
                height: 14
            });
            });

            $(document).on("click", ".delete-record", function(e) {
                if (confirm("Are you sure?")) {
                    var id = $(this).attr('data-id');
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
                            action: 'delete_services',
                            service_id: id,
                        },
                        dataType: 'json',
                        success: function(response) {
                            jQuery('body').waitMe('hide');
                            // console.log(response);
                            toastr.success(response.message, "Success");
                            
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
    </script>
    
</body>
<!-- END: Body-->

<!-- </html> -->