<?php function pod_form_shortcode() { 
    $user = wp_get_current_user();
    // if(in_array('administrator', $user->roles) || in_array('vendor', $user->roles) ){
    //     $redirect = home_url();
    //     echo "<script>
    //          alert('{$user->roles[0]} not requested this service');
    //         window.location.href = '{$redirect}';
    //     </script>";
    //     wp_redirect(home_url(''));
    //     exit;
    // }
    $usertype = get_user_meta($user->ID, 'user_type', true);
    $type = isset($_GET['type']) ? $_GET['type'] : 'Service'; 
    $type = str_replace('-', ' ', $type);
    $type_mappings = [
        'Print On Demand' => 'Print',
        'Service On Demand' => 'Service',
        'Bulk Manufacturing' => 'Bulk'
    ];
    $type = $type_mappings[ucwords($type)] ?? ucwords($type);
    ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/css/all.css' ?>">
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/css/main.css' ?>">
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/css/responsive.css' ?>">
<style>
    .container-wrap {
        padding-top: 0px !important;
    }
    .file-row img {
        height: 50px !important;
    }

  
    .file-row {
        display: flex;
        gap: 20px;
        padding: 10px;

    }

    input#file {
        margin-top: 10px;
    }

    button.remove-row {
        background-color: #328d50;
        color: #fff;
        border: 1px solid #328d50;
        padding: 5px 11px;
        height: 30px;
        margin-top: 10px;
    }
    input.quantity-input {
        background: #ffff;
        border: 1px solid #e1e1e1;
    }

    select.material-select {
        background: #ffff;
        border: 1px solid #e1e1e1;
    }
   
    .itemTypeDiv{
        display: flex;
        gap:10px;
    }
    .itemLabel{
        margin-bottom: unset !important;
    }
    input#physical, input#digital, input#both {
        width: auto;
        height: auto;
    }
    .container.main-content {
        padding: 0;
    }
    .file-preview {
        display: flex;
        align-items: center;
        margin-top: 10px;
        gap:20px;
    }
    .file-item img {
        max-width: 100px;
        max-height: 100px;
        margin-right: 10px;
    }
    .file-item .remove-file {
        color: red;
        cursor: pointer;
        margin-left: 10px;
    }
</style>
<!-- <section class="products_top_holder">
    <div class="box_frame">
        <div class="products_top_holder_txt">
            <h1 class="products_top_holder_note"><?= $type; ?></h1>
            <h2 class="products_top_holder_note_lite">ON DEMAND</h2>
        </div>
        <div class="pic_frame">
            <img src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/images/sclupture_img.png' ?>" alt="img" class="">
        </div>
    </div>
</section> -->
<section class="products_first_holder">
    <div class="box_frame">
        <div class="print_demand_inner_holder">
            <div class="print_demand_inner_left_slice">
                <form id="print_demand_form" class="print_demand_form">
                    <div class="form_strip">
                        <input name="title" type="text" placeholder="Title" required>
                    </div>
                    <!-- <div class="form_strip">
                        <input name="category" type="text" placeholder="Category" value="<?=  $type ?>"  readonly>
                    </div> -->
                    <div class="form_strip">
                        <textarea name="description" placeholder="Description" required></textarea>
                    </div>
                    <?php if( isset($_GET['type'] ) && $_GET['type'] == 'print-on-demand'){ ?>
                    <!-- <div class="form_upper_stripe add_files">
                        <div class="form_strip">
                            <label for="">Your STL files</label>
                            <div class="file_upload_box">
                                <button type="button" class="add_click">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                                <input type="file" id="file" name="stl_files[]" accept="image/*"  class="file_input"/>
                            </div>
                            <div class="file-preview"></div>
                        </div>
                    </div> -->
                   

                    <!-- Template for the row -->
                    <div class="row-template">
                        <div class="file-row initial-row">
                            <!-- <img src="" alt="File preview" class="file-preview-image" width="50" /> -->
                            <input type="file" id="file" accept="image/*" name="stl_files[]" required />
                            <input type="number" name="quantity[]" placeholder="Enter Quantity" class="quantity-input" required />
                            <select name="material[]" class="material-select">
                                <!-- <option hidden selected>Select Material</option> -->
                                <?php
                                $args = ['taxonomy' => 'materials', 'parent' => 0, 'hide_empty' => false];
                                $parents = get_terms($args);
                                foreach ($parents as $parent) { ?>
                                    <optgroup label="<?= $parent->name ?>">
                                        <?php
                                        $args['parent'] = $parent->term_id;
                                        $children = get_terms($args);
                                        foreach ($children as $child) { ?>
                                            <option value="<?= $child->name ?>"><?= $child->name ?></option>
                                        <?php } ?>
                                    </optgroup>
                                <?php } ?>
                            </select>
                            <button type="button" class="remove-row" style="display: none;">Remove</button>
                            </div>
                    </div>

                    <div class="form_upper_stripe add_files">
                        <div class="form_strip">
                            <label for="">Your STL files</label>
                            <div class="file_upload_box">
                                <button type="button" class="add_click">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                                <!-- <input type="file" id="file"  accept="image/*" class="file_input" /> -->
                            </div>
                            <!-- <div class="file-preview"></div> -->
                        </div>
                    </div>

                        <div class="form_strip w-50">
                            <label for="">I need this printed by</label>
                            <input placeholder="Select Date" class="textbox-n" type="text" min='<?= date('Y-m-d') ?>' onfocus="(this.type='date')" onblur="(this.type='text')" name="deadline_date"  id="date" required />
                        </div>
                    <?php } ?>
                    <?php if( isset($_GET['type'] ) && $_GET['type'] == 'service-on-demand'){ ?>
                        
                        <div class="form_upper_stripe">
                            <div class="form_strip">
                                <label for="">Add picture example</label>
                                <div class="file_upload_box">
                                    <button type="button" class="add_click">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <input type="file" id="file" name="example_files[]" accept="image/*"  class="file_input" multiple/>
                                </div>
                                <div class="file-preview"></div>
                            </div>
                        </div>
                       
                   
                        <div class="form_strip w-50">
                            <label for="">I need this completed by</label>
                            <input placeholder="Select Date" class="textbox-n" type="text" min='<?= date('Y-m-d') ?>' onfocus="(this.type='date')" onblur="(this.type='text')" name="deadline_date"  id="date" required />
                        </div>
                        <div class="form_strip w-50 itemTypeDiv">
                            <input type="radio" id="physical" name="item_type" value="physical">
                            <label class="itemLabel" for="physical">Physical Item</label>
                            <input type="radio" id="digital" name="item_type" value="digital">
                            <label class="itemLabel" for="digital">Digital Item</label>
                            <input type="radio" id="both" name="item_type" value="both didital & physical">
                            <label class="itemLabel" for="both">Both</label>
                        </div>
                    <?php } ?>
                    <?php if( isset($_GET['type'] ) && $_GET['type'] == 'bulk-manufacturing'){ ?>
                    <div class="form_strip w-50">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" placeholder="Enter Quantity" required />
                    </div>
                    <?php } ?>
                    <div class="form_upper_stripe_init">
                        <div class="form_strip relative_item">
                            <label for="">Amount</label>
                            <input type="number" name="price" placeholder="Enter Amount" required>
                        </div>
                        <div class="form_strip">
                            <input type="hidden" name="type" value="<?= $_GET['type'] ?>">
                            <input type="hidden" name="action" value="add_new_request">
                            <button class="quote_btn" type="submit" data-url="<?= is_user_logged_in() && $usertype != 'business' && $_GET['type'] == 'bulk-manufacturing' ? home_url( 'register?redirect='.home_url("add-new-request/?type=bulk-manufacturing")) : '' ?>"> Get a quote </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="print_demand_inner_right_slice">
                <div class="img_strip">
                    <img src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/images/print_on_demand_img.png' ?>" alt="img">
                </div>    
            </div>
        </div>
    </div>
</section>
<!-- clone fields -->
<!-- <div class="pod-fields" style="display:none;">
    <div class="form_strip w-50">
        <label for="">Quantity</label>
        <input type="number" name="quantity" placeholder="Enter Quantity" required />
    </div>
    <div class="form_strip w-50">
        <label for="">Material</label>
        <select name="material">
        <?php
            $args = array('taxonomy' => 'materials', 'parent' => 0, 'hide_empty' => false);
            $parents = get_terms($args);
            foreach ($parents as $parent) { ?>
            <optgroup class="swe-car" label="<?= $parent->name ?>">
                <?php
                $args['parent'] = $parent->term_id;
                $children = get_terms($args);
                foreach ($children as $child) { ?>
                <option value="<?= $child->name ?>"><?= $child->name ?></option>
                <?php } ?>
            </optgroup>
        <?php } ?>
        </select>
    </div>
</div> -->
<!-- clone fields -->
<!-- <script src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/js/custom.js' ?>"></script> -->
<script>
    jQuery(document).ready(function() {
        

       // Add new row on clicking the add button
    jQuery(document).on('click', '.add_click', function () {
        // Clone the row template and make it visible
        var newRow = jQuery('.row-template .file-row').first().clone();
        // Remove the 'initial-row' class and make the remove button visible in the new row
        newRow.removeClass('initial-row').find('.remove-row').show();
        // Add 'required' attribute to the input fields in the new row
        newRow.find('input[type="file"]').attr('required', true);
        newRow.find('input[type="number"]').attr('required', true);
        newRow.find('select').attr('required', true);
        
        // Clear any existing values in the cloned inputs
        newRow.find('input').val('');

        // Append the new row to the container
        jQuery('.row-template').append(newRow);
    });

    // Handle file input change to show the image preview
    jQuery(document).on('change', '.file_input', function (e) {
        var file = e.target.files[0];
        if (!file) return; // Exit if no file is selected

        var reader = new FileReader();
        var row = jQuery(this).closest('.form_strip'); // Get the parent container

        reader.onload = function (event) {
            // Show the image preview
            row.find('.file-preview-image').attr('src', event.target.result).show();
            // Hide the file upload box
            row.find('.file_upload_box').hide();
        };

        reader.readAsDataURL(file);
    });

    // Remove row on clicking the remove button
    jQuery(document).on('click', '.remove-row', function () {
        jQuery(this).closest('.file-row').remove();
    });


        // jQuery(document).on('change', '.file_input', function (e) {
        //     var file = e.target.files[0];

        //     if (!file) return; // Exit if no file is selected

        //     var reader = new FileReader();
        //     reader.onload = function (event) {
        //         // Create a new row
        //         var newRow = jQuery('.row-template').clone().removeClass('row-template').show();

        //         // Set the file preview image
        //         newRow.find('.file-preview-image').attr('src', event.target.result).attr('alt', file.name);

        //         // Append the new row to the form
        //         jQuery('.add_files').append(newRow);
        //     };

        //     reader.readAsDataURL(file);
        // });

        // // Remove row on clicking remove button
        // jQuery(document).on('click', '.remove-row', function () {
        //     jQuery(this).closest('.file-row').remove();
        // });

        // // Remove file when "Remove" button is clicked
        // jQuery('.file-preview').on('click', '.remove-file', function() {
        //     var fileNameToRemove = jQuery(this).data('file');
        //     // Remove the file from preview
        //     jQuery('.file-item[data-file="' + fileNameToRemove + '"]').remove();
        //     // Remove file from the file input field
        //     var fileInput = jQuery('.file_input')[0];
        //     var filesArray = Array.from(fileInput.files);
        //     var updatedFiles = filesArray.filter(function(file) {
        //         return file.name !== fileNameToRemove;
        //     });
        //     // Reset the file input value and assign the updated files back
        //     var dataTransfer = new DataTransfer();
        //     updatedFiles.forEach(function(file) {
        //         dataTransfer.items.add(file);
        //     });
        //     fileInput.files = dataTransfer.files;
        //     // If all files are removed, show the upload box again
        //     if (updatedFiles.length === 0) {
        //         jQuery('.file_upload_box').show();
        //     }
        // });
    });
</script>
<script>
    const type = "<?= $_GET['type'] ?>";
    if(type != 'print-on-demand'){
        const addClickButtons = document.querySelectorAll('.add_click');
        const fileInputs = document.querySelectorAll('.file_input');
        addClickButtons.forEach((addButton, index) => {
            addButton.addEventListener('click', function () {
                fileInputs[index].click();
            });
        });

        // When files are selected
        jQuery('.file_input').on('change', function(e) {
            var files = e.target.files;
            var filePreview = jQuery('.file-preview');
            filePreview.html(''); // Reset the file preview area
            // if (files.length > 0) {
            //     jQuery('.file_upload_box').hide();
            // }
            // Iterate over the selected files and display them
            Array.from(files).forEach(function(file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var fileType = file.type.split('/')[0];
                    var filePreviewHTML = '';
                    if (fileType === 'image') {
                        filePreviewHTML = '<img src="' + event.target.result + '" alt="' + file.name + '" width="50" />';
                    } else {
                        filePreviewHTML = '<img src="<?= home_url()?>/wp-content/themes/salient-child/frontend/assets/front/images/document.png" alt="' + file.name + '" width="50" />';
                    }
                    filePreviewHTML += '<button class="remove-file" data-file="' + file.name + '">Remove</button>';
                    filePreview.append('<div class="file-item" data-file="'+ file.name +'">' + filePreviewHTML + '</div>');
                };
                reader.readAsDataURL(file);
            });
           
        });
    }
</script>
<script>
    jQuery(document).ready(function() {
        var redirect_url = jQuery("#print_demand_form").find('button[type=submit]').data('url');
        var service_type = "<?= $_GET['type'] ?>";
        // console.log(service_type);
        jQuery("#print_demand_form").submit(function(e) {
            e.preventDefault(); // prevent the default form submission

            if(service_type == 'service-on-demand'){
                const featuredImage = jQuery('#file')[0]; // Access the file input element
            
                if (featuredImage.files.length === 0) {
                    Swal.fire({
                        title: "Info",
                        text:  "Please upload file before submitting",
                        icon: "info",
                    })
                    return false;
                }
            }

            if (redirect_url) {
                Swal.fire({
                    title: "Unauthorize",
                    text:  "Please register yourself as a business to avail this feature",
                    icon: "info",
                }).then((willDelete) => {
                    window.location.href = redirect_url;
                }); 
                return false;
            }
            var form = new FormData(this);
            jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            jQuery(this).find('button[type=submit]').prop('disabled', true);
            var $thiss = jQuery(this);
            jQuery('body').waitMe({
                effect: 'bounce',
                text: '',
                bg: 'rgba(255,255,255,0.7)',
                color: '#000',
                maxSize: '',
                waitTime: -1,
                textPos: 'vertical',
                fontSize: '',
                source: ''
            });
            jQuery.ajax({
                type: 'post',
                url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery($thiss).find('button[type=submit]').prop('disabled', false);
                    if (!response.status) {
                        toastr.error(response.message, response.title);
                    } else {
                        toastr.success(response.message, response.title);
                        jQuery("#print_demand_form")[0].reset();
                        // jQuery('.file_upload_box').show();
                        // jQuery('.file-preview').html('');
                        jQuery('.file-row').html('');
                        // if (response.auto_redirect) {
                        //     window.location.href = response.redirect_url;
                        // }
                    }
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                    jQuery('body').waitMe('hide');
                }
            });
        });
    });
</script>
<?php } 
add_shortcode('pod_form', 'pod_form_shortcode');