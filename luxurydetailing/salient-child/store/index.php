<?php /* Template Name: Dashboard */ 
?>
<!-- <!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr"> -->
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>

<!-- END: Head-->
<?php include "includes/header.php"; ?>
<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/charts/apexcharts.css">
<!-- BEGIN: Body-->

<style>
    .used p.card-text {
        line-height: 14px;
    }
    .not-used{
        pointer-events: none;
    opacity: 0.4;
    }
    .dark-layout body .card-body.statistics-body p {
        color: #b4b7bd;
    }
    body .card-body.statistics-body p {
        color: black;
    }
    .earning_log{
        display: flex;
        justify-content: space-between;
    }
    .apexcharts-toolbar {
        top: -32px !important;
        position: absolute;
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
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row match-height">

                        <!-- Statistics Card -->
                        <div class="col-xl-9 col-md-6 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Service Bookings</h4>
                                    <div class="d-flex align-items-center">
                                        <!-- <p class="card-text font-small-2 me-25 mb-0">Updated 1 month ago</p> -->
                                    </div>
                                </div>
                                <div class="card-body statistics-body">
                                    <div class="row">

                                    <?php 
                                        $pages_with_links = ['PG1', 'PG3'];
                                        $datas['PG1'] = ['bg' => 'primary', 'icon' => 'box', 'name'=>'Gold Garage'];
                                        $datas['PG2'] = ['bg' => 'info', 'icon' => 'box', 'name'=>'PG2'];
                                        $datas['PG3'] = ['bg' => 'danger', 'icon' => 'box', 'name'=>'Panther Garage'];
                                        $datas['PG4'] = ['bg' => 'success', 'icon' => 'box', 'name'=>'PG4'];
                                        $datas['PG5'] = ['bg' => 'warning', 'icon' => 'box', 'name'=>'PG5'];
                                        $datas['PG6'] = ['bg' => 'info', 'icon' => 'box', 'name'=>'PG6'];

                                        foreach ($datas as $key => $value) {
                                            $link = in_array($key, $pages_with_links) ? home_url('all-orders/?garage='.$key) : '#'; 
                                            $class = !in_array($key, $pages_with_links) ? 'not-used' : 'used'; 
                                            $args = array(
                                                'post_type' => 'orders',
                                                'post_status' => 'any',
                                                'posts_per_page' => -1,
                                                'meta_query' => [
                                                    [
                                                        'key' => 'garage_location',
                                                        'value' => $key,  // Replace 'desired_value' with the value you want to filter by
                                                        'compare' => '=',  // Comparison operator, can be '=', '!=', '>', '<', etc.
                                                    ]
                                                ]
                                            );
                                            $orders = new WP_Query($args);

                                            //var_dump(count($orders->posts)); ?>
                                      
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-xl-0 <?= $class ?>">
                                                <a class="d-flex flex-row" href="<?= $link ?>">
                                                    <div class="avatar bg-light-<?= $value['bg'] ?> me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="<?= $value['icon'] ?>" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= count($orders->posts) ?></h4>
                                                        <p class="card-text font-small-3 mb-0"><?= $value['name'] ?> </p>
                                                    </div>
                                                </a>
                                            </div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						
						    <!-- Statistics Card -->
                        <div class="col-xl-3 col-md-6 col-12 ">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Service Bookings</h4>
                                    <div class="d-flex align-items-center">
                                        <!-- <p class="card-text font-small-2 me-25 mb-0">Updated 1 month ago</p> -->
                                    </div>
                                </div>
                                <div class="card-body statistics-body">
                                    <div class="row">

                                    <?php
										$data = [];
										$data['engr-campus-garage'] = ['bg' => 'info', 'icon' => 'box'];

                                        foreach ($data as $key => $value) {
                                          
                                            $args = array(
                                                'post_type' => 'orders',
                                                'post_status' => 'any',
                                                'posts_per_page' => -1,
                                                'meta_query' => [
                                                    [
                                                        'key' => 'garage_location',
                                                        'value' => $key,  // Replace 'desired_value' with the value you want to filter by
                                                        'compare' => '=',  // Comparison operator, can be '=', '!=', '>', '<', etc.
                                                    ]
                                                ]
                                            );
                                            $orders = new WP_Query($args);

                                            //var_dump(count($orders->posts)); ?>
                                      
                                            <div class="col-xl-12 col-sm-12 col-12 mb-2 mb-xl-0 not-used">
                                                <a class="d-flex flex-row" href="#">
                                                    <div class="avatar bg-light-<?= $value['bg'] ?> me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="<?= $value['icon'] ?>" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= count($orders->posts) ?></h4>
                                                        <p class="card-text font-small-3 mb-0"><?= $key ?> </p>
                                                    </div>
                                                </a>
                                            </div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
						
                        <!--/ Statistics Card -->
                    </div>

                    <div class="row match-height">
                        <div class="col-lg-4 col-12">
                            <div class="row match-height">
                                <!-- Bar Chart - Orders -->
                                <div class="col-lg-6 col-md-3 col-6">
                                    <div class="card">
                                        <div class="card-body pb-50">

                                        <?php 
                                            $args = array(
                                                'post_type' => 'orders',
                                                'post_status' => 'any',
                                                'posts_per_page' => -1,
                                            );
                                            $orders = new WP_Query($args);

                                            $count = count($orders->posts); ?>

                                            <h6>Total Orders</h6>
                                            <h2 class="fw-bolder mb-1"><?= $count ?></h2>
                                            <div id="statistics-order-chart"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Bar Chart - Orders -->

                                <!-- Line Chart - Profit -->
                                <div class="col-lg-6 col-md-3 col-6">
                                    <div class="card card-tiny-line-stats">
                                        <div class="card-body pb-50">
                                            <?php 
                                                function get_total_amount_sum_for_post_type($post_type) {
                                                    global $wpdb;

                                                    // Prepare the SQL query
                                                    $query = $wpdb->prepare("
                                                        SELECT SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
                                                        FROM {$wpdb->postmeta} pm
                                                        JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                                                        WHERE pm.meta_key = 'total_price'
                                                        AND p.post_type = %s
                                                        AND p.post_status = 'publish'
                                                    ", $post_type);

                                                    // Execute the query
                                                    $total_amount = $wpdb->get_var($query);

                                                    return $total_amount ? $total_amount : 0;
                                                }
                                            ?>
                                            <h6>Total Earning</h6>
                                            <h2 class="fw-bolder mb-1">$<?= get_total_amount_sum_for_post_type('orders') ?></h2>
                                            <div id="statistics-profit-chart"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Line Chart - Profit -->

                                <!-- Earnings Card -->
                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="card earnings-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">

                                                <?php 
                                                
                                                    function get_total_amount_sum_for_post_type_this_month($first_day_of_month, $last_day_of_month) {
                                                        global $wpdb;
                                                    
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
                                                    
                                                        // Execute the query
                                                        $total_amount = $wpdb->get_var($query);
                                                    
                                                        return $total_amount ? $total_amount : 0;
                                                    }

                                                    $sumThisMonth = get_total_amount_sum_for_post_type_this_month( date('Y-m-01'), date('Y-m-t'));
                                                    $sumLastMonth = get_total_amount_sum_for_post_type_this_month( date('Y-m-01',strtotime('first day of last month')), date('Y-m-t',strtotime('last day of last month')));
                                                    
                                                    function calculate_percentage_increase($last_month, $this_month) {
                                                        if ($last_month == 0) {
                                                            return $this_month > 0 ? 100 : 0; // Handle division by zero
                                                        }
                                                    
                                                        $increase = (($this_month - $last_month) / $last_month) * 100;
                                                    
                                                        return round($increase, 2);
                                                    }

                                                    $sumPersent = calculate_percentage_increase($sumLastMonth, $sumThisMonth);
                                                ?>
                                                    <h4 class="card-title mb-1">Earnings</h4>
                                                    <div class="earning_log">
                                                        <div class="this_month">
                                                            <div class="font-small-2">This Month</div>
                                                            <h5 class="mb-1">$<?= $sumThisMonth ?></h5>
                                                        </div>
                                                        <div class="last_month">
                                                            <div class="font-small-2">Last Month</div>
                                                            <h5 class="mb-1">$<?= $sumLastMonth ?></h5>
                                                        </div>
                                                    </div>
                                                   
                                                    <p class="card-text text-muted font-small-2">
                                                        <span class="fw-bolder"><?= $sumPersent ?>%</span> <span><?= $sumPersent < 0 ? 'less' : 'more' ?>  earnings than last month.</span>
                                                    </p>
                                                </div>
                                                <div class="col-6">
                                                    <div id="earnings-chart"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Earnings Card -->
                            </div>
                        </div>

                        <!-- Revenue Report Card -->
                        <div class="col-lg-8 col-12">
                            <div class="card card-revenue-budget">
                                <div class="row mx-0">
                                    <div class="col-md-12 col-12 revenue-report-wrapper">
                                        <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title mb-50 mb-sm-0">Revenue Report</h4>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center me-2">
                                                    <span class="bullet bullet-primary font-small-3 me-50 cursor-pointer"></span>
                                                    <span>Booking</span>
                                                </div>
                                                <div class="d-flex align-items-center ms-75">
                                                    <span class="bullet bullet-warning font-small-3 me-50 cursor-pointer"></span>
                                                    <span>Earnings</span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 

                                            function get_order_count_by_month($post_type) {
                                                global $wpdb;

                                                // Get the current year
                                                $current_year = date('Y');
                                            
                                                // Prepare the SQL query to get the count of orders grouped by month for the current year
                                                // AND post_status IN ('completed', 'publish', 'wc-on-hold')  -- Include only specific order statuses
                                                $query = $wpdb->prepare("
                                                    SELECT DATE_FORMAT(post_date, '%%Y-%%m') as month, COUNT(ID) as order_count
                                                    FROM {$wpdb->posts}
                                                    WHERE post_type = %s
                                                    AND post_status IN ('completed', 'publish', 'wc-on-hold')
                                                    AND YEAR(post_date) = %d
                                                    GROUP BY DATE_FORMAT(post_date, '%%Y-%%m')
                                                    ORDER BY DATE_FORMAT(post_date, '%%Y-%%m') ASC
                                                ", $post_type, $current_year);
                                            
                                                // Execute the query
                                                $results = $wpdb->get_results($query, OBJECT_K);
                                            
                                                // Initialize an array with all months of the current year
                                                $months = array();
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $month = sprintf('%s-%02d', $current_year, $i);
                                                    $months[] = isset($results[$month]) ? $results[$month]->order_count : 0;
                                                }
                                            
                                                return $months;
                                            }

                                            function get_total_amount_sum_by_month_for_current_year($post_type = 'orders', $meta_key = 'total_price') {
                                                global $wpdb;
                                            
                                                // Get the current year
                                                $current_year = date('Y');
                                            
                                                // Prepare the SQL query to get the sum of total_price grouped by month for the current year
                                                $query = $wpdb->prepare("
                                                    SELECT DATE_FORMAT(post_date, '%%Y-%%m') as month, SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
                                                    FROM {$wpdb->postmeta} pm
                                                    JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                                                    WHERE pm.meta_key = %s
                                                    AND p.post_type = %s
                                                    AND p.post_status = 'publish'
                                                    AND YEAR(p.post_date) = %d
                                                    GROUP BY DATE_FORMAT(p.post_date, '%%Y-%%m')
                                                    ORDER BY DATE_FORMAT(p.post_date, '%%Y-%%m') ASC
                                                ", $meta_key, $post_type, $current_year);
                                            
                                                // Execute the query
                                                $results = $wpdb->get_results($query, OBJECT_K);
                                            
                                                // Initialize an array with all months of the current year
                                                $months = array();
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $month = sprintf('%s-%02d', $current_year, $i);
                                                    $months[] = isset($results[$month]) ? $results[$month]->total_amount : 0;
                                                }
                                            
                                                return $months;
                                            }

                                        ?>
                                        <!-- <div id="revenue-report-chart"></div> -->
                                        <div id="booking-chart"></div>
                                    </div>
                                    <!-- <div class="col-md-4 col-12 budget-wrapper">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle budget-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                2020
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">2020</a>
                                                <a class="dropdown-item" href="#">2019</a>
                                                <a class="dropdown-item" href="#">2018</a>
                                            </div>
                                        </div>
                                        <h2 class="mb-25">$25,852</h2>
                                        <div class="d-flex justify-content-center">
                                            <span class="fw-bolder me-25">Budget:</span>
                                            <span>56,800</span>
                                        </div>
                                        <div id="budget-chart"></div>
                                        <button type="button" class="btn btn-primary">Increase Budget</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!--/ Revenue Report Card -->
                    </div>

                 
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

   

    <?php include "includes/scripts.php"; ?>

    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/js/core/app-menu.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>

    
    <script>

        var bookingChartData = <?= json_encode(get_order_count_by_month('orders')) ?>;
        var revenueChatData = <?= json_encode(get_total_amount_sum_by_month_for_current_year()) ?>;
        // console.log(revenueChatData);
        // var bookingChartData = [];
        // var revenueChatData = [];

        var $bookingChart = document.querySelector('#booking-chart');
        var bookingChart;

        var $textMutedColor = '#b9b9c3';

        function graphData(booking, earning) {
            return {
                chart: {
                height: 230,
                stacked: true,
                type: 'bar',
                toolbar: { show: true }
                },
                plotOptions: {
                bar: {
                    columnWidth: '17%',
                    endingShape: 'rounded'
                },
                distributed: true
                },
                colors: [window.colors.solid.primary, window.colors.solid.warning],
                series: [
                {
                    name: 'Bookings',
                    data: booking
                    // data: [95, 177, 284, 256, 105, 63, 168, 218, 72, 24, 422, 22]
                },
                {
                    name: 'Earnings',
                    data:  earning
                    // data: [-8, -10, 2, 5, 3, -10, 6, 2, 4, 7, 20, 305]
                }
                ],
                dataLabels: {
                enabled: false
                },
                legend: {
                show: false
                },
                grid: {
                padding: {
                    top: -20,
                    bottom: -10
                },
                yaxis: {
                    lines: { show: true }
                }
                },
                xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: {
                    style: {
                    colors: $textMutedColor,
                    fontSize: '0.86rem'
                    }
                },
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                }
                },
                yaxis: {
                labels: {
                    style: {
                    colors: $textMutedColor,
                    fontSize: '0.86rem'
                    }
                }
                }
            };
        }

        bookingChart = new ApexCharts($bookingChart, graphData(bookingChartData,revenueChatData));
        bookingChart.render();

</script>
</body>
<!-- END: Body-->

<!-- </html> -->