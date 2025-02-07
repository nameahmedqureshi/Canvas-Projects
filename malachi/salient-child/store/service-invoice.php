<?php  /* Template Name:  Service Invoice */ ?>

<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ( ! $order_id ) {
  echo 'Invalid Order ID';
  return;
}
$service = get_post($_GET['id']);
// $service_name = get_post_meta($_GET['id'], 'service_name', true);
// $vendor_name = get_post_meta($_GET['id'], 'vendor_name', true);
// $customer_name = get_post_meta($_GET['id'], 'customer_name', true);
// $payment_status = get_post_meta($_GET['id'], 'payment_status', true);
// $total_price = get_post_meta($_GET['id'], 'total_price', true);
// $pending_payment = get_post_meta($_GET['id'], 'pending_payment', true);
// $pending_balance = get_post_meta($_GET['id'], 'pending_balance', true);
// $recurring_amount = get_post_meta($_GET['id'], 'recurring_amount', true);
$customer_id = get_post_meta($_GET['id'], 'customer_id', true);
$vendor_id = get_post_meta($_GET['id'], 'vendor_id', true);
if(in_array( 'vendor', wp_get_current_user()->roles) ){
    $userdata = get_userdata( $customer_id );
} else {
    $userdata = get_userdata( $vendor_id  );
}
$metadata = get_post_meta($_GET['id']);
// var_dump( $metadata['customer_id'][0]);
// var_dump( $userdata);
?>
<?php  include "includes/styles.php"; 
 include "includes/header.php"; ?>
<!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/app-chat.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/app-chat-list.css">
<!-- END: Page CSS-->

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
        .full {
            width: 100% !important;
        }
        .chat-app-window .user-chats {
           
            height: calc(50% - 65px - 65px) !important;
        }
        div#card-element {
            padding: 15px;
            background: aliceblue;
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
        <div class="content-header row"></div>
        <div class="content-body">
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    <div class="col-xl-9 col-md-8 col-12">

                        <div class="card invoice-preview-card">
                            <div class="card-body invoice-padding pb-0">
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div class="mt-md-0 mt-2">
                                        <h4 class="invoice-title">Order Details <span class="invoice-number">#<?= esc_html($_GET['id']); ?></span></h4>
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title">Date:</p>
                                            <p class="invoice-date"><?= date("d M Y", strtotime($service->post_date));  ?></p>
                                        </div>
                                       
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title">Payment Status:</p>
                                            <p class="invoice-date"><?= esc_html($metadata['payment_status'][0] == 'succeeded' ? 'Completed' : 'Pending'); ?></p>
                                        </div>
                                        <div class="invoice-date-wrapper">
                                            <p class="invoice-date-title">Shipping Status:</p>
                                            <p class="invoice-date"><?= esc_html($service->post_status == 'publish' ? 'Completed' : 'Pending'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="invoice-spacing" />
                            <div class="table-responsive">
                                <h2 class="order_item">Order Items</h2>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Invoice ID</th>
                                            <th class="py-1">Item</th>
                                            <th class="py-1">Vendor</th>
                                            <th class="py-1">Customer</th>
                                            <th class="py-1">Partial</th>
                                            <th class="py-1">Admin Commision</th>
                                            <th class="py-1">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="py-1">
                                                <span class="fw-bold">#<?=  $order_id ?></span>
                                            </td>
                                            <td class="py-1">
                                                <div class="order_item_main">
                                                    <div class="order_img">
                                                        <?php $product_image_url = get_the_post_thumbnail_url( get_post_meta( $_GET['id'], 'service_id', true) );  ?>
                                                        <img src="<?=  !empty($product_image_url) ? $product_image_url  : $directory_url.'/assets/images/no-preview.png' ?>" height="50" width="50" alt="" />
                                                    </div>
                                                    <div class="order_title">
                                                        <p class="card-text fw-bold mb-25"><?= esc_html($metadata['service_name'][0]); ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold"><?=  $metadata['vendor_name'][0]; ?></span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold"><?=  $metadata['customer_name'][0]; ?></span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">$<?=  number_format($metadata['recurring_amount'][0], 2); ?></span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">$<?=  number_format($metadata['commission_amount'][0], 2); ?></span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">$<?=  number_format($metadata['total_price'][0], 2); ?></span>
                                            </td>
                                          
                                        </tr>
                                    </tbody>
                                </table>

                            
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                        <!-- <p class="card-text mb-0">
                                            <span class="fw-bold">Order Price:</span>
                                            <span class="ms-20">$<?= number_format($metadata['total_price'][0], 2); ?></span>
                                        </p> -->
                                    
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper">
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">Remaining:</p>
                                                <p class="invoice-total-amount">$<?=  number_format($metadata['pending_payment'][0] , 2); ?></p>
                                            </div>
                                            <hr class="my-50" />
                                           
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">Total:</p>
                                                <p class="invoice-total-amount">$<?=  number_format($metadata['total_price'][0], 2); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="invoice-spacing" />
                        </div>

                    </div>
                    <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <?php if($metadata['pending_balance'][0] && in_array('customer', wp_get_current_user()->roles)) { ?>
                                <button type="button" class="pay_remaining btn btn-primary w-100 mb-75"  data-bs-toggle="modal" data-bs-target="#addNewCard">Pay Remaining Balance</button>
                                <?php } ?> 
                                <a class="btn btn-primary w-100 mb-75" href="<?= home_url('print-invoice?id='.$order_id.'&type=service') ?>" target="_blank"> Print </a>
                                <a class="btn btn-primary w-100 mb-75" href="<?=  home_url('service-bookings/?type='.$_GET['type']) ?>">Back</a>
                              
                            </div>
                        </div>

                        <!-- Active chat -->
                        <?php if (!in_array('administrator', wp_get_current_user()->roles)) { ?>
                        <div class="chat-application">
                            <div class="content-right full">
                                <div class="content-wrapper container-xxl p-0">
                                    <div class="content-header row">
                                    </div>
                                    <div class="content-body">
                                        <div class="body-content-overlay"></div>
                                        <!-- Main chat area -->
                                        <section class="chat-app-window">
                                        
                                            <!-- Active Chat -->
                                            <div class="active-chat">
                                                <!-- Chat Header -->
                                                <div class="chat-navbar">
                                                    <header class="chat-header">
                                                        <div class="d-flex align-items-center">
                                                            <div class="sidebar-toggle d-block d-lg-none me-1">
                                                                <i data-feather="menu" class="font-medium-5"></i>
                                                            </div>
                                                            <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                                                <img src="<?= $directory_url ?>/assets/images/avatar.png" alt="avatar" height="36" width="36" />
                                                            </div>
                                                            <h6 class="mb-0 active-chat-user"><?= $userdata->display_name ?></h6>
                                                        </div>
                                                    
                                                    </header>
                                                </div>
                                                <!--/ Chat Header -->

                                                <!-- User Chat messages -->
                                                <div class="user-chats">
                                                    <div class="chats"></div>
                                                </div>
                                                <!-- User Chat messages -->

                                                <!-- Submit Chat form -->
                                                <form class="chat-app-form" id="chat-form">
                                                    <div class="input-group input-group-merge me-1 form-send-message">
                                                        <input type="text" class="form-control message" name="message" placeholder="Type your message or use speech to text" />
                                                    </div>
                                                    <input type="hidden" name="receiver_id" value="<?=  $userdata->ID ?>">
                                                    <input type="hidden" name="action" value="onMessage">
                                                    <button type="submit" class="btn btn-primary send">
                                                        <i data-feather="send" class="d-lg-none"></i>
                                                        <span class="d-none d-lg-block">Send</span>
                                                    </button>
                                                </form>
                                                <!--/ Submit Chat form -->
                                            </div>
                                            <!--/ Active Chat -->
                                        </section>
                                        <!--/ Main chat area -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- Active chat -->
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- add new card modal  -->
<div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <form id="pay_remaining_balance">
                    <div class="summary"></div>
                    <div class="mb-1 col-md-12">
                        <div id="card-element"></div> 
                    </div>
                    
                    <div class="col-12 text-center">
                        <input type="hidden" class="post_id" name="post_id" value="<?= $_GET['id'] ?>">
                        <input type="hidden"  name="type" value="<?= $_GET['type'] ?>">
                        <input type="hidden" name="action" value="pay_remaining_balance_by_customer">
                        <button type="submit" class="btn btn-primary me-1 mt-1">Pay</button>
                        <button type="reset" class="btn btn-outline-secondary mt-1 reset_btn" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ add new card modal  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>

  <!-- END: Content-->
  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div> 
  <?php include "includes/scripts.php"; ?> 
    <!-- BEGIN: Page JS-->
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-chat.js"></script>
    <!-- END: Page JS-->
  <!-- <script src="<?= $directory_url ?>/app-assets/js/core/app-menu.js"></script> -->
  <!-- <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/dashboard-ecommerce.js"> </script> -->
  <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-invoice.min.js"></script>

<script>
    $(document).ready(function () {

        // stripe 
        var pub_key = "pk_test_51PNfoGAOqJbE4AIGUB2S5oYWIWMRjB0N4otuUHZKgYZk7TwZ3MDhFN1lJQqq3JoFfyHzvMWoA2bRH3SecQ1L8VdF00XTYhOqiJ";
        stripe = Stripe(pub_key);
        var elements = stripe.elements();
        cardElement = elements.create('card', {
            hidePostalCode: true,
        });
        cardElement.mount('#card-element');

        let service_name = "<?= $metadata['service_name'][0]  ?>";
        let total_price = parseFloat("<?= $metadata['total_price'][0]  ?>"); 
        let pending_payment = parseFloat("<?= $metadata['pending_payment'][0] ?>"); 

        $(document).on("click", ".pay_remaining", function(e) {
            $('.summary').html("<h4 class='text-center'>" + service_name + "</h4><p class='text-center'>Total Amount: $" + total_price.toFixed(2) + "</p><p class='text-center'>Remaining: $" + pending_payment.toFixed(2) + "</p>");
        });

        $("#pay_remaining_balance").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = new FormData(this);
            // console.log('stripe', stripe);
            $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            $(this).find('button[type=submit]').prop('disabled', true);
                var thiss = $(this);
            $('body').waitMe({
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
            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Handle error
                    toastr.error( result.error.message, "Error");
                    console.log(result.error);
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled',false); 
                    return;
                } else {
                    // Attach the token or source to the form data
                    form.append('stripeToken', result.token.id);
                    $.ajax({
                        type: 'post',
                        url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                        data: form, // Use FormData directly
                        dataType : 'json',
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            jQuery('.fa.fa-spinner.fa-spin').remove();
                            jQuery('body').waitMe('hide');
                            jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                            if(!response.status){
                                toastr.error(response.message, response.title);
                                $('.reset_btn').click();
                            }
                            else{
                                toastr.success(response.message, response.title);
                                if (response.auto_redirect) {window.location.href = response.redirect_url;}
                            } 
                        },
                        error : function(errorThrown){ 
                            console.log(errorThrown);
                            jQuery('body').waitMe('hide');

                        }
                    });
                }
            }); 
        });

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
                        Swal.fire('Success', response.data.message, 'success');
                        // Optionally, reload the page or update UI as needed
                    } else {
                        // Display error message
                        Swal.fire('Error', response.data.message, 'error');
                    }
                },
                error: function (xhr, status, error) {
                    // Display AJAX error message
                    Swal.fire('Error', 'AJAX Error: ' + error, 'error');
                }
            });
        });

        $('#chat-form').submit(function(e){
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = new FormData(this);           
            var thiss = jQuery(this);

            jQuery.ajax({
                type: 'post',
                url: "<?= admin_url('admin-ajax.php')  ?>",
                data: form,
                dataType : 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(!response.status){
                        toastr.error(response.message, response.title);
                    } else {
                        $('#chat-form')[0].reset();
                        $('.chats').append(response.html);
                        $('.user-chats ').scrollTop($('.user-chats ')[0].scrollHeight);
                    }
                    
                },
                error : function(errorThrown){
                    console.log(errorThrown);
                }
            });
        });

        function updateMessages(id) {
               
            jQuery.ajax({
                type: 'post',
                url: "<?= admin_url('admin-ajax.php')  ?>",
                data: {
                    action: 'get_messages',
                    id: id,
                },
                dataType: 'json',
                success: function (response) {
                    //console.log(response.html);
                    if (response.html) {
                        $('.chats').html(response.html);
                        $('.user-chats ').scrollTop($('.user-chats ')[0].scrollHeight);

                    }
                // console.log(response);
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
        // Execute the code for loading the chat
        setInterval(function () {
            var idFromUrl = new URLSearchParams(window.location.search).get('id');
            if(idFromUrl){
                updateMessages(idFromUrl);
            }
        }, 3000);

    });
</script>
</body>
