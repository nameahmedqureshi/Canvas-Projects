<?php  /* Template Name:  Print Invoice */ ?>
<?php  include "includes/styles.php"; 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css-rtl/pages/app-invoice.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css-rtl/custom-rtl.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/assets/css/style-rtl.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/app-invoice-print.css">

<!-- END: Page CSS-->
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">

  
    <style>
        img.dark-logo, img.light-logo {
            max-width: 60px !important;
        }
        img.dark-logo, img.light-logo{
            display: none;
        }
        
        html.light-layout.dark-layout img.dark-logo {
            display: none;
        }
        html.dark-layout img.light-logo, html.light-layout.dark-layout img.light-logo{
            display: block;
        }
        html.light-layout img.dark-logo {
            display: block;
        }
        h2.order_item {
            margin-left: 30px;
            margin-bottom: 20px;
        }
        select#status {
            margin-left: 50px;
            margin-top: 10px;
            padding: 4px 0px;
        }
        .order_item_main {
            display: flex;
            align-items: center;
        }
        .order_title {
            margin-left: 15px;
        }
        .extra_fee {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }

        .extra_fee svg {
            transform: scale(2);
            margin-right: 20px;
        }
    </style>

    <!-- BEGIN: Content-->
    <!-- invoice type -->
    <?php if(isset($_GET['type']) &&  $_GET['type'] == 'service') {
    
        $invoice_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ( ! $invoice_id ) {
        echo 'Invalid Invoice ID';
        return;
        }

        $get_invoice_data = get_post($invoice_id);

        if ( ! $get_invoice_data ) {
        echo 'Invoice not found.';
        return;
        }

        $id = $get_invoice_data->ID;
        $service_name = get_post_meta($id, 'service_name', true);
        $description = $get_invoice_data->post_content;
        $creation_date = date('d F Y', strtotime($get_invoice_data->post_date));
        $amount = get_post_meta($id, 'total_price', true);
        $payment_status = get_post_meta($id, 'payment_status', true);
        $user_id = get_post_meta($id, 'vendor_id', true);
        $get_user = get_user_by( 'id', $user_id  );
        // $customer_phone = get_user_meta($user_id, 'ph_num', true);
        $customer_email = $get_user->user_email;
        $fname =  get_user_meta($user_id, 'first_name', true); 
        $lname =  get_user_meta($user_id, 'last_name', true);  
        $customer_name =  sprintf('%s %s',$fname, $lname  );

    ?>
    <div class="app-content content ">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="invoice-print p-3">
                    <div class="invoice-header d-flex justify-content-between flex-md-row flex-column pb-2">
                        <div>
                            <div class="d-flex mb-1">
                                <img class="dark-logo" alt="Kainamo" src="<?= home_url()?>/wp-content/uploads/2024/10/FF-01-001-2048x1328.png">
                                <img class="light-logo" alt="Kainamo" src="<?= home_url()?>/wp-content/uploads/2024/10/FFF-001-002.png"> 
                                <!-- <img src="https://devu11.testdevlink.net/heather/wp-content/uploads/2024/07/ggblack.png" alt="" width="50px" height="50px"> -->
                                <!-- <h3 class="text-primary invoice-logo">Kainamo</h3> -->
                            </div>
                          
                            <!-- <p class="mb-25">LUXURY WITH A GREATER PURPOSE – we are dedicated to sustainability, global awareness,and to shaping a future</p>
                            <p class="mb-25">where luxury and high fashion coexist with environmental and social responsibility.</p> -->
                           
                        </div>
                        <div class="mt-md-0 mt-2">
                            <h4 class="fw-bold text-end mb-1">INVOICE s#<?= $id ?></h4>
                            <div class="invoice-date-wrapper mb-50">
                                <span class="invoice-date-title">Date Issued:</span>
                                <span class="fw-bold"> <?= $creation_date ?></span>
                            </div>
                            
                            <div class="invoice-date-wrapper">
                                <span class="invoice-date-title">Payment Status:</span>
                                <span class="fw-bold"><?= $payment_status == 'succeeded' ? 'Completed' : 'Pending' ?></span>
                            </div>
                            <div class="invoice-date-wrapper">
                                <span class="invoice-date-title">Shipping Status:</span>
                                <span class="fw-bold"><?= $get_invoice_data->post_status == 'publish' ? 'Completed' : 'Pending' ?></span>
                            </div>
                        </div>
                    </div>

                    <hr class="my-2" />

                    <div class="row pb-2">

                    <div class="table-responsive">
                        <h2 class="order_item">Order Items</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="py-1">Item</th>
                                    <th class="py-1">Cost</th>
                                    <th class="py-1">Qty</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="py-1">
                                        <div class="order_item_main">
                                            <div class="order_img">
                                                <?php $product_image_url = get_the_post_thumbnail_url( get_post_meta( $_GET['id'], 'service_id', true) );  ?>
                                                <img src="<?=  !empty($product_image_url) ? $product_image_url  : $directory_url.'/assets/images/no-preview.png' ?>" height="50" width="50" alt="" />
                                            </div>
                                            <div class="order_title">
                                                <p class="card-text fw-bold mb-25"><?= esc_html($service_name); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">$<?=  number_format($amount, 2); ?></span>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">× 1</span>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">$<?=  number_format($amount, 2); ?></span>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>


                    <hr class="my-2" />

                    <div class="row">
                        <div class="col-12">
                            <span class="fw-bold">Note:</span>
                            <span>It was a pleasure working with you. We hope you will keep us in mind. Thank You!</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php } ?>
    <!-- invoice type -->
    <!-- END: Content-->


    <!-- BEGIN: Content-->
    <!-- order type -->
    <?php if(isset($_GET['type']) &&  $_GET['type'] == 'product') {
    
        $invoice_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ( ! $invoice_id ) {
        echo 'Invalid Invoice ID';
        return;
        }

        $order = wc_get_order( $invoice_id );
        if ( ! $order ) {
        echo 'Invoice not found.';
        return;
        }

        $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        $order_status = wc_get_order_status_name( $order->get_status() );
        $order_total = $order->get_total();
        $order_date = wc_format_datetime( $order->get_date_created() );
        $billing_address = $order->get_formatted_billing_address();
        $shipping_address = $order->get_formatted_shipping_address();
        $payment_method = $order->get_payment_method_title();
        $customer_email = $order->get_billing_email();
        $customer_phone = $order->get_billing_phone();
        $items = $order->get_items();
        $order_statuses = wc_get_order_statuses();

    ?>
    <div class="app-content content ">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="invoice-print p-3">
                    <div class="invoice-header d-flex justify-content-between flex-md-row flex-column pb-2">
                        <div>
                            <div class="d-flex mb-1">
                                <img class="dark-logo" alt="Kainamo" src="<?= home_url()?>/wp-content/uploads/2024/10/FF-01-001-2048x1328.png">
                                <img class="light-logo" alt="Kainamo" src="<?= home_url()?>/wp-content/uploads/2024/10/FFF-001-002.png"> 
                            </div>
                        
                            <!-- <p class="mb-25">LUXURY WITH A GREATER PURPOSE – we are dedicated to sustainability, global awareness,and to shaping a future <br>where luxury and high fashion coexist with environmental <br>and social responsibility.</p> -->
                            
                        </div>
                        <div class="mt-md-0 mt-2">
                            <h4 class="fw-bold text-end mb-1">INVOICE #<?= $invoice_id ?></h4>
                            <div class="invoice-date-wrapper mb-50">
                                <span class="invoice-date-title">Date:</span>
                                <span class="fw-bold"> <?= $order_date ?></span>
                            </div>
                            <div class="invoice-date-wrapper">
                                <span class="invoice-date-title">Customer:</span>
                                <span class="fw-bold"><?=  $customer_name ?></span>
                            </div>
                            <div class="invoice-date-wrapper">
                                <span class="invoice-date-title">Status:</span>
                                <span class="fw-bold"><?= $order_status  ?></span>
                            </div>
                        </div>
                    </div>

                    <hr class="invoice-spacing" />

                    <div class="row pb-2">

                        <div class="col-sm-6 mt-sm-0 mt-2">
                            <h6 class="mb-1">Billing Details:</h6>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="pe-1">Billing Address:</td>
                                        <td><?= wp_kses_post($billing_address); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="pe-1">Shipping Address:</td>
                                        <td><?= wp_kses_post($shipping_address); ?></td>
                                    </tr>
                                   
                                    
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-sm-6">
                            <h6 class="mb-1">Invoice To:</h6>
                            <p class="mb-25"><?= $customer_email ?></p>
                            <p class="mb-25"><?= $customer_phone ?></p>
                        </div>
                    
                    </div>

                    <hr class="my-2" />

                    <div class="table-responsive">
                        <h2 class="order_item">Order Items</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="py-1">Item</th>
                                    <th class="py-1">Cost</th>
                                    <th class="py-1">Qty</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $items as $item ) {
                                
                                    $product = $item->get_product();
                                    $item_name = $item->get_name();
                                    $item_cost = $item->get_total();
                                    $item_qty = $item->get_quantity();
                                    $item_total = $product->get_price() * $item_qty;
                                    $product_image_url = wp_get_attachment_url( $product->get_image_id() );
                                ?>
                                <tr class="border-bottom">
                                    <td class="py-1">
                                        <div class="order_item_main">
                                            <div class="order_img">
                                                <img src="<?=  $product_image_url ? $product_image_url  : $directory_url.'/assets/images/no-preview.png' ?>" height="50" width="50" alt="" />
                                            </div>
                                            <div class="order_title">
                                                <p class="card-text fw-bold mb-25"><?= esc_html($item_name); ?></p>
                                                <p class="card-text text-nowrap"><span>SKU:</span> <?= esc_html($product->get_sku()); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">$<?= $product->get_price(); ?></span>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">× <?= esc_html($item_qty); ?></span>
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold"><?= wc_price($item_total); ?></span>
                                    </td>
                                </tr>
                                <?php } ?>
                                <!-- Add any additional rows for fees or shipping if needed -->
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body invoice-padding pb-0">
                        <div class="row invoice-sales-total-wrapper">
                            
                            <div class="col-md-12  order-md-2 order-1">
                                <div class="invoice-total-wrapper">
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Items Subtotal:</p>
                                        <p class="invoice-total-amount"><?= wc_price($order->get_subtotal()); ?></p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Shipping:</p>
                                        <p class="invoice-total-amount"><?= wc_price($order->get_shipping_total()); ?></p>
                                    </div>
                                    <hr class="my-50" />
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Order Total:</p>
                                        <p class="invoice-total-amount"><?= wc_price($order_total); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="invoice-spacing" />

                    <div class="row">
                        <div class="col-12">
                            <span class="fw-bold">Note:</span>
                            <span>It was a pleasure working with you. We hope you will keep us in mind. Thank You!</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php } ?>
    <!-- order type -->
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div> 
    <?php include "includes/scripts.php"; ?> 
   
    <!-- BEGIN: Page Vendor JS-->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <!-- END: Page Vendor JS-->
   <!-- BEGIN: Page JS-->
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-invoice-print.js"></script>
    <!-- END: Page JS-->
    
</body>