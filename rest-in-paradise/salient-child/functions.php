<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include 'custom/main.php';
include 'custom/users.php';
include 'custom/announcementsClass.php';
include 'custom/noticesClass.php'; // death notice class
include 'custom/familyNoticeClass.php'; 
include 'custom/serviceDirectoryClass.php'; 
// include 'custom/eventClass.php';
// include 'custom/pollClass.php';
include 'custom/chatClass.php';
// include 'custom/donationClass.php';
include 'custom/profile-setting.php';
include "vendor/autoload.php"; // include stripe library


// add_role(
// 	'funeral_directory', // Role slug
// 	'Funeral Directory', // Display name
// );  

add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		wp_enqueue_style( 'dataTables', 'https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css', '', $nectar_theme_version );
		wp_enqueue_script( 'datatables', 'https://cdn.datatables.net/2.2.1/js/dataTables.min.js', '', $nectar_theme_version );
		
    if ( is_rtl() ) {
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}

function searchFilter($attr) {
	include 'shortcode/filter.php';
}


function deathNoticeListin() {
	include 'shortcode/death_notice_listin.php';
}

function familyNoticeList() {
	include 'shortcode/family_notice_list.php';
}

function familyNotice() {
	include 'shortcode/family_notice.php';
}

function servicesDirectoryAds($attr) {
	include 'shortcode/services-directory-ads.php';
}

function serviceDetail($attr) {
	include 'shortcode/service-detail.php';
}

function deathNotice() {
	include 'shortcode/death-notice.php';
}

function deathNoticeAds() {
	include 'shortcode/death-notice-ads.php';
}

function countyMap() {
	include 'shortcode/map.php';
}
add_shortcode('countyMap', 'countyMap' );



add_shortcode('searchFilter', 'searchFilter' );
add_shortcode('deathNoticeListin', 'deathNoticeListin' );
add_shortcode('deathNotice', 'deathNotice' );
add_shortcode('deathNoticeAds', 'deathNoticeAds' );

add_shortcode('familyNoticeList', 'familyNoticeList' );
add_shortcode('familyNotice', 'familyNotice' );

add_shortcode('servicesDirectoryAds', 'servicesDirectoryAds' );
add_shortcode('serviceDetail', 'serviceDetail' );

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Payment Details',
        'menu_title'    => 'Payment Details',
        'menu_slug'     => 'payment-details',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}
?>