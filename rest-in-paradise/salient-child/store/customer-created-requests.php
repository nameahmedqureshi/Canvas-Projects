<?php /* Template Name: My Requests */ ?>
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
                        <div class="card-body border-bottom">
                            <h2 class="card-title">My Requests</h2>
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
                        <!-- </div> -->
 
                        <!-- customer -->
                        <?php
                           $args = [
                                'post_type'      => $_GET['type'] ?? 'print-on-demand',
                                'posts_per_page' => -1,
                                'post_status'    => 'publish',
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
                                        'key'     => 'user_id',
                                        'value'   => get_current_user_id(),
                                        'compare' => '='
                                    ],
                                    [
                                        'key'     => 'post_status',
                                        'value'   => 'active',
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
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Amount </th>
                                        <th>Date</th>
                                        <th>Quotations</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services->posts as $key => $value) { 
                                       
                                       $type = get_post_meta($value->ID, 'type', true);
                                       $total_price = get_post_meta($value->ID, 'price', true);
                                       $payment_status = get_post_meta($value->ID, 'payment_status', true);
                                       $quotations = get_post_meta($value->ID, 'quote');
                                    //    $vendor =  new WP_User( $vendor_id ); 
                                    ?>
                                        <tr>
                                            <td><?= $value->ID ?></td>
                                            <td><?= $type ?></td>
                                            <td><?= get_the_title($value->ID) ?></td>
                                            <td><?= !empty( $total_price) ? '$'.number_format( $total_price, 2) : '----'; ?></td>
                                            <td><?= date('d F Y', strtotime($value->post_date)) ?></td>
                                            <td><?= count($quotations) ?></td>

                                            <td>
                                                <?php  if($payment_status != 'succeeded') { ?> 
                                                <a href="<?= home_url( 'view-quote-requests?id='.$value->ID.'&type='. $_GET['type'] ) ?>" class="view-record" data-id=<?= $value->ID ?> data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="View Quotes">
                                                    <i data-feather='eye'></i>
                                                </a>
                                                <?php } ?>
                                                <a href="#!" class="delete-record" data-id=<?= $value->ID ?> data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete value">
                                                    <i data-feather='trash-2'></i>
                                                </a>
                                            </td>
                                        </tr>

                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>

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
                {
                    text: 'Add New Request',
                    className: 'add-new btn btn-primary',
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
               
            ],
            });
            table.on('draw', function () {
                feather.replace({
                    width: 14,
                    height: 14
                });
            });

            var new_request_url = "<?=  home_url('add-new-request/?type='.$_GET['type']) ?>";
            console.log("new_request_url",new_request_url);
            $(document).on("click", ".add-new", function() {
                $(location).prop('href', new_request_url);
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
                            action: 'delete_request',
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