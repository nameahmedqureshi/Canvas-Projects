<?php /* Template Name: service view orders */ 
$post_id = $_GET["id"];
$post_data = get_post($post_id);
$meta_data = get_post_meta($post_id);

// echo "<pre>";
// var_dump($meta_data);
?>
<!-- <!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr"> -->
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>


<!-- END: Head-->
<?php include "includes/header.php"; ?>


<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Main Menu-->
   <?php include "includes/manu.php"; ?>
  <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <!-- END: Main Menu-->
<style>
    .order-card .card-body h5 {
        margin-top: 30px;
        font-size: 25px;
        color: #000;
        margin-bottom: 20px;
        text-decoration: underline;
    }
    .order-card .card-body h5 {
        margin-top: 30px;
    }
    .content-body {
        padding: 20px;
    }
    .order-card {
        margin-bottom: 20px;
    }
    .order-card .card-header {
        background-color: #343a40;
        color: #fff;
    }
    .order-card .card-body {
        background-color: #e9ecef;
    }
    .order-card .card-body h5 {
        font-weight: bold;
    }

    table tr th:first-child {
        width:30%
    }
</style>
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title text-center">Order Details</h2>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mb-3">
                                <h4 class="card-title">Service Information</h4>
                                <table class="table table-bordered text-nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Service</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="text-start">Booking ID</th>
                                            <td><?= $post_id ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Service Date</th>
                                            <td><?= date('d M Y', strtotime(get_post_meta($post_id, 'date', true))) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Status</th>
                                            <td><?= get_post_meta($post_id, 'order_status', true) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Garage Location</th>
                                            <td><?php 
                                            $garage = get_post_meta($post_id, 'garage_location', true);
                                            echo garage_name($garage);
                                             ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Type</th>
                                            <td><?= get_post_meta($post_id, 'type', true) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Classification</th>
                                            <td><?= !empty(get_post_meta($post_id, 'classification', true)) ? get_post_meta($post_id, 'classification', true) : '----' ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Client Requests</th>
                                            <td><?= !empty(apply_filters('the_content', get_post_field('post_content', $post_id))) ? apply_filters('the_content', get_post_field('post_content', $post_id)) : '----' ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Booking Date</th>
                                            <td><?= date('d M Y h:i A', strtotime($post_data->post_date)) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Pickup Time</th>
                                            <td><?= !empty(get_post_meta($post_id, 'pickup_time', true)) ? get_post_meta($post_id, 'pickup_time', true) : '----' ?></td>
                                        </tr>
                                        <!-- <tr>
                                            <th scope="row" class="text-start">Current Date</th>
                                            <td><?= date('d M Y h:i A') ?></td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>

                            <?php 
                            $order_summary = get_post_meta($post_id, 'order_summary', true);
                            if( !empty($order_summary) ){ ?>

                                <div class="table-responsive mb-3">
                                    <h4 class="card-title">Services</h4>
                                    <table class="table table-bordered text-nowrap text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            foreach($order_summary as $val) { 
                                                // var_dump($val); 
                                                ?>
                                            
                                            <tr>
                                                <th scope="row" class="text-start"><?= $val["title"] ?></th>
                                                <td>$<?= $val["price"] ?></td>
                                            </tr>
                                            <?php } ?>

                                            <tr>
                                                <th scope="row" class="text-start">Tip</th>
                                                <td>$<?= !empty(get_post_meta($post_id, 'tip_price',true)) ? get_post_meta($post_id, 'tip_price',true) : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="text-start">Total</th>
                                                <td>$<?= get_post_meta($post_id, 'total_price', true) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>

                            <div class="table-responsive mb-3">
                                <h4 class="card-title">Vehicle Information</h4>
                                <table class="table table-bordered text-nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Vehicle</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="text-start">Vehicle License Plate</th>
                                            <td> <?= get_the_title($post_id) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Make</th>
                                            <td><?= get_post_meta($post_id, 'make', true) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Model</th>
                                            <td><?= get_post_meta($post_id, 'model', true) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Year</th>
                                            <td><?= get_post_meta($post_id, 'year', true) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive mb-3">
                                <h4 class="card-title">User Information</h4>
                                <table class="table table-bordered text-nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">User</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="text-start">User Type</th>
                                            <td><?= !empty(get_post_meta($post_id, 'user_buying_type', true)) ? get_post_meta($post_id, 'user_buying_type', true) : '----' ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">First Name</th>
                                            <td><?= get_post_meta($post_id, 'first_name', true) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Last Name</th>
                                            <td><?= !empty(get_post_meta($post_id, 'last_name', true) ) ? get_post_meta($post_id, 'last_name', true) : '----' ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">User Email</th>
                                            <td><?= !empty(get_post_meta($post_id, 'user_email', true)) ? get_post_meta($post_id, 'user_email', true) : '----' ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Phone Number</th>
                                            <td><?= get_post_meta($post_id, 'number', true) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Type</th>
                                            <td><?= !empty(get_post_meta($post_id, 'usertype', true)) ? get_post_meta($post_id, 'usertype', true) : '----' ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Panther ID Number</th>
                                            <td><?= !empty(get_post_meta($post_id, 'panther_id', true)) ? get_post_meta($post_id, 'panther_id', true) : '----' ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Classification</th>
                                            <td><?= !empty(get_post_meta($post_id, 'classification', true)) ? get_post_meta($post_id, 'classification', true) : '----' ?></td>
                                        </tr>
                                    </tbody>
                                </table>
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

   
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

    <?php include "includes/scripts.php"; ?>

</body>
<!-- END: Body-->

<!-- </html> -->