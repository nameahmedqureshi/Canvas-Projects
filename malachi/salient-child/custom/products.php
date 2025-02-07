<?php
include "notification-trait.php";
class ProductManage
{
    use NotificationTrait;
    function __construct()
    {
        $variable = [
            'get_users_by_type',
            'add_update_product',
            'add_tags',
            'delete_tags',  
            'delete_product', 
            'update_order_status', 
            'update_order_status_by_customer', 
            'delete_pro_category', 
            'sponsered_product',
            'product_filter',
            'add_custom_comment'
        ];
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }
    }

   
    public function product_filter(){
        // var_dump($_POST['search_filters']);
        // exit;
        $paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
        $product_type = isset($_POST['search_filters']['product_type'][0]) ? $_POST['search_filters']['product_type'][0] : '';    
        $category = isset($_POST['search_filters']['category'][0]) ? $_POST['search_filters']['category'][0] : [];
        $search_filters = isset($_POST['search_filters']) ? $_POST['search_filters'] : [];    
        set_query_var('paged', $paged);
   
        if ($product_type) {
            $product_type =  [
            'relation' => 'AND',
                [
                    'key'     => 'product_type',
                    'value'   => $product_type,
                    'compare' => '=',
                ]
            ];
        }

        if( !empty($search_filters['rating']) ){
            $rating =  [
                [
                    'key'     => '_wc_average_rating',
                    'value'   => $search_filters['rating'],
                    'compare' => '=',
                    'type'    => 'NUMERIC'
                ]
            ];
        }

        // $search_filters_keys = ['country', 'state', 'city', 'zip_code'];
        // $searchByLocation = [];
        // foreach ($search_filters_keys as $key) {
        //     if (!empty($search_filters[$key])) {
        //         $searchByLocation = [
        //             'key'     => $key,
        //             'value'   => $search_filters[$key],
        //             'compare' => '=',
        //         ];
        //     } 
        // }

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 36,
            'post_status'    => 'publish',
            'paged'          => $paged,
            'meta_query'     => [
                // 'relation' => 'OR',
                // [
                //     'key'     => 'sponsored',
                //     'value'   => 'active',
                //     'compare' => '=',
                // ],
                // [
                //     'key'     => 'sponsored',
                //     'compare' => 'NOT EXISTS', // Includes products without the 'sponsored' meta key
                // ],
                $product_type,
                $rating,
                // $searchByLocation,
               
            ],
            'orderby'  => [
                'meta_value' => 'ASC',  // Orders sponsored products first
                'date'       => 'DESC',  // Orders by date within each group
            ],
            'meta_key' => 'sponsored',  // Required for 'meta_value' ordering
        );

        if(isset($_POST['parent_cat']) || !empty($category)) {
            $parent_cat = !empty($category) ? $category : $_POST['parent_cat'];
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $parent_cat,
                    'operator' => 'IN',
                ],
            ];
        }

        if(isset($_POST['store_profile_id'])){
            $args['author'] =  $_POST['store_profile_id'];
        }
        
       
        $products_query = new WP_Query($args);
        // var_dump($products_query->found_posts);
        // exit;
        $html = '';
        $paginationhtml = '';
        $foundResults = $products_query->found_posts;
        if ($products_query->have_posts()) {
            while ($products_query->have_posts()) {
                $products_query->the_post();
                $product = wc_get_product(get_the_ID());
                // Get product price
                $price = $product->get_price_html();
                // Get average rating and number of reviews
                $average_rating = $product->get_average_rating();
                $review_count = $product->get_review_count();               
                $product_image = has_post_thumbnail() ? get_the_post_thumbnail(null, 'medium') : "<img src='https://devu13.testdevlink.net/grown/wp-content/uploads/woocommerce-placeholder.png'>";
                $sponsored =  get_post_meta(get_the_ID(), 'sponsored', true);
                $author_id = get_post_field('post_author', $product->get_id()); // Get the author ID
                // $author_name = get_the_author_meta('display_name', $author_id); // Get the author's display name
                $author_name = get_user_meta($author_id, 'store_details', true);
                $shopname = !empty($author_name['store_name']) ? $author_name['store_name'] : "---";
                $product_type =  get_post_meta(get_the_ID(), 'product_type', true);

                // var_dump($author_name["store_name"]);
                // var_dump($shopname);

                $categories = wc_get_product_category_list($product->get_id());
                $html .= '<a href="' . get_permalink() . '" class="info__block">';
                    if($sponsored == 'active'){ 
                        $html .= '<div class="sponsored">
                            <p>HOT</p>
                        </div>';
                    }
                    $html .= '<div class="info__block_img_block">
                         '. $product_image .'
                    </div>
                    <div class="info__block_txt_block">
                     <small class="product_type">'.$product_type.'</small>
                        <h3>' . get_the_title() . '</h3>
                        <div class="p-desc">' . substr(wp_strip_all_tags(get_the_excerpt()), 0, 50) . '</div>
                        <div class="grid_seprator">
                            <h4>' . $price . '</h4>
                        </div>
                        <p class="author"> Shop: <span class="author-link" data-author='. home_url('store-profile?id=' . $author_id). '>'  . $shopname .  '</span></p>
                        <div class="rating_stars">
                            <ul>';
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $average_rating) {
                                        $html .= '<li><i class="fa-solid fa-star"></i></li>';
                                    } else {
                                        $html .= '<li><i class="fa-solid fa-star-half-stroke"></i></li>';
                                    }
                                }
                                $html .= '<li><p>' . $review_count . ' Reviews</p></li>
                            </ul>
                        </div>
                    </div>
                </a>';
            }
            $paginationhtml .= 
            paginate_links(array(
                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(1))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $products_query->max_num_pages,
                'prev_text' => __('« Previous'),
                'next_text' => __('Next »'),
            ));
            wp_reset_postdata(); // Restore original post data
        }
        else {
			$html = '<p class="p_not_found">No products found</p>';
		}
        $response['status'] = true;
		$response['html'] = $html;	
		$response['foundResults'] = $foundResults;	
		$response['pagination'] = $paginationhtml;	
		return $this->response_json($response);
    }

    public function add_custom_comment() {
        if(empty($_POST['name']) || empty($_POST['comment'])){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "PLease Fill Required Field";
            return $this->response_json($response);
        }
        $commentdata = array(
            'comment_post_ID'      => $_POST['post_id'],
            'comment_author'       => $_POST['name'], // Name of the comment author
            'comment_author_email' => 'test@test.com', // Email of the comment author
            'comment_author_url'   => 'http://example.com', // URL of the comment author
            'comment_content'      => $_POST['comment'], // Content of the comment
            'comment_type'         => '', // Type of comment (empty string for standard comment)
            'comment_parent'       => 0, // ID of the parent comment if this is a reply
            'user_id'              => 0, // ID of the user (0 if not logged in)
            'comment_approved'     => 1, // Whether the comment is approved (1 for approved, 0 for not approved)
        );
        //   var_dump($commentdata);
        //  exit;
        // Insert the comment and retrieve the new comment ID
        $comment_id = wp_insert_comment($commentdata);
        if($comment_id){
            update_comment_meta( $comment_id, 'rating', $_POST['rating'] );
            $image_ids = [];
            if (!isset($_FILES['review_image'])) return;
            foreach ($_FILES['review_image']['name'] as $key => $value) {
                if ($value !== '') {
                    $file = $this->get_file_data($_FILES['review_image'], $key);
                    $upload_result = $this->uploadImage($file);
                    if ($upload_result['success']) {
                        $image_ids[] = $upload_result['attach_id'];
                    }
                }
            }
            update_comment_meta( $comment_id, 'review_images',  $image_ids );
        }
        if (is_wp_error($comment_id)) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
        } else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Comment added successfully!";
            $response['status'] = true;
            // $response['post_id'] = $_POST['post_id'];
            $response['auto_redirect'] = true;
            $response['redirect_url'] = $_POST['redirect_url'];
        }
        return $this->response_json($response);
    }

    function get_users_by_type() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        $users_arg = new WP_User_Query( array(
            'role'     => 'vendor'
        ) );
        $get_users = $users_arg->get_results();
        $users = "";
        if ( !empty( $get_users ) ) {
            foreach ( $get_users as $user ) { 
                $users .= '<option value="'. $user->ID .'" >'. $user->display_name .'</option>';
        } } 
        $response = [
            'status' => true,
            'usersHtml' => $users,
        ];
        return $this->response_json($response);
    }

    function sponsered_product(){
        if (!is_user_logged_in()) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        if (empty($_POST['product_id']) ||  empty($_POST['stripeToken'])) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Some fields missing, Please try again";
            return $this->response_json($response);
        } 
        $token = $_POST['stripeToken'];
        $current_user_id = get_current_user_id();
        $test_credentials = get_field('test_credentials', 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        if (empty($secret_key)) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Admin stripe details missing";
            return $this->response_json($response);
        }
        $stripe = new \Stripe\StripeClient($secret_key);
        try {
            $charge = $stripe->charges->create([
                'amount' => 10 * 100, // Amount in cents, adjust as needed
                'currency' => 'usd',
                'source' => $token,
                'description' => 'Sponsored Product'
            ]);
            if ($charge->status == "succeeded") {
                update_post_meta($_POST['product_id'], 'sponsored_start_date', date('Y-m-d'));
                update_post_meta($_POST['product_id'], 'sponsored_end_date', date('Y-m-d', strtotime('+1 day')));
                update_post_meta($_POST['product_id'], 'sponsored', 'active');
                $response['title'] = "Success";
                $response['message'] = "Your product is sponsored!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = home_url('all-products/?type='.$_POST['product_type']);
            } else {
                throw new Exception("Payment failed.");
            }
        }
        catch (Exception $e) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $this->response_json($response);
    }

    function add_update_product(){

        // var_dump($_POST['availability']);
        // if (!isset($_POST['stock_management']) ) {
        //     var_dump('not set');
        // } else {
        //     var_dump('set');

        // }
        // exit;
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        // var_dump($_POST);
        // exit;
        $product = !empty($_POST['product_id']) ? wc_get_product($_POST['product_id']) : new WC_Product_Simple();
        $new_product = empty($_POST['product_id']);
        if( empty( $_POST['product_title'] ) || empty( $_POST['regular_price'] ) ){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please fill required fields";
            return $this->response_json($response);
        }
        if (current_user_can('administrator')) {
            if( empty( $_POST['user_type'] ) ){
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Please select user";
                return $this->response_json($response);
            }
        }
        $this->set_product_data($product);
        $this->handle_stock_management($product);
        $this->handle_product_attributes($product);
        $gallery_images = $this->handle_gallery_images($product);
        // var_dump($gallery_images);
        // exit;
        $this->handle_featured_image($product);
        $product->save();
        $product_id = $product->get_id(); // Get the product ID after saving
        $this->handle_stl_files($product_id);   
        update_post_meta($product_id, 'product_type', $_POST['product_type']);
        update_post_meta($product_id, 'customer_says', $_POST['customer_says']);
        update_post_meta($product_id, 'state', $_POST['state']);
        update_post_meta($product_id, 'city', $_POST['city']);
        update_post_meta($product_id, 'zip_code', $_POST['zip_code']);
        update_post_meta($product_id, 'availability', $_POST['availability']);
        $selected_user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
        if (current_user_can('administrator')) {
            wp_update_post(array(
                'ID' => $product_id,
                'post_author' => $selected_user_id
            ));
        } 
        //Push Notification
        $this->send_push_notifications($product_id, $new_product);
        if (is_wp_error($product)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $product->get_error_message();
        } else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Product published successfully!";
            $response['auto_redirect'] = true;
            $response['status'] = true;
            $response['redirect_url'] = home_url('all-products?type='.$_POST['product_type']);
        }
        return $this->response_json($response);
    }
    private function set_product_data($product) {
        $product->set_name($_POST['product_title']);
        $product->set_regular_price($_POST['regular_price']);
        $product->set_sale_price($_POST['sale_price'] ?? '');
        // $product->set_sku($_POST['sku'] ?? '');
        $product->set_short_description($_POST['short_desc'] ?? '');
        $product->set_description($_POST['long_desc'] ?? '');
        $product->set_category_ids($_POST['categories'] ?? []);
        $product->set_tag_ids($_POST['tags'] ?? []);
        $product->set_status('publish');
    }
    private function handle_stock_management($product) {
        if (!isset($_POST['stock_management']) ) {
            if(isset($_POST['stock_status']) && $_POST['stock_status'] === 'made_to_order'){
                $product->set_manage_stock(false);
                $product->set_stock_quantity(0);
                $product->set_stock_status('instock');
                $product->set_backorders($_POST['_backorders']);
                update_post_meta($product->get_id(), 'made_to_order', 'made_to_order');

            } 
            else {
                $product->set_manage_stock(false);
                $product->set_stock_status($_POST['stock_status']);
                $product->set_stock_quantity(intval($_POST['total_quantity'] ?? 0));
                $product->set_backorders($_POST['_backorders']);
                update_post_meta($product->get_id(), 'made_to_order', $_POST['stock_status']);

            } 
           
        } else {
            $product->set_manage_stock(true);
            $product->set_stock_quantity(intval($_POST['total_quantity'] ?? 0));
            // $product->set_backorders($_POST['_backorders']);
            delete_post_meta($product->get_id(), 'made_to_order', true);

        }
      
    }
    private function handle_product_attributes($product) {
        if (empty($_POST['attr_name'])) return;
        $attributes = [];
        foreach ($_POST['attr_name'] as $index => $name) {
            $attribute = new WC_Product_Attribute();
            $attribute->set_name($name);
            $attribute->set_options(explode('|', $_POST['attr_val'][$index]));
            $attribute->set_position($index);
            $attribute->set_visible(true);
            $attribute->set_variation(true);
            $attributes[] = $attribute;
        }
        $product->set_attributes($attributes);
    }
    function handle_gallery_images($product) {
        $gallery_image_ids = $product->get_gallery_image_ids();
        if (!isset($_FILES['product_gallery'])) return;
        foreach ($_FILES['product_gallery']['name'] as $key => $value) {
            if ($value !== '') {
                $file = $this->get_file_data($_FILES['product_gallery'], $key);
                $upload_result = $this->uploadImage($file);
                if ($upload_result['success']) {
                    $gallery_image_ids[] = $upload_result['attach_id'];
                }
            }
        }
        $product->set_gallery_image_ids($gallery_image_ids);
        return $gallery_image_ids;
    }
    private function handle_featured_image($product) {
        if (isset($_FILES["featured_image"]) && $_FILES["featured_image"]["name"] !== '') {
            $upload_result = $this->uploadImage($_FILES["featured_image"]);
            if ($upload_result["success"]) $product->set_image_id($upload_result['attach_id']);
        } elseif ($product->get_image_id()) {
            $product->set_image_id($product->get_image_id());
        } else {
            $product->set_image_id('');
        }
    }
    private function handle_stl_files($product_id) {
        $stl_ids = get_post_meta($product_id, 'stl_files', true);
        $stl_ids = is_array($stl_ids) ? $stl_ids : [];
        if (!isset($_FILES["stl_gallery"])) return;
        foreach ($_FILES['stl_gallery']['name'] as $key => $value) {
            if ($value !== '') {
                $file = $this->get_file_data($_FILES['stl_gallery'], $key);
                $upload_result = $this->uploadImage($file);
                if ($upload_result['success']) $stl_ids[] = $upload_result['attach_id'];
            }
        }
        update_post_meta($product_id, 'stl_files', $stl_ids);
    }
    private function get_file_data($file_array, $key) {
        return [
            'name' => $file_array['name'][$key],
            'type' => $file_array['type'][$key],
            'tmp_name' => $file_array['tmp_name'][$key],
            'error' => $file_array['error'][$key],
            'size' => $file_array['size'][$key]
        ];
    }
    private function send_push_notifications($product_id, $new_product) {
        if (!$new_product) return;
        $customers = new WP_User_Query(['role' => 'customer']);
        foreach ($customers->get_results() as $user) {
            $notification = $this->push_notifications(
                'New Product Live',
                'A new product is live. Explore its features now and be the first to try it out today!',
                $user->ID
            );
            if ($notification["success"]) {
                add_post_meta($notification["post_id"], 'notification_status', 'unread');
                add_post_meta($notification["post_id"], 'user_id', $user->ID);
                add_post_meta($notification["post_id"], 'product_link', get_permalink($product_id));
            }
        }
    }
    function delete_product() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        if (empty($_POST['product_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Product not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['product_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "Product not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Product deleted";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }
    function update_order_status() {
        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $new_status = isset($_POST['new_status']) ? sanitize_text_field($_POST['new_status']) : '';
        if ( ! $order_id || ! $new_status ) {
            wp_send_json_error( array( 'message' => 'Invalid request.' ) );
        }
        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            wp_send_json_error( array( 'message' => 'Order not found.' ) );
        }
        $order->update_status( $new_status );
        update_post_meta($order_id, 'order_completed', date('d-m-Y'));
        global $wpdb;
        $query = $wpdb->prepare(
            'UPDATE wp_wc_orders AS o
             INNER JOIN wp_wc_orders_meta AS om
             ON o.id = om.order_id
             SET o.status = %s
             WHERE om.meta_key = "partial_order_id"
             AND om.meta_value = %d',
            $new_status,
            $order_id
        );
        $wpdb->query($query);
        //Push Notification
        $notification_title = 'Product Order #'.$order_id;
        $notification_content = '<p>Your product order status has been updated to '. $new_status .' on '. date("l jS \of F Y ") .'</p>';
        $notification = $this->push_notifications($notification_title , $notification_content, $_POST['customer_id']);
        if($notification["success"] == true){
            // Add custom field for read/unread status
            add_post_meta($notification["post_id"], 'notification_status', 'unread');
            add_post_meta($notification["post_id"], 'user_id', $_POST['customer_id']);
        }
        wp_send_json_success( array( 'message' => 'Order status updated successfully.' ) );
    }
    function update_order_status_by_customer(){
        if(!is_user_logged_in()){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		} 
        if (empty($_POST['order_id'])) {
            $response['title'] = "Error";
            $response['message'] = "Order not found!";
            $response['status'] = false;
            return $this->response_json($response);
        }
        update_post_meta($_POST['order_id'], 'customer_order_status', $_POST['customer_order_status']);
        $response['title'] = "Success";
        $response['message'] = "Order status updated!";
        $response['status'] = true;
        $response['customer_order_status'] = 'Received';
        return $this->response_json($response);
    }
    function add_tags(){
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}
        if (empty($_POST['tags'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "Please fill required field!";
            $response['status'] = false;
            return $this->response_json($response);
        }
        // Check if the tag already exists
        if (term_exists($_POST['tags'], 'product_tag')) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "Tag already exists!";
            $response['status'] = false;
            return $this->response_json($response);
        }
        $tag = get_term_by( 'name', $_POST['old_tag'], 'product_tag' ); 
        if ( $tag ) {
            $tag_id = $tag->term_id;
            $term = wp_update_term($tag_id, 'product_tag', array(
                'name' => $_POST['tags'],
            ) );
            $message = "Tag updated successfully!";
        } else {
            $term = wp_insert_term($_POST['tags'], 'product_tag');
            $message = "Tag added successfully!";
        }
        if (is_wp_error($term)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = $term->get_error_message();;
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] =  $message;
            $response['status'] = true;
            $response['auto_redirect'] = true;
            $response['redirect_url'] = home_url('tags-list/');
        }
        return $this->response_json($response);
    }
    function delete_pro_category() {
        if (!is_user_logged_in()) {
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        if (empty($_POST['cat_id'])) {
            $response['status'] = false;
            $response['message'] = "This category are not found.";
            return $this->response_json($response);
        }
        if (empty($_POST['cat_type'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "Category type not defined!";
            $response['status'] = false;
            return $this->response_json($response);
        }
        $result = wp_delete_term( $_POST['cat_id'], $_POST['cat_type'] ); 
        if ( is_wp_error( $result ) ) {
            $response['message'] = $result->get_error_message();
            $response['status'] = false;
        }
        else {
            $response['message'] = "Deleted Succesfully";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }
    function delete_tags(){
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}
        if (empty($_POST['tag_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Tag not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_term( $_POST['tag_id'], 'product_tag' ); 
        if ( is_wp_error( $result ) ) {
            $response['message'] = $result->get_error_message();
            $response['status'] = false;
        }
        else {
            $response['message'] = "Deleted Succesfully";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }
    function response_json($response) {
        echo json_encode($response);
        wp_die();
    }
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
        // return $all_products;
    }
    function uploadImage($file) {
        // fetch uploaded image
        $image = $file['tmp_name'];
        $filename = $file['name'];
        $upload_file = wp_upload_bits($filename, null, file_get_contents($image));
        if (!$upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null);
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment($attachment, $upload_file['file']);
            if (!is_wp_error($attachment_id)) {
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
                wp_update_attachment_metadata($attachment_id,  $attachment_data);
                return array(
                    'success' => true,
                    'url' => $upload_file['url'],
                    'attach_id' => $attachment_id
                );
            }
        } else {
            //send upload error 
            return array(
                'success' => false,
                'msg' => $upload_file['error']
            );
        }
    }
}
$ProductManage = new ProductManage();
