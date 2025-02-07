<?php 
/* Template Name: Orders */
include "includes/styles.php";?>
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
            background-color: #577226;
            border-color: #577226;
        }
        button.dt-button.add-new.btn.btn-primary {
            padding: 10px;
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
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="app-user-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h2>Orders</h2>
                            <div class="row">
                                <div class="col-md-4 user_role"></div>
                                <div class="col-md-4 user_plan"></div>
                                <div class="col-md-4 user_status"></div>
                            </div>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <div class="table-responsive">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Customer</th>
                                        <th>Purchased</th>
                                        <th>Order Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Ensure WooCommerce is active
                                    if (class_exists('WooCommerce')) {

                                        // Get the current user ID
                                        $current_user_id = get_current_user_id();

                                        // Get orders
                                        if(in_array('administrator',wp_get_current_user()->roles)){
                                            $args = array(
                                                'limit' => -1, // Adjust the number of orders to display
                                                'orderby' => 'date',
                                                'order' => 'DESC',
                                            );
                                        } else {
                                            $args = array(
                                                'limit' => -1, // Adjust the number of orders to display
                                                'orderby' => 'date',
                                                'order' => 'DESC',
                                                'customer' => $current_user_id,
                                            );
                                        }

                                       

                                        $orders = wc_get_orders($args);
                                        //var_dump($args);

                                        if (!empty($orders)) {
                                            foreach ($orders as $order) {
                                                $order_id = $order->get_id();
                                                $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                                                $order_status = $order->get_status();
                                                $order_status_name = wc_get_order_status_name($order_status);
                                                $order_total = $order->get_total();
                                                $order_date = wc_format_datetime($order->get_date_created());

                                                // Get purchased items
                                                $items = $order->get_items();
                                                $purchased_items = '';
                                                foreach ($items as $item) {
                                                    // Check if the product belongs to the current user
                                                    $product_user_id = get_post_field('post_author', $item->get_product_id());
                                                    // var_dump($product_user_id);
                                                    // exit;
                                                   // if ($product_user_id == $current_user_id) {
                                                        $purchased_items .= $item->get_name() . ' x ' . $item->get_quantity() . ', ';
                                                   // }
                                                }
                                                $purchased_items = rtrim($purchased_items, ', ');

                                                // If no items belong to the current user, skip displaying this order
                                                if (empty($purchased_items)) {
                                                    continue;
                                                }

                                                // Determine badge class based on status
                                                $status_classes = array(
                                                    'pending' => 'warning',
                                                    'processing' => 'warning',
                                                    'on-hold' => 'warning',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger',
                                                    'refunded' => 'secondary',
                                                    'failed' => 'danger',
                                                );
                                                $badge_class = isset($status_classes[$order_status]) ? $status_classes[$order_status] : 'info';

                                                echo '<tr>';
                                                echo '<td class="order_name fw-bold">#' . esc_html($order_id) . ' ' . esc_html($customer_name) . '</td>';
                                                echo '<td class="order_date">' . esc_html($order_date) . '</td>';
                                                echo '<td><span class="badge badge-light-' . esc_attr($badge_class) . '">' . esc_html($order_status_name) . '</span></td>';
                                                echo '<td class="customer_name">' . esc_html($customer_name) . '</td>';
                                                echo '<td class="purchased_name">' . esc_html($purchased_items) . '</td>';
                                                echo '<td class="order_total fw-bold">' . wp_kses_post(wc_price($order_total)) . '</td>';
                                                echo '<td><a href="' . esc_url(home_url('order-details/?order_id=' . $order_id)) . '" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="View Order">View Order</a></td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="8">No orders found.</td></tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="8">WooCommerce is not active.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div>
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
    <!-- {{-- <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script> --}} -->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>

    <script>
        var table = $('.datatables-basic').DataTable({

           // order: [[1, 'desc']],
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
    </script>
    
</body>
<!-- END: Body-->

</html>