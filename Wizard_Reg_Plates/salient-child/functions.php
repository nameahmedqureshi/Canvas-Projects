<?php 
include('custom_template/bulid_your_plate.php');
include('custom_template/main.php');
include('vendor/autoload.php');

add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		
    if ( is_rtl() ) {
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Plate Design',
        'menu_title'    => 'Plate Design',
        'menu_slug'     => 'plate-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Payment Details',
        'menu_title'    => 'Payment Details',
        'menu_slug'     => 'payment-details',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
    add_submenu_page( 'woocommerce', 'Plate Orders', 'Plate Orders', 'manage_options', 'edit.php?post_type=plate-orders', false  ); 
}

add_filter('acf/load_field/name=select_letter_style',  'acf_load_letter_field_choices' );
function acf_load_letter_field_choices( $field ) {
    
    // Reset choices
    $field['choices'] = array();

    // Check to see if Repeater has rows of data to loop over
    if( have_rows('letter_style', 'option') ) {
        
        // Execute repeatedly as long as the below statement is true
        while( have_rows('letter_style', 'option') ) {
            
            // Return an array with all values after the loop is complete
            the_row();
            
            // Variables
            $value = get_sub_field('letter_name');
            $label = get_sub_field('letter_name');

            
            // Append to choices
            $field['choices'][ $value ] = $label;
        }
    }
    // Return the field
    return $field;
}
?>