<?php
/* Template Name: Service View Orders */
$user = wp_get_current_user();
$account_status = get_user_meta($user->ID, 'account_status', true);
if (!in_array('administrator', $user->roles)) {
               
    if ($account_status == "Not Active") {
       wp_logout(  );
       wp_redirect(home_url('/login-account'));
        exit;
    }
}

$post_id = $_GET["id"];
$post_data = get_post($post_id);
$meta = get_post_meta($post_id);
$service_type =  get_post_meta($meta["service_id"][0], 'servic_type', true);
$uploaded_video =  get_post_meta($post_id , 'uploaded_recorded_video', true);
$get_video_url =  wp_get_attachment_url(  $uploaded_video  );
$upsell_amount = get_post_meta($post_id, 'upsell_amount', true);
?>

<?php include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <style>
        /* .dna_list{
            text-align: left;
        } */
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
        table.table tr th:first-child {
            width: 17%;
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
                <section>
                    <div class="card order-card">
                        <div class="card-header">
                            <h2 class="card-title">Order Details</h2>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mb-3">
                                <h4 class="card-title">Service Information</h4>
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="text-start">Booking ID</th>
                                            <td>#<?= $post_id ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Service Name</th>
                                            <td><?= get_the_title($meta["service_id"][0] ) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Service Price</th>
                                            <td>$<?= get_post_meta($post_id, 'service_price', true) ?> <?= !empty($upsell_amount) ? ' (Upsell $'.$upsell_amount.') ' : ''  ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Service Type</th>
                                            <td><?= ucfirst(get_post_meta($post_id, 'service_type', true)) ?></td>
                                        </tr>
                                        <?php if ($meta['service_type'][0] != "recorded") { ?>
                                            <tr>
                                                <th scope="row" class="text-start">Service Date</th>
                                                <td><?= get_post_meta($post_id, 'date', true) ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="text-start">Service Time</th>
                                                <td><?= get_post_meta($post_id, 'slots', true) ?></td>
                                            </tr>
                                        <?php } if (isset($meta['service_dna'][0]) && $meta['service_dna'][0]) {
                                                    $dna = unserialize($meta['service_dna'][0]); ?>

                                                <tr>
                                                    <th scope="row" class="text-start">DNA</th>
                                                    <td>
                                                        <?php if (is_array($dna)): ?>
                                                            <ul>
                                                                <?php foreach ($dna as $item) echo "<li class='dna_list'>$item</li>"; ?>
                                                            </ul>
                                                        <?php else: ?>
                                                            <?= $dna ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>

                                        <!-- <tr>
                                            <th scope="row" class="text-start">DNA</th>
                                            <td><?= is_array($dna) ? implode(', <br>', $dna ) : $dna ?></td>
                                        </tr> -->
                                        <?php } ?> 
                                        <tr>
                                            <th scope="row" class="text-start">Status</th>
                                            <td><?= get_post_meta($post_id, 'order_status', true) ?></td>
                                        </tr>

                                        <tr>
                                            <th scope="row" class="text-start">Client Requests</th>
                                            <td><?= apply_filters('the_content', get_post_field('post_content', $post_id)) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive mb-3">
                                <h4 class="card-title">User Information</h4>
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="text-start">First Name</th>
                                            <td><?= get_post_meta($post_id, 'first_name', true) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Last Name</th>
                                            <td><?= get_post_meta($post_id, 'last_name', true) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">User Email</th>
                                            <td><?= get_post_meta($post_id, 'user_email', true) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start">Phone Number</th>
                                            <td><?= get_post_meta($post_id, 'phone', true) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php if($service_type == 'recorded') { ?>
                            <div class="table-responsive mb-3" id="video_container">
                                
                                <?php if( !in_array('subscriber', wp_get_current_user()->roles) ) { ?>
                                    <h4 class="card-title">Upload Video</h4>
                                    <form class="upload_video" enctype="multipart/form-data" <?= !empty($get_video_url) ? 'style="display:none"' : '' ?>>
                                        <input type="file" name="video" accept="video/*">
                                        <input type="hidden" name="order_id" value="<?= $_GET["id"] ?>">
                                        <input type="hidden" name="action" value="upload_recorded_video">
                                        <button type="submit" class="btn btn-outline-primary waves-effect">Upload</button>
                                    </form>
                                <?php } ?>
                                <?php if($get_video_url) { ?>
                                    <div class="video_container" >
                                        <video width="100%" height="100%" controls style="border-radius: 15px;">
                                            <source src="<?= $get_video_url ?>" type="video/mp4" >
                                            Your browser does not support the video tag.
                                        </video>
                                        <?= in_array('administrator', wp_get_current_user()->roles) ? '<button type="button" class="btn btn-outline-primary waves-effect remove_video">Remove</button>' : ''  ?>
                                    </div>
                                   
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>   
                    </div>
                </section>
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
        jQuery(document).ready(function(){

            jQuery(document).on('click', '.remove_video', function( e ){
                jQuery('.video_container').hide();
                jQuery('.upload_video').show();
            });


            jQuery(".upload_video").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                //  alert("works");
                var form = new FormData(this);
                //console.log('form', form);
                jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                jQuery(this).find('button[type=submit]').prop('disabled',true);
                var thiss = jQuery(this);

                jQuery('body').waitMe({
                    effect : 'bounce',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                });

                jQuery.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php')  ?>",
                    data: form,
                    dataType : 'json',
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType : 'json',
                    success: function (response) {
                        jQuery('.fa.fa-spinner.fa-spin').remove();
                        jQuery('body').waitMe('hide');
                        jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                        console.log("response", response);
                        if(!response.status){
                        Swal.fire({
                            title: response.title,
                            text:  response.message,
                            icon: response.icon,
                            })
                        }
                        else{
                            Swal.fire({
                                title: response.title,
                                text:  response.message,
                                icon: response.icon,
                                showConfirmButton: true,
                            }).then((willDelete) => {
							  if (response.redirect_url) {window.location.href = response.redirect_url;}
							}); 
                        } 
                    },
                    error : function(errorThrown){
                        console.log(errorThrown);
                        jQuery('body').waitMe('hide');
                    }
                });
            }); 

        });

    </script>
    
</body>
<!-- END: Body-->

</html>