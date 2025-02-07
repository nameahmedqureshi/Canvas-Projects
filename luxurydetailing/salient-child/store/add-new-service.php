<?php /* Template Name: Add New Service */ ?>
<?php
if (isset($_GET['id'])) {
   $get_post = get_post($_GET['id']);
}
// Get WooCommerce product categories
$product_categories = get_terms( array(
    'taxonomy' => 'services-category',
    'orderby' => 'name',
    'order'   => 'ASC',
    'hide_empty' => false, // Change to false to show categories even if they have no products
) );
$post_categories = wp_get_post_terms( $get_post->ID, 'services-category', array('fields' => 'ids') );
?>
<!-- <!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr"> -->
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/katex.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.snow.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.bubble.css">

<style>
    .ql-editor {
        min-height: 200px;
    }
    .form-control:disabled {
        background-color: #efefef;
    }
	form.form.form-vertical.manage_service .card .row.innr_row {
    padding: 0px 15px;
}
	.row.innr_row .col-sm-12 {
    padding: 0px;
}
	.des_blk {
    padding: 1.5rem 1.5rem 0px 0px;
}
	form.form.form-vertical.manage_service .col-md-10.col-12 {
    display: flex;
    margin-bottom: 30px;
}
</style>

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

            <div class="content-body">

                <!-- Basic Vertical form layout section start -->

                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form form-vertical manage_service" enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="col-md-4  col-4">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">Service Name *</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $get_post->post_title  ?>" name="service_name" placeholder="Service Name" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4  col-4">
                                                <div class="mb-1">
                                                    <label class="form-label" for="service_type">Select Service *</label>
                                                    <select class="form-select" name="service_type" id="service_type">
                                                        <option <?php if (get_post_meta($get_post->ID, 'service_type', true) == 'main_service') echo 'selected'; ?> value="main_service">Main Service</option>
                                                        <option <?php if (get_post_meta($get_post->ID, 'service_type', true) == 'special_service') echo 'selected'; ?> value="special_service">Add-Ons</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4  col-4">
                                                <div class="mb-1">
                                                    <label class="form-label" for="status">Status *</label>
                                                    <select class="form-select" name="status" id="status">
                                                        <option <?php if (get_post_meta($get_post->ID, 'status', true) == 'active') echo 'selected'; ?>  value="active">Active</option>
                                                        <option <?php if (get_post_meta($get_post->ID, 'status', true) == 'in_active') echo 'selected'; ?> value="in_active">In Active</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2  col-2">
                                                <div class="mb-1">
                                                    <label class="form-label" for="cars_price">Cars Price *</label>
                                                    <input type="number" id="cars_price" class="form-control" value="<?= get_post_meta($get_post->ID, 'cars_price', true)  ?>" name="cars_price" placeholder="Cars Price" />
                                                </div>
                                            </div>
                                            <div class="col-md-2  col-2">
                                                <div class="mb-1">
                                                    <label class="form-label" for="truck_price">SYV’s & Trucks Price *</label>
                                                    <input type="number" id="truck_price" class="form-control" value="<?= get_post_meta($get_post->ID, 'truck_price', true)  ?>" name="truck_price" placeholder="SYV’s & Trucks Price" />
                                                </div>
                                            </div>
                                            <div class="col-md-2  col-2">
                                                <div class="mb-1">
                                                    <label class="form-label" for="over_sized">Over Sized Price *</label>
                                                    <input type="number" id="over_sized" class="form-control" value="<?= get_post_meta($get_post->ID, 'over_sized', true)  ?>" name="over_sized" placeholder="Over Sized Price" />
                                                </div>
                                            </div>
                                            <div class="col-md-2  col-2">
                                                <div class="mb-1">
                                                    <label class="form-label" for="single_price">Single Price</label>
                                                    <input type="number" id="single_price" class="form-control" <?= get_post_meta($get_post->ID, 'single_price', true) ? "" : "disabled" ?>  value="<?= get_post_meta($get_post->ID, 'single_price', true)  ?>" name="single_price" placeholder="Single Price" />
                                                </div>
                                            </div>
                                            <div class="col-md-4  col-4">
                                                <div class="mb-1">
                                                    <label class="form-label" for="single_price_text">Single Price Description</label>
                                                    <input type="text" id="single_price_text" class="form-control" <?= get_post_meta($get_post->ID, 'single_price', true) ? "" : "disabled" ?> value="<?= get_post_meta($get_post->ID, 'single_price_text', true)  ?>" name="single_price_text" placeholder="Single Price text" />
                                                </div>
                                            </div>

                                            <div class="col-md-10  col-12">
                                                    <div class="card">
                                                       
                                                        <div class="card-body des_blk">
                                                            <p class="card-text">Please Add Description</p>
                                                            <div class="row innr_row">
                                                                <div class="col-sm-12">
                                                                    <div id="full-wrapper">
                                                                        <div id="full-container">
                                                                            <div class="editor">
                                                                                <?= $get_post->post_content ?>
                                                                                <p class="card-text"></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                            <div class="col-md-2  col-12">
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
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/image-resize.min.js"></script>

    <script>
              jQuery('#service_type').change(function() {
                if (jQuery(this).val() == 'special_service') {
                    jQuery('#single_price').prop('disabled', false);
                    jQuery('#single_price_text').prop('disabled', false);
                } else {
                    jQuery('#single_price').prop('disabled', true);
                    jQuery('#single_price_text').prop('disabled', true);
                }
            });
            jQuery('#single_price, #single_price_text').on('input', function() {
                jQuery('#over_sized').val('');
                jQuery('#truck_price').val('');
                jQuery('#cars_price').val('');
            });
            jQuery('#over_sized, #truck_price, cars_price').on('input', function() {
                jQuery('#single_price').val('');
                jQuery('#single_price_text').val('');
            });

        $(".manage_service").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = new FormData(this);
            var description = $('.ql-editor').html();
            form.append("description", description);
            // console.log('form', form);
            $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            $(this).find('button[type=submit]').prop('disabled', true);
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
                    $('.fa.fa-spinner.fa-spin').remove();
                    $('body').waitMe('hide');
                    $(thiss).find('button[type=submit]').prop('disabled', false);
                    //  console.log(response);
                    if (!response.status) {
                        Swal.fire({
                            title: response.icon,
                            text: response.message,
                            icon: response.icon,
                        })

                    } else{
                            if (response.auto_redirect) {window.location.href = response.redirect_url;}
                            else{ 
                                Swal.fire({
                                    title: response.title,
                                    text:  response.message,
                                    icon: response.icon,
                                }).then((willDelete) => {
                                if (response.redirect_url) {window.location.href = response.redirect_url;}
                                }); 
                            }
                        
                        } 
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                    $('body').waitMe('hide');
                }
            });
        });

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
    </script>

</body>
<!-- END: Body-->

<!-- </html> -->