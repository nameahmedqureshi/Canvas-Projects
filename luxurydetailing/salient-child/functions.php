<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include "vendor/autoload.php";

include "custom/user.php";

include "custom/services.php";

include "custom/service_orders.php";

include "custom_template/services.php";

include "custom_template/profile_edit.php";

include "custom_template/user_order_view.php";

include "services.php";

include "custom_template/user_history.php";

include "custom_template/reviews.php";

add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);



function salient_child_enqueue_styles() {

		

		$nectar_theme_version = nectar_get_theme_version();

		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );

		wp_enqueue_script( 'stripe', 'https://js.stripe.com/v3/', '', true );

		wp_enqueue_script( 'sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', '', true );

		wp_enqueue_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', '', true );

		

    if ( is_rtl() ) {

   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );

		}

}



add_action('wp_footer', 'login_popup');

function login_popup(){

	include 'custom_template/login.php';

}

add_action('woocommerce_checkout_create_order_line_item',  'save_custom_fields_to_order', 15, 4);
function save_custom_fields_to_order($item, $cart_item_key, $values, $order) {

	// if ( isset( $_POST['garage-location'] ) ) {
	// 	$item->add_meta_data('Garage Location', sanitize_text_field($_POST['garage-location']));
	// }

	$fields = [
		'garage-location' => __('Garage Location', 'salient'),
		'make' => __('Make', 'salient'),
		'model' => __('Model', 'salient'),
		'year' => __('Year', 'salient'),
		'licence-plate' => __('Licence Plate #', 'salient'),
		'bookingdate' => __('Booking Date', 'salient'),
		'customdate' => __('Custom Date', 'salient'),
		'select-pickup-time' => __('Pickup Time', 'salient'),
	];

	foreach ($fields as $key => $label) {
	    if (isset($_POST[$key])) {
	        $item->add_meta_data($label, sanitize_text_field($_POST[$key]));
	    }
	}
}


?>