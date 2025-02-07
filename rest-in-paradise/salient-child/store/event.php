<?php /*Template Name: event */ ?>
<?php //if(is_user_logged_in()) {  wp_redirect(home_url('dashboard/')); exit; } ?>
    <!-- BEGIN: Head-->
    <?php include "includes/styles.php"; ?>
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/calendars/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Page CSS-->
     
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
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
    <?php include "includes/header.php"; ?>
     
    <style>
         .card-body.dd {
            display: flex;
            justify-content: space-between;
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
                <!-- Full calendar start -->
                <section>
                    <div class="app-calendar overflow-hidden border">
                        <div class="row g-0">
                            <!-- Sidebar -->
                            <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                                <div class="sidebar-wrapper">
                                    <div class="card-body d-flex justify-content-center">
                                        <button class="btn btn-primary btn-toggle-sidebar w-100" data-bs-toggle="modal" data-bs-target="#add-new-sidebar">
                                            <span class="align-middle">Add Event</span>
                                        </button>
                                    </div>
                                    <div class="card-body pb-0">
                                        <h5 class="section-label mb-1">
                                            <span class="align-middle">Filter</span>
                                        </h5>
                                        <div class="form-check mb-1">
                                            <input type="checkbox" class="form-check-input select-all" id="select-all" checked />
                                            <label class="form-check-label" for="select-all">View All</label>
                                        </div>
                                        <div class="calendar-events-filter">
                                            <div class="form-check form-check-danger mb-1">
                                                <input type="checkbox" class="form-check-input input-filter" id="personal" data-value="personal" checked />
                                                <label class="form-check-label" for="personal">Personal</label>
                                            </div>
                                            <div class="form-check form-check-primary mb-1">
                                                <input type="checkbox" class="form-check-input input-filter" id="business" data-value="business" checked />
                                                <label class="form-check-label" for="business">Business</label>
                                            </div>
                                            <div class="form-check form-check-warning mb-1">
                                                <input type="checkbox" class="form-check-input input-filter" id="family" data-value="family" checked />
                                                <label class="form-check-label" for="family">Family</label>
                                            </div>
                                            <div class="form-check form-check-success mb-1">
                                                <input type="checkbox" class="form-check-input input-filter" id="holiday" data-value="holiday" checked />
                                                <label class="form-check-label" for="holiday">Holiday</label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <input type="checkbox" class="form-check-input input-filter" id="etc" data-value="etc" checked />
                                                <label class="form-check-label" for="etc">ETC</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-auto">
                                    <img src="<?= $directory_url ?>/app-assets/images/pages/calendar-illustration.png" alt="Calendar illustration" class="img-fluid" />
                                </div>
                            </div>
                            <!-- /Sidebar -->
                            <!-- Calendar -->
                            <div class="col position-relative">
                                <div class="card shadow-none border-0 mb-0 rounded-0">
                                    <div class="card-body pb-0">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Calendar -->
                            <div class="body-content-overlay"></div>
                        </div>
                    </div>
                    <!-- Calendar Add/Update/Delete event modal-->
                    <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
                        <div class="modal-dialog sidebar-lg">
                            <div class="modal-content p-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title">Add Event</h5>
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
                                            <button type="submit" class="btn btn-primary add-event-btn me-1">Add</button>
                                            <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary update-event-btn d-none me-1">Update</button>
                                            <button class="btn btn-outline-danger btn-delete-event d-none">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Calendar Add/Update/Delete event modal-->
                </section>
                <!-- Full calendar end -->
                <?php if(in_array('administrator', wp_get_current_user()->roles)  || true) { ?>
                <!-- events list start -->
                <section>
                    <!-- list and filter start -->
                    <div class="card" <?= in_array('administrator', wp_get_current_user()->roles) ? '' : 'style="display:none"' ?>>
                        <div class="card-body dd">
                            <h2 class="card-title">All Events</h2>
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
                        <?php 
                        
                            $args = [
                                'post_type'      => 'events',
                                'posts_per_page' => -1,
                                'post_status' => ['publish'],
                                'meta_query'     => [
                                    'relation' => 'OR', // Combine conditions with OR logic
                                    [
                                        'key'     => 'status', 
                                        'compare' => 'NOT EXISTS' // Status meta key does not exist
                                    ],
                                    
                                ],
                                'date_query'     => array(
                                    array(
                                        'after'     => $date_before_10_days,
                                        'before'    => $current_date,
                                        'inclusive' => true,
                                    ),
                                ),
                            ];
                            
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
                                        <th>Member</th>
                                        <th>Event</th>
                                        <th>Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Location </th>
                                        <th>Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $event = [];
                                    $i = 1;
                                    foreach ($events->posts as $key => $value) {
                                    $postMeta = get_post_meta($value->ID);
                                    $currentDateTime = date('Y-m-d H:i'); // Current date and time in 'Y-m-d H:i' format
                                        if(strtotime($currentDateTime) > strtotime($postMeta['end_date'][0])){
                                                update_post_meta($value->ID, 'status', 'expired');
                                        }
                                        $statusClass = '';
                                        if($postMeta['status'][0] == 'expired'){
                                            $statusClass = 'badge badge-light-danger';
                                        }

                                        $event[] =  [
                                                        'id'            =>  $i,
                                                        'url'           => '',
                                                        'title'         => $postMeta['event_name'][0],
                                                        'start'         => $postMeta['start_date'][0],
                                                        'end'           => $postMeta['end_date'][0],
                                                        'allDay'        => true,
                                                        'extendedProps' => [
                                                        'calendar'      => $postMeta['type'][0]
                                                        ]
                                                    ];
                                       $i++;
                                    ?>
                                        <tr>
                                            <td><?= $value->ID ?></td>
                                            <td><a href="<?= home_url('view-profile/?id='.$postMeta['userid'][0]) ?>"><?= $postMeta['username'][0]  ?></a></td>
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
                                            
                                            
                                        </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php //} ?>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- events list ends -->
                 <?php } ?>
            </div>
        </div>
    </div>
    <script>
        events = <?= json_encode($event) ?>
    </script>
    <!-- END: Content-->
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
        <?php include "includes/scripts.php"; ?>
        <!-- BEGIN: Page Vendor JS-->
        <script src="<?= $directory_url ?>/app-assets/vendors/js/calendar/fullcalendar.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/extensions/moment.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
        <!-- END: Page Vendor JS-->
        <!-- BEGIN: Page JS-->
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-calendar-events.js?v=<?= time() ?>"></script>
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-calendar.js?v=<?= time() ?>"></script>
        
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
                
                // Buttons with Dropdown
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    
                ],
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
            
            $(window).on('load', function() {
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            });

            // $(document).on('click', '#calendar', function(e) {
            //     alert();
            //     e.preventDefault();
            //     $('#add-new-sidebar').hide();

            // });
       
        </script>
    </body>
    <!-- END: Body-->
</html>