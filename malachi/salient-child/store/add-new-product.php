<?php  /* Template Name: Add New Product */ ?>
<?php
if(in_array('administrator', wp_get_current_user()->roles) || in_array('vendor', wp_get_current_user()->roles)) { ?>

<?php

$_product = !empty($_GET['id']) ? wc_get_product($_GET['id']) : new WC_Product_Simple();
$attributes = $_product->get_attributes();
$stl_files = get_post_meta($_product->get_id(), 'stl_files', true);
if(isset($_GET['id'])){
    $product_categories = wp_get_post_terms( $_GET['id'], 'product_cat', array('fields' => 'ids') );
    $product_tags = wp_get_post_terms( $_GET['id'], 'product_tag', array('fields' => 'ids') );
    $metadata = get_post_meta($_GET['id']);
    $availability = get_post_meta($_GET['id'], 'availability', true);
    // var_dump($metadatas);
}

$tags = get_tags(array(
    'taxonomy'   =>  'product_tag' ,
    'hide_empty' => false
));
$categories = get_categories(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hierarchical' => true,  // Ensures hierarchical order
));



// echo "<pre>";
// var_dump($categories);

// exit;

include "includes/styles.php"; ?>

<!-- END: Head-->
<?php include "includes/header.php"; ?>

<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-validation.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-wizard.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">

<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/katex.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/monokai-sublime.min.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.snow.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/editors/quill/quill.bubble.css">
<link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-quill-editor.css">

<style>
     
     .select2-results__option.select2-results__option--highlighted {
        color: #ffff !important;
        background: #084025 !important;
    }

     span#subscription_tooltip {
 
         font-size: 12px;
         font-weight: 600;

     }   
     .avatar img {
        width: 50px;
        height: 50px;
    }

     /* ul.list-group {
        height: 400px;
        overflow: auto;
    } */

    ul.list-group {
        /* width: 200px; */
        height: 400px;
        background: #ffffff;
        overflow: scroll;
        overflow-x: hidden;
    }
    ul.list-group::-webkit-scrollbar {
        width: 12px;
    }

    ul.list-group::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
        border-radius: 10px;
    }

    ul.list-group::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
    }


     html.light-layout.dark-layout .form-check-input:checked{
        background-color: #ffff;
     } 
     html.dark-layout .form-check-input:checked{
        background-color: #577226;
     }  
     .dark-layout .select2-container .select2-selection--multiple .select2-selection__choice {
      
        color: #ffff !important;
       
    } 
     .ql-editor {
         min-height: 200px;
     }
     .btn.btn-submit {
         background: #577226;
         color: #fff;
     }
     .mb-1.product_status {
         width: 20%;
         position: relative;
         top: 54px;
         left: 750px;
     }

     div#preview {
         display: flex;
         flex-wrap: wrap;
     }

     .img-container {
         width: 33%;
         margin: auto;
         display: table;
         margin-top: 30px;
     }

     button.remove-btn {
         margin: auto;
         color: #fff;
         background: #cd4535;
         border: none;
         padding: 10px;
         border-radius: 4px;
         /* border-bottom: 4px solid #b02818; */
         transition: all .2s ease;
         outline: none;
         text-transform: uppercase;
         font-weight: 700;
         display: table;
         margin-top: 26px;
     }

     .img-preview {
         margin: auto;
         display: table;
     }

     .img-preview img {
         width: 150px;
         height: 150px;
         object-fit: cover;
     }

     .dark-layout .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-box {
         color: #babfc7 !important;
     }
     .bs-stepper .bs-stepper-header .step.crossed .step-trigger .bs-stepper-box {
         color: #084025 !important;
     }

     .dark-layout .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-box {
         background-color: #084025;
     }
     .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-box {
         background-color: #084025;
     }
     .dark-layout .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-label .bs-stepper-title {
         color: #b4b7bd;
     }
     .bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-label .bs-stepper-title{
         color: #6e6b7b;

     }

     button#addImageButton, button#addSTLButton {
         width: 100%;
         margin: 0;
         color: #fff;
         background: #084025;
         border: none;
         padding: 10px;
         border-radius: 4px;
         transition: all .2s ease;
         outline: none;
         text-transform: uppercase;
         font-weight: 700;
     }

     p.multipile_desc {
         margin-top: 20px;
         border: 4px dashed #577226;
         position: relative;
         font-weight: 100;
         text-transform: uppercase;
         color: #15824B;
         padding: 66px 0;
         font-size: 1.5rem;
         text-align: center;
     }

     input#fileInput, input#stlfileInput {
         display: none;
     }

     .card {
         box-shadow: unset !important;
     }

     .file-upload, .multiple  {
     /*             background-color: #ffffff; */
         width: 100%;
         margin: 0 auto;
         padding: 20px 0px 20px 0px;
     }

     .file-upload-btn {
         width: 100%;
         margin: 0;
         color: #fff;
         background: #084025;
         border: none;
         padding: 10px;
         border-radius: 4px;
         /* border-bottom: 4px solid #15824B; */
         transition: all .2s ease;
         outline: none;
         text-transform: uppercase;
         font-weight: 700;
     }

     .file-upload-btn:hover {
         /* background: #1AA059; */
         color: #ffffff;
         transition: all .2s ease;
         cursor: pointer;
     }

     .file-upload-btn:active {
         border: 0;
         transition: all .2s ease;
     }

     .file-upload-content {
         display: none;
         text-align: center;
     }

     .file-upload-input {
         position: absolute;
         margin: 0;
         padding: 0;
         width: 100%;
         height: 100%;
         outline: none;
         opacity: 0;
         cursor: pointer;
     }

     .image-upload-wrap {
         margin-top: 20px;
         border: 4px dashed #577226;
         position: relative;
     }

     /* .image-dropping,
         .image-upload-wrap:hover {
         background-color: #577226;
         border: 4px dashed #ffffff;
         } */

     .image-title-wrap {
         padding: 0 15px 15px 15px;
         color: #222;
     }

     .drag-text {
         text-align: center;
     }

     .drag-text h3 {
         font-weight: 100;
         text-transform: uppercase;
         color: #15824B;
         padding: 60px 0;
     }

     .file-upload-image {
         max-height: 200px;
         max-width: 200px;
         margin: auto;
         padding: 20px;
     }

     .remove-image {
         width: 120px;
         margin: 0;
         color: #fff;
         background: #cd4535;
         border: none;
         padding: 10px;
         border-radius: 4px;
         border-bottom: 4px solid #b02818;
         transition: all .2s ease;
         outline: none;
         text-transform: uppercase;
         font-weight: 700;
     }

     .remove-image:hover {
         background: #c13b2a;
         color: #ffffff;
         transition: all .2s ease;
         cursor: pointer;
     }

     .remove-image:active {
         border: 0;
         transition: all .2s ease;
     }
</style>

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">


    <!-- BEGIN: Main Menu-->
    <?php include "includes/manu.php"; ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <section class="modern-vertical-wizard">
                    <div class="bs-stepper vertical wizard-modern modern-vertical-wizard-example">

                        <div class="bs-stepper-header">
                            <!-- Select status -->

                            <div class="step" data-target="#account-details-vertical-modern" role="tab" id="account-details-vertical-modern-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='settings'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">General</span>
                                        <span class="bs-stepper-subtitle">Product Details</span>
                                    </span>
                                </button>
                            </div>

                            <div class="step" data-target="#inventory-details-vertical-modern" role="tab" id="inventory-details-vertical-modern-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='settings'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Inventory</span>
                                        <span class="bs-stepper-subtitle">Inventory Management</span>
                                    </span>
                                </button>
                            </div>

                            <!-- <div class="step" data-target="#availability-details-vertical-modern" role="tab" id="availability-details-vertical-modern-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='settings'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Availability</span>
                                        <span class="bs-stepper-subtitle">Set Product Availability</span>
                                    </span>
                                </button>
                            </div> -->

                            <div class="step" data-target="#personal-info-vertical-modern" role="tab" id="personal-info-vertical-modern-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='box'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Attributes</span>
                                        <span class="bs-stepper-subtitle">Add Attributes Info</span>
                                    </span>
                                </button>
                            </div>

                            <div class="step" data-target="#address-step-vertical-modern" role="tab" id="address-step-vertical-modern-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='more-vertical'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Categories & Tags</span>
                                        <span class="bs-stepper-subtitle">Add Details</span>
                                    </span>
                                </button>
                            </div>

                            <div class="step" data-target="#social-links-vertical-modern" role="tab" id="social-links-vertical-modern-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='align-center'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Description</span>
                                        <span class="bs-stepper-subtitle">Add Description</span>
                                    </span>
                                </button>
                            </div>

                            <div class="step" data-target="#images-links-vertical-modern" role="tab" id="images-links-vertical-modern-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='align-center'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Images</span>
                                        <span class="bs-stepper-subtitle">Add images</span>
                                    </span>
                                </button>
                            </div>


                        </div>
                        
                        <div class="bs-stepper-content">
                            <form id="submitProduct"  enctype="multipart/form-data">

                                <div id="account-details-vertical-modern" class="content" role="tabpanel" aria-labelledby="account-details-vertical-modern-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Product Details</h5>
                                    </div>
                                    <!-- <form class="product_detail"> -->
                                        <div class="row">
                                            <div class="mb-1 col-md-12">
                                                <label class="form-label" for="product_title">Product Title *</label>
                                                <input type="text" name="product_title" value="<?=   $_product->name  ?>" id="product_title" class="form-control" placeholder="Product Title" />
                                            </div>
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="regular_price">Regular price ($) *</label>
                                                <input type="number" name="regular_price" value="<?= $_product->regular_price ?>" id="regular_price" class="form-control" placeholder="Regular price" />
                                                <?php $subscription_data = get_option('subscription_data', true); ?>
                                                <span id="subscription_tooltip"> <?= !empty($subscription_data['tooltip']) ? $subscription_data['tooltip']  : '' ?></span>
                                            
                                            </div>
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="sale_price">Sale price ($)</label>
                                                <input type="number" name="sale_price" value="<?=  $_product->sale_price  ?>" id="sale_price" class="form-control" placeholder="Sale price" aria-label="Sale price" />
                                            </div>
                                            <!-- Country -->
                                            <div class="mb-1 col-md-3">
                                                <label class="form-label" for="country">Country</label>
                                                <?php
                                                    // Array of all countries
                                                    $countries = [
                                                        'United States',
                                                        'Canada',
                                                        'United Kingdom',
                                                        'Australia',
                                                        'India',
                                                        'Germany',
                                                        'France',
                                                        'Italy',
                                                        'Spain',
                                                        'China',
                                                        'Japan',
                                                        'South Korea',
                                                        'Brazil',
                                                        'Mexico',
                                                        'Russia',
                                                        'South Africa',
                                                        'New Zealand',
                                                        'Saudi Arabia',
                                                        'United Arab Emirates',
                                                        'Singapore'
                                                    ];
                                                ?>
                                                <select name="country" class="form-select" id="country">
                                                    <?php foreach ($countries as $country): ?>
                                                        <option value="<?= esc_attr($country); ?>" <?= isset($metadata['country'][0]) && $metadata['country'][0] == $country ? 'selected' : ''; ?>>
                                                            <?= esc_html($country); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Country -->
                                            <div class="mb-1 col-md-3">
                                                <label class="form-label" for="state">State</label>
                                                <?php
                                                    // Array of all states
                                                    // $states = [
                                                    //     'Alabama',
                                                    //     'Alaska',
                                                    //     'Arizona',
                                                    //     'Arkansas',
                                                    //     'California',
                                                    //     'Colorado',
                                                    //     'Connecticut',
                                                    //     'Delaware',
                                                    //     'District Of Columbia',
                                                    //     'Florida',
                                                    //     'Georgia',
                                                    //     'Hawaii',
                                                    //     'Idaho',
                                                    //     'Illinois',
                                                    //     'Indiana',
                                                    //     'Iowa',
                                                    //     'Kansas',
                                                    //     'Kentucky',
                                                    //     'Louisiana',
                                                    //     'Maine',
                                                    //     'Maryland',
                                                    //     'Massachusetts',
                                                    //     'Michigan',
                                                    //     'Minnesota',
                                                    //     'Mississippi',
                                                    //     'Missouri',
                                                    //     'Montana',
                                                    //     'Nebraska',
                                                    //     'Nevada',
                                                    //     'New Hampshire',
                                                    //     'New Jersey',
                                                    //     'New Mexico',
                                                    //     'New York',
                                                    //     'North Carolina',
                                                    //     'North Dakota',
                                                    //     'Ohio',
                                                    //     'Oklahoma',
                                                    //     'Oregon',
                                                    //     'Pennsylvania',
                                                    //     'Rhode Island',
                                                    //     'South Carolina',
                                                    //     'South Dakota',
                                                    //     'Tennessee',
                                                    //     'Texas',
                                                    //     'Utah',
                                                    //     'Vermont',
                                                    //     'Virginia',
                                                    //     'Washington',
                                                    //     'West Virginia',
                                                    //     'Wisconsin',
                                                    //     'Wyoming'
                                                    // ];
                                                ?>
                                                <input type="text" name="state" value="<?=  $metadata['state'][0]  ?>" id="state" class="form-control" placeholder="State" aria-label="State" />

                                                <!-- <select name="state" class="form-select" id="state">
                                                    <?php foreach ($states as $code => $name): ?>
                                                        <option value="<?= esc_attr($name); ?>" <?= $metadata['state'][0] == $name ? 'selected' : ''; ?>>
                                                            <?= esc_html($name); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>                                          -->
                                            </div>
                                            <div class="mb-1 col-md-3">
                                                <label class="form-label" for="sale_price">City</label>
                                                <input type="text" name="city" value="<?=  $metadata['city'][0]  ?>" id="city" class="form-control" placeholder="City" aria-label="City" />
                                            </div>
                                            <div class="mb-1 col-md-3">
                                                <label class="form-label" for="zip_code">Zip code</label>
                                                <input type="number" name="zip_code" value="<?=  $metadata['zip_code'][0]  ?>" id="zip_code" class="form-control" placeholder="Zip Code" aria-label="Zip Code" />
                                            </div>
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
                                                    $get_users = $users_arg->get_results();
                                                } ?>
                                                <div class="mb-1 col-md-6 user">
                                                    <label class="form-label" for="select_user_type">Select User Type</label>
                                                    <select name="user_type" class="form-select" id="select_user_type">
                                                        <option disabled hidden <?= empty($selected_user_type) ? 'selected' : '' ?>>Select User Type</option>
                                                        <option value="vendor" <?= $selected_user_type == 'vendor' ? 'selected' : '' ?>>Vendor</option>
                                                    </select>
                                                </div>
                                                <div class="mb-1 col-md-6 user">
                                                    <label class="form-label" for="select_user">Select User</label>
                                                    <select name="user_id" class="form-select" id="select_user">
                                                        <option disabled hidden <?= empty($selected_user_id) ? 'selected' : '' ?>>Select User</option>

                                                        <?php foreach ($get_users as $user) { ?>
                                                            <option value="<?= esc_attr($user->ID) ?>" <?= $selected_user_id == $user->ID ? 'selected' : '' ?>>
                                                                <?= esc_html($user->display_name) ?>
                                                            </option>
                                                        <?php } ?>                                                    
                                                    </select>
                                                
                                                </div>
                                            <?php } ?>
                                             
                                            <div class="mb-1 col-md-12">
                                                <div class="card">
                                                    <div class="card-body1">
                                                        <label class="form-label" for="customer_says">What customer says about this product?</label>
                                                        <textarea class="form-control" id="customer_says" value="<?=  $metadata['customer_says'][0] ?>" name="customer_says" rows="6" ><?= $metadata['customer_says'][0]  ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                         

                                        </div>
                                      
                                    <!-- </form> -->
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-outline-secondary btn-prev" type="button" disabled  style="opacity: 0;">
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next" type="button">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    </div>
                                </div>

                                <div id="inventory-details-vertical-modern" class="content" role="tabpanel" aria-labelledby="inventory-details-vertical-modern-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Inventory Details</h5>
                                        <!-- <small class="text-muted">Enter Your Inventory Details.</small> -->
                                    </div>
                                    <!-- <form class="product_detail"> -->
                                        <!-- <div class="row">
                                            <div class="mb-1 col-md-12">
                                                <label class="form-label" for="sku">SKU</label>
                                                <input type="text" name="sku" value="<?=  $_product->sku ?>" id="sku" class="form-control" placeholder="5487FB8/24-1" />
                                            </div>
                                        </div> -->
                                        
                                        <div class="row">
                                          
                                            <div class="mb-1 col-md-12">
                                                <input class="form-check-input" type="checkbox" name="stock_management" id="stock_management" value="checked" <?=  $_product->manage_stock == "yes"  ? 'checked' : '' ?> >
                                                <label class="form-check-label" for="stock_management">Stock Management</label>
                                            </div>

                                            <div class="mb-1 col-md-12 stock_quantity_div" <?=  $_product->manage_stock == "no" ? 'style="display:none"' : 'style="display:block"' ?> >
                                                <label class="form-label" for="total_quantity"> Total Quantity</label>
                                                <input type="number" name="total_quantity" value="<?=  $_product->stock_quantity ?>" id="total_quantity" class="form-control" placeholder="0" />
                                            </div>

                                            <div class="mb-1 col-md-12 backorders_div"  <?=  $_product->manage_stock == 'no' ? 'style="display:none"' : 'style="display:block"' ?> >
                                                <h5 class="mb-0">Allow backorders?</h5><br>
                                                <input type="radio" name="_backorders" value="no"  id="dna" class="form-check-input" checked <?= $_product->backorders == 'no' ? 'checked' : '' ?> />
                                                <label class="form-check-label" for="dna"> Do not allow</label><br><br>

                                                <input type="radio" name="_backorders" value="notify" id="abnc" class="form-check-input" <?= $_product->backorders == 'notify' ? 'checked' : '' ?>/>
                                                <label class="form-check-label" for="abnc"> Allow, but notify customer</label><br><br>

                                                <input type="radio" name="_backorders" value="yes" id="allow" class="form-check-input" <?= $_product->backorders == 'yes' ? 'checked' : '' ?>/>
                                                <label class="form-check-label" for="allow"> Allow</label><br><br>
                                            </div>

                                            
                                            <div class="mb-1 col-md-12 stock_status_div" <?= $_product->manage_stock == "yes" ? 'style="display:none"' : 'style="display:block"' ?>>
                                                <h5 class="mb-0">Stock status</h5><br>
                                                <div class="mb-1 col-md-12">
                                                    <input class="form-check-input" type="radio" name="stock_status" id="made_to_order" value="made_to_order" <?= $metadata['made_to_order'][0] == "made_to_order" ? 'checked' : '' ?> >
                                                    <label class="form-check-label" for="made_to_order">Made to order</label>
                                                </div>
                                                <input type="radio" name="stock_status" value="instock"  id="in_stock" class="form-check-input" <?= $metadata['made_to_order'][0] == "instock"  ? 'checked' : '' ?> />
                                                <label class="form-check-label" for="in_stock">  In stock</label><br><br>

                                                <input type="radio" name="stock_status" value="outofstock" id="out_of_stock" class="form-check-input" <?= $metadata['made_to_order'][0] == "outofstock"  ? 'checked' : '' ?> />
                                                <label class="form-check-label" for="out_of_stock"> Out of stock</label><br><br>

                                                <input type="radio" name="stock_status" value="onbackorder" id="on_backorder" class="form-check-input" <?= $metadata['made_to_order'][0] == "onbackorder"  ? 'checked' : '' ?> />
                                                <label class="form-check-label" for="on_backorder"> On backorder</label><br><br>

                                            </div>
                                         
                                        </div>
                                    <!-- </form> -->
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary btn-prev waves-effect waves-float waves-light" type="button" >
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next" type="button">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    </div>
                                </div>

                             

                                <div id="personal-info-vertical-modern" class="content" role="tabpanel" aria-labelledby="personal-info-vertical-modern-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Attributes Info</h5>
                                    </div>
                                    <div class="row">
                                        <div class="content-body">
                                            <section class="form-control-repeater">
                                                <div class="row">
                                                    <!-- Invoice repeater -->
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-title">New Attributes</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <!-- <form action="#" class="invoice-repeater"> -->
                                                                    <div data-repeater-list="invoice">
                                                                        <div data-repeater-item>

                                                                            <!-- Existing attributes -->
                                                                            <?php foreach ($attributes as $attribute){ ?>
                                                                                <div class="row d-flex align-items-center">
                                                                                    <div class="col-md-2 col-12">
                                                                                        <div class="mb-1">
                                                                                            <label class="form-label" for="attr_name">Name:</label>
                                                                                            <input type="text" class="form-control" name="attr_name[]" value="<?php echo esc_attr($attribute->get_name()); ?>" id="attr_name" aria-describedby="itemname" placeholder="f.e. size or color" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-8 col-12">
                                                                                        <label class="form-label" for="attr_val">Value(s):</label>
                                                                                        <div class="mb-1">
                                                                                            <textarea name="attr_val[]" id="attr_val" rows="4" cols="50" placeholder="Enter options for customers to choose from, f.e. “Blue” or “Large”. Use “|” to separate different options.">
                                                                                                <?php echo implode('|', $attribute->get_options()); ?>
                                                                                            </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 col-12 mb-50">
                                                                                        <div class="mb-1">
                                                                                            <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                                                <i data-feather="x" class="me-25"></i>
                                                                                                <span>Delete</span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            <?php } ?>

                                                                            <div class="container-for-clones">
                                                                                <!-- Default Attributes -->
                                                                                 <?php if(!isset($_GET['id'])) { ?>
                                                                                <div class="row d-flex align-items-center clone-attr-div" style="display: flex;">
                                                                                    <div class="col-md-2 col-12">
                                                                                        <div class="mb-1">
                                                                                            <label class="form-label" for="attr_name">Name:</label>
                                                                                            <input type="text" class="form-control" name="attr_name[]" value="Color" id="attr_name" aria-describedby="itemname" placeholder="f.e. size or color">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-8 col-12">
                                                                                        <label class="form-label" for="attr_val">Value(s):</label>
                                                                                        <div class="mb-1">
                                                                                            <textarea name="attr_val[]" id="attr_val" rows="4" cols="50" value="Red|Blue" placeholder="Enter options for customers to choose from, f.e. “Blue” or “Large”. Use “|” to separate different options.">Red|Blue</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 col-12 mb-50">
                                                                                        <div class="mb-1">
                                                                                            <button class="btn btn-outline-danger text-nowrap px-1 waves-effect" data-repeater-delete="" type="button">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-25"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                                <span>Delete</span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row d-flex align-items-center clone-attr-div" style="display: flex;">
                                                                                    <div class="col-md-2 col-12">
                                                                                        <div class="mb-1">
                                                                                            <label class="form-label" for="attr_name">Name:</label>
                                                                                            <input type="text" class="form-control" name="attr_name[]" value="Size" id="attr_name" aria-describedby="itemname" placeholder="f.e. size or color">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-8 col-12">
                                                                                        <label class="form-label" for="attr_val">Value(s):</label>
                                                                                        <div class="mb-1">
                                                                                            <textarea name="attr_val[]" id="attr_val" rows="4" cols="50" value="Large|Small" placeholder="Enter options for customers to choose from, f.e. “Blue” or “Large”. Use “|” to separate different options.">Large|Small</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 col-12 mb-50">
                                                                                        <div class="mb-1">
                                                                                            <button class="btn btn-outline-danger text-nowrap px-1 waves-effect" data-repeater-delete="" type="button">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-25"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                                <span>Delete</span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row d-flex align-items-center clone-attr-div" style="display: flex;">
                                                                                    <div class="col-md-2 col-12">
                                                                                        <div class="mb-1">
                                                                                            <label class="form-label" for="attr_name">Name:</label>
                                                                                            <input type="text" class="form-control" name="attr_name[]" value="Materials" id="attr_name" aria-describedby="itemname" placeholder="f.e. size or color">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-8 col-12">
                                                                                        <label class="form-label" for="attr_val">Value(s):</label>
                                                                                        <div class="mb-1">
                                                                                            <textarea name="attr_val[]" id="attr_val" rows="4" cols="50" value="PLA|PETG|ABS|ASA|PC|TPU|Nylon" placeholder="Enter options for customers to choose from, f.e. “Blue” or “Large”. Use “|” to separate different options.">PLA|PETG|ABS|ASA|PC|TPU|Nylon</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 col-12 mb-50">
                                                                                        <div class="mb-1">
                                                                                            <button class="btn btn-outline-danger text-nowrap px-1 waves-effect" data-repeater-delete="" type="button">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-25"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                                <span>Delete</span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php } ?>
                                                                                <!-- Default Attributes -->
                                                                            </div>

                                                                            <hr />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                                                                <i data-feather="plus" class="me-25"></i>
                                                                                <span>Add New</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                <!-- </form> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /Invoice repeater -->
                                                </div>

                                            </section>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary btn-prev" type="button">
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next" type="button">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    </div>
                                </div>

                                <div id="address-step-vertical-modern" class="content" role="tabpanel" aria-labelledby="address-step-vertical-modern-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Add Tags and Categories</h5>
                                    </div>    
                                    <!-- multi file upload ends -->
                                    <div class="row">
                                        <!-- <form class="catg_tag"> -->
                                            <!-- Multiple -->
                                            <div class="col-md-6 mb-1">
                                                

                                                <label class="form-label" for="categories">Categories</label>
                                                <select data-placeholder="Select a category..." class="select2-icons form-select" id="categories"  name="categories[]" multiple>
                                                    
                                                    <?php

                                                        foreach ($categories as $category) {
                                                            // Display only top-level categories (parents)
                                                            if ($category->slug == $_GET['type']) {
                                                                // Get child categories of the current category
                                                                $child_categories = array_filter($categories, function($cat) use ($category) {
                                                                    return $cat->parent == $category->term_id;
                                                                }); ?>

                                                                <?php if (!empty($child_categories)) { ?>
                                                                    <?php foreach ($child_categories as $child_cat) { 
                                                                        // Check for sub-child categories
                                                                        $sub_child_categories = array_filter($categories, function($sub_cat) use ($child_cat) {
                                                                            return $sub_cat->parent == $child_cat->term_id;
                                                                        });

                                                                        // Display the child category
                                                                        ?>
                                                                        <optgroup label="<?= esc_html($child_cat->name); ?>">
                                                                            <?php if (!empty($sub_child_categories)) { ?>
                                                                                <?php foreach ($sub_child_categories as $sub_child_cat) { ?>
                                                                                    <option value="<?=  esc_attr( $sub_child_cat->term_id ) ?>" <?= !empty($product_categories) && in_array($sub_child_cat->term_id, $product_categories) ? 'selected' : '' ?>><?= esc_attr( $sub_child_cat->name ) ?></option>

                                                                                <?php } 
                                                                            } ?>
                                                                        </optgroup>
                                                                    <?php } 
                                                                } 
                                                            }
                                                        }
                                                    ?>
                                                    
                                                </select>
                                            </div>
                                           
                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="tags">Tags</label>
                                                <select class="select2 form-select"  id="tags" name="tags[]" multiple>
                                                    <optgroup label="Select Tags">
                                                        <?php foreach ($tags as $tag) {  ?>
                                                            <option value="<?=  esc_attr( $tag->term_id ) ?>" <?= !empty($product_tags) && in_array($tag->term_id, $product_tags) ? 'selected' : '' ?>><?= esc_attr( $tag->name ) ?></option>
                                                        <?php } ?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        <!-- </form> -->
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary btn-prev" type="button">
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next" type="button">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    </div>
                                </div>

                                <div id="social-links-vertical-modern" class="content" role="tabpanel" aria-labelledby="social-links-vertical-modern-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Description</h5>
                                        <!-- <small>Enter Your Description.</small> -->
                                    </div>
                                    <!-- Snow Editor start -->
                                    <section class="snow-editor">
                                        <div class="row">
                                            <!-- <form class="prod_desc"> -->
                                                <!-- <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body1">
                                                            <label class="form-label" for="short_desc">Short Description:</label>
                                                            <textarea class="form-control" id="short_desc" value="<?=  $_product->short_description ?>" name="short_desc" rows="6" ><?= $_product->short_description ?></textarea>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <label class="form-label" for="short_desc">Short Description:</label>                                                        </div>
                                                        <div class="card-body1">
                                                            <div class="shorteditor">
                                                                <p class="card-text"></p>
                                                                <?= $_product->short_description ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <label class="form-label" for="short_desc">Long Description:</label>                                                        </div>
                                                        <div class="card-body1">
                                                            <div class="editor">
                                                                <p class="card-text"></p>
                                                                <?= $_product->description ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- </form> -->
                                        </div>
                                    </section>
                                    <!-- Snow Editor end -->
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary btn-prev" type="button">
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next" type="button">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    </div>
                                </div>

                                <div id="images-links-vertical-modern" class="content" role="tabpanel" aria-labelledby="images-links-vertical-modern-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Images</h5>
                                    </div>
                                    <!-- Snow Editor start -->
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- <form class="prod_img"> -->
                                                <div class="card">
                                                    <h2>Featured Image</h2>
                                                    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                                                    <div class="file-upload">
                                                        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Set Featured Image</button>
                                                        <div class="image-upload-wrap" <?= isset($_GET['id']) && wp_get_attachment_url($_product->image_id)  ? 'style="display:none"' : ''  ?>>
                                                            <input class="file-upload-input" id="featured_image" name="featured_image" type="file" accept="image/*"  />
                                                            <div class="drag-text">
                                                                <h3>Drag and drop a file or select add Image</h3>
                                                            </div>
                                                        </div>
                                                        <div class="file-upload-content" <?= isset($_GET['id']) && wp_get_attachment_url($_product->image_id) ? 'style="display:block"' : 'style="display:none"'  ?>>
                                                            <img class="file-upload-image" src="<?= isset($_GET['id']) && wp_get_attachment_url($_product->image_id) ? wp_get_attachment_url($_product->image_id) : '#'  ?>" alt="your image" />
                                                            <div class="image-title-wrap">
                                                                <button type="button" onclick="removeUpload()" class="remove-image">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- </form> -->
                                        </div>
                                        <!-- single file upload ends -->
                                        <!-- multi file upload starts -->
                                        <div class="col-6">
                                            <h2>Product Gallery</h2>
                                            <div class="card multiple">
                                                <button type="button" id="addImageButton">Add Product Gallery</button>
                                                <div class="drag-drop-box" style="<?= !empty($_product->gallery_image_ids) ? 'display:none' : 'display:block' ?>">
                                                    <input type="file" id="fileInput" name="product_gallery[]" accept="image/*" multiple>
                                                    <p class="multipile_desc">Click Product Gallery Button Add Image</p>
                                                </div>
                                               
                                                    <div id="preview">
                                                        <?php foreach ($_product->gallery_image_ids as $key => $value) { ?>
                                                            <div class="img-container">
                                                                <div class="img-preview">
                                                                    <img src="<?= wp_get_attachment_url($value) ?>">
                                                                </div>
                                                                <button class="remove-btn">Remove</button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- multi file upload ends -->
                                    <?php if($_GET['type'] == 'stl-library') { ?>
                                        <div class="col-12">
                                            <!-- <h2>STL Files</h2> -->
                                            <div class="card multiple">
                                                <button type="button" id="addSTLButton">Add STL Files</button>
                                                <div class="stl-drag-drop-box" style="<?= !empty($stl_files) ? 'display:none' : 'display:block' ?>">
                                                    <input type="file" id="stlfileInput" name="stl_gallery[]" multiple>
                                                    <p class="multipile_desc">Click to Add STL Files</p>
                                                </div>
                                            
                                                    <div id="stlpreview">
                                                        <?php if(!empty($stl_files)) { foreach ($stl_files as $key => $value) { ?>
                                                            <div class="img-container">
                                                                <div class="img-preview">
                                                                    <img src="<?= wp_get_attachment_url($value) ?>">
                                                                </div>
                                                                <button class="remove-btn">Remove</button>
                                                            </div>
                                                        <?php } } ?>
                                                    </div>
                                            </div>
                                        </div>


                                    <?php } ?>
                                
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary btn-prev" type="button">
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <?php //if($_GET['type'] != 'stl-library') { ?>
                                        <button class="btn btn-primary prdouct_submit" type="submit"><?= isset($_GET['id']) ? 'Update' : 'Submit'  ?></button>
                                        <?php //} else { ?>
                                        <!-- <button class="btn btn-primary btn-next" type="button">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button> -->
                                        <?php //} ?>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="product_id" value="<?= isset($_GET['id']) && !isset($_GET['profile']) ? $_GET['id'] : '' ?>">
                                <input type="hidden" name="product_type" value="<?= isset($_GET['type']) ? $_GET['type'] : '' ?>">
                                <input type="hidden" name="action" value="add_update_product">
                            </form>

                            <!-- new attribute div -->
                            <div class="row d-flex align-items-center clone-attr-div" style="display:none !important">
                                <div class="col-md-2 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="attr_name">Name:</label>
                                        <input type="text" class="form-control" name="attr_name[]" value="" id="attr_name" aria-describedby="itemname" placeholder="f.e. size or color" />
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <label class="form-label" for="attr_val">Value(s):</label>
                                    <div class="mb-1">
                                        <textarea name="attr_val[]" id="attr_val" rows="4" cols="50" placeholder="Enter options for customers to choose from, f.e. “Blue” or “Large”. Use “|” to separate different options.">
                                            
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12 mb-50">
                                    <div class="mb-1">
                                        <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                            <i data-feather="x" class="me-25"></i>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- end -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <?php
    if(!isset($_GET['profile']) && !isset($_GET['id'])){
        var_dump('ss');
    // Fetch WooCommerce products
    $args = [

        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status'=> 'publish',
        'meta_query'     => [
            [
                'key'      => 'product_type',
                'value'      => $_GET['type'] ?? 'creations',
                'compare'  => '=',
            ]
        ],
    ];

   if(in_array('vendor', wp_get_current_user()->roles)){
        $args['author'] =  get_current_user_id();
    }
    $products = new WP_Query($args);
    ?>

    <!-- product profiles modal -->
    <div class="modal fade show" id="shareProject" style="display: block;" tabindex="-1" aria-labelledby="shareProjectTitle" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-4">
                    <h1 class="text-center mb-1" id="shareProjectTitle">Product Profiles</h1>
                    <p class="text-center">Select product to copy the data</p>

                    <!-- <label class="form-label fw-bolder font-size font-small-4 mb-50" for="addMemberSelect">Find Products</label>
                    <select class="select2 form-select" id="addMemberSelect">
                        <option value="" label="Select a product"></option>
                        <?php if ($products->have_posts()) : ?>
                            <?php while ($products->have_posts()) : $products->the_post(); ?>
                                <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select> -->

                    <!-- <p class="fw-bolder pt-50 mt-2">Products</p> -->

                    <!-- product's list -->
                    <ul class="list-group list-group-flush mb-2">
                        <?php if ($products->have_posts()) : ?>
                            <?php while ($products->have_posts()) : $products->the_post(); $product = wc_get_product( get_the_ID() ); ?>
                                <li class="list-group-item d-flex align-items-start border-0 px-0">
                                    <div class="avatar me-75">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('thumbnail', ['width' => 50, 'height' => 50, 'alt' => get_the_title()]); ?>
                                        <?php else : ?>
                                            <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" alt="Placeholder" width="50" height="50" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <div class="me-1">
                                            <h5 class="mb-25"><?php the_title(); ?></h5>
                                            <span><?php echo get_post_meta(get_the_ID(), '_price', true); ?> <?php echo get_woocommerce_currency_symbol(); ?></span>
                                        </div>
                                        <div class="dropdown">
                                            <a href="<?= home_url('add-product?id='.get_the_ID().'&type='.$_GET['type'].'&profile=true') ?>" class="btn btn-flat-secondary copy-product">
                                                <span class="d-none d-lg-inline-block">Use this profile</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <li class="list-group-item d-flex align-items-start border-0 px-0">
                                <p class="text-center">No products found.</p>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <!--/ product's list -->
                </div>
            </div>
        </div>
    </div>
    <!-- / product profiles modal -->

    <?php wp_reset_postdata(); ?>
    <?php } ?>


    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


    <?php include "includes/scripts.php"; ?>

   

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/katex.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/highlight.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/editors/quill/image-resize.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <!-- END: Page Vendor JS-->

    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <!-- <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script> -->
    <!-- <script src="<?= $directory_url ?>/app-assets/js/core/app-menu.js"></script> -->
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/form-wizard.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/form-repeater.js"></script>
    <!-- <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/form-file-uploader.js"></script> -->
   

    <script>
        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
            $('input[name="featured_image"]').val('');

        }
      
        $(document).ready(function() {

            $(document).on('click', '.btn-close', function(){
                jQuery('#shareProject').hide();
            });

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

           
                    
            // Handle the form submission
            $("#submitProduct").submit(function(e) {
                e.preventDefault(); // Prevent the default form submission
                var is_edit = "<?= isset($_GET['id']) ? true : false ?>";
                console.log(is_edit);
                if(!is_edit){
                    const featuredImage = $('#featured_image')[0]; // Access the file input element
                    const galleryImages = $('#fileInput')[0]; // Access the file input element
                    // const stlImage = $('#stlfileInput')[0]; // Access the file input element

                    
                    if (featuredImage.files.length === 0) {
                        alert('Please select featured image before submitting.');
                        return false;
                    }
                    if (galleryImages.files.length === 0) {
                        alert('Please select at least one gallery image before submitting.');
                        return false;
                    }
                    // if (stlImage.files.length === 0) {
                    //     alert('Please select at least one stl file before submitting.');
                    //     return false;
                    // }

                    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    let isValid = true;

                    // Check the featured image file type
                    if (featuredImage.files.length > 0) {
                        const featuredFile = featuredImage.files[0];
                        if (!allowedTypes.includes(featuredFile.type)) {
                            alert("Invalid featured image file type. Please upload a JPG, PNG, or GIF image.");
                            isValid = false;
                        }
                    }

                    // Check each file in the gallery image input
                    if (galleryImages.files.length > 0) {
                        for (let i = 0; i < galleryImages.files.length; i++) {
                            const galleryFile = galleryImages.files[i];
                            if (!allowedTypes.includes(galleryFile.type)) {
                                alert("Invalid gallery image file type. Please upload a JPG, PNG, or GIF image.");
                                isValid = false;
                                break; // Stop the loop once an invalid file is found
                            }
                        }
                    }

                    if (!isValid) {
                        return false; // Prevent form submission if any file type is invalid
                    }
                } else {
                    if (jQuery('.drag-drop-box').css('display') != 'none') {
                        alert('Please select at least one gallery image before submitting.');
                        return false;
                    }
                    if (jQuery('.image-upload-wrap').css('display') != 'none') {
                        alert('Please select featured image before submitting.');
                        return false;
                    }
                    // if (jQuery('.stl-drag-drop-box').css('display') != 'none') {
                    //     alert('Please select at least one stl file before submitting.');
                    //     return false;
                    // }
                }


                var regular_price = jQuery('#regular_price').val();
                var sale_price = jQuery('#sale_price').val();
                if (parseFloat(sale_price) >= parseFloat(regular_price)) {
                    alert('Sale price should be less than regular price');
                    return false;
                }


                // Create a FormData object to combine all form data
                var form = new FormData(this);

                var long_desc = $('.editor .ql-editor').html();
                var short_desc = $('.shorteditor .ql-editor').html();
                form.append("short_desc", short_desc);
                form.append("long_desc", long_desc);

                //var post_status = $('#select_status').find(":selected").val();
                //form.append("post_status", post_status);

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

            $(document).on('change', '#select_user_type', function(e) {
                var user_type = jQuery(this).val();
                var thiss = jQuery(this);
                jQuery('body').waitMe({
                    effect: 'pulse',
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
                    data: {
                        action: 'get_users_by_type',
                        user_type: user_type,
                    },
                    dataType: 'json',
                    success: function (response) {
                        jQuery('body').waitMe('hide');
                        jQuery('#select_user').html(response.usersHtml); 
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                        jQuery('body').waitMe('hide');
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

            var quill = new Quill( '.shorteditor', {
                modules: {
                    imageResize: {
                        displaySize: true
                    }, // default false
                    toolbar: toolbarOptions,
                },
                theme: 'snow'
            });

            $(document).on('change', '.file-upload-input', function(e) {
                var reader = new FileReader();
                var input = $(this);
                // console.log("input", input[0].files[0]);
                // console.log("files", input[0].files[0].name);

                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                  //  $('.image-title').html(input[0].files[0].name);
                };
                reader.readAsDataURL(input[0].files[0]);

            });

            $('.image-upload-wrap').bind('dragover', function() {
                $('.image-upload-wrap').addClass('image-dropping');
            });

            $('.image-upload-wrap').bind('dragleave', function() {
                $('.image-upload-wrap').removeClass('image-dropping');
            });

        
            // $('#fileInput, #stlfileInput').change(function() {
            $(document).on('change', '#fileInput, #stlfileInput', function(e) {
                // alert(jQuery(e.target).is('#stlfileInput'));
                var files = $(this)[0].files;
                let trigger = jQuery(e.target).is('#stlfileInput') ? 'stlpreview' : 'preview';
                // alert('trigger', trigger);
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (file) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            var preview = '<div class="img-container"><div class="img-preview"><img src="' + event.target.result + '"></div><button type="button" class="remove-btn">Remove</button></div>';
                            $('#'+trigger).append(preview);
                        }

                        reader.readAsDataURL(file);
                    }
                }
                if (jQuery(e.target).is('#stlfileInput')) {
                    $('.stl-drag-drop-box').hide();
                } else {
                    $('.drag-drop-box').hide();
                }

            });

        

            $('#preview').on('click', '.remove-btn', function() {
                $(this).parent('.img-container').remove();
                $('#fileInput').val(''); // Reset the file input if necessary
                if ($('#preview').html().trim() === '') {
                    $('.drag-drop-box').show();
                }
            });

            $('#stlpreview').on('click', '.remove-btn', function() {
                $(this).parent('.img-container').remove();
                $('#stlfileInput').val(''); // Reset the file input if necessary
                if ($('#stlpreview').html().trim() === '') {
                    $('.stl-drag-drop-box').show();
                }
            });


            $('#addImageButton').click(function() {
                $('#fileInput').click();
            });

            $('#addSTLButton').click(function() {
                $('#stlfileInput').click();
            });

            // clone attributes
            jQuery(document).on('click', '[data-repeater-create]', function(e){
                var clone = jQuery('.clone-attr-div').first().clone();
                clone.find('input, textarea').val(''); // Clear input values
                clone.css('display', 'flex'); 
                jQuery('.container-for-clones').append(clone);
            });

            jQuery(document).on('click', '[data-repeater-delete]', function(e) {
                e.preventDefault();
                jQuery(this).closest('.align-items-center').remove();
            });

            // $('.stock_quantity_div').show();
            jQuery(document).on('change', '#stock_management', function(e){
                $('#total_quantity').val('');
                if ($(this).prop('checked')){
                    // alert('check');
                    $('.stock_quantity_div, .backorders_div').show();
                    $('.stock_status_div').hide();
                } else {
                    // alert('uncheck');
                    $('.stock_quantity_div, .backorders_div').hide();
                    $('.stock_status_div').show();
                }
            });

            jQuery('#categories').select2({
                placeholder: "Select category",
            });

            jQuery('#tags').select2({
                placeholder: "Select Tag"
            });

         
        });
    </script>

</body>

</html>
<?php } else { wp_redirect(home_url('dashboard/'));
} ?>