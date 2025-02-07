<?php
class PrintOnDemand {
    function __construct() {
        $variable = [
            'add_new_request', 
            // 'add_new_service_quotation_request', 
            // 'accept_print_on_demand_request', 
            'print_on_demand_quote',
            'delete_request',
            'accept_print_on_demand_request_by_customer',
            'pay_remaining_balance_by_customer',
            'on_demand_service_quote'
        ];
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }
        $cpt = array('register_print_on_demand_requests', 'register_on_demand_services', 'register_bulk_manufacturing');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }
    function add_new_request() {
        // var_dump($_FILES['stl_files']);
        // exit;
      

        if(!is_user_logged_in()){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Your session is expired!";
			return $this->response_json($response);
		}
        if(in_array('administrator', wp_get_current_user()->roles) || in_array('vendor', wp_get_current_user()->roles) ){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You are not requested this service, please register yourself as a customer or bussiness";
			return $this->response_json($response);
        }
        if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['price'])) {
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
        $request_type = !empty($_POST['type']) ? $_POST['type'] :  'service-on-demand';
        // if (empty($_POST['type']) ) {
        //     $response['status'] = false;
        //     $response['message'] = "Request type not defined";
        //     return $this->response_json($response);
        // }
        if ( $request_type == 'print-on-demand' && $_FILES['stl_files']['size'] <= 0 ) {
            $response['status'] = false;
            $response['message'] = "Please upload stl file";
            return $this->response_json($response);
        }
        if ( $request_type == 'service-on-demand' && $_FILES['example_files']['size'] <= 0 ) {
            $response['status'] = false;
            $response['message'] = "Please upload example file";
            return $this->response_json($response);
        }
        // var_dump($_FILES['stl_files']['size']);
        // exit;
        $total_price = $_POST['price'];
        // Check if price is valid before proceeding
        if (!$total_price || !is_numeric($total_price)) {
            $response['status'] = false;
            $response['message'] = "Invalid total price.";
            return $this->response_json($response);
        }
        try {
            $post_data = array(
                'post_title'   => $_POST['title'],
                'post_content'   => $_POST['description'],
                'post_status'  => 'publish', 
                'post_type'    => $request_type,
                'post_author'    => get_current_user_id(),
            );
            $post_id = wp_insert_post($post_data);
            if (is_wp_error($post_id)) {
                throw new Exception($post_id->get_error_message());
            }
            if($post_id){
                update_post_meta($post_id,'price',$_POST['price']);
                update_post_meta($post_id,'quantity',$_POST['quantity']);
                update_post_meta($post_id,'user_id',get_current_user_id());
                update_post_meta($post_id,'date', date('d-m-Y'));
                update_post_meta($post_id,'type', $request_type);
                update_post_meta($post_id,'post_status', 'active');
                update_post_meta($post_id,'deadline_date', $_POST['deadline_date']);
                update_post_meta($post_id,'item_type', $_POST['item_type']);

                 

                if ( $request_type == 'print-on-demand') {
                    $this->handle_file_upload('stl_files', 'stl_files', $post_id);
                  
                }
                if ($request_type == 'service-on-demand') {
                    $this->handle_file_upload('example_files', 'example_files', $post_id);
                }
                $response['title'] = "Success";
                $response['message'] = "Your request has been submitted successfully!";
                $response['status'] = true;
            }
        } catch (Exception $e) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $this->response_json($response);
    }
    // Function to handle file uploads
    // Function to handle file uploads and save additional data
    function handle_file_upload($file_field_name, $meta_key, $post_id) {
        $stl_files = []; // Initialize the array to hold data
        if (isset($_FILES[$file_field_name])) {
            $files = $_FILES[$file_field_name];
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );
                    $upload_result = $this->uploadImage($file); // Call your uploadImage function
                    if ($upload_result['success']) {
                        // Collect file details along with additional metadata
                        // Ensure each file gets its associated metadata
                        $quantity = isset($_POST['quantity'][$key]) ? intval($_POST['quantity'][$key]) : 0;
                        $material = isset($_POST['material'][$key]) ? sanitize_text_field($_POST['material'][$key]) : '';

                        // return $quantity;
                         // Append the data for this file
                        $stl_files[] = [
                            'img' => $upload_result['attach_id'], // Attachment ID of the uploaded file
                            'quantity' => $quantity,
                            'material' => $material,
                        ];
                    }
                }
            }
            // Save the stl_files array as a single meta entry
            update_post_meta($post_id, $meta_key, $stl_files);
        }
        return $stl_files;
    }

    // function handle_file_upload($file_field_name, $meta_key, $post_id) {
    //     $image_ids = [];
    //     if (isset($_FILES[$file_field_name])) {
    //         $files = $_FILES[$file_field_name];
    //         foreach ($files['name'] as $key => $value) {
    //             if ($files['name'][$key]) {
    //                 $file = array(
    //                     'name' => $files['name'][$key],
    //                     'type' => $files['type'][$key],
    //                     'tmp_name' => $files['tmp_name'][$key],
    //                     'error' => $files['error'][$key],
    //                     'size' => $files['size'][$key]
    //                 );
    //                 $upload_result = $this->uploadImage($file);
    //                 if ($upload_result['success']) {
    //                     // Collect file details along with additional metadata
    //                     $image_ids[] = [
    //                         'img' => $upload_result['attach_id'], // Attachment ID
    //                         'quantity' => isset($_POST['quantity'][$key]) ? intval($_POST['quantity'][$key]) : 0, // Quantity from form
    //                         'material' => isset($_POST['material'][$key]) ? sanitize_text_field($_POST['material'][$key]) : '', // Material from form
    //                     ];
    //                     // $image_ids[] = $upload_result['attach_id'];
    //                     // update_post_meta($post_id, $meta_key, $image_ids);
    //                 }
    //             }
    //         }
    //         update_post_meta($post_id, $meta_key, $image_ids);

    //     }
    //     return $image_ids;
    // }

    function accept_print_on_demand_request_by_customer(){
        if(!is_user_logged_in()){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
        $test_credentials = get_field('test_credentials', 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        if (empty($secret_key)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Admin keys missing";
            return $this->response_json($response);
        }
        // Retrieve the subscription commission data from options
        $subscription_data = get_option('subscription_data');
        $subscribed_commission = floatval($subscription_data['subscribed_commission']);
        $unsubscribed_commission = floatval($subscription_data['unsubscribed_commission']);
        $postid = $_POST['post_id'];
        $type = get_post_meta($postid,'type',true);
        $vendor_id = $_POST['vendor_id'];
        // Check if the vendor is subscribed and apply the relevant commission
        $subscription_status = get_user_meta($vendor_id, 'subscription_status', true);
        $commission_rate = $subscription_status == 'active' ? $subscribed_commission : $unsubscribed_commission;
        $total_price = $this->decryptData($_POST['price']);
        $partial_amount = $total_price / 2;
        // Calculate the commission amount
        $commission_amount = ($commission_rate / 100) * $total_price;
        // Check if price is valid before proceeding
        if (!$total_price || !is_numeric($total_price)) {
            throw new Exception('Invalid total price.');
        }
        $token = $_POST['stripeToken'];
        $stripe = new \Stripe\StripeClient($secret_key);
        try {
            $charge = $stripe->charges->create([
                'amount' => $partial_amount * 100, // Amount in cents, adjust as needed
                'currency' => 'usd',
                'source' => $token,
                'description' => 'On demand partial payment'
            ]);
            if ($charge->status == "succeeded") {
                // $post_data = array(
                //     'ID' => $postid,
                //     'post_status'  => 'publish', 
                //     'post_type'    => 'print-on-demand',
                // );
                // $post_id = wp_update_post($post_data);
                // if (is_wp_error($post_id)) {
                //     throw new Exception($post_id->get_error_message());
                // }
                if($postid){
                    update_post_meta($postid,'vendor_id', $vendor_id);
                    update_post_meta($postid,'accept_date', date('d-m-Y'));
                    update_post_meta($postid,'post_status', 'inactive');
                    // Save commission 
                    update_post_meta($postid,'commission_rate', $commission_rate. '%');
                    update_post_meta($postid,'commission_amount', $commission_amount);
                    $new_post_id =  $this->create_service_order($postid, $total_price);
                    if (is_wp_error($new_post_id)) {
                        throw new Exception($new_post_id->get_error_message());
                    }
                    if($new_post_id){
                        $current_user = wp_get_current_user();
                        $vendor_user = new WP_User(intval($vendor_id));
                        update_post_meta($new_post_id,'customer_id',$current_user->ID);
                        update_post_meta($new_post_id,'customer_name',$current_user->display_name);
                        update_post_meta($new_post_id,'vendor_id',$vendor_user->ID);
                        update_post_meta($new_post_id,'vendor_name',$vendor_user->display_name);
                        update_post_meta($new_post_id,'type',$type);
                        update_post_meta($new_post_id,'pending_balance', true);
                        update_post_meta($new_post_id,'pending_payment', $partial_amount);
                        update_post_meta($new_post_id,'recurring_amount', $partial_amount);
                        update_post_meta($new_post_id,'payment_status', $charge->status);
                        // Save commission
                        update_post_meta($new_post_id,'commission_rate', $commission_rate. '%');
                        update_post_meta($new_post_id,'commission_amount', $commission_amount);
                        // Call the total_sales static method from FilterEarning class
                        FilterEarning::total_sales($type, $commission_amount, $total_price, $current_user->ID, $vendor_user->ID);
                    }
                }
                $response['title'] = "Success";
                $response['message'] = "This request added to your order's list!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('service-bookings/?type='.$_POST['type']);
            }
            else {
                throw new Exception("Payment failed.");
            }
        } catch (Exception $e) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $this->response_json($response);
    }
    function pay_remaining_balance_by_customer() {
        if(!is_user_logged_in()){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
        $test_credentials = get_field('test_credentials', 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        if (empty($secret_key)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please add Stripe key";
            return $this->response_json($response);
        }
        $postid = $_POST['post_id'];
        $pending_balance = get_post_meta($postid, 'pending_payment', true);
        $token = $_POST['stripeToken'];
        $stripe = new \Stripe\StripeClient($secret_key);
        try {
            $charge = $stripe->charges->create([
                'amount' => $pending_balance * 100, // Amount in cents, adjust as needed
                'currency' => 'usd',
                'source' => $token,
                'description' => 'Print on demand partial remaining payment'
            ]);
            if ($charge->status == "succeeded") {
                update_post_meta($postid,'pending_payment_date', date('d-m-Y'));   
                update_post_meta($postid,'pending_payment', 0);   
                update_post_meta($postid,'pending_balance', false);
                $response['title'] = "Success";
                $response['message'] = "Your payment is received!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('service-invoice/?id='.$postid.'&type='.$_POST['type']);
            }
            else {
                throw new Exception("Payment failed.");
            }
        } catch (Exception $e) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $this->response_json($response);
    }
    function print_on_demand_quote() {
        if(!is_user_logged_in()){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
        $postid = $this->decryptData($_POST['post_id']);
        $vendor_id = get_current_user_id();
        if (empty($_POST['quote_price']) || empty($_POST['comment'])) {
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
        if($postid){
            $quote_data = [
                'post_id' => $postid,
                'vendor_id' => $vendor_id,
                'quote_description' => $_POST['comment'],
                'quote_price' => $_POST['quote_price'],
                'apply_date' => date('d-m-Y'),
            ];
            add_post_meta($postid,'quote', $quote_data );
            update_post_meta($postid,'user_'.$vendor_id, 'applied' );
            $response['title'] = "Success";
            $response['message'] = "Your quotation submitted sucessfully!";
            $response['auto_redirect'] = true;
            $response['status'] = true;
            $response['redirect_url'] = site_url('pod-requests?type='.$_POST['type']);
            return $this->response_json($response);
        }
    }
    function on_demand_service_quote() {
        if(!is_user_logged_in()){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
        $postid = $this->decryptData($_POST['post_id']);
        $vendor_id = get_current_user_id();
        if (empty($_POST['quote_price']) || empty($_POST['comment'])) {
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
        if($postid){
            $quote_data = [
                'post_id' => $postid,
                'vendor_id' => $vendor_id,
                'quote_description' => $_POST['comment'],
                'quote_price' => $_POST['quote_price'],
                'apply_date' => date('d-m-Y'),
            ];
            add_post_meta($postid,'quote', $quote_data );
            $response['title'] = "Success";
            $response['message'] = "Your quotation submitted sucessfully!";
            $response['auto_redirect'] = true;
            $response['status'] = true;
            $response['redirect_url'] = site_url('demand-services');
            return $this->response_json($response);
        }
    }
    function delete_request() {
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
            $response['message'] = "Request not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Deleted Succesfully";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }
    function create_service_order($post_id, $total_price){
        // $current_user = wp_get_current_user();
        // $vendor_user = new WP_User(intval($vendor_id));
        $get_post = get_post(intval($post_id));
        if (!$get_post) {
            throw new Exception('Invalid post.');
        }
        $service_post_data = array(
            'post_title'   => '#'.$post_id.'-'.rand(10,10000),
            'post_status'  => 'draft', 
            'post_type'    => 'services-order',
            // 'author'	   => $current_user->ID,
        );
        $new_post_id = wp_insert_post($service_post_data);
        if ($new_post_id) {
            update_post_meta($new_post_id,'service_id',$post_id);
            update_post_meta($new_post_id,'service_name',$get_post->post_title);
            update_post_meta($new_post_id,'total_price', $total_price);
            update_post_meta($new_post_id, 'order_date', date('d-m-Y'));
        }
        return $new_post_id;
    }
    function register_print_on_demand_requests(){
        register_post_type('print-on-demand',
            array(
                'labels'      => array(
                    'name'          => __('Print On Demand', 'textdomain'),
                    'singular_name' => __('Print On Demand', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'show_ui'     => true,
                    'supports' => array('title'),
            )
        );
         // Register Custom Taxonomy
		// $taxonomy_labels = array(
		// 	'name'              => _x('Print On Demand Categories', 'taxonomy general name', 'textdomain'),
		// 	'singular_name'     => _x('Print On Demand Category', 'taxonomy singular name', 'textdomain'),
		// 	'search_items'      => __('Search Print On Demand Categories', 'textdomain'),
		// 	'all_items'         => __('All Print On Demand Categories', 'textdomain'),
		// 	'parent_item'       => __('Parent Print On Demand Category', 'textdomain'),
		// 	'parent_item_colon' => __('Parent Print On Demand Category:', 'textdomain'),
		// 	'edit_item'         => __('Edit Print On Demand Category', 'textdomain'),
		// 	'update_item'       => __('Update Print On Demand Category', 'textdomain'),
		// 	'add_new_item'      => __('Add New Print On Demand Category', 'textdomain'),
		// 	'new_item_name'     => __('New Print On Demand Category', 'textdomain'),
		// 	'menu_name'         => __('Category', 'textdomain'),
		// );
		// $taxonomy_args = array(
		// 	'hierarchical'      => true,
		// 	'labels'            => $taxonomy_labels,
		// 	'show_ui'           => true,
		// 	'show_in_rest'      => true,
		// 	'show_admin_column' => true,
		// 	'query_var'         => true,
		// 	'rewrite'           => array('slug' => 'print-on-demand-categories'),
		// );
		// register_taxonomy('print-on-demand-categories', array('print-on-demand'), $taxonomy_args);
    }
    function register_on_demand_services(){
        register_post_type('service-on-demand',
            array(
                'labels'      => array(
                    'name'          => __('Services On Demand', 'textdomain'),
                    'singular_name' => __('Services On Demand', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'show_ui'     => true,
                    'supports' => array('title'),
            )
        );
         // Register Custom Taxonomy
		// $taxonomy_labels = array(
		// 	'name'              => _x('Services On Demand Categories', 'taxonomy general name', 'textdomain'),
		// 	'singular_name'     => _x('Services On Demand Category', 'taxonomy singular name', 'textdomain'),
		// 	'search_items'      => __('Search Services On Demand Categories', 'textdomain'),
		// 	'all_items'         => __('All Services On Demand Categories', 'textdomain'),
		// 	'parent_item'       => __('Parent Services On Demand Category', 'textdomain'),
		// 	'parent_item_colon' => __('Parent Services On Demand Category:', 'textdomain'),
		// 	'edit_item'         => __('Edit Services On Demand Category', 'textdomain'),
		// 	'update_item'       => __('Update Services On Demand Category', 'textdomain'),
		// 	'add_new_item'      => __('Add New Services On Demand Category', 'textdomain'),
		// 	'new_item_name'     => __('New Services On Demand Category', 'textdomain'),
		// 	'menu_name'         => __('Category', 'textdomain'),
		// );
		// $taxonomy_args = array(
		// 	'hierarchical'      => true,
		// 	'labels'            => $taxonomy_labels,
		// 	'show_ui'           => true,
		// 	'show_in_rest'      => true,
		// 	'show_admin_column' => true,
		// 	'query_var'         => true,
		// 	'rewrite'           => array('slug' => 'service-on-demand-categories'),
		// );
		// register_taxonomy('service-on-demand-categories', array('service-on-demand'), $taxonomy_args);
    }
    function register_bulk_manufacturing(){
        register_post_type('bulk-manufacturing',
            array(
                'labels'      => array(
                    'name'          => __('Bulk Manufacturing', 'textdomain'),
                    'singular_name' => __('Bulk Manufacturing', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'show_ui'     => true,
                    'supports' => array('title'),
            )
        );
         // Register Custom Taxonomy
		// $taxonomy_labels = array(
		// 	'name'              => _x('Bulk Manufacturing Categories', 'taxonomy general name', 'textdomain'),
		// 	'singular_name'     => _x('Bulk Manufacturing Category', 'taxonomy singular name', 'textdomain'),
		// 	'search_items'      => __('Search Bulk Manufacturing Categories', 'textdomain'),
		// 	'all_items'         => __('All Bulk Manufacturing Categories', 'textdomain'),
		// 	'parent_item'       => __('Parent Bulk Manufacturing Category', 'textdomain'),
		// 	'parent_item_colon' => __('Parent Bulk Manufacturing Category:', 'textdomain'),
		// 	'edit_item'         => __('Edit Bulk Manufacturing Category', 'textdomain'),
		// 	'update_item'       => __('Update Bulk Manufacturing Category', 'textdomain'),
		// 	'add_new_item'      => __('Add New Bulk Manufacturing Category', 'textdomain'),
		// 	'new_item_name'     => __('New Bulk Manufacturing Category', 'textdomain'),
		// 	'menu_name'         => __('Category', 'textdomain'),
		// );
		// $taxonomy_args = array(
		// 	'hierarchical'      => true,
		// 	'labels'            => $taxonomy_labels,
		// 	'show_ui'           => true,
		// 	'show_in_rest'      => true,
		// 	'show_admin_column' => true,
		// 	'query_var'         => true,
		// 	'rewrite'           => array('slug' => 'bulk-manufacturing-categories'),
		// );
		// register_taxonomy('bulk-manufacturing-categories', array('bulk-manufacturing'), $taxonomy_args);
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
    function decryptData($data) {
		$ciphering = "AES-128-CTR";
		$decryption_iv = '1234567891011121';
		$options = 0;
		$decryption_key = "W3docs";
		return openssl_decrypt($data, $ciphering, $decryption_key, $options, $decryption_iv);
    }
}
new PrintOnDemand();