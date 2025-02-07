<?php /* Template Name: Register */ ?>
<?php if(is_user_logged_in()) { wp_redirect(home_url('main-dashboard/')); exit; } ?>
<?php get_header() ?>
<?php 
    $test_credentials = get_field( 'test_credentials' , 'option');
    $publishable_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_private_key' , 'option') : get_field( 'live_stripe_private_key' , 'option');

?>
<style>         
            
    /* Tooltip container */
    .acount_type .hd .tooltip {
        position: absolute;
        top: 0;
        right: 0px;
        left: unset;
    }

    /* Tooltip text */
    .tooltip .tooltiptext {
    visibility: hidden;
    width: 339px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
    
    /* Position the tooltip text - see examples below! */
    position: absolute;
        z-index: 1;
    }
    .acount_type .hd {
        position: relative;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    .tooltip:hover .tooltiptext {
    visibility: visible;
    }
    .switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
    margin-left: 10px;
    margin-right: 10px;
    }
    .toggle_plan_div {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
    }

    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 19px;
    width: 20px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
    div#card-element {
        padding: 20px;
        box-shadow: 0px 0px 5px 0px #80808087;
    }
    .sub {
        display: flex;
    }
    .sub label.radio {
        margin-bottom: 30px;
        width: 100%;
        height: 100%;
        padding: 20px;
    }

    .sub h4 {margin-bottom: 30px;}

    .sub p.price {
        margin-top: 10px;
    }

    .sub .radio.selected h4 {
        color: #fff;
    }

    .sub .radio.selected span {
        color: #fff;
    }
    * {
    margin: 0;
    padding: 0;
    }

    html {
        height: 100%;
    }

    /*Background color*/
    /* #grad1 {
        background-color: : #9C27B0;
        background-image: linear-gradient(120deg, #FF4081, #81D4FA);
    } */

    /*form styles*/
    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px;
    }

    #msform fieldset .form-card {
        background: white;
        border: 0 none;
        border-radius: 0px;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        padding: 20px 40px 30px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 20px 3%;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    /*Hide all except first fieldset*/
    #msform fieldset:not(:first-of-type) {
        display: none;
    }

    #msform fieldset .form-card {
        text-align: left;
        color: #9E9E9E;
    }

    #msform input, #msform textarea, #msform select {
        /* padding: 0px 8px 4px 8px;
        border: none; */
        border-bottom: 1px solid #ccc;
        /* border-radius: 0px; */
        margin-bottom: 7px;
        box-sizing: border-box;
        /* font-family: montserrat; */
        /* color: #2C3E50;
        font-size: 16px; */
        letter-spacing: 1px;
        width: 100%;
        height: 45px;
        background: transparent;
        border: 2px solid #2c4766;
        outline: none;
        border-radius: 40px;
        font-size: 1em;
        color: #000;
        padding: 0 20px;
        transition: .5s ease;
        margin-top: 2px;
    }

    #msform input:focus, #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid #764020;
        outline-width: 0;
    }

    /*Blue Buttons*/
    #msform .action-button {
        width: 280px;
        background: #967a31;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button:hover, #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #764020;
    }

    /*Previous Buttons*/
    #msform .action-button-previous {
        width: 280px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button-previous:hover, #msform .action-button-previous:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
    }

    /*Dropdown List Exp Date*/
    select.list-dt {
        border: none;
        outline: 0;
        border-bottom: 1px solid #ccc;
        padding: 2px 5px 3px 5px;
        margin: 2px;
    }

    select.list-dt:focus {
        border-bottom: 2px solid #764020;
    }

    /*The background card*/
    .card {
        z-index: 0;
        border: none;
        border-radius: 0.5rem;
        position: relative;
    }

    /*FieldSet headings*/
    .fs-title {
        font-size: 25px;
        color: #2C3E50;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left;
    }

    /*progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
        display: flex;
        justify-content: center;
    }

    #progressbar .active {
        color: #000000;
    }

    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        width: 25%;
        float: left;
        position: relative;
    }

    /*Icons in the ProgressBar*/
    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f023";
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f007";
    }

    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f09d";
    }

    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f00c";
    }

    /*ProgressBar before any progress*/
    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px;
    }

    /*ProgressBar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1;
    }

    /*Color number of the step and the connector before it*/
    #progressbar li.active:before, #progressbar li.active:after {
        background: #967a31;
    }

    /*Imaged Radio Buttons*/
	.radio-group {
    position: relative;
    margin-bottom: 25px;
    text-align: center;
	}
    div#grad1 {
    width: 80%;
    padding-top: 50px;
	}
    div#grad1 h2, div#grad1 p {
        text-align: center;
    }
     .radio p {
        padding-bottom: 0;
    }
     .radio.selected p {
        color: #fff;
    }

    .radio.selected i {
        color: #fff;
    }
    .radio-group input[type="radio" i] {
        display: none;
    }
    label.radio {
        margin-bottom: 30px;
    }

    .radio {
        display: inline-flex;
        width: 234px;
        height: 104px;
        border-radius: 0;
        background: #ffff;
        box-shadow: 0 1px 7px 2px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        cursor: pointer;
        margin: 8px 16px;
        text-align: center;
        align-items: center;
        justify-content: center;
    }
    .acount_type i {
        font-size: 25px;
    }

    .radio:hover {
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
    }

    .radio.selected {
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
        background: #967a31;
    }

    /*Fit image in bootstrap div*/
    .fit-image{
        width: 100%;
        object-fit: cover;
    }
	
	/* responsive */
	
	@media (max-width: 1600px) {
		
		.sub label.radio {
    padding: 20px 10px;
    }		
            .acount_type i {
        font-size: 20px;
    }
            .acount_type .hd .tooltip {
        top: 3px;
    }
            
    }
        /* ********** */
        
        @media (max-width: 1440px) {
            
            .sub h4 {
        margin-bottom: 10px;
    }
            
        }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- MultiStep Form -->
<div class="container" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Sign Up Your User Account</strong></h2>
                <p>Fill all form field to go to next step</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" class="signup_form">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Account</strong></li>
                                <li id="personal"><strong>Personal</strong></li>
                                <!-- <li id="payment"><strong>Subscription</strong></li> -->
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Account Information</h2>
                                    <div class="radio-group">
                                        <input  type="radio" id="service_directory" name="user_type" value="service_directory" checked><label class="radio selected"  for="service_directory"><div class="acount_type"><i class="fa fa-user" aria-hidden="true"></i><p>Become a Service Director</p></div></label>
                                        <input  type="radio" id="funeral_directory" name="user_type" value="funeral_directory"><label class="radio"  for="funeral_directory"><div class="acount_type"><i class="fa fa-user" aria-hidden="true"></i><p>Become a Funeral Director</p></div></label>
                                        <!-- <input  type="radio" id="restaurant" name="user_type" value="restaurant"><label class="radio"  for="restaurant"><div class="acount_type"><i class="fa fa-user" aria-hidden="true"></i><p>Become a Restaurant</p></div></label> -->
                                        <br>
                                    </div>
                                    <input type="email" name="user_email" placeholder="Email *"/>
                                    <input type="text" name="user_name" placeholder="Username"/>
                                    <input type="password" name="password" placeholder="Password *"/>
                                    <input type="password" name="cpwd" placeholder="Confirm Password *"/>
                                </div>
                                <input type="button" name="next" class="next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Personal Information</h2>
                                    <input type="text" name="fname" placeholder="First Name *"/>
                                    <input type="text" name="lname" placeholder="Last Name *"/>
                                    <input type="tel" name="phno" placeholder="Contact No."/>
                                    <label for="">Yearly Subscription In €250.</label>
                                    <div id="card-element"></div> 
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="hidden" name="action" value="signup_user">
                                <button type="submit" class="action-button">Register</button>
                            </fieldset>
                            <!-- <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Subscription</h2>
                                    <div id="card-element"></div> 
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="hidden" name="action" value="signup_user">
                                <button type="submit" class="action-button">Subscribe</button>
                            </fieldset> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer() ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    jQuery(document).ready(function(){
    
        // stripe 
        
        var pub_key = "<?= $publishable_key ?>";
        var stripe = Stripe(pub_key);
        var elements = stripe.elements();
        var cardElement = elements.create('card', {
            hidePostalCode: true,
        });
        cardElement.mount('#card-element');

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        
        jQuery(".next").click(function(){
            
            current_fs = jQuery(this).parent();
            next_fs = jQuery(this).parent().next();
            
            //Add Class Active
            jQuery("#progressbar li").eq(jQuery("fieldset").index(next_fs)).addClass("active");
            
            //show the next fieldset
            next_fs.show(); 
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;
        
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                }, 
                duration: 600
            });
        });
        
        jQuery(".previous").click(function(){
            
            current_fs = jQuery(this).parent();
            previous_fs = jQuery(this).parent().prev();
            
            //Remove class active
            jQuery("#progressbar li").eq(jQuery("fieldset").index(current_fs)).removeClass("active");
            
            //show the previous fieldset
            previous_fs.show();
        
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;
        
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                }, 
                duration: 600
            });
        });
        
        jQuery(document).on('click', '.radio-group .radio', function(){
            jQuery(this).parent().find('.radio').removeClass('selected');
            jQuery(this).addClass('selected');
        });

        jQuery('input[name="user_type"]').change(function(){
            var user_type = jQuery(this).val();
          
            if(user_type != 'service_directory'){
                jQuery('#card-element').empty();
                jQuery('#card-element').hide();
            } else{
                stripe = Stripe(pub_key);
                elements = stripe.elements();
                cardElement = elements.create('card', {
                    hidePostalCode: true,
                });
                cardElement.mount('#card-element');
                jQuery('#card-element').show();
            }
            
        });
       
        //signup user
        jQuery("#msform").submit(function(e) {
            e.preventDefault();

            var form = new FormData(this);
            jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            jQuery(this).find('button[type=submit]').prop('disabled', true);
            var $form = jQuery(this);

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

            if (jQuery(this).find('input[name=user_type]:checked').val() == 'funeral_directory') {
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
                    $form.find('button[type=submit]').prop('disabled', false);
                    if(!response.status){
                        Swal.fire({
                            title: response.title,
                            text:  response.message,
                            icon: response.icon,
                            })
                    }
                    else{
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
                    $form.find('.fa-spinner').remove();
                    $form.prop('disabled', false);
                    jQuery('body').waitMe('hide');
                }
            });
        }
        
    });
    
</script>