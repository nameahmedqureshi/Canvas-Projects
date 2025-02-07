<?php /* Template Name: Donations */ ?>
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
<!-- Include the PayPal JavaScript SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=AdiwKv4R1Szdgmh5TPtuZ1lucw4_tVzxAJU35CNq5lVVUtbJg0clRT4SK1k4BE49ZksusSKKMx_GZ4kw&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
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
    form.dateFilter {
        display: flex;
    }

    form.dateFilter .filter_div {
        margin-right: 10px;
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
                <div class="row match-height">
                    <!-- Earnings Card -->
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="card card-congratulation-medal">
                            <div class="card-body">
                                <h4>Total Donation</h4>
                                <?php
                                 global $wpdb;

                                 $user_id = get_current_user_id();
                                 $is_admin = in_array('administrator', wp_get_current_user()->roles);
                                 
                                 // Build the SQL query
                                 $sql = "SELECT SUM(CAST(meta_value AS DECIMAL(10, 2))) as total_donations
                                         FROM {$wpdb->postmeta} pm
                                         INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
                                         WHERE p.post_type = 'donations'
                                           AND p.post_status = 'publish'
                                           AND pm.meta_key = 'amount'";
                                 
                                 if (!$is_admin) {
                                     $sql .= $wpdb->prepare(" AND p.post_author = %d", $user_id);
                                 }
                                 
                                 // Execute the query
                                 $total_donations = $wpdb->get_var($sql);
                                ?>
                               
                                <p class="card-text font-small-3 fw-bolder"><?= in_array('administrator', wp_get_current_user()->roles) ? 'This is the amount you collect from donations' : 'This is the amount you donate' ?></p>
                                <h4>$<?= number_format($total_donations, 2) ?></h4>
                            </div>
                        </div>
                    </div>
                    <!--/ Earnings Card -->
                    <?php  if( !in_array('administrator', wp_get_current_user()->roles) ) { ?>
                    <!-- Modal Card -->
                    <div class="col-lg-6 col-md-6 col-12">
                            <!-- add new card  -->
                            <div class="card">
                                <div class="card-body text-center">
                                <i data-feather="credit-card" class="font-large-2 mb-1"></i>
                                <h5 class="card-title">Donate</h5>
                                <p class="card-text">
                                    Make new donation by click donate button
                                </p>
                                <!-- modal trigger button -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewCard">
                                    Donate
                                </button>
                                </div>
                            </div>
                            <!-- / add new card  -->
                    </div>
                    <!--/ Mddal Card -->
                    <?php } ?>
                </div>
                <!-- users list start -->
                <section class="app-user-list">
                   
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h2 class="card-title">Recent Donations</h2>
                            <?php
                                $current_date = date('Y-m-d');
                                $date_before_10_days = date('Y-m-d', strtotime('-10 days'));
                            ?>
                            <form class="dateFilter" action="" method="GET">
                                <?php if(in_array('administrator', wp_get_current_user()->roles) ) { ?>
                                <div class="filter_div">
                                    <label class="col-form-label" for="fp-range">Member: </label>
                                </div>
                                <?php
                                    $users = new WP_User_Query( array(
                                    'role'   => 'customer',
                                    'fields' => 'display_name', // Fetch only user IDs
                                ) );
                                $agents = $users->get_results();
                                ?>
                                <div class="filter_div">
                                    <!-- <input type="text" name="agent" class="form-control" value="<?= isset($_GET['agent']) ? $_GET['agent'] : '' ?>" placeholder="Agent Name"> -->
                                    <select class="form-select" name="agent" id="basicSelect">
                                        <option value="" hidden selected>Select member</option>
                                        <?php foreach ($agents as $key => $value) { ?>
                                            <option value="<?= $value ?>" <?= isset($_GET['agent']) && $_GET['agent'] ==  $value ? 'selected' : '' ?>><?= $value ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php } ?>
                                <div class="filter_div">
                                    <label class="col-form-label" for="fp-range">Date Range: </label>
                                </div>
                                <div class="filter_div">
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="fp-range" name="date" class="form-control flatpickr-range flatpickr-input" value="<?= isset($_GET['date']) ? $_GET['date'] : $current_date . ' to ' . $date_before_10_days ?>" placeholder="YYYY-MM-DD to YYYY-MM-DD" readonly="readonly">
                                    </div>
                                </div>
                                <div class="">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Filter</button>
                                </div>
                            </form>
                        </div>
                        <?php
                        $args = array(
                            'post_type' => 'donations',
                            'post_status' => 'publish',
                            'post_per_page' => -1,
                            'author' => !in_array('administrator', wp_get_current_user()->roles) ? get_current_user_id() : '',
                            'date_query'     => array(
                                array(
                                    'after'     => $date_before_10_days,
                                    'before'    => $current_date,
                                    'inclusive' => true,
                                ),
                            ),
                        );
                      
                        // Check if the 'date' parameter exists in the URL
                        if (isset($_GET['date'])) {
                            // Extract start and end dates from the URL parameter
                            $date_range = explode(' to ', sanitize_text_field($_GET['date']));
                            
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
                        // Check for a specific agent in the POST request
                        if (isset($_GET['agent'])) {
                            $agent_name = sanitize_text_field($_GET['agent']);
                            // Add a meta query to filter by agent's username
                            $args['meta_query'] = [
                                [
                                    'key'     => 'agent',
                                    'value'   => $agent_name,
                                    'compare' => 'LIKE', // Change to '=' if you want an exact match
                                ],
                            ];
                        }
                        $payouts = new WP_Query($args);
                        ?>
                        <div class="card-datatable table-responsive pt-0">
                            <div class="table-responsive">
                                <table class="datatables-basic table">
                                    <thead>
                                        <tr>
                                            <th>Donate ID</th>
                                            <th>Memeber</th>
                                            <th>Amount</th>
                                            <th>Paid Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($payouts->posts ?? [] as $key => $value) { 
                                             $amount = get_post_meta($value->ID, 'amount', true); 
                                             $agent = get_post_meta($value->ID, 'agent', true); ?>
                                            <tr>
                                                <td><?= $value->ID ?></td>
                                                <td><?= $agent  ?></td>
                                                <td class="payout_amount fw-bold">$<?= number_format($amount, 2)   ?></td>
                                                <td class="payout_date"><?= date('Y/m/d', strtotime($value->post_date))  ?></td>
                                                <td><span class="badge bg-success">Completed</span></td>
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
    <!-- add new card modal  -->
    <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <h1 class="text-center mb-1" id="addNewCardTitle">Make Donation</h1>
                    <p class="text-center">Enter a amount for donation</p>
                    <!-- form -->
                    <!-- <form id="payout_request" class="row gy-1 gx-2 mt-75" onsubmit="return false"> -->
                    <form id="donation_request" class="row gy-1 gx-2 mt-75">
                        <div class="mb-1 col-md-12">
                            <label class="form-label" for="payout_amount">Amount *</label>
                            <input type="number" name="amount" id="payout_amount" class="form-control" placeholder="Donation Amount" />
                        </div>
                        <div class="col-12">
                            <div id="paypal-buttons"></div> <!-- Paypal element -->
                        </div>
                       
                        <div class="col-12 text-center">
                            <input type="hidden" name="action" value="add_donation">
                            <button type="submit" class="btn btn-primary me-1 mt-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary mt-1 reset_btn" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ add new card modal  -->
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
    <!-- Date picker -->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/pickers/form-pickers.js"></script>
    <script>
        <?php if( in_array('customer', wp_get_current_user()->roles)){ ?>
            function showWaitIndicator() {
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
            }
            function hideWaitIndicator() {
                jQuery('body').waitMe('hide');
            }
            function clearPayPalButtons() {
                $('#paypal-buttons').empty();
            }
            function renderPayPalButtons(planId) {
                paypal.Buttons({
                    style: {
                        shape: 'pill',
                        color: 'gold',
                        layout: 'vertical',
                        label: 'subscribe'
                    },
                    createSubscription: function(data, actions) {
                        return actions.subscription.create({
                            plan_id: planId
                        });
                    },
                    onApprove: function(data, actions) {
                        showWaitIndicator();
                        var formData = $('.donation_request').serialize();
                        $.ajax({
                            type: 'post',
                            url: '<?= admin_url('admin-ajax.php') ?>',
                            data: {
                                action: 'signup_user',
                                form_data: formData,
                                subscription_id: data.subscriptionID
                            },
                            dataType: 'json',
                            success: function(response) {
                                hideWaitIndicator();
                                Swal.fire({
                                    icon: response.icon,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false
                                });
                                if (response.status) {
                                    window.location.href = response.redirect;
                                }
                            },
                            error: function(errorThrown) {
                                hideWaitIndicator();
                                console.log(errorThrown);
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: errorThrown.err,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                }).render('#paypal-buttons');
            }
            clearPayPalButtons(); // Clear previous paypal buttons
            renderPayPalButtons("dasdsa");
        <?php } ?>
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
        $("#donation_request").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = new FormData(this);
            // console.log('form', form);
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
            $.ajax({
                type: 'post',
                url: "<?= admin_url('admin-ajax.php')  ?>",
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.fa.fa-spinner.fa-spin').remove();
                    $('body').waitMe('hide');
                    $(thiss).find('button[type=submit]').prop('disabled', false);
                    if (!response.status) {
                            toastr.error(response.message, response.title);
                    } else{
                        toastr.success(response.message, response.title);
                        if (response.auto_redirect) {window.location.href = response.redirect_url;}
                    } 
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                    $('body').waitMe('hide');
                }
            });
        });
    </script>
    
</body>
<!-- END: Body-->
</html>
