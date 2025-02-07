<?php  /* Template Name:  Order Details */ ?>
<?php  include "includes/styles.php"; ?>
<?php include "includes/header.php"; 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ( ! $order_id ) {
  echo 'Invalid Order ID';
  return;
}

// Ensure WooCommerce is active
if ( ! class_exists( 'WooCommerce' ) ) {
  echo 'WooCommerce is not active.';
  return;
}

$order = wc_get_order( $order_id );

if ( ! $order ) {
  echo 'Order not found.';
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
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css-rtl/pages/app-invoice.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css-rtl/custom-rtl.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/assets/css/style-rtl.css">

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

  <!-- BEGIN: Main Menu--> 
  <?php include "includes/manu.php"; ?>
  <!-- END: Main Menu-->
    <style>
        .invoice-logo{
            color: #577226 !important;
            font-size: 1.5rem !important;
        }
        .inv{
            height: 50px;
            width: 50px;
        }
        h2.order_item {
            margin-left: 30px;
            margin-bottom: 20px;
        }
        select#status {
    margin-left: 50px;
    margin-top: 10px;
    padding: 4px 0px 4px 10px;
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
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
      <div class="content-header row"></div>
      <div class="content-body">
      <form action="" method="post">
        <section class="invoice-preview-wrapper">
            <div class="row invoice-preview">
                <div class="col-xl-9 col-md-8 col-12">
                    <div class="card invoice-preview-card">
                        <div class="card-body invoice-padding pb-0">
                            <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                <div>
                                    <div class="logo-wrapper">
                                        <img class="dark-logo inv"src="https://devu11.testdevlink.net/heather/wp-content/uploads/2024/07/ggblack.png" alt="" width="80px" height="80px">
                                        <img class="light-logo inv"src="https://devu11.testdevlink.net/heather/wp-content/uploads/2024/07/ggwhite.png" alt="" width="80px" height="80px">
                                        <h3 class="invoice-logo">Julianna Moda</h3>
                                    </div>
                                    <p class="card-text mb-25">LUXURY WITH A GREATER PURPOSE – we are dedicated to sustainability,</p>
                                    <p class="card-text mb-25">global awareness,and to shaping a future where luxury and high fashion</p>
                                    <p class="card-text mb-25">coexist with environmental and social responsibility.</p>
                                   
                                </div>
                                <div class="mt-md-0 mt-2">
                                    <h4 class="invoice-title">Order Details <span class="invoice-number">#<?= esc_html($order_id); ?></span></h4>
                                    <div class="invoice-date-wrapper">
                                        <p class="invoice-date-title">Date:</p>
                                        <p class="invoice-date"><?= esc_html($order_date); ?></p>
                                    </div>
                                    <div class="invoice-date-wrapper">
                                        <p class="invoice-date-title">Customer:</p>
                                        <p class="invoice-date"><?= esc_html($customer_name); ?></p>
                                    </div>
                                    <?php if ( !in_array('customer', wp_get_current_user()->roles) ) { ?>
                                    <div class="invoice-date-wrapper">
                                        <label class="form-label" for="status">Status:</label>&nbsp&nbsp
                                        <select class="form-select" id="status" name="status">
                                            <?php foreach ( $order_statuses as $status => $label ) : ?>
                                                <option value="<?php echo esc_attr( $status ); ?>" <?=  $status == 'wc-'.$order->get_status() ? 'selected' : ''; ?>><?php echo esc_html( $label ); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <hr class="invoice-spacing" />
                        <div class="card-body invoice-padding pt-0">
                            <div class="row invoice-spacing">
                                <div class="col-xl-8 p-0">
                                    <h6 class="mb-2">Billing Details</h6>

                                    <p class="card-text mb-25"><span class="fw-bold">Billing Address:<br> </span><?= wp_kses_post($billing_address); ?></p>
                                    <br>
                                    <p class="card-text mb-25"><span class="fw-bold">Shipping Address:<br> </span><?= wp_kses_post($shipping_address); ?></p>
                                </div>
                                <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                    <h6 class="mb-2">Customer Details:</h6>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="pe-1">Email:</td>
                                                <td><span class="fw-bold"><?= wp_kses_post($customer_email); ?></span></td>
                                            </tr>
                                            <tr>
                                                <td class="pe-1">Phone:</td>
                                                <td><span class="fw-bold"><?= wp_kses_post($customer_phone); ?></span></td>
                                            </tr>
                                            <!-- Add additional payment details if needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                                
                                <div class="col-md-12 d-flex justify-content-end order-md-2 order-1">
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
                        
                        <!-- Invoice Note starts -->
                        <div class="card-body invoice-padding pt-0">
                            <div class="row">
                                <div class="col-12">
                                    <span class="fw-bold">Note:</span>
                                    <span>It was a pleasure working with you. We hope you will keep us in mind. Thank You!</span>
                                </div>
                            </div>
                        </div>
                        <!-- Invoice Note ends -->

                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                    <div class="card">
                        <div class="card-body">
                           
                            
                            <?php 
                            if ( !in_array('customer', wp_get_current_user()->roles) ) {
                                echo '<button type="submit" class="btn btn-primary w-100 mb-75" name="update_order">Update</button>';
                            } ?>
                            <a class="btn btn-outline-secondary w-100 mb-75 btn btn-primary w-100 mb-75 waves-effect waves-float waves-light" href="<?= home_url('print-invoice?id='.$order_id.'&type=order') ?>" target="_blank"> Print </a>
                            <a class="btn btn-primary  w-100 mb-75" href="<?= home_url('orders/') ?>">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      </form>
        <?php
        // Update order status on form submission
        if ( isset($_POST['update_order']) && isset($_POST['status']) ) {
            $new_status = sanitize_text_field($_POST['status']);
            $order->update_status( $new_status );
            // echo '<div class="notice notice-success is-dismissible"><p>Order status updated to ' . esc_html($new_status) . '.</p></div>';
        }
        ?>
      </div>
    </div>
  </div>


    <!-- END: Content-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div> 
    <?php include "includes/scripts.php"; ?>

    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-invoice.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script>
        $(document).ready(function () {

            
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

            const updateButton = $('[name="update_order"]');
            
            updateButton.click(function (e) {
                e.preventDefault();
                
                const newStatus = $('#status').val();
                const orderId = <?php echo $order_id; ?>;
                
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    method: 'POST',
                    data: {
                        action: 'update_order_status',
                        order_id: orderId,
                        new_status: newStatus
                    },
                    success: function (response) {
                        if (response.success) {
                            // Display success message
                            toastr.success(response.data.message,  'Success');
                            // Optionally, reload the page or update UI as needed
                        } else {
                            // Display error message
                            toastr.error(response.data.message,  'Error');

                        }
                    },
                    error: function (xhr, status, error) {
                        // Display AJAX error message
                        Swal.fire('Error', 'AJAX Error: ' + error, 'error');
                    }
                });
            });
        });
    </script>
</body>