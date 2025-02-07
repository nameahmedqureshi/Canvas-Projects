<?php /* Template Name: Dashboard */ ?>
<?php 
if(!is_user_logged_in() ) { 
    $redirect = home_url('login');
    echo "<script>
      
        window.location.href = '{$redirect}';
    </script>";

    wp_redirect(home_url('login/'));
    exit;
} 
$user = wp_get_current_user(); ?>
<style>
    p.card-text.font-small-3.mb-0 {
        color: #b4b7bd;
    }
    .stats {
        font-size: 12px !important;
    }
</style>
<?php
if(in_array('administrator', $user ->roles)) { ?>

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
                    <section id="dashboard-ecommerce">
                        <div class="row match-height">
                            <!-- Statistics Card -->
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="card card-statistics">
                                    <div class="card-header">
                                        <h4 class="card-title">Statistics</h4>
                                    </div>
                                    <div class="card-body statistics-body">
                                        <div class="row">
                                        
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <?php
                                                // total Profits/ Earning
                                                global $wpdb;
                                          
                                                // Prepare the SQL query for service orders sales count
                                                $query = $wpdb->prepare("
                                                SELECT SUM(CAST(pm.meta_value AS DECIMAL(10,2))) as total_sum
                                                FROM {$wpdb->posts} p
                                                INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                                                WHERE p.post_type = 'total_sales'
                                                AND p.post_status = 'publish'
                                                AND pm.meta_key = 'total_price'
                                                ");
                                                $sales_query = $wpdb->get_var($query); 
                                                ?>
                                                <!-- <div class="d-flex flex-row"> -->
                                                <a class="d-flex flex-row" href="<?= home_url( 'total-earning' ) ?>">
                                                    <div class="avatar bg-light-danger me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="dollar-sign" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">

                                                        <h4 class="fw-bolder mb-0">$<?=  number_format($sales_query, 2); ?></h4>
                                                        <p class="card-text font-small-3 mb-0">Transactions</p>
                                                    </div>
                                                   
                                                </a>
                                            </div>
                                            <?php 
                                                function get_product_count($meta_value){
                                                    $args = array(
                                                        'post_type' => 'product',
                                                        'post_status' => 'publish',
                                                        'posts_per_page' => -1,
                                                        'meta_key' => 'product_type',
                                                        'meta_value' =>  $meta_value
                                                    );
                                                    $products = new WP_Query($args);
                                                    return count($products->posts);
                                                }
                                            ?>
                                            <!-- Creations -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="figma" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_product_count('creations') ?></h4>
                                                        <p class="card-text font-small-3 mb-0">Creations</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- STL Library -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="package" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_product_count('stl-library') ?></h4>
                                                        <p class="card-text font-small-3 mb-0">STL Library</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Services -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="layout" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_product_count('services') ?></h4>
                                                        <p class="card-text font-small-3 mb-0">Services</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Customers -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-xl-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-info me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="user" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $users = new WP_User_Query( array(
                                                        'role'     => 'customer',
                                                    ) );
                                                    $customer_users = $users->get_results();
                                                    $customer_count = count($customer_users); ?>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= $customer_count ?></h4>
                                                        <p class="card-text font-small-3 mb-0">Customers </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Vendors -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="user" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $args = new WP_User_Query( array(
                                                        'role'     => 'vendor',
                                                    ) );
                                                    $vendors = $args->get_results();
                                                    $vendor_count = count($vendors); ?>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?=  $vendor_count  ?></h4>
                                                        <p class="card-text font-small-3 mb-0">Vendors</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-info me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="user" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                    $args = array(
                                                        'post_type' => 'subscribers',
                                                        'post_status' => 'publishs',
                                                        'posts_per_page' => -1,
                                                    );
                                                    $subscriber = new WP_Query($args);
                                                    $count = count($subscriber->posts); ?>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= $count ?></h4>
                                                        <p class="card-text font-small-3 mb-0">Subscribers</p>
                                                    </div>
                                                </div>
                                            </div> -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Statistics Card -->
                        </div>

                        <!-- Orders Count -->
                        <div class="row match-height">
                            <?php 
                            function get_orders_count($meta_value){
                                $args = array(
                                    'post_type' => 'total_sales',
                                    'post_status' => 'publish',
                                    'meta_key' => 'type',
                                    'meta_value' => $meta_value
                                );
                                $order_count = new WP_Query($args);
                                return count($order_count->posts); 
                            }
                           ?>
                            <div class="col-lg-12 col-12">
                                <div class="row match-height">
                                    <!-- Bar Chart - Creations Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Creation Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('creations') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Creations Orders -->

                                    <!-- Bar Chart - Stl Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>STL Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('stl-library') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Stl Orders -->

                                    <!-- Bar Chart - Services Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Services Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('services') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Services Orders -->

                                   
                                    <!-- Bar Chart - Print on demand Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Print on demand Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('print-on-demand') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Print on demand Orders -->

                                    <!-- Bar Chart - Service on demand Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Service on demand Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('service-on-demand') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Print on demand Orders -->

                                    <!-- Bar Chart - Bulk Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Bulk Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('bulk-manufacturing') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Print on demand Orders -->

                                </div>
                            </div>
                        </div>

                        <!-- Graph -->
                        <div class="row match-height">
                        
                            <!-- Services Revenue Report Card -->
                            <div class="col-lg-6 col-12">
                                <div class="card card-revenue-budget">
                                    <div class="row mx-0">
                                        <div class="col-md-12 col-12 revenue-report-wrapper">
                                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                                <h4 class="card-title mb-50 mb-sm-0">On Demand Bookings Report</h4>
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
                                                        AND post_status IN ('draft', 'publish')
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

                                                function get_total_amount_sum_by_month_for_current_year($post_type = 'services-order', $meta_key = 'total_price') {
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
                                                        AND p.post_status IN ('draft', 'publish')
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

                                            <div id="booking-chart"></div>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                            <!--/ Services Report Card -->

                            <!-- Orders Revenue Report Card -->
                            <div class="col-lg-6 col-12">
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
                            <!--/ Orders Report Card -->
                        </div>

                        <!-- Earning -->
                        <div class="row match-height">
                            <!-- Revenue Report Card -->
                            <div class="col-lg-6 col-12">
                                <div class="card earnings-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">

                                            <?php 
                                            
                                                function get_total_amount_sum_for_post_type_this_month($first_day_of_month, $last_day_of_month) {
                                                    global $wpdb;

                                                    // get services amount
                                                    $query = $wpdb->prepare("
                                                    SELECT  SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
                                                    FROM {$wpdb->posts} p
                                                    INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                                                    WHERE pm.meta_key = %s
                                                    AND p.post_type = %s
                                                    AND p.post_status IN ('draft', 'publish')
                                                    AND p.post_date >= %s
                                                    AND p.post_date <= %s
                                                    ", 'total_price','total_sales', $first_day_of_month, $last_day_of_month);

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
                                                <h4 class="card-title mb-1">Monthly Transactions</h4>
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
                            <!--/ Revenue Report Card -->
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
           

            var bookingChartData = <?= json_encode(get_order_count_by_month('services-order')) ?>;
            var revenueChatData = <?= json_encode(get_total_amount_sum_by_month_for_current_year()) ?>;

            var productbookingChartData = <?= json_encode(get_product_order_count_by_month()) ?>;
            var productrevenueChatData = <?= json_encode(get_product_total_amount_sum_by_month_for_current_year()) ?>;


            // console.log("productbookingChartData",productbookingChartData);
            // console.log("productrevenueChatData",productrevenueChatData);
            // var bookingChartData = [];
            // var revenueChatData = [];

            var $bookingChart = document.querySelector('#booking-chart');
            var bookingChart;
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

            bookingChart = new ApexCharts($bookingChart, graphData(bookingChartData,revenueChatData));
            bookingChart.render();

            productChart = new ApexCharts($productChart, graphData(productbookingChartData,productrevenueChatData));
            productChart.render();

        </script>
        
    </body>
    <!-- END: Body-->


<?php } elseif(in_array('vendor', $user ->roles)) { ?>

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
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="card card-statistics">
                                    <div class="card-header">
                                        <h4 class="card-title">Statistics</h4>
                                    </div>
                                    <div class="card-body statistics-body">
                                        <div class="row">
                                        
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <?php
                                                    // Prepare the SQL query for orders sales
                                                    $query = $wpdb->prepare(
                                                    "SELECT SUM(CAST(pm.meta_value AS DECIMAL(10,2))) as total_sum
                                                     FROM {$wpdb->posts} p
                                                     INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                                                     INNER JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id
                                                     WHERE p.post_type = 'total_sales'
                                                     AND p.post_status = 'publish'
                                                     AND pm.meta_key = 'total_price'
                                                     AND pm2.meta_key = 'vendor_id'
                                                     AND pm2.meta_value = %d",
                                                    get_current_user_id()
                                                    );
  
                                            
                                                
                                                    // Execute the query
                                                    $services_sales_query = $wpdb->get_var($query);
                                                ?>
                                                <!-- <div class="d-flex flex-row"> -->
                                                <a class="d-flex flex-row" href="<?= home_url( 'earnings' ) ?>">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="trending-up" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0">$<?= number_format($services_sales_query, 2) ?></h4>
                                                        <p class="card-text font-small-2 mb-0">Transactions </p>
                                                    </div>
                                                </a>
                                            </div>

                                            <!-- Available Balance -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="credit-card" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                    $sales_and_commission_data =  $payoutClass->get_user_sales_and_commission_data(get_current_user_id());

                                                    ?>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0">$<?= number_format($sales_and_commission_data['net_amount'], 2);  ?></h4>
                                                        <p class="card-text font-small-2 mb-0">Balance</p>
                                                    </div>
                                                </div>
                                            </div> 

                                            <?php 
                                                function get_product_count($product_type){
                                                    $args = array(
                                                        'post_type' => 'product',
                                                        'post_status' => 'publish',
                                                        'author' => get_current_user_id(),
                                                        'posts_per_page' => -1,
                                                        'meta_key' => 'product_type',
                                                        'meta_value' =>  $product_type,
                                                    );
                                                    $products = new WP_Query($args);
                                                    return count($products->posts);
                                                }
                                            ?>
                                            <!-- Creations -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="figma" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_product_count('creations') ?></h4>
                                                        <p class="card-text font-small-2 mb-0">Creations</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- STL Library -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="package" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_product_count('stl-library') ?></h4>
                                                        <p class="card-text font-small-2 mb-0">STL Library</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Services -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="layout" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_product_count('services') ?></h4>
                                                        <p class="card-text font-small-2 mb-0">Services</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Qoute Requests -->
                                            <?php
                                            function get_quote_requests_count(){
                                                $args = array(
                                                    'post_type' => ['print-on-demand', 'service-on-demand', 'bulk-manufacturing'],
                                                    'posts_per_page' => -1,
                                                    'meta_key' => 'post_status',
                                                    'meta_value' =>  'active',
                                                );
                                                $quote_requests = new WP_Query($args);
                                                return count($quote_requests->posts);
                                            }
                                            ?>
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="list" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_quote_requests_count() ?></h4>
                                                        <p class="card-text font-small-2 mb-0">Quote Requests</p>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Statistics Card -->

                        <!-- Badge and earning -->
                        <div class="row match-height">

                            <?php
                            $fast_responses = get_user_meta($user->ID, 'fast_responses', true);
                            $quick_shipping = get_user_meta($user->ID, 'quick_shipping', true); 
                            if($fast_responses == 'true' || $quick_shipping == 'true') {
                            ?>
                            <!-- Medal Card -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="card card-congratulation-medal">
                                    <div class="card-body">
                                        <h5>Congratulations 🎉 </h5>
                                        <?php if($fast_responses == 'true') { ?>
                                        <p class="card-text font-small-3">You have earned fast response badge</p>
                                        <?php } ?>
                                        <?php if($quick_shipping == 'true') { ?>
                                        <p class="card-text font-small-3">You have earned quick shipping badge</p>
                                        <?php } ?>
                                        <img src="<?= $directory_url ?>/app-assets/images/illustration/badge.svg" class="congratulation-medal" alt="Medal Pic">

                                    </div>
                                </div>
                            </div>
                            <!--/ Medal Card -->
                            <?php } ?>


                            <!-- Earnings Card -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="card earnings-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">

                                            <?php 
                                            
                                                function get_total_amount_sum_for_post_type_this_month($first_day_of_month, $last_day_of_month) {
                                                    global $wpdb;


                                                    // get services amount
                                                    $query = $wpdb->prepare("
                                                    SELECT  SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
                                                    FROM {$wpdb->posts} p
                                                    INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                                                    INNER JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id
                                                    WHERE pm.meta_key = %s
                                                    AND p.post_type = %s
                                                    AND pm2.meta_key = %s
                                                    AND pm2.meta_value = %s
                                                    AND p.post_status IN ('draft', 'publish')
                                                    AND p.post_date >= %s
                                                    AND p.post_date <= %s
                                                    ", 'total_price','total_sales', 'vendor_id', get_current_user_id(), $first_day_of_month, $last_day_of_month);

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
                                                <h4 class="card-title mb-1">Monthly Transactions</h4>
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

                        <!-- Orders Count -->
                        <div class="row match-height">
                            <?php 
                            function get_orders_count($meta_value){
                                $args = array(
                                    'post_type'   => 'total_sales',
                                    'post_status' => 'publish',
                                    'meta_query'  => array(
                                        'relation' => 'AND',
                                        array(
                                            'key'   => 'type',
                                            'value' => $meta_value,
                                        ),
                                        array(
                                            'key'   => 'vendor_id',
                                            'value' => get_current_user_id(),
                                        ),
                                    ),
                                );
                                $order_count = new WP_Query($args);
                                return count($order_count->posts); 
                            }
                           ?>
                            <div class="col-lg-12 col-12">
                                <div class="row match-height">
                                    <!-- Bar Chart - Creations Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Creation Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('creations') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Creations Orders -->

                                    <!-- Bar Chart - Stl Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>STL Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('stl-library') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Stl Orders -->

                                    <!-- Bar Chart - Services Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Services Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('services') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Services Orders -->

                                   
                                    <!-- Bar Chart - Print on demand Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Print on demand Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('print-on-demand') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Print on demand Orders -->

                                    <!-- Bar Chart - Service on demand Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Service on demand Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('service-on-demand') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Print on demand Orders -->

                                    <!-- Bar Chart - Bulk Orders -->
                                    <div class="col-lg-2 col-md-3 col-6">
                                        <div class="card">
                                            <div class="card-body pb-50" style="position: relative;">
                                                <h6>Bulk Orders</h6>
                                                <h2 class="fw-bolder mb-1"><?= get_orders_count('bulk-manufacturing') ?></h2>
                                                <div id="order-chart" style="min-height: 85px;"><div id="apexcharts0ck24ab1" class="apexcharts-canvas apexcharts0ck24ab1 apexcharts-theme-light" style="width: 135px; height: 70px;"><svg id="SvgjsSvg2264" width="135" height="70" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG2266" class="apexcharts-inner apexcharts-graphical" transform="translate(13.5, 15)"><defs id="SvgjsDefs2265"><linearGradient id="SvgjsLinearGradient2269" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop2270" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop2271" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop2272" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask0ck24ab1"><rect id="SvgjsRect2274" width="139" height="55" x="-11.5" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask0ck24ab1"><rect id="SvgjsRect2275" width="120" height="59" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect2273" width="5.8" height="55" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient2269)" class="apexcharts-xcrosshairs" y2="55" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG2289" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG2290" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG2292" class="apexcharts-grid"><g id="SvgjsG2293" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine2295" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2296" x1="-9.5" y1="11" x2="125.5" y2="11" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2297" x1="-9.5" y1="22" x2="125.5" y2="22" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2298" x1="-9.5" y1="33" x2="125.5" y2="33" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2299" x1="-9.5" y1="44" x2="125.5" y2="44" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine2300" x1="-9.5" y1="55" x2="125.5" y2="55" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG2294" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine2302" x1="0" y1="55" x2="116" y2="55" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine2301" x1="0" y1="1" x2="0" y2="55" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG2276" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG2277" class="apexcharts-series" seriesName="2020" rel="1" data:realIndex="0"><rect id="SvgjsRect2279" width="5.8" height="55" x="-2.9" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2280" d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z" pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55" cy="30.25" cx="2.9000000000000012" j="0" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2281" width="5.8" height="55" x="26.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2282" d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z" pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55" cy="8.25" cx="31.900000000000002" j="1" val="85" barHeight="46.75" barWidth="5.8"></path><rect id="SvgjsRect2283" width="5.8" height="55" x="55.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2284" d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z" pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55" cy="19.25" cx="60.89999999999999" j="2" val="65" barHeight="35.75" barWidth="5.8"></path><rect id="SvgjsRect2285" width="5.8" height="55" x="84.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2286" d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z" pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55" cy="30.25" cx="89.89999999999999" j="3" val="45" barHeight="24.75" barWidth="5.8"></path><rect id="SvgjsRect2287" width="5.8" height="55" x="113.1" y="0" rx="5" ry="5" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#f3f3f3" class="apexcharts-backgroundBar"></rect><path id="SvgjsPath2288" d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" fill="rgba(255,159,67,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask0ck24ab1)" pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z" pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55" cy="19.25" cx="118.89999999999999" j="4" val="65" barHeight="35.75" barWidth="5.8"></path></g><g id="SvgjsG2278" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine2303" x1="-9.5" y1="0" x2="125.5" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine2304" x1="-9.5" y1="0" x2="125.5" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG2305" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG2306" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG2307" class="apexcharts-point-annotations"></g><rect id="SvgjsRect2308" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect2309" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><g id="SvgjsG2291" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG2267" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 35px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 178px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
                                        </div>
                                    </div>
                                    <!--/ Bar Chart - Print on demand Orders -->

                                </div>
                            </div>
                        </div>

                        <div class="row match-height">
                           

                            <!-- Services Revenue Report Card -->
                            <div class="col-lg-6 col-12">
                                <div class="card card-revenue-budget">
                                    <div class="row mx-0">
                                        <div class="col-md-12 col-12 revenue-report-wrapper">
                                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                                <h4 class="card-title mb-50 mb-sm-0">Service Bookings Report</h4>
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
                                                        SELECT DATE_FORMAT(p.post_date, '%%Y-%%m') as month, COUNT(p.ID) as order_count
                                                        FROM {$wpdb->posts} p
                                                        JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                                                        WHERE p.post_type = %s
                                                        AND p.post_status IN ('draft', 'publish')
                                                        AND pm.meta_key = %s
                                                        AND pm.meta_value = %s
                                                        AND YEAR(p.post_date) = %d
                                                        GROUP BY DATE_FORMAT(p.post_date, '%%Y-%%m')
                                                        ORDER BY DATE_FORMAT(p.post_date, '%%Y-%%m') ASC
                                                    ", $post_type, 'vendor_id', get_current_user_id(), $current_year);

                                                    
                    
                                                    // Execute the query
                                                    $results = $wpdb->get_results($query);

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

                                                function get_total_amount_sum_by_month_for_current_year($post_type = 'services-order', $meta_key = 'total_price', $vendor_meta_key = 'vendor_id') {
                                                    global $wpdb;

                                                    // Get the current year
                                                    $current_year = date('Y');

                                            

                                                    // Prepare the SQL query to get the sum of total_price grouped by month for the current year
                                                    $query = $wpdb->prepare("
                                                        SELECT DATE_FORMAT(post_date, '%%Y-%%m') as month, SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
                                                        FROM {$wpdb->postmeta} pm
                                                        JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                                                        JOIN {$wpdb->postmeta} pm_vendor ON p.ID = pm_vendor.post_id
                                                        WHERE pm.meta_key = %s
                                                        AND pm_vendor.meta_key = %s
                                                        AND pm_vendor.meta_value = %d
                                                        AND p.post_type = %s
                                                        AND p.post_status IN ('draft', 'publish')
                                                        AND YEAR(p.post_date) = %d
                                                        GROUP BY DATE_FORMAT(p.post_date, '%%Y-%%m')
                                                        ORDER BY DATE_FORMAT(p.post_date, '%%Y-%%m') ASC
                                                    ", $meta_key, $vendor_meta_key, get_current_user_id() ,$post_type, $current_year);

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

                                            <div id="booking-chart"></div>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                            <!--/ Services Report Card -->

                            <!-- Product Revenue Report Card -->
                            <div class="col-lg-6 col-12">
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
                            <!--/ Services Report Card -->
                        </div>
                        

                    
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

            var bookingChartData = <?= json_encode(get_order_count_by_month('services-order')) ?>;
            var revenueChatData = <?= json_encode(get_total_amount_sum_by_month_for_current_year()) ?>;

            var productbookingChartData = <?= json_encode(get_product_order_count_by_month()) ?>;
            var productrevenueChatData = <?= json_encode(get_product_total_amount_sum_by_month_for_current_year()) ?>;


            // console.log("productbookingChartData",productbookingChartData);
            // console.log("productrevenueChatData",productrevenueChatData);
            // var bookingChartData = [];
            // var revenueChatData = [];

            var $bookingChart = document.querySelector('#booking-chart');
            var bookingChart;
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

            bookingChart = new ApexCharts($bookingChart, graphData(bookingChartData,revenueChatData));
            bookingChart.render();

            productChart = new ApexCharts($productChart, graphData(productbookingChartData,productrevenueChatData));
            productChart.render();

        </script>

        
    </body>
    <!-- END: Body-->

<?php } elseif(in_array('customer', $user ->roles)) { ?>

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
                    
                    
                    <section id="dashboard-ecommerce">

                        <!-- Statistics Card -->
                        <div class="row match-height">
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="card card-statistics">
                                    <div class="card-header">
                                        <h4 class="card-title">Order Statistics</h4>
                                    </div>
                                    <div class="card-body statistics-body">
                                        <div class="row">
                                        
                                            <?php 
                                                // function get_order_count($meta_value){
                                                //     $args = array(
                                                //         'post_type'   => 'total_sales',
                                                //         'post_status' => 'publish',
                                                //         'meta_query'  => array(
                                                //             'relation' => 'AND',
                                                //             array(
                                                //                 'key'   => 'type',
                                                //                 'value' => $meta_value,
                                                //             ),
                                                //             array(
                                                //                 'key'   => 'customer_id',
                                                //                 'value' => get_current_user_id(),
                                                //             ),
                                                //         ),
                                                //     );
                                                //     $products = new WP_Query($args);
                                                //     return count($products->posts);
                                                // }
                                                function get_order_count($meta_value) {
                                                    global $wpdb;
                                                
                                                    // Query to count unique orders with the same reference_order_id for the given customer and type
                                                    $query = $wpdb->prepare("
                                                        SELECT COUNT(DISTINCT p.ID)
                                                        FROM {$wpdb->posts} p
                                                        INNER JOIN {$wpdb->postmeta} pm1 ON p.ID = pm1.post_id
                                                        INNER JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id
                                                        INNER JOIN {$wpdb->postmeta} pm3 ON p.ID = pm3.post_id
                                                        WHERE p.post_type = 'total_sales'
                                                        AND p.post_status = 'publish'
                                                        AND pm1.meta_key = 'type' 
                                                        AND pm1.meta_value = %s
                                                        AND pm2.meta_key = 'customer_id'
                                                        AND pm2.meta_value = %d
                                                        AND pm3.meta_key = 'reference_order_id'
                                                    ", $meta_value, get_current_user_id());
                                                
                                                    // Execute the query and get the count of unique orders by reference_order_id
                                                    $order_count = $wpdb->get_var($query);
                                                
                                                    return $order_count;
                                                }
                                            ?>
                                            <!-- Creations -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="figma" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_order_count('creations') ?></h4>
                                                        <p class="card-text stats mb-0">Creations</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- STL Library -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="package" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_order_count('stl-library') ?></h4>
                                                        <p class="card-text stats mb-0">STL Library</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Services -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="layout" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_order_count('services') ?></h4>
                                                        <p class="card-text stats mb-0">Services</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Print On Demand -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="book" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_order_count('print-on-demand') ?></h4>
                                                        <p class="card-text stats mb-0">Print On Demand</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Service On Demand -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="compass" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_order_count('service-on-demand') ?></h4>
                                                        <p class="card-text stats mb-0">Service On Demand</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Bulk -->
                                            <div class="col-xl-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                                <div class="d-flex flex-row">
                                                    <div class="avatar bg-light-success me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="database" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto">
                                                        <h4 class="fw-bolder mb-0"><?= get_order_count('bulk-manufacturing') ?></h4>
                                                        <p class="card-text stats mb-0">Bulk Manufacturing</p>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Statistics Card -->
                    
                        <div class="row match-height">
                        
                            <!-- Services Revenue Report Card -->
                            <div class="col-lg-6 col-12">
                                <div class="card card-revenue-budget">
                                    <div class="row mx-0">
                                        <div class="col-md-12 col-12 revenue-report-wrapper">
                                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                                <h4 class="card-title mb-50 mb-sm-0">Service Bookings Report</h4>
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
                                                        AND post_status IN ('draft', 'publish')
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

                                                function get_total_amount_sum_by_month_for_current_year($post_type = 'services-order', $meta_key = 'total_price') {
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
                                                        AND p.post_status IN ('draft', 'publish')
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

                                            <div id="booking-chart"></div>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                            <!--/ Services Report Card -->

                            <!-- Orders Revenue Report Card -->
                            <div class="col-lg-6 col-12">
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

            var bookingChartData = <?= json_encode(get_order_count_by_month('services-order')) ?>;
            var revenueChatData = <?= json_encode(get_total_amount_sum_by_month_for_current_year()) ?>;

            var productbookingChartData = <?= json_encode(get_product_order_count_by_month()) ?>;
            var productrevenueChatData = <?= json_encode(get_product_total_amount_sum_by_month_for_current_year()) ?>;


            console.log("productbookingChartData",productbookingChartData);
            console.log("productrevenueChatData",productrevenueChatData);
            // var bookingChartData = [];
            // var revenueChatData = [];

            var $bookingChart = document.querySelector('#booking-chart');
            var bookingChart;
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

            bookingChart = new ApexCharts($bookingChart, graphData(bookingChartData,revenueChatData));
            bookingChart.render();

            productChart = new ApexCharts($productChart, graphData(productbookingChartData,productrevenueChatData));
            productChart.render();

        </script>

        
    </body>
    <!-- END: Body-->

<?php } ?>