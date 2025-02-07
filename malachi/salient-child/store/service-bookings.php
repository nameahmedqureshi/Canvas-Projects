<?php /* Template Name: Service All Bookings */ ?>
<!-- BEGIN: Head-->

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
        .card-body.dd {
            display: flex;
            justify-content: space-between;
        }
        td.remaining {
            color: red !important;
            font-weight: bold;
        }
        .instructions {
            padding: 20px;
        }

        .instructions  p {
            font-size: 12px;
            font-weight:bold
        }
        td.ship {
            margin-top: 12px;
        
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
                        <div class="card-body dd">
                            <h2 class="card-title">Bookings</h2>
                            <?php
                            $current_date = date('Y-m-d');
                            $date_before_10_days = date('Y-m-d', strtotime('-10 days'));
                            ?>
                            <!-- <div class="card-body border-bottom"> -->
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
                            <!-- </div> -->
                            <!-- Filter -->
                        </div>
                        <!-- admin -->
                        <?php if(in_array('administrator', wp_get_current_user()->roles) ) { 
                        
                            $args = [
                                'post_type'      => 'services-order',
                                'posts_per_page' => -1,
                                'post_status' => 'any',
                                'date_query'     => array(
                                    array(
                                        'after'     => $date_before_10_days,
                                        'before'    => $current_date,
                                        'inclusive' => true,
                                    ),
                                ),
                            ];

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
                         
                            $services = new WP_Query($args);
                        ?>
                        <div class="instructions border-bottom col-12">
                            <p>Note: "Shipping status highlighted in green means the customer has confirmed delivery, while yellow indicates delivery is not yet confirmed."</p>
                            <span class="badge bg-success">Customer Received</span>  <span class="badge bg-warning">Customer Not Received</span> 
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Booking No</th>
                                        <!-- <th>Type</th> -->
                                        <th>Service</th>
                                        <!-- <th>Vendor</th> -->
                                        <th>Customer</th>
                                        <!-- <th>Amount </th> -->
                                        <!-- <th>Vendor Received</th> -->
                                        <th>Remaining</th>
                                        <th>Commision</th>
                                        <th>Total </th>
                                        <th>Payment Status </th>
                                        <th>Shipping Status</th>
                                        <th>Delivered In</th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services->posts as $key => $value) { 
                                       
                                       $payment_status = get_post_meta($value->ID, 'payment_status', true);
                                    //    $vendor_id =  get_post_meta($value->ID, 'vendor_id', true);
                                       $total_price =  get_post_meta($value->ID, 'total_price', true);
                                       $remaining =  get_post_meta($value->ID, 'pending_payment', true);
                                        //    $vendor =  new WP_User( $vendor_id ); 
                                       $customer_id = get_post_meta($value->ID, 'customer_id', true);
                                       $order_date = get_post_meta($value->ID, 'order_date', true);
                                       $order_completed = get_post_meta($value->ID, 'order_completed', true);
                                       $pending_balance = get_post_meta($value->ID, 'pending_balance', true);
                                    //    $type = get_post_meta($value->ID, 'type', true);
                                       $customer_order_status = get_post_meta($value->ID, 'customer_order_status', true);
                                       $admin_commission = get_post_meta($value->ID, 'commission_amount', true);

                                       if($order_completed){
                                            $date1 = new DateTime($order_date);
                                            $date2 = new DateTime($order_completed);
                                            // Calculate the difference
                                            $interval = $date1->diff($date2);

                                            // Get the difference in days
                                            $days_difference = $interval->format('%d days');
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $value->ID ?></td>
                                            <!-- <td><?= $type ?> </td> -->
                                            <td><?= get_post_meta($value->ID, 'service_name', true) ?></td>
                                            <!-- <td><?= get_post_meta($value->ID, 'vendor_name', true) ?></td> -->
                                            <td><?=  get_post_meta($value->ID, 'customer_name', true) ?></td>
                                            <td class="<?= !empty($remaining) ? 'remaining' : '' ?>">$<?= !empty($remaining) ?  number_format( $remaining, 2) : number_format( '0', 2);  ?></td>
                                            <td>$<?= number_format( $admin_commission, 2); ?></td>
                                            <td>$<?= number_format( $total_price, 2); ?></td>
                                            <td><?= $pending_balance ? 'Partial' : 'Completed' ?></td>
                                            
                                            <td class="ship <?= $customer_order_status && $value->post_status == 'publish' ? 'badge badge-light-success' : ($value->post_status == 'publish' ? 'badge badge-light-warning' : '') ?>">
                                                <?= $value->post_status == 'publish' ? 'Delivered' : '
                                                <select class="form-select" name="shipping_status" data-id="' . $value->ID . '" customer-id="' . $customer_id . '">
                                                    <option value="pending">Pending</option>
                                                    <option value="publish">Delivered</option>
                                                </select>' ?>

                                            </td>
                                            
                                            <td><?=  $days_difference == '0 days' ? '1 days' : $days_difference ?></td>
                                            <td>
                                                <a href="<?= home_url('service-invoice/?id='.$value->ID.'&type='.$_GET['type']) ?>" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Invoice">
                                                    <i data-feather='list'></i>
                                                </a> 
                                                <?php $current_user = wp_get_current_user(); if(in_array('administrator', $current_user->roles)) { ?>
                                                <a href="#!" class="delete-record" data-id=<?= $value->ID ?> data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete value">
                                                    <i data-feather='trash-2'></i>
                                                </a>
                                                <?php } ?>
                                            </td>
                                        </tr>

                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>


                        <!-- Vendor -->
                        <?php if(in_array('vendor', wp_get_current_user()->roles) ) { 
                            
                          

                            $args = [
                                'post_type'      => 'services-order',
                                'posts_per_page' => -1,
                                'post_status'    => 'any',
                                'date_query'     => array(
                                    array(
                                        'after'     => $date_before_10_days,
                                        'before'    => $current_date,
                                        'inclusive' => true,
                                    ),
                                ),
                                'meta_query'     => [
                                    'relation' => 'AND',  // Ensures both conditions must be met
                                    [
                                        'key'     => 'vendor_id',
                                        'value'   => get_current_user_id(),
                                        'compare' => '='
                                    ],
                                    [
                                        'key'     => 'type',
                                        'value'   => $_GET['type'] ?? 'quick-service',
                                        'compare' => '='
                                    ]
                                ]
                            ];

                            if($_GET['status'] == 'pending'){
                                $args['post_status']  = 'draft';
                            } elseif($_GET['status'] == 'completed'){
                                $args['post_status']  = 'publish';
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
                            
                        
                            $services = new WP_Query($args);
                        ?>
                        <div class="instructions border-bottom col-12">
                            <p>Note: "Shipping status highlighted in green means the customer has confirmed delivery, while yellow indicates delivery is not yet confirmed."</p>
                            <span class="badge bg-success">Customer Received</span>  <span class="badge bg-warning">Customer Not Received</span> 
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Booking No</th>
                                        <!-- <th>Type</th> -->
                                        <th>Service</th>
                                        <!-- <th>Vendor</th> -->
                                        <th>Customer</th>
                                        <!-- <th>Vendor Received</th> -->
                                        <th>Remaining</th>
                                        <th>Admin Commision</th>
                                        <th>Total </th>
                                        <th>Payment Status </th>
                                        <th>Shipping Status</th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services->posts as $key => $value) { 
                                    
                                    $payment_status = get_post_meta($value->ID, 'payment_status', true);
                                    // $vendor_id =  get_post_meta($value->ID, 'vendor_id', true);
                                    $total_price =  get_post_meta($value->ID, 'total_price', true);
                                    // $vendor =  new WP_User( $vendor_id ); 
                                    $customer_id = get_post_meta($value->ID, 'customer_id', true);
                                    $remaining =  get_post_meta($value->ID, 'pending_payment', true);
                                    // $type = get_post_meta($value->ID, 'type', true);
                                    $pending_balance = get_post_meta($value->ID, 'pending_balance', true);
                                    $customer_order_status = get_post_meta($value->ID, 'customer_order_status', true);
                                    $admin_commission = get_post_meta($value->ID, 'commission_amount', true);


                                    ?>
                                        <tr>
                                            <td><?= $value->ID ?></td>
                                            <!-- <td><?= !empty($type) ? $type : '---' ?> </td> -->
                                            <td><?= get_post_meta($value->ID, 'service_name', true) ?></td>
                                            <!-- <td><?= get_post_meta($value->ID, 'vendor_name', true) ?></td> -->
                                            <td><?=  get_post_meta($value->ID, 'customer_name', true) ?></td>
                                            <td class="<?= !empty($remaining) ? 'remaining' : '' ?>">$<?= !empty($remaining) ?  number_format( $remaining, 2) : number_format( '0', 2);  ?></td>
                                            <td>$<?= number_format( $admin_commission, 2); ?></td>
                                            <td>$<?= number_format( $total_price, 2); ?></td>
                                            <td><?= $pending_balance ? 'Partial' : 'Completed' ?></td>
                                            <td class="ship <?= $customer_order_status && $value->post_status == 'publish' ? 'badge badge-light-success' : ($value->post_status == 'publish' ? 'badge badge-light-warning' : '') ?>">
                                                <?= $value->post_status == 'publish' ? 'Delivered' : '
                                                <select class="form-select" name="shipping_status" data-id="' . $value->ID . '" customer-id="' . $customer_id . '">
                                                    <option value="pending">Pending</option>
                                                    <option value="publish">Delivered</option>
                                                </select>' ?>
                                            </td>

                                            <td>
                                                <a href="<?= home_url('service-invoice/?id='.$value->ID.'&type='.$_GET['type']) ?>" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Invoice">
                                                    <i data-feather='list'></i>
                                                </a> 
                                                <!-- <a href="<?= home_url('chat/?id='.$customer_id.'&type=service-booking') ?>" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Chat">
                                                    <i data-feather='message-square'></i>
                                                </a>  -->
                                                <?php $current_user = wp_get_current_user(); if(in_array('administrator', $current_user->roles)) { ?>
                                                <a href="#!" class="delete-record" data-id=<?= $value->ID ?> data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete value">
                                                    <i data-feather='trash-2'></i>
                                                </a>
                                                <?php } ?>
                                            </td>
                                        </tr>

                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>

                        <!-- customer -->
                        <?php if(in_array('customer', wp_get_current_user()->roles) ) { 
                           
                            $args = [
                                'post_type'      => 'services-order',
                                'posts_per_page' => -1,
                                'post_status'    => 'any',
                                'date_query'     => array(
                                    array(
                                        'after'     => $date_before_10_days,
                                        'before'    => $current_date,
                                        'inclusive' => true,
                                    ),
                                ),
                                'meta_query'     => [
                                    'relation' => 'AND',  // Ensures both conditions must be met
                                    [
                                        'key'     => 'customer_id',
                                        'value'   => get_current_user_id(),
                                        'compare' => '='
                                    ],
                                    [
                                        'key'     => 'type',
                                        'value'   => $_GET['type'] ?? 'quick-service',
                                        'compare' => '='
                                    ]
                                ]
                            ];

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
                            $services = new WP_Query($args);

                        ?>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Booking No</th>
                                        <th>Service</th>
                                        <th>Vendor</th>
                                        <th>Amount </th>
                                        <th>Remaining</th>
                                        <th>Date</th>
                                        <th>Shipping Status</th>
                                        <th>Received Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services->posts as $key => $value) { 
                                       
                                       $payment_status = get_post_meta($value->ID, 'payment_status', true);
                                       $vendor_id =  get_post_meta($value->ID, 'vendor_id', true);
                                       $total_price = get_post_meta($value->ID, 'total_price', true);
                                       $customer_order_status = get_post_meta($value->ID, 'customer_order_status', true);
                                       $remaining =  get_post_meta($value->ID, 'pending_payment', true);

                                    //    $vendor =  new WP_User( $vendor_id ); 
                                    ?>
                                        <tr>
                                            <td><?= $value->ID ?></td>
                                            <td><?= get_post_meta($value->ID, 'service_name', true) ?></td>
                                            <td><?= get_post_meta($value->ID, 'vendor_name', true) ?></td>
                                            <td>$<?= number_format( $total_price, 2); ?></td>
                                            <td class="<?= !empty($remaining) ? 'remaining' : '' ?>">$<?= !empty($remaining) ?  number_format( $remaining, 2) : number_format( '0', 2);  ?></td>

                                            <td><?= date('d F Y', strtotime($value->post_date)) ?></td>
                                            <td>
                                                <?= $value->post_status == 'publish' ? 'Delivered' : 'Pending' ?>
                                               
                                            </td>
                                            <td>
                                                <?= $customer_order_status == 'received' ? 'Received' : '
                                                <select class="form-select" name="customer_order_status" data-id="' . $value->ID . '">
                                                    <option value="not-received">Not Received</option>
                                                    <option value="received">Received</option>
                                                </select>' ?>
                                            </td>

                                            <td>
                                                <a href="<?= home_url('service-invoice/?id='.$value->ID.'&type='.$_GET['type']) ?>" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Invoice">
                                                    <i data-feather='list'></i>
                                                </a> 
                                                
                                                <?php $current_user = wp_get_current_user(); if(in_array('administrator', $current_user->roles)) { ?>
                                                <a href="#!" class="delete-record" data-id=<?= $value->ID ?> data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete value">
                                                    <i data-feather='trash-2'></i>
                                                </a>
                                                <?php } ?>
                                            </td>
                                        </tr>

                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>

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

            $(document).on("change", "select[name='shipping_status']", function(e) {
                if (confirm("Are you sure?")) {
                    var id = $(this).attr('data-id');
                    var customer_id = $(this).attr('customer-id');
                    var shipping_status = $(this).val();
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
                            action: 'update_shipping_status',
                            service_id: id,
                            shipping_status: shipping_status,
                            customer_id: customer_id,
                        },
                        dataType: 'json',
                        success: function(response) {
                            jQuery('body').waitMe('hide');
                            // console.log(response);
                            if(!response.status){
                                toastr.error(response.message, response.title);
                            } else {
                                toastr.success(response.message, response.title);
                                thiss.parents('.ship').addClass('badge badge-light-warning').text('Delivered');
                                // thiss.parents('.ship').addClass('badge badge-light-warning');

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
                            action: 'update_status_by_customer',
                            service_id: id,
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