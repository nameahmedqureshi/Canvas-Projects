<?php 
class ProductBundleClass{

    function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_files' ) );

        $variable = array('get_selected_arrow_products', 'get_product', 'create_product_bundle');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }

    }

    function enqueue_custom_files() {
        wp_enqueue_script('jquery');
        wp_enqueue_style('toastr-style', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
        wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');       

        wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
   
    }

    function get_selected_arrow_products() {

         // Clear the cart before adding the bundled product
        WC()->cart->empty_cart();
        
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'tax_query' => array(
               array(
                 'taxonomy' => 'product_cat',
                 'field'    => 'term_id',
                 'terms'     =>  $_POST['cat_id'],
                 'operator'  => 'IN'
                 )
               )
            );
        $query = new WP_Query($args);
        //var_dump($query);
        $html = '';
        
        foreach ($query->posts ?? [] as $key => $value) {
            $_product = wc_get_product( $value->ID );
            // var_dump($_product);
            $product_image =  wp_get_attachment_url($_product->image_id);
            $html .= '<label class="checkbox_wrap">
                    <input type="radio" name="arrow_product" product-type="arrow" value="'.$_product->id.'">
                    <div class="col_4">
                        <div class="image_wrap">
                            <img src="'. (!empty($product_image) ? $product_image : "https://kanakaarchery.com/wp-content/uploads/2024/08/image-4-300x300-1.png") . '" alt="">
                        </div>
                        <div class="text_block">
                            <h4> '.$_product->name. ' </h4>
                        </div>
                    </div>
                </label>';
            wp_reset_postdata(); 
        } 

        $response['status'] = true;
        $response['html'] = $html;
        return $this->response_json($response);
        // exit;
    }

    function get_product() {
        
        if($_POST['type'] == 'arrow'){
            $product_link = get_the_permalink( $_POST['product_id'] );
            if( $product_link ) {
                $response['status'] = true;
                $response['src'] = $product_link;
            }
        }elseif($_POST['type'] == 'broadhead'){
            $html = '';
            $_product = wc_get_product( $_POST['product_id'] );
            $product_image =  wp_get_attachment_url($_product->image_id);
            $html .= '<div class="col_6">
                        <div class="image_wrap">
                            <img src="'. (!empty($product_image) ? $product_image : "https://kanakaarchery.com/wp-content/uploads/2024/08/image-4-300x300-1.png") . '" alt="">
                        </div>
                    </div>
                    <div class="col_6">
                        <div class="text_block">
                            <h2> '.$_product->name. ' </h2>
                            <h4> '.$_product->regular_price.'$ </h4>
                            <p> '.(!empty($_product->short_description) ? $_product->short_description : $_product->description) .' </p>
                            <div class="packs">
                                <input type="radio" id="html" name="pack" value="1" checked>
                                <label for="html">Pack of 1</label><br>
                                <input type="radio" id="css" name="pack" value="3">
                                <label for="css">Pack of 3</label><br>
                                <input type="radio" id="javascript" name="pack" value="5">
                                <label for="javascript">Pack of 5</label>
                            </div>
                            <div class="quantity" style="display:none">
                                <input type="button" value="-" class="minus">	<label class="screen-reader-text" for="quantity_66bbd49d0e76c"></label>
                                <input type="number" id="quantity_66bbd49d0e76c" class="input-text qty text" name="broadhead_product_quantity" value="1" aria-label="Product quantity" size="4" min="1" max="" step="1" placeholder="" inputmode="numeric" autocomplete="off" data-sharkid="__10">
                                <input type="button" value="+" class="plus">
                            </div>
                        </div>
                </div>';
            $response['status'] = true;
            $response['html'] = $html;
        }
        else {
            $response['status'] = false;
        }
        return $this->response_json($response);
      
    }

    function create_product_bundle(){

        global $woocommerce;
        $broadhead_product_id = $_POST['broadhead_product'];
        $broadhead_quantity = intval($_POST['broadhead_product_quantity']);
        $arrow_product_fnl_price = intval($_POST['arrow_product_fnl_price']);
    
        // Get the product objects
        $broadhead_product = wc_get_product($broadhead_product_id);

        // Calculate the total price
        $broadhead_total_price = $broadhead_product->get_price() * $broadhead_quantity;
        $total_price = $arrow_product_fnl_price + $broadhead_total_price;
        
        // Apply a 10% discount
        // $discounted_price = $total_price * 0.90;
        // var_dump($total_price);
      
        // var_dump(number_format($discounted_price, 2));
        // exit;

        WC()->cart->add_to_cart($broadhead_product_id, $broadhead_quantity);

        $response['status'] = true;
        $response['auto_redirect'] = true;
        $response['redirect_url'] = home_url('cart');
        return $this->response_json($response);
      
    }


    // function get_fletching_options() {

    //     if ( function_exists( 'wc_get_product' ) ) {
    //         // Get the product ID from the query or other source
    //         // Get the product
    //         $html = '';
    //         // Check if product exists
    //         $_product = wc_get_product( $_POST['product_id'] );

            
    //         // var_dump($_product);
    //         $product_image =  wp_get_attachment_url($_product->image_id);
    //         $html .= '<div class="col_6">
    //                         <div class="image_wrap">
    //                             <img src="'. (!empty($product_image) ? $product_image : "https://kanakaarchery.com/wp-content/uploads/2024/08/image-4-300x300-1.png") . '" alt="">
    //                         </div>
    //                     </div>
    //                     <div class="col_6"> '.do_action( 'woocommerce_tm_epo_fields' ) .'</div>';
        
    //     }

    //     $response['status'] = true;
    //     $response['html'] = $html;
    //     return $this->response_json($response);
    // }

    function response_json($response){
		echo json_encode($response);
		wp_die(); 
	}

}
new ProductBundleClass();

    // Step 1: Add meta data to cart item
    add_filter('woocommerce_add_cart_item_data', 'add_bundle_meta_to_cart_item', 10, 3);
    function add_bundle_meta_to_cart_item($cart_item_data, $product_id) {
        // var_dump($_POST);
        // var_dump($cart_item_data);
        // exit;
        if(isset($_POST['is_bundle']) && $_POST['is_bundle'] == 'yes') {
			
            $cart_item_data['is_bundle'] = true;
        }
        return $cart_item_data;
    }

	// Step 2: Display bundle meta data to order
	add_filter('woocommerce_get_item_data', 'display_bundle_meta_in_cart', 10, 2);
	function display_bundle_meta_in_cart($item_data, $cart_item) {
		if(!empty($cart_item['is_bundle'])) {
			$item_data[] = array(
				'key'     => __('Bundle Product', 'textdomain'),
				'value'   => __('Yes', 'textdomain'),
				'display' => __('Yes', 'textdomain'),
			);
		}
		return $item_data;
	}

	// Step 3: Save bundle meta data to order
	add_action('woocommerce_checkout_create_order_line_item', 'add_bundle_meta_to_order_item', 10, 4);
	function add_bundle_meta_to_order_item($item, $cart_item_key, $values, $order) {
		if(isset($values['is_bundle'])) {
			$item->add_meta_data(__('Bundle Product', 'textdomain'), __('Yes', 'textdomain'));
		}
	}

	function add_custom_meta_to_existing_cart_item() {
		// var_dump($_POST);
        // exit;
		

		if(isset($_POST['is_bundle']) && $_POST['is_bundle'] == 'yes') {
			// Loop through all cart items
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		
				// Check if the current cart item matches the target product ID
				if ( $cart_item['product_id'] == $_POST['arrow_product'] ) {
					
					// Add or update custom meta data
					WC()->cart->cart_contents[$cart_item_key]['is_bundle'] = true;
		
				}
			}
		
			// Save the updated cart data
			WC()->cart->set_session();
		}
	}
	
	add_action('woocommerce_before_calculate_totals', 'add_custom_meta_to_existing_cart_item');

	function apply_bundle_discount_to_cart_totals($cart) {
		// Make sure we're running in the cart context and not in AJAX requests
		if (is_admin() && !defined('DOING_AJAX')) return;

		// Initialize variables to hold the total price of the products in the bundle
		$bundle_total = 0;
	
		// Loop through cart items to check for the bundled products
		foreach ($cart->get_cart() as $cart_item) {
			
			// Check if the cart item is part of the bundle by checking custom meta
			if (isset($cart_item['is_bundle']) && $cart_item['is_bundle'] === true) {
				// Accumulate the price of the bundled products
				$bundle_total += $cart_item['line_total'];
			}
		}
		
		// Apply a 10% discount to the total price of the bundle
		if ($bundle_total > 0) {
			$discount = $bundle_total * 0.10; // 10% discount
			$cart->add_fee(__('Bundle Discount (10%)', 'your-textdomain'), -$discount, true, 'standard');
		}
	}
	
	add_action('woocommerce_cart_calculate_fees', 'apply_bundle_discount_to_cart_totals', 10);