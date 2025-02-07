<?php /*Template Name: Forum */ ?>
<?php //if(is_user_logged_in()) {  wp_redirect(home_url('dashboard/')); exit; } ?>
<?php
    $post_status = 'publish';
    if(isset($_GET['type']) && $_GET['type'] == 'draft'){
        $post_status = 'draft';
    }elseif(isset($_GET['type']) && $_GET['type'] == 'myforum'){
        $post_status =  ['publish', 'draft'];
    }

  
    if(in_array('administrator', wp_get_current_user()->roles)){ 
        $args = [
            'post_type' => 'forum',
            'post_status' => $post_status,
            'posts_per_page' => -1,
            'author' =>  isset($_GET['type']) && $_GET['type'] == 'myforum' ? get_current_user_id() : '',
        ];

        // Fetch count for all published forums
        $all_published_count = (new WP_Query([
            'post_type'      => 'forum',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ]))->found_posts;

        // Fetch count for "My Forums" (published + draft)
        $my_forum_count = (new WP_Query([
            'post_type'      => 'forum',
            'post_status'    => ['publish', 'draft'],
            'posts_per_page' => -1,
            'author'         => get_current_user_id(),
        ]))->found_posts;

        // Fetch count for "Waiting for Approval" (all drafts)
        $waiting_for_approval_count = (new WP_Query([
            'post_type'      => 'forum',
            'post_status'    => 'draft',
            'posts_per_page' => -1,
        ]))->found_posts;

    } else {
        $args = [
            'post_type' => 'forum',
            'post_status' => $post_status,
            'posts_per_page' => -1,
            'author' =>  get_current_user_id(),
        ];

        // Fetch count for all published forums
        $all_published_count = (new WP_Query([
            'post_type'      => 'forum',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'author'         => get_current_user_id(),
        ]))->found_posts;

        // Fetch count for "My Forums" (published + draft)
        $my_forum_count = (new WP_Query([
            'post_type'      => 'forum',
            'post_status'    => ['publish', 'draft'],
            'posts_per_page' => -1,
            'author'         => get_current_user_id(),
        ]))->found_posts;

        // Fetch count for "Waiting for Approval" (all drafts)
        $waiting_for_approval_count = (new WP_Query([
            'post_type'      => 'forum',
            'post_status'    => 'draft',
            'posts_per_page' => -1,
            'author'         => get_current_user_id(),
        ]))->found_posts;
    }

    $announcements = new WP_Query($args);


    // $current_user_id = get_current_user_id();





    // var_dump($announcements)
?>
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
       
        .email-application .email-app-details .email-scroll-area {
            padding-left: 1.5%;
            padding-right: 1.5%;
        }
        p.no-record {
            text-align: center;
            padding: 50px;
        }
        .forumShow {
            display: flex;
        }

        .form-floating {
            margin-bottom: 20px;
        }


        li.user-mail {
            margin-bottom: 15px;
        }
        .bottom-left {
            float: left;
            margin-top: 15px;
        }

        .bottom-left li {
            background: transparent !important;
            border: none !important;
        }

        .dark-layout .postcontent *, .dark-layout .question * {
            color: #caced7 !important;
        }
        
        .postcontent *, .question * {
            color: black !important;
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
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="sidebar-content email-app-sidebar">
                        <div class="email-app-menu">
                            <div class="form-group-compose text-center compose-btn">
                                <button type="button" class="compose-email btn btn-primary w-100" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#compose-mail">
                                    Add New
                                </button>
                            </div>
                            <div class="sidebar-menu-list">
                                <div class="list-group list-group-messages">
                                    <a href="<?= site_url('forums') ?>" class="list-group-item list-group-item-action <?= !isset($_GET['type']) ? 'active' : ''?>">
                                        <i data-feather="mail" class="font-medium-3 me-50"></i>
                                        <span class="align-middle">Forum</span>
                                        <span class="badge badge-light-success rounded-pill float-end"><?= $all_published_count ?></span>
                                    </a>
                                    <a href="<?= site_url('forums?type=myforum') ?>" class="list-group-item list-group-item-action <?= isset($_GET['type']) && $_GET['type'] == 'myforum' ? 'active' : ''?>">
                                        <i data-feather="send" class="font-medium-3 me-50"></i>
                                        <span class="align-middle">My Forum</span>
                                        <span class="badge badge-light-danger rounded-pill float-end"><?= $my_forum_count ?></span>
                                    </a>
                                    <a href="<?= site_url('forums?type=draft') ?>" class="list-group-item list-group-item-action <?= isset($_GET['type']) && $_GET['type'] == 'draft' ? 'active' : ''?>">
                                        <i data-feather="edit-2" class="font-medium-3 me-50"></i>
                                        <span class="align-middle">Waiting for approval</span>
                                        <span class="badge badge-light-warning rounded-pill float-end"><?= $waiting_for_approval_count ?></span>
                                    </a>
                                </div>
                                <h6 class="section-label mt-3 mb-1 px-2">Labels</h6>
                                <div class="list-group list-group-labels">
                                    <a href="#" class="list-group-item list-group-item-action"><span class="bullet bullet-sm bullet-success me-1"></span>Approved Topics</a>
                                    <a href="#" class="list-group-item list-group-item-action"><span class="bullet bullet-sm bullet-warning me-1"></span>Waiting For Approval</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="content-right">
                <div class="content-wrapper container-xxl p-0">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="body-content-overlay"></div>
                        <!-- Email list Area -->
                        <div class="email-app-list">
                            <!-- Email search starts -->
                            <div class="app-fixed-search d-flex align-items-center">
                                <div class="sidebar-toggle d-block d-lg-none ms-1">
                                    <i data-feather="menu" class="font-medium-5"></i>
                                </div>
                                <div class="d-flex align-content-center justify-content-between w-100">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
                                        <input type="text" class="form-control" id="email-search" placeholder="Search......" aria-label="Search..." aria-describedby="email-search" />
                                    </div>
                                </div>
                            </div>
                            <!-- Email search ends -->

                            <!-- Email list starts -->
                            <div class="email-user-list">
                                <ul class="email-media-list">
                                    <?php 
                                       
                                        foreach($announcements->posts ?? [] as $key => $val){ 
                                            $author = get_userdata($val->post_author);
                                            $profile_pic = get_user_meta($val->post_author, 'profile_pic', true);
                                            $image_url = wp_get_attachment_image_url( $profile_pic );
                                    ?>

                                  
                                    <li class="user-mail forumShow" data-id="<?= $val->ID ?>">
                                        <div class="mail-left pe-50">
                                            <div class="avatar">
                                                <img src="<?=  !empty($image_url) ? $image_url : $directory_url.'/store/assets/images/avatar.png' ?>" alt="avatar img holder" width="48" height="48" />
                                            </div>
                                            
                                        </div>
                                        <div class="mail-body">
                                            <div class="mail-details">
                                                <div class="mail-items">
                                                    <h5 class="mb-25 posttitle"><?= get_the_title( $val->ID ) ?></h5>

                                                    <span class="text-truncate mb-0"> <?= $author->display_name ?> </span>
                                                </div>
                                                <div class="mail-meta-item d-flex align-items-center">
                                                    <span class="me-50 bullet bullet-<?= $val->post_status == 'draft' ? 'warning' : 'success' ?> bullet-sm"></span>
                                                    <small class="mail-date-time text-muted"><?= date("d M y, g:i A", strtotime($val->post_date)) ?></small>
                                                </div>
                                            </div>
                                            <div class="mail-message postcontent"><?= $val->post_content ?></div>
                                            <?php if(in_array('administrator', wp_get_current_user()->roles)){ ?>
                                            <div class="bottom-left">
                                                <ul class="list-inline m-0">
                                                    <li class="list-inline-item mail-unread">
                                                        <?= get_comments_number($val->ID) ?> <span class="action-icon"><i data-feather="message-square" class="font-medium-2"></i></span>
                                                    </li>
                                                    <li class="list-inline-item mail-unread" id="edit" data-id="<?= $val->ID  ?>" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#compose-mail">
                                                        <span class="action-icon"><i data-feather="edit" class="font-medium-2"></i></span>
                                                    </li>
                                                    <li class="list-inline-item mail-delete delete_forum" data-id="<?= $val->ID  ?>">
                                                        <span class="action-icon"><i data-feather="trash-2" class="font-medium-2"></i></span>
                                                    </li>
                                                    <?php if(in_array('administrator', wp_get_current_user()->roles) && $_GET['type'] == 'draft'){ ?>
                                                    <li class="list-inline-item mail-delete approved_forum" data-id="<?= $val->ID  ?>">
                                                        <span class="action-icon"><i data-feather='check-circle' class="font-medium-2"></i></i></span>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <?php } elseif(in_array('customer', wp_get_current_user()->roles) && $_GET['type'] == 'myforum') { ?>
                                            <div class="bottom-left">
                                                <ul class="list-inline m-0">
                                                    <li class="list-inline-item mail-unread">
                                                        <?= get_comments_number($val->ID) ?> <span class="action-icon"><i data-feather="message-square" class="font-medium-2"></i></span>
                                                    </li>
                                                    <li class="list-inline-item mail-unread" id="edit" data-id="<?= $val->ID  ?>" data-bs-backdrop="false" data-bs-toggle="modal" data-bs-target="#compose-mail">
                                                        <span class="action-icon"><i data-feather="edit" class="font-medium-2"></i></span>
                                                    </li>
                                                    <li class="list-inline-item mail-delete delete_forum" data-id="<?= $val->ID  ?>">
                                                        <span class="action-icon"><i data-feather="trash-2" class="font-medium-2"></i></span>
                                                    </li>
                                                   
                                                </ul>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <?php } if(!$announcements->found_posts) { ?>
                                        <p class="no-record">No Topics found</p>
                                    <?php } ?>
                                 

                                </ul>
                                <div class="no-results">
                                    <h5>No Items Found</h5>
                                </div>
                            </div>
                            <!-- Email list ends -->
                        </div>
                        <!--/ Email list Area -->
                        <!-- Detailed Email View -->
                        <div class="email-app-details">
                            <!-- Detailed Email Header starts -->
                            <div class="email-detail-header">
                                <div class="email-header-left d-flex align-items-center">
                                    <span class="go-back me-1"><i data-feather="chevron-left" class="font-medium-4"></i></span>
                                    <h4 class="email-subject mb-0">Forum Discussion 😃</h4>
                                </div>
                            </div>
                            <!-- Detailed Email Header ends -->

                            <!-- Detailed Email Content starts -->
                            <div class="email-scroll-area" id="forumDetail">
                                <div class="forum_show"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <form id="replyForum">
                                            <div class="form-floating">
                                                <textarea class="form-control" name="reply" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                                <label for="floatingTextarea2">Comments</label>
                                            </div>
                                            <input type="hidden" name="post_id" value="<?= $val->ID ?>">
                                            <input type="hidden" name="action" value="replyForum">
                                            <button type="submit" class="reply btn btn-primary w-20">
                                                Reply
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="comment_show"></div>
                                <!-- <div id="pagination-section"></div> -->
                                <!-- <input type="hidden" id="forum-id" value="596">  -->

                               
                            </div>
                            <!-- Detailed Email Content ends -->
                        </div>
                        <!--/ Detailed Email View -->

                        <!-- compose email -->
                        <div class="modal modal-sticky" id="compose-mail" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content p-0">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Forum</h5>
                                        <div class="modal-actions">
                                            <a href="#" class="text-body me-75"><i data-feather="minus"></i></a>
                                            <a href="#" class="text-body me-75 compose-maximize"><i data-feather="maximize-2"></i></a>
                                            <a class="text-body" href="#" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></a>
                                        </div>
                                    </div>
                                    <div class="modal-body flex-grow-1 p-0">
                                        <form id="add_forum">
                                            
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
                                                        <input type="hidden" name="action" value="add_forum">
                                                        <button type="submit" class="btn btn-primary">Publish</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ compose email -->

                  
                    </div>
                </div>
            </div>
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

            $("#add_forum").submit(function(e) {
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

            //reply
            $("#replyForum").submit(function(e) {
                e.preventDefault(); // Prevent the default form submission
                // Create a FormData object to combine all form data
                var form = new FormData(this);
                var post_id = form.get('post_id');
                console.log("post_id", post_id);
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
                            toastr.success(response.message, response.title);
                            $('.comment_show').prepend(response.forumReply);
                            $("#replyForum")[0].reset();
                        } 
                    },
                    error: function(errorThrown) {
                        jQuery('body').waitMe('hide');
                        console.log(errorThrown);
                    }
                });
            });

            function get_comments(post_id){

                jQuery.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php') ?>",
                    data: {
                        action: 'get_comments_by_post_id',
                        post_id: post_id,
                    },
                    dataType: 'json',
                    success: function (response) {
                        // jQuery('body').waitMe('hide');
                        // console.log(response.html);
                        jQuery('.comment_show').html(response.html);
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                        // jQuery('body').waitMe('hide');
                    }
                });

            }

            $(document).on('click', '#edit' ,function(){
                jQuery('input[name="post_id"]').remove();
                var title = $(this).parents('.forumShow').find('.posttitle').text();
                var description = $(this).parents('.forumShow').find('.postcontent').html();
                $('#emailSubject').val(title);
                $('.ql-editor').html(description);
                $('#add_forum').append('<input type="hidden" name="post_id" value="'+ $(this).data('id') +'">');
            })

            $(document).on('click', '.compose-email' ,function(){
                $('#emailSubject').val('');
                $('.ql-editor').html('');
                jQuery('input[name="post_id"]').remove();
            })

            $(document).on("click", ".forumShow", function(e) {
                var forum_id = $(this).attr('data-id');
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
                        action: 'forum_detail',
                        forum_id: forum_id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        // jQuery('body').waitMe('hide');
                        // console.log(response);
                        
                        if (response.status) {
                            $('.forum_show').html(response.forum_html);
                            $('.comment_show').html(response.comment_html);
                            // $('#pagination-section').html(response.pagination_html); // Update pagination section

                            jQuery('body').waitMe('hide');
                        }
                    },
                    error: function(errorThrown) {
                        console.log(errorThrown);
                        // jQuery('body').waitMe('hide');
                    }
                });
                
            });

            //aproved
            $(document).on("click", ".approved_forum", function(e) {
                if (confirm("Are you sure to approve this?")) {
                    var forum_id = $(this).attr('data-id');
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
                            action: 'approved_forum',
                            forum_id: forum_id,
                        },
                        dataType: 'json',
                        success: function(response) {
                            jQuery('body').waitMe('hide');
                           
                            if (response.status) {
                                thiss.parents('.forumShow').fadeOut(1000);
                                toastr.success("Approved");
                            } else {
                                toastr.error(response.message, response.title);
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

            $(document).on("click", ".delete_forum", function(e) {
                if (confirm("Are you sure?")) {
                    var forum_id = $(this).attr('data-id');
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
                            action: 'delete_forum',
                            forum_id: forum_id,
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
                                thiss.parents('.forumShow').fadeOut(1000);
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

            // jQuery(document).on('click', '.page-link', function (e) {
            //     e.preventDefault();
            //     var page = jQuery(this).data('page');
            //     var forum_id = jQuery('#forum-id').val(); // Replace with your forum ID source

            //     jQuery.ajax({
            //         url: "<?= admin_url('admin-ajax.php') ?>",
            //         type: 'POST',
            //         data: {
            //             action: 'forum_detail',
            //             forum_id: forum_id,
            //             page: page,
            //         },
            //         success: function (response) {
            //             jQuery('.comment_show').html(response.comment_html); // Update comments section
            //             jQuery('#pagination-section').html(response.pagination_html); // Update pagination section
            //             console.log(response.comment_html);
            //         },
            //     });
            // });



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