<?php /* Template Name: service orders */ ?>
<?php
// Check if the current user is logged in
if (!is_user_logged_in()) {
    wp_redirect(home_url('login-account/'));
    exit;
}

// Prepare arguments for the query
$args = array(
    'post_type' => 'orders',
    'post_status' => 'any',
    'posts_per_page' => -1,
);

if (isset($_GET['type'])) {
    $args['meta_query'] = array(
        array(
            'key' => 'service_type',
            'value' => $_GET['type'],
            'compare' => '='
        )
    );
}

    // Get the current user's information
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $roles = $current_user->roles;

// If the user is not an administrator, add a meta query to filter orders by user ID
if (!in_array('administrator', $roles)) {
    $args['author'] = $user_id;
}


// Query the orders
$orders = new WP_Query($args);
?>

<?php include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <style>
        td.post_status {
            text-transform: capitalize;
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

                <!-- add new card modal  -->
                <!-- <div class="modal fade" id="videoPopup" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                    <div class="modal-dialog video_popup modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-sm-5 mx-50 pb-5">
                                <video width="100%" height="100%" controls style="border-radius: 15px;">
                                    <source src="" type="video/mp4" >
                                    Your browser does not support the video tag.
                                </video>
                            
                            </div>
                        </div>
                    </div>
                </div> -->
                <!--/ add new card modal  -->
                <!-- users list start -->
                <section class="app-user-list">
                  
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h4 class="card-title">Services</h4>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Service Name</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Service Date</th>
                                        <th>Time</th>
                                        <th>User Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($orders->posts ?? [] as $key => $value) {
                                        $order_id = $value->ID;
                                        $service_id = get_post_meta($order_id, 'service_id', true);
                                        $service_user_id = get_post_meta($order_id, 'user_id', true);
                                        $service_name = get_post_meta($order_id, 'service_name', true);
                                        $servic_type = get_post_meta($service_id, 'servic_type', true);
                                        $service_price = get_post_meta($order_id, 'service_price', true);
                                        $first_name = get_post_meta($order_id, 'first_name', true);
                                        $last_name = get_post_meta($order_id, 'last_name', true);
                                        $date = get_post_meta($order_id, 'date', true);
                                        $slots = get_post_meta($order_id, 'slots', true);
                                        $special_requests = get_post_meta($order_id, 'client_requests', true);
                                        $order_status = get_post_meta($order_id, 'order_status', true);
                                        $quantity = get_post_meta($order_id, 'service_dna', true);
                                        $upsell_amount = get_post_meta($order_id, 'upsell_amount', true);
                                        if (is_array($quantity)) {
                                            $count = count($quantity);
                                            
                                            
                                        }
                                        // var_dump($servic_type);
                                        $user_name = $first_name;
                                        ?>
                                        <tr>
                                            <td><?= $order_id ?></td>
                                            <td><?= $service_name ?></td>
                                            <td class="type"><?= $servic_type == 'in_person' ? 'In person' : ucfirst($servic_type) ?></td>
                                            <td>$<?= !empty($upsell_amount) ? $upsell_amount : (is_array($quantity) ? $service_price * $count : $service_price) ?></td>
                                            <td><?= !empty($date) ? $date : '-' ?></td>
                                            <td><?= !empty($slots) ? $slots : '-----' ?></td>
                                            <td><?= $first_name ?></td>
                                            <td class="order_status">
                                                <?php if (in_array('administrator', $roles)) { ?>
                                                    <?= $order_status == "Completed" ? $order_status : '<select class="form-control service_status" data-id="' . $value->ID . '" user-id="' . $service_user_id . '"><option disabled selected>Pending</option> <option value="done">Complete</option> </select>' ?>
                                                <?php } else { ?>
                                                    <?= $order_status ?>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                
                                                <a href="<?= home_url('service-view-orders/?id=' . $order_id) ?>" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Order Detail">
                                                    <i data-feather='eye'></i>
                                                </a>
                                                <?php if($servic_type == 'recorded') {
                                                    $uploaded_video =  get_post_meta($order_id , 'uploaded_recorded_video', true);
                                                    $get_video_url =  wp_get_attachment_url(  $uploaded_video  );   
                                                ?>

                                                <a href="<?= home_url('service-view-orders/?id=' . $order_id) ?>#video_container" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Order Detail">
                                                    <i data-feather='play'></i>
                                                </a>
                                                <!-- <a href="#!" recording_id="<?=  $order_id ?>" data-url="<?=  $get_video_url  ?>" class="recorded_video_class" data-bs-placement="top" title="Video"  data-bs-toggle="modal" data-bs-target="#videoPopup">
                                                    <i data-feather='play'></i>
                                                </a> -->
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
               
            ],
        });
        table.on('draw', function () {
            feather.replace({
                width: 14,
                height: 14
            });
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
                        action: 'delete_services',
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

        // $(document).on("change", ".service_status", function(e) {

        //     var post_id = jQuery(this).attr("data-id");
        //     var user_id = jQuery(this).attr("user-id");
          
        //     Swal.fire({
        //         title: "An input!",
        //         text: "Write something interesting:",
        //         input: 'number',
        //         showCancelButton: true,
        //         animation: "slide-from-top",      
        //     }).then((result) => {
                
        //         if (!result.value) {
        //             return "You need to write something!";
        //         } else {
                   
        //             if (confirm("Are you sure?")) {
        //                 var thiss = jQuery(this);
        //                 jQuery('body').waitMe({
        //                     effect: 'bounce',
        //                     text: '',
        //                     bg: 'rgba(255,255,255,0.7)',
        //                     color: '#000',
        //                     maxSize: '',
        //                     waitTime: -1,
        //                     textPos: 'vertical',
        //                     fontSize: '',
        //                     source: '',
        //                 });
        //                 jQuery.ajax({
        //                     type: 'post',
        //                     url: "<?= admin_url('admin-ajax.php') ?>",
        //                     data: {
        //                         action: 'service_status_update', 
        //                         post_id: post_id, 
        //                         user_id: user_id, 
        //                     },
        //                     dataType: 'json',
        //                     success: function(response) {
        //                         jQuery('body').waitMe('hide');
        //                         // console.log(response);
        //                         if (response.status) {
        //                                 toastr.success(response.message, "Success");
        //                                 thiss.parents('tr').find('.order_status').html(response.order_status);
        //                         } else {
        //                                 toastr.error(response.message, "Error");
        //                         }
        //                     },
        //                     error: function(errorThrown) {
        //                         console.log(errorThrown);
        //                         jQuery('body').waitMe('hide');
        //                     }
        //                 });
        //             }

        //         }
        //     });
        //     return false;
        // });

        $(document).on("change", ".service_status", function(e) {
            var post_id = $(this).attr("data-id");
            var user_id = $(this).attr("user-id");
            var type = $(this).parents('tr').find('.type').text();
            // console.log("type", type);
            if(type == 'In person'){

                Swal.fire({
                    title: "Enter an Amount",
                    text: "How much do you charge for this?",
                    input: 'number',
                    inputPlaceholder: 'Enter the amount',
                    showCancelButton: true,
                    animation: false,
                    inputValidator: (value) => {
                        if (!value) {
                            return "You need to enter a number!";
                        }
                    }
                }).then((result) => {
                    if (result.value) {
                        processAjaxRequest(post_id, user_id, result.value, $(this));
                    }
                });
                } else {
                // Direct AJAX call if type is not 'In_person'
                processAjaxRequest(post_id, user_id, null, $(this));
            }

            return false;
        });

        // Function to handle the AJAX call
        function processAjaxRequest(post_id, user_id, amount, thiss) {
            if (confirm("Are you sure?")) {
                $('body').waitMe({
                    effect: 'bounce',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                });

                $.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php') ?>",
                    data: {
                        action: 'service_status_update',
                        post_id: post_id,
                        user_id: user_id,
                        amount: amount // Amount can be null if not 'In_person'
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('body').waitMe('hide');
                        if (response.status) {
                            toastr.success(response.message, "Success");
                            thiss.parents('tr').find('.order_status').html(response.order_status);
                        } else {
                            toastr.error(response.message, "Error");
                        }
                    },
                    error: function(errorThrown) {
                        console.log(errorThrown);
                        $('body').waitMe('hide');
                    }
                });
            }
        }


        // $(document).on("click", ".recorded_video_class", function(e) {
        //   var video_url = $(this).attr('data-url');
        //   console.log("video_url", video_url);
        //   if(video_url){
        //     $('.video_popup').find('source').attr('src',video_url);

        //   } else {
        //     alert("Video Not uploaded yet");
        //     $('.modal').hide();
        //   }

        // });

    </script>
    
</body>
<!-- END: Body-->

</html>