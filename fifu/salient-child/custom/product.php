<?php
include "notification-trait.php";

class ProductManage
{

    use NotificationTrait;

    function __construct()
    {
        $variable = array('add_update_product', 'delete_product', 'add_tags', 'delete_tags', 'add_category', 'delete_category', 'featured_product', 'update_order_status', 'get_users_by_type');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

       add_action( 'woocommerce_after_add_to_cart_form',  array( $this, 'show_profile' ));

    }


    function show_profile() {
        // Get the current post object
        $current_post = get_post(get_the_ID());
        
        if (!$current_post) {
            return;
        }
    
        // Get the post author's ID
        $author_id = $current_post->post_author;
        
        // Get the author's display name
        $author_name = get_the_author_meta('display_name', $author_id);
        
        // Construct the link to the store profile
        $profile_link = esc_url(home_url('store-profile/?id=' . $author_id));
        
        // Output the link with the author's name
        echo '<span class="vendor">Vendor: <a href="' . $profile_link . '" target="_blank">' . esc_html($author_name) . '</a></span>';
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
            'role'     => $_POST['user_type']
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

    function update_order_status() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
        $new_status = isset($_POST['new_status']) ? sanitize_text_field($_POST['new_status']) : '';
        $user_id = intval($_POST['user_id']);


    
        if ( ! $order_id || ! $new_status ) {
            wp_send_json_error( array( 'message' => 'Invalid request.' ) );
        }
    
        $order = wc_get_order( $order_id );
        
        if ( ! $order ) {
            wp_send_json_error( array( 'message' => 'Order not found.' ) );
        }
    
        $order->update_status( $new_status );
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
        $notification_title = 'Order #'.$order_id;
        $notification_content = '<p>Your order status has been updated on '. date("l jS \of F Y ") .'</p>';
        $notification = $this->push_notifications($notification_title , $notification_content, $user_id);
        if($notification["success"] == true){
            // Add custom field for read/unread status
            add_post_meta($notification["post_id"], 'notification_status', 'unread');
            add_post_meta($notification["post_id"], 'user_id', $user_id);
        }
    
        wp_send_json_success( array( 'message' => 'Order status updated successfully.' ) );
    }
    

    function add_update_product(){
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
      

        $product = new WC_Product_Simple();
        if(!empty($_POST['product_id'])){
            $product = wc_get_product( $_POST['product_id'] );
        }

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

        $product->set_name( $_POST['product_title'] );
        $product->set_regular_price(  $_POST['regular_price']   );
        $product->set_sale_price( isset($_POST['sale_price']) ? $_POST['sale_price'] : '' );
        $product->set_sku( isset($_POST['sku']) ? $_POST['sku'] : ''  ); 
        $product->set_short_description( isset($_POST['short_desc']) ? $_POST['short_desc'] : ''  );
        $product->set_description( isset($_POST['long_desc']) ? $_POST['long_desc'] : ''  );
        $product->set_category_ids( isset($_POST['categories']) ? $_POST['categories'] : [] );
        $product->set_tag_ids(  isset($_POST['tags']) ? $_POST['tags'] : []  );
        $product->set_status(   $_POST['post_status']   );
       
        //Stock Management
        // if(isset($_POST['stock_management']) && $_POST['stock_management'] == 'checked'){
            $product->set_manage_stock( true ); // Enable stock management

            $stock_quantity = isset($_POST['total_quantity']) ? intval($_POST['total_quantity']) : 0;
            $product->set_stock_quantity($stock_quantity); // Set stock quantity if provided, else set to 0
 
            $product->set_backorders( $_POST['_backorders'] ); // Set backorders option
        // } else {
        //     $product->set_manage_stock( false ); // Disable stock management
        //     $product->set_stock_status( $_POST['stock_status'] );  // Set stock status
        // }

      
        // that's going to be an array of attributes we add to a product programmatically

        $attr_names = isset($_POST['attr_name']) ? $_POST['attr_name'] : [];
        $attr_vals = isset($_POST['attr_val']) ? $_POST['attr_val'] : [];
        $multiple_attributes = [];
        $attributes = [];
      
        if(!empty($attr_names)){
            // add the attribute
            foreach ($attr_names as $index => $name) {
                $values = explode('|', $attr_vals[$index]);
                $multiple_attributes[] = [
                    'name' => $name,
                    'options' => $values,
                    'position' => $index,
                    'visible' => true,
                    'variation' => true,
                ];
            }

                 
            foreach ($multiple_attributes as $attr) {
                $attribute = new WC_Product_Attribute();
                $attribute->set_name($attr['name']);
                $attribute->set_options($attr['options']);
                $attribute->set_position($attr['position']);
                $attribute->set_visible($attr['visible']);
                $attribute->set_variation($attr['variation']);
                $attributes[] = $attribute;
            }

            $product->set_attributes( $attributes );

        }

      
        $gallery_image_ids = [];
        if(isset($_FILES["product_gallery"])){
            $product_gallery = $_FILES['product_gallery'];
          

            foreach ($product_gallery['name'] as $key => $value) {
                if ($product_gallery['name'][$key]) {
                    $file = array(
                        'name' => $product_gallery['name'][$key],
                        'type' => $product_gallery['type'][$key],
                        'tmp_name' => $product_gallery['tmp_name'][$key],
                        'error' => $product_gallery['error'][$key],
                        'size' => $product_gallery['size'][$key]
                    );
                    
                    $upload_result = $this->uploadImage($file);
                   
                    if ($upload_result['success']) {
                        $gallery_image_ids[] = $upload_result['attach_id'];
                        $product->set_gallery_image_ids(  $gallery_image_ids );

                    }
                }
            }
        }


        if (isset($_FILES["featured_image"])) {
            $featured_image = $_FILES["featured_image"];
                // User is uploading a new image
                if ($featured_image['size'] != 0) {
                    $res = $this->uploadImage($featured_image);
                    if ($res["success"]) {
                        $product->set_image_id($res['attach_id']);
                    }
                }
        }else{
           
            // User is trying to remove the existing image
            $product->set_image_id('');
        }
          

        $product->save();
        $product_id = $product->get_id(); // Get the product ID after saving
        update_post_meta($product_id, 'stock_type', $_POST['stock_type']);
        $selected_user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

        if (current_user_can('administrator')) {
            wp_update_post(array(
                'ID' => $product_id,
                'post_author' => $selected_user_id
            ));
            // $user_type = get_user_meta($selected_user_id, 'user_type', true);
            // $subscription_plan = get_user_meta($selected_user_id, 'subscription_plan', true);
            // update_post_meta($product_id, 'user_type', $user_type);
            // update_post_meta($product_id, 'subscription_plan', $subscription_plan);
           
        } 
        // else {
        //     $current_user = wp_get_current_user();
        //     $user_type = get_user_meta($current_user->ID, 'user_type', true);
        //     $subscription_plan = get_user_meta($current_user->ID, 'subscription_plan', true);
        //     update_post_meta($product_id, 'user_type', $user_type);
        //     update_post_meta($product_id, 'subscription_plan', $subscription_plan);
        // }
       
      
       // exit;

        

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
            $response['redirect_url'] = home_url('product');
        }
        
        return $this->response_json($response);
    }

    function featured_product() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        
        $current_date = date("Y-m-d");
        $start_featured_date = get_user_meta(get_current_user_id(), 'start_featured_date', true);
        $end_featured_date = get_user_meta(get_current_user_id(), 'end_featured_date', true);

        $current_timestamp = strtotime($current_date);
        $start_featured_timestamp = strtotime($start_featured_date);
        $end_featured_timestamp = strtotime($end_featured_date);

        if ($current_timestamp >= $start_featured_timestamp && $current_timestamp <= $end_featured_timestamp) {
            if($_POST['status'] == 'checked') {
                update_post_meta($_POST['product_id'], 'featured_product', 'true');
                $response['status'] = true;
                $response['message'] = "Product is featured";

            } else {
                update_post_meta($_POST['product_id'], 'featured_product', 'false');
                $response['status'] = true;
                $response['message'] = "Product is remove from featured";

            } 
        } else {
            $response['status'] = false;
            $response['message'] = "You are not able to featured products";
        }
        return $this->response_json($response);

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

    function add_category() {
        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}
        if (empty($_POST['category'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "Please fill required field!";
            $response['status'] = false;
            return $this->response_json($response);
        }
        // If the category exist,
        if (term_exists($_POST['category'], $_POST['cat_type'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "Category already exists!";
            $response['status'] = false;
            return $this->response_json($response);

        }

        // Get the term object by name
        $category = get_term_by( 'name', $_POST['old_cat'], 'product_cat'); 
        // var_dump($_POST['old_cat']);
        // var_dump($category);
        // exit;

        if ( $category ) {
            $category_id = $category->term_id;
            $term = wp_update_term($category_id, 'product_cat', array(
                'name' => $_POST['category'],
            ) );
            $message = "Category updated successfully!";
        } else {
            $term = wp_insert_term($_POST['category'], 'product_cat');
            $message = "Category added successfully!";
        }

        if (is_wp_error($term)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = $term->get_error_message();
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = $message;
            $response['status'] = true;
            $response['auto_redirect'] = true;
            $response['redirect_url'] = home_url('category-list/');
        }
           
        return $this->response_json($response);
    }

    function delete_category() {
        if(!is_user_logged_in()){
		
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

        if (empty($_POST['cat_id'])) {
            $response['status'] = false;
            $response['title'] = "Error";
            $response['message'] = "This category are not found.";
            return $this->response_json($response);
        }

        $result = wp_delete_term( $_POST['cat_id'], 'product_cat' ); 

        if ( is_wp_error( $result ) ) {
            $response['message'] = $result->get_error_message();
            $response['status'] = false;
            $response['title'] = "Error";
        }
        else {
            $response['message'] = "Deleted Succesfully";
            $response['status'] = true;
        }
        return $this->response_json($response);

    }

    function response_json($response){
        echo json_encode($response);
        wp_die();
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
new ProductManage();