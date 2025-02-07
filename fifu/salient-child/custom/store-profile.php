<?php
class StoreProfile {

    function __construct() {
        $variable = array('get_products_by_page', 'send_feedback', 'product_listing', 'review_status_update');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_feedback_posttype');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function product_listing() {
        if (!is_user_logged_in()) {
            return $this->response_json([
                'icon' => 'error',
                'title' => 'Error',
                'status' => false,
                'message' => "You're session is expired! Please Login",
            ]);
        }
    
        $current_user = wp_get_current_user();
        $user_type = get_user_meta($current_user->ID, 'user_type', true);
        $subscription_plan = get_user_meta($current_user->ID, 'subscription_plan', true);
        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    
        $farmer_args = $this->get_product_query_args('farmer', $subscription_plan, $paged);
        $farmer_products = new WP_Query($farmer_args);
    
        $supplier_products = null;
        if ($user_type == 'restaurant') {
            $supplier_args = $this->get_product_query_args('supplier', $subscription_plan, $paged);
            $supplier_products = new WP_Query($supplier_args);
        }
    
        $response = [
            'status' => true,
            'farmershtml' => $this->generate_product_html($farmer_products),
            'farmers_pagination_html' => $this->generate_pagination_html($farmer_products, $paged),
            'suppliershtml' => $supplier_products ? $this->generate_product_html($supplier_products) : '',
            'suppliers_pagination_html' => $supplier_products ? $this->generate_pagination_html($supplier_products, $paged) : '',
        ];
    
        return $this->response_json($response);
    }
    
    function get_product_query_args($user_type, $subscription_plan, $paged) {
        $subscription_key = $subscription_plan === 'standard' ? 'standard' : ($subscription_plan === 'advanced' ? 'advanced' : 'premium');
        return [
            'post_type' => 'product',
            'posts_per_page' => 30,
            'post_status' => 'publish',
            'paged' => $paged,
            'meta_query' => [
                'relation' => 'AND',
                ['key' => 'user_type', 'value' => $user_type, 'compare' => '='],
                ['key' => 'subscription_plan', 'value' => $subscription_key, 'compare' => '='],
            ],
        ];
    }
    
    function generate_product_html($query) {
        if (!$query->have_posts()) {
            return '<p class="no-result">No Products Found</p>';
        }
    
        $html = '';
        foreach ($query->posts as $post) {
            $product = wc_get_product($post->ID);
            $product_image = wp_get_attachment_url($product->get_image_id());
            $author_id = $product->get_post_data()->post_author;
            $author_name = get_user_meta($author_id, 'first_name', true);
    
            $html .= '
            <div class="col span_3">
                <div class="item_box">
                    <img src="' . $product_image . '" alt="">
                    <h4>' . get_the_title($post->ID ) . '</h4>
                    <p>' . $product->get_short_description() .'</p>
                    <p class="price">€<span>' . $product->get_regular_price() . '</span></p>
                    <a href="' . site_url('store-profile?id=' . $author_id) . '" target="_blank" class="btn btn-primary">Author: ' . $author_name . '</a><br>
                    <a href="' . get_permalink($post->ID) . '" class="btn btn-primary">View Product</a>
                </div>
            </div>';
        }
    
        return $html;
    }
    
    function generate_pagination_html($query, $paged) {
        return paginate_links([
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '?paged=%#%',
            'current' => $paged,
            'total' => $query->max_num_pages,
            'prev_text' => __('« Previous'),
            'next_text' => __('Next »'),
        ]);
    }
    

    function get_products_by_page() {

        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired! Please Login";
			return $this->response_json($response);
		}
       
        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $search = isset($_POST['search']) ? $_POST['search'] : '';

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 1,
            'post_status'=> 'publish',
            'author' => $_POST['user_id'], 
            'paged'=> $paged,
            's' => $search,
        );
        $get_products = new WP_Query( $args );

        $products_html = "";
        $paginationhtml = "";


        if ($get_products->have_posts()) {
            $products_html .= '<div class="woocommerce columns-4 ss">
            <div class="woocommerce-notices-wrapper"></div>
                <ul class="products columns-4" data-n-lazy="off" data-rm-m-hover="off" data-n-desktop-columns="4" data-n-desktop-small-columns="3" data-n-tablet-columns="default" data-n-phone-columns="default" data-product-style="classic">';
            while ($get_products->have_posts()) {
                $get_products->the_post();
                wc_get_template_part('content', 'product');
            }
            $products_html .= '</ul></div>';
            wp_reset_postdata();

            $paginationhtml .=  paginate_links( array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => '?paged=%#%',
                'current' => $paged,
                'total' => $get_products->max_num_pages,
                'prev_text' => __('« Previous'),
                'next_text' => __('Next »'),
            )); 
        } else {
            $response['status'] = false;
            $products_html = '<p>No product found.</p>';
        }
        
        $response['status'] = true;
		$response['producthtml'] = $products_html;
		$response['paginationhtml'] = $paginationhtml;

        return $this->response_json($response);
    }

    function send_feedback() {

        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired! Please Login";
			return $this->response_json($response);
		}

        if ( empty($_POST['comment']) || empty($_POST['rate'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please rate and review";
            return $this->response_json($response);
        }

        // var_dump($_POST);
        // exit;
        $post_data = array(
			'post_title'   => rand(0,1000),
			'post_content' => $_POST['comment'],
			'post_status'  => 'draft', 
			'post_type'    => 'feedbacks',
			'post_author'	   => $_POST['user_id'],
		);
       
        $post_id = wp_insert_post($post_data);
        if($post_id){
            update_post_meta($post_id, 'rating', $_POST['rate']);
        }
       

        if (is_wp_error($post_id)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Try again, something's amiss!";
        
        } else {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = "Thank you for your feedback!";
                $response['status'] = true;
        }

        return $this->response_json($response);
    }

    
    public function review_status_update(){

        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        $result =  wp_update_post(array(
            'ID' => $_POST['post_id'],
            'post_status' => 'publish'
        ));
       
        if(!$result){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Try again, something's amiss!";
        }else{
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Review approved";
            $response['review_status'] = "Approved";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function register_feedback_posttype(){
        register_post_type('feedbacks',
			array(
				'labels'      => array(
					'name'          => __('Feedback', 'textdomain'),
					'singular_name' => __('Feedback', 'textdomain'),
				),
					'public'      => true,
					'has_archive' => true,
					'supports' => array('title','editor', 'comments'),
			)
		);
    }

    function response_json($response){
		echo json_encode($response);
		wp_die(); 
	}

}
new StoreProfile();