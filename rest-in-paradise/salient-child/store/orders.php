<?php /* Template Name: All Orders */ ?>
<?php include "includes/styles.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">

    <!-- datepicker -->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/pickadate/pickadate.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/pickers/form-pickadate.css">
    <style>
   
        .card-body.border-bottom {
            display: flex;
            justify-content: space-between;
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
                            <h2 class="card-title">Orders</h2>
                       
                            <?php
                                $current_date = date('Y-m-d');
                                $date_before_10_days = date('Y-m-d', strtotime('-10 days'));
                            ?>
                            <form class="dateFilter row" action="" method="POST">
                                
                                <div class="col-3">
                                    <label class="col-form-label" for="fp-range">Date Range: </label>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="fp-range" name="date" class="form-control flatpickr-range flatpickr-input" value="<?= isset($_POST['date']) ? $_POST['date'] : $current_date . ' to ' . $date_before_10_days ?>" placeholder="YYYY-MM-DD to YYYY-MM-DD" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Filter</button>
                                </div>
                            </form>
                        </div>
                        <!-- Filter -->

                        <?php //if(in_array('administrator', wp_get_current_user()->roles) || in_array('vendor', wp_get_current_user()->roles)) { ?>
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
                                        <?php if(!in_array('customer', wp_get_current_user()->roles)) { ?>
                                            <th>Admin Commision</th>
                                        <?php } ?>
                                        <!-- <th>Earnings</th> -->
                                        <!-- <th>Delivered In</th> -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Ensure WooCommerce is active
                                        if (class_exists('WooCommerce')) {

                                            // Get the current user ID
                                            $current_user_id = get_current_user_id();
                                           

                                            $args = [
                                                'limit' => -1, // Adjust the number of orders to display
                                                'orderby' => 'date',
                                                'order' => 'DESC',
                                                'status' => ['wc-completed','wc-pending', 'wc-hold', 'wc-processing'],
                                                'date_query'     => array(
                                                    array(
                                                        'after'     => $date_before_10_days,
                                                        'before'    => $current_date,
                                                        'inclusive' => true,
                                                    ),
                                                ),
                                            ];

                                            if(isset($_GET['status'])){
                                                $args['status'] = [$_GET['status']];
                                            }

                                            // Check if the 'date' parameter exists in the URL
                                            if (isset($_POST['date'])) {
                                                // Extract start and end dates from the URL parameter
                                                $date_range = explode(' to ', sanitize_text_field($_POST['date']));
                                                
                                                if (count($date_range) == 2) {
                                                    // If both start and end dates are provided in the range
                                                    $start_date = $date_range[0];
                                                    $end_date   = $date_range[1];

                                                    // Add meta query to filter by date range
                                                    $args['date_query'] = array(
                                                        array(
                                                            'after'     => $start_date,
                                                            'before'    => $end_date,
                                                            'inclusive' => true,
                                                        ),
                                                    );
                                                } 
                                            }

                                            if(in_array('administrator', wp_get_current_user()->roles)) { 

                                                $args['meta_query'][] = [
                                                    'key' => 'usertype',
                                                    'value' => 'seller',
                                                    'compare' => '='
                                                ];
                                               
                                            } elseif(in_array('vendor', wp_get_current_user()->roles))  {

                                                $args['meta_query'][] = [
                                                    'key' => '_seller_id',
                                                    'value' => $current_user_id,
                                                    'compare' => '='
                                                ];
                                            }
                                            elseif(in_array('customer', wp_get_current_user()->roles))  {

                                                $args['meta_query'][] = [
                                                    'key' => 'customer_id',
                                                    'value' => $current_user_id,
                                                    'compare' => '='
                                                ];
                                            }


                                            // Get the parent category term ID from the URL parameter
                                            if (isset($_GET['type'])) {
                                                $parent_category_slug = sanitize_text_field($_GET['type']);
                                                $parent_category = get_term_by('slug', $parent_category_slug, 'product_cat');

                                                // If the category exists, get all child categories including the parent
                                                if ($parent_category) {
                                                    $category_ids = get_term_children($parent_category->term_id, 'product_cat');
                                                    $category_ids[] = $parent_category->term_id; // Include the parent category
                                                }
                                            }

                                            $orders = wc_get_orders($args);
                                            //  var_dump($orders);

                                            if (!empty($orders)) {
                                                foreach ($orders as $order) {
                                                    $order_id = $order->get_id();
                                                    $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                                                    $order_status = $order->get_status();
                                                    $order_status_name = wc_get_order_status_name($order_status);
                                                    // $order_total = $order->get_total();
                                                    $order_date = $order->get_date_created();
                                                    // $order_completed = get_post_meta($order_id, 'order_completed', true);
                                                    // if($order_completed){
                                                    //     $date1 = new DateTime($order_date);
                                                    //     $date2 = new DateTime($order_completed);
                                                    //     $interval = $date1->diff($date2);
            
                                                    //     $days_difference = $interval->days;
                                                    // }
                                                    // Get purchased items
                                                    $items = $order->get_items();
                                                    $category_total = 0;
                                                    $purchased_items = '';

                                                    foreach ($items as $item) {
                                                        $product_id = $item->get_product_id();
                                                        $product_categories = wc_get_product_term_ids($product_id, 'product_cat');

                                                        // Check if the product belongs to the specified category or its children
                                                        if (!empty($category_ids) && array_intersect($category_ids, $product_categories)) {
                                                            $purchased_items .= $item->get_name() . ' x ' . $item->get_quantity() . ', ';
                                                            // Calculate total for matching category items only
                                                            $category_total += $item->get_total();
                                                            // $order->get_meta_data('commission_amount');
                                                        }
                                                    }
                                                    // Skip the order if no items match the category filter
                                                    if (empty($purchased_items)) {
                                                        continue;
                                                    }

                                                    $purchased_items = rtrim($purchased_items, ', ');

                                                    // Determine badge class based on status
                                                    $status_classes = array(
                                                        'pending' => 'warning',
                                                        'completed' => 'success',
                                                    );
                                                    $badge_class = isset($status_classes[$order_status]) ? $status_classes[$order_status] : 'info';
                                                    if($order_status_name == 'Pending payment'){
                                                        $order_status_name =    'Pending';
                                                    }

                                                    // var_dump($order->get_meta('commission_amount'));

                                                    ?>

                                                    <tr>
                                                    <td class="order_name fw-bold"><?= esc_html($order_id) ?></td>
                                                    <td class="order_date"><?=  esc_html(wc_format_datetime($order->get_date_created())) ?></td>
                                                    <td><span class="badge badge-light-<?=  esc_attr($badge_class) ?>"><?=  esc_html($order_status_name) ?></span></td>
                                                    <td class="customer_name"><?=  esc_html($customer_name) ?></td>
                                                    <td class="purchased_name"><?=  esc_html($purchased_items) ?></td>
                                                    <td class="order_total fw-bold">$<?=  number_format($category_total, 2)  ?></td>
                                                    <?php if(!in_array('customer', wp_get_current_user()->roles)) { ?>
                                                    <td class="earnings fw-bold">$<?=  number_format($order->get_meta('commission_amount'), 2) ?></td>
                                                    <?php } ?>
                                                    <!-- <td><?= !empty($days_difference) ? $days_difference. " Days" : "---" ?></td> -->

                                                    <td><a href="<?=  esc_url(home_url('order-details/?order_id=' . $order_id.'&type='.$_GET['type'])) ?>" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="View Order">View Order</a></td>
                                                    </tr>
                                                <?php }
                                            } 
                                        } else {
                                            echo '<tr><td colspan="8">WooCommerce is not active.</td></tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <?php //} ?>
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

    <!-- Date picker -->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/pickers/form-pickers.js"></script>

    <script>
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

            $(document).on("change", "select[name='customer_order_status']", function(e) {
                if (confirm("Are you sure?")) {
                    var id = $(this).attr('data-id');
                    var customer_order_status = $(this).val();
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
                            action: 'update_order_status_by_customer',
                            order_id: id,
                            customer_order_status: customer_order_status,
                        },
                        dataType: 'json',
                        success: function(response) {
                            jQuery('body').waitMe('hide');
                            // console.log(response);
                            if(!response.status){
                                toastr.error(response.message, response.title);
                            } else {
                                toastr.success(response.message, response.title);
                                thiss.parents('td').html(response.customer_order_status);
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

</html>