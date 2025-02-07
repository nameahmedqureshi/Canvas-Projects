<?php /* Template Name: Product Bundle */ ?>
<?php get_header(); ?>
<style>

    /* #product{
        width: 100%;
        height: 1300px;
    } */
    .quantity {
        margin-top: 20px;
    }
div#ht {
    padding: 70px 130px;
}
    div#tbs {
        pointer-events: none;
    }


    input.minus {
        color: #666;
        width: 35px;
        height: 35px;
        text-shadow: none;
        padding: 0;
        margin: 0;
        background-color: transparent;
        display: inline-block;
        vertical-align: middle;
        border: none;
        position: relative;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.25s ease;
        border-radius: 50px !important;
        line-height: 24px !important;
        font-size: 18px;
        background-color: #fff;
        -webkit-appearance: none;
        font-family: "Open Sans";
        font-weight: 400;
    }

    input#quantity_66bbd49d0e76c {
            border: none;
        margin: 0 10px;
        display: inline-block;
        height: 35px;
        line-height: 35px;
        margin: 0;
        font-size: 20px;
        font-family: "Open Sans";
        font-weight: 700;
        padding: 0 5px;
        text-align: center;
        vertical-align: middle;
        background-color: transparent;
        background-image: none;
        box-shadow: none;
        width: 46px;
        position: relative;
    }

    input.plus {
        color: #666;
        width: 35px;
        height: 35px;
        text-shadow: none;
        padding: 0;
        margin: 0;
        background-color: transparent;
        display: inline-block;
        vertical-align: middle;
        border: none;
        position: relative;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.25s ease;
        border-radius: 50px !important;
        line-height: 24px !important;
        font-size: 18px;
        background-color: #fff;
        -webkit-appearance: none;
        font-family: "Open Sans";
        font-weight: 400;
    }
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    ul.ts li.active a {
        font-weight: bold;
    }

    .image_wrap img {
        width: 100%;
        /* Adjust as needed */
        height: auto;
    }

    .b1 {
        padding: 10px 20px;
        border: none;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        margin: 5px;
    }

    .b2 {
        background-color: #6c757d;
    }

    .hidden {
        display: none;
    }

    #tab1 input:checked+.col_6 {
        padding-block: 40px;
        border-radius: 30px;
        border: 2px solid #bf202f;
    }

#tab1 .col_6 {
    padding-block: 0px !important;
    border-radius: 30px;
    border: 2px solid transparent !important;
}

    #tab1 label.checkbox_wrap input {
        display: none;
    }

    #tab1 label.checkbox_wrap {
        width: 100%;
        margin-top: 30px;
        padding-inline: 5px;
    }

    #ht ul.ts li.active.tb1 .text_block {
        font-size: 18px;
        line-height: 28px;
    }

    #ht ul.ts li.tb1 .text_block {
        font-size: 0px;
        transition: 0.8s;
    }

    #tab2 input:checked+.col_4 {
        padding-block: 12px;
        border-radius: 30px;
        border: 2px solid #bf202f;
    }

    #tab2 .col_4 {
        padding-block: 0px !important;
        border-radius: 30px;
        border: 2px solid transparent !important;
    }

    #tab2 label.checkbox_wrap input {
        display: none;
    }

    #tab2 label.checkbox_wrap {
        width: 100%;
        margin-top: 30px;
        padding-inline: 5px;
    }

    #tab3 .col_12 h1 {
        margin-bottom: 35px;
    }

    #tab4 .col_12 h1 {
        margin-bottom: 35px;
    }

    #tab6 .col_12 h1 {
        margin-bottom: 35px;
    }

    #but button#nextButton {
        background: #bf202f;
        color: white;
        padding: 17px 45px;
        font-size: 16px;
        line-height: 26px;
        font-family: 'bold';
        border-radius: 40px !important;
    }

    #but button#prevButton {
        background: transparent;
        color: black;
        border: 1px solid;
        margin-right: 15px;
        padding: 17px 45px;
        font-size: 16px;
        line-height: 26px;
        font-family: 'bold';
        border-radius: 40px !important;
    }

    #but button#addToCartButton {
        background: #bf202f;
        color: white;
        padding: 17px 45px !important;
        font-size: 16px;
        line-height: 26px;
        font-family: 'bold';
        border-radius: 40px !important;
    }

    #tab5 input:checked+.col_4 {
        padding-block: 12px;
        border-radius: 30px;
        border: 2px solid #bf202f;
    }

    #tab5 .col_4 {
        padding-block: 0px !important;
        border-radius: 30px;
        border: 2px solid transparent !important;
    }

    #tab5 label.checkbox_wrap input {
        display: none;
    }

	#ht h1 {
    font-size: 33px;
}
 label.checkbox_wrap {
    width: 33.3% !important;
    margin-top: 0px;
    padding-inline: 5px;
}
	#tab5 .col_4 img {
    display: table;
}
	.wrap.col_12 {
    flex-wrap: wrap;
}

    #ht label.checkbox_wrap {
        cursor: pointer;
    }
	
	#ht ul.ts li.tb1 .image_wrap {
		background: #d0d0d0;
		padding: 40px 40px;
		position: absolute;
		left: 0;
		top: -14px;
		bottom: 0px;
		border-radius: 100px;
	}
	#ht ul.ts li.tb1.active .image_wrap {
		background: #bf202f;
	}
	#ht ul.ts li.tb1 {
		position: relative;
		list-style: unset;
		border-right: 3px solid #d8d8d8;
		padding-left: 22px;
		margin-left: 0px;
		padding-right: 0px;
	}
	#ht ul.ts li.tb1.active {
		padding-right: 20px;
	}
</style>
<div id="ht" class="container main-content">
    <form id="arrow-selection-form">
        <div id="tbs" class="row">
            <ul class="ts">
                <li class="tb1 active">
                    <a href="#tab1">
                        <div class="image_wrap">
                            <img src="https://kanakaarchery.com/wp-content/uploads/2024/07/arrow-tradd.jpg" alt="">
                        </div>
                        <div class="text_block">
                            <strong>Step 1/6</strong>
                            <br>Choose Arrow Type
                        </div>
                    </a>
                </li>
                <li class="tb1">
                    <a href="#tab2">
                        <div class="image_wrap">
                            <img src="https://kanakaarchery.com/wp-content/uploads/2024/07/arrow-tradd.jpg" alt="">
                        </div>
                        <div class="text_block">
                            <strong>Step 2/6</strong>
                            <br>Sub Category
                        </div>
                    </a>
                </li>
                <li class="tb1 tab3">
                    <a href="#tab3">
                        <div class="image_wrap">
                            <img src="https://kanakaarchery.com/wp-content/uploads/2024/07/arrow-tradd.jpg" alt="">
                        </div>
                        <div class="text_block">
                            <strong>Step 3/6</strong>
                            <br>Choose Quantity
                        </div>
                    </a>
                </li>
				
				<li class="tb1">
                    <a href="#tab3">
                        <div class="image_wrap">
                            <img src="https://kanakaarchery.com/wp-content/uploads/2024/07/arrow-tradd.jpg" alt="">
                        </div>
                        <div class="text_block">
                            <strong>Step 4/6</strong>
                            <br>Fletching Options
                        </div>
                    </a>
                </li>
              
                <li class="tb1">
                    <a href="#tab5">
                        <div class="image_wrap">
                            <img src="https://kanakaarchery.com/wp-content/uploads/2024/07/arrow-tradd.jpg" alt="">
                        </div>
                        <div class="text_block">
                            <strong>Step 5/6</strong>
                            <br>Choose Broadhead
                        </div>
                    </a>
                </li>
                <li class="tb1">
                    <a href="#tab6">
                        <div class="image_wrap">
                            <img src="https://kanakaarchery.com/wp-content/uploads/2024/07/arrow-tradd.jpg" alt="">
                        </div>
                        <div class="text_block">
                            <strong>Step 6/6</strong>
                            <br>Choose Quantity
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div id="tab1" class="tab-content active">
            <div class="col_12">
                <h1>Choose Arrow Type</h1>
            </div>
            <div class="wrap col_12">
                <label class="checkbox_wrap">
                    <input type="radio" name="telescoping_arrows" id="telescoping_arrows" class="arrowtype" value="39">
                    <div class="col_6">
                        <div class="image_wrap">
							<img src="https://kanakaarchery.com/wp-content/uploads/2024/08/telescoping-DG-300x300-1.jpg" alt="">
                        </div>
                        <div class="text_block">
                            <h4>Telescoping Arrows</h4>
                        </div>
                    </div>
                </label>
                <label class="checkbox_wrap">
                    <input type="radio" name="telescoping_arrows" id="non_telescoping_arrows" class="arrowtype" value="40">
                    <div class="col_6">
                        <div class="image_wrap">
							<img src="https://kanakaarchery.com/wp-content/uploads/2024/08/image-4-300x300-1.png" alt="">
                        </div>
                        <div class="text_block">
                            <h4>Non Telescoping Arrows</h4>
                        </div>
                    </div>
                </label>
            </div>
        </div>
        <div id="tab2" class="tab-content">
            <div class="col_12">
                <h1>Choose Type of Non Telescoping Arrow</h1>
            </div>
            <div class="wrap col_12 products"></div>
        </div>
        <div id="tab3" class="tab-content">
            <div class="col_12">
                <h1 class="quantity_opt">Choose Quantity</h1>
				<h1 class="fletching_opt" style="display:none">Fletching Options</h1>
            </div>
            <div class="col_12 product_view">
                <iframe id="product" src="" scrolling="no" style="width: 100%; height: 1361px;; border: none; overflow: hidden;" ></iframe>
            </div>
        </div>
       
        <div id="tab5" class="tab-content">
            <div class="col_12">
                <h1>Choose Broadhead</h1>
            </div>

            <div class="wrap col_12">
                <?php 
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'     =>  30,
                            'operator'  => 'IN'
                            )
                        )
                    );
                $query = new WP_Query($args);
                foreach ($query->posts ?? [] as $key => $value) {
                $_product = wc_get_product( $value->ID ); 
                $product_image =  wp_get_attachment_url($_product->image_id); ?>

                <label class="checkbox_wrap">
                    <input type="radio" name="broadhead_product" product-type="broadhead" value="<?= $_product->id ?>">
                    <div class="col_4">
                        <div class="image_wrap">
                            <img src="<?= !empty($product_image) ? $product_image : "https://kanakaarchery.com/wp-content/uploads/2024/08/image-4-300x300-1.png" ?>" alt="">
                        </div>
                        <div class="text_block">
                            <h4> <?= $_product->name ?> <small>
                                    <br><?= $_product->regular_price ?>$ </small>
                            </h4>
                        </div>
                    </div>
                </label>
                <?php } ?>
             
            </div>
           
        </div>
        <div id="tab6" class="tab-content">
            <div class="col_12">
                <h1>Choose Broadhead Quantity</h1>
            </div>
            <div class="col_12 broadhead_product_view"></div>
        </div>
        <!-- Navigation Buttons -->
        <div id="but" class="row">
            <div class="col_12">
                <button type="button" class="b1 b2 hidden" id="prevButton">Back</button>
                <!-- <button type="button" class="b1" id="nextButton">Next Step</button> -->
                <input type="hidden" name="is_bundle" value="yes">
                <input type="hidden" name="arrow_product_fnl_price">
                <input type="hidden" name="arrow_product_quantity">
                <input type="hidden" name="action" value="create_product_bundle">
                <button type="submit" class="b1 hidden" id="addToCartButton">Add to Cart</button>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    jQuery(document).ready(function() {

        function updateButtons() {
            var currentIndex = jQuery('.tab-content.active').index('.tab-content');
            var totalTabs = jQuery('.tab-content').length;
            jQuery('#prevButton').toggleClass('hidden', currentIndex === 0);
            jQuery('#nextButton').toggleClass('hidden', currentIndex === totalTabs - 1);
            jQuery('#addToCartButton').toggleClass('hidden', currentIndex !== totalTabs - 1);
        }



        // Handle tab clicks
        jQuery('ul.ts li a').click(function(e) {
            e.preventDefault();
            var targetTab = jQuery(this).attr('href');
            jQuery('.tab-content').removeClass('active');
            jQuery(targetTab).addClass('active');
			jQuery('.tab-content').fadeOut('slow');
            jQuery(targetTab).fadeIn('slow');
			
            jQuery('ul.ts li').removeClass('active');
            jQuery(this).closest('li').addClass('active');
			
			//#DIV_ID is an example. Use the id of your destination on the page
			jQuery('html, body').animate({ scrollTop: $('#ht').offset().top - 20 }, 'slow');
            updateButtons();
        });

        // Handle next and previous buttons
        jQuery('#prevButton').click(function() {
            var currentTab = jQuery('.tab-content.active');
			if(currentTab.attr('id') == 'tab5'){
				 jQuery('#ht').waitMe({
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
			   jQuery('#tab3 .product_view #product').attr('src', productSrc);
			 }
            var targetTab;
            if (jQuery(this).attr('id') === 'prevButton') {
                targetTab = currentTab.prev('.tab-content');
            } 
            if (targetTab.length) {
                jQuery('ul.ts li a[href="#' + targetTab.attr('id') + '"]').click();
            }
        });
        // Initialize buttons visibility
        updateButtons();

        //Choose Arrow Type
        jQuery(document).on('click', '.arrowtype', function(e){
            var cat_id = jQuery(this).val();
            var cat_type = jQuery(this).parent('.checkbox_wrap').find('.text_block h4').text();
            // console.log("cat_id", cat_id);
            var thiss = jQuery(this);
            jQuery('#ht').waitMe({
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
                data: {
                    action: 'get_selected_arrow_products',
                    cat_id: cat_id,
                },
                dataType : 'json',
                success: function (response) {
                    jQuery('#ht').waitMe('hide');
                    // console.log(response.html);
                    if(response.status){
                        jQuery('#tab2 .products').html(response.html);
                        jQuery('#tab2 h1').text("Choose Type of " + cat_type);
                        jQuery('li.tb1.active').next().find('a').trigger('click');
                    } else {
                        toastr.error('Error', 'No products found');
                    }
                  
                },
                error : function(errorThrown){
                    console.log(errorThrown);
                    jQuery('#ht').waitMe('hide');
                }
            });

        });

        //Choose Arrow Product
        
		var productSrc;
        jQuery(document).on('click', 'input[name="arrow_product"]', function(e){
            var product_id = jQuery(this).val();
            var type = jQuery(this).attr('product-type');
            // console.log("product_id", product_id);
            var thiss = jQuery(this);
            jQuery('#ht').waitMe({
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
                data: {
                    action: 'get_product',
                    product_id: product_id,
                    type: type,
                },
                dataType : 'json',
                success: function (response) {
                    // jQuery('body').waitMe('hide');
                    // console.log(response.src);
                    if(response.status){
						productSrc = response.src;
                        var iframe = jQuery('#tab3 .product_view #product');
                        iframe.attr('src', response.src);
                     
                        jQuery('li.tb1.active').next().find('a').trigger('click');
                        jQuery('html, body').animate({
                            scrollTop: $('#ht').offset().top - 20 //#DIV_ID is an example. Use the id of your destination on the page
                        }, 'slow');
                    } else {
                        toastr.error('Error', 'No product found');
                    }
                  
                },
                error : function(errorThrown){
                    console.log(errorThrown);
                    jQuery('#ht').waitMe('hide');
                }
            });

        });

   
        function adjustIframeHeight(iframe) {
            var contentHeight = iframe.contentWindow.document.body.scrollHeight+30;
            jQuery(iframe).css({
                height: contentHeight + 'px',
                width: "100%"
            });
        }
        
        // Select the iframe and listen for the load event
        jQuery('#product, iframe').on('load', function() {
//             console.log("start");
			if(jQuery('#tab3').hasClass('active')){
			   jQuery('.tb1.active').removeClass('active');
				jQuery('.tab3').addClass('active')
				jQuery('#prevButton').hide();
			}
			
			
            jQuery('#ht').waitMe('hide');
            // Ensure you are accessing the iframe correctly
            var iframe = document.getElementById('product');
            var iframeContent = jQuery(iframe.contentWindow.document);
// 			console.log(iframeContent);
            // Initial height adjustment
            //
            
            iframeContent.find('.cpf-section.tc-cell.tcwidth.tcwidth-100.nw, .single_add_to_cart_button').hide();
			iframeContent.find('.single_add_to_cart_button').before(`<div class="action">
							<button type="button" class="nextFleching">Fletching Options</button>
							<button type="button" class="prevFleching">Back</button></div>
							<style>.container.main-content {padding: unset;}.container-wrap {padding-top: 0px !important;}
							img.attachment-shop_single.size-shop_single.wp-post-image {border-radius: 30px;}</style>`);
			
            adjustIframeHeight(iframe);
            // var h = this.contentWindow.document.body.scrollHeight
            // var w = this.contentWindow.document.body.scrollWidth
            // jQuery(this).css({
            // height: "",
            // width: "100%"
            // })
            // var h1 = this.contentWindow.document.body.scrollHeight
            // var w1 = this.contentWindow.document.body.scrollWidth
            // jQuery(this).css({
            // height: h,
            // width: w
            // }).animate({
            // height: h1,
            // width: w1
            // }, 300 )  
            // 
			var clickCount = 0;
			iframeContent.find('.nextFleching').on('click', function(e) {
				clickCount = clickCount+1;
             	iframeContent.find('.cpf-section.tc-cell.tcwidth.tcwidth-100, .nextFleching').fadeOut('slow');
             	iframeContent.find('.cpf-section.tc-cell.tcwidth.tcwidth-100.nw, .single_add_to_cart_button').fadeIn('slow');
				jQuery('.quantity_opt').fadeOut('slow');
				jQuery('.fletching_opt').fadeIn('slow');
                jQuery('li.tb1.active').removeClass('active').next('li.tb1').addClass('active')
				adjustIframeHeight(iframe);
            });
			
			iframeContent.find('.prevFleching').on('click', function(e) {
				
				if(clickCount == 0){
				   jQuery('#prevButton').show();
				}
				if(clickCount == 1){
				   clickCount = 0;
				}
             	iframeContent.find('.cpf-section.tc-cell.tcwidth.tcwidth-100, .nextFleching').fadeIn('slow');
             	iframeContent.find('.cpf-section.tc-cell.tcwidth.tcwidth-100.nw, .single_add_to_cart_button').fadeOut('slow');
				jQuery('.quantity_opt').fadeIn('slow');
				jQuery('.fletching_opt').fadeOut('slow');
                jQuery('li.tb1.active').prev().find('a').trigger('click');
				
				adjustIframeHeight(iframe);
            });
			
            // Attach event listeners to select and radio inputs
            iframeContent.find('select, input[type="radio"]').on('change', function() {
//                 console.log("works");
                // Adjust iframe height on change
                adjustIframeHeight(iframe);
            });
                            
            // Now attach the click event to the button inside the iframe
            iframeContent.find('.single_add_to_cart_button').on('click', function(e) {
                // Check if the button has the 'disabled' class
                if (jQuery(this).hasClass('disabled')) {
                    // Prevent default action if the button is disabled
                    e.preventDefault();
                    return false; // Stop further actions
                }
				
                const arrow_product_quantity = iframeContent.find('input[name="quantity"]').val();
                const arrow_product_fnl_price = iframeContent.find('.price.amount.final bdi').text();
                const fnl_price = parseFloat(arrow_product_fnl_price.replace(/[$,]/g, ''));
                jQuery('input[name="arrow_product_quantity"]').val(arrow_product_quantity);
                jQuery('input[name="arrow_product_fnl_price"]').val(fnl_price);
                jQuery('li.tb1.active').next().find('a').trigger('click');
				jQuery('#prevButton').show();
            });
            
        });

        // jQuery('iframe').on("load", function(e) {

        // })
      
        //Choose Broadhead Product
        jQuery(document).on('click', 'input[name="broadhead_product"]', function(e){
            var product_id = jQuery(this).val();
            var type = jQuery(this).attr('product-type');
            // console.log("product_id", product_id);
            var thiss = jQuery(this);
            jQuery('#ht').waitMe({
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
                data: {
                    action: 'get_product',
                    product_id: product_id,
                    type: type,
                },
                dataType : 'json',
                success: function (response) {
                    jQuery('#ht').waitMe('hide');
                    // console.log(response.src);
                    if(response.status){
                        jQuery('#tab6 .broadhead_product_view').html(response.html);
                        // jQuery('#nextButton').hide();
                        jQuery('li.tb1.active').next().find('a').trigger('click');
                    } else {
                        toastr.error('Error', 'No product found');
                    }
                  
                },
                error : function(errorThrown){
                    console.log(errorThrown);
                    jQuery('#ht').waitMe('hide');
                }
            });

        });

        //Form Submission
        jQuery("#arrow-selection-form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            //  alert("works");
            var form = new FormData(this);
            // console.log('form', form);
            jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            jQuery(this).find('button[type=submit]').prop('disabled',true);
            var thiss = jQuery(this);
            jQuery('#ht').waitMe({
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
                    jQuery('#ht').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                    if (!response.status) {
                        Swal.fire({
                            title: response.title,
                            text: response.message,
                            icon: response.icon,
                        })
                    } else{
                        if (response.auto_redirect) {
                            // toastr.success("Success");
                            window.location.href = response.redirect_url;
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
                    }
                    
                },
                error : function(errorThrown){
                    console.log(errorThrown);
                    jQuery('#ht').waitMe('hide');
                }
            });

        }); 

        jQuery(document).on('change', 'input[name="pack"]', function(e){
            jQuery('input[name="broadhead_product_quantity"]').val(jQuery(this).val());
        });

    });
</script>
<?php get_footer(); ?>