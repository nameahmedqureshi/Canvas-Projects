<?php
/**
 * WpStairs Theme Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WpStairs Theme
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_WPSTAIRS_THEME_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'wpstairs-theme-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_WPSTAIRS_THEME_VERSION, 'all' );

}

function website_remove($fields)
{
if(isset($fields['url']))
unset($fields['url']);
return $fields;
}
add_filter('comment_form_default_fields', 'website_remove', 11);

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
       unset($fields['billing']['billing_company']);
	   unset($fields['billing']['billing_address_1']);
	   unset($fields['billing']['billing_address_2']);
	   unset($fields['billing']['billing_city']);
	   unset($fields['billing']['billing_postcode']);
	   unset($fields['billing']['billing_state']);
	   unset($fields['billing']['billing_phone']);
	unset($fields['billing']['billing_country']);


     return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'add_email_verification_field_checkout' );
  
function add_email_verification_field_checkout( $fields ) {
 
$fields['billing']['billing_email']['class'] = array('form-row-wide');
 
$fields['billing']['billing_em_ver'] = array(
    'label' => __('Confirm Email ', 'er'),
    'required' => true,
    'class' => array('form-row-wide'),
    'clear' => true,
    'priority' => 999,
);
 
return $fields;
}
 
// ---------------------------------
// 3) Generate error message if field values are different
 
add_action('woocommerce_checkout_process', 'matching_email_addresses');
 
function matching_email_addresses() { 
$email1 = $_POST['billing_email'];
$email2 = $_POST['billing_em_ver'];
if ( $email2 !== $email1 ) {
wc_add_notice( __( 'Your email addresses do not match', 'er' ), 'error' );
}
}


