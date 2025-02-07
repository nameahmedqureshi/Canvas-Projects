<?php 



include "vendor/autoload.php"; // include stripe library

include 'custom/users.php';

include 'custom/profile-setting.php';

include 'custom/product.php';

include 'custom/chat.php';

include 'custom/invoice.php';
include 'custom/announcementsClass.php';
include 'custom/schedulepickupsClass.php';



add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);



function salient_child_enqueue_styles() {

		

		$nectar_theme_version = nectar_get_theme_version();

		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );

		

    if ( is_rtl() ) {

   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );

		}

}



//Shortcodes

function login_form_shortcode(){

		ob_start();

		include 'multivendor/login.php';

		return ob_get_clean();

}



function register_form_shortcode(){

		ob_start();

		include 'multivendor/register.php';

		return ob_get_clean();

}

function forget_password_form_shortcode(){

		ob_start();

		include 'multivendor/forget_password.php';

		return ob_get_clean();

}

function reset_password_form_shortcode(){

		ob_start();

		include 'multivendor/reset_password.php';

		return ob_get_clean();

}

function after_invoice_payment_shortcode() {

	ob_start();

	include 'multivendor/success_invoice_page.php';

	return ob_get_clean();

}

add_shortcode( 'login_form', 'login_form_shortcode' );

add_shortcode( 'register_form', 'register_form_shortcode' );

add_shortcode( 'forget_password_form', 'forget_password_form_shortcode' );

add_shortcode( 'reset_password_form', 'reset_password_form_shortcode' );

add_shortcode( 'after_invoice_payment', 'after_invoice_payment_shortcode' );





?>