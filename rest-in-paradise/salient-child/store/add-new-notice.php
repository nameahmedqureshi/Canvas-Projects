<?php /* Template Name: Add Death Notice */ ?>
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
                                                    <label class="form-label" for="f-name">Date of Death *</label>
                                                    <input type="text" name="death_date" id="fp-default" value="<?=  $metaData['death_date'][0]   ?>" class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">In the loving care of (Optional)</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $metaData['loving_care'][0]  ?>" name="loving_care" placeholder="In the loving care" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">Predeceased by (Optional)</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $metaData['predeceased'][0]  ?>" name="predeceased" placeholder="Predeceased" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">Deeply missed & loved by (Optional)</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $metaData['deeply_missed'][0]  ?>" name="deeply_missed" placeholder="Deeply missed & loved" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="short_desc">Some Special Words: (Optional)</label>
                                                    <input class="form-control" id="exampleFormControlTextarea1" name="special_words" value="<?= $metaData['special_words'][0] ?>" placeholder="Some Special Words" /> 
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">Funeral Details *</label>
                                                    <input type="text" id="f-name" class="form-control" value="<?= $metaData['funeral_details'][0]  ?>" name="funeral_details"  placeholder="Funeral Details" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">Live Funeral Stream Link (Optional)</label>
                                                    <input type="link" id="f-name" class="form-control" value="<?= $metaData['stream_link'][0]  ?>" name="stream_link" placeholder="Live Funeral Stream Link" />
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-2 mt-2">
                                                <h3 class="form-label">Died</h3>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="died" id="inlineRadio1" value="Peacefully" <?=  $metaData['died'][0] == 'Peacefully' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="inlineRadio1">Peacefully</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="died" id="inlineRadio2" value="Suddenly" <?=  $metaData['died'][0] == 'Suddenly' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="inlineRadio2">Suddenly</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="died" id="inlineRadio3" value="Suddenly but peacefully" <?=  $metaData['died'][0] == 'Suddenly but peacefully' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="inlineRadio3">Suddenly but peacefully
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="died" id="inlineRadio4" value="Tragically" <?=  $metaData['died'][0] == 'Tragically' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="inlineRadio4">Tragically</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-2 mt-2">
                                                <h3 class="form-label">The Family wish for</h3>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="wish" id="wish1" value="No Flowers" <?=  $metaData['wish'][0] == 'No Flowers' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="wish1">No Flowers</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="wish" id="wish2" value="Family Flowers only" <?=  $metaData['wish'][0] == 'Family Flowers only' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="wish2">Family Flowers only</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="wish" id="wish3" value="Flowers Welcome" <?=  $metaData['wish'][0] == 'Flowers Welcome' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="wish3">Flowers Welcome</label>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="f-name">Donations To</label>
                                                    <input type="text" id="fp-default" name="donation_to" value="<?php //echo $metaData['donation_to'][0] ?>" class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">                                                </div>
                                                </div>
                                            </div> -->
                                         
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

                                            <div class="col-md-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="website-vertical">Upload Photo (optional)</label>
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

                                            <div class="col-md-8 mb-9">
                                                <h3 class="form-label" >For the family only: would they like their notice to go up on restinparadise’ Social Media Pages?</h3>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="family_notice" id="family_notice1" value="Yes" <?=  $metaData['family_notice'][0] == 'Yes' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="family_notice1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="family_notice" id="family_notice2" value="No" <?=  $metaData['family_notice'][0] == 'No' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="family_notice2">No</label>
                                                </div>
                                            </div>
                                           
                                            
                                            <div class="col-md-12">
                                                <input type="hidden" value="<?= $_GET['id'] ?>" name="post_id">
                                                <input type="hidden" value="<?= $_GET['type'] ?>" name="post_type">
                                                <input type="hidden" value="add_update_notice" name="action">
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

    <script>

       

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