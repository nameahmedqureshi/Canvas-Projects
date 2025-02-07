<?php /* Template Name: Payout */ ?>
<?php
if(in_array('vendor', wp_get_current_user()->roles) ) { ?>

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
                                  
                                  $sales_and_commission_data =  $payoutClass->get_user_sales_and_commission_data(get_current_user_id());

                                    // var_dump($sales_and_commission_data);
                                    // var_dump($services_sales_query);
                                    // var_dump($commission_amount);
                                    // var_dump($on_demand_commission_amount);
                                    // var_dump($commisions);

                                  

                                    // var_dump($results[0]->total_amount);
                                    // var_dump($get_payout_amount[0]->total_amount);


                                    // $total =  $total_amount_of_product_and_serives_sales - $get_payout_amount[0]->total_amount;
                                    
                                ?>
                                <h3 class="mb-75 mt-2 pt-50">
                                    <p>$<?=  number_format($sales_and_commission_data['net_amount'], 2);  ?></p>
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewCard">
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
                            <h2 class="card-title">Recent Payouts</h2>
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
                        <?php
                        $args = array(
                            'post_type' => 'payouts',
                            'post_status' => 'any',
                            'post_per_page' => -1,
                            'author' => get_current_user_id(),
                            'date_query'     => array(
                                array(
                                    'after'     => $date_before_10_days,
                                    'before'    => $current_date,
                                    'inclusive' => true,
                                ),
                            ),
                        );

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
                        $payouts = new WP_Query($args);

                        ?>
                        <div class="card-datatable table-responsive pt-0">
                            <div class="table-responsive">
                                <table class="datatables-basic table">
                                    <thead>
                                        <tr>
                                            <th>Payout ID</th>
                                            <th>Amount</th>
                                            <th>Notes</th>
                                            <th>Date Processed</th>
                                            <th>Paid Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($payouts->posts ?? [] as $key => $value) { 
                                             $paid_date = get_post_meta($value->ID, 'paid_date', true); 
                                             $payout_amount = get_post_meta($value->ID, 'payout_amount', true); ?>
                                            <tr>
                                                <td><?= $value->ID ?></td>
                                                <td class="payout_amount fw-bold">$<?= number_format($payout_amount, 2)  ?></td>
                                                <td class="payout_note"><?= get_the_excerpt($value->ID) ?></td>
                                                <td class="payout_date"><?= date('Y/m/d', strtotime($value->post_date))  ?></td>
                                                <td class="payout_date"><?= !empty($paid_date) ? date('Y/m/d', strtotime($paid_date)) : '---'  ?></td>
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
    <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
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

    <!-- Date picker -->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/pickers/form-pickers.js"></script>

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

<?php } else { wp_redirect(home_url('dashboard/'));
} ?>