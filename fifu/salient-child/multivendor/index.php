<?php /* Template Name: index */ ?>
<?php 
if(!is_user_logged_in() ) { 
    $redirect = home_url('login');
    echo "<script>
      
        window.location.href = '{$redirect}';
    </script>";

    wp_redirect(home_url('login/'));
    exit;
} 

$user = wp_get_current_user();
if(in_array('administrator', $user ->roles)) { 

    include "includes/styles.php"; ?>
    <?php
        // total Profits/ Earning
        global $wpdb;

        // Prepare the SQL query
        $query = $wpdb->prepare("
        SELECT DISTINCT wp_wc_order_stats.net_total FROM wp_wc_order_stats
        INNER JOIN wp_wc_orders_meta ON 
        wp_wc_order_stats.order_id = wp_wc_orders_meta.order_id 
        WHERE wp_wc_orders_meta.meta_key = 'main_order';
        ");

        // Execute the query
        $total_amount = $wpdb->get_results($query); 
    ?>

    <!-- END: Head-->
    <?php include "includes/header.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/charts/apexcharts.css">
    <!-- BEGIN: Body-->

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
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        <!-- Statistics Card -->
                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Statistics</h4>
                                    <!-- <div class="d-flex align-items-center">
                                        <p class="card-text font-small-2 me-25 mb-0">Updated 1 month ago</p>
                                    </div> -->
                                </div>
                                <div class="card-body statistics-body">
                                    <div class="row">
                                     
                                        <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="box" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <?php $total = 0; foreach ($total_amount as $key => $value) { $total += $value->net_total; }   ?>

                                                    <h4 class="fw-bolder mb-0">$<?=  number_format($total, 2); ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Transactions </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-info me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="shopping-cart" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <?php 
                                                    $product_arg = [
                                                        'post_type' => 'product',
                                                        'post_status' => 'publish',
                                                        
                                                    ];
                                                    $product_query = new WP_Query($product_arg);
                                                    ?>

                                                    <h4 class="fw-bolder mb-0"><?= $product_query->found_posts  ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Products </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-success me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="shopping-bag" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <?php 
                                                $query = $wpdb->prepare(
                                                    "SELECT * FROM `wp_wc_orders_meta` WHERE `meta_key` = 'usertype' AND `meta_value` IN ('farmer', 'supplier')"
                                                );      
                                                // Execute the query
                                                $results = $wpdb->get_results($query); 
                                                $orders_count = count($results); ?>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0"><?= $orders_count ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Orders</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-info me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="user" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <?php
                                                $users = new WP_User_Query( array(
                                                    'role'     => 'restaurant',
                                                ) );
                                                $restaurants = $users->get_results();
                                                $restaurants_count = count($restaurants); ?>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0"><?= $restaurants_count ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Restaurants </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="user" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <?php
                                                $args = new WP_User_Query( array(
                                                    'role'     => 'farmer',
                                                ) );
                                                $farmers = $args->get_results();
                                                $farmers_count = count($farmers); ?>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0"><?= $farmers_count  ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Farmers </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-success me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="user" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <?php
                                                $args = new WP_User_Query( array(
                                                    'role'     => 'supplier',
                                                ) );
                                                $suppliers = $args->get_results();
                                                $suppliers_count = count($suppliers); ?>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0"><?=  $suppliers_count  ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Suppliers</p>
                                                </div>
                                            </div>
                                        </div>

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
                                            $query = $wpdb->prepare(
                                                "SELECT * FROM `wp_wc_orders_meta` WHERE `meta_key` = 'usertype' AND `meta_value` IN ('farmer', 'supplier')"
                                            );      
                                            // Execute the query
                                            $results = $wpdb->get_results($query); 
                                            $orders_count = count($results); ?>

                                            <h6>Total Orders</h6>
                                            <h2 class="fw-bolder mb-1"><?= $orders_count ?></h2>
                                            <div id="statistics-order-chart"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Bar Chart - Orders -->

                                <!-- Line Chart - Profit -->
                                <div class="col-lg-6 col-md-3 col-6">
                                    <div class="card card-tiny-line-stats">
                                        <div class="card-body pb-50">
                                            <?php $total = 0; foreach ($total_amount as $key => $value) { $total += $value->net_total; }   ?>
                                            <h6>Total Earning</h6>
                                            <h2 class="fw-bolder mb-1">$<?=  number_format($total, 2); ?></h2>
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
                                                <div class="col-12">

                                                    <?php 
                                                    
                                                        function get_total_amount_sum_for_post_type_this_month($first_day_of_month, $last_day_of_month) {
                                                            global $wpdb;

                                                        
                                                        
                                                            $query = $wpdb->prepare("
                                                                SELECT  SUM(CAST(pm.`net_total` AS UNSIGNED)) AS total_amount
                                                                FROM wp_wc_order_stats pm
                                                                JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                                WHERE p.meta_key = 'main_order'
                                                                AND pm.date_created >= %s
                                                                AND pm.date_created <= %s
                                                            ", $first_day_of_month, $last_day_of_month);
                                                        
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
                                            function get_product_order_count_by_month() {
                                                global $wpdb;

                                                // Get the current year
                                                $current_year = date('Y');

                                                // Prepare the SQL query to get the count of orders grouped by month for the current year
                                                // AND post_status IN ('completed', 'publish', 'wc-on-hold')  -- Include only specific order statuses

                                                $query = $wpdb->prepare("
                                                SELECT DISTINCT DATE_FORMAT(date_created, '%%Y-%%m') as month, COUNT(order_id) as order_count 
                                                FROM wp_wc_order_stats
                                                WHERE YEAR(date_created) = %d
                                                GROUP BY DATE_FORMAT(date_created, '%%Y-%%m')
                                                ORDER BY DATE_FORMAT(date_created, '%%Y-%%m') ASC
                                                ", $current_year);

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

                                            function get_product_total_amount_sum_by_month_for_current_year() {
                                                global $wpdb;

                                                // Get the current year
                                                $current_year = date('Y');

                                                // Prepare the SQL query to get the sum of total_price grouped by month for the current year
                                                $query = $wpdb->prepare("
                                                    SELECT DATE_FORMAT(date_created, '%%Y-%%m') as month, SUM(CAST(pm.`net_total` AS UNSIGNED)) AS total_amount
                                                    FROM wp_wc_order_stats pm
                                                    JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                    WHERE p.meta_key = 'main_order'
                                                    AND YEAR(pm.date_created) = %d
                                                    GROUP BY DATE_FORMAT(pm.date_created, '%%Y-%%m')
                                                    ORDER BY DATE_FORMAT(pm.date_created, '%%Y-%%m') ASC
                                                ",$current_year);


                                            

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

                                        <!-- <div id="booking-chart"></div> -->

                                        <div id="product-chart"></div>
                                    </div>
                                  
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

    <script src="<?= $directory_url ?>/app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/core/app-menu.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>

    
    <script>

        var productbookingChartData = <?= json_encode(get_product_order_count_by_month()) ?>;
        var productrevenueChatData = <?= json_encode(get_product_total_amount_sum_by_month_for_current_year()) ?>;


        // var bookingChartData = [];
        // var revenueChatData = [];

        var $productChart = document.querySelector('#product-chart');
        var productChart;

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


        productChart = new ApexCharts($productChart, graphData(productbookingChartData,productrevenueChatData));
        productChart.render();

    </script>

    
</body>
<!-- Supplier dashboard -->
<?php } elseif(in_array('supplier', $user ->roles)) { ?>

    <!-- BEGIN: Head-->

    <?php include "includes/styles.php"; ?>

    <!-- END: Head-->
    <?php include "includes/header.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/charts/apexcharts.css">
    <!-- BEGIN: Body-->

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
            </div>
            <div class="content-body">
            
                <!-- Vendor Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <!-- Statistics Card -->
                    <div class="row match-height">
                        <div class="col-lg-6 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Statistics</h4>
                                </div>
                                <div class="card-body statistics-body">
                                    <div class="row">
                                    
                                        <div class="col-md-6 col-12">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-success me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="shopping-cart" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <?php 
                                                $args = array(
                                                    'post_type' => 'product',
                                                    'author' => get_current_user_id(),
                                                    'post_status' => 'publish',
                                                    'posts_per_page' => -1,
                                                );
                                                $product_booking = new WP_Query($args); ?>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0"><?= $product_booking->found_posts ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Products</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="shopping-bag" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <?php 
                                                    $query = $wpdb->prepare(
                                                        'SELECT * FROM `wp_wc_orders_meta` WHERE `meta_key` = "_seller_id" AND `meta_value` = "'.get_current_user_id().'"'
                                                    );  

                                                    // Execute the query
                                                    $results = $wpdb->get_results($query);
                                                    $orders_count = count($results) ?>

                                                    <h4 class="fw-bolder mb-0"><?=  $orders_count  ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Orders </p>
                                                </div>
                                            </div>
                                        </div>

                                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-lg-2 col-12">
                            <!-- Bar Chart - Orders -->
                            
                            <?php
                                $query = $wpdb->prepare('
                                SELECT SUM(CAST(wp_wc_order_stats.net_total AS UNSIGNED))  AS total_amount
                                FROM wp_wc_order_stats 
                                INNER JOIN wp_wc_orders_meta ON 
                                wp_wc_order_stats.order_id = wp_wc_orders_meta.order_id 
                                WHERE wp_wc_orders_meta.meta_key = "_seller_id"
                                AND wp_wc_orders_meta.meta_value = "'.get_current_user_id().'"');

                                // Execute the query
                                $results = $wpdb->get_results($query);
                                
                            ?>
                            
                            <div class="card">
                                <div class="card-body pb-50">
                                    <h6>Sales</h6>
                                    <h2 class="fw-bolder mb-1">$<?= number_format($results[0]->total_amount, 2);  ?></h2>
                                    <div id="statistics-order-chart"></div>
                                </div>
                            </div>
                                
                            <!--/ Bar Chart - Orders -->
                        </div>

                            <!-- Earnings Card -->
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="card earnings-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">

                                            <?php 
                                            
                                                function get_total_amount_sum_for_post_type_this_month($first_day_of_month, $last_day_of_month) {
                                                    global $wpdb;
                                                
                                                    $query = $wpdb->prepare("
                                                        SELECT  SUM(CAST(pm.`net_total` AS UNSIGNED)) AS total_amount
                                                        FROM wp_wc_order_stats pm
                                                        JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                        WHERE p.meta_key = %s
                                                        AND `meta_value` = %d
                                                        AND pm.date_created >= %s
                                                        AND pm.date_created <= %s
                                                    ", '_seller_id', get_current_user_id(), $first_day_of_month, $last_day_of_month);
                                                
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
                                            <div id="statistics-profit-chart" style="display:none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Earnings Card -->
                    </div>
                    <!--/ Statistics Card -->

                    <!-- Product Order Revenue Report Card -->
                    <div class="row match-height">
                        <div class="col-lg-12 col-12">
                            <div class="card card-revenue-budget">
                                <div class="row mx-0">
                                    <div class="col-md-12 col-12 revenue-report-wrapper">
                                        <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title mb-50 mb-sm-0">Product Orders Report</h4>
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
                                            function get_product_order_count_by_month() {
                                                global $wpdb;

                                                // Get the current year
                                                $current_year = date('Y');

                                                // Prepare the SQL query to get the count of orders grouped by month for the current year
                                                // AND post_status IN ('completed', 'publish', 'wc-on-hold')  -- Include only specific order statuses

                                                $query = $wpdb->prepare("
                                                SELECT DISTINCT DATE_FORMAT(date_created, '%%Y-%%m') as month, COUNT(order_id) as order_count 
                                                FROM wp_wc_order_stats
                                                WHERE YEAR(date_created) = %d
                                                AND  `meta_value` = %s
                                                AND `meta_value` = %d
                                                GROUP BY DATE_FORMAT(date_created, '%%Y-%%m')
                                                ORDER BY DATE_FORMAT(date_created, '%%Y-%%m') ASC
                                                ", $current_year, '_seller_id', get_current_user_id());

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

                                            function get_product_total_amount_sum_by_month_for_current_year() {
                                                global $wpdb;

                                                // Get the current year
                                                $current_year = date('Y');

                                                // Prepare the SQL query to get the sum of total_price grouped by month for the current year
                                                $query = $wpdb->prepare("
                                                    SELECT DATE_FORMAT(date_created, '%%Y-%%m') as month, SUM(CAST(pm.`net_total` AS UNSIGNED)) AS total_amount
                                                    FROM wp_wc_order_stats pm
                                                    JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                    WHERE p.meta_key = %s
                                                    AND `meta_value` = %d
                                                    AND YEAR(pm.date_created) = %d
                                                    GROUP BY DATE_FORMAT(pm.date_created, '%%Y-%%m')
                                                    ORDER BY DATE_FORMAT(pm.date_created, '%%Y-%%m') ASC
                                                ", '_seller_id',get_current_user_id(), $current_year);


                                            

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

                                        <!-- <div id="booking-chart"></div> -->

                                        <div id="product-chart"></div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Product Order Report Card -->
                    
                
                </section>
                <!-- Vendor Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>



    <?php include "includes/scripts.php"; ?>

    <script src="<?= $directory_url ?>/app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/core/app-menu.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>

    <script>


        var productbookingChartData = <?= json_encode(get_product_order_count_by_month()) ?>;
        var productrevenueChatData = <?= json_encode(get_product_total_amount_sum_by_month_for_current_year()) ?>;


        var $productChart = document.querySelector('#product-chart');
        var productChart;

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

        productChart = new ApexCharts($productChart, graphData(productbookingChartData,productrevenueChatData));
        productChart.render();
    </script>

</body>
<!-- END: Body-->
<!-- Supplier dashboard -->

<!-- Farmer Dashboard -->
<?php } elseif(in_array('farmer', $user ->roles)) { ?>
    <!-- BEGIN: Head-->

    <?php include "includes/styles.php"; ?>

    <!-- END: Head-->
    <?php include "includes/header.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/charts/apexcharts.css">
    <!-- BEGIN: Body-->

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
            </div>
            <div class="content-body">
              
                <!-- Vendor Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <!-- Statistics Card -->
                    <div class="row match-height">
                        <div class="col-lg-6 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Statistics</h4>
                                </div>
                                <div class="card-body statistics-body">
                                    <div class="row">
                                   
                                        <div class="col-md-6 col-12">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-success me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="shopping-cart" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <?php 
                                                $args = array(
                                                    'post_type' => 'product',
                                                    'author' => get_current_user_id(),
                                                    'post_status' => 'publish',
                                                    'posts_per_page' => -1,
                                                );
                                                $product_booking = new WP_Query($args); ?>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0"><?= $product_booking->found_posts ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Products</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="shopping-bag" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <?php 
                                                    $query = $wpdb->prepare(
                                                        'SELECT * FROM `wp_wc_orders_meta` WHERE `meta_key` = "_seller_id" AND `meta_value` = "'.get_current_user_id().'"'
                                                    );  

                                                    // Execute the query
                                                    $results = $wpdb->get_results($query);
                                                    $orders_count = count($results) ?>

                                                    <h4 class="fw-bolder mb-0"><?=  $orders_count  ?></h4>
                                                    <p class="card-text font-small-3 mb-0">Orders </p>
                                                </div>
                                            </div>
                                        </div>

                                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-lg-2 col-12">
                            <!-- Bar Chart - Orders -->
                            
                            <?php
                                $query = $wpdb->prepare('
                                SELECT SUM(CAST(wp_wc_order_stats.net_total AS UNSIGNED))  AS total_amount
                                FROM wp_wc_order_stats 
                                INNER JOIN wp_wc_orders_meta ON 
                                wp_wc_order_stats.order_id = wp_wc_orders_meta.order_id 
                                WHERE wp_wc_orders_meta.meta_key = "_seller_id"
                                AND wp_wc_orders_meta.meta_value = "'.get_current_user_id().'"');

                                // Execute the query
                                $results = $wpdb->get_results($query);
                                
                            ?>
                            <div class="card">
                                <div class="card-body pb-50">
                                    <h6>Sales</h6>
                                    <h2 class="fw-bolder mb-1">$<?= number_format($results[0]->total_amount, 2);  ?></h2>
                                    <div id="statistics-order-chart"></div>
                                </div>
                            </div>
                                
                            <!--/ Bar Chart - Orders -->
                        </div>

                            <!-- Earnings Card -->
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="card earnings-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">

                                                <?php 
                                            
                                                function get_total_amount_sum_for_post_type_this_month($first_day_of_month, $last_day_of_month) {
                                                    global $wpdb;
                                                
                                                    $query = $wpdb->prepare("
                                                        SELECT  SUM(CAST(pm.`net_total` AS UNSIGNED)) AS total_amount
                                                        FROM wp_wc_order_stats pm
                                                        JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                        WHERE p.meta_key = %s
                                                        AND `meta_value` = %d
                                                        AND pm.date_created >= %s
                                                        AND pm.date_created <= %s
                                                    ", '_seller_id', get_current_user_id(), $first_day_of_month, $last_day_of_month);
                                                
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
                                            <div id="statistics-profit-chart" style="display:none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Earnings Card -->
                    </div>
                    <!--/ Statistics Card -->

                    <!-- Product Order Revenue Report Card -->
                    <div class="row match-height">
                        <div class="col-lg-12 col-12">
                            <div class="card card-revenue-budget">
                                <div class="row mx-0">
                                    <div class="col-md-12 col-12 revenue-report-wrapper">
                                        <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title mb-50 mb-sm-0">Product Orders Report</h4>
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
                                            function get_product_order_count_by_month() {
                                                global $wpdb;

                                                // Get the current year
                                                $current_year = date('Y');

                                                // Prepare the SQL query to get the count of orders grouped by month for the current year
                                                // AND post_status IN ('completed', 'publish', 'wc-on-hold')  -- Include only specific order statuses

                                                $query = $wpdb->prepare("
                                                SELECT DISTINCT DATE_FORMAT(date_created, '%%Y-%%m') as month, COUNT(order_id) as order_count 
                                                FROM wp_wc_order_stats
                                                WHERE YEAR(date_created) = %d
                                                AND  `meta_value` = %s
                                                AND `meta_value` = %d
                                                GROUP BY DATE_FORMAT(date_created, '%%Y-%%m')
                                                ORDER BY DATE_FORMAT(date_created, '%%Y-%%m') ASC
                                                ", $current_year, '_seller_id', get_current_user_id());

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

                                            function get_product_total_amount_sum_by_month_for_current_year() {
                                                global $wpdb;

                                                // Get the current year
                                                $current_year = date('Y');

                                                // Prepare the SQL query to get the sum of total_price grouped by month for the current year
                                                $query = $wpdb->prepare("
                                                    SELECT DATE_FORMAT(date_created, '%%Y-%%m') as month, SUM(CAST(pm.`net_total` AS UNSIGNED)) AS total_amount
                                                    FROM wp_wc_order_stats pm
                                                    JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                    WHERE p.meta_key = %s
                                                    AND `meta_value` = %d
                                                    AND YEAR(pm.date_created) = %d
                                                    GROUP BY DATE_FORMAT(pm.date_created, '%%Y-%%m')
                                                    ORDER BY DATE_FORMAT(pm.date_created, '%%Y-%%m') ASC
                                                ", '_seller_id',get_current_user_id(), $current_year);


                                            

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

                                        <!-- <div id="booking-chart"></div> -->

                                        <div id="product-chart"></div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Product Order Report Card -->
                    
                   
                </section>
                <!-- Vendor Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

   

    <?php include "includes/scripts.php"; ?>

    <script src="<?= $directory_url ?>/app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/core/app-menu.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>

    <script>


        var productbookingChartData = <?= json_encode(get_product_order_count_by_month()) ?>;
        var productrevenueChatData = <?= json_encode(get_product_total_amount_sum_by_month_for_current_year()) ?>;


        var $productChart = document.querySelector('#product-chart');
        var productChart;

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

        productChart = new ApexCharts($productChart, graphData(productbookingChartData,productrevenueChatData));
        productChart.render();
    </script>

    
</body>
<!-- END: Body-->
<!-- Farmer Dashboard -->

<!-- Restaurant Dashboard -->
<?php } elseif(in_array('restaurant', $user ->roles)) {  ?>

    <!-- BEGIN: Head-->

    <?php include "includes/styles.php"; ?>

    <!-- END: Head-->
    <?php include "includes/header.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/charts/apexcharts.css">
<!-- BEGIN: Body-->

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
                  
                   
                <section id="dashboard-ecommerce">
                   
                    <div class="row match-height">
                    

                        <!-- Orders Revenue Report Card -->
                        <div class="col-lg-7 col-12">
                            <div class="card card-revenue-budget">
                                <div class="row mx-0">
                                    <div class="col-md-12 col-12 revenue-report-wrapper">
                                        <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title mb-50 mb-sm-0"> Orders Report</h4>
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
                                            function get_product_order_count_by_month() {
                                                global $wpdb;

                                                // Get the current year
                                                $current_year = date('Y');

                                                // Prepare the SQL query to get the count of orders grouped by month for the current year

                                                $query = $wpdb->prepare("
                                                SELECT DISTINCT DATE_FORMAT(pm.date_created, '%%Y-%%m') as month, COUNT(pm.order_id) as order_count 
                                                FROM wp_wc_order_stats pm
                                                JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                WHERE YEAR(pm.date_created) = %d
                                                AND p.`meta_key` = %s
                                                AND p.`meta_value` = %d
                                                GROUP BY DATE_FORMAT(pm.date_created, '%%Y-%%m')
                                                ORDER BY DATE_FORMAT(pm.date_created, '%%Y-%%m') ASC
                                                ", $current_year, 'customer_id', get_current_user_id());

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

                                            function get_product_total_amount_sum_by_month_for_current_year() {
                                                global $wpdb;

                                                // Get the current year
                                                $current_year = date('Y');

                                                // Prepare the SQL query to get the sum of total_price grouped by month for the current year
                                                $query = $wpdb->prepare("
                                                    SELECT DATE_FORMAT(date_created, '%%Y-%%m') as month, SUM(CAST(pm.`net_total` AS UNSIGNED)) AS total_amount
                                                    FROM wp_wc_order_stats pm
                                                    JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                    WHERE p.`meta_key` = %s
                                                    AND p.`meta_value` = %d
                                                    AND YEAR(pm.date_created) = %d
                                                    GROUP BY DATE_FORMAT(pm.date_created, '%%Y-%%m')
                                                    ORDER BY DATE_FORMAT(pm.date_created, '%%Y-%%m') ASC
                                                ",'customer_id', get_current_user_id(), $current_year);


                                            

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

                                        <!-- <div id="booking-chart"></div> -->

                                        <div id="product-chart"></div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        <!--/ Orders Report Card -->

                        <div class="col-lg-5 col-12">
                            <div class="row match-height">
                                <!-- Bar Chart - Orders -->
                                <div class="col-lg-4 col-md-3 col-6">
                                    <div class="card">
                                        <div class="card-body pb-50">

                                            <?php 
                                            $query = $wpdb->prepare(
                                                'SELECT * FROM `wp_wc_orders_meta` WHERE `meta_key` = "customer_id" AND `meta_value` = "'.get_current_user_id().'"'
                                            );  
                
                                            // Execute the query
                                            $results = $wpdb->get_results($query);
                                            $orders_count = count($results) ?>

                                            <h6>Total Orders</h6>
                                            <h2 class="fw-bolder mb-1"><?= $orders_count ?></h2>
                                            <div id="statistics-order-chart"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Bar Chart - Orders -->

                                <!-- Line Chart - Profit -->
                                <div class="col-lg-8 col-md-3 col-6">
                                    <div class="card card-tiny-line-stats">
                                        <div class="card-body pb-50">
                                            <h6>Total Spend</h6>
                                            <?php
                                               

                                               // Prepare the SQL query to get the sum of total_price grouped by month for the current year
                                               $query = $wpdb->prepare("
                                                   SELECT SUM(CAST(pm.`net_total` AS UNSIGNED)) AS total_amount
                                                   FROM wp_wc_order_stats pm
                                                   JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                   WHERE p.`meta_key` = %s
                                                   AND p.`meta_value` = %d
                                               ",'customer_id', get_current_user_id());

                                               // Execute the query
                                               $total_amount = $wpdb->get_var($query);

                                            // Execute the query
                                            //$total_spend = $wpdb->get_results($total_spend_query, OBJECT_K); ?>
                                            <h2 class="fw-bolder mb-1">$<?=  number_format($total_amount, 2); ?></h2>
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
                                                <div class="col-12">

                                                <?php 
                                                
                                                    function get_total_amount_sum_for_post_type_this_month($first_day_of_month, $last_day_of_month) {
                                                        global $wpdb;

                                                    
                                                    
                                                     

                                                        $query = $wpdb->prepare("
                                                        SELECT SUM(CAST(pm.`net_total` AS UNSIGNED)) AS total_amount
                                                        FROM wp_wc_order_stats pm
                                                        JOIN wp_wc_orders_meta p ON  pm.order_id = p.order_id 
                                                        WHERE p.`meta_key` = %s
                                                        AND p.`meta_value` = %d
                                                        AND pm.date_created >= %s
                                                        AND pm.date_created <= %s
                                                    ",'customer_id', get_current_user_id(), $first_day_of_month, $last_day_of_month);
                                                    
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
                                                    <h4 class="card-title mb-1">Monthly Spending</h4>
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
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Earnings Card -->
                            </div>
                           
                        </div>
                    </div>

                </section>
            
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

   

    <?php include "includes/scripts.php"; ?>

    <script src="<?= $directory_url ?>/app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/core/app-menu.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>

    <script>

        var productbookingChartData = <?= json_encode(get_product_order_count_by_month()) ?>;
        var productrevenueChatData = <?= json_encode(get_product_total_amount_sum_by_month_for_current_year()) ?>;


        // console.log("productbookingChartData",productbookingChartData);
        // console.log("productrevenueChatData",productrevenueChatData);
        // var bookingChartData = [];
        // var revenueChatData = [];


        var $productChart = document.querySelector('#product-chart');
        var productChart;

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


        productChart = new ApexCharts($productChart, graphData(productbookingChartData,productrevenueChatData));
        productChart.render();

    </script>

    
</body>
<!-- END: Body-->
<?php } ?>
<!-- Restaurant Dashboard -->