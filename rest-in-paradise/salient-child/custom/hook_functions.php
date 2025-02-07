<?php
//show sponsored product on cart page
add_action('woocommerce_after_cart', 'sponsored_products');
function sponsored_products(){ ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri(). '/frontend/assets/front/css/main.css' ?>">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri(). '/frontend/assets/front/css/responsive.css' ?>">
    <?php

        check_sponsored_products_status();
        
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 5,
            'post_status' => 'publish',
            'meta_query'     => [
                [
                    'key'      => 'sponsored',
                    'value'    => 'active',
                    'compare'  => '=',
                ]
            ],
        );

        $sponsored_products = new WP_Query( $args );
    ?>

    <div class="grid__strip">
        <?php

        if ( $sponsored_products->have_posts() ) {
            while ( $sponsored_products->have_posts() ) : $sponsored_products->the_post();
            // Get product object
            $product = wc_get_product(get_the_ID());

            // Get product price
            $price = $product->get_price_html();

            // Get average rating and number of reviews
            $average_rating = $product->get_average_rating();
            $review_count = $product->get_review_count(); ?>

            <a href="<?php the_permalink(); ?>" class="info__block">
                <div class="info__block_img_block">
                    <?php if (has_post_thumbnail()) { 
                    the_post_thumbnail('medium'); 
                    } else { ?>
                        <img src="<?= get_stylesheet_directory_uri().'/frontend/assets/front/images/card_img_1.png'; ?>" alt="img">
                    <?php } ?>                            
                </div>
                <div class="info__block_txt_block">
                    <h3><?= get_the_title($value->ID); ?></h3>
                    <p><?= substr(get_the_excerpt(), 0,50); ?></p>

                    <div class="grid_seprator">
                        <h4><?= $price; ?></h4>
                        <!-- <p>$799.55</p> -->
                    </div>
                    <div class="rating_stars">
                        <ul>
                            <?php for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $average_rating) { ?>
                                    <li><i class="fa-solid fa-star"></i></li>
                                <?php } else { ?>
                                    <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                <?php }
                            } ?>
                            <li><p><?= $review_count; ?> Reviews</p></li> <!-- Dynamic reviews -->
                        </ul>
                    </div>
                </div>
            </a>
        <?php  endwhile; 
        }
        wp_reset_postdata(); ?>
    </div>
<?php } 


//show blog on single product page
// add_action('woocommerce_after_single_product', 'show_blogs');
function show_blogs() { ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri(). '/frontend/assets/front/css/main.css' ?>">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri(). '/frontend/assets/front/css/responsive.css' ?>">

    <h1>Blogs</h1>
    <div class="grid__strip">
        <?php
        // Set up query for the latest 5 blog posts
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 7,
            'post_status'    => 'publish',
        );

        $blogs = new WP_Query($args); 
        if ( $blogs->have_posts() ) {
            while ( $blogs->have_posts() ) : $blogs->the_post(); ?>

            <a href="<?php the_permalink(); ?>" class="info__block">
                <div class="info__block_img_block">
                    <?php if (has_post_thumbnail()) { 
                    the_post_thumbnail('medium'); 
                    } else { ?>
                        <img src="<?= get_stylesheet_directory_uri().'/frontend/assets/front/images/card_img_1.png'; ?>" alt="img">
                    <?php } ?>                            
                </div>
                <div class="info__block_txt_block">
                    <h3><?= get_the_title($value->ID); ?></h3>
                    <p><?= substr(get_the_excerpt(), 0,100); ?></p>
                </div>
            </a>
        <?php  endwhile; 
        }
        wp_reset_postdata(); ?>
    </div>
<?php }

//Split orders
function split_order_by_seller($order_id) {
    // Get the original order
    $order = wc_get_order($order_id);
    $customer_id = get_current_user_id();
    // echo "<pre>";
    // var_dump($order);
    // Check if the order has already been split
      if ($order->get_meta('_order_split_completed')) {
        return; // Exit the function if order is already split
    }

    // Retrieve the subscription data from options
    $subscription_data = get_option('subscription_data');
    $subscribed_commission = floatval($subscription_data['subscribed_commission']);
    $unsubscribed_commission = floatval($subscription_data['unsubscribed_commission']);

    // Array to hold seller orders
    $seller_orders = array();

    // Loop through each item in the original order
    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();
        $seller_id = get_post_field('post_author', $product_id);

		if (!isset($seller_orders[$seller_id])) {
            $seller_orders[$seller_id] = wc_create_order();
        }

        // Set order type based on top-level category    
        $type = '';
        $top_category = get_top_most_category($product_id, 'product_cat'); // For WooCommerce product categories
        if ($top_category) {
            $type = $top_category->slug;
        }

        // Add the item to the seller's order
        $seller_order = $seller_orders[$seller_id];
		$seller_order->add_product($item->get_product(), $item->get_quantity(), array(
            'totals' => array(
                'subtotal' => $item->get_subtotal(),
                'total'    => $item->get_total(),
            )
        ));    

        // Check if the vendor is subscribed and apply the relevant commission
        $subscription_status = get_user_meta($seller_id, 'subscription_status', true);
        $commission_rate = $subscription_status == 'active' ? $subscribed_commission : $unsubscribed_commission;

        // Calculate the commission amount
        $item_total = $item->get_total();
        $commission_amount = ($commission_rate / 100) * $item_total;

        // Save commission to order item meta for each seller
        $seller_order->update_meta_data('commission_rate', $commission_rate . '%');
        $seller_order->update_meta_data('commission_amount', $commission_amount);
        
        // Call the total_sales function from FilterEarning
        if (class_exists('FilterEarning')) {
            FilterEarning::total_sales($type, $commission_amount, $item_total, $customer_id , $seller_id, $order_id);
        }
       
		// Copy item meta
        foreach ($item->get_meta_data() as $meta) {
            $seller_order->add_meta_data($meta->key, $meta->value);
        }
	}

	// Finalize and save the seller orders
	foreach ($seller_orders as $seller_id => $seller_order) {
		$seller_order->set_address($order->get_address('billing'), 'billing');
		$seller_order->set_address($order->get_address('shipping'), 'shipping');
		$seller_order->calculate_totals();
		$seller_order->update_status('completed');
		$seller_order->update_meta_data('_seller_id', $seller_id);
		$seller_order->update_meta_data('_customer', $customer_id);
		$seller_order->update_meta_data('usertype', 'seller');
		$seller_order->save();
	}

    // Save the seller IDs in the original order
    $order->update_meta_data('main_order', $seller_id);
    $order->update_meta_data('customer_id', $customer_id);
    $order->update_meta_data('partial_order_id', $seller_order->get_id());
    $order->update_meta_data('_order_split_completed', true); // Mark as completed
    $order->update_status('completed'); 
    $order->save();
}

add_action('woocommerce_thankyou', 'split_order_by_seller');


function check_sponsored_products_status() {

    $pro = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status'=> 'publish',
    ];
    
    $all_products = new WP_Query( $pro );

    foreach ($all_products->posts ?? [] as $key => $value) {
        $sponsored_end_date = get_post_meta($value->ID, 'sponsored_end_date', true);
        $sponsored_start_date = get_post_meta($value->ID, 'sponsored_start_date', true);
        $current_date = date('Y-m-d');
        $is_sponsored = strtotime($current_date) >= strtotime($sponsored_start_date) && strtotime($current_date) <= strtotime($sponsored_end_date) ? 'sponsored' : '';
        if( empty($is_sponsored)){
            update_post_meta($value->ID, 'sponsored', 'expired');
        }
    }

}

function get_top_most_category($product_id) {
    // Get the categories for the given post
    $categories = get_the_terms($product_id, 'product_cat');

    // If no categories found, return false
    if (empty($categories) || is_wp_error($categories)) {
        return false;
    }

    // Start with the first category found
    $category = $categories[0];

    // Loop until we find the top-most category (parent is 0)
    while ($category->parent != 0) {
        $category = get_term($category->parent, 'product_cat');
    }

    return $category; // Top-most category
}

// Admin stripe details
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Payment Details',
        'menu_title'    => 'Payment Details',
        'menu_slug'     => 'payment-details',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

// Prevent admin and vendor buying product
add_filter('woocommerce_add_to_cart_validation', 'prevent_admin_from_adding_to_cart', 10, 3);

function prevent_admin_from_adding_to_cart($passed, $product_id, $quantity) {
    // Check if the current user is an admin
    if (is_user_logged_in() && current_user_can('administrator') || current_user_can('vendor')) {
    
        // Add an error notice
        wc_add_notice(__('You are not allowed to purchase products.', 'woocommerce'), 'error');
        
        // Prevent the product from being added to the cart
        return false;
    }

    return $passed;
}
add_action('wp_footer', 'add_admin_cart_alert_script');

function add_admin_cart_alert_script() {
    if (is_user_logged_in() && current_user_can('administrator') || current_user_can('vendor')) {
        ?>
        <script>
            jQuery(document).ready(function($) {
                $(document).on('click', '.single_add_to_cart_button, .direct_checkout', function(e) {
                    e.preventDefault();
                    alert('Your role not allowed to purchase products.');
                });
            });
        </script>
        <?php
    }
}


?>