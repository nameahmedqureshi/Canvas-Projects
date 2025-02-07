<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include 'custom/main.php';
add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		
    if ( is_rtl() ) {
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}


	
	

	// Hook to apply the discounted price
	// add_action('woocommerce_before_calculate_totals', 'apply_bundle_discount');
	// function apply_bundle_discount( $cart_obj ) {
	// 	// var_dump($_POST);
	// 	// exit;

	// 	if(isset($_POST['is_bundle']) && $_POST['is_bundle'] == 'yes') {

	// 		$broadhead_product_id = $_POST['broadhead_product'];
	// 		$broadhead_quantity = intval($_POST['broadhead_product_quantity']);
	// 		$arrow_product_fnl_price = intval($_POST['arrow_product_fnl_price']);
		
	// 		// Get the product objects
	// 		$broadhead_product = wc_get_product($broadhead_product_id);

	// 		// Calculate the total price
	// 		$broadhead_total_price = $broadhead_product->get_price() * $broadhead_quantity;
	// 		$total_price = $arrow_product_fnl_price + $broadhead_total_price;
			
	// 		// Apply a 10% discount
	// 		$discounted_price = $total_price * 0.90;
			
	// 		// Loop through the cart items
	// 		foreach ( $cart_obj->get_cart() as $cart_item_key => $cart_item ) {
	// 			// Apply the discount
	// 			$cart_item['data']->set_price( $discounted_price * 0.90 ); // Apply 10% discount
	// 		}
	// 	}
	// }


add_action('wp_head', 'custom_css_for_iframe');
function custom_css_for_iframe() {

	// if(current_user_can( 'administrator' )){
		  

		   echo '<script>
		   if (window.self !== window.top) {
			   var css = `

					#adminmenumain, #wpadminbar, #screen-meta-links, .error, .page-title-action, .notice {display:none !important;} #wpcontent, #wpfooter { margin-left: 0px;} 
					#userfeedback-metabox, #monsterinsights-metabox, #formatdiv, #om-global-post-settings, #aioseo-settings, #nectar-metabox-page-header, #nectar-metabox-header-nav-transparency, #nectar-metabox-fullscreen-rows, #wpfooter, #vc_clipboard_toolbar, .glsr-mce-button, .wpforms-insert-form-button, .optin-monster-insert-campaign-button, #add_gform, .font-awesome-icon-chooser-media-button, .nectar-shortcode-generator, .aioseo-score-settings, #export-action, #delete-action{
						display: none !important;
					}
					header#top {
					   display: none !important;
					}
					div#header-space {
						display: none !important;
					}
					div#header-secondary-outer {
						display: none !important;
					}
					nav.woocommerce-breadcrumb {
						display: none !important;
					}
					div#wc-square-google-pay {
						display: none !important;
					}
					div#wc-square-digital-wallet {
						display: none !important;
				   	}
					.nectar-social.fixed.woo.visible {
						display: none !important;
					}
					.tinv-wraper.tinv-wishlist {
						display: none !important;
					}
					.ppc-button-wrapper {
						display: none !important;
					}
					.product_meta {
						display: none !important;
					}
					.woocommerce-tabs {
						display: none !important;
					}
					section.related.products {
						display: none !important;
					}
					div#footer-outer {
						display: none !important;
					}

					div#tm-extra-product-options {
						position: relative !important;
						left: 0!important;
						transform: none!important;
						width: 100%!important;
						max-width: 100%!important;
						background: transparent!important;
						box-shadow: none!important;
						display: block !important;
					}

					#tm-extra-product-options .close-modal {
						display: none;
					}

					#tm-extra-product-options button.fletching_options {
						display: none;
					}

					button.customize {
						display: none !important;
					}
			   `;
			   jQuery("<style type=\"text/css\">" + css + "</style>").appendTo("head");
		   }
	   </script>';
	   

   } 
	
// }

// function cm_redirect_users_by_role() {

//     if ( is_product() ){
// 		do_action("woocommerce_tm_epo_fields"); 
      
//     }
// } // cm_redirect_users_by_role
// add_action( 'woocommerce_after_single_product_summary', 'cm_redirect_users_by_role' );

// pd

// function custom_quantity_based_discount( $cart ) {
//     if ( is_admin() && ! defined( 'DOING_AJAX' ) )
//         return;

//     $product_ids = array(848, 341, 803); // Replace with your product IDs

//     foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
//         if ( in_array( $cart_item['product_id'], $product_ids ) ) {
//             $quantity = $cart_item['quantity'];
//             $original_price = $cart_item['data']->get_price();

//             if ( $quantity == 1 ) {
//                 $discounted_price = $original_price - ( $original_price * 0.10 );
//             } elseif ( $quantity == 2 ) {
//                 $discounted_price = $original_price - ( $original_price * 0.15 );
//             } elseif ( $quantity == 3 ) {
//                 $discounted_price = $original_price - ( $original_price * 0.20 );
//             } else {
//                 $discounted_price = $original_price; // No discount for quantities greater than 3
//             }

//             $cart_item['data']->set_price( $discounted_price );
//         }
//     }
// }
// add_action( 'woocommerce_before_calculate_totals', 'custom_quantity_based_discount' );
// 



// Replace "Add to Cart" with "Select Options" on shop or archive pages for simple products in the "Arrow" category
add_filter('woocommerce_loop_add_to_cart_link', 'custom_shop_archive_add_to_cart_button_text_simple', 10, 2);

function custom_shop_archive_add_to_cart_button_text_simple($button, $product) {
    // Check if we are on the shop or product category (archive) page
    if (is_shop() || is_product_category()) {
        // Check if the product is in the "arrow" category
        if (has_term('arrows', 'product_cat', $product->get_id())) {
            // Check if the product is a simple product
            if ($product->is_type('simple')) {
                $button_text = __('Select Options', 'woocommerce');
                $url = $product->get_permalink();
                $button = '<a href="' . esc_url($url) . '" class="button select-options">' . esc_html($button_text) . '</a>';
            }
        }
    }

    return $button;
}





?>