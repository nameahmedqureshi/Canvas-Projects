<?php /* Template Name: Add Family Notice */ ?>
<?php

if ( !in_array('administrator', wp_get_current_user()->roles) && !in_array('funeral_directory', wp_get_current_user()->roles) ) { 
    wp_redirect(home_url('login/'));
  exit;
}
if (isset($_GET['id'])) {
    $get_post = get_post($_GET['id']);
    $metaData = get_post_meta($_GET['id']);
    // var_dump($post_categories);
}
?>

<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>



<?php include "includes/header.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/katex.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.bubble.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-quill-editor.css">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/pickadate/pickadate.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/pickers/form-pickadate.css">
    <!-- END: Page CSS-->


<style>
    .form-control:disabled {
        background-color: #efefef;
    }
    div#card-element {
        margin-bottom: 20px;
        margin-top: 10px;
        padding: 20px;
        background: aliceblue;
    }
    .ql-editor {
         min-height: 200px;
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
                                            
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="website-vertical">Upload Photo: (optional)</label>
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' id="imageUpload" name="person_image" accept="image/png, image/jpeg" />
                                                            <label for="imageUpload">
                                                                <i data-feather='edit' style="width: 33px; height: 29px;"></i>
                                                            </label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="imagePreview" style="background-image: url('<?= !empty($metaData['person_image'][0]) ? wp_get_attachment_url($metaData['person_image'][0]) :  $directory_url.'/assets/images/no-preview.png'  ?>')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                            <section class="snow-editor">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <label class="form-label" for="short_desc">About *</label>  
                                                            </div>
                                                            <div class="card-body1">
                                                                <div class="editor">
                                                                    <p class="card-text"></p>
                                                                    <?= $metaData['about'][0] ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                           

                                            <div class="col-md-4">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">Name *</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $metaData['name'][0]  ?>" name="name" placeholder="Name" />
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">SurName *</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $metaData['surname'][0]   ?>" name="surname" placeholder="SurName" />
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">Maiden Name</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $metaData['maiden_name'][0]   ?>" name="maiden_name" placeholder="Maiden Name" />
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-1">
                                                    <?php
                                                        $irishtown =['Belfast', 'Lisburn', 'Ballymena', 'Carrickfergus', 'Antrim','Armagh', 'Portadown', 'Lurgan', 'Craigavon','Carlow Town', 'Tullow', 'Bagenalstown', 'Hacketstown'];
                                                    ?>
                                                    <label class="form-label" for="f-name">Town</label>
                                                    <select name="town" class="form-select" id="town">
                                                        <?php foreach ($irishtown as $country): ?>
                                                            <option value="<?= esc_attr($country); ?>" <?= isset($metaData['town'][0]) && $metaData['town'][0] == $country ? 'selected' : ''; ?>>
                                                                <?= esc_html($country); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <!-- <input type="text" id="f-name" class="form-control" value="<?= $metaData['country'][0]   ?>" name="country" placeholder="Place, County" /> -->
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-1">
                                                    <?php
                                                        $irishCounties = [ 'Antrim','Armagh','Carlow','Cavan','Clare','Cork','Derry','Donegal','Down','Dublin','Fermanagh','Galway','Kerry','Kildare','Kilkenny','Laois','Leitrim','Limerick','Longford','Louth','Mayo','Meath','Monaghan','Offaly','Roscommon','Sligo','Tipperary','Tyrone','Waterford','Westmeath','Wexford','Wicklow'];
                                                    ?>
                                                    <label class="form-label" for="f-name">Place, County</label>
                                                    <select name="country" class="form-select" id="country">
                                                        <?php foreach ($irishCounties as $country): ?>
                                                            <option value="<?= esc_attr($country); ?>" <?= isset($metaData['country'][0]) && $metaData['country'][0] == $country ? 'selected' : ''; ?>>
                                                                <?= esc_html($country); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <!-- <input type="text" id="f-name" class="form-control" value="<?= $metaData['country'][0]   ?>" name="country" placeholder="Place, County" /> -->
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-1">
                                                    <?php
                                                        $categories = get_terms([
                                                            'taxonomy' => 'family-notice-category',
                                                            'hide_empty' => false, // Set to true if you only want categories with products
                                                
                                                        ]);
                                                
                                                    ?>
                                                    <label class="form-label" for="f-name">Type</label>
                                                    <select name="cat_type" class="form-select">
                                                        <?php if ( !empty($categories) && !is_wp_error($categories) ) {

                                                            foreach ( $categories as $category ){ ?>
                                                            <option value="<?= esc_attr($category->term_id); ?>" <?= isset($metaData['cat_type'][0]) && $metaData['cat_type'][0] == $category->term_id ? 'selected' : ''; ?>>
                                                                <?= esc_html($category->name); ?>
                                                            </option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if(!isset($_GET['id'])){ ?>
                                            <div class="col-md-12">
                                                <div id="card-element"></div> 
                                            </div>
                                            <?php } ?>

                                            <div class="col-md-12">
                                                <input type="hidden" value="<?= $_GET['id'] ?>" name="post_id">
                                                <!-- <input type="hidden" value="<?= $_GET['type'] ?>" name="post_type"> -->
                                                <input type="hidden" value="add_update_family_notice" name="action">
                                                <button type="submit" class="btn btn-primary me-1"><?= isset($_GET['id']) ? 'Update' : 'Submit'  ?></button>
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

    <?php
     $test_credentials = get_field( 'test_credentials' , 'option');
     $publishable_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_private_key' , 'option') : get_field( 'live_stripe_private_key' , 'option');
    
    ?>

    <?php include "includes/scripts.php"; ?>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/image-resize.min.js"></script>
     <!-- BEGIN: Page Vendor JS-->
     <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/pickers/form-pickers.js"></script>
    <!-- END: Page JS-->
    <script src="https://js.stripe.com/v3/"></script>

    <script>

        <?php if(!isset($_GET['id'])){ ?>
        // stripe 
        var pub_key = "<?= $publishable_key ?>";
        var stripe = Stripe(pub_key);
        var elements = stripe.elements();
        var cardElement = elements.create('card', {
            hidePostalCode: true,
        });
        cardElement.mount('#card-element');
        <?php } ?>

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
            var post_id = $("input[name='post_id']").val(); // Get the value of post_id
            var about = $('.ql-editor').html();
            form.append("about", about);
         
            // console.log('form', form);
            $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            $(this).find('button[type=submit]').prop('disabled', true);
            var $form = jQuery(this);
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

            if (post_id) { // Check if post_id is empty or null
                return ajexCall(form, $form);
            }

            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    Swal.fire({
                        title: "Error",
                        text: result.error.message,
                        icon: "error"
                    });
                    console.log(result.error);
                    $form.find('.fa-spinner').remove();
                    jQuery('body').waitMe('hide');
                    $form.find('button[type=submit]').prop('disabled', false);
                } else {
        
                    form.append('stripeToken', result.token.id);
                    ajexCall(form, $form);
                }
            }); 
        });

        function ajexCall(form, $form) {
            jQuery.ajax({
                type: 'post',
                url: '<?= admin_url('admin-ajax.php'); ?>',
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $form.find('.fa-spinner').remove();
                    jQuery('body').waitMe('hide');
                    $form.prop('disabled', false);
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
                    $form.find('.fa-spinner').remove();
                    $form.prop('disabled', false);
                    jQuery('body').waitMe('hide');
                }
            });
        }

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