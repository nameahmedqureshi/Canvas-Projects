<?php 

// Include the main file
include 'templates/main.php';
// Include the main file
include 'gallery/gallery.php';

require_once WP_PLUGIN_DIR . '/stripe-gateway/init.php';
add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		
    if ( is_rtl() ) {
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}


//Redirect User after register
add_filter( 'woocommerce_registration_redirect', 'custom_redirection_after_registration', 10, 1 );
function custom_redirection_after_registration( $redirection_url ){
    // Change the redirection Url
    $redirection_url = home_url('dashboard'); // dashboard

    return $redirection_url; // Always return something
}

add_filter( 'woocommerce_login_redirect', 'custom_login_redirect', 9999 );
 
function custom_login_redirect( $redirect_url ) {
    $redirect_url = home_url('dashboard'); // dashboard
    return $redirect_url;
}

// shortocde for track duck
function track_duck_template_shortcode() {
    ob_start(); // Start output buffering
    
    // Include your custom template file
    include 'templates/track-duck.php';
    
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('track_duck', 'track_duck_template_shortcode');


add_filter('gform_pre_render', 'populate_dropdown_with_taxonomy_terms');
function populate_dropdown_with_taxonomy_terms($form) {
    // Specify the form field ID you want to populate
    $field_id = 16; // Change to the actual field ID

    // Specify the custom taxonomy slug you want to fetch terms from
    $taxonomy = 'gallery_categories'; // Change to your taxonomy slug

    // Get the taxonomy terms
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false, // Show even if there are no posts with the term
    ));

    // Populate the Dropdown field with the terms
    foreach ($form['fields'] as &$field) {
        if ($field->id == $field_id) {
            $choices = array();
            foreach ($terms as $term) {
                $choices[] = array(
                    'text' => $term->name,
                    'value' => $term->name,
                );
            }
            $field->choices = $choices;
            break;
        }
    }

    return $form;
}

?>