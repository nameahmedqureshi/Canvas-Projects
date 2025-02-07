<?php /*Template Name: Announcements */ ?>
<?php //if(is_user_logged_in()) {  wp_redirect(home_url('dashboard/')); exit; } ?>
    <!-- BEGIN: Head-->
    <?php include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/katex.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/extensions/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/select/select2.min.css">

     <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-quill-editor.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/extensions/ext-component-toastr.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/app-email.css">
    <!-- END: Page CSS-->

    <?php include "includes/header.php"; ?>
     
    <style>
        .email-application .email-app-details {
            width: 100%;
        }

        .email-application .email-app-details .email-scroll-area {
            padding-left: 1.5%;
            padding-right: 1.5%;
        }
        .dark-layout .postcontent * {
            color: #caced7 !important;
        }
        .no-accounment {
            margin-top: 20px;
        }
        
        .postcontent * {
            color: black !important;
        }

        .dark-layout .btn-outline-primary {
            border: 1px solid #bcb2b2 !important;
            color: #bcbcbc;
        }

        .badge.badge-light-primary {
            background-color: rgb(221 221 221 / 12%);
            color: #2b875b !important;
        }

    </style>
    <!-- END: Head-->

    <body class="vertical-layout vertical-menu-modern content-left-sidebar navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar">
    <!-- BEGIN: Main Menu-->
        <?php include "includes/manu.php"; ?>
        <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content email-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-area-wrapper container-xxl p-0">
           
            <!-- <div class="content-right"> -->
                <div class="content-wrapper container-xxl p-0">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="body-content-overlay"></div>
                        <!-- Email list Area -->


                        <!-- <div class="email-app-list"> -->
                            <?php //if(!in_array('customer', wp_get_current_user()->roles)){ ?>
                            <!-- <div class="sidebar-content email-app-sidebar">
                                <div class="email-app-menu">
                                    <div class="form-group-compose text-center compose-btn">
                                        <button type="button" class="compose-email btn btn-primary w-100" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#compose-mail">
                                            Add New Announcement
                                        </button>
                                    </div>
                                
                                </div>
                            </div> -->
                            <?php //} ?>
                          

                            <!-- Email list starts -->
                            <?php
                            // $args = [
                            //     'post_type' => 'announcements',
                            //     'post_status' => 'publish',
                            //     'posts_per_page' => -1
                            // ];
                            // $announcements = new WP_Query($args);

                            ?>
                            <!-- <div class="email-user-list">
                                <ul class="email-media-list"> -->
                                
                                    <?php //foreach($announcements->posts ?? [] as $key => $val){ ?>
                                    <!-- <li class="d-flex user-mail">
                                        <div class="mail-left pe-50">
                                            <div class="avatar">
                                                <img src="<?= $directory_url ?>/app-assets/images/portrait/small/avatar-s-17.jpg" alt="Generic placeholder image" />
                                            </div> -->
                                            <!-- <div class="user-action">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2" />
                                                    <label class="form-check-label" for="customCheck2"></label>
                                                </div>
                                                <span class="email-favorite"><i data-feather="star"></i></span>
                                            </div> -->
                                        <!-- </div>
                                        <div class="mail-body">
                                            <div class="mail-details">
                                                <div class="mail-items">
                                                    <h5 class="mb-25"><?= get_the_title( $val->ID ) ?></h5> -->
                                                    <!-- <span class="text-truncate">Thanks, Let's do it.🤩</span> -->
                                                <!-- </div>
                                                <div class="mail-meta-item"> -->
                                                    <!-- <span class="me-50 bullet bullet-danger bullet-sm"></span> -->
                                                    <!-- <span class="mail-date"><?= date("d M y, g:i A", strtotime($val->post_date)) ?></span>
                                                </div>
                                            </div>
                                            <div class="mail-message">
                                                <p class="mb-0 text-truncate">
                                                   <?= $val->post_content ?>
                                                </p>
                                            </div>
                                        </div>
                                    </li> -->
                                    <?php //} ?>
                                   
<!--                                    
                                </ul>
                                <div class="no-results">
                                    <h5>No Items Found</h5>
                                </div>
                            </div> -->
                            <!-- Email list ends -->
                        </div>


                        <!--/ Email list Area -->
                        <!-- Detailed Email View -->
                        <div class="email-app-details show">
                            <!-- Detailed Email Header starts -->
                            <div class="email-detail-header">
                                <div class="email-header-left d-flex align-items-center">
                                    <!-- <span class="go-back me-1"><i data-feather="chevron-left" class="font-medium-4"></i></span> -->
                                    <h4 class="email-subject mb-0">Focused On Announcement 😃</h4>
                                </div>
                                <?php if(!in_array('customer', wp_get_current_user()->roles)){ ?>
                                <div class="email-header-right ms-2 ps-1">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                        <button type="button" class="compose-email btn btn-outline-primary w-100" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#compose-mail">
                                            <i data-feather="plus" class="font-medium-2"></i> Add New
                                        </button>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <?php } ?>
                            </div>
                            <!-- Detailed Email Header ends -->

                            <!-- Detailed Email Content starts -->
                            <?php 
                              $args = [
                                'post_type' => 'announcements',
                                'post_status' => 'publish',
                                'posts_per_page' => -1
                            ];
                            $announcements = new WP_Query($args);
                            if($announcements->found_posts) { ?>
                            <div class="email-scroll-area">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="email-label">
                                            <span class="mail-label badge rounded-pill badge-light-primary">Latest</span>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                  
                                    foreach($announcements->posts ?? [] as $key => $val){ 
                                        $author = get_userdata($val->post_author);
                                        $profile_pic = get_user_meta($val->post_author, 'profile_pic', true);
                                        $image_url = wp_get_attachment_image_url( $profile_pic );
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card cardParent">
                                            <div class="card-header email-detail-head">
                                                <div class="user-details d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="avatar me-75">
                                                        <img src="<?=  !empty($image_url) ? $image_url : $directory_url.'/assets/images/avatar.png' ?>" alt="avatar img holder" width="48" height="48" />
                                                    </div>
                                                    <div class="mail-items">
                                                        <h5 class="mb-0 posttitle"><?= get_the_title( $val->ID ) ?></h5>
                                                        <div class="email-info">
                                                            <span role="button" class="font-small-3 text-muted">
                                                                <?= $author->display_name ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mail-meta-item d-flex align-items-center">
                                                    <small class="mail-date-time text-muted"><?= date("d M y, g:i A", strtotime($val->post_date)) ?></small>
                                                    <?php if(!in_array('customer', wp_get_current_user()->roles)){ ?>

                                                    <div class="dropdown ms-50">
                                                        <div role="button" class="dropdown-toggle hide-arrow" id="email_more" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i data-feather="more-vertical" class="font-medium-2"></i>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="email_more">
                                                            <div class="dropdown-item" id="edit" data-id="<?= $val->ID  ?>" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#compose-mail">
                                                                <i data-feather="edit" class="me-50"></i>Edit
                                                            </div>
                                                            <div class="dropdown-item delete_announcement" data-id="<?= $val->ID  ?>"><i data-feather="trash-2" class="me-50"></i>Delete</div>
                                                            <!-- <div class="dropdown-item"><i data-feather="corner-up-right" class="me-50"></i>Forward</div> -->
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="card-body mail-message-wrapper pt-2">
                                                <div class="mail-message postcontent"><?= $val->post_content ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                               
                            </div>
                            <?php } else { ?>
                                <div class="col-md-6 col-xl-12 no-accounment">
                                    <div class="card bg-secondary text-white">
                                        <div class="card-body">
                                            <h4 class="card-title text-white">No Accouncements yet</h4>
                                            <!-- <p class="card-text">If you want to add an accouncements, click the button +Add New</p> -->
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- Detailed Email Content ends -->
                        </div>
                        <!--/ Detailed Email View -->

                        <!-- make announcement -->
                        <div class="modal modal-sticky" id="compose-mail" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content p-0">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Make Announcement</h5>
                                        <div class="modal-actions">
                                            <!-- <a href="#" class="text-body me-75"><i data-feather="minus"></i></a> -->
                                            <a href="#" class="text-body me-75 compose-maximize"><i data-feather="maximize-2"></i></a>
                                            <a class="text-body" href="#" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></a>
                                        </div>
                                    </div>
                                    <div class="modal-body flex-grow-1 p-0">
                                        <form id="add_announcement">
                                           
                                            <div class="compose-mail-form-field">
                                                <label for="emailSubject" class="form-label">Subject: </label>
                                                <input type="text" id="emailSubject" class="form-control" placeholder="Subject" name="subject" />
                                            </div>
                                            <div id="message-editor">
                                                <div class="editor" data-placeholder="Type message..."></div>
                                                <div class="compose-editor-toolbar">
                                                    <span class="ql-formats me-0">
                                                        <select class="ql-font">
                                                            <option selected>Sailec Light</option>
                                                            <option value="sofia">Sofia Pro</option>
                                                            <option value="slabo">Slabo 27px</option>
                                                            <option value="roboto">Roboto Slab</option>
                                                            <option value="inconsolata">Inconsolata</option>
                                                            <option value="ubuntu">Ubuntu Mono</option>
                                                        </select>
                                                    </span>
                                                    <span class="ql-formats me-0">
                                                        <button class="ql-bold"></button>
                                                        <button class="ql-italic"></button>
                                                        <button class="ql-underline"></button>
                                                        <!-- <button class="ql-link"></button> -->
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="compose-footer-wrapper">
                                                <div class="btn-wrapper d-flex align-items-center">
                                                    <div class="btn-group dropup me-1">
                                                        <input type="hidden" name="action" value="add_announcement">
                                                        <button type="submit" class="btn btn-primary">Publish</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ make announcement  -->

                    </div>
                </div>
            <!-- </div> -->
        </div>
    </div>
    <!-- END: Content-->


        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <?php include "includes/scripts.php"; ?>

        <!-- BEGIN: Page Vendor JS-->
        <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/katex.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/quill.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/extensions/toastr.min.js"></script>
        <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
        <!-- END: Page Vendor JS-->
      
        <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-email.js"></script>

        <script>

            $("#add_announcement").submit(function(e) {
                e.preventDefault(); // Prevent the default form submission
                // Create a FormData object to combine all form data
                var form = new FormData(this);

                var long_desc = $('.ql-editor').html();
                form.append("description", long_desc);

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

            $(document).on('click', '#edit' ,function(){
                jQuery('input[name="post_id"]').remove();
                var title = $(this).parents('.cardParent').find('.posttitle').text();
                var description = $(this).parents('.cardParent').find('.postcontent').html();
                $('#emailSubject').val(title);
                $('.ql-editor').html(description);
                $('#add_announcement').append('<input type="hidden" name="post_id" value="'+ $(this).data('id') +'">');
            })

            $(document).on('click', '.compose-email' ,function(){
                $('#emailSubject').val('');
                $('.ql-editor').html('');
                jQuery('input[name="post_id"]').remove();
            })

            $(document).on("click", ".delete_announcement", function(e) {
                if (confirm("Are you sure?")) {
                    var announcement_id = $(this).attr('data-id');
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
                            action: 'delete_announcement',
                            announcement_id: announcement_id,
                        },
                        dataType: 'json',
                        success: function(response) {
                            jQuery('body').waitMe('hide');
                            // console.log(response);
                            // Swal.fire({
                            //     icon: response.icon,
                            //     title: response.title,
                            //     text: response.message,
                            // });
                            if (response.status) {
                                thiss.parents('.cardParent').fadeOut(1000);
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

            $(window).on('load', function() {
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            });
       
        </script>
    </body>
    <!-- END: Body-->

</html>