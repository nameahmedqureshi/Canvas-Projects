<?php /* Template Name: Invoices */ ?>
<?php

include "includes/styles.php";

$args = [
    'post_type'   =>  'invoices',
    'posts_per_page' => -1,
    'post_status' => 'publish'
];
if(in_array('customer', wp_get_current_user()->roles)) {
    $args['meta_query']  = [
        [
            'key'      => 'user_id',
            'value'    => get_current_user_id(),
            'compare'  => '=',
        ]
    ];
}

$invoices = new WP_Query($args);
// var_dump($invoices->found_posts);
?>


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
            
            <?php if(in_array('administrator', wp_get_current_user()->roles)) { ?>
            <!-- Modal -->
            <div class="modal fade" id="inlineForm" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-sm-5 mx-50 pb-5">
                            <h1 class="text-center mb-1" id="addNewCardTitle">Invoice Form</h1>
                            <p class="text-center">Enter following details to create invoice for user</p>
                            <!-- form -->
                            <!-- <form id="payout_request" class="row gy-1 gx-2 mt-75" onsubmit="return false"> -->
                            <?php
                            $args = array(
                                'role__in'    => 'customer',
                                'order'       => 'ASC',
                                '_registered' => date( 'Y-m-d' ),
                            );
                            
                            $users = get_users($args);
                            ?>
                            <form id="create_invoice" class="row gy-1 gx-2 mt-75">
                                <div class="col-12">
                                    <label class="form-label" for="basicSelect">Select User *</label>
                                    <select name="user_id" class="form-select" id="basicSelect">
                                        <?php  foreach ($users as $key => $user) { ?>
                                        <option  value="<?= $user->ID ?>" ><?= $user->display_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="payout_description">Title *</label>

                                    <input type="text" name="title" placeholder="Add Title" class="form-control" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="payout_description">Description *</label>
                                    <textarea class="form-control"  placeholder="Add Description"  name="description" rows="6" ></textarea>
                                </div>
                                <div class="mb-1 col-md-12">
                                    <label class="form-label" for="payout_amount">Amount ($) *</label>
                                    <input type="number" name="amount" placeholder="Add Amount" class="form-control" />
                                </div>
                            
                                <div class="col-12 text-center">
                                    <input type="hidden" name="action" value="create_invoice">
                                    <button type="submit" class="btn btn-primary me-1 mt-1">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary mt-1 reset_btn" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
             <?php } ?>
            <div class="content-body">
                <!-- users list start -->
                <section class="app-user-list">
                  
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h4 class="card-title">Invoices</h4>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>Creation Date</th>
                                        <th>Completion Date</th>
                                        <th>Amount </th>
                                        <th>Status </th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                   
                                   foreach ($invoices->posts ?? [] as $key => $value) { 
                                        $id = $value->ID; 
                                        $completion_date =  get_post_meta($id, 'completion_date', true);  
                                        $user_id =  get_post_meta($id, 'user_id', true);  
                                        $fname =  get_user_meta($user_id, 'first_name', true); 
                                        $lname =  get_user_meta($user_id, 'last_name', true);  
                                        $fullname =  sprintf('%s %s',$fname, $lname  );
                                        $payment_link = get_post_meta($id, 'payment_link', true);  ?>
                                        <tr>
                                            <td><?= $id ?></td>
                                            <td><?= get_the_title($id); ?></td>
                                            <td><?= $fullname; ?></td>
                                            <td><?= date('d F Y', strtotime($value->post_date)) ?></td>
                                            <td><?= !empty($completion_date) ? $completion_date : '----'  ?></td>
                                            <td>$<?= get_post_meta($id, 'amount', true); ?></td>
                                            <td><?= get_post_meta($id, 'status', true); ?></td>
                                            <td>
                                                <a href="<?= home_url('invoice-detail?id='. $id ) ?>" class="invoice"  data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="View Invoice">
                                                    <i data-feather='eye'></i>
                                                </a>
                                                <a href="<?= $payment_link ?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Pay">
                                                    <i data-feather='link'></i>
                                                </a>
                                                <?php if(in_array('administrator', wp_get_current_user(  )->roles)) { ?>
                                                    <a href="#!" data-id="<?= $id ?>"  class="delete"  data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete Invoice">
                                                        <i data-feather='trash-2'></i>
                                                    </a>
                                                <?php } ?>
                                               
                                            </td>
                                        </tr>

                                   <?php }  ?>
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

        var tableConfig = {
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
                'pdfHtml5'
            ]
        };

        <?php if(in_array('administrator', wp_get_current_user()->roles)) { ?>
            tableConfig.buttons.push({
                text: 'Add New Invoice',
                className: 'add-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#inlineForm'
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            });
        <?php } ?>

        var table = $('.datatables-basic').DataTable(tableConfig);

        table.on('draw', function () {
            feather.replace({
                width: 14,
                height: 14
            });
        });
        

        $("#create_invoice").submit(function(e) {
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
                    //  console.log(response);
                    if (!response.status) {
                        toastr.error(response.message, "Error");


                    } else{
                            if (response.auto_redirect) {window.location.href = response.redirect_url;}
                            else{ 
                                toastr.success(response.message, response.title);
                            }
                        } 
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                    $('body').waitMe('hide');
                }
            });
        });

        $(document).on("click", ".delete", function(e) {
            if (confirm("Are you sure?")) {
                var invoice_id = $(this).attr('data-id');
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
                        action: 'delete_invoice',
                        invoice_id: invoice_id,
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

        // $('.copy').on('click', function(e) {
        //     e.preventDefault();
        //     var link = $(this).data('link');
        //     var tempInput = $('<input>');
        //     $('body').append(tempInput);
        //     tempInput.val(link).select();
        //     document.execCommand('copy');
        //     tempInput.remove();
        //     toastr.success('Link copied to clipboard');
        // });
        
    </script>
    
</body>
<!-- END: Body-->

<!-- </html> -->