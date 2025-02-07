<?php /* Template Name: My Events */ ?>

<!-- BEGIN: Head-->



<?php include "includes/styles.php"; ?>


<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/calendars/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<!-- END: Vendor CSS-->

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/app-calendar.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-validation.css">
<!-- datepicker -->
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/pickadate/pickadate.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/pickers/form-pickadate.css">
<!-- END: Page CSS-->

<style>

    td.expired {
        pointer-events: none;
        opacity: 0.3;
    }

    .card-body.dd {

        display: flex;

        justify-content: space-between;

    }

    td.remaining {

        color: red !important;

        font-weight: bold;

    }

    .instructions {

        padding: 20px;

    }



    .instructions  p {

        font-size: 12px;

        font-weight:bold

    }

    td.ship {

        margin-top: 12px;

    

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

                            <h2 class="card-title">My Events</h2>

                            <?php

                            $current_date = date('Y-m-d');

                            $date_before_10_days = date('Y-m-d', strtotime('-10 days'));

                            ?>

                            <!-- <div class="card-body border-bottom"> -->

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

                            <!-- </div> -->

                            <!-- Filter -->

                        </div>

                        <!-- admin -->

                        <?php //if(in_array('administrator', wp_get_current_user()->roles) ) { 

                        

                            $args = [

                                'post_type'      => 'events',
                                'posts_per_page' => -1,
                                'post_status' => ['publish', 'draft'],
                                'author'=> get_current_user_id(),
                                'date_query'     => array(
                                    array(
                                        'after'     => $date_before_10_days,
                                        'before'    => $current_date,
                                        'inclusive' => true,
                                    ),
                                ),
                            ];

                            if(isset($_GET['type'])){
                                $args['post_status'] = ['draft'];
                                $args['author'] = '';
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

                         

                            $events = new WP_Query($args);

                        ?>

                       
                        <div class="card-datatable table-responsive pt-0">

                            <table class="datatables-basic table">

                                <thead>

                                    <tr>

                                        <th>Event ID</th>
                                        <th>User</th>
                                        <th>Event</th>
                                        <th>Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Location </th>
                                        <th>Status </th>
                                        <th>Actions </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach ($events->posts as $key => $value) { 

                                       $postMeta = get_post_meta($value->ID);
                                       $currentDateTime = date('Y-m-d H:i'); // Current date and time in 'Y-m-d H:i' format
                                        if(strtotime($currentDateTime) > strtotime($postMeta['end_date'][0])){
                                                update_post_meta($value->ID, 'status', 'expired');
                                        }

                                        $statusClass = '';
                                        if($postMeta['status'][0] == 'expired'){
                                            $statusClass = 'badge badge-light-danger';
                                        }
                                       //    var_dump($postMeta);

                                    ?>

                                        <tr>

                                            <td><?= $value->ID ?></td>
                                            <?php if (in_array('administrator', wp_get_current_user()->roles)) { ?> 
                                            <td><a href="<?= home_url('view-profile/?id='.$postMeta['userid'][0]) ?>"><?= $postMeta['username'][0]  ?></a></td>
                                            <?php } elseif (in_array('customer', wp_get_current_user()->roles)) { ?>
                                            <td><?= $postMeta['username'][0]  ?></td>
                                            <?php } ?>
                                            <td><?= $postMeta['event_name'][0]  ?></td>
                                            <td><?= $postMeta['type'][0]  ?></td>
                                            <td><?= $postMeta['start_date'][0]  ?></td>
                                            <td><?= $postMeta['end_date'][0]  ?></td>
                                            <td><?= $postMeta['event_location'][0]  ?></td>
                                            
                                            <!-- Check roles and display status -->
                                            <?php if (in_array('administrator', wp_get_current_user()->roles)) { ?> 
                                                <td class="ship <?= isset($statusClass) && !empty($statusClass) ? $statusClass : ($value->post_status == 'publish' ? 'badge badge-light-success' : '') ?>">
                                                    <?php if ($value->post_status == 'publish') {
                                                        // Check if the event is expired
                                                        echo strtotime($currentDateTime) > strtotime($postMeta['end_date'][0]) ? 'Expired' : 'Active';
                                                    } else { ?>
                                                        <select class="form-select" name="post_status" data-id="<?= $value->ID ?>">
                                                            <option value="draft">Pending</option>
                                                            <option value="publish">Publish</option>
                                                        </select>
                                                    <?php } ?>
                                                </td>
                                            <?php } elseif (in_array('customer', wp_get_current_user()->roles)) { ?>
                                                <td class="ship <?= isset($statusClass) && !empty($statusClass) ? $statusClass : ($value->post_status == 'publish' ? 'badge badge-light-success' : 'badge badge-light-warning') ?>">
                                                    <?php 
                                                    if ($value->post_status == 'publish') {
                                                        // Check if the event is expired
                                                        echo strtotime($currentDateTime) > strtotime($postMeta['end_date'][0]) ? 'Expired' : 'Active';
                                                    } else {
                                                        echo 'Pending';
                                                    }
                                                    ?>
                                                </td>
                                            <?php } ?>

                                            
                                            <td class="<?= isset($statusClass) && !empty($statusClass) ? 'expired' : '' ?>">
                                            <a href="#!" 
                                                class="edit-record" 
                                                data-id="<?= $value->ID ?>" 
                                                data-name="<?= $postMeta['event_name'][0] ?>" 
                                                data-type="<?= $postMeta['type'][0] ?>" 
                                                data-start="<?= $postMeta['start_date'][0] ?>" 
                                                data-end="<?= $postMeta['end_date'][0] ?>" 
                                                data-location="<?= $postMeta['event_location'][0] ?>" 
                                                data-description="<?= isset($postMeta['event_description'][0]) ? $postMeta['event_description'][0] : '' ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#add-new-sidebar">
                                                    <i data-feather='edit'></i>
                                            </a>

                                                <a href="#!" class="delete-record" data-id=<?= $value->ID ?> data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Remove Event">

                                                    <i data-feather='trash-2'></i>

                                                </a>


                                            </td>

                                        </tr>



                                   <?php } ?>

                                </tbody>

                            </table>

                        </div>

                        <?php //} ?>

                    </div>

                    <!-- list and filter end -->

                </section>

                <!-- users list ends -->

                <!-- Calendar Add/Update/Delete event modal-->
                <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
                    <div class="modal-dialog sidebar-lg">
                        <div class="modal-content p-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title">Update Event</h5>
                            </div>
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <form id="add_event" class="event-form">
                                    <div class="mb-1">
                                        <label for="title" class="form-label">Title *</label>
                                        <input type="text" class="form-control" id="title" name="event_name" placeholder="Event Title" required />
                                    </div>
                                    <div class="mb-1">
                                        <label for="select-label" class="form-label">Label</label>
                                        <select class="select2 select-label form-select w-100" id="select-label" name="type">
                                            <option data-label="primary" value="Business" selected>Business</option>
                                            <option data-label="danger" value="Personal">Personal</option>
                                            <option data-label="warning" value="Family">Family</option>
                                            <option data-label="success" value="Holiday">Holiday</option>
                                            <option data-label="info" value="ETC">ETC</option>
                                        </select>
                                    </div>
                                    <div class="mb-1 position-relative">
                                        <label for="start-date" class="form-label">Start Date *</label>
                                        <input type="text" class="form-control" id="start-date" name="start_date" placeholder="Start Date" />
                                    </div>
                                    <div class="mb-1 position-relative">
                                        <label for="end-date" class="form-label">End Date *</label>
                                        <input type="text" class="form-control" id="end-date" name="end_date" placeholder="End Date" />
                                    </div>
                                    
                                    
                                    <div class="mb-1">
                                        <label for="event-location" class="form-label">Location *</label>
                                        <input type="text" class="form-control" name="event_location" id="event-location" placeholder="Enter Location" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Description</label>
                                        <textarea name="event_description" id="event-description-editor" class="form-control"></textarea>
                                    </div>
                                    <div class="mb-1 d-flex">
                                        <input type="hidden" name="action" value="add_event">
                                        <button type="submit" class="btn btn-primary add-event-btn me-1">Update</button>
                                        <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Calendar Add/Update/Delete event modal-->

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





    <!-- BEGIN: Page Vendor JS-->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/calendar/fullcalendar.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/extensions/moment.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-calendar-events.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-calendar.js"></script>

    
    <!-- Date picker -->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/pickers/form-pickers.js"></script>
    <!-- END: Page JS-->



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

        $(document).on("change", "select[name='post_status']", function(e) {

            if (confirm("Are you sure?")) {

                var event_id = $(this).attr('data-id');

                var event_status = $(this).val();

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

                        action: 'approved_event',

                        event_id: event_id,

                        event_status: event_status,


                    },

                    dataType: 'json',

                    success: function(response) {

                        jQuery('body').waitMe('hide');

                        // console.log(response);

                        if(!response.status){

                            toastr.error(response.message, response.title);

                        } else {

                            toastr.success(response.message, response.title);

                            thiss.parents('.ship').addClass('badge badge-light-success').text('Active');

                            // thiss.parents('.ship').addClass('badge badge-light-warning');



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


        $(document).on("click", ".delete-record", function(e) {

            if (confirm("Are you sure?")) {

                var event_id = $(this).attr('data-id');

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

                        action: 'delete_event',

                        event_id: event_id,

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

        $("#add_event").submit(function(e) {
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

        // Event listener for edit button click
        $('.edit-record').on('click', function () {
            // Fetch data attributes from the clicked button
            let id = $(this).data('id');
            let name = $(this).data('name');
            let type = $(this).data('type');
            let start = $(this).data('start');
            let end = $(this).data('end');
            let location = $(this).data('location');
            let description = $(this).data('description');

            // Populate modal form fields with fetched data
            $('#title').val(name);
            $('#select-label').val(type).change(); // For select2 dropdowns, call .change()
            $('#start-date').val(start);
            $('#end-date').val(end);
            $('#event-location').val(location);
            $('#event-description-editor').val(description);

            // Optional: Add hidden input to pass the event ID
            if ($('#event-id').length === 0) {
                $('<input>')
                    .attr({
                        type: 'hidden',
                        id: 'event-id',
                        name: 'post_id',
                        value: id
                    })
                    .appendTo('#add_event');
            } else {
                $('#event-id').val(id); // Update if hidden input already exists
            }
        });

            
        table.on('draw', function () {

            feather.replace({

                width: 14,

                height: 14

            });

        });

    </script>

    

</body>
<!-- END: Body-->