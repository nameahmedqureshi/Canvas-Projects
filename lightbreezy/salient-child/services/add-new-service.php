<?php /* Template Name: Add New Service */ ?>
<?php
if (isset($_GET['id'])) {
   $get_post = get_post($_GET['id']);
   $meta = get_post_meta( $_GET['id'] );
   $description = apply_filters('the_content', $get_post->post_content);
}
// // Get WooCommerce product categories
// $product_categories = get_terms( array(
//     'taxonomy' => 'services-category',
//     'orderby' => 'name',
//     'order'   => 'ASC',
//     'hide_empty' => false, // Change to false to show categories even if they have no products
// ) );
// $post_categories = wp_get_post_terms( $get_post->ID, 'services-category', array('fields' => 'ids') );

function selectData($storeData, $localData) {
   if ( is_array($storeData)) {
        return in_array($localData, $storeData) ? "selected" : "checked";
   }
    return $storeData == $localData ? "selected" : "checked";
}
?>

<?php include "includes/styles.php"; ?>
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/katex.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.snow.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.bubble.css">

<!-- <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/pickadate/pickadate.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
<!-- <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/pickers/form-pickadate.css"> -->

<style>
    .dna_check {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .dna_check .mb-1 {
        margin-bottom: 0 !important;
    }
    .ql-editor {
        min-height: 200px;
    }
    .form-control:disabled {
        background-color: #efefef;
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
                                            <div class="col-md-3  col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="service_name">Service Name *</label>
                                                    <input type="text" id="service_name" class="form-control" value="<?= $get_post->post_title  ?>" name="service_name" placeholder="Service Name" />
                                                </div>
                                            </div>

                                            <div class="col-md-3  col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="service_price">Service Price *</label>
                                                    <input type="text" id="service_price" class="form-control" value="<?= $meta['price'][0]  ?>" name="price" placeholder="Service Price" />
                                                </div>
                                            </div>
                                            <div class="col-md-3  col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="servic_type">Service Type *</label>
                                                    <select class="form-select" name="servic_type" id="servic_type">
                                                        <option <?= selectData($meta['servic_type'][0], 'in_person') ?> value="in_person">In Person</option>
                                                        <option <?= selectData($meta['servic_type'][0], 'remote') ?> value="remote">Remote</option>
                                                        <option <?= selectData($meta['servic_type'][0], 'recorded') ?> value="recorded">Recorded</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2  col-2">
                                                <div class="mb-1">
                                                    <label class="form-label" for="status">Status *</label>
                                                    <select class="form-select" name="status" id="status">
                                                        <option <?= selectData($meta['status'][0], 'active') ?> value="active">Active</option>
                                                        <option <?= selectData($meta['status'][0], 'in_active') ?> value="in_active">In Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                        
                                            <!-- <div class="col-md-1  col-1 dna_check">
                                                <div class="mb-1">
                                                    <input type="checkbox" <?= isset($meta['dna_check'][0]) && $meta['dna_check'][0] ? 'checked' : '' ?>  id="dna_check" name="dna_check" value="is_dna">
                                                    <label for="dna_check">Is DNA</label><br>                                                
                                                </div>
                                            </div> -->
                                                

                                            <!-- <div class="col-md-10  col-12 dna_desc">
                                                <div class="mb-1">
                                                    <label class="form-label" for="end_time">Add DNA <b>( Enter one option per line )</b></label>
                                                    <textarea class="form-control" id="add_dna" name="dna_option" rows="11"><?= $meta['dna_option'][0] ?></textarea>
                                                </div>
                                            </div> -->

                                            <div class="col-md-10  col-12 add_desc mb-1">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <!-- <p class="card-text">Please Add Description</p> -->
                                                        <label class="form-label" for="end_time">Please Add Description</label>
                                                        <div id="full-wrapper">
                                                            <div id="full-container">
                                                                <div class="editor">
                                                                    <?= $description ?>
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

                                            <?php $days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
                                                // $returnDays = ($isEdit) ? $coaching?->getslots->pluck('days')->toArray() : $days;
                                                $slots = isset($meta['slots'][0]) ? unserialize($meta['slots'][0]) : [];            
                                                $saveDay =  array_column($slots, 'days');

                                                foreach ($days as $key => $day) {

                                                    // $slotKey =  array_search($day, array_column($slots, 'days'));

                                                    $saveSlots = [];
                                                    if (in_array($day, $saveDay)) {
                                                        foreach ($slots as $key => $value) {
                                                            if ( $value['days'] == $day) {
                                                                $saveSlots = $value;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                ?>

                                                <div class="col-md-12 col-12 row days_slots <?= $day ?>">
                                                    <div class="col-md-3 mt-2">
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-label" for="days-<?= $key ?>"><?= $day ?></label>
                                                            <input class="form-check-input days" type="checkbox" name="slots[<?= $key ?>][days]" id="days-<?= $key ?>" value="<?= $day ?>" <?= (in_array($day, $saveDay)) ? "checked" : '' ?> <?= $slots ? "" : 'checked' ?>>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mb-1">
                                                        <label class="form-label" for="start_time-<?= $key ?>">Start Time</label>
                                                        <input type="text" id="start_time-<?= $key ?>" value="<?= $slots ? $saveSlots['start_time'] : "10:00" ?>"  name="slots[<?= $key ?>][start_time]" class="form-control flatpickr-time text-start start_time" placeholder="HH:MM" />
                                                    </div>

                                                    <div class="col-md-3 mb-1">
                                                        <label class="form-label" for="end_time-<?= $key ?>">End Time</label>
                                                        <input type="text" id="end_time-<?= $key ?>" value="<?=  $slots ? $saveSlots['end_time'] :"12:00" ?>" name="slots[<?= $key ?>][end_time]" class="form-control flatpickr-time text-start end_time" placeholder="HH:MM" />
                                                    </div>

                                                    <div class="col-md-3 mb-1">
                                                        <label class="form-label" for="duration-<?= $key ?>">Select duration</label>
                                                        <select class="form-select duration" id="duration-<?= $key ?>" name="slots[<?= $key ?>][duration]" required>
                                                            <?php $durations = ["10", "15", "20", "25", "30", "35", "40", "45", "50", "55", "60", "90", "120", "150", "180", "200", "220", "240", "260", "280", "300"];
                                                                foreach ($durations as $duration) { ?>
                                                                    <option value="<?= $duration ?>" <?= ($saveSlots['duration'] == $duration) ? "selected" : '' ?> ><?= $duration ?> min</option>
                                                                <?php } ?>

                                                        </select>
                                                    </div>
                                                </div>

                                            <?php } ?>



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
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/pickers/form-pickers.js"></script>

    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/image-resize.min.js"></script>

    <script>
        $(document).ready(function() {

            $(document).on( 'change', '#servic_type', function(e){
                servic_type();
            })

            function servic_type() {
                var value = $('#servic_type').val();
                // if (value == "in_person/remote") {
                if (value == "in_person" || value == "remote") {
                    $('.days_slots').show();
                    $('.days_slots').find('input, select').prop('disabled', false);

                } else {
                    $('.days_slots').find('input, select').prop('disabled', true);
                    $('.days_slots').hide();
                }
            }

            servic_type();

            $(document).on( 'change', '.days', function(e){
                disabeldField();
            })

            function disabeldField(params) {
                $('.days').each(function(i, obj) {
                    var val = $(this).val();
                    var ischeck = $(this).is(':checked');
                    if(!ischeck){
                        $(this).parents('.'+val).find('input, select').prop('disabled', true);
                    }else{
                        $(this).parents('.'+val).find('input, select').prop('disabled', false);
                    }
                    $(this).prop('disabled', false);
                });
            }

            disabeldField();

            // Function to toggle CSS properties based on the state of the checkbox
            function toggleCSS() {
                if ($('#dna_check').is(':checked')) {
                    $('.dna_desc').css({
                        'display': 'block',
                        'width': '30%'
                    });
                    $('.add_desc').css('width', '52%');
                } else {
                    $('.dna_desc').css('display', 'none');
                    $('.add_desc').css('width', '82%');
                }
            }

            // Initial call to set the CSS based on the initial state of the checkbox
            toggleCSS();

            // Event listener for the checkbox change event
            $('#dna_check').change(function() {
                toggleCSS(); // Call the toggle function whenever the checkbox state changes
            });
        });
       
        $('#select2-multiple').select2({
            placeholder: 'Select a Days'
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

</html>