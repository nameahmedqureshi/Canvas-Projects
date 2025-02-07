<?php /* Template Name: POD Requests */ ?>
<!-- BEGIN: Head-->
<?php
// function encryptData($data) {
//     $ciphering = "AES-128-CTR";
//     $iv_length = openssl_cipher_iv_length($ciphering);
//     $options = 0;
//     $encryption_iv = '1234567891011121';
//     $encryption_key = "W3docs";
//     return  openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
// }

 include "includes/styles.php"; ?>

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
        .instructions {
            padding: 20px;
        }
        button.get_quote_button.applied {
            opacity: 0.3;
            pointer-events: none;
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
                            <h2 class="card-title">Requests</h2>
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

                        <?php if( in_array('vendor', wp_get_current_user()->roles) ) { ?>
                            <div class="instructions border-bottom col-12">
                                <?php $page_url = 'https://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"], '?') . '?type='.$_GET['type'];  ?>
                                <a href="<?= $page_url .'&status=applied' ?>" class="btn btn-success waves-effect waves-float waves-light">Applied Requests</a>                        
                                <a href="<?= $page_url .'&status=not-applied' ?>" class="btn btn-danger waves-effect waves-float waves-light">Not Applied Requests</a>                        
                            </div>
                        <?php } ?>
 
                        
                        <?php
                            $args = [
                                'post_type'      => $_GET['type'],
                                'posts_per_page' => -1,
                                'date_query'     => array(
                                    array(
                                        'after'     => $date_before_10_days,
                                        'before'    => $current_date,
                                        'inclusive' => true,
                                    ),
                                ),
                                'meta_query'     => [
                                    'relation' => "AND",
                                    [
                                        'key'     => 'post_status',
                                        'value'   => 'active',
                                        'compare' => '=',
                                    ],
                                ],
                            ];

                            if($_GET['status'] == 'applied') {
                                $args['meta_query'][] =
                                [
                                    'key'     => 'user_'.get_current_user_id(),  
                                    'value'   => 'applied',
                                    'compare' => '=',
                                ];
                            }elseif($_GET['status'] == 'not-applied') {
                                $args['meta_query'][] =
                                [
                                    'key'     => 'user_'.get_current_user_id(),  
                                    'value'   => 'applied',
                                    'compare' => 'NOT EXISTS',
                                ];
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
                        <div class="card-datatable table-responsive pt-0">
                        <!-- administrator -->
                        <?php if( in_array('administrator', wp_get_current_user()->roles) ) { ?>
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Booking No</th>
                                        <th>Customer</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Posted Date</th>
                                        <th>Deadline</th>
                                        <th>Vendor Quotations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services->posts as $key => $value) { 
                                       
                                        $price =  get_post_meta($value->ID, 'price', true);
                                        $customer_id =  get_post_meta($value->ID, 'user_id', true);
                                        $customer_name =  get_user_meta($customer_id, 'first_name', true);
                                        $payment_status = get_post_meta($value->ID,'payment_status', true);
                                        $deadline_date = get_post_meta($value->ID,'deadline_date', true);
                                        $status = get_post_meta($value->ID,'user_'.get_current_user_id(), true);
                                        $quote = get_post_meta($value->ID,'quote');
                                        $vendor_id = array_column($quote, 'vendor_id');
                                        $current_user = get_current_user_id();
                                        // var_dump($price);

                                    //    $vendor =  new WP_User( $vendor_id ); 
                                    ?>
                                        <tr class="product-item">
                                            <td><?= $value->ID ?></td>
                                            <td><?= $customer_name ?></td>
                                            <td class="title"><a href="<?= get_permalink($value->ID) ?>" target="_blank" ><?= get_the_title($value->ID) ?></a></td>
                                            <td class="excerpt"><?= substr(get_the_excerpt($value->ID), 0,50); ?></td>
                                            <td class="price">$<?= number_format($price, 2) ?></td>
                                            <td><?= date('d F Y', strtotime($value->post_date)) ?></td>
                                            <td class="deadline_date"><?= date('d F Y', strtotime($deadline_date)) ?></td>
                                            <td>
                                                <a href="<?= home_url( 'view-quote-requests?id='.$value->ID.'&type='. $_GET['type'] ) ?>" class="view-record" data-id=<?= $value->ID ?> data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="View Quotes">
                                                    <i data-feather='eye'></i>
                                                </a>
                                            </td>
                                        </tr>

                                   <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                        <!-- administrator -->

                        <!-- vendor -->
                        <?php if( in_array('vendor', wp_get_current_user()->roles) ) { ?>
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Booking No</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Posted Date</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services->posts as $key => $value) { 
                                       
                                        $price =  get_post_meta($value->ID, 'price', true);
                                        $payment_status = get_post_meta($value->ID,'payment_status', true);
                                        $deadline_date = get_post_meta($value->ID,'deadline_date', true);
                                        $status = get_post_meta($value->ID,'user_'.get_current_user_id(), true);
                                        $quote = get_post_meta($value->ID,'quote');
                                        $vendor_id = array_column($quote, 'vendor_id');
                                        $current_user = get_current_user_id();
                                        // var_dump($price);

                                    //    $vendor =  new WP_User( $vendor_id ); 
                                    ?>
                                        <tr class="product-item">
                                            <td><?= $value->ID ?></td>
                                            <td class="title"><a href="<?= get_permalink($value->ID) ?>" target="_blank" ><?= get_the_title($value->ID) ?></a></td>
                                            <td class="excerpt"><?= get_the_excerpt($value->ID) ?></td>
                                            <td class="price">$<?= number_format($price, 2) ?></td>
                                            <td><?= date('d F Y', strtotime($value->post_date)) ?></td>
                                            <td class="deadline_date"><?= date('d F Y', strtotime($deadline_date)) ?></td>
                                            <td><?= in_array($current_user, $vendor_id) ? 'applied' : 'not-applied' ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary get_quote_button <?= in_array($current_user,$vendor_id) ? 'applied' : 'not-applied' ?>" data-id="<?= encryptData($value->ID) ?>" data-user="<?= encryptData($value->post_author) ?>" data-bs-toggle="modal" data-bs-target="#addNewCard">
                                                    Quote Proposal
                                                </button>
                                            </td>
                                        </tr>

                                   <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                        <!-- vendor -->

                        </div>

                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <h1 class="text-center mb-1" id="addNewCardTitle"></h1>
                    <p class="text-center priceshow"></p>
                    <!-- form -->
                    <!-- <form id="payout_request" class="row gy-1 gx-2 mt-75" onsubmit="return false"> -->
                    <form class="row gy-1 gx-2 mt-75 submit_quote">
                        <div class="mb-1 col-md-12">
                            <label class="form-label" for="payout_amount">Quote Price *</label>
                            <input type="number" name="quote_price" id="payout_amount" class="form-control" placeholder="Quote Price" />
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="payout_description">Comment *</label>
                            <textarea class="form-control" name="comment" id="payout_description" rows="3" placeholder="Comment"></textarea>
                        </div>
                       
                        <div class="col-12 text-center">
                            <input type="hidden" name="post_id" value="">
                            <input type="hidden" name="user_id" value="">
                            <input type="hidden" name="type" value="<?= $_GET['type'] ?>">
                            <input type="hidden" name="action" value="print_on_demand_quote">
                            <button type="submit" class="btn btn-primary me-1 mt-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary mt-1 reset_btn" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

        $(document).on( 'click', ".get_quote_button", function(){

            var mainServiceBox = $(this).parents('.product-item');
            var service_title = mainServiceBox.find(".title").text();
            var single_price_text = mainServiceBox.find(".price").text();
            var post_id = $(this).data('id');
            var user_id = $(this).data('user');
            $('input[name="post_id"]').val(post_id);
            $('input[name="user_id"]').val(user_id);
            $('#addNewCardTitle').text(service_title);
            $('#addNewCard .priceshow').text(single_price_text);
        });

        //quote
        $(".submit_quote").submit(function(e) {
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
          
            $.ajax({
                type: 'post',
                url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                data: form,
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
                    }
                    else{
                        // toastr.success(response.message, response.title);
                        if (response.auto_redirect) {
                            window.location.href = response.redirect_url;
                        }                    
                    } 
                },
                error : function(errorThrown){ 
                    console.log(errorThrown);
                    jQuery('body').waitMe('hide');

                }
            });
                
        });
                     
    </script>
    
</body>
<!-- END: Body-->