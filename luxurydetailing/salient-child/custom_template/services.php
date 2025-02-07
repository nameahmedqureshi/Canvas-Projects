<?php 
function services(){
$test_credentials = get_field( 'test_credentials');
$publishable_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_private_key') : get_field( 'test_stripe_private_key');
$main_service = array(
    'post_type' => 'services',
    'posts_per_page' => -1,
    'post_status' => 'publish',
	'meta_key'        => 'cars_price',
	'orderby'   => 'meta_value_num',
	'order'  => 'ASC',
    'meta_query' => array(
        array(
            'key'     => 'service_type',
            'value'   => 'main_service',
            'compare' => 'LIKE',
        ),
        array(
            'key'     => 'status',
            'value'   => 'active',
            'compare' => '=',
        ),
    ),
);

$special_service = array(
    'post_type' => 'services',
    'posts_per_page' => -1,
    'post_status' => 'publish',
	'meta_key'        => 'cars_price',
	'orderby'   => 'meta_value_num',
	'order'  => 'ASC',
    'meta_query' => array(
        array(
            'key'     => 'service_type',
            'value'   => 'special_service',
            'compare' => 'LIKE',
        ),
        array(
            'key'     => 'status',
            'value'   => 'active',
            'compare' => '=',
        ),
    ),
);
$get_main_services = new WP_Query($main_service);

$get_special_services = new WP_Query($special_service);
$user_login = is_user_logged_in();
?>
<style>
    .pickup label, .tip_div label {
        padding: 6px;
        border-radius: 10px;
        border: 1px #c38e36 solid;
        cursor: pointer;
        margin: 3px;
    }

    .pickup input,  .tip_div input {
        display: none;
    }
    .pickup input[type="radio"]:checked + label, .tip_div input[type="radio"]:checked + label {
        background-color: #c38e36;
        border: 1px #c38e36 solid;
    }

    .Make_Model_Year .input_field {
    width: 100% !important;
    }
    .multiple_service .single_box {
        display: none;
    }
    .single_service h1 {
        width: 100%;
    }
    .single_box p {
        width: 87%;
    }
    .single_service .multiple_box {
        display: none;
    }
    .single_price {
        width: 30%;
    }
    button.btn {
        width: 59%;
        font-size: 14px !important;
    }

    button.btn.btn-primary.forget_pass {
        width: 39%;
        padding: 13px;
        background: #f2e47c;
        text-decoration: unset;
        border: unset;
        font-size: 17px !important;
        font-weight: 400;
        text-transform: uppercase;
    }
    .auth-reset-password-form button {
        color: #000;
        margin-top: 10px;
    }
    .auth-reset-password-form {
        padding: 60px;
    }
    .auth-forgot-password-form button.btn {
        margin-top: 20px;
        text-align: center;
        width: 100%;
        color: #000;
    }
    .forget_pass {
        cursor: pointer;
        text-decoration: underline;
        font-weight: 600;
        padding-bottom: 0;
    }
    .form-check {
        display: inline-flex;
        padding: 10px;
        align-items: center;
    }
        .auth-forgot-password-form p.loign.dsec {
        margin-top: 10px;
    }

    .form-check input#remember-me {
        margin-left: 0;
        width: 10% !important;
    }
        .auth-forgot-password-form {
        padding: 60px;
    }

    .form-check label.form-check-label {
        width: 55%;
        text-align: left;
    }
    form.form.login_form .input {
         width: 46% !important;
    }
	
	.cart_icon.not_login i {
		COLOR: #c38e36;
		FONT-SIZE: 25PX;
	}
	
	option.used{
		font-weight: 600;
	}

    a.guest {
        text-align: center;
        color: black;
    
    }

</style>
<div class="tabs">
    <ul id="tabs-nav">
        <li><a href="#tab1">Main Service</a></li>
        <li><a href="#tab2">Add-Ons</a></li>
    </ul> <!-- END tabs-nav -->
    <div id="tabs-content">
        <div id="tab1" class="tab-content">
            <div class="container">
                <div class="services_sec">
                    <?php foreach ($get_main_services->posts ?? [] as $key => $value) { 
                        $image =  get_the_post_thumbnail_url($value->ID);
                        $post_categories = wp_get_post_terms($value->ID, 'services-category', array('fields' => 'names'));
                        $service_id = $value->ID; 
                        ?>
                        <div class="main_service_box" service_id="<?= $service_id ?>">
                            <div class="col span_5">
                                <a href="<?= home_url("service/")."?id=".$service_id ?>">

                                    <img src="<?=  !empty($image) ? $image : get_stylesheet_directory_uri().'/store/assets/images/no-preview.png' ?>" alt="">
                                </a>
                            </div>
                            <div class="col span_7">
                                <a href="<?= home_url("service/")."?id=".$service_id ?>">
                                    <h2><?=  get_the_title($value->ID) ?></h2>
                                </a>
                                <!-- <p><?=  get_the_excerpt($value->ID) ?></p> -->
                                        <div class="d-flex pricing">
                                            <div class="Cars_pricing multipile">
                                                <h3>$<?=  get_post_meta($value->ID, 'cars_price', true)   ?></h3>
                                                <h5>Car</h5>
                                            </div>
                                            <div class="trucks_pricing">
                                            <h3>$<?=  get_post_meta($value->ID, 'truck_price', true)   ?></h3>
                                            <h5>SUV’s &amp; Trucks</h5>
                                            </div>
                                            <div class="Over-Sized_pricing">
                                            <h3>$<?=  get_post_meta($value->ID, 'over_sized', true)   ?></h3>
                                            <h5>Over-Sized</h5>
                                        </div>
                                    <?php 
                                    if(is_user_logged_in()){?>
                                    <div class="cart_icon single">
                                        <input type="checkbox" id="main_service_cart_<?= $service_id ?>" name="main_service_cart">
                                        <label for="main_service_cart_<?= $service_id ?>">
                                            <i class="fa fa-shopping-cart main_service_cart" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <?php } else{?>
										  <div class="cart_icon not_login <?= is_user_logged_in() ? '' : 'single' ?>">
												<i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    </div>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div id="tab2" class="tab-content">
            <div class="container">
                <div class="services_sec">
                    <?php foreach ($get_special_services->posts ?? [] as $key => $value) { 
                        $image = get_the_post_thumbnail_url($value->ID);
                        $post_categories = wp_get_post_terms($value->ID, 'services-category', array('fields' => 'names'));
                        $service_id = $value->ID; 
                        ?>
                        <div class="main_service_box" service_id="<?= $service_id ?>">
                            <div class="col span_5">
                                <a href="<?= home_url("service/")."?id=".$service_id ?>">
                                    <img src="<?=  !empty($image) ? $image : get_stylesheet_directory_uri().'/store/assets/images/no-preview.png' ?>" alt="">
                                </a>
                            </div>
                            <div class="col span_7">
                                <a href="<?= home_url("service/")."?id=".$service_id ?>">
                                    <h2><?=  get_the_title($value->ID) ?></h2>
                                </a>
                                <!-- <p><?= get_the_excerpt($service_id) ?></p> -->
                                <div class="d-flex pricing ">
                                <?php if( empty(get_post_meta($value->ID, 'single_price', true)) ) {  ?>

                                    <div class="Cars_pricing">
                                        <h3>$<?= get_post_meta($service_id, 'cars_price', true) ?></h3>
                                        <h5>Car</h5>
                                    </div>
                                    <div class="trucks_pricing">
                                        <h3>$<?= get_post_meta($service_id, 'truck_price', true) ?></h3>
                                        <h5>SUV’s &amp; Trucks</h5>
                                    </div>
                                    <div class="Over-Sized_pricing">
                                        <h3>$<?= get_post_meta($service_id, 'over_sized', true) ?></h3>
                                        <h5>Over-Sized</h5>
                                    </div>
                                    <?php }else{ ?>
                                        <div class="single_price">
                                        <h3>$<?= get_post_meta($service_id, 'single_price', true) ?></h3>
                                        <h5><?= get_post_meta($service_id, 'single_price_text', true) ?></h5>
                                    </div>
                                    <?php } ?>

                                    
                                    <div class="cart_icon multiple">
                                        <input type="checkbox" id="special_service_cart_<?= $service_id ?>" service_id="<?= $service_id ?>" name="special_service_cart">
                                        <label class="special_service_cart" for="special_service_cart_<?= $service_id ?>">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    
										
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div> <!-- END tabs -->
</div> <!-- END tabs -->


<div id="Booking_Modal"  class="modal main_service">
    <div class="modal-content">
        <div class="form-box">
            <i class="fa fa-times close" aria-hidden="true"></i>
            <div class="booking">
                <form class="booking_form">
                    <?php if(!is_user_logged_in()) { ?>
                        <div class="input_field span_6">
                            <label>First Name</label>
                            <input type="text" name="guest_first_name" placeholder="First Name" class="input_space" required />
                        </div>
                        <div class="input_field span_6">
                            <label>Last Name</label>
                            <input type="text" name="guest_last_name" placeholder="Last Name" class="input_space" required />
                        </div>
                        <div class="input_field span_6">
                            <label>Email Address</label>
                            <input type="email" name="guest_email" placeholder="Email Address" class="input_space" required />
                        </div>
                        <div class="input_field span_6">
                            <label>Phone No</label>
                            <input type="tel" name="guest_phone" placeholder="Phone No" class="input_space" required />
                        </div>
                    <?php } ?>
                    <div class="input_field select_option col span_6">
                        <label>Garage Location</label>
                        <select name="garage_location" id="m-garage_location" >
                        <!-- <option disabled >Select Option</option> -->
                            <option class="used" value="pg1" >Gold Garage</option>
                            <option value="pg2" disabled >PG-2</option>
                            <option class="used" value="pg3"  >Panther Garage</option>
                            <option value="pg4" disabled>PG-4</option>
                            <option value="pg5" disabled >PG-5</option>
                            <option value="pg6" disabled >PG-6</option>
                            <option value="engr-campus-garage" disabled >Engr. Campus Garage</option>
                        </select>
                        <div class="select_arrow"></div>
                    </div>
                    <!-- <div class="input_field select_option col span_6">
                        <label>Classification</label>
                        <select name="classification" id="classification" class="input_space" >
                        <option disabled >Select Option</option>
                        <option value="freshman">Freshman</option>
                        <option value="sophomore">Sophomore</option>
                        <option value="jr">Jr</option>
                        <option value="sr">Sr</option>
                        </select>
                        <div class="select_arrow"></div>
                    </div> -->
                    <div class="input_field select_option col span_6">
                        <label>Vehicle Information</label>
                        <select name="type" id="Type" >
                        <option selected disabled >Car Size</option>
                            <option  value="car" >Car</option>
                            <option value="trucks" >SUV’s & Trucks</option>
                            <option value="over_sized" >Over-Sized</option>
                        </select>
                        <div class="select_arrow"></div>
                    </div>
                    <div class="Make_Model_Year  span_12">
                        <div class="input_field">
                            <input type="text" name="make" placeholder="Make" required />
                        </div>
                        <div class="input_field ">
                            <input type="text" name="model" placeholder="Model" required />
                        </div>
                        <div class="input_field">
                            <input type="number" min="1900" max="<?= date('Y'); ?>" step="1" value="<?= date('Y'); ?>" name="year" class="year" placeholder="Year" required />
                        </div>
                    </div>
                    <div class="input_field span_6">
                        <input type="text" name="vehicle_license_plate" placeholder="License Plate #" class="input_space" required />
                    </div>
                    <div class="input_field span_6">
                        <input type="text" name="date" placeholder="Booking Date" id="m_booking_date" class="booking_date" readonly required />
                    </div>
                    
                    <?php if(is_user_logged_in()) { ?>
                        <div class="input_field span_12">
                            <label for="m-client_requests">Client requests:</label>
                            <textarea id="m-client_requests" name="client_requests" rows="4" cols="50"></textarea>
                        
                        </div>
                    <?php } ?>

                    <div class="input_field span_12 pickup">
                        <span>Select Pickup Time:</span>
                        <input style="width: 0.7rem; margin: 0;" id="pick1" type="radio" name="pickup_time" value="8am-12pm" checked/>
                        <label for="pick1"> 8 am to 12 pm</label>
                        <input style="width: 0.7rem; margin: 0;" id="pick2" type="radio" name="pickup_time" value="1pm-6pm"/>
                        <label for="pick2"> 1 pm to 6 pm</label>
                      
                    </div>

                    <div class="input_field span_6 tip_div">
                        <span>Tip:</span>
                        <input style="width: 0.7rem; margin: 0;" id="tip0" type="radio" name="tip" value="5"/>
                        <label for="tip0"> $5</label>
                        <input style="width: 0.7rem; margin: 0;" id="tip1" type="radio" name="tip" value="10"/>
                        <label for="tip1"> $10</label>
                        <input style="width: 0.7rem; margin: 0;" id="tip2" type="radio" name="tip" value="20"/>
                        <label for="tip2"> $20</label>
                        <input style="width: 0.7rem; margin: 0;" id="tip3" type="radio" name="tip" value="30"/>
                        <label for="tip3"> $30</label>
                        <input style="width: 0.7rem; margin: 0;" id="tip4" type="radio" name="tip" value="other"/>
                        <label for="tip4"> Other</label>
                    </div>

                    <div class="tip_field input_field span_6 custom_tip_div" style="display: none; ">
                        <input type="number" min="1" name="custom_tip" placeholder="Enter Amount" />
                    </div>

                    <div class="input_field span_12">
                        <label for="client_requests">Payment Option:</label>
                    </div>
                    <div id="card-element"></div>
                    <!-- <div class="input_field span_12">
                        <input style="width: 0.7rem; margin: 0;" type="checkbox" name="pay_later" id="pay_later" />
                        <label for="pay_later"> Pay Later</label>
                    </div> -->
                    <input type="hidden" name="service_id" class="main_service_id" value=""  />
                    <input type="hidden" name="action" value="service_order" />
                    <input class="button" type="submit" value="<?= is_user_logged_in() ? 'Book' : 'Quick Book'  ?>" />
                    <?php if(!is_user_logged_in()) { ?>
                        <p class="guest">Please Click Here For <span id="guest_login_btn">Register</span></p>
                    <?php } ?>
                </form>
               

            </div>
        </div>
    </div>
</div>
<div id="special_Modal" class="modal special_service">
    <div class="modal-content">
        <div class="form-box">
            <i class="fa fa-times close" aria-hidden="true"></i>
            <div class="booking">
            <form class="booking_form special_form">
                <div class="service_detail">
                </div>
                    <!-- <div class="input_field span_6">
                        <label>Panther ID number</label>
                        <input type="number" name="panther_id" placeholder="Panther ID number" class="input_space" required />
                    </div> -->
                    <?php if(!is_user_logged_in()) { ?>
                        <div class="input_field span_6">
                            <label>First Name</label>
                            <input type="text" name="guest_first_name" placeholder="First Name" class="input_space" required />
                        </div>
                        <div class="input_field span_6">
                            <label>Last Name</label>
                            <input type="text" name="guest_last_name" placeholder="Last Name" class="input_space" required />
                        </div>
                        <div class="input_field span_6">
                            <label>Email Address</label>
                            <input type="email" name="guest_email" placeholder="Email Address" class="input_space" required />
                        </div>
                        <div class="input_field span_6">
                            <label>Phone No</label>
                            <input type="tel" name="guest_phone" placeholder="Phone No" class="input_space" required />
                        </div>
                    <?php } ?>
                    <div class="input_field select_option col span_6">
                        <label>Garage Location</label>
                        <select name="garage_location" id="s-garage_location" >
                        <!-- <option disabled >Select Option</option> -->
                            <option value="pg1" >Gold Garage</option>
                            <option value="pg2" disabled >PG-2</option>
                            <option value="pg3" >Panther Garage</option>
                            <option value="pg4" disabled>PG-4</option>
                            <option value="pg5" disabled>PG-5</option>
                            <option value="pg6" disabled>PG-6</option>
                            <option value="engr-campus-garage" disabled>Engr. Campus Garage</option>
                        </select>
                        <div class="select_arrow"></div>
                    </div>
                    <!-- <div class="input_field select_option col span_6">
                        <label>Classification</label>
                        <select name="classification" id="classification" class="input_space" >
                        <option disabled >Select Option</option>
                        <option value="freshman" >Freshman</option>
                        <option value="sophomore" >Sophomore</option>
                        <option value="jr" >Jr</option>
                        <option value="sr" >Sr</option>
                        </select>
                        <div class="select_arrow"></div>
                    </div> -->
                    <div class="input_field select_option col span_6">
                        <label>Vehicle Information</label>
                        <select name="type" id="Vehicle-Type" >
                        <option disabled selected >Car Size</option>
                            <option value="car" >Car</option>
                            <option value="trucks" >SUV’s & Trucks</option>
                            <option value="over_sized" >Over-Sized</option>
                        </select>
                        <div class="select_arrow"></div>
                    </div>
                    <div class="Make_Model_Year  span_12">
                        <div class="input_field">
                            <input type="text" name="make" placeholder="Make" required />
                        </div>
                        <div class="input_field ">
                            <input type="text" name="model" placeholder="Model" required />
                        </div>
                        <div class="input_field">
                            <input type="number" min="1900" max="<?= date('Y'); ?>" step="1" value="<?= date('Y'); ?>" name="year" class="year" placeholder="Year" required />
                        </div>
                    </div>
                    <div class="input_field span_6">
                        <input type="text" name="vehicle_license_plate" placeholder="License Plate #" class="input_space" required />
                    </div>
                    <div class="input_field span_6">
                        <input type="text" name="date" placeholder="Booking Date" id="s_booking_date" class="booking_date" readonly required />
                    </div>
                    
                    <?php if(is_user_logged_in()) { ?>
                        <div class="input_field span_12">
                            <label for="m-client_requests">Client requests:</label>
                            <textarea id="m-client_requests" name="client_requests" rows="4" cols="50"></textarea>
                        
                        </div>
                    <?php } ?>

                    <div class="input_field span_12 pickup">
                        <span>Select Pickup Time:</span>
                        <input style="width: 0.7rem; margin: 0;" id="pick3" type="radio" name="pickup_time" value="8am-12pm" checked/>
                        <label for="pick3"> 8 am to 12 pm</label>
                        <input style="width: 0.7rem; margin: 0;" id="pick4" type="radio" name="pickup_time" value="1pm-6pm"/>
                        <label for="pick4"> 1 pm to 6 pm</label>
                      
                    </div>

                    <div class="input_field span_6 tip_div">
                        <span>Tip:</span>
                        <input style="width: 0.7rem; margin: 0;" id="special_tip0" type="radio" name="tip" value="5"/>
                        <label for="special_tip1"> $5</label>
                        <input style="width: 0.7rem; margin: 0;" id="special_tip1" type="radio" name="tip" value="10"/>
                        <label for="special_tip1"> $10</label>
                        <input style="width: 0.7rem; margin: 0;" id="special_tip2" type="radio" name="tip" value="20"/>
                        <label for="special_tip2"> $20</label>
                        <input style="width: 0.7rem; margin: 0;" id="special_tip3" type="radio" name="tip" value="30"/>
                        <label for="special_tip3"> $30</label>
                        <input style="width: 0.7rem; margin: 0;" id="special_tip4" type="radio" name="tip" value="other"/>
                        <label for="special_tip4"> Other</label>
                    </div>

                    <div class="tip_field input_field span_6 custom_tip_div" style="display: none; ">
                        <input type="number" min="1" name="custom_tip" placeholder="Enter Amount" />
                    </div>

                    <div class="input_field span_12">
                        <label for="client_requests">Payment Option:</label>
                    </div>
                    <div id="card-element1"></div> 

                    <!-- <div class="input_field span_12">
                        <input style="width: 0.7rem; margin: 0;" type="checkbox" name="pay_later" id="pay_laterSpecial" />
                        <label for="pay_laterSpecial"> Pay Later</label>
                    </div> -->
                    <div class="input_field span_6">
                        <input type="hidden" name="action" value="special_service_order" />
                        <input class="button" type="submit" value="<?= is_user_logged_in() ? 'Book' : 'Quick Book'  ?>" />
                    </div>
                    <div class="input_field span_6">
                        <input class="close button" type="button" value="Add More Services" />
                        <!-- <input type="hidden" name="service_id" class="specail_service_id" value=""  /> -->
                    </div>
                    <?php if(!is_user_logged_in()) { ?>
                        <p class="guest">Please Click Here For <span id="guest_login_btn">Register</span></p>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<!-- <script src="https://js.stripe.com/v3/"></script> -->
<script type="text/javascript">
		window.onload = function () {
			duDatepicker('#s_booking_date, #m_booking_date', { auto: true, inline: true, minDate: 'today',
				events: {
					dateChanged: function (data) {
						document.body.click();
					}
				}
			});
        }
</script>
<script>
    jQuery(document).ready(function() {


        jQuery('#pay_later').change(function(e) {
            var isChecked = jQuery(this).is(':checked');
            jQuery('#card-element').slideDown();
            if (isChecked) {
                jQuery('#card-element').slideUp();
            }
        });

        jQuery('input[name="tip"]').change(function(e) {
            var isChecked = jQuery(this).is(':checked');
            if (isChecked && jQuery(this).val() == 'other') {
                jQuery('.tip_field').show();
            } else {
                jQuery('.tip_field').hide();

            }
        });


        jQuery('#pay_laterSpecial').change(function(e) {
            var isChecked = jQuery(this).is(':checked');
            jQuery('#card-element1').slideDown();
            if (isChecked) {
                jQuery('#card-element1').slideUp();
            }
        });
//         var pub_key = "pk_test_51MAZe4HnBjRuAp0ig9aBTPdENBP8OcVtiSIOHXv9EYDFVg2fuyq8nYs15fHWsQ3TWTnJ9sYvdHp65n8m6ZzvckIK00LDa3LnBE";

//         live account 
        // var pub_key = "pk_test_51PXpcrIIqqE89EoUfmKL7HzHBvi9ER0PFewAwOlv2VBIvrr5S9u6XcZkdITSlK0kNBigm1HTIYufG4TEYZ0nMPng009BJOX8Pd";
		var pub_key = "pk_live_51PXpcrIIqqE89EoUQ3FzpHBZzPpCNKldNzf9p3LYbpNYrks4TWce1kiMIU9nb28ya9QxbGUcLYjHVa74c62uLBp700TwhQ4VGT";

        var stripe = Stripe(pub_key);
        var elements = stripe.elements();
        var cardElement = elements.create('card', { hidePostalCode: true });
        cardElement.mount('#card-element');

        var stripe1 = Stripe(pub_key);
        var elements1 = stripe1.elements();
        var cardElement1 = elements1.create('card', { hidePostalCode: true });
        cardElement1.mount('#card-element1');

        var today = new Date().toISOString().split('T')[0];
        jQuery('.booking_date').attr('min', today);
   


        jQuery(".booking_form").submit(function(e) {
            e.preventDefault();

            if(jQuery('input[name="tip"]').is(':checked') && jQuery('input[name="tip"]:checked').val() == 'other' && jQuery('input[name="custom_tip"]').val() < 1){
                Swal.fire({
                    title: "Error",
                    text: "Please add tip",
                    icon: "error"
                });
                return false;
            }

            var form = new FormData(this);
            jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            jQuery(this).find('button[type=submit]').prop('disabled', true);
            var $form = jQuery(this);

            stripe = $form.hasClass("special_form") ? stripe1 : stripe;
            cardElement = $form.hasClass("special_form") ? cardElement1 : cardElement;
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

            if (jQuery(this).find('input[name=pay_later]').is(':checked')) {
                return ajexCallAddServices(form, $form);
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
                    ajexCallAddServices(form, $form);
                }
            });
        });
    });

    function ajexCallAddServices(form, $form) {
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
                            if(!response.status){
                                Swal.fire({
                                    title: response.title,
                                    text:  response.message,
                                    icon: response.icon,
                                 })

                            }
                            else{

                                Swal.fire({
                                    title: response.title,
                                    text:  response.message,
                                    icon: response.icon,
                                }).then((willDelete) => {
                                if (response.redirect_url) {window.location.href = response.redirect_url;}
                                }); 
                            
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
</script>
<?php 
}
add_shortcode('services', 'services');
?>