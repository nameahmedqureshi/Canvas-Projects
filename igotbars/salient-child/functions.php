<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include 'custom/main.php';
include 'custom/video_competition.php';
add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		
    if ( is_rtl() ) {
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}


/**
 * Snippet Name: Show categories on product loop with "pro-cat" class.
 * Snippet Author: ecommercehints.com
 */
function ecommercehints_woocommerce_after_shop_loop_item() {
    $terms = get_the_terms( get_the_ID(), 'product_cat' );

    if ($terms && !is_wp_error($terms)) {
        $term_names = array();
        foreach ($terms as $term) {
            $term_names[] = $term->name;
        }

        $class = 'pro-cat'; // Set the class name to "pro-cat".

        echo '<div class="' . esc_attr($class) . '">' . implode(', ', $term_names) . '</div>';
    }
}

// add the action
add_action('woocommerce_after_shop_loop_item', 'ecommercehints_woocommerce_after_shop_loop_item', 1, 0);

add_action('wp_footer', 'custom_nav_item_visibility');
add_action('wp_head', 'custom_css_for_admin');
add_action('admin_head', 'custom_css_for_admin');

function custom_css_for_admin() {
	// global $wp;
	// var_dump( add_query_arg( NULL, NULL ) );
	// exit;
	

	global $current_user;
	$user_id = get_current_user_id();
	$specific_admins = ['2'];
	if(in_array($user_id, $specific_admins)){
		   echo '<style>
		   #adminmenumain, #wpadminbar, #screen-meta-links, .error, .page-title-action, .notice, #vtrts_subscribe {display:none !important;} #wpcontent, #wpfooter { margin-left: 0px;} 
		   #userfeedback-metabox, #monsterinsights-metabox, #formatdiv, #om-global-post-settings, #aioseo-settings, #nectar-metabox-page-header, #nectar-metabox-header-nav-transparency, #nectar-metabox-fullscreen-rows, #wpfooter, #vc_clipboard_toolbar, .glsr-mce-button, .wpforms-insert-form-button, .optin-monster-insert-campaign-button, #add_gform, .font-awesome-icon-chooser-media-button, .nectar-shortcode-generator, .aioseo-score-settings, #export-action, #delete-action{
			display: none !important;
			}
			a.wpb_switch-to-front-composer {
				display: none !important;
			}
			
			a.wpb_switch-to-gutenberg {
				display: none !important;
			}
			span.vc_clipboard_oc_button.o:before {
				display: none !important;
			}
			.ahc_main_container .row .col-lg-3:nth-child(1) {
				display: none;
			}
			.ahc_main_container .col-lg-8 a[title="change settings"] img {
				display: none;
			}
			
	   	</style>';

	   echo '<script>
				
					var isIframe = window !== window.top;
					if (!isIframe && window.location.href.indexOf("https://devu03.testdevlink.net/Bars/wp-admin/") !== -1) {
						window.location.href = "https://devu03.testdevlink.net/Bars/dashboard";
						
					}
				
			</script>';
   } 

	
}

function custom_nav_item_visibility() {
	if(!is_user_logged_in()){ ?>
		<script>
		 jQuery('.custom_item').hide();
	 
		 </script>
	 
	 <?php }
	
	if(is_user_logged_in()){ ?>
		<script>
		 jQuery('.logged_in_custom_item').hide();
	 
		 </script>
	 
	 <?php }
}


//Shortcode video compitetion
function video_competition(){
	ob_start();
	include 'video_competition.php';
	return ob_get_clean();
}
add_shortcode('video_competition', 'video_competition');
?>