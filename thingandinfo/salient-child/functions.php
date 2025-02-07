<?php

include 'custom/main.php';
include 'vendor/autoload.php';
add_action('wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles()
{

  $nectar_theme_version = nectar_get_theme_version();
  wp_enqueue_style('salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version);

  if (is_rtl()) {
    wp_enqueue_style('salient-rtl',  get_template_directory_uri() . '/rtl.css', array(), '1', 'screen');
  }
}

add_filter('woocommerce_login_redirect', 'bbloomer_customer_login_redirect', 9999);

function bbloomer_customer_login_redirect($redirect_url)
{
  $redirect_url = '/upload';
  return $redirect_url;
}


add_filter('woocommerce_registration_redirect', 'bbloomer_customer_register_redirect');

function bbloomer_customer_register_redirect($redirect_url)
{
  $redirect_url = '/upload';
  return $redirect_url;
}
// Check function exists.
if (function_exists('acf_add_options_page')) {
  // Register options page.
  $option_page = acf_add_options_page(array(
    'page_title'    => __('Stripe Details'),
    'menu_title'    => __('Stripe Details'),
    'menu_slug'     => 'stripe-settings',
    'capability'    => 'edit_posts',
    'redirect'      => false
  ));
}

function generate_url_shortcode()
{
  ob_start(); // Start output buffering

  // Include your custom template file
  include 'custom/generate-url.php';

  return ob_get_clean(); // Return the buffered content
}
add_shortcode('generate_url', 'generate_url_shortcode');
