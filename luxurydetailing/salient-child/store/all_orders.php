<?php /* Template Name: service orders */ ?>
<?php

$type = [];
$garage = '';
if ($_GET['garage'] && !empty($_GET['garage'])) {
    $garage = $_GET['garage'];
    $type = [
        [
            'key' => 'garage_location',
            'value' => $_GET['garage'],  // Replace 'desired_value' with the value you want to filter by
            'compare' => '=',  // Comparison operator, can be '=', '!=', '>', '<', etc.
        ]
    ];
}

$args = array(
    'post_type' => 'orders',
    'post_status' => 'any',
    'posts_per_page' => -1,
    'meta_query' => $type
);
$orders = new WP_Query($args);
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

        .form-select {
            padding: 5px;
            font-size: 12px;
            background-image: unset;
        }
        .dark-layout select.form-select:not([multiple='multiple']) {
            background-image: unset;
        }
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
        .earning_log{
        display: flex;
        justify-content: space-between;
        }
    </style>
<!-- END: Head-->
<?php include "includes/header.php"; ?>


<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Main Menu-->
   <?php include "includes/manu.php"; ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                
                <!-- Earnings Card -->
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card earnings-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">

                                <?php 

                                    function orderCount($start_date, $end_date) {
                                        global $type;
                                        $args = array(
                                            'post_type'     => 'orders',
                                            'post_status'   => 'any',
                                            'posts_per_page' => -1,
                                            'meta_query'    => $type,
                                            'date_query'    => [[
                                                'after'     => $start_date,
                                                'before'    => $end_date,
                                                'inclusive' => true,
                                            ],],
                                        );
                                        $orders = new WP_Query($args);
                                        return count($orders->posts);
                                    }
                                   
                                    function get_total_amount_sum_for_post_type_this_day($first_day_of_month, $last_day_of_month) {
                                        global $wpdb;
                                        global $garage;
                                        
                                        if ($garage) {
                                            $query = $wpdb->prepare("
                                            SELECT SUM(CAST(pm1.meta_value AS UNSIGNED)) AS total_amount
                                            FROM {$wpdb->postmeta} pm1
                                            JOIN {$wpdb->posts} p ON pm1.post_id = p.ID
                                            JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id
                                            WHERE pm1.meta_key = 'total_price'
                                            AND pm2.meta_key = 'garage_location'
                                            AND pm2.meta_value = %s
                                            AND p.post_type = %s
                                            AND p.post_status = 'publish'
                                            AND p.post_date >= %s
                                            AND p.post_date <= %s", 
                                            $garage, 'orders', $first_day_of_month, $last_day_of_month);
                                        } else {
                                            $query = $wpdb->prepare("
                                            SELECT SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
                                            FROM {$wpdb->postmeta} pm
                                            JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                                            WHERE pm.meta_key = 'total_price'
                                            AND p.post_type = %s
                                            AND p.post_status = 'publish'
                                            AND p.post_date >= %s
                                            AND p.post_date <= %s
                                        ", 'orders', $first_day_of_month, $last_day_of_month);
                                        }
                                        
                                    
                                        // Execute the query
                                        $total_amount = $wpdb->get_var($query);
                                    
                                        return $total_amount ? $total_amount : 0;
                                    }

                                    function amount_sum_this_day($first_day_of_month) {
                                        global $wpdb;
                                        global $garage;
                                        
                                        if ($garage) {
                                            $query = $wpdb->prepare("
                                            SELECT SUM(CAST(pm1.meta_value AS UNSIGNED)) AS total_amount
                                            FROM {$wpdb->postmeta} pm1
                                            JOIN {$wpdb->posts} p ON pm1.post_id = p.ID
                                            JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id
                                            WHERE pm1.meta_key = 'total_price'
                                            AND pm2.meta_key = 'garage_location'
                                            AND pm2.meta_value = %s
                                            AND p.post_type = %s
                                            AND p.post_status = 'publish'
                                            AND DATE(p.post_date) = %s",
                                            $garage, 'orders', $first_day_of_month,);
                                        } else {
                                            $query = $wpdb->prepare("
                                            SELECT SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
                                            FROM {$wpdb->postmeta} pm
                                            INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                                            WHERE pm.meta_key = 'total_price'
                                            AND p.post_type = %s
                                            AND p.post_status = 'publish'
                                            AND DATE(p.post_date) = %s",
                                            'orders', $first_day_of_month);
                                        }
                                        
                                        // Execute the query
                                        $total_amount = $wpdb->get_var($query);
                                        return $total_amount ? $total_amount : 0;
                                    }

                                    $sumThisDay = amount_sum_this_day( date('Y-m-d'));
                                    $sumLastday = amount_sum_this_day( date('Y-m-d',strtotime('-1 day')) );
                                    
                                    function calculate_percentage_increase_day($last_day, $this_day) {
                                        if ($last_day == 0) {
                                            return $this_day > 0 ? 100 : 0; // Handle division by zero
                                        }
                                    
                                        $increase = (($this_day - $last_day) / $last_day) * 100;
                                    
                                        return round($increase, 2);
                                    }

                                    $sumPersent = calculate_percentage_increase_day($sumLastday, $sumThisDay);
                                ?>
                                    <h4 class="card-title mb-1">Daily Report</h4>
                                    <div class="earning_log">
                                        <div class="this_month">
                                            <div class="font-small-2">Total Earnings</div>
                                            <h5 class="mb-1">$<?= $sumThisDay ?></h5>
                                        </div>
                                        <div class="last_month">
                                            <div class="font-small-2">Total Order</div>
                                            <h5 class="mb-1"><?= orderCount( date('Y-m-d'), date('Y-m-d')) ?></h5>
                                        </div>
                                    </div>
                                    
                                    <p class="card-text text-muted font-small-2">
                                        <span class="fw-bolder"><?= $sumPersent ?>%</span> <span><?= $sumPersent < 0 ? 'less' : 'more' ?>  earnings than last day.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Earnings Card -->
                <!-- Earnings Card -->
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card earnings-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">

                                <?php 
                                
                                    $current_date = date('Y-m-d');
                                    $first_day_of_week = date('Y-m-d', strtotime('monday this week', strtotime($current_date)));
                                    $last_day_of_week = date('Y-m-d', strtotime('sunday this week', strtotime($current_date)));

                                    $first_day_of_last_week = date('Y-m-d', strtotime('monday last week', strtotime($current_date)));
                                    $last_day_of_last_week = date('Y-m-d', strtotime('sunday last week', strtotime($current_date)));

                                    $sumThisWeek = get_total_amount_sum_for_post_type_this_day( $first_day_of_week, $last_day_of_week);
                                    $sumLastWeek = get_total_amount_sum_for_post_type_this_day( $first_day_of_last_week, $last_day_of_last_week);
                                   
                                    $sumPersent = calculate_percentage_increase_day($sumLastWeek, $sumThisWeek);
                                ?>
                                    <h4 class="card-title mb-1">Weekly Report</h4>
                                    <div class="earning_log">
                                        <div class="this_month">
                                            <div class="font-small-2">Total Earnings</div>
                                            <h5 class="mb-1">$<?= $sumThisWeek ?></h5>
                                        </div>
                                        <div class="last_month">
                                            <div class="font-small-2">Total Order</div>
                                            <h5 class="mb-1"><?= orderCount( $first_day_of_week, $last_day_of_week) ?></h5>
                                        </div>
                                    </div>
                                    
                                    <p class="card-text text-muted font-small-2">
                                        <span class="fw-bolder"><?= $sumPersent ?>%</span> <span><?= $sumPersent < 0 ? 'less' : 'more' ?>  earnings than last week.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Earnings Card -->

                <!-- Earnings Card -->
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card earnings-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                <?php 
                              
                                    $sumThisMonth = get_total_amount_sum_for_post_type_this_day( date('Y-m-01',strtotime('first day of this month')), date('Y-m-t',strtotime('last day of this month')));
                                    $sumLastMonth = get_total_amount_sum_for_post_type_this_day( date('Y-m-01',strtotime('first day of last month')), date('Y-m-t',strtotime('last day of last month')));
                                    
                                    $sumPersent = calculate_percentage_increase_day($sumLastMonth, $sumThisMonth);
                                ?>
                                    <h4 class="card-title mb-1">Monthly Report</h4>
                                    <div class="earning_log">
                                        <div class="this_month">
                                            <div class="font-small-2">Total Earnings</div>
                                            <h5 class="mb-1">$<?= $sumThisMonth ?></h5>
                                        </div>
                                        <div class="last_month">
                                            <div class="font-small-2">Total Order</div>
                                            <h5 class="mb-1"><?= orderCount( date('Y-m-01',strtotime('first day of this month')), date('Y-m-t',strtotime('last day of this month')) ) ?></h5>
                                        </div>
                                    </div>
                                    
                                    <p class="card-text text-muted font-small-2">
                                        <span class="fw-bolder"><?= $sumPersent ?>%</span> <span><?= $sumPersent < 0 ? 'less' : 'more' ?>  earnings than last month.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Earnings Card -->

                <!-- Earnings Card -->
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card earnings-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">

                                <?php 
                                
                                    $sumThisYear = get_total_amount_sum_for_post_type_this_day( date('Y-01-01',strtotime('first day of this year')), date('Y-12-31',strtotime('last day of this year')) );
                                    $sumLastYear = get_total_amount_sum_for_post_type_this_day( date('Y-01-01',strtotime('-1 year')), date('Y-12-31',strtotime('-1 year')) );
                                    $sumPersent = calculate_percentage_increase_day($sumLastYear, $sumThisYear);
                                ?>
                                   <h4 class="card-title mb-1">Yearly Report</h4>
                                    <div class="earning_log">
                                        <div class="this_month">
                                            <div class="font-small-2">Total Earnings</div>
                                            <h5 class="mb-1">$<?= $sumThisYear ?></h5>
                                        </div>
                                        <div class="last_month">
                                            <div class="font-small-2">Total Order</div>
                                            <h5 class="mb-1"><?= orderCount( date('Y-01-01',strtotime('first day of this year')), date('Y-12-31',strtotime('last day of this year')) ) ?></h5>

                                        </div>
                                    </div>
                                    
                                    <p class="card-text text-muted font-small-2">
                                        <span class="fw-bolder"><?= $sumPersent ?>%</span> <span><?= $sumPersent < 0 ? 'less' : 'more' ?>  earnings than last year.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Earnings Card -->

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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Service</th>
                                        <th>Garage</th>
                                        <th>License Plate</th>
                                        <th>Service Date</th>
                                        <th>Payment</th>
                                        <!-- <th>User Type</th> -->
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($orders->posts ?? [] as $key => $value) { 

                                        $author_meta = get_user_meta($value->post_author);
                                        $author = get_userdata($value->post_author);
                                        $name = get_post_meta($value->ID, 'first_name', true);
                                        $service_id = get_post_meta($value->ID, 'service_id', true);
                                        $service_name = get_the_title($service_id);
                                        $order_summary = get_post_meta($value->ID, 'order_summary', true);
                                        $order_status = get_post_meta($value->ID, 'order_status', true);
                                        $user_buying_type = get_post_meta($value->ID, 'user_buying_type', true);
                                        $garage = get_post_meta($value->ID, 'garage_location', true);
                                        //var_dump($garage);
                                        // if($garage == 'Gold Garage'){
                                        //     update_post_meta($value->ID, 'garage_location', 'pg1');

                                        // }


                                       
                                        ?>
                                        <tr>
                                            <td><?= $value->ID ?></td>
                                            <td><?= $name ?></td>
                                            <td><?= get_post_meta($value->ID, 'number', true) ?></td>
                                            <td><?= !empty($service_id) ? $service_name : $order_summary[0]["title"];  ?></td>
                                            <td><?= garage_name($garage) ?></td>
                                            <td><?= get_the_title($value->ID) ?></td>
                                            <td><?= date('d M Y', strtotime(get_post_meta($value->ID, 'date', true))) ?></td>
                                            <td>
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <!-- <div class="avatar  me-1"><img src="http://lms-coaching.test/storage/coaching/Ko1jeJntgFWsIJnYbECpMjpBWWVv65FCeBe8h01s.jpg" alt="Avatar" width="32" height="32"></div> -->
                                                    <div class="d-flex flex-column" style="color:<?= $value->post_status == 'draft' ? 'red' : 'green' ?>">
                                                        <span class="emp_name text-truncate fw-bold">$<?= get_post_meta($value->ID, 'total_price', true) ?></span>
                                                        <small class="emp_post text-truncate"><?= $value->post_status == 'draft' ? 'Not Paid' : 'Paid' ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="order_status"><?= $order_status == "Completed" ? $order_status : '<select class="form-select service_status" data_id="'.$value->ID.'" id=""><option disabled selected>Pending</option> <option value="done">Complete</option> </select>'?></td>
                                            <td>
                                                <a href="<?= home_url('view-order?id='.$value->ID) ?>" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit value Detail">
                                                    <i data-feather='eye'></i>
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

            $(document).on("change", ".service_status", function(e) {
                var post_id = jQuery(this).attr("data_id");
                if (confirm("Are you sure?")) {
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
                            action: 'service_status_update', 
                            post_id: post_id, 
                        },
                        dataType: 'json',
                        success: function(response) {
                            jQuery('body').waitMe('hide');
                            // console.log(response);
                            toastr.success(response.message, "Success");
                            thiss.parents('tr').find('.order_status').html(response.order_status);
                            // if (response.status) {
                            //     thiss.parents('tr').fadeOut(1000);
                            // }
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