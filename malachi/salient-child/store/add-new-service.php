<?php /* Template Name: Add New Service */ ?>
<?php

if (!in_array('administrator', wp_get_current_user()->roles) && !in_array('vendor', wp_get_current_user()->roles)) { 
    wp_redirect(home_url('dashboard/'));
  exit;
}
if (isset($_GET['id'])) {
    $get_post = get_post($_GET['id']);
    $post_categories = wp_get_post_terms( $get_post->ID, 'services-category', array('fields' => 'ids') );
    // var_dump($post_categories);
}
// Get WooCommerce services_categories
$services_categories = get_terms( array(
    'taxonomy' => 'services-category',
    'orderby' => 'name',
    'order'   => 'ASC',
    'hide_empty' => false, // Change to false to show categories even if they have no products
) );
?>

<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>



<?php include "includes/header.php"; ?>
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/katex.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.snow.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.bubble.css">


<style>
    .form-control:disabled {
        background-color: #efefef;
    }
    .ql-editor {
        min-height: 200px;
    }
    .dark-layout .select2-container .select2-selection--multiple .select2-selection__choice {
        color: #f6fffb !important;
    }

    .avatar-upload .avatar-preview {
        width: 250px;
        height: 250px;
        position: relative;
        border-radius: 9%;
        border: 6px solid #F8F8F8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    }
    .avatar-upload {
        position: relative;
        max-width: 260px;
    }

    .avatar-upload .avatar-preview > div {
        width: 100%;
        height: 100%;
        border-radius: 9%;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
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

            <div class="content-body">

                <!-- Basic Vertical form layout section start -->

                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="manage_service" class="form form-vertical" enctype="multipart/form-data">

                                        <div class="row">

                                            <!-- Select Vendor -->
                                            <?php
                                            if( in_array('administrator', wp_get_current_user()->roles)  ){ 
                                                // If editing an existing product, retrieve its meta
                                                if (!empty($_GET['id'])) {
                                                   
                                                    $get_post = get_post($_GET['id']);
                                                    $get_user = get_user_by( 'id', $get_post->post_author);
                                                    $selected_user_type = $get_user->roles[0];
                                                    $selected_user_id = $get_post->post_author;
                                                    $users_arg = new WP_User_Query(array(
                                                        'role' => $selected_user_type
                                                    ));
                                                } else {
                                                    $users_arg = new WP_User_Query(array(
                                                        'role' => 'vendor'
                                                    ));
                                                } 
                                                $get_users = $users_arg->get_results();
                                                ?>
                                                <!-- <div class="col-md-6 col-12 user">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="select_user_type">Select User Type *</label>
                                                        <select name="user_type" class="form-select" id="select_user_type">
                                                            <option  hidden <?= empty($selected_user_type) ? 'selected' : '' ?>>Select User Type</option> 
                                                            <option value="vendor" <?= $selected_user_type == 'vendor' ? 'selected' : '' ?>>Vendor</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="<?= in_array('administrator', wp_get_current_user()->roles) ? 'col-md-4' : 'col-md-6'  ?> col-12 user">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="select_user">Select User *</label>
                                                        <select name="user_id" class="form-select" id="select_user">
                                                            <!-- <option  hidden <?= empty($selected_user_id) ? 'selected' : '' ?>>Select User</option> -->

                                                            <?php foreach ($get_users as $user) { ?>
                                                                <option value="<?= esc_attr($user->ID) ?>" <?= $selected_user_id == $user->ID ? 'selected' : '' ?>>
                                                                    <?= esc_html($user->display_name) ?>
                                                                </option>
                                                            <?php } ?>                                                    
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="<?= in_array('administrator', wp_get_current_user()->roles) ? 'col-md-4' : 'col-md-6'  ?>  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">Service Name *</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $get_post->post_title  ?>" name="service_name" placeholder="Service Name" />
                                                </div>
                                            </div>

                                            <div class="<?= in_array('administrator', wp_get_current_user()->roles) ? 'col-md-4' : 'col-md-6'  ?>  col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="service_price">Price *</label>
                                                    <input type="text" id="service_price" class="form-control" value="<?= get_post_meta($get_post->ID, 'price', true)  ?>" name="service_price" placeholder="Service Price" />
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-6 mb-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="selectStatus">Select Status</label>
                                                    <select class="form-select" name="service_status" id="selectStatus">
                                                        <!-- <option selected hidden disabled>Select Status</option> -->
                                                        <option <?= $get_post->post_status == 'publish' ? 'selected' : ''  ?>  value="publish">Publish</option>
                                                        <option <?= $get_post->post_status == 'draft' ? 'selected' : ''  ?> value="draft">Draft</option>
                                                    </select>
                                                </div>
                                            </div>

                                            

                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="categories">Categories</label>
                                                <select class="form-select" id="categories" name="service_categories[]" multiple>
                                                    <optgroup label="Select Categories">
                                                        <?php foreach ($services_categories as $cat) {  ?>
                                                            <option value="<?=  esc_attr( $cat->term_id ) ?>" <?= !empty($post_categories) && in_array($cat->term_id, $post_categories) ? 'selected' : '' ?>><?= esc_attr( $cat->name ) ?></option>
                                                        <?php } ?>
                                                    </optgroup>
                                                </select>
                                            </div>

                                            <div class="col-9">
                                                <div class="card">
                                                    <div class="card-header" style="padding: 0px;">
                                                        <label class="form-label" for="short_desc">Description:</label>
                                                    </div>
                                                    <div class="card-body" style="padding: 0px;">
                                                        <div class="editor">
                                                            <p class="card-text"></p>
                                                            <?= $get_post->post_content ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="website-vertical">Service Image</label>
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' id="imageUpload" name="service_image" accept="image/png, image/jpeg" />
                                                            <label for="imageUpload">
                                                                <i data-feather='edit' style="width: 33px; height: 29px;"></i>
                                                            </label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="imagePreview" style="background-image: url('<?= !empty(get_the_post_thumbnail_url($get_post->ID)) ? get_the_post_thumbnail_url($get_post->ID) :  $directory_url.'/assets/images/no-preview.png'  ?>')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <input type="hidden" value="<?= $_GET['id'] ?>" name="post_id">
                                                <input type="hidden" value="add_update_services" name="action">
                                                <button type="submit" class="btn btn-primary me-1"><?= isset($_GET['id']) ? 'Update' : 'Submit'  ?></button>
                                                <!-- <button type="reset" class="btn btn-outline-secondary">Reset</button> -->
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



    <?php include "includes/scripts.php"; ?>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/image-resize.min.js"></script>

    <script>

        jQuery("#categories").select2();

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

        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote', 'code-block'],

            [{
                'header': 1
            }, {
                'header': 2
            }], // custom button values
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }], // superscript/subscript
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction

            [{
                'size': ['small', false, 'large', 'huge']
            }], // custom dropdown
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],

            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            [{
                'font': []
            }],
            [{
                'align': []
            }],

            ['clean'], // remove formatting button
            ['link', 'image'],

        ];

        var container = $('.editor');
        var quill = new Quill('.editor', {
            modules: {
                imageResize: {
                    displaySize: true
                }, // default false
                toolbar: toolbarOptions,
            },
            theme: 'snow'
        });

        $("#manage_service").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = new FormData(this);
            
            var long_desc = $('.ql-editor').html();
            form.append("long_desc", long_desc);
            var categories =  jQuery('#categories').val(); 
            form.append("service_categories", categories);

            // console.log(Array.from(form.entries()));

         
            // console.log('form', form);
            // $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            // $(this).find('button[type=submit]').prop('disabled', true);
            var thiss = $(this);
            $('body').waitMe({
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
            $.ajax({
                type: 'post',
                url: "<?= admin_url('admin-ajax.php')  ?>",
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // $('.fa.fa-spinner.fa-spin').remove();
                    $('body').waitMe('hide');
                    // $(thiss).find('button[type=submit]').prop('disabled', false);
                    //  console.log(response);
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
                    console.log(errorThrown);
                    $('body').waitMe('hide');
                }
            });
        });

        // $(document).on('change', '#select_user_type', function(e) {
        //     var user_type = jQuery(this).val();
        //     var thiss = jQuery(this);
        //     jQuery('body').waitMe({
        //         effect: 'pulse',
        //         text: '',
        //         bg: 'rgba(255,255,255,0.7)',
        //         color: '#000',
        //         maxSize: '',
        //         waitTime: -1,
        //         textPos: 'vertical',
        //         fontSize: '',
        //         source: '',
        //     });
        
        //     jQuery.ajax({
        //         type: 'post',
        //         url: '<?= admin_url('admin-ajax.php'); ?>',
        //         data: {
        //             action: 'get_users_by_type',
        //             user_type: user_type,
        //         },
        //         dataType: 'json',
        //         success: function (response) {
        //             jQuery('body').waitMe('hide');
        //             jQuery('#select_user').html(response.usersHtml); 
        //         },
        //         error: function (errorThrown) {
        //             console.log(errorThrown);
        //             jQuery('body').waitMe('hide');
        //         }
        //     });

        // });
    </script>

</body>
<!-- END: Body-->

</html>