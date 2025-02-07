<?php /* Template Name: Farmer Subscription Packages */ ?>
<?php
  $basic_plan = get_option('basic_plan', true);
  $advanced_plan = get_option('advanced_plan', true);
  $premium_plan = get_option('premium_plan', true);
?>
<!DOCTYPE html>
<html lang="en">
<?php  include "includes/styles.php";  ?>
<!-- END: Head-->
<?php include "includes/header.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
    <style>
        .btn.btn-submit {
            background: #577226;
            color: #fff;
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
                            <div class="step" data-target="#basic-plan" role="tab" id="basic-plan-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='settings'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Basic</span>
                                        <span class="bs-stepper-subtitle">Add Basic Plan Details</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#advanced-plan" role="tab" id="advanced-plan-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='box'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Advanced</span>
                                        <span class="bs-stepper-subtitle">Add Advanced Plan Details</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#premium-plan" role="tab" id="premium-plan-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather='align-center'></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Premium</span>
                                        <span class="bs-stepper-subtitle">Add Premium Plan Details</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="bs-stepper-content">
                            <form id="create_subscription">
                               
                                <div id="basic-plan" class="content" role="tabpanel" aria-labelledby="basic-plan-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Basic Plan Details</h5>
                                        <small class="text-muted">Enter Your Basic Plan Details.</small>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="basic_plan_title">Plan Title *</label>
                                            <input type="text" name="basic_plan_title" value="<?=  $basic_plan['plan_title'] ?>" id="basic_plan_title" class="form-control" placeholder="Plan Title" />
                                        </div>
                                        <div class="mb-1 col-12">
                                            <label for="basic_short_desc">Add Description:</label>
                                            <textarea class="form-control" id="basic_short_desc" value="<?= $basic_plan['short_desc'] ?>" name="basic_short_desc" rows="4" cols="50"><?= 
                                           $basic_plan['short_desc'] ?></textarea>
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="basic_annual_price">Annual Price *</label>
                                            <input type="number" name="basic_annual_price" value="<?=  $basic_plan['annual_price'] ?>" id="basic_annual_price" class="form-control" placeholder="Annual Price" aria-label="Annual Price" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="basic_monthly_price">Monthly Price *</label>
                                            <input type="number" name="basic_monthly_price" value="<?=  $basic_plan['monthly_price'] ?>" id="basic_monthly_price" class="form-control" placeholder="Monthly Price" aria-label="Monthly Price" />
                                        </div>
                                    </div>
                                 
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-outline-secondary btn-prev" type="button" disabled >
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next" type="button">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    </div>
                                </div>

                                <div id="advanced-plan" class="content" role="tabpanel" aria-labelledby="advanced-plan-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Advanced Plan Details</h5>
                                        <small class="text-muted">Enter Your Advanced Plan Details.</small>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="advanced_plan_title">Plan Title *</label>
                                            <input type="text" name="advanced_plan_title" value="<?=  $advanced_plan['plan_title'] ?>" id="advanced_plan_title" class="form-control" placeholder="Plan Title" />
                                        </div>
                                        <div class="mb-1 col-12">
                                            <label for="advanced_short_desc">Add Description:</label>
                                            <textarea class="form-control" id="advanced_short_desc" value="<?=  $advanced_plan['short_desc'] ?>" name="advanced_short_desc" rows="4" cols="50"><?= 
                                            $basic_plan['short_desc'] ?></textarea>
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="advanced_annual_price">Annual Price *</label>
                                            <input type="number" name="advanced_annual_price" value="<?=  $advanced_plan['annual_price'] ?>" id="advanced_annual_price" class="form-control" placeholder="Annual Price" aria-label="Annual Price" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="advanced_monthly_price">Monthly Price *</label>
                                            <input type="number" name="advanced_monthly_price" value="<?=  $advanced_plan['monthly_price'] ?>" id="advanced_monthly_price" class="form-control" placeholder="Monthly Price" aria-label="Monthly Price" />
                                        </div>
                                    </div>
                                 
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-outline-secondary btn-prev" type="button" disabled >
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary btn-next" type="button">
                                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                                            <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    </div>
                                </div>
                              
                                <div id="premium-plan" class="content" role="tabpanel" aria-labelledby="premium-plan-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Premium Plan Details</h5>
                                        <small class="text-muted">Enter Your Premium Plan Details.</small>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1 col-md-12">
                                            <label class="form-label" for="premium_plan_title">Plan Title *</label>
                                            <input type="text" name="premium_plan_title" value="<?=  $premium_plan['plan_title'] ?>" id="premium_plan_title" class="form-control" placeholder="Plan Title" />
                                        </div>
                                        <div class="mb-1 col-12">
                                            <label for="premium_short_desc">Add Description:</label>
                                            <textarea class="form-control" id="premium_short_desc" value="<?=  $premium_plan['short_desc'] ?>" name="premium_short_desc" rows="4" cols="50"><?= 
                                            $advanced_plan['short_desc'] ?></textarea>
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="premium_annual_price">Annual Price *</label>
                                            <input type="number" name="premium_annual_price" value="<?= $premium_plan['annual_price'] ?>" id="premium_annual_price" class="form-control" placeholder="Annual Price" aria-label="Annual Price" />
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label class="form-label" for="premium_monthly_price">Monthly Price *</label>
                                            <input type="number" name="premium_monthly_price" value="<?= $premium_plan['monthly_price'] ?>" id="premium_monthly_price" class="form-control" placeholder="Monthly Price" aria-label="Monthly Price" />
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary btn-prev" type="button">
                                            <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <input type="hidden" name="usertype" value="farmer">
                                        <input type="hidden" name="action" value="manage_subcription">
                                        <button class="btn" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <?php include "includes/scripts.php"; ?>

    <script src="<?= $directory_url ?>/app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="<?= $directory_url ?>/app-assets/js/scripts/forms/form-wizard.js"></script>

    <script>

        $(document).ready(function(){
            // Handle the form submission
            jQuery("#create_subscription").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = new FormData(this);
                jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                jQuery(this).find('button[type=submit]').prop('disabled',true);
                var thiss = jQuery(this);
                jQuery('body').waitMe({
                    effect : 'bounce',
                    text : '',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                });

                jQuery.ajax({
                    type: 'post',
                    url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                    data: form,
                    dataType : 'json',
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType : 'json',
                    success: function (response) {
                        jQuery('.fa.fa-spinner.fa-spin').remove();
                        jQuery('body').waitMe('hide');
                        jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                        if(!response.status){
                            toastr.error(response.message, response.title);
                      
                        }
                        else{
                            toastr.success(response.message, response.title);
						} 
                    },
                    error : function(errorThrown){
                        console.log(errorThrown);
                        jQuery('body').waitMe('hide');
                    }
                });

            }); 

            var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],

                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],                         // text direction

                [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],

                ['clean'],                                         // remove formatting button
                ['link', 'image'],

            ];

        });                         
    </script>
    
</body>
</html>
