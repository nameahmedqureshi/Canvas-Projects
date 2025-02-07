<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include "vendor/autoload.php"; // include stripe library
include "custom/users.php";
include "custom/package-subscription.php";
include "custom/product.php";
include "custom/payouts.php";
include "custom/profile-setting.php";
include "custom/chat.php";
include "custom/store-profile.php";
include 'frontend/product-listing.php';
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
        'page_title'    => 'Payment Details',
        'menu_title'    => 'Payment Details',
        'menu_slug'     => 'payment-details',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}



    // function add_custom_role() {
    //     add_role(
    //                  'supplier', // Role slug
    //                 'Supplier', // Display name
                
    //             );  
           
    //     }
    //     add_action('init', 'add_custom_role');
    

add_filter( 'woocommerce_get_availability_text', 'bbloomer_custom_get_availability_text', 99, 2 );

function bbloomer_custom_get_availability_text( $availability, $product ) {
    $stock = $product->get_stock_quantity();
    $stocktype = get_post_meta($product->get_id(), 'stock_type', true);
    if ( $product->is_in_stock() && $product->managing_stock() ) $availability = 'Quantity: ' . $stock . ' ' . $stocktype;

    return $availability;
}

function add_featured_badge() {
    global $product;

    // Check if the product is featured
    if ( get_post_meta( $product->get_id(), 'featured_product', true ) === 'true' ) {
        echo '<span class="featured-badge">Featured</span>';
    }

}
add_action( 'woocommerce_before_shop_loop_item_title', 'add_featured_badge', 5 );

function add_authortype() {
    global $product;

    $post_id =  $product->get_id();
    $get_post = get_post($post_id);
    $subscription_plan = get_user_meta( $get_post->post_author, 'subscription_plan', true );
    $first_name = get_user_meta( $get_post->post_author, 'first_name', true );
    $last_name = get_user_meta( $get_post->post_author, 'last_name', true );
    $full_name = sprintf('%s %s', $first_name, $last_name);
    if ( $subscription_plan  ) {
        echo '<p class="author">Author: '.$full_name.'</p>';
        echo '<p class="subscription_plan">Subscription: '.$subscription_plan.'</p>';
    }
}
add_action( 'woocommerce_after_shop_loop_item', 'add_authortype', 5 );
    

function split_order_by_seller($order_id) {
    // Get the original order
    $order = wc_get_order($order_id);
    $customer_id = get_current_user_id();
    // Array to hold seller orders
    $seller_orders = array();

    // Loop through each item in the original order
    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();
        $seller_id = get_post_field('post_author', $product_id);

		if (!isset($seller_orders[$seller_id])) {
            $seller_orders[$seller_id] = wc_create_order();
        }

        // Add the item to the seller's order
        $seller_order = $seller_orders[$seller_id];
		$seller_order->add_product($item->get_product(), $item->get_quantity(), array(
            'totals' => array(
                'subtotal' => $item->get_subtotal(),
                'total'    => $item->get_total(),
            )
        ));    

		// Copy item meta
        foreach ($item->get_meta_data() as $meta) {
            $seller_order->add_meta_data($meta->key, $meta->value);
        }
	}

	// Finalize and save the seller orders
	foreach ($seller_orders as $seller_id => $seller_order) {
        $user_meta = get_userdata($seller_id);
		$seller_order->set_address($order->get_address('billing'), 'billing');
		$seller_order->set_address($order->get_address('shipping'), 'shipping');
		$seller_order->calculate_totals();
		$seller_order->update_status('processing');
		$seller_order->update_meta_data('_seller_id', $seller_id);
		$seller_order->update_meta_data('usertype', $user_meta->roles[0]);
		$seller_order->save();
		
	}

    // Save the seller IDs in the original order
    $order->update_meta_data('main_order', $seller_id);
    $order->update_meta_data('customer_id', $customer_id);
    $order->update_meta_data('partial_order_id', $seller_order->get_id());
    $order->save();
}

add_action('woocommerce_thankyou', 'split_order_by_seller');

// farmers standard prevent from buying
// function prevent_buying_notlogged_in_users_or_farmer_standard() {

//     $current_user   = wp_get_current_user();
//     $subscription_plan      = get_user_meta($current_user->ID, 'subscription_plan', true);

   
//     if ( is_product() ){
//         if(!is_user_logged_in()){
//             wp_redirect( home_url('login/') );
//             return;
//         }
//         if ( $subscription_plan == 'standard' && $current_user->roles[0] == 'farmer') {
//             wp_redirect( home_url() );
//             return;
//         } 
//     }

//     if(is_page('product-listing')){
        
//         if ( $subscription_plan == 'standard' && $current_user->roles[0] == 'farmer') {
//             $redirect =  home_url('login');
//             echo "<script>
//             alert('You are not able to buying products. please upgrade your plan');
//             window.location.href = '{$redirect}';
//             </script>";
//         } 
//     }
// }
// add_action( 'wp', 'prevent_buying_notlogged_in_users_or_farmer_standard' );

add_filter('woocommerce_product_tabs', 'woo_new_product_tab');

function woo_new_product_tab($tabs) {
    // Get the current user object
    $current_user = wp_get_current_user();
    if (in_array('restaurant', $current_user->roles)) { // Replace 'desired_role' with the specific role (e.g., 'customer', 'subscriber')

        $tabs['desc_tab'] = array(
            'title'    => __('Product Inquiry', 'woocommerce'),
            'priority' => 50,
            'callback' => 'woo_new_product_tab_content',
        );
    }
    return $tabs;
}

function woo_new_product_tab_content() {
    global $product; // Get the current product object
    $author_id = $product->get_post_data()->post_author; // Get the author's ID

    ?>
    <form id="submitInquiry">
        <textarea id="marketking_send_inquiry_textarea" name="message" required placeholder="Enter your message"></textarea>
        <input type="hidden" name="receiver_id" value="<?php echo esc_attr($author_id); ?>"> <!-- Add Author ID -->
        <input type="hidden" name="action" value="send_message">
        <input type="submit" class="button" value="send">
    </form>
    <?php
}



?>