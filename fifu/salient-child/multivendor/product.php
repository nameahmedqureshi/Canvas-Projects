<?php 
/* Template Name: product */

    $get_current_user_id = get_current_user_id();
    if(in_array('administrator', wp_get_current_user()->roles)){
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'post_status'=> 'any',
        );
    }else {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'post_status'=> 'any',
            'author' => $get_current_user_id,
        );
    }
   
    $get_products = new WP_Query( $args );

    $subscription_plan = get_user_meta($get_current_user_id, 'subscription_plan', true);


    $current_date = date("Y-m-d");
    $start_featured_date = get_user_meta($get_current_user_id, 'start_featured_date', true);
    $end_featured_date = get_user_meta($get_current_user_id, 'end_featured_date', true);

    $current_timestamp = strtotime($current_date);
    $start_featured_timestamp = strtotime($start_featured_date);
    $end_featured_timestamp = strtotime($end_featured_date);

    if ($current_timestamp > $end_featured_timestamp) {  
        update_user_meta( $get_current_user_id, 'start_featured_date', date('Y-m-d', strtotime('+3 months', strtotime($end_featured_date))) );

        $start_featured_date = get_user_meta($get_current_user_id, 'start_featured_date', true);
 
        $update_end_featured_date = $subscription_plan == 'advanced' 
        ? date('Y-m-d', strtotime('+1 months', strtotime($start_featured_date))) 
        : ($subscription_plan == 'premium' 
            ? date('Y-m-d', strtotime('+45 days', strtotime($start_featured_date)))
            : null
        );
    
        update_user_meta( $get_current_user_id, 'end_featured_date', $update_end_featured_date );
    
    }



    include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <style>
        .fw-bold {
            font-size: 15px;
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
                <!-- users list start -->
                <section class="app-user-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h2s>Products</h2s>
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
                                            <?php if ($current_timestamp >= $start_featured_timestamp && $current_timestamp <= $end_featured_timestamp) { ?>
                                            <th>Featured</th>
                                            <?php } ?>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>SKU</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Vendor</th>
                                            <th>Usertype</th>
                                            <th>Status</th>
                                            <th>Published</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  foreach ($get_products->posts ?? [] as $key => $value) {
                                             $product = wc_get_product( $value->ID );
                                             

                                             $product_image =  wp_get_attachment_url($product->image_id);
                                             $author_id = $value->post_author;
                                             $is_featured = get_post_meta($value->ID, 'featured_product', true);
                                             $first_name = get_user_meta($author_id, 'first_name', true);
                                             $last_name = get_user_meta($author_id, 'last_name', true);
                                             $user_type = get_user_meta($author_id, 'user_type', true);
                                             //  $date=$product->date;
                                            //  var_dump( $value);
                                            //  exit;
                                            $product_status = ($product->status == 'publish') ? 'badge-light-success' : 
                                            (($product->status == 'pending') ? 'badge-light-warning' : 
                                            (($product->status == 'draft') ? 'badge-light-dark' : ''));
                                        ?>
                                        <tr>
                                            <?php if ($current_timestamp >= $start_featured_timestamp && $current_timestamp <= $end_featured_timestamp) { ?>
                                                <td><input type="checkbox" class="featured" name="featured[]" value="<?= $value->ID ?>" <?= $is_featured == 'true' ? 'checked' : '' ?>  ></td>
                                            <?php } ?>

                                            <td><?= $value->ID ?></td>
                                            <td class="pro_name">
                                                <img src="<?= !empty($product_image) ? $product_image : $directory_url.'/assets/images/no-preview.png' ?>" height="25" width="25" alt="" />
                                                <span class="fw-bold"><?= $product->name  ?></span>
                                            </td>
                                            <td class="sku"><?= !empty($product->sku) ? $product->sku : '---' ?></td>
                                            <td class="price">£<?= $product->regular_price  ?></td>
                                            <td><span class="badge rounded-pill badge-light-secondary me-1"><?= $product->stock_status ?></span></td>
                                            <td><?= !empty($first_name ) ? $first_name . ' ' . $last_name: '---'  ?></td>
                                            <td><?= $user_type  ?></td>
                                            <td><span class="badge rounded-pill <?= $product_status ?> me-1"><?= $product->status ?></span></td>
                                            <td class="publish_date"><?= date('d M Y', strtotime($value->post_date) ); ?></td>
                                            <td>
                                                <a href="<?= get_the_permalink($value->ID) ?>" target="_blank" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="View">
                                                    <i data-feather='eye'></i>
                                                </a> 

                                                <a href="<?= home_url("add-product/?id=".$value->ID) ?>" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit value Detail">
                                                    <i data-feather='edit'></i>

                                                </a>

                                                <a href="#!" data-id="<?= $value->ID ?>" class="delete-record" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete value">
                                                    <i data-feather='trash-2'></i>
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
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

   

    <?php include "includes/scripts.php"; ?>

    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
    <!-- {{-- <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script> --}} -->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>

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
                    text: 'Add Product',
                    className: 'add-new btn btn-primary',
                    attr: {
                        // 'data-bs-toggle': 'modal',
                        // 'data-bs-target': '#addservicemodal'
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
            ],
            });

            $(document).on("click",".add-new",function() {
                $(location).prop('href', "<?= home_url("add-product/") ?>");
            });

            table.on('draw', function () {
                feather.replace({
                    width: 14,
                    height: 14
                });
            });
            // featured
            $(document).on("change", ".featured", function(e) {
                var product_id = $(this).val();
                var status = $(this).is(':checked') ? 'checked' : 'not_checked';
              
                var thiss = jQuery(this);
                jQuery('.app-user-list').waitMe({
                    effect: 'facebook',
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
                        action: 'featured_product',
                        product_id: product_id,
                        status: status,
                    },
                    dataType: 'json',
                    success: function(response) {
                        jQuery('.app-user-list').waitMe('hide');
                        // console.log(response);
                        toastr.success(response.message, "Success");
                      
                    },
                    error: function(errorThrown) {
                        console.log(errorThrown);
                        jQuery('.app-user-list').waitMe('hide');
                    }
                });
                
            });


            $(document).on("click", ".delete-record", function(e) {
                if (confirm("Are you sure?")) {
                    var pro_id = $(this).attr('data-id');
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
                            action: 'delete_product',
                            product_id: pro_id,
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

</html>