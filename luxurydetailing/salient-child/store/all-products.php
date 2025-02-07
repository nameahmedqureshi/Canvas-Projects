<?php /* Template Name: S Product All Products */ ?>
<?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1
    );
    $get_products = new WP_Query( $args );

    // var_dump($get_products);

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <style>
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
                                        <th>Id</th>
                                        <th>Featured Image</th>
                                        <th>Product</th>
                                        <!-- <th>Category</th> -->
                                        <th>Seller </th>
                                        <th>Sale Price</th>
                                        <th>Price</th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                   
                                    foreach ($get_products->posts ?? [] as $key => $value) {
                                        $product = wc_get_product( $value->ID );
                                        $product_image =  wp_get_attachment_url($product->image_id);
                                        $sale_price = $product->sale_price;
                                        //  var_dump($product);
                                       // exit;
                                    ?>

                                        <tr>
                                            <td><?= $product->id ?></td>
                                            <td><img class="file-image" src="<?=  !empty($product_image) ? $product_image : $directory_url.'/assets/images/no-preview.png' ?>" alt="your image" /></td>
                                            <td><?= $product->name  ?></td>
                                            <!-- <td><?= $product->name ?></td> -->
                                            <td><?= the_author_meta( 'user_nicename' , $value->post_author );  ?></td>
                                            <td><?=!empty($sale_price) ? $sale_price : '---' ?></td>
                                            <td><?= $product->regular_price ?></td>
                                            <td>
                                                <a href="<?= home_url('add-product?id='.$product->id) ?>" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit value Detail">
                                                    <i data-feather='edit'></i>
                                                </a>

                                                <a href="#!" class="delete-record delete_product" data-bs-toggle="tooltip" data-id="<?= $product->id ?>" data-bs-placement="top" title="" data-bs-original-title="Delete value">
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

    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>

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

        var new_product_url = "<?=  home_url('add-product') ?>";
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
                    text: 'Add New Product',
                    className: 'add-new btn btn-primary',
                    attr: {
                        // 'data-bs-toggle': 'modal',
                        // 'data-bs-target': '#addservicemodal'
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
               
            ],
            });

            $(document).on("click", ".add-new", function() {
                $(location).prop('href', new_product_url);
            });

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
    </script>
    
</body>
<!-- END: Body-->

</html>