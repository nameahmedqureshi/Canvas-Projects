<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include 'custom/homeChatIcon.php';
include 'custom/users.php';
include 'custom/products.php';
include 'src/chat2.php';
include 'custom/services.php';
include 'custom/payouts.php';
include 'custom/filter-earnings.php';
include 'custom/profile-setting.php';
include 'custom/subscribers.php';
include 'custom/hook_functions.php';
include 'custom/print_on_demand.php';
include 'frontend/add_subscribers.php'; // shortcode
include 'frontend/pod-form.php'; // shortcode
include 'frontend/service_booking.php'; // shortcode
include 'stripe_vendor/autoload.php'; //Stripe
add_action('wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);
function salient_child_enqueue_styles()
{
	$nectar_theme_version = nectar_get_theme_version();
	wp_enqueue_style('salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version);
	if (is_rtl()) {
		wp_enqueue_style('salient-rtl',  get_template_directory_uri() . '/rtl.css', array(), '1', 'screen');
	}
}
// remove_role(
// 	        'seller', // Role slug
// 	    );
// add_role(
//                      'business', // Role slug
//                     'Business', // Display name
//                 );  
//shortcode product filter
function custom_product_filter(){
    ob_start();
    include 'frontend/product-filter.php';
    return ob_get_clean();
}
add_shortcode('product_filter', 'custom_product_filter');
function AS_disable_plugin_updates( $value ) {
	//create an array of plugins you want to exclude from updates ( string composed by folder/main_file.php)
	 $pluginsNotUpdatable = [
	  'advanced-custom-fields-pro/acf.php',
	];
	if ( isset($value) && is_object($value) ) {
	  foreach ($pluginsNotUpdatable as $plugin) {
		  if ( isset( $value->response[$plugin] ) ) {
			  unset( $value->response[$plugin] );
		  }
		}
	}
	return $value;
  }
  add_filter( 'site_transient_update_plugins', 'AS_disable_plugin_updates' );


	add_filter('woocommerce_add_cart_item_data', 'capture_selected_attributes', 10, 2);
	function capture_selected_attributes($cart_item_data, $product_id) {
		// var_dump($_POST);
		// exit;
		if (!empty($_POST)) {
			foreach ($_POST as $key => $value) {
				if (strpos($key, 'attribute_') !== false) {
					$cart_item_data['selected_attributes'][$key] = sanitize_text_field($value);
				}
			}
		}
		return $cart_item_data;
	}

  	add_filter('woocommerce_get_item_data', 'display_selected_attributes_in_cart', 10, 2);
	function display_selected_attributes_in_cart($item_data, $cart_item) {
		
		if (isset($cart_item['selected_attributes']) && !empty($cart_item['selected_attributes'])) {
			foreach ($cart_item['selected_attributes'] as $key => $value) {
				$attribute_name = wc_attribute_label(str_replace('attribute_', '', $key));
				$item_data[] = [
					'name' => esc_html($attribute_name),
					'value' => esc_html($value),
				];
			}
		}
		return $item_data;
	}

	add_action('woocommerce_checkout_create_order_line_item', 'save_selected_attributes_to_order_meta', 10, 4);
	function save_selected_attributes_to_order_meta($item, $cart_item_key, $values, $order) {
		if (isset($values['selected_attributes']) && !empty($values['selected_attributes'])) {
			foreach ($values['selected_attributes'] as $key => $value) {
				$attribute_name = wc_attribute_label(str_replace('attribute_', '', $key));
				$item->add_meta_data($attribute_name, sanitize_text_field($value));
			}
		}
	}

