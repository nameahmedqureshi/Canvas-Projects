<?php 
/* Template Name: reviews */
include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/modal-create-app.css">
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
                            <h2>Reviews</h2>
                            <div class="row">
                                <div class="col-md-4 user_role"></div>
                                <div class="col-md-4 user_plan"></div>
                                <div class="col-md-4 user_status"></div>
                            </div>
                        </div>

                        <!-- Product Reviews -->
                        <?php if( isset($_GET['type']) && $_GET['type'] == 'product' ) { ?>

                            <div class="card-datatable table-responsive pt-0">
                                <div class="table-responsive">
                                    <table class="datatables-product table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product</th>
                                                <th>Rating</th>
                                                <th>Review</th>
                                                <th>User</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Ensure WooCommerce is active
                                            if (class_exists('WooCommerce')) {
                                                // Get product reviews
                                                $reviews = get_comments(array(
                                                    // 'status' => 'approve', // Approved reviews only
                                                    'post_type' => 'product', // Reviews for WooCommerce products only
                                                    'number' => 0, // Get all reviews
                                                    'user_id' => in_array('administrator', wp_get_current_user()->roles) ? '': get_current_user_id()

                                                ));
                                                // echo "<pre>";
                                                // var_dump($reviews);

                                                if (!empty($reviews)) {
                                                    foreach ($reviews as $review) {
                                                        // Get product information
                                                        $product = wc_get_product($review->comment_post_ID);
                                                        if ($product) {
                                                            $rating = intval(get_comment_meta($review->comment_ID, 'rating', true));
                                                            $product_url = get_permalink($product->get_id());
                                                            ?>
                                                       
                                                            <tr>
                                                                <td><?= $review->comment_post_ID ?></td>
                                                                <td class="product">
                                                                    <span class="fw-bold"><?php echo esc_html($product->get_name()); ?></span>
                                                                </td>
                                                                <td class="product_rating"><?php echo esc_html($rating); ?></td>
                                                                <td class="product_reviews" style="max-width:350px"><?php echo esc_html($review->comment_content); ?></td>
                                                                <td class="user_name"><?php echo esc_html($review->comment_author); ?></td>
                                                                <td>
                                                                    <a href="<?= esc_url($product_url); ?>" target="_blank" class="btn btn-outline-primary waves-effect">
                                                                        <i data-feather='eye'></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                } 
                                            } else {
                                                echo '<tr><td colspan="5">WooCommerce is not active.</td></tr>';
                                            }
                                            // var_dump($product);
                                            // exit;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        <?php } ?>

                        <!-- Store Reviews -->
                        <?php if( isset($_GET['type']) && $_GET['type'] == 'store' ) { ?>
                            
                            <div class="card-datatable table-responsive pt-0">
                                <div class="table-responsive">
                                    <table class="datatables-store table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Rating</th>
                                                <th>Review</th>
                                                <th>User</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                // Get product reviews
                                                $args = array(
                                                    'post_type' => 'feedbacks', // Reviews for WooCommerce products only
                                                    'posts_per_page' => -1, // Get all reviews
                                                    'post_status' => 'any', 
                                                    'author' =>  in_array('administrator', wp_get_current_user()->roles) ? '': get_current_user_id()
                                                );
                                                $get_reviews = new WP_Query($args);
                                                foreach ($get_reviews->posts ?? [] as $key => $value) { $review_id = $value->ID; ?>
                                                    <tr>
                                                        <td><?= $review_id ?></span></td>
                                                        <td class="product_rating"><?= get_post_meta($review_id, 'rating', true) ?></td>
                                                        <td class="product_reviews" style="max-width:350px"><?= $value->post_content ?></td>
                                                        <td class="user_name"><?= the_author_meta( 'display_name', $value->post_author ); ?></td>
                                                        <td class="status"><?= $value->post_status == "publish" ? 'Approved' : '<select class="form-select review_status" data_id="'.$value->ID.'" id=""><option disabled selected>Pending</option> <option value="publish">Approve</option> </select>'?></td>

                                                    </tr>
                                                <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
        <!-- add new card modal  -->
        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <h1 class="text-center mb-1" id="addNewCardTitle">Reply to Review</h1>
                        <!-- form -->
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <div class="input-group input-group-merge">
                                <label for="reply">Here you can leave a publicly visible reply. Please note that you can only reply once.</label>
                                <textarea id="reply" name="reply" rows="4" cols="50" style="width: 100%;">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-1 mt-1">Sand</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <!--/ add new card modal  -->
            <!-- add new card modal  -->
        <div class="modal fade" id="pricingModal" tabindex="-1" aria-labelledby="pricingModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <h1 class="text-center mb-1" id="addNewCardTitle">Report Review</h1>
                        <!-- form -->
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <div class="input-group input-group-merge">
                                <label for="reporting">Enter the reason you are reporting this review...</label>
                                <textarea id="reporting" name="reporting" rows="4" cols="50" style="width: 100%;">
                                </textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-1 mt-1">Sand</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ add new card modal  -->

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
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/modal-add-new-cc.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/page-pricing.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/modal-add-new-address.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/modal-create-app.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/modal-two-factor-auth.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/modal-edit-user.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/modal-share-project.js"></script>

    <script>
        var type = "<?= $_GET['type']; ?>";
        var datatable_class = type == 'product' ? 'datatables-product' : 'datatables-store';
        var table = $('.'+datatable_class).DataTable({

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

            $(document).on("change", ".review_status", function(e) {
                var post_id = jQuery(this).attr("data_id");
                if (confirm("Are you sure?")) {
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
                            action: 'review_status_update', 
                            post_id: post_id, 
                        },
                        dataType: 'json',
                        success: function(response) {
                            jQuery('body').waitMe('hide');
                            // console.log(response);
                            toastr.success(response.message, "Success");
                            thiss.parents('tr').find('.status').html(response.review_status);
                            // if (response.status) {
                            //     thiss.parents('tr').fadeOut(1000);
                            // }
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