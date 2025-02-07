<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <style>
        .form-control:disabled {
            background-color: #efefef;
        }
        .select2-container--default.select2-container--disabled li.select2-selection__choice {
            background: #efefef !important;
            border-color: #cbcbcb !important;
        }
    </style>

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
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Add Session</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">

                <!-- Basic Vertical form layout section start -->

                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form form-vertical" method="POST" action="#" enctype="multipart/form-data">
                                       
                                        <div class="row">
                                            <div class="col-md-3  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="title" >Title</label>
                                                    <input type="text" id="title" class="form-control" value="" name="title" placeholder="title" />
                                                    
                                                </div>
                                            </div>

                                           <div class="col-md-3 mb-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="fp-multiple">Blackout dates</label>
                                                    <input type="text" id="fp-multiple" class="form-control flatpickr-multiple" value="" name="blackout_dates" placeholder="YYYY-MM-DD"  />
                                                    
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="status">Session Status</label>
                                                    <select class="form-select" id="status" name="status" required>
                                                        <option value="1" >active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                    
                                                </div>
                                            </div>

                                           
                                            <div class="col-md-3 mb-1">
                                                <label class="form-label" for="duration">Select duration</label>
                                                <select class="form-select" id="duration" name="duration" required>
                                                    <?php $durations = [15, 20, 25, 30, 40, 45, 60, 90, 120];
                                                    foreach ($durations as $duration) { ?>
                                                        <option value="{{ $duration }}" ><?= $duration ?> min</option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="col-md-6  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="start_time">Start Time</label>
                                                    <input type="text" id="start_time"  class="form-control flatpickr-time text-start" placeholder="HH:MM" value="" name="start_time"/>
                                                    
                                                </div>
                                            </div>

                                            <div class="col-md-6  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="end_time">End Time</label>
                                                    <input type="text" id="end_time"  class="form-control flatpickr-time text-start" placeholder="HH:MM" value="" name="end_time" />
                                                    
                                                </div>
                                            </div>

                                           

                                            <div class="col-md-2">
                                                <div class="mb-1">
                                                    <label class="form-label" for="website-vertical">Banner image</label>
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' id="imageUpload" name="image" accept="image/png, image/jpeg" />
                                                            <label for="imageUpload">
                                                                <i data-feather='edit' style="width: 33px; height: 29px;"></i>
                                                            </label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="imagePreview" style="background-image: url('assets/images/no-preview.png')">
                                                            </div>
                                                        </div>
                                                        

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-10  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="description">Description</label>
                                                    <textarea class="form-control" name="description" id="description" placeholder="Session description" rows="8"></textarea>
                                                    
                                                </div>
                                            </div>
                                           
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary me-1">Submit</button>
                                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Basic Vertical form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

   

    <?php include "includes/scripts.php"; ?>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <!-- {{-- <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/pickers/pickadate/legacy.js"></script> --}} -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>

    
    <script>

    var timePickr = $('.flatpickr-time'),
     multiPickr = $('.flatpickr-multiple');

                // Time
        if (timePickr.length) {
            timePickr.flatpickr({
            enableTime: true,
            noCalendar: true,
            });
        }

        // Multiple Dates
        if (multiPickr.length) {
            multiPickr.flatpickr({
                weekNumbers: true,
                mode: 'multiple',
                minDate: 'today',
                dateFormat: 'Y/m/d',
            });
        }

    </script>

</body>
<!-- END: Body-->

</html>