<?php /* Template Name: Payout */ ?>
<?php
if(in_array('farmer', wp_get_current_user()->roles) || in_array('supplier', wp_get_current_user()->roles) ) { 
$args = array(
    'post_type' => 'payouts',
    'post_status' => 'any',
    'post_per_page' => -1,
    'author' => get_current_user_id(),
);
$payouts = new WP_Query($args);
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
                <div class="row match-height">
                    <!-- Earnings Card -->
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="card card-congratulation-medal">
                            <div class="card-body">
                                <h4>Available for Payout</h4>
                                <?php
                                    $query = $wpdb->prepare('
                                    SELECT SUM(CAST(wp_wc_order_stats.net_total AS UNSIGNED))  AS total_amount
                                    FROM wp_wc_order_stats 
                                    INNER JOIN wp_wc_orders_meta ON 
                                    wp_wc_order_stats.order_id = wp_wc_orders_meta.order_id 
                                    WHERE wp_wc_orders_meta.meta_key = "_seller_id"
                                    AND wp_wc_orders_meta.meta_value = "'.get_current_user_id().'"');

                                    // Execute the query
                                    $results = $wpdb->get_results($query);

                                    $payout_amount = $wpdb->prepare('SELECT SUM(CAST(pm.meta_value AS UNSIGNED))  AS total_amount
                                    FROM wp_posts as p 
                                    INNER JOIN wp_postmeta as pm ON 
                                    p.ID = pm.post_id 
                                    WHERE pm.meta_key = "payout_amount"
                                    AND p.post_type = "payouts"
                                    AND p.post_author = "'.get_current_user_id().'"');
                                    // Execute the query
                                    $get_payout_amount = $wpdb->get_results($payout_amount);

                                    // var_dump($results[0]->total_amount);
                                    // var_dump($get_payout_amount[0]->total_amount);


                                    $total = $results[0]->total_amount - $get_payout_amount[0]->total_amount;
                                    
                                ?>
                                <h3 class="mb-75 mt-2 pt-50">
                                    <p>£<?=  number_format($total, 2);  ?></p>
                                </h3>
                                <p class="card-text font-small-3 fw-bolder">This is the amount you currently have in earnings, available for your next payout.</p>
                            </div>
                        </div>
                    </div>
                    <!--/ Earnings Card -->

                    <!-- Modal Card -->
                    <div class="col-lg-6 col-md-6 col-12">
                            <!-- add new card  -->
                            <div class="card">
                                <div class="card-body text-center">
                                <i data-feather="credit-card" class="font-large-2 mb-1"></i>
                                <h5 class="card-title">Payout</h5>
                                <p class="card-text">
                                    Request a payout
                                </p>

                                <!-- modal trigger button -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payoutForm">
                                    Request
                                </button>
                                </div>
                            </div>
                            <!-- / add new card  -->
                    </div>
                    <!--/ Mddal Card -->
                </div>
                <!-- users list start -->
                <section class="app-user-list">
                   
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h2>Recent Payouts</h2>
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
                                            <th>Payout ID</th>
                                            <th>Amount</th>
                                            <th>Notes</th>
                                            <th>Date Processed</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($payouts->posts ?? [] as $key => $value) {  ?>
                                            <tr>
                                                <td><?= get_the_title($value->ID) ?></td>
                                                <td class="payout_amount fw-bold">$<?= get_post_meta($value->ID, 'payout_amount', true)  ?></td>
                                                <td class="payout_note"><?= get_the_excerpt($value->ID) ?></td>
                                                <td class="payout_date"><?= date('Y/m/d', strtotime($value->post_date))  ?></td>
                                                <td class="payout_date"><?=  $value->post_status == 'draft' ? 'Pending' : 'Completed' ?></td>
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
    <div class="modal fade" id="payoutForm" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <h1 class="text-center mb-1" id="addNewCardTitle">Add Payout Request</h1>
                    <p class="text-center">Enter a amount for payout</p>
                    <!-- form -->
                    <!-- <form id="payout_request" class="row gy-1 gx-2 mt-75" onsubmit="return false"> -->
                    <form id="payout_request" class="row gy-1 gx-2 mt-75">
                        <div class="mb-1 col-md-12">
                            <label class="form-label" for="payout_amount">Payout Amount *</label>
                            <input type="number" name="payout_amount" id="payout_amount" class="form-control" placeholder="Payout Amount" />
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="payout_description">Description *</label>
                            <textarea class="form-control" name="payout_description" id="payout_description" rows="3" placeholder="Enter information about payout request"></textarea>
                        </div>
                       
                        <div class="col-12 text-center">
                            <input type="hidden" name="action" value="payout_request">
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

    <script>

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

        $("#payout_request").submit(function(e) {
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

<?php } else { wp_redirect(home_url('/'));
} ?>