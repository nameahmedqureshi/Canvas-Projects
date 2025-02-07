<?php /* Template Name: S Product All Products */ ?>
<?php
   // $author_type = isset($_GET['type']) == 'vendor' ? get_current_user_id() : 'any';
   $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status'=> 'publish',
        'meta_query'     => [
            [
                'key'      => 'product_type',
                'value'      => $_GET['type'] ?? 'creations',
                'compare'  => '=',
            ]
        ],
    ];
   if(in_array('vendor', wp_get_current_user()->roles)){
        $args['author'] =  get_current_user_id();
    }
    $get_products = new WP_Query( $args );
    // var_dump($get_products);
?>
<!-- BEGIN: Head-->
<?php include "includes/styles.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <style>
        tr.sponsored .sponsered_product {
            pointer-events: none;
            opacity: 0.3;
        }
        div#card-element {
            padding: 15px;
            margin-bottom: 10px;
            background: aliceblue;
        }
        small.emp_post.text-truncate.text-muted {
            text-align: center;
        }
        .fw-bold {
            font-size: 15px;
        }
        img.file-image {
            height: 30px;
            width: 40px;
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
                            <h4 class="card-title">Products</h4>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <!-- <th>SKU</th> -->
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <!-- <th>Vendor</th> -->
                                        <!-- <th>Usertype</th> -->
                                        <th>Status</th>
                                        <th>Published</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($get_products->posts ?? [] as $key => $value) {
                                        $product = wc_get_product( $value->ID );
                                        $product_image =  wp_get_attachment_url($product->image_id);
                                        $author_id = $value->post_author;
                                        $first_name = get_user_meta($author_id, 'first_name', true);
                                        $last_name = get_user_meta($author_id, 'last_name', true);
                                        $user_type = get_user_meta($author_id, 'user_type', true);
                                        $product_status = ($product->status == 'publish') ? 'badge-light-success' : 
                                        (($product->status == 'pending') ? 'badge-light-warning' : 
                                        (($product->status == 'draft') ? 'badge-light-dark' : ''));
                                        $sponsored_end_date = get_post_meta($value->ID, 'sponsored_end_date', true);
                                        $sponsored_start_date = get_post_meta($value->ID, 'sponsored_start_date', true);
                                        $current_date = date('Y-m-d');
                                        // var_dump($current_date);
                                        $is_sponsored = strtotime($current_date) >= strtotime($sponsored_start_date) && strtotime($current_date) <= strtotime($sponsored_end_date) ? 'sponsored' : '';
                                        // var_dump($is_sponsored);
                                        if( empty($is_sponsored)){
                                            update_post_meta($value->ID, 'sponsored', 'expired');
                                            // delete_post_meta($value->ID, 'sponsored', true);
                                        }
                                        // var_dump($product);
                                        
                                        // Determine the stock message
                                        if ($product->stock_status == 'instock' && $product->stock_quantity != NULL ) {
                                            $stock_check = $product->stock_quantity;
                                        
                                        } elseif ($product->stock_status == 'outofstock') {
                                            $stock_check = 'No Stock'; 
                                        }  elseif ($product->stock_status == 'instock' && $product->stock_quantity == NULL) {
                                            $stock_check = 'Unlimited'; 
                                        } 
                                    ?>
                                        <tr class="<?= $is_sponsored ?>">
                                            <td><?= $is_sponsored == 'sponsored' ? " <i data-feather='bookmark'></i> " : '' ?><?= $product->id ?></td>
                                            <td>
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="avatar  me-1"><img src="<?= !empty($product_image) ? $product_image : $directory_url.'/assets/images/no-preview.png' ?>" height="32" width="32" alt="" /></div>
                                                    <div class="d-flex flex-column">
                                                        <span class="emp_name text-truncate fw-bold"><?= $product->name  ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- <td class="sku"><?= !empty($product->sku) ? $product->sku : '---' ?></td> -->
                                            <td class="price">$<?= number_format($product->regular_price, 2)  ?></td>
                                            <td><span class="badge rounded-pill badge-light-secondary me-1"><?= $product->stock_status ?> ( <?= $stock_check  ?> )</span></td>
                                            
                                            <!-- <td><?= !empty($first_name ) ? $first_name . ' ' . $last_name: '---'  ?></td> -->
                                            <!-- <td><?= !empty($user_type ) ? $user_type : '---' ?></td> -->
                                            <td><span class="badge rounded-pill <?= $product_status ?> me-1"><?= $product->status == 'publish' ? 'Published' : $product->status ?></span></td>
                                            <td class="publish_date"><?= date('d M Y', strtotime($value->post_date) ); ?></td>
                                            <td>
                                                <a href="<?= get_the_permalink($value->ID) ?>" target="_blank" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="View">
                                                    <i data-feather='eye'></i>
                                                </a> 
                                                <a href="<?= home_url('add-product?id='.$product->id.'&type='.$_GET['type']) ?>" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit value Detail">
                                                    <i data-feather='edit-2'></i>
                                                </a>
                                                <a href="#!" class="delete-record delete_product" data-bs-toggle="tooltip" data-id="<?= $product->id ?>" data-bs-placement="top" title="" data-bs-original-title="Delete">
                                                    <i data-feather='trash-2'></i>
                                                </a>
                                                <?php  if(in_array('vendor', wp_get_current_user()->roles)){ ?>
                                                <a href="#!" class="sponsered_product" data-id="<?= $product->id ?>" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#sponsored" title="" data-bs-original-title="Add this product as a Sponsered product">
                                                    <i data-feather='zap'></i>
                                                </a>
                                                <?php } ?>
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
    <!-- Sponsored Product  -->
    <div class="modal fade" id="sponsored" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <h1 class="text-center mb-1" id="addNewCardTitle">Sponsored for Just $1!</h1>
                    <p class="text-center">Enter your card details</p>
                    <!-- form -->
                    <!-- <form id="payout_request" class="row gy-1 gx-2 mt-75" onsubmit="return false"> -->
                    <form id="sponsered_product">
                        <div class="mb-1 col-md-12">
                            <div id="card-element"></div> 
                        </div>
                        <div class="col-12 text-center">
                            <input type="hidden" class="product_id" name="product_id" value="">
                            <input type="hidden" name="product_type" value="<?= $_GET['type'] ?>">
                            <input type="hidden" name="action" value="sponsered_product">
                            <button type="submit" class="btn btn-primary me-1 mt-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary mt-1 reset_btn" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Sponsored Product  -->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <?php 
        $test_credentials = get_field( 'test_credentials' , 'option');
        $publishable_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_private_key' , 'option') : get_field( 'live_stripe_private_key' , 'option');
    ?>
    <?php include "includes/scripts.php"; ?>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function(){
            let stripe = "";
            let cardElement = "";
            $(document).on("click", '.sponsered_product', function(e){
                var product_id = $(this).attr('data-id');
                $('.product_id').val(product_id);
                // stripe 
                let pub_key = "<?= $publishable_key ?>";
                console.log("pub_key",pub_key);
                stripe = Stripe(pub_key);
                let elements = stripe.elements();
                cardElement = elements.create('card', {
                    hidePostalCode: true,
                });
                cardElement.mount('#card-element');
            });
            $("#sponsered_product").submit(function(e) {
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
                        toastr.error(result.error.message, "Error");
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
           // var new_product_url = "<?=  home_url('add-product') ?>";
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
            // Buttons with Dropdown
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                // {
                //     text: 'Add New Product',
                //     className: 'add-new btn btn-primary',
                //     attr: {
                //         // 'data-bs-toggle': 'modal',
                //         // 'data-bs-target': '#addservicemodal'
                //     },
                //     init: function(api, node, config) {
                //         $(node).removeClass('btn-secondary');
                //     }
                // }
            ],
            });
            // $(document).on("click", ".add-new", function() {
            //     $(location).prop('href', new_product_url);
            // });
            table.on('draw', function () {
            feather.replace({
                width: 14,
                height: 14
            });
            });
            $(document).on("click", ".delete_product", function(e) {
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
        });
    </script>
</body>
<!-- END: Body-->