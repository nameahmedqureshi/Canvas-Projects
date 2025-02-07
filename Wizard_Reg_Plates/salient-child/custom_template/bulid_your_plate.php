<?php 

function encryptData($data) {
   
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "W3docs";
    $encrypted_data = openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);

     // Remove all slashes and plus signs from the data
     $cleaned_data  = str_replace(array('/', '+', '-', '='), '', $encrypted_data);
     return $cleaned_data;
}
function buildPlate() {
    $test_credentials = get_field( 'test_credentials' , 'option');
$publishable_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_private_key' , 'option') : get_field( 'test_stripe_private_key' , 'option'); ?>
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . '/custom_template/assets/css/custom_style.css'  ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<section class="plate">
    <div class="container">
        <div class="row  wpb_row vc_row-fluid vc_row top-level vc_row-flex" id="build_plate">
            <form class="plate_order">
                <div class="col span_8">
                    <div class="tabs">
                        <ul id="tabs-nav">
                            <li>
                                <span>1</span>
                                <a href="#tab1">Reg</a>
                            </li>
                            <li>
                                <span>2</span>
                                <a href="#tab2">Style</a>
                            </li>
                            <li>
                                <span>3</span>
                                <a href="#tab3">Front</a>
                            </li>
                            <li>
                                <span>4</span>
                                <a href="#tab4">Rear</a>
                            </li>
                            <li>
                                <span>5</span>
                                <a href="#tab5">Flag</a>
                            </li>
                            <li>
                                <a href="#tab6">Extras</a>
                            </li>
                        </ul>
                        <!-- END tabs-nav -->
                        <div class="Registration" id="Registration">
                            <div class="col span_3">
                                <div id="tabs-content">

                                    <!-- Registration tab -->
                                    <div id="tab1" class="tab-content">
                                        <h3>Registration</h3>
                                        <label for="registration">Your registration*</label>
                                        <input type="text" id="registration_num" name="registration" maxlength="8" placeholder="YOUR REG">
                                        <p class="warning-message">Please enter a valid registration</p>
                                        <div class="continue_btn_main step1  disabled">
                                            <a href="#tab2" class="continue_btn">Continue</a>
                                        </div>
                                        <p class="new-reg">Looking for a new <br> registration? </p>
                                        <a href="#">Search regs</a>
                                    </div>

                                    <!-- Letter Style tab -->
                                    <div id="tab2" class="tab-content">
                                        <h3>Letter Style</h3>
                                        <div class="style plate_styles">
                                            <h4>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" fill="none">
                                                    <g clip-path="url(#a)">
                                                        <path d="M5.925 7.237c.051.459.092.994.022 1.445-.045.288-.144.61-.376.858-.252.27-.598.385-.99.36m1.344-2.663L3.157 9.218l.094.077c.153.126.318.263.493.364.24.14.5.22.837.24m1.344-2.662c.138.177.273.328.406.452.238.223.499.39.786.448.31.062.591-.016.821-.18.214-.151.37-.368.489-.583.236-.43.398-1.002.522-1.54.081-.355.153-.73.218-1.065.032-.171.063-.332.092-.473l.254-1.173.49 2.568c.094.542.228 1.026.407 1.413.174.374.424.733.796.907.419.195.85.095 1.216-.166.217-.155.428-.375.633-.653l-.014.106c-.076.565-.077 1.064.006 1.474.082.405.261.786.6 1.015.356.24.774.237 1.162.102.378-.131.768-.399 1.16-.766l.574-.54-1.559 4.925H3.967l-1.43-4.79.62.5 2.768-1.981ZM4.58 9.9l.032-.5-.031.5H4.58ZM9.63 1.758l-.143.07-.149-.047c-.19-.06-.392-.29-.392-.633 0-.424.288-.651.51-.651.221 0 .509.228.509.65 0 .306-.162.528-.335.611Zm4.17 3.92-.124-.026-.1-.091a.716.716 0 0 1-.215-.528c0-.424.288-.651.51-.651.221 0 .509.228.509.65 0 .424-.288.652-.51.652a.351.351 0 0 1-.07-.006ZM5.29 5.666l-.1.027a.359.359 0 0 1-.096.012c-.222 0-.509-.228-.509-.65 0-.424.288-.651.51-.651.221 0 .509.228.509.65a.709.709 0 0 1-.237.548l-.077.064Zm12.07 2.071-.162-.06-.104-.164a.757.757 0 0 1-.112-.404c0-.423.288-.65.51-.65.221 0 .509.227.509.65 0 .424-.288.651-.51.651a.377.377 0 0 1-.13-.023ZM1.895 7.61l-.092.137-.127.057a.404.404 0 0 1-.168.036c-.222 0-.509-.227-.509-.65 0-.424.288-.652.51-.652.221 0 .509.229.509.651 0 .166-.05.31-.123.421Zm2.192 8.503h10.793V17.5H4.086v-1.387Z" fill="currentColor" stroke="currentColor"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="a">
                                                            <path fill="currentColor" transform="translate(.5)" d="M0 0h18v18H0z"></path>
                                                        </clipPath>
                                                    </defs>
                                                </svg>Best seller
                                            </h4>
                                            <?php  $styles = get_field('letter_style', 'option');  
                                            if ($styles) { foreach ($styles as $key => $value) {
                                                $letter_style = $value['letter_style']; ?>

                                                <input type="radio" id="<?= encryptData($value['letter_name']) ?>" data-style="<?= isset($value['letter_style']) ? $value['letter_style'] : ''; ?>" data-price="<?= isset($value['letter_price']) ? $value['letter_price'] : ''; ?>" class="letter_style" name="style" value="<?= isset($value['letter_name']) ? $value['letter_name'] : '';  ?>" <?= isset($value['default_letter']) && $value['default_letter'] == 'true' ? 'checked' : '';  ?> >
                                                <label for="<?= encryptData($value['letter_name'])  ?>" >
                                                    <div class="style_box">
                                                        <img class="style_img" src="<?= isset($value['letter_image']) ? $value['letter_image'] : '';  ?>">
                                                        <div class="style_desc">
                                                            <h5 class="style_hed"><?= isset($value['letter_name']) ? $value['letter_name'] : '';  ?></h5>
                                                            <p class="style_pri">£<?= isset($value['letter_price']) ? $value['letter_price'] : ''; ?> Per Pair</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            <?php } } ?>
                                        </div>
                                        <div class="continue_btn_main">
                                            <a href="#tab3" class="continue_btn">Continue</a>
                                        </div>
                                    </div>

                                    <!-- Front Letter Style tab -->
                                    <div id="tab3" class="tab-content">
                                        <h3>Front Plate - <br> Shape/Size </h3>
                                        <div class="style">
                                            <div class="dont_need">
                                                <input type="checkbox" class="front_dont_need" id="dont_need" name="front_dont_need" value="yes">
                                                <label for="dont_need" class="front_dont_need">I don't need a front plate</label>
                                            </div>
                                            <div class="front_sec">
                                                <!-- default front style -->
                                                <?php  $default_front_plate_image = get_field('set_default_front_plate_image', 'option');  
                                                    $default_front_plate_name = get_field('set_default_front_plate_name', 'option');
                                                    if(isset($default_front_plate_image) && isset($default_front_plate_name)){  ?>
                                                    
                                                    <input type="radio" id="d_front_style"  data-price="0"  class="front_style_radio" data-style="standard" name="front_style" value="<?= $default_front_plate_name  ?>" checked >
                                                    <label for="d_front_style">
                                                        <div class="style_box">
                                                            <img class="style_img" src="<?= $default_front_plate_image  ?>">
                                                            <div class="style_desc">
                                                                <h5 class="style_hed">Standard</h5>
                                                                <p class="style_pri">Included</p>
                                                            </div>
                                                        </div>
                                                    </label>
                                                
                                                    <?php } ?>

                                                <!-- front style -->
                                                <?php  $front_plate = get_field('front_plate', 'option');  
                                                if ($front_plate) { foreach ($front_plate as $key => $value) {
                                                    $front_style = $value['front_style'];
                                                    $styles = $value['select_letter_style'];
                                                    // Encrypt each style and store in a new array
                                                    $encrypted_styles = array_map('encryptData', $styles); ?> 

                                                    <input type="radio" id="front_<?= $key ?>"  data-price="<?= isset($value['front_price']) ? $value['front_price'] : ''; ?>"  class="front_style_radio"  data-style="<?= isset($value['front_style']) ? $value['front_style'] : '';  ?>"  name="front_style" value="<?= isset($value['front_name']) ? $value['front_name'] : '';  ?>" >
                                                    <label for="front_<?= $key ?>">
                                                        <div class="style_box shape_style <?= implode(' ', $encrypted_styles) ?>" style="display:none">
                                                            <img class="style_img" src="<?= isset($value['front_image']) ? $value['front_image'] : '';  ?>">
                                                            <div class="style_desc">
                                                                <h5 class="style_hed"><?= isset($value['front_name']) ? $value['front_name'] : '';  ?></h5>
                                                                <p class="style_pri">£<?= isset($value['front_price']) ? $value['front_price'] : ''; ?> Per Pair</p>
                                                            </div>
                                                        </div>
                                                    </label>
                                                <?php } } ?>
                                            
                                            </div>
                                        </div>
                                        <div class="continue_btn_main">
                                            <a href="#tab4" class="continue_btn">Continue</a>
                                        </div>
                                    </div>

                                        <!-- Rear Letter Style tab -->
                                    <div id="tab4" class="tab-content">
                                        <h3>Rear Plate - Shape <br> / Size </h3>
                                        <div class="style">
                                            <div class="dont_need">
                                                <input type="checkbox" class="rear_dont_need" id="rear_dont_need" name="rear_dont_need" value="yes">
                                                <label for="rear_dont_need"  class="rear_dont_need">I don't need a rear plate</label>
                                            </div>
                                            <div class="rear_sec">
                                                <!-- default rear plate -->
                                            <?php  $default_rear_plate_image = get_field('set_default_rear_plate_image', 'option');  
                                                $default_rear_plate_name = get_field('set_default_rear_plate_name', 'option');
                                                if(isset($default_rear_plate_image) && isset($default_rear_plate_name)){  ?>
                                                
                                                <input type="radio" id="d_rear_style" data-price="0"  class="rear_style_radio" data-style="standard" name="rear_style" value="<?= $default_rear_plate_name  ?>" checked >
                                                <label for="d_rear_style">
                                                    <div class="style_box">
                                                        <img class="style_img" src="<?= $default_rear_plate_image  ?>">
                                                        <div class="style_desc">
                                                            <h5 class="style_hed">Standard</h5>
                                                            <p class="style_pri">Included</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            
                                                <?php } ?>

                                                <!-- rear plate -->
                                                <?php  $rear_plate = get_field('rear_plate', 'option');  
                                                if ($rear_plate) { foreach ($rear_plate as $key => $value) {
                                                    $rear_style = $value['rear_style']; 
                                                    $styles = $value['select_letter_style'];
                                                    // Encrypt each style and store in a new array
                                                    $encrypted_styles = array_map('encryptData', $styles); ?>

                                                    <input type="radio"  class="rear_style_radio" data-style="<?= isset($value['rear_style']) ? $value['rear_style'] : '';  ?>" data-price="<?= isset($value['rear_price']) ? $value['rear_price'] : ''; ?>"  id="rear_<?= $key ?>" name="rear_style" value="<?= isset($value['rear_name']) ? $value['rear_name'] : '';  ?>" >
                                                    <label for="rear_<?= $key ?>" >
                                                        <div class="style_box shape_style <?= implode(' ', $encrypted_styles) ?>" style="display:none">
                                                            <img class="style_img" src="<?= isset($value['rear_image']) ? $value['rear_image'] : '';  ?>">
                                                            <div class="style_desc">
                                                                <h5 class="style_hed"><?= isset($value['rear_name']) ? $value['rear_name'] : '';  ?></h5>
                                                                <p class="style_pri">£<?= isset($value['rear_price']) ? $value['rear_price'] : ''; ?> Per Pair</p>
                                                            </div>
                                                        </div>
                                                    </label>
                                            <?php } } ?>

                                            </div>
                                        </div>
                                        <div class="continue_btn_main">
                                            <a href="#tab5" class="continue_btn">Continue</a>
                                        </div>
                                    </div>

                                        <!-- Flag Style tab -->
                                    <div id="tab5" class="tab-content">
                                        <h3>Flag</h3>
                                        <div class="style">
                                            <div class="dont_need flag dont_need_flag_div">
                                                <input type="checkbox" id="dont_need_flag"  data-price="0" name="dont_need_flag" value="yes" checked>
                                                <label for="dont_need_flag">I don't need a flag</label>
                                            </div>
                                            <div class="dont_need black_border">
                                                <?php  $flag_border_price = get_field('flag_border_price', 'option');  ?>
                                                <input type="checkbox" id="black_border" data-style="" data-price="<?= isset($flag_border_price) ? $flag_border_price : '0'; ?>"  name="black_border" value="yes">
                                                <label for="black_border">Please add a black border</label>
                                            </div>
                                            <div class="flag_sec" style="display:none">

                                                <?php  $flags = get_field('flag', 'option');  
                                                if ($flags) { foreach ($flags as $key => $value) {
                                                    $flag_style = $value['flag_style']; ?>

                                                    <input type="radio" class="flag_style_radio" data-style="<?= isset($value['flag_style']) ? $value['flag_style'] : ''; ?>" data-price="<?= isset($value['flag_price']) ? $value['flag_price'] : ''; ?>"  id="flag_<?= $key ?>" name="flag_style" value="<?= isset($value['flag_name']) ? $value['flag_name'] : '';  ?>" >
                                                    <label for="flag_<?= $key ?>" >
                                                        <div class="style_box">
                                                            <img class="style_img" src="<?= isset($value['flag_image']) ? $value['flag_image'] : '';  ?>">
                                                            <div class="style_desc">
                                                                <h5 class="style_hed"><?= isset($value['flag_name']) ? $value['flag_name'] : '';  ?></h5>
                                                                <p class="style_pri">£<?= isset($value['flag_price']) ? $value['flag_price'] : ''; ?> Per Pair</p>
                                                            </div>
                                                        </div>
                                                    </label>
                                                <?php } } ?>
                                            
                                            </div>
                                        </div>
                                        <div class="continue_btn_main">
                                            <a href="#tab6" class="continue_btn">Continue </a>
                                        </div>
                                    </div>

                                        <!-- Extra Products tab -->
                                    <div id="tab6" class="tab-content">
                                        <div class="col span_12">
                                            <div class="main_accord">
                                                <div class="accordion">

                                                    <?php  $extras = get_field('extras', 'option');  
                                                        if ($extras) { foreach ($extras as $key => $value) { ?>
                                                            <div class="accordion-item">
                                                                <div class="accordion-header">
                                                                    <div class="accord_heading">
                                                                        <p><?= isset($value['product_name']) ? $value['product_name'] : '';  ?></p>
                                                                    </div>
                                                                    <div class="accord_detail">
                                                                        <p class="price"> £<?= isset($value['product_price']) ? $value['product_price'] : '';  ?></p>

                                                                        <input type="checkbox" class="extra_item" name="extra_item[]" data-price="<?= isset($value['product_price']) ? $value['product_price'] : '';?>" value="<?= isset($value['product_name']) ? $value['product_name'] : '';  ?>" id="<?= encryptData($value['product_name']) ?>">
                                                                        <label for="<?= encryptData($value['product_name']) ?>">
                                                                            <div class="extra_item_div">
                                                                                <div class="add_to_cart add_extra_item">
                                                                                    <i class="fa fa-plus" aria-hidden="true"></i>Add 
                                                                                </div>
                                                                            </div>
                                                                        </label>

                                                                    </div>
                                                                    <div class="accordion-open">
                                                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="accordion-content">
                                                                    <div class="row acord_content">
                                                                        <div class="col span_3">
                                                                            <img class="pro_img" src="<?= isset($value['product_image']) ? $value['product_image'] : '';  ?>">
                                                                            <p class="pro_price">£<?= isset($value['product_price']) ? $value['product_price'] : '';  ?></p>
                                                                        </div>
                                                                        <div class="col span_9">
                                                                            <p class="pro_desc"><?= isset($value['product_description']) ? $value['product_description'] : '';  ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                    <?php } } ?>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col span_9 preview_parent">
                                <div class="Plate_Preview">
                                    <h3>Plate Preview</h3>
                                    <div class="Plate_buttons">
                                        <button type="button"  class="Front_plate active" dataId="front">Front plate</button>
                                        <button type="button"  class="Rear_plate" dataId="rear">Rear plate</button>
                                    </div>
                                    <div class="plate_box">
                                        
                                        <div class="plate_num_box front" dataId="front">
                                            <p class="plate_num">YOUR REG</p>
                                        </div>
                                        <div class="plate_num_box rear" dataId="rear">
                                            <p class="plate_num">YOUR REG</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col span_4">
                    <div class="order_detail">
                    
                        <h4>Your Order</h4>
                        <div class="style_desc">
                            <h5>Number Plates</h5>
                            <p class="plate_info">Registration: <strong class="plate_num">ASFD558</strong>
                            </p>
                        </div>
                        <p class="plate_info">Letter Style: <strong class="letter_plate_style">4D 3mm with Gel</strong>
                        </p>
                        <p class="plate_info">Front plate: <strong class="front_plate_style">Standard</strong>
                        </p>
                        <p class="plate_info">Rear plate: <strong class="rear_plate_style">Standard</strong>
                        </p>
                        <p class="plate_info">Flag: <strong class="flag_plate_style">None</strong>
                        </p>
                        <p class="plate_info">Border: <strong class="border_plate_style">None</strong>
                        </p>
                        <div class="order_price">
                            <p class="plate_price">£<strong class="order_price">10.83</strong></p>
                        </div>
                        <?php
                            $extras = get_field('extras', 'option'); 
                           
                            if ($extras) { foreach ($extras as $key => $value) { ?>
                            <div class="order_vat extra_products <?= encryptData($value['product_name'])  ?>" style="display:none">
                                <h6 class="plate_vat"><?= isset($value['product_name']) ? $value['product_name'] : '';  ?></h6>
                                <p class="vats_price">£<strong class="vs_price"><?= isset($value['product_price']) ? $value['product_price'] : '';  ?></strong></p>
                            </div>
                        <?php } }
                        ?>
                        <div class="order_vat">
                            <h6 class="plate_vat">VAT</h6>
                            <p class="vat_price">£<strong class="v_price">10.83</strong></p>
                        </div>
                        <div class="order_total">
                            <h6 class="plate_total">TOTAL</h6>
                            <p class="vat_price">£<strong class="total_price">10.83</strong></p>
                        </div>
                        <div class="user_form">
                            <input type="text" name="customer_name" class="usr_frm" placeholder="Enter Your Name *">
                            <input type="email" name="customer_email"  class="usr_frm"  placeholder="Enter Your Email *">
                            <input type="text" name="customer_country" class="usr_frm"  placeholder="Enter Your Country *">
                            <input type="text" name="customer_address" class="usr_frm"  placeholder="Enter Your Address *">
                            <input type="text" name="customer_city" class="usr_frm"  placeholder="Enter Your Town/City *">
                            <input type="number" name="customer_zip" class="usr_frm"  placeholder="Enter Your Postcode/ZIP *">
                            <input type="tel" name="customer_tel" class="usr_frm"  placeholder="Enter Your Phone Number *">

                            <div id="card-element"></div> 
                        </div>
                        <input type="hidden" name="action" value="order_plates" />
                        <button type="submit">Checkout</button>
                        
                        <!-- <div class="monthly_pay">
                            <p>Or Pay 3 Monthly Payments <br>- Interest-Free </p>
                            <p class="monthly_payment">£64.98</p>
                        </div> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script>
    
    $(document).ready(function() {
        // Hide all accordion content initially
        $(".accordion-content").hide();

        // Toggle accordion on header click
        $(".accordion-open").click(function() {
           
            $(this).find(".fa-angle-down").toggleClass("fa-angle-up");

            // Check if the clicked item is already open
            if ($(this).parents('.accordion-header').next().is(':visible')) {
                // Slide up the clicked item if it's already open
                $(this).parents('.accordion-header').next().slideUp();
            } else {
                // Slide up all accordion items except the one clicked
                $(".accordion-content").not($(this).parents('.accordion-header').next()).slideUp();
                // Slide down the content of the clicked accordion item
                $(this).parents('.accordion-header').next().slideDown();
            }
           
        });

        jQuery(document).on('click', '.continue_btn_main', function(){
            jQuery('#tabs-nav li.active').next('li').click();
        });

        // stripe 
        var pub_key = "<?= $publishable_key ?>";
        var stripe = Stripe(pub_key);
		var elements = stripe.elements();
        var cardElement = elements.create('card', {
            hidePostalCode: true,
        });
		cardElement.mount('#card-element');

        $(".plate_order").submit(function(e) {
            e.preventDefault();
            var form = new FormData(this);
            jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
			jQuery(this).find('button[type=submit]').prop('disabled',true);
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
            var thiss =  $(this);
            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Handle error
                    Swal.fire({
                        title: "Error",
                        text:  result.error.message,
                        icon: "error",
                    })
                    console.log(result.error);
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled',false); 
                    return;
                } else {
                    // Attach the token or source to the form data
                    form.append('stripeToken', result.token.id);
                    $.ajax({
                        type: 'post',
                        url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                        data: form, // Use FormData directly
                        dataType : 'json',
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            jQuery('.fa.fa-spinner.fa-spin').remove();
                            jQuery('body').waitMe('hide');
                            jQuery(thiss).find('button[type=submit]').prop('disabled',false);
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
                                    showConfirmButton: false,
                                    })
                            if(response.auto_redirect){
                                window.location.href = response.redirect_url;
                            }
                            } 
                        },
                        error : function(errorThrown){ 
                        console.log(errorThrown);
                    }
                    });
                }
            }); 
        }); 

        jQuery('.Plate_buttons button').click(function(){
            var dataId = jQuery(this).attr('dataId');
            jQuery('.plate_num_box').hide();
            // jQuery('.plate_num_box').css('display', 'none !important');
            
            jQuery('.plate_num_box[dataId="' + dataId + '"]').show();

            jQuery(".Plate_buttons button").removeClass("active");
            jQuery(this).addClass("active");
        });

        $("#registration_num").keyup(function(){
            var reg_num = jQuery(this).val();
            jQuery(".plate_num").text(reg_num);
            $('.step1').removeClass('disabled');
            $("ul#tabs-nav").css("pointer-events", "auto");
            $('.warning-message').hide();
            if(reg_num == ''){
                jQuery(".plate_num").text("YOUR REG");
                $('.step1').addClass('disabled');
                $("ul#tabs-nav").css("pointer-events", "none");
                $('.warning-message').show();
            }
        });
            // Show the first tab and hide the rest
        $('#tabs-nav li:first-child').addClass('active');
        $('.tab-content').hide();
        $('.tab-content:first').show();

        // Click function
        $('#tabs-nav li').click(function(){
            $('#tabs-nav li').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').hide();

            var activeTabText = jQuery(this).find('a').text();
            if(activeTabText == 'Rear'){
                jQuery('.Rear_plate').click();
            }
            if(activeTabText == 'Front'){
                jQuery('.Front_plate').click();
            }

            if(jQuery('.rear_dont_need').prop('checked') == true ){
                jQuery('.Front_plate').click();
            }

            if(jQuery('.front_dont_need').prop('checked') == true ){
                jQuery('.Rear_plate').click();
            }
            
            var activeTab = $(this).find('a').attr('href');
            $(activeTab).fadeIn();

            if(activeTab == '#tab6') {
                $(activeTab).parents("#tabs-content").parent(".span_3").addClass("span_12").removeClass("span_3");
                $(".preview_parent").hide();
            }else{
                $(activeTab).parents("#tabs-content").parent(".span_12").addClass("span_3").removeClass("span_12");
                $(".preview_parent").show();
            }

            return false;
        });


        // your order prices changes based on selections
        var vatPercentage = <?= json_encode(get_field('set_vat_percentage','options'));  ?>;
        var originalSelectedLetter = parseFloat($('.plate_styles').find("input[type='radio']:checked").attr('data-price'));

        function updatePrices(selectedLetter, vatPercentage) {
            selectedLetter = parseFloat(selectedLetter);
            var vatPrice = (vatPercentage * selectedLetter) / 100;
            var orderPrice = selectedLetter - vatPrice;
            $('.order_price').text(orderPrice.toFixed(2));
            $('.v_price').text(vatPrice.toFixed(2));
            $('.total_price').text(selectedLetter.toFixed(2));
        }
        updatePrices(originalSelectedLetter, vatPercentage);

        function resetFrontAndRearOptions(){
            jQuery('.front_dont_need, .rear_dont_need, #black_border, .extra_item').prop('checked', false);
            jQuery('#dont_need_flag').prop('checked', true);
            jQuery('.front_sec, .rear_sec').show();
            jQuery('.flag_sec, .extra_products').hide();
            jQuery('.Front_plate, .Rear_plate, .front_dont_need, .rear_dont_need').removeClass('disabled');
            jQuery('.rear_sec, .front_sec').find("input[type='radio']:first").click();
            jQuery(".extra_item_div").html('<div class="add_to_cart add_extra_item"><i class="fa fa-plus" aria-hidden="true"></i>Add </div>');
           
        }

        // Conditionally hide the front or rear styles
        jQuery(document).on( 'change', '.letter_style', function(e) {
            var id =  $(this).attr('id');
            jQuery('.shape_style').hide();
            jQuery('.'+id).show();
            jQuery(".letter_plate_style").text($(this).val());
            resetFrontAndRearOptions()
            if ( jQuery('.front_dont_need').is(':checked') || jQuery('.rear_dont_need').is(':checked') ) {
                resetFrontAndRearOptions()
            }

            var activeTab = jQuery('#tabs-nav li.active a').text();
            if(activeTab == 'Style'){
                jQuery('.front, .rear').removeClass('four_d_5mm_acrylic ghost three_d_gel_resin four_d_3mm_acrylic four_d_3mm_gel printed');
                jQuery('.front, .rear').addClass(jQuery(this).attr('data-style'));
            }
           
            selectedLetter =  $(this).attr('data-price');
           
            updatePrices(selectedLetter, vatPercentage);
        });

        function updateSelectedLetter() {
            var selectedLetter = parseFloat($('.plate_styles').find("input[type='radio']:checked").attr('data-price'));
            var checkedRadioButton = $('.front_sec').find("input[type='radio']:checked");
            selectedLetter += checkedRadioButton.length ? parseFloat(checkedRadioButton.attr('data-price')) : 0;
            checkedRadioButton = $('.rear_sec').find("input[type='radio']:checked");
            selectedLetter += checkedRadioButton.length ? parseFloat(checkedRadioButton.attr('data-price')) : 0;
            if ($('.rear_dont_need').is(':checked') || $('.front_dont_need').is(':checked')) {
                selectedLetter = parseFloat(selectedLetter / 2); 
            } 
            checkedRadioButton = $('.flag_sec').find("input[type='radio']:checked");
            selectedLetter += checkedRadioButton.length ? parseFloat(checkedRadioButton.attr('data-price')) : 0;
            selectedLetter += $('#black_border').is(':checked') ? parseFloat($('#black_border').attr('data-price')) : 0;
             // Iterate over each checkbox with class "extra_item"
            jQuery('.extra_item').each(function() {
                // Check if the checkbox is checked
                if (jQuery(this).is(':checked')) {
                    // Get the value of the data-price attribute and convert it to a float
                    var price = parseFloat(jQuery(this).attr('data-price'));
                    // Add the price to the total sum
                    selectedLetter += price;
                }
            });
            return selectedLetter;
        }

        //Front Condition
        jQuery('.front_dont_need').change(function() {
            if(jQuery(this).is(':checked')) {
                jQuery('.front_style_radio:first').click();
                jQuery('.front_sec').hide();
                jQuery('.Front_plate').removeClass('active');
                jQuery('.Front_plate, .rear_dont_need').addClass('disabled');
                jQuery('.Rear_plate').addClass('active');
                jQuery('.front_style_radio').prop('checked', false);
                jQuery('.front_plate_style').text('None'); // your order chnages on click
                jQuery('.front').removeClass('standard hex shortened oversize square japanese_plate motorbike_plate four_d_laser_cut_plate');
            } else {
                jQuery(".front_sec").show();
                jQuery('.Front_plate').addClass('active');
                jQuery('.Front_plate, .rear_dont_need').removeClass('disabled');
                jQuery('.Rear_plate').removeClass('active');
                jQuery('.front_style_radio:first').click();
             
            }

           
            
           // updatePrices(selectedLetter, vatPercentage);
            updatePrices(updateSelectedLetter(), vatPercentage);

        });

        //Rear Condition
        jQuery('.rear_dont_need').change(function() {
            if(jQuery(this).is(':checked')) {
                jQuery('.rear_style_radio:first').click();
                jQuery('.rear_sec').hide();
                jQuery('.Rear_plate').removeClass('active');
                jQuery('.Rear_plate, .front_dont_need').addClass('disabled');
                jQuery('.Front_plate').addClass('active');
                jQuery('.rear_style_radio').prop('checked', false);
                jQuery('.rear_plate_style').text('None'); // your order chnages on click
                jQuery('.rear').removeClass('standard hex shortened oversize square japanese_plate motorbike_plate four_d_laser_cut_plate');
            } else {
                jQuery(".rear_sec").show();
                jQuery('.Rear_plate').addClass('active');
                jQuery('.Rear_plate, .front_dont_need').removeClass('disabled');
                jQuery('.Front_plate').removeClass('active');
                jQuery('.rear_style_radio:first').click();
               
            }

          
            //updatePrices(selectedLetter, vatPercentage);
            updatePrices(updateSelectedLetter(), vatPercentage);
        });



        // your order chnages on click
        var front_plate = 0;
        jQuery(document).on( 'change', '.front_style_radio', function(e) {
            jQuery(".front_plate_style").text($(this).val());

            var activeTab = jQuery('#tabs-nav li.active a').text();
            if(activeTab == 'Front'){
                jQuery('.front').removeClass('standard hex shortened oversize square japanese_plate motorbike_plate four_d_laser_cut_plate');
                jQuery('.front').addClass(jQuery(this).attr('data-style'));
            }

            // if($(this).attr('value') == 'Hex'){
            //     jQuery('#dont_need_flag').prop('checked', true);
            //     jQuery('.dont_need_flag_div').css("pointer-events", "none");
            //     jQuery('.flag_sec').hide();
            // } else {
            //     jQuery('.dont_need_flag_div').css("pointer-events", "auto");
            // }
            
       
            var additionalPrice = parseFloat($(this).attr('data-price')); 
            selectedLetter = parseFloat(selectedLetter) - front_plate;
            selectedLetter = parseFloat(selectedLetter) + additionalPrice; // Append the additional price to selectedPlate
            front_plate = additionalPrice;
           // updatePrices(selectedLetter, vatPercentage);
           updatePrices(updateSelectedLetter(), vatPercentage);
        });

        var rear_plate = 0;
        jQuery(document).on( 'change', '.rear_style_radio', function(e) {
            jQuery(".rear_plate_style").text($(this).val());

            var activeTab = jQuery('#tabs-nav li.active a').text();
            if(activeTab == 'Rear'){
                jQuery('.rear').removeClass('standard hex shortened oversize square japanese_plate motorbike_plate four_d_laser_cut_plate');
                jQuery('.rear').addClass(jQuery(this).attr('data-style'));
            }

            // if($(this).attr('value') == 'Hex'){
            //     jQuery('#dont_need_flag').prop('checked', true);
            //     jQuery('.dont_need_flag_div').css("pointer-events", "none");

            //     jQuery('.dont_need flag, .flag_sec').hide();
            // } 
            // else {
            //     jQuery('.dont_need_flag_div').css("pointer-events", "auto");
            // }

            var additionalPrice = parseFloat($(this).attr('data-price')); 
            selectedLetter = parseFloat(selectedLetter) - rear_plate;
            selectedLetter = parseFloat(selectedLetter) + additionalPrice; // Append the additional price to selectedPlate
            rear_plate = additionalPrice;
           // updatePrices(selectedLetter, vatPercentage);
           updatePrices(updateSelectedLetter(), vatPercentage);
        });

        var flag_plate = 0;
        jQuery(document).on( 'change', '.flag_style_radio', function(e) {
            jQuery(".flag_plate_style").text($(this).val());

            var activeTab = jQuery('#tabs-nav li.active a').text();
            if(activeTab == 'Flag'){
               
                jQuery('.front, .rear').removeClass('flag un_flag st_flag salt_flag welsh_flag green_flag');
                jQuery('.front, .rear').addClass(jQuery(this).attr('data-style') + ' flag');
               
            }
            var additionalPrice = parseFloat($(this).attr('data-price')); 
            selectedLetter = parseFloat(selectedLetter) - flag_plate;
            selectedLetter = parseFloat(selectedLetter) + additionalPrice; // Append the additional price to selectedPlate
            flag_plate = additionalPrice;

            updatePrices(updateSelectedLetter(), vatPercentage);

        });
   
        jQuery('#dont_need_flag').change(function() {
        
            if(jQuery(this).is(':checked')) {
                jQuery('.flag_sec').hide();
                $('.flag_style_radio').prop('checked', false);
                $('.flag_plate_style').text('None');
                jQuery('.front, .rear').removeClass('flag un_flag st_flag salt_flag welsh_flag green_flag');


            } else {
                jQuery(".flag_sec").show();
                jQuery('.flag_style_radio:first').click();
               
            }
            updatePrices(updateSelectedLetter(), vatPercentage);
        });
        
        var black_border = 0;
        jQuery(document).on( 'change', '#black_border', function(e) {
            var additionalPrice = parseFloat($(this).attr('data-price')); 
           

            if(jQuery(this).is(':checked')) {
                $('.border_plate_style').text('Yes');
                jQuery('.front, .rear').addClass(jQuery(this).attr('id'));
                selectedLetter = parseFloat(selectedLetter) + additionalPrice; // Append the additional price to selectedPlate
                black_border = additionalPrice;
            } else {
                $('.border_plate_style').text('None');
                jQuery('.front, .rear').removeClass(jQuery(this).attr('id'));
                selectedLetter = parseFloat(selectedLetter) - black_border;
                black_border = additionalPrice;
            }
            updatePrices(updateSelectedLetter(), vatPercentage);
        });

        var extra_item = 0;
        jQuery(document).on( 'change', '.extra_item', function(e) {
            var id = $(this).attr('id');
            var additionalPrice = parseFloat($(this).attr('data-price')); 

            if(jQuery(this).is(':checked')) {
                $(this).parents('.accord_detail').find("i").removeClass("fa-plus");
                $(this).parents('.accord_detail').find("i").addClass("fa-check");
                $(this).parents('.accord_detail').find(".extra_item_div").html('<div class="add_to_cart add_extra_item"><i class="fa fa-minus" aria-hidden="true"></i>Remove </div>');
                $('.'+id).show();
                selectedLetter = parseFloat(selectedLetter) + additionalPrice; // Append the additional price to selectedPlate
                extra_item = additionalPrice;
            }
            else {
                $(this).parents('.accord_detail').find("i").removeClass("fa-check");
                $(this).parents('.accord_detail').find("i").addClass("fa-plus");
                $(this).parents('.accord_detail').find(".extra_item_div").html('<div class="add_to_cart add_extra_item"><i class="fa fa-plus" aria-hidden="true"></i>Add </div>');
                $('.'+id).hide();
                selectedLetter = parseFloat(selectedLetter) - additionalPrice; // Append the additional price to selectedPlate
                extra_item = additionalPrice;
            }
            updatePrices(updateSelectedLetter(), vatPercentage);

        });

        jQuery(document).on('click', '.continue_btn_main', function(e) {
            var activeTab = jQuery('#tabs-nav li.active a').text();
            if(activeTab == 'Rear'){
                jQuery('.Rear_plate').click();
            }
            if(activeTab == 'Front'){
                jQuery('.Front_plate').click();
            }
            if(jQuery('.rear_dont_need').prop('checked') == true ){
                jQuery('.Front_plate').click();
            }

            if(jQuery('.front_dont_need').prop('checked') == true ){
                jQuery('.Rear_plate').click();
            }
        });

        jQuery('.plate_styles').find("input[type='radio']:checked").change();


    });
</script>
<?php
}
add_shortcode('customPlate', 'buildPlate');
?>