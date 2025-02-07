<?php  /* Template Name:  Invoice Details */ ?>
<?php  include "includes/styles.php"; ?>
<?php include "includes/header.php"; 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

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
$title = $get_invoice_data->post_title;
$description = $get_invoice_data->post_content;
$creation_date = date('d F Y', strtotime($get_invoice_data->post_date));
$completion_date = get_post_meta($id, 'completion_date', true);
$amount = get_post_meta($id, 'amount', true);
$status = get_post_meta($id, 'status', true);
$user_id = get_post_meta($id, 'user_id', true);
$get_user = get_user_by( 'id', $user_id  );
$customer_phone = get_user_meta($user_id, 'ph_num', true);
$customer_email = $get_user->user_email;
$fname =  get_user_meta($user_id, 'first_name', true); 
$lname =  get_user_meta($user_id, 'last_name', true);  
$customer_name =  sprintf('%s %s',$fname, $lname  );
// var_dump($get_user);
?>
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css-rtl/plugins/forms/pickers/form-flat-pickr.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css-rtl/pages/app-invoice.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css-rtl/custom-rtl.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/assets/css/style-rtl.css">

<!-- END: Page CSS-->
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
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="invoice-preview-wrapper">
                    <div class="row invoice-preview">
                        <!-- Invoice -->
                        <div class="col-xl-9 col-md-8 col-12">
                            <div class="card invoice-preview-card">
                                <div class="card-body invoice-padding pb-0">
                                    <!-- Header starts -->
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
                                            <h4 class="invoice-title">
                                                Invoice
                                                <span class="invoice-number">#<?= $id ?></span>
                                            </h4>
                                            <div class="invoice-date-wrapper">
                                                <p class="invoice-date-title">Date Issued:</p>
                                                <p class="invoice-date"><?= $creation_date ?></p>
                                            </div>
                                            <div class="invoice-date-wrapper">
                                                <p class="invoice-date-title">Status:</p>
                                                <p class="invoice-date"><?= $status == 'paid' ? 'Paid' : 'Unpaid' ?></p>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                </div>

                                <hr class="invoice-spacing" />

                                <!-- Address and Contact starts -->
                                <div class="card-body invoice-padding pt-0">
                                    <div class="row invoice-spacing">
                                        
                                        <div class="col-xl-8 p-0">
                                            <h6 class="mb-2">Invoice Details:</h6>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td class="pe-1">Title:</td>
                                                        <td><span class="fw-bold"><?= $title ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-1">Description:</td>
                                                        <td><?= $description ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-1">Amount:</td>
                                                        <td>$<?= $amount ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-1">Issued Date:</td>
                                                        <td><?= $creation_date ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-1">Payed Date:</td>
                                                        <td><?= $completion_date ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                            <h6 class="mb-2">Invoice To:</h6>
                                            <h6 class="mb-25"><?= $customer_name ?></h6>
                                            <p class="card-text mb-0"><?= $customer_email ?></p>
                                            <p class="card-text mb-25"><?= $customer_phone ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Address and Contact ends -->

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
                        <!-- /Invoice -->

                        <!-- Invoice Actions -->
                        <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <a class="btn btn-outline-secondary w-100 mb-75 btn btn-primary w-100 mb-75 waves-effect waves-float waves-light" href="<?= home_url('print-invoice?id='.$id.'&type=invoice') ?>" target="_blank"> Print </a>
                                    <a class="btn btn-outline-secondary w-100 mb-75 btn btn-primary w-100 mb-75 waves-effect waves-float waves-light" href="<?= home_url('invoice') ?>"> Back </a>

                                </div>
                            </div>
                        </div>
                        <!-- /Invoice Actions -->
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div> 
    <?php include "includes/scripts.php"; ?> 
   
    <!-- BEGIN: Page Vendor JS-->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <!-- END: Page Vendor JS-->
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-invoice.min.js"></script>
</body>