<?php 
function products_listing() {

    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    if( !is_user_logged_in() || in_array('administrator', wp_get_current_user()->roles) ){
        $args = [
            'post_type' => 'product',
            'posts_per_page' => 20,
            'post_status' => 'publish',
            'paged'=> $paged,
        ];
    } else {
        $curent_user = wp_get_current_user();
        $user_type = get_user_meta($curent_user->ID, 'user_type', true);
        $subscription_plan = get_user_meta($curent_user->ID, 'subscription_plan', true);
        // Get featured user IDs
    //    $featured_user_ids = get_featured_user_ids($user_type);
        // Get users with the same subscription plan
        $same_subscription_plan_user_ids = get_same_subscription_plan_user_ids($user_type, $subscription_plan);
        // $data = array_merge($featured_user_ids, $same_subscription_plan_user_ids);
        // $data = array_unique($data);
        $data = $same_subscription_plan_user_ids;
        
        // if (!empty($data)) {
            $args = [
                'post_type' => 'product',
                'posts_per_page' => 20,
                'post_status' => 'publish',
                'author__in' => $data,
                'paged'=> $paged,
            ];
        // }
    }

    //  echo "<pre>";
    // var_dump($same_subscription_plan_user_ids);

    $query = new WP_Query($args);

    ?>
    <style>
        .not-logged-in .product-add-to-cart {
            display: none;
        }

        .not-logged-in .product-wrap {
            pointer-events: none;
        }
        .pagination {
            text-align: center;
        }

        a.page-numbers {
            padding: 2px;
        }
    </style>
    <!-- Products -->
    <?php if (isset($query) && $query->have_posts()) { ?>
        <div class="woocommerce columns-4 <?= !is_user_logged_in() ? 'not-logged-in' : '' ?>">
            <div class="woocommerce-notices-wrapper"></div>
            <ul class="products columns-4" data-n-lazy="off" data-rm-m-hover="off" data-n-desktop-columns="4" data-n-desktop-small-columns="3" data-n-tablet-columns="default" data-n-phone-columns="default" data-product-style="classic">
                <?php while ($query->have_posts()) {
                    $query->the_post();
                    wc_get_template_part('content', 'product');
                } ?>
            </ul>
        </div>
        <?php wp_reset_postdata(); 
    } ?>
    <div class="pagination">
        <?php 
            echo paginate_links( array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $query->max_num_pages,
            'prev_text' => __('« Previous'),
            'next_text' => __('Next »'),
            )); 
        ?>
    </div> 
    <?php
    if( !$query->found_posts){ ?>
        <div class="no_result"><p>No Products Found</p></div>
    <?php }
}

add_shortcode('product_showcase', 'products_listing');


function get_featured_user_ids($user_type) {
    global $wpdb;

    $featured_user_ids = [];
  

    if ($user_type == 'farmer') {
        $user_meta_value = "('supplier')";
    } elseif ($user_type == 'supplier') {
        $user_meta_value = "('farmer')";
    } elseif ($user_type == 'restaurant' || in_array('administrator', wp_get_current_user()->roles)) {
        $user_meta_value = "('farmer', 'supplier')";
    }

    if (isset($user_meta_value)) {
        $base_query = "
        SELECT um.user_id
        FROM {$wpdb->usermeta} AS um
        INNER JOIN {$wpdb->posts} AS p ON um.user_id = p.post_author
        INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
        WHERE um.meta_key = 'user_type'
        AND pm.meta_key = 'featured_product'
        AND pm.meta_value = %s
        AND um.meta_value IN $user_meta_value 
    ";

        $featured_query = $wpdb->prepare($base_query, 'true', $user_meta_value);
        $featured_user_ids = $wpdb->get_col($featured_query);

       
       // var_dump($featured_query);
    }

    return $featured_user_ids;
}

function get_same_subscription_plan_user_ids($user_type, $subscription_plan) {
    global $wpdb;

    $same_subscription_plan_user_ids = [];
   

    if ($user_type == 'farmer' && in_array($subscription_plan, ['standard'])) {
        $user_meta_value = "('supplier')";
        $plan_meta_value = "('standard')";
    } 
    elseif ($user_type == 'farmer' && in_array($subscription_plan, ['advanced'])) {
        $user_meta_value = "('supplier')";
        $plan_meta_value = "('standard', 'advanced')";
    } 
    elseif ($user_type == 'farmer' && in_array($subscription_plan, ['premium'])) {
        $user_meta_value = "('supplier')";
        $plan_meta_value = "('standard', 'advanced', 'premium')";
    } 
    elseif ($user_type == 'supplier' && in_array($subscription_plan, ['standard'])) {
        $user_meta_value = "('farmer')";
        $plan_meta_value = "('standard')";
    } 
    elseif ($user_type == 'supplier' && in_array($subscription_plan, ['advanced'])) {
        $user_meta_value = "('farmer')";
        $plan_meta_value = "('standard', 'advanced')";
    } 
    elseif ($user_type == 'supplier' && in_array($subscription_plan, ['premium'])) {
        $user_meta_value = "('farmer')";
        $plan_meta_value = "('standard', 'advanced', 'premium')";
    } 
    elseif ($user_type == 'restaurant' && in_array($subscription_plan, ['standard'])) {
        $user_meta_value = "('farmer', 'supplier')";
        $plan_meta_value = "('standard')";
    } 
    elseif ($user_type == 'restaurant' && in_array($subscription_plan, ['advanced'])) {
        $user_meta_value = "('farmer', 'supplier')";
        $plan_meta_value = "('standard', 'advanced')";
    } 
    elseif ($user_type == 'restaurant' && in_array($subscription_plan, ['premium'])) {
        $user_meta_value = "('farmer', 'supplier')";
        $plan_meta_value = "('standard', 'advanced', 'premium')";
    } 
   
    

    if (isset($user_meta_value)) {
       // $query = $wpdb->prepare($base_query, $subscription_plan, $user_meta_value);
        $base_query = "
        SELECT pm1.user_id
        FROM {$wpdb->usermeta} AS pm1
        INNER JOIN {$wpdb->usermeta} AS pm2 ON pm1.user_id = pm2.user_id
        WHERE pm1.meta_key = 'user_type'
        AND pm2.meta_key = 'subscription_plan'
        AND pm1.meta_value IN $user_meta_value 
        AND pm2.meta_value IN $plan_meta_value 
    ";
        // $same_subscription_plan_user_ids = $wpdb->get_col($query);
        $query = $wpdb->prepare($base_query, $subscription_plan);
        $same_subscription_plan_user_ids = $wpdb->get_col($query);

      
    //    var_dump($query);
    }

    return $same_subscription_plan_user_ids;
}
?>
