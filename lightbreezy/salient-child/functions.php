<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include("custom/services.php");
include "vendor/autoload.php";
include("custom/user.php");
include("custom/service_orders.php");
include("frontend/service.php");
include("frontend/service_inner.php");
include("frontend/service_booking.php");
include("frontend/user_history.php");
include("frontend/user_order_details.php");
include("services/register.php");
include("services/login.php");
include("services/forget-password.php");
include("services/reset-password.php");
include("services/profile_edit.php");
add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		
    if ( is_rtl() ) {
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}

?>