<?php /*Template Name: Poll */ ?>
<?php //if(is_user_logged_in()) {  wp_redirect(home_url('dashboard/')); exit; } ?>
    <!-- BEGIN: Head-->
    <?php include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-validation.css">
    <!-- END: Page CSS-->

    <?php include "includes/header.php"; ?>
     
    <style>
       
        .pollOptions {
            display: flex;
        }
        .pollOptions div {
            margin-right: 10px;
        }
        .card {
            height: 90%;
        }
        li.avatar {
            background: none;
            color: #8a8a8a;
        }
    </style>
    <!-- END: Head-->

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
                    <h3>Polls</h3>
                    <!-- <p class="mb-2">
                        A role provided access to predefined menus and features so that depending <br />
                        on assigned role an administrator can have access to what he need
                    </p> -->

                    <!-- Role cards -->
                    <div class="row">
                        <?php if(in_array('administrator', wp_get_current_user()->roles)){ ?>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="d-flex align-items-end justify-content-center h-100">
                                            <img src="<?= $directory_url ?>/app-assets/images/illustration/faq-illustrations.svg" class="img-fluid mt-2" alt="Image" width="85" />
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="card-body text-sm-end text-center ps-sm-0">
                                            <a href="javascript:void(0)" data-bs-target="#addRoleModal" data-bs-toggle="modal" class="stretched-link text-nowrap add-new-role">
                                                <span class="btn btn-primary mb-1">Add New Poll</span>
                                            </a>
                                            <p class="mb-0">Add poll, if it does not exist</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php 

                            if(in_array('administrator', wp_get_current_user()->roles)){ 
                                $args = [
                                    'post_type' => 'poll',
                                    'post_status' => ['publish', 'draft'],
                                    'posts_per_page' => -1,
                                ];
                            }elseif(in_array('customer', wp_get_current_user()->roles)){ 
                                $args = [
                                    'post_type' => 'poll',
                                    'post_status' => ['publish'],
                                    'posts_per_page' => -1,
                                ];
                            }
                            $polls = new WP_Query($args);
                            $user_id = get_current_user_id();

                            foreach($polls->posts ?? [] as $key => $val){ 

                                $pollOptions = get_post_meta($val->ID, 'options', true);
                                $pollData = get_post_meta($val->ID, 'pollData', true);
                                // var_dump($pollOptions);
                                // var_dump($pollData);
                                // Initialize an array to store the counts
                                $optionCounts = array_fill_keys($pollOptions, 0);

                                // Count votes for each option
                                if (!empty($pollData)) {
                                    foreach ($pollData as $userId => $vote) {
                                        if (array_key_exists($vote, $optionCounts)) {
                                            $optionCounts[$vote]++;
                                        }
                                    }
                                }

                        ?>
                    

                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <span class="badge rounded-pill badge-light-<?= $val->post_status == 'draft' ? 'warning' : 'success' ?>"><?= $val->post_status == 'draft' ? 'Inactive' : 'Active' ?></span>
                                        <?php if(in_array('administrator', wp_get_current_user()->roles)){ ?>
                                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0" style="gap: 8px;">
                                                <li data-bs-toggle="modal" data-bs-target="#addRoleModal"  data-id="<?= $val->ID  ?>" data-popup="tooltip-custom" data-bs-placement="top" title="Edit" class="avatar avatar-sm pull-up edit_poll">
                                                    <i data-feather='edit'></i>                                            
                                                </li>

                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Inactive this poll" data-id="<?= $val->ID  ?>" class="avatar avatar-sm pull-up inactive_poll">
                                                    <i data-feather='power'></i>                                            
                                                </li>

                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete" data-id="<?= $val->ID  ?>" class="avatar avatar-sm pull-up delete_poll">
                                                    <i data-feather='trash'></i>                                            
                                                </li>
                                                
                                            </ul>
                                            <!-- <a href="javascript:;" class="role-edit-modal" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                                                <small class="fw-bolder">Edit Poll</small>
                                            </a> -->
                                        <?php } ?>
                                    
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                                        <div class="role-heading">
                                            <h4 class="fw-bolder"><?= get_the_title( $val->ID ) ?></h4>
                                            <div class="pollOptions">

                                                <?php foreach ($pollOptions as $key => $value) { 
                                                    if(!in_array('administrator', wp_get_current_user()->roles)){ ?>
                                                    <div class="form-check form-check-success">
                                                        <input type="radio" id="customColorRadio_<?= $val->ID . $key ?>" data-id="<?= $val->ID ?>" name="option_<?= $val->ID ?>" value="<?= $value ?>" class="form-check-input polling" <?= $pollData[$user_id] == $value ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="customColorRadio_<?= $val->ID . $key ?>"><b><?=  $value ?></b> <span><?= '('.$optionCounts[$value] .'),' ?><span></label>

                                                    </div>
                                                <?php } else { ?>
                                                    <div class="form-check-success">
                                                        <p><b><?=  $value ?></b> <span><?= '('.$optionCounts[$value] .'),' ?><span></p>
                                                    </div>
                                                <?php } } ?>
                                        
                                            </div>
                                        
                                        </div>
                                    
                                        <!-- <a href="javascript:void(0);" class="text-body"><i data-feather="copy" class="font-medium-5"></i></a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                       

                        <?php if(!$polls->found_posts) { ?>
                            <p class="no-record">No Polls are found</p>
                        <?php } ?>
                        
                    
                    </div>
                    <!--/ Role cards -->

                    <!-- <h3 class="mt-50">Poll Result</h3>
                    <p class="mb-2">Find all of your company’s administrator accounts and their associate roles.</p> -->
                    <!-- table -->
                    <!-- <div class="card">
                        <div class="table-responsive">
                            <table class="datatables-basic table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Question</th>
                                        <th>Option</th>
                                        <th>Plan</th>
                                        <th>Billing</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div> -->
                    <!-- table -->

                    <!-- Add Role Modal -->
                    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-5 pb-5">
                                    <div class="text-center mb-4">
                                        <h1>Add New Poll</h1>
                                        <!-- <p>Set role permissions</p> -->
                                    </div>
                                    <!-- Add role form -->
                                    <form id="add_poll" class="row">
                                        <div class="col-12">
                                            <label class="form-label" for="modalRoleName">Ask Question</label>
                                            <input type="text" id="modalRoleName" name="question" class="form-control" placeholder="Enter question" tabindex="-1" data-msg="Please enter question" />
                                        </div>
                                        <div class="col-12">
                                            <h4 class="mt-2 pt-50">Options</h4>
                                            <div class="options">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                                            <i data-feather="plus" class="me-25"></i>
                                                            <span>Add Option</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="container-for-clones"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-2">
                                            <input type="hidden" name="action" value="add_poll">
                                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Discard
                                            </button>
                                        </div>
                                    </form>
                                    <!--/ Add role form -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Add Role Modal -->
                    <!-- Poll div -->
                    <div class="poll_options" style="display:none !important">
                        <div class="col-md-8 col-12">
                            <label class="form-label">+Add</label>
                            <input type="text" name="options[]" class="form-control" placeholder="+Add"  />
                        </div>
                        <div class="col-md-2 col-12 mb-50">
                            <div class="mb-1">
                                <button class="btn btn-outline-danger text-nowrap px-1 delete_option" type="button">
                                    <i data-feather="x" class="me-25"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Poll div -->

                </div>
            </div>
        </div>
        <!-- END: Content-->


        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <?php include "includes/scripts.php"; ?>

        <!-- BEGIN: Page Vendor JS-->
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/buttons.bootstrap5.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/js/scripts/components/components-modals.js"></script>
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Page JS-->
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/modal-add-role.js"></script>
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-access-roles.js"></script>
        <!-- END: Page JS-->
      

        <script>
            $(document).ready(function() {
                var table = $('.datatables-basic').DataTable({
                    // order: [[1, 'desc']],
                    dom: '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
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

                // clone poll
                jQuery(document).on('click', '[data-repeater-create]', function(e){
                    var clone = jQuery('.poll_options').first().clone();
                    clone.find('input').val(''); // Clear input values
                    clone.css('display', 'flex'); 
                    jQuery('.container-for-clones').append(clone);
                });

                jQuery(document).on('click', '.delete_option', function(e) {
                    e.preventDefault();
                    jQuery(this).closest('.poll_options').remove();
                });

                jQuery(document).on('click', '.add-new-role', function(e) {
                    $('.container-for-clones').html('');
                    jQuery('input[name="post_id"]').remove();

                });

                $("#add_poll").submit(function(e) {
                    e.preventDefault(); // Prevent the default form submission
                    // Create a FormData object to combine all form data
                    var form = new FormData(this);
            
                    var thiss = $(this);
                    // console.log('formData', form);
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
                    // AJAX request to the server
                    $.ajax({
                        type: 'post',
                        url: '<?= admin_url('admin-ajax.php'); ?>',
                        data: form, // Use FormData directly
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // jQuery('.fa.fa-spinner.fa-spin').remove();
                            jQuery('body').waitMe('hide');
                            // jQuery(thiss).find('button[type=submit]').prop('disabled', false);
                            if (!response.status) {
                                toastr.error(response.message, response.title);

                            } else{
                                if (response.auto_redirect) {
                                    toastr.success(response.message, response.title);
                                    window.location.href = response.redirect_url;
                                }
                                
                            } 
                        },
                        error: function(errorThrown) {
                            jQuery('body').waitMe('hide');
                            console.log(errorThrown);
                        }
                    });
                });


                $(document).on("click", ".delete_poll", function(e) {
                    if (confirm("Are you sure?")) {
                        var poll_id = $(this).attr('data-id');
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
                                action: 'delete_poll',
                                poll_id: poll_id,
                            },
                            dataType: 'json',
                            success: function(response) {
                                jQuery('body').waitMe('hide');
                                // console.log(response);
                                if (response.status) {
                                    thiss.parents('.col-md-6').fadeOut(1000);
                                    toastr.success("Success");
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

                //inactive
                $(document).on("click", ".inactive_poll", function(e) {
                    if (confirm("Are you sure inactive this poll?")) {
                        var poll_id = $(this).attr('data-id');
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
                                action: 'inactive_poll',
                                poll_id: poll_id,
                            },
                            dataType: 'json',
                            success: function(response) {
                                jQuery('body').waitMe('hide');
                                // console.log(response);
                                if (!response.status) {
                                    toastr.error(response.message, response.title);

                                } else{
                                    if (response.auto_redirect) {
                                        // toastr.success(response.message, response.title);
                                        window.location.href = response.redirect_url;
                                    }
                                    
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

                //polling
                $(document).on("change", '.polling', function(e) {
                    var poll_id = $(this).attr('data-id');
                    var poll_value = $(this).attr('value');
                    var thiss = jQuery(this);
                    jQuery('.content-body').waitMe({
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
                            action: 'polling',
                            poll_id: poll_id,
                            poll_value: poll_value,
                        },
                        dataType: 'json',
                        success: function(response) {
                            jQuery('.content-body').waitMe('hide');
                            // console.log(response);
                            if (!response.status) {
                                toastr.error(response.message, response.title);

                            } else{
                                toastr.success(response.message, response.title);
                            } 
                        },
                        error: function(errorThrown) {
                            console.log(errorThrown);
                            jQuery('.content-body').waitMe('hide');
                        }
                    });
                   
                });
                
                //edit poll
                $(document).on("click", ".edit_poll", function(e) {
                    var poll_id = $(this).attr('data-id');
                    jQuery('input[name="post_id"]').remove();
                    $('#add_poll').append('<input type="hidden" name="post_id" value="'+ poll_id +'">');

                    var thiss = jQuery(this);
                    jQuery('.content-body').waitMe({
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
                            action: 'edit_poll',
                            poll_id: poll_id,
                        },
                        dataType: 'json',
                        success: function(response) {
                            jQuery('.content-body').waitMe('hide');
                            // console.log(response);
                            if (!response.status) {
                                toastr.error(response.message, response.title);

                            } else{
                                $('.container-for-clones').html('');
                                $('#modalRoleName').val(response.title);
                                $('.container-for-clones').append(response.options);
                            } 
                        },
                        error: function(errorThrown) {
                            console.log(errorThrown);
                            jQuery('.content-body').waitMe('hide');
                        }
                    });
                   
                });

                $(window).on('load', function() {
                    if (feather) {
                        feather.replace({
                            width: 14,
                            height: 14
                        });
                    }
                });
            });
       
        </script>
    </body>
    <!-- END: Body-->

</html>