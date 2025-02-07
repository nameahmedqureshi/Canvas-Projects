<?php 
include "notification-trait.php";
class ManageServices {
    use NotificationTrait;

    function __construct()
    {
        $variable = array('buy_service', 'add_update_services', 'delete_services', 'update_shipping_status', 'update_status_by_customer', 'add_category', 'delete_category', 'get_selected_category_services');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_services','services_order');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function buy_service() {
        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired! Please Login.";
			
			return $this->response_json($response);
		}

        if (empty($_POST['comment']) || empty($_POST['stripeToken'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }

        $user_id = get_current_user_id();
        $user = new WP_User( $user_id );

        // Retrieve the subscription commission data from options
        $subscription_data = get_option('subscription_data');
        $subscribed_commission = floatval($subscription_data['subscribed_commission']);
        $unsubscribed_commission = floatval($subscription_data['unsubscribed_commission']);

        $post_id = $this->decryptData($_POST['post_id']); 
        $get_post = get_post($post_id);
        $price = get_post_meta($post_id, 'price', true );

        $vendor_user = new WP_User( $get_post->post_author );
        // Check if the vendor is subscribed and apply the relevant commission
        $subscription_status = get_user_meta($vendor_user->ID, 'subscription_status', true);
        $commission_rate = $subscription_status == 'active' ? $subscribed_commission : $unsubscribed_commission;
        // Calculate the commission amount
        $commission_amount = ($commission_rate / 100) * $price;

       
        // $stripe_data = get_user_meta($vendor_user->ID, 'stripe_details', true);
        // $secret_key = $stripe_data['secret_key'];

        $test_credentials = get_field('test_credentials', 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        
   
        if (empty($secret_key)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please add Stripe key";
            return $this->response_json($response);
        }
     
        // Set Stripe secret key
        $token = $_POST['stripeToken'];
        \Stripe\Stripe::setApiKey( $secret_key );

        $charge_params = [
            'amount' => $price * 100, // Amount in cents
            'currency' => 'usd',
            'source' => $token,
            'description' => 'Service Payment'
        ];

        try {
            $charge = \Stripe\Charge::create($charge_params);
            if ($charge->status == "succeeded") {
                $post_data = array(
                    'post_title'   => '#'.$post_id.'-'.rand(10,10000),
                    'post_status'  => 'draft', 
                    'post_type'    => 'services-order',
                    'author'	   => $user_id,
                );
                $new_post_id = wp_insert_post($post_data);


                if (is_wp_error($new_post_id)) {
                    throw new Exception($new_post_id->get_error_message());
                }

                if ($new_post_id) {

                  //  $vendor_service_price = get_post_meta( $get_post->ID,'price',true);
                    update_post_meta($new_post_id,'vendor_id',$vendor_user->ID);
                    update_post_meta($new_post_id,'vendor_name',$vendor_user->display_name);
                    update_post_meta($new_post_id,'service_id',$post_id);
                    update_post_meta($new_post_id,'service_name',$get_post->post_title);
                    update_post_meta($new_post_id,'customer_id',$user->ID);
                    update_post_meta($new_post_id,'customer_name',$user->display_name);
                    update_post_meta($new_post_id,'total_price', $price);
                    update_post_meta($new_post_id,'payment_status', $charge->status);
                    update_post_meta($new_post_id, 'order_date', date('d-m-Y'));
                    update_post_meta($new_post_id, 'type', 'quick');
                    // Save commission 
                    update_post_meta($new_post_id,'commission_rate', $commission_rate. '%');
                    update_post_meta($new_post_id,'commission_amount', $commission_amount);

                    //Push Notification
                    $notification_title = 'Service Order #'.$new_post_id;
                    $notification_content = '<p>New order has been received on '. date("l jS \of F Y ") .'</p>';
                    $notification = $this->push_notifications($notification_title , $notification_content, $vendor_user->ID);
                    if($notification["success"] == true){
                        // Add custom field for read/unread status
                        add_post_meta($notification["post_id"], 'notification_status', 'unread');
                        add_post_meta($notification["post_id"], 'notification_admin_status', 'unread');
                        add_post_meta($notification["post_id"], 'user_id', $vendor_user->ID);
                        add_post_meta($notification["post_id"], 'admin_id', '1');
                    }
                }

                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = "Thank you for buying service!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('service-booking/');
                return $this->response_json($response);
            }
            else {
                throw new Exception("Payment failed.");
            }
        }
        catch(Exception $e) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return $this->response_json($response);
        }

    }


    function add_update_services() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
        // $categories =  array_map('intval', explode(',', $_POST['service_categories']));       
        // var_dump($categories);
       
        // var_dump($_POST);
        //  exit;
        if (current_user_can('administrator')) {

            if( empty( $_POST['user_id'] ) ){
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Please select user";
                return $this->response_json($response);
            }
        }

        if (empty($_POST['service_name']) || empty($_POST['service_price'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }

     
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : get_current_user_id();
        $user = new WP_User( $user_id );
       
        // parse_str($_POST['form_data'], $form_data);
      
     
        $post_data = array(
			'post_title'   => $_POST['service_name'],
			'post_content'   => $_POST['long_desc'],
			'post_status'  => $_POST['service_status'], 
			'post_type'    => 'services',
			'post_author'	   => $user_id,
          //  'tags_input' => $topic_tags,
		);
        // var_dump($post_data);
        // exit;
       
        if(!empty($_POST['post_id'])){
			$post_data['ID'] = $_POST['post_id'];
			$post_id = wp_update_post($post_data);
		} else { 
			$post_id = wp_insert_post($post_data);
		}      

        if($post_id){
          
            update_post_meta($post_id,'user_type',$user->roles[0]);
            update_post_meta($post_id,'vendor',$user->display_name);
            update_post_meta($post_id,'price',$_POST['service_price']);
            // Set the selected category
            if($_POST['service_categories']){
                // $categories = array_map('intval', $_POST['service_categories']);
                $categories =  array_map('intval', explode(',', $_POST['service_categories']));       

                wp_set_object_terms($post_id, $categories , 'services-category');
            }

            if(isset($_FILES["service_image"])){
               
				$featured_image = $_FILES["service_image"];
				// set post thumnail for the post
				if($featured_image['size'] != 0) {
					$res = $this->uploadImage($featured_image);
					if($res["success"]) {
						$post_featured_image = $res['attach_id'];
                      
						// And finally assign featured image to post
						set_post_thumbnail( $post_id, $post_featured_image );
					}
				}
			}
        }
        // var_dump($post_id);
        // exit;

        if (is_wp_error($post_id)) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
			
		} else {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = "Service added successfully!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('all-services');
		}

		return $this->response_json($response);
    }

    function update_shipping_status() {
      
        if(!is_user_logged_in()){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		} 

        if (empty($_POST['service_id'])) {
            $response['title'] = "Error";
            $response['message'] = "Service not found!";
            $response['status'] = false;
            return $this->response_json($response);
        }

        $post_data = array(
			'ID'   => $_POST['service_id'],
			'post_status'  => $_POST['shipping_status'], 
			'post_type'    => 'services-order',
		);
       
		$post_id = wp_update_post($post_data, true);
        if($post_id){
            update_post_meta($_POST['service_id'], 'order_completed', date('d-m-Y'));
        }
        
        //Push Notification
        $notification_title = 'Service Order #'.$post_id;
        $notification_content = '<p>Your service order status has been completed on '. date("l jS \of F Y ") .'</p>';
        $notification = $this->push_notifications($notification_title , $notification_content, $_POST['customer_id']);
        if($notification["success"] == true){
            // Add custom field for read/unread status
            add_post_meta($notification["post_id"], 'notification_status', 'unread');
            add_post_meta($notification["post_id"], 'user_id', $_POST['customer_id']);
        }
      
        if (is_wp_error($post_id)) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Try again, something's amiss!";
        
        } else {
            $response['title'] = "Success";
            $response['message'] = "Shipping status updated!";
            $response['status'] = true;
            // $response['shipping_status'] = 'Delivered';
        }

        return $this->response_json($response);
    }

    function update_status_by_customer(){
     
        if(!is_user_logged_in()){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		} 

        if (empty($_POST['service_id'])) {
            $response['title'] = "Error";
            $response['message'] = "Service not found!";
            $response['status'] = false;
            return $this->response_json($response);
        }

        update_post_meta($_POST['service_id'], 'customer_order_status', $_POST['customer_order_status']);
        $response['title'] = "Success";
        $response['message'] = "Order status updated!";
        $response['status'] = true;
        $response['customer_order_status'] = 'Received';
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

        if (empty($_POST['cat_type'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "Category type not defined!";
            $response['status'] = false;
            return $this->response_json($response);
        }

        // Get the term object by name
        $category = get_term_by( 'name', $_POST['old_cat'], $_POST['cat_type'] ); 
       
        if ( $category ) {
            $category_id = $category->term_id;

            // If the category exist,
            if (term_exists($_POST['category'], $_POST['cat_type'])) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = "Category already exists!";
                $response['status'] = false;
                return $this->response_json($response);
            }
         
            $term = wp_update_term($category_id, $_POST['cat_type'], array(
                'name' => $_POST['category'],
            ) );
            $message = "Category updated successfully!";
        } else {

            $term = wp_insert_term($_POST['category'], $_POST['cat_type']);
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
            $response['redirect_url'] = home_url('category-list/?type='.$_POST['cat_type']);
        }
           
        return $this->response_json($response);
    }

    function get_selected_category_services() {
        // var_dump($_POST);
        // exit;
        if (isset($_POST['category'])) {
            if($_POST['category'] == 'all'){
                $args = array(
                    'post_type'         => 'services',
                    'posts_per_page'    => -1, // Display all posts
                    'post_status'       => 'publish',
                );
            }
            else{
                $args = array(
                    'post_type'      => 'services',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'services-category',
                            'field'    => 'id',
                            'terms'    => $_POST['category'],
                        ),
                    ),
                );
            }

            $services = new WP_Query($args);
    
            $html = '';
            
            foreach ($services->posts ?? [] as $key => $value) { 
                $post_categories = wp_get_post_terms($value->ID, "services-category", array("fields" => "names"));
                $categories = implode(", ", $post_categories);
                $price =  get_post_meta($value->ID, 'price', true);

            $html .= '<div class="product-item">
                    <div class="product-image">
                        <img src="' . (!empty(get_the_post_thumbnail_url($value->ID)) 
                            ? get_the_post_thumbnail_url($value->ID) 
                            : get_stylesheet_directory_uri() . "/store/assets/images/no-preview.png") . 
                        '" alt="Service Image">                    
                    </div>
                    <div class="product-details">
                        <p class="catgory">'.$categories.'</p>
                        <h3 class="product-title">'. get_the_title($value->ID) .'</h3>
                        <p class="product-content">'. get_the_excerpt($value->ID) .'</p>
                        <p class="product-price">$'. number_format($price, 2, '.', '') .'</p>
                        <p class="product-author">Author: '. get_post_meta($value->ID, 'vendor', true) .'</p>
                        <p class="product-posted">Posted: '. get_the_date('', $value->ID) .'</p>
                        <button class="book_button" type="button"  data-id="'. $this->encryptData($value->ID) .'" data-user="'. $this->encryptData($value->post_author) .'">Book</button>
                    </div>
                </div>';
            }

            
            if( $html == ''){
                $html = '<p="no_result">No services found<p>';

            }
            
    
            $response['status'] = true;
            $response['html'] = $html;
            return $this->response_json($response);
        }

        $response['status'] = false;
        $response['message'] = "Not selected any!";
        return $this->response_json($response);
    }

    function delete_category() {
        if (!is_user_logged_in()) {
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        var_dump($_POST);
        exit;

        if (empty($_POST['cat_id'])) {
            $response['status'] = false;
            $response['message'] = "This category are not found.";
            return $this->response_json($response);
        }

       

        $result = wp_delete_term( $_POST['cat_id'], 'services-category' ); 

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

    function delete_services() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['service_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This service are not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['service_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "Service not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Deleted Succesfully";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function register_services() {
        register_post_type('services',
            array(
                'labels'      => array(
                    'name'          => __('Services', 'textdomain'),
                    'singular_name' => __('Services', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title','editor', 'comments','thumbnail'),
                    'taxonomies'  => array('post_tag'), 

            )
        );

        // Register Custom Taxonomy
		$taxonomy_labels = array(
			'name'              => _x('Service Categories', 'taxonomy general name', 'textdomain'),
			'singular_name'     => _x('Service Category', 'taxonomy singular name', 'textdomain'),
			'search_items'      => __('Search Service Categories', 'textdomain'),
			'all_items'         => __('All Service Categories', 'textdomain'),
			'parent_item'       => __('Parent Service Category', 'textdomain'),
			'parent_item_colon' => __('Parent Service Category:', 'textdomain'),
			'edit_item'         => __('Edit Service Category', 'textdomain'),
			'update_item'       => __('Update Service Category', 'textdomain'),
			'add_new_item'      => __('Add New Service Category', 'textdomain'),
			'new_item_name'     => __('New Service Category Name', 'textdomain'),
			'menu_name'         => __('Category', 'textdomain'),
		);

		$taxonomy_args = array(
			'hierarchical'      => true,
			'labels'            => $taxonomy_labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'service-categories'),
		);

		register_taxonomy('services-category', array('services'), $taxonomy_args);
    }

    function services_order() {
        register_post_type('services-order',
            array(
                'labels'      => array(
                    'name'          => __('Services Order', 'textdomain'),
                    'singular_name' => __('Services Order', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title','editor', 'comments','thumbnail'),
            )
        );
    }

    function uploadImage($file) {
        // fetch uploaded image
        $image = $file['tmp_name'];
        $filename = $file['name'];

        $upload_file = wp_upload_bits($filename, null, file_get_contents($image));

        if (!$upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'] );
            if (!is_wp_error($attachment_id)) {
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                wp_update_attachment_metadata( $attachment_id,  $attachment_data );

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

    function response_json($response) {
        echo json_encode($response);
        wp_die();
    }

    function decryptData($data) {
		$ciphering = "AES-128-CTR";
		$decryption_iv = '1234567891011121';
		$options = 0;
		$decryption_key = "W3docs";
		return openssl_decrypt($data, $ciphering, $decryption_key, $options, $decryption_iv);
    }

    function encryptData($data) {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "W3docs";
        return  openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
    }

} 
new ManageServices();