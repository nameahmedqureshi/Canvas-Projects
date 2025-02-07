<?php /* Template Name: Vendor Profiles  */ ?>
<?php 
$current_user_id = wp_get_current_user();
$user_type = get_user_meta($current_user_id->ID, 'user_type', true);
$subscription_plan = get_user_meta($current_user_id->ID, 'subscription_plan', true);

function get_featured_user_id($user_type) {
    global $wpdb;

    $featured_user_ids = [];
  

    if ($user_type == 'farmer') {
        $user_meta_value = "('supplier')";
    } elseif ($user_type == 'supplier') {
        $user_meta_value = "('farmer')";
    } elseif ($user_type == 'restaurant' || in_array('administrator', wp_get_current_user()->roles)) {
        $user_meta_value = "('farmer', 'supplier')";
    }

    if (isset($user_meta_value)) {
        $base_query = "
        SELECT um.user_id
        FROM {$wpdb->usermeta} AS um
        INNER JOIN {$wpdb->posts} AS p ON um.user_id = p.post_author
        INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
        WHERE um.meta_key = 'user_type'
        AND pm.meta_key = 'featured_product'
        AND pm.meta_value = %s
        AND um.meta_value IN $user_meta_value 
    ";

        $featured_query = $wpdb->prepare($base_query, 'true', $user_meta_value);
        $featured_user_ids = $wpdb->get_col($featured_query);

       
    //    var_dump($featured_query);
    }

    return $featured_user_ids;
}

function get_same_subscription_plan_user_id($user_type, $subscription_plan) {
    global $wpdb;

    $same_subscription_plan_user_ids = [];
   

    if ($user_type == 'farmer' && in_array($subscription_plan, ['advanced', 'premium'])) {
        $user_meta_value = "('supplier')";
    } elseif ($user_type == 'supplier') {
        $user_meta_value = "('farmer')";
    } elseif ($user_type == 'restaurant' || in_array('administrator', wp_get_current_user()->roles)) {
        $user_meta_value = "('farmer', 'supplier')";
    } 

    

    if (isset($user_meta_value)) {
       // $query = $wpdb->prepare($base_query, $subscription_plan, $user_meta_value);
        $base_query = "
        SELECT pm1.user_id
        FROM {$wpdb->usermeta} AS pm1
        INNER JOIN {$wpdb->usermeta} AS pm2 ON pm1.user_id = pm2.user_id
        WHERE pm1.meta_key = 'user_type'
        AND pm2.meta_key = 'subscription_plan'
        AND pm1.meta_value IN $user_meta_value 
        AND pm2.meta_value = %s
    ";
        // $same_subscription_plan_user_ids = $wpdb->get_col($query);
        $query = $wpdb->prepare($base_query, $subscription_plan);
        $same_subscription_plan_user_ids = $wpdb->get_col($query);

      
      //  var_dump($query);
    }

    return $same_subscription_plan_user_ids;
}

global $wpdb;

// Get featured user IDs
$featured_user_ids = get_featured_user_id($user_type);

// Get users with the same subscription plan
$same_subscription_plan_user_ids = get_same_subscription_plan_user_id($user_type, $subscription_plan);

$data = array_merge($featured_user_ids, $same_subscription_plan_user_ids);
$user_ids = array_unique($data);

// var_dump($featured_user_ids);
// var_dump($same_subscription_plan_user_ids);
// exit;
  
$users = get_users(array(
    'include' => $user_ids
));


// echo "<pre>";
// var_dump($user_type);
// var_dump($subscription_plan);
// var_dump($users);
?>
<?php include "includes/styles.php"; ?>

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
                        <div class="card-body border-bottom">
                            <h2>Profiles</h2>
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
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone No</th>
                                            <th>Plan</th>
                                            <th>Total Products</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users ?? [] as $key => $value) { 
                                            // $stripe_details = get_user_meta($value->post_author, 'stripe_details', true);
                                            $first_name = get_user_meta($value->ID, 'first_name', true);
                                            $last_name = get_user_meta($value->ID, 'last_name', true);
                                            $full_name = sprintf('%s %s',$first_name, $last_name );
                                            $ph_num = get_user_meta($value->ID, 'ph_num', true);
                                            $user_type = get_user_meta($value->ID, 'user_type', true);
                                            $subscription_plan = get_user_meta($value->ID, 'subscription_plan', true);
                                            ?>
                                            <tr>
                                                <td><?= $value->ID ?></td>
                                                <td><?= $full_name ?></td>
                                                <td><?= $value->user_email ?></td>
                                                <td><?= !empty($ph_num) ? $ph_num : '---'  ?></td>
                                                <td><?= $user_type.'-'.$subscription_plan ?></td>
                                                <td><?= count_user_posts( $value->ID , ['product']  );  ?></td>
                                                <td>
                                                    <a href="<?= home_url('store-profile?id='.$value->ID)  ?>" target="_blank" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="View Profile">
                                                        <i data-feather='eye'></i>
                                                    </a> 
                                                </td>
                                            </tr>
                                      <?php } ?>
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
    <!-- send money using stripe  -->
    <div class="modal fade" id="sendMoney" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <h1 class="text-center mb-1" id="addNewCardTitle">Send Money</h1>
                    <p class="text-center">Enter your card details</p>
                    <!-- form -->
                    <!-- <form id="payout_request" class="row gy-1 gx-2 mt-75" onsubmit="return false"> -->
                    <form id="payout_request">
                        <div class="mb-1 col-md-12">
                            <div id="card-element"></div> 
                        </div>
                       
                        <div class="col-12 text-center">
                            <input type="hidden" class="request_id" name="request_id" value="">
                            <input type="hidden" class="user" name="user" value="">
                            <input type="hidden" name="redirect" value="<?= "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
                            <input type="hidden" name="action" value="send_payout_using_stripe">
                            <button type="submit" class="btn btn-primary me-1 mt-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary mt-1 reset_btn" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ send money using stripe   -->

        <!-- send money using bank  -->
    <div class="modal fade" id="sendMoneyBank" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <h1 class="text-center mb-1" id="addNewCardTitle">Card Details</h1>
                    <div class="mb-1 col-md-12">
                        <p>Account Holder Name: <span class="acount_holder"></span></p>
                        <p>Account Number: <span class="acount_number"></span></p>
                    </div>
                    
                    <div class="col-12 text-center">
                        
                        <button type="button" class="btn btn-primary me-1 mt-1 payout_using_bank_btn" data-id="" data-url="<?= "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">Pay</button>
                        <button type="reset" class="btn btn-outline-secondary mt-1 reset_btn" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ send money using bank   -->
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
    <script src="<?= $directory_url ?>/app-assets/js/scripts/components/components-modals.js"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        $(document).ready(function(){

            var stripe = "";
            var cardElement = "";
            
            $(document).on("click", '.pay_btn', function(e){
                var post_id = $(this).attr('data-id');
                var user = $(this).attr('data-user');
                $('.request_id').val(post_id);
                $('.user').val(user);

                jQuery.ajax({
                    type: 'post',
                    url: "<?= admin_url( 'admin-ajax.php') ?>",
                    data: {
                        action: 'get_publishable_key',
                        user: user,
                    },
                    dataType : 'json',
                    success: function (response) {
                        // stripe 
                        var pub_key = response.publishable_key;
                        console.log("pub_key",pub_key);

                        stripe = Stripe(pub_key);
                        var elements = stripe.elements();
                        cardElement = elements.create('card', {
                            hidePostalCode: true,
                        });
                        cardElement.mount('#card-element');
                       
                        },
                        error : function(errorThrown){
                        console.log(errorThrown);
                    }
                });
            });
      

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

            // using stripe pay
            $("#payout_request").submit(function(e) {
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
                        Swal.fire({
                            title: "Error",
                            text:  result.error.message,
                            icon: "error",
                        })
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
                                    thiss.parents('tr').find('.payout_status').text('Paid');
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

            // using bank pay
            $(document).on("click", '.bank_pay_btn', function(e){
                var account_holder_name = $(this).attr('bank-name');
                var cardnumber = $(this).attr('bank-card');
                var id = $(this).attr('data-id');
                $('.payout_using_bank_btn').attr('data-id', id);
                $('.acount_holder').text(account_holder_name);
                $('.acount_number').text(cardnumber);
                
            });

            $(document).on("click", '.payout_using_bank_btn', function(e){
                if (confirm("Are you sure?")) {
                    var post_id = $(this).attr('data-id');
                    var data_url = $(this).attr('data-url');
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
                    jQuery.ajax({
                        type: 'post',
                        url: "<?= admin_url( 'admin-ajax.php') ?>",
                        data: {
                            action: 'send_payout_using_bank',
                            post_id: post_id,
                            redirect: data_url,
                        },
                        dataType : 'json',
                        success: function (response) {
                            jQuery('body').waitMe('hide');
                            if(!response.status){
                                toastr.error(response.message, response.title);
                            }
                            else{
                                toastr.success(response.message, response.title);
                                thiss.parents('tr').find('.payout_status').text('Paid');
                                if (response.auto_redirect) {window.location.href = response.redirect_url;}
                            } 
                        },
                        error : function(errorThrown){
                            jQuery('body').waitMe('hide');
                            console.log(errorThrown);
                        }
                    });
                }
                return false;
            });
        });
    </script>


    
</body>
<!-- END: Body-->

</html>