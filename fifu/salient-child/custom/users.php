<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include "notification-trait.php";

class MainClass {

    use NotificationTrait;

    function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_files' ) );

        $variable = array('signup_user', 'login_user','reset_password_custom','forgot_password','update_user_profile', 'change_password','delete_user', 'deactivate_account', 'add_user', 'cancel_membership', 'renew_subscription', 'read_all_notifications');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }

        $cpt = array('register_notification');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }

    }

    function enqueue_custom_files() {
        wp_enqueue_script('jquery');
      //  wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/custom/assets/css/style.css', array(), '1.0', 'all');
        wp_enqueue_style('toastr-style', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
        wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');       

        wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
        wp_enqueue_script('custom_script', get_stylesheet_directory_uri() . '/custom/assets/js/custom.js', array(), true);
       
        $user_data =   array( 
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        );
        wp_localize_script('custom_script', 'ajax_script', $user_data);
   
    }


    public function login_user() {
		parse_str($_POST['form_data'], $form_data);
		$useremail = isset($form_data['user_email']) ? sanitize_text_field($form_data['user_email']) : '';
		$password = isset($form_data['password']) ? sanitize_text_field($form_data['password']) : '';
		$remember_me = isset($form_data['remember']) ? sanitize_text_field($form_data['remember']) : '';

        if ($useremail != "" && $password != "") {
            $remember_me = isset($remember_me);
            $isemail = filter_var($useremail, FILTER_VALIDATE_EMAIL);
            $user = get_user_by(($isemail) ? 'email':'login', $useremail);
            $account_status = get_user_meta($user->ID, 'account_status', true);
            if (!$user) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = 'Invalid login or password';
                $response['status'] = $remember_me;
                return $this->response_json($response);
            }
            if (wp_check_password($password, $user->data->user_pass, $user->ID)) {

                if (!in_array('administrator', $user->roles)) {
                   
                    if ($account_status == "Not Active") {
                        $response['icon'] = "error";
                        $response['title'] = "Error";
                        $response['message'] = 'Your account is deactivated';
                        $response['status'] = false;
                        return $this->response_json($response);
                    }
                 
                }

                $creds = array(
                    'user_login' => $user->data->user_login,
                    'user_password' => $password,
                    'remember'      => true
                );
                $user = wp_signon($creds, true);
                
                if (is_wp_error($user)) {
                    $passwordErr = "Can't login";
                    $response['title'] = "Error";
                    $response['icon'] = "error";
                    $response['message'] = $user->get_error_message();
                    $response['status'] = false;
                } 
                else {
                   
                    // var_dump($redirect_url);
                    // exit;
                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['auto_redirect'] = true;
                    $response['status'] = true;
					$response['redirect_url'] = home_url('main-dashboard/');
                }
            } else {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $passwordErr = "Password is inncorrect";
                $response['message'] = $passwordErr;
                $response['status'] = false;}
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Invalid login or password';
            $response['status'] = false;
        }
        return $this->response_json($response);
    }

    function signup_user(){
       
       
        // Check for required fields
        $required_fields = ['fname', 'lname', 'user_email', 'password', 'user_name', 'user_type', 'stripeToken'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                return $this->response_json([
                    'icon' => "error",
                    'status' => false,
                    'message' => "Please fill all required fields"
                ]);
            }
        }

        if (email_exists(trim($_POST['user_email']))) {
            $response['icon'] = "error";
            $response['message']  = 'The E-mail , you enetered is already registered, Try another one.';
            $response['status'] = false;
            return $this->response_json($response);
        }
        
        if(strlen($_POST['password']) < 8){
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
            $response['status'] = false;
            return $this->response_json($response);
        }


        if (username_exists(trim($_POST['user_name']))) {
            $response['icon'] = "error";
            $response['message']  = 'Username , you enetered is already registered, Try another one.';
            $response['status'] = false;
            return $this->response_json($response);
        }

        $test_credentials = get_field( 'test_credentials' , 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        if ($secret_key == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please Add Stripe key";
            return $this->response_json($response); 
        }

        // Set your Stripe secret key
        $stripe =  \Stripe\Stripe::setApiKey($secret_key);
        // Retrieve the token from the request
        $token = $_POST['stripeToken'];

        $price = $this->subcription_price_calculate($_POST['plan_switcher']);

        $plan_mode = isset($_POST['plan_switcher']) ? 'yearly' : 'monthly';

        if ($price <= 0) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Something went wrong, Please try again";
            return $this->response_json($response); 
        }

        try 
        {
            $create_subscription = $this->create_subscription($price, $token);

            // var_dump($create_subscription);
            // exit;

            if ($create_subscription->status == "trialing") {
                $userdata = array(
                    'first_name' => $_POST['fname'],
                    'last_name' => $_POST['lname'],
                    'user_login' => $_POST['user_email'],
                    'user_email' => $_POST['user_email'],
                    'user_pass' =>  $_POST['password'],
                    'role'	=> $_POST['user_type'],
                );
                $user = wp_insert_user($userdata);

                if (is_wp_error($user)) {
                    throw new Exception($user->get_error_message());
                }

                if ($user) {
                    $membership_start_date = date("Y-m-d");
                  //  $start_featured_date = date('Y-m-d', strtotime('+3 months', strtotime($membership_start_date)));
                    $end_featured_date = $_POST["subcription_plan"] == 'advanced' 
                    ? date('Y-m-d', strtotime('+1 months', strtotime($membership_start_date))) 
                    : ($_POST["subcription_plan"] == 'premium' 
                        ? date('Y-m-d', strtotime('+45 days', strtotime($membership_start_date)))
                        : null
                    );
                    update_user_meta($user, 'user_name', $_POST["user_name"]);
                    update_user_meta($user, 'ph_num', $_POST["phno"]);
                    update_user_meta($user, 'product_sold', $_POST["product_sold"]);
                    update_user_meta($user, 'shipping_quantity', $_POST["quantities"]);
                    update_user_meta($user, 'user_type', $_POST["user_type"]);
                    update_user_meta($user, 'subscription_plan', $_POST["subcription_plan"]);
                    update_user_meta($user, 'account_status', 'Active');
                    update_user_meta($user, 'membership_trail_end', date('d M Y H:i:s', $create_subscription->billing_cycle_anchor));
                    update_user_meta($user, 'plan_mode', $plan_mode);
                    update_user_meta($user, 'stripe_subscription_id', $create_subscription->id);
                    update_user_meta($user, 'membership_status', $create_subscription->status);
                    update_user_meta($user, 'full_name', $_POST['fname'].' '.$_POST['lname']);
                    if($_POST["subcription_plan"] == 'advanced' || $_POST["subcription_plan"] == 'premium'){
                        update_user_meta($user, 'membership_start_date', $membership_start_date);
                        update_user_meta($user, 'start_featured_date', $membership_start_date);
                        update_user_meta($user, 'end_featured_date', $end_featured_date);
                    }


                    if(isset($_FILES["tem_name"])){
                        $document = $_FILES["tem_name"];
                        if($document['size'] != 0) {
                            $res = $this->uploadImage($document);
                            if($res["success"]) {
                                update_user_meta($user, 'document_attachment', $res['attach_id']);
                            }
                        }
                    }
                }

                $response['auto_redirect'] = true;
                $response['icon'] = "success";
                $response['message'] = "Succesfully Registered!";
                $response['status'] = true;
                $response['redirect_url'] = home_url('login/');
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

    function draft_all_products_after_cancel_membership($user_id) {
    
        // Get all products by the specified user
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1, // Get all products
            'author' => $user_id,
            'post_status' => 'publish' // Only published products
        );
    
        $query = new WP_Query($args);
    
        // Check if the user has any products
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $product_id = get_the_ID();
    
                // Update the product status to 'draft'
                $updated = wp_update_post(array(
                    'ID' => $product_id,
                    'post_status' => 'draft'
                ));
    
                // Check if the update was successful
                if (is_wp_error($updated)) {
                    return array(
                        'success' => false,
                        'msg' => $updated->get_error_message()
                    );
                }
            }
            wp_reset_postdata();
    
            return array(
                'success' => true,
                'msg' => 'products drafts'
            );
        }
    }

    function publish_all_products_after_cancel_membership($user_id) {
    
        // Get all products by the specified user
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1, // Get all products
            'author' => $user_id,
            'post_status' => 'draft' // Only draft products
        );
    
        $query = new WP_Query($args);
    
        // Check if the user has any products
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $product_id = get_the_ID();
    
                // Update the product status to 'draft'
                $updated = wp_update_post(array(
                    'ID' => $product_id,
                    'post_status' => 'publish'
                ));
    
                // Check if the update was successful
                if (is_wp_error($updated)) {
                    return array(
                        'success' => false,
                        'msg' => $updated->get_error_message()
                    );
                }
            }
            wp_reset_postdata();
    
            return array(
                'success' => true,
                'msg' => 'products publish'
            );
        }
    }

    function cancel_membership() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        

        $test_credentials = get_field( 'test_credentials' , 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        if ($secret_key == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Admin Stripe key missing, please contact admin";
            return $this->response_json($response); 
        }

        // Set your Stripe secret key
        $stripe =  \Stripe\Stripe::setApiKey($secret_key);

        $stripe_subscription_id = get_user_meta($_POST['user_id'], 'stripe_subscription_id', true);

        if (!$stripe_subscription_id) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "No subscription found for this user.";
            return $this->response_json($response); 
        }

        try {
            $subscription = \Stripe\Subscription::retrieve($stripe_subscription_id);
            // var_dump(date('d M Y H:i:s', $subscription->billing_cycle_anchor));
            // exit;
            if ($subscription->status == 'canceled') {
                // Subscription is already canceled
                $response['icon'] = "warning";
                $response['title'] = "Already Canceled";
                $response['status'] = false;
                $response['message'] = "Subscription has already been canceled.";
                return $this->response_json($response);
            }
            $subscription->cancel();
            update_user_meta($_POST['user_id'], 'membership_status', 'canceled');
            $this->draft_all_products_after_cancel_membership($_POST['user_id']);
            // var_dump($draft_products);

            //Push Notification
            // $notification_title = 'Membership Cancel #'.$stripe_subscription_id;
            // $notification_content = '<p>Your memebership has been cancelled on '. date("l jS \of F Y ") .'</p>';
            // $notification = $this->push_notifications($notification_title , $notification_content, $_POST['user_id']);
            // if($notification["success"] == true){
            //     // Add custom field for read/unread status
            //     add_post_meta($notification["post_id"], 'notification_status', 'unread');
            //     add_post_meta($notification["post_id"], 'user_id', $_POST['user_id']);
            // }
        
            // $response['icon'] = "success";
            // $response['message'] = "Subscription cancelled successfully";
            $response['status'] = true;
            $response['auto_redirect'] = true;
            $response['redirect_url'] = home_url('logout/');
            return $this->response_json($response);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return $this->response_json($response);
        }

    }

    function renew_subscription() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }   


             
        // Check for required fields
        $required_fields = ['subcription_plan', 'stripeToken'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                return $this->response_json([
                    'icon' => "error",
                    'status' => false,
                    'message' => "Please fill all required fields"
                ]);
            }
        }

        $test_credentials = get_field( 'test_credentials' , 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        if ($secret_key == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Admin stripe key not define";
            return $this->response_json($response); 
        }

        // Set your Stripe secret key
        $stripe =  \Stripe\Stripe::setApiKey($secret_key);
        // Retrieve the token from the request
        $token = $_POST['stripeToken'];

        $price = $this->subcription_price_calculate($_POST['plan_switcher']);

        $plan_mode = isset($_POST['plan_switcher']) ? 'yearly' : 'monthly';
    
        if ($price <= 0) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Something went wrong, Please try again";
            return $this->response_json($response); 
        }

        $curent_user = wp_get_current_user();

        try 
        {
            $create_subscription = $this->create_subscription($price, $token);
    
            // var_dump($create_subscription->status);
            // exit;
    
            if ($create_subscription->status == "trialing" || $create_subscription->status == "active") {
    
                $membership_start_date = date("Y-m-d");
               // $start_featured_date = date('Y-m-d', strtotime('+3 months', strtotime($membership_start_date)));
                $end_featured_date = $_POST["subcription_plan"] == 'advanced' 
                ? date('Y-m-d', strtotime('+1 months', strtotime($membership_start_date))) 
                : ($_POST["subcription_plan"] == 'premium' 
                    ? date('Y-m-d', strtotime('+45 days', strtotime($membership_start_date)))
                    : null
                );
                update_user_meta($curent_user->ID, 'subscription_plan', $_POST["subcription_plan"]);
                update_user_meta($curent_user->ID, 'plan_mode', $plan_mode);
                update_user_meta($curent_user->ID, 'stripe_subscription_id', $create_subscription->id);
                update_user_meta($curent_user->ID, 'membership_status', $create_subscription->status);
                update_user_meta($curent_user->ID, 'membership_start_date', $membership_start_date);
                update_user_meta($curent_user->ID, 'start_featured_date', $membership_start_date);
                update_user_meta($curent_user->ID, 'end_featured_date', $end_featured_date);
    
                $this->publish_all_products_after_cancel_membership($curent_user->ID); // publish products
    
                $response['auto_redirect'] = true;
                $response['icon'] = "success";
                $response['message'] = "Your subscription has been renew successfully!";
                $response['status'] = true;
                $response['redirect_url'] = home_url('main-dashboard/');
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

    function subcription_price_calculate($planSwitcher){

        if($_POST['user_type'] == 'farmer'){
            $basic_plan = get_option('basic_plan', true);
            $advanced_plan = get_option('advanced_plan', true);
            $premium_plan = get_option('premium_plan', true);
        }
        elseif($_POST['user_type'] == 'supplier'){
            $basic_plan = get_option('supplier_basic_plan', true);
            $advanced_plan = get_option('supplier_advanced_plan', true);
            $premium_plan = get_option('supplier_premium_plan', true);
        }else {
            $basic_plan = get_option('restaurant_basic_plan', true);
            $advanced_plan = get_option('restaurant_advanced_plan', true);
            $premium_plan = get_option('restaurant_premium_plan', true);
        }
     

        $price = 0;
        if($planSwitcher){

            if($_POST['subcription_plan'] == 'standard'){
                $price += $basic_plan["annual_price"];
            }
    
            if($_POST['subcription_plan'] == 'advanced'){
                $price += $advanced_plan["annual_price"];
            }
    
            if($_POST['subcription_plan'] == 'premium'){
                $price += $premium_plan["annual_price"];
            }
          
        }else {
            if($_POST['subcription_plan'] == 'standard'){
                $price += $basic_plan["monthly_price"];
            }
    
            if($_POST['subcription_plan'] == 'advanced'){
                $price += $advanced_plan["monthly_price"];
            }
    
            if($_POST['subcription_plan'] == 'premium'){
                $price += $premium_plan["monthly_price"];
            }
        }

        return $price;
    }

    function create_subscription($price, $token){
      
        // Step 1: Check if the product already exists
        $products = \Stripe\Product::all(['limit' => 1000, 'active' => true]);
        $product = null;
        foreach ($products->data as $p) {
            if ($p->name == $_POST['subcription_plan'].'-'.$price) {
                $product = $p;
                break;
            }
        }
  
        //Create Product
        if (!$product) {
            $product = \Stripe\Product::create([
                'name' => $_POST['user_type'].'-'.$_POST['subcription_plan'].'-'.$price,
                'type' => 'service',
            ]);
        }
  
        // Step 2: Create Prices based on the plan selected
        if ($_POST['plan_switcher']) {
            $price = \Stripe\Price::create([
                'product' => $product->id,
                'unit_amount' => $price * 100,
                'currency' => 'usd',
                'recurring' => ['interval' => 'year'],
            ]);
        } else  {
            $price = \Stripe\Price::create([
                'product' => $product->id,
                'unit_amount' => $price * 100,
                'currency' => 'usd',
                'recurring' => ['interval' => 'month'],
            ]);
        }
  
          // Step 3: Create a Customer
          $customer = \Stripe\Customer::create([
              'name' => $_POST['fname'], 
              'email' => $_POST['user_email'],
              'source' => $token,
          ]);
  
          // Step 4: Create Subscription
          $subscription = \Stripe\Subscription::create([
              'customer' => $customer->id,
              'items' => [['price' => $price->id]],
              'trial_period_days' => 90, // 3-month trial
          ]);

        return $subscription;
    }

    public function get_subscription_status(){
        $test_credentials = get_field( 'test_credentials' , 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        if ($secret_key == "") {
            return [
                'status' => false,
                'subscription_status' => "Admin Stripe key missing, please contact admin",
    
            ];
        }
        // Set your Stripe secret key
        $stripe =  \Stripe\Stripe::setApiKey($secret_key);
        $stripe_subscription_id = get_user_meta(get_current_user_id(), 'stripe_subscription_id', true);
        $subscription = \Stripe\Subscription::retrieve($stripe_subscription_id);
        return [
            'status' => true,
            'subscription_status' => $subscription->status,

        ];
            
    }

    public function read_all_notifications() {

        $unread_order_notifications = array(
            'post_type'  => 'notifications',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'   => 'notification_status',
                    'value' => 'unread',
                ),
                array(
                    'key'   => 'user_id',
                    'value' => $_POST['user_id'],
                    'compare' => '='
                ),
            ),
        );
        $unread_orders = new WP_Query($unread_order_notifications);

        foreach ($unread_orders->posts ?? [] as $key => $value) {
            update_post_meta($value->ID, 'notification_status', 'read');
        }
        
        $response['status'] = true;
        return $this->response_json($response);
    }
    
    function forgot_password(){
        // var_dump($_POST);
        // exit;
        $get_user = get_user_by('email', $_POST['recovery_email']);

        if ($get_user) {
            $code = $this->generateRandomString($length = 4);
            setcookie("verification_code", $code, time() + 3000 , "/"); 
            setcookie("verific_user_id", $get_user->ID, time() + 3000 , "/"); 
            ob_start();
            include get_stylesheet_directory() . '/multivendor/email_template/email-recover.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $msg = wp_mail($_POST['recovery_email'], "Fifu", $email_content, $headers);

  
            if ($msg) {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = 'Verification Code Send Successfully Please Check Your Email';
                $response['status'] = true;
                $response['redirect_url']= home_url('reset-password/');
                return $this->response_json($response);
            }
            else{
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = 'Please Check Your Internet Connection';
                $response['status'] = false;
                return $this->response_json($response);
            }

        }else{
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message']  = "Try again this email doesn't exists";
            $response['status'] = false;
        }
        return $this->response_json($response);
    }


    function reset_password_custom(){
        
        if(strlen($_POST['password']) < 8){
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if(!isset($_COOKIE['verific_user_id']) || $_COOKIE['verific_user_id'] == ""){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'TimeOut Please Try Again';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if(!isset($_COOKIE['verification_code']) || $_COOKIE['verification_code'] != $_POST['verification_code']){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Try again verification code is not match';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if ($_POST['password'] == "" || $_POST['password_re'] == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Please fill all required fields correctly';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if ($_POST['password'] != $_POST['password_re']) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Password not Match';
            $response['status'] = false;
            return $this->response_json($response);
        }

        wp_set_password($_POST['password'],$_COOKIE['verific_user_id']);
        $response['icon'] = "success";
        $response['title'] = "Success";
        $response['message']  = "Password Reset Successfully";
        $response['status'] = true;
        $response['redirect_url'] = home_url("login/");

        return $this->response_json($response);

    }
    
    function update_user_profile() {
        // Check if the user is logged in
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
		}
    
        $isemail = filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL);
        $user = get_user_by(($isemail) ? 'email':'login', $_POST['user_email']);
        if (empty($_POST['user_id'])) {
            $response['status'] = false;
            $response['message'] = "User not found.";
            return $this->response_json($response);
        }
    
     
        // Update user data
        $user_data = array(
            'ID' => $user->ID,
            'user_email' => sanitize_email($_POST['user_email']),
            'first_name' => isset($_POST['f_name']) ? sanitize_text_field($_POST['f_name']) : $user->first_name,
            'last_name' => isset($_POST['l_name']) ? sanitize_text_field($_POST['l_name']) : $user->last_name,
        );

        if (!empty($_POST['ph_num'])) {
            $user_data['ph_num'] = $_POST['ph_num'];
            update_user_meta($user->ID, 'ph_num', $user_data['ph_num']);
        }
    
        $updated = wp_update_user($user_data); // Update the user
       
    
        if (is_wp_error($updated)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Try again, something's amiss";
        } else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['status'] = true;
            $response['message'] = "Profile updated successfully!";
            $response['redirect_url'] = home_url('users/');
        }
    
        return $this->response_json($response);
    }
    
    function change_password(){
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        // parse_str($_POST['form_data'], $form_data);

        if (empty($_POST['password'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please fill password field";
            return $this->response_json($response);
        }

        if (empty($_POST['user_id'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "User not found";
            return $this->response_json($response);
        }

        if(strlen($_POST['password']) < 8){
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
            $response['status'] = false;
            return $this->response_json($response);
        }

        wp_set_password($_POST['password'], $_POST['user_id']);
        $response['icon'] = "success";
        $response['title'] = "Success";
        $response['message']  = "Password Changed Successfully";
        $response['status'] = true;

        return $this->response_json($response);
    }

    function delete_user() {
        // var_dump($_POST['user']);
        // exit;
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        $user_id = intval($_POST['user']);

        if (empty($user_id)) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Something went wrong.";
            return $this->response_json($response);
        }
       
        $result = wp_delete_user($user_id);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "User not found";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "User deleted";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function deactivate_account() {
        if (empty($_POST['user'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Something went wrong.";
            return $this->response_json($response);
        }

        $account_status = get_user_meta($_POST['user'], 'account_status', true);

        if ($account_status == "Not Active") {
            $result = update_user_meta($_POST['user'], 'account_status', 'Active');
            $message = "Account Activate";
        } else {
            $result = update_user_meta($_POST['user'], 'account_status', 'Not Active');
            $message = "Account Deactivate";
        }
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "User not found";
            $response['status'] = false;
        } else {
            $account_status = get_user_meta($_POST['user'], 'account_status', true);
            $response['icon'] = "success";
            $response['message'] = $message;
            $response['status'] = true;
            $response['account_status'] = $account_status;
        }
        return $this->response_json($response);
    }

    function register_notification(){
        register_post_type('notifications',
			array(
				'labels'      => array(
					'name'          => __('Notifications', 'textdomain'),
					'singular_name' => __('Notifications', 'textdomain'),
				),
					'public'      => true,
					'has_archive' => true,
					'supports' => array('title','editor'),
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

    function response_json($response){
		echo json_encode($response);
		wp_die(); 
	}

    public function generateRandomString($length = 8) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
$userClass = new MainClass();
