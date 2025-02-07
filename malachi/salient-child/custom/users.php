<?php
include "notification-trait.php";

class MainClass
{
    use NotificationTrait;

    function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_files'));
        add_action('publish_post',  array($this,'new_post_publish' )); // new post publish


        $variable = [
            'signup_user', 
            'login_user', 
            'resend_email_verific_code', 
            'update_user_profile', 
            'change_password',  
            'forgot_password', 
            'reset_password_custom', 
            'verify_email', 
            'delete_user', 
            'read_all_notifications',
            'deactivate_account', 
            'add_user', 
            'vendor_settings', 
            'assign_reward_badges'
        ];

        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        
        $cpt = array('register_notification');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }


    function enqueue_custom_files() {
        wp_enqueue_script('jquery');
        wp_enqueue_style('toastr-style', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
        wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');

        wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);

        wp_enqueue_script('toastr-script', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array(), null, true);
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
        wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/custom/assets/js/custom.js',array('jquery'), time(), true);

        $user_data =   array(
            'ajax_url' => admin_url('admin-ajax.php'),
			'current_user' => get_current_user_id(),
        );
        wp_localize_script('custom-script', 'ajax_script', $user_data);
    }



    function signup_user(){

        // var_dump($_POST);
        // exit;
        if (empty($_POST['user_name']) || empty($_POST['user_email']) || empty($_POST['password'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill All Required Fields";
            return $this->response_json($response);
        }

        if (email_exists(trim($_POST['user_email']))) {
            $response['icon'] = "error";
            $response['message']  = 'The E-mail , you enetered is already registered, Try another one.';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if (strlen($_POST['password']) < 8) {
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if ($_POST['password'] != $_POST['confirm_password']) {
            $response['icon'] = "error";
            $response['message'] = 'Password Not Match';
            $response['status'] = false;
            return $this->response_json($response);
        }



        if (username_exists(trim($_POST['user_name']))) {
            $response['icon'] = "error";
            $response['message']  = 'Username , you enetered is already registered, Try another one.';
            $response['status'] = false;
            return $this->response_json($response);
        }

        $test_credentials = get_field('test_credentials', 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        
   
        if (empty($secret_key)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Something went wrong";
            return $this->response_json($response);
        }

        $user_type = 'customer';
        $role = 'customer';
        if(isset($_POST['user_type']) && $_POST['user_type'] == 'business'){
            $user_type = 'business';
            $role = 'customer';
        } elseif(isset($_POST['user_type']) && $_POST['user_type'] == 'vendor'){
            $user_type = $_POST['user_type'];
            $role = $_POST['user_type'];
        }

        // var_dump( $user_type);
        // var_dump( $role);
        // exit;

        $token = $_POST['stripeToken'];
        $subscription_data = get_option('subscription_data', true);
        $stripe =  \Stripe\Stripe::setApiKey($secret_key);

        try {
                   
            if(isset($_POST['subscribe'])){
                $create_subscription = $this->create_subscription($subscription_data['monthly_price'], $token);
                if ($create_subscription->status == "active") {
                    $user = $this->create_user($_POST, $role, $user_type);
                    update_user_meta($user, 'subscription_status', $create_subscription->status);              
                    update_user_meta($user, 'stripe_subscription_id', $create_subscription->id);              
                    update_user_meta($user, 'date', date('d/m/Y'));              
                    // update_user_meta($user, 'expire_date', date('Y-m-d', strtotime('+1 month')););              
                
                } else {
                    throw new Exception("Payment failed.");
                }
            } else {
                $user = $this->create_user($_POST, $role, $user_type);
            }

            $response['auto_redirect'] = false;
            $response['icon'] = "success";
            $response['message'] = "Succesfully Registered! Please check your email.";
            $response['status'] = true;
            $response['redirect_url'] = home_url('verify-email');
            
    
        } catch (Exception $e) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }

        return $this->response_json($response);
    }

    function login_user(){

        $useremail = isset($_POST['user_email']) ? sanitize_text_field($_POST['user_email']) : '';
        $password = isset($_POST['password']) ? sanitize_text_field($_POST['password']) : '';
        $remember_me = isset($_POST['remember']) ? sanitize_text_field($_POST['remember']) : '';

        if ($useremail != "" && $password != "") {
            $remember_me = isset($remember_me);
            $isemail = filter_var($useremail, FILTER_VALIDATE_EMAIL);
            $user = get_user_by(($isemail) ? 'email' : 'login', $useremail);
            $email_status =  get_user_meta($user->ID, 'email_status', true);
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
                   
                    if ($email_status != "Verified") {
                        $response['icon'] = "error";
                        $response['title'] = "Error";
                        $response['message'] = 'Your account is not verified, please check your email to verify account';
                        $response['status'] = false;
                        $response['auto_redirect'] = true;
                        $response['redirect_url'] = home_url('verify-email');
                        setcookie('verific_user_id', $user->ID, time()+3600, '/');
                        return $this->response_json($response);
                    }

                    if ($account_status == "Not Active") {
                        $response['icon'] = "error";
                        $response['title'] = "Error";
                        $response['message'] = 'Your account is deactivated';
                        $response['status'] = false;
                        return $this->response_json($response);
                    }
                    // var_dump($user->roles);
                    // var_dump($account_status);
                    // exit;
                }

                //exit;

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
                } else {
                   
                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['message'] = 'Redirecting you to dashboard';
                    $response['auto_redirect'] = true;
                    $response['status'] = true;
                    $response['redirect_url'] = home_url('login?action=login/');
                }
            } else {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $passwordErr = "Password is inncorrect";
                $response['message'] = $passwordErr;
                $response['status'] = false;
            }
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Invalid login or password';
            $response['status'] = false;
        }
        return $this->response_json($response);
    }

    private function create_user($data, $role, $user_type){
        $userdata = [
            'first_name' => sanitize_text_field($data['user_name']),
            'user_login' => sanitize_email($data['user_email']),
            'user_email' => sanitize_email($data['user_email']),
            'user_pass'  => $data['password'],
            'role'       => $role,
        ];

        $user = wp_insert_user($userdata);

        if (is_wp_error($user)) {
            throw new Exception($user->get_error_message());
        }

        // Update user meta with additional data
        update_user_meta($user, 'email_status', 'Not Verified');
        update_user_meta($user, 'account_status', 'Not Active');
        update_user_meta($user, 'user_type', $user_type);
        update_user_meta($user, 'business_name', sanitize_text_field($data['business_name']));
        update_user_meta($user, 'business_email', sanitize_email($data['business_email']));
        update_user_meta($user, 'business_num', sanitize_text_field($data['business_num']));

        // Generate and store activation key
        $code = $this->generateRandomString(6);
        setcookie("verific_user_id", $user, time() + 3000, "/");
        update_user_meta($user, 'activation_key', $code);

        // Send verification email
        ob_start();
        include get_stylesheet_directory() . '/custom/email_template/email-confirmation.php';
        $email_content = ob_get_clean();
        $headers = ['Content-Type: text/html; charset=UTF-8'];
        wp_mail($data['user_email'], "Kainamo", $email_content, $headers);

        return $user;
    }

    function create_subscription($price, $token){
      
        // Step 1: Check if the product already exists
        $products = \Stripe\Product::all(['limit' => 100, 'active' => true]);
        $product = null;
        foreach ($products->data as $p) {
            if ($p->name == $_POST['user_type'].'-'.$price) {
                $product = $p;
                break;
            }
        }
  
        //Create Product
        if (!$product) {
            $product = \Stripe\Product::create([
                'name' => $_POST['user_type'].'-'.$price,
                'type' => 'service',
            ]);
        }
  
        // Step 2: Create Prices based on the plan selected
        $price = \Stripe\Price::create([
            'product' => $product->id,
            'unit_amount' => $price * 100,
            'currency' => 'usd',
            'recurring' => ['interval' => 'month'],
        ]);
  
        // Step 3: Create a Customer
        $customer = \Stripe\Customer::create([
            'name' => $_POST['user_name'], 
            'email' => $_POST['user_email'],
            'source' => $token,
        ]);

        // Step 4: Create Subscription
        $subscription = \Stripe\Subscription::create([
            'customer' => $customer->id,
            'items' => [['price' => $price->id]],
        ]);

        return $subscription;
    }

    function resend_email_verific_code() {
        $code = $this->generateRandomString($length = 6);
        setcookie("verific_user_id", $_POST['verific_user_id'], time() + 3000, "/");
        update_user_meta($_POST['verific_user_id'], 'activation_key', $code);
        $get_user = get_user_by('id', $_COOKIE['verific_user_id']);

        ob_start();
        include get_stylesheet_directory() . '/custom/email_template/email-confirmation.php';
        $email_content = ob_get_contents();
        ob_end_clean();
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $msg = wp_mail($get_user->user_email, "Kainamo", $email_content, $headers);

        if (is_wp_error($msg)) {
            $response['icon'] = "error";
            $response['message'] = 'Try again, internet connection missed';
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Verification code sent! Please check your email.";
            $response['status'] = true;
        }

        return $this->response_json($response);
    }

    function verify_email(){
        if (empty($_POST['verification_code'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please Fill 6 Digit Code";
            return $this->response_json($response);
        }

        if (!isset($_COOKIE['verific_user_id']) || $_COOKIE['verific_user_id'] == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'TimeOut Please Try Again';
            $response['status'] = false;
            return $this->response_json($response);
        }

        $get_user = get_user_by('id', $_COOKIE['verific_user_id']);
        if ($get_user) {
            $get_user_key = get_user_meta($_COOKIE['verific_user_id'], 'activation_key', true);
        }
        if ($_POST['verification_code'] != $get_user_key) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Verification Code Is Incorrect';
            $response['status'] = false;
            return $this->response_json($response);
        } else {
            update_user_meta($get_user->ID, 'email_status', 'Verified');
            update_user_meta($get_user->ID, 'account_status', 'Active');


            $response['auto_redirect'] = false;
            $response['icon'] = "success";
            $response['message'] = "Your account has been succesfully verified";
            $response['status'] = true;
            $response['redirect_url'] = home_url('login');
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

    function read_all_notifications() {

    

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
        if($_POST['type'] == 'administrator'){
           
            $unread_order_notifications = array(
                'post_type'  => 'notifications',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key'   => 'notification_admin_status',
                        'value' => 'unread',
                    ),
                  
                    array(
                        'key'   => 'admin_id',
                        'value' => $_POST['user_id'],
                        'compare' => '='
                    ),
                ),
            );
        }
       
        
        $unread_orders = new WP_Query($unread_order_notifications);

       

        foreach ($unread_orders->posts ?? [] as $key => $value) {
            if($_POST['type'] == 'administrator'){
                update_post_meta($value->ID, 'notification_admin_status', 'read');
            }else {
                update_post_meta($value->ID, 'notification_status', 'read');
            }
        }
        
        $response['status'] = true;
        return $this->response_json($response);
    }

    function delete_user() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['user'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Something went wrong.";
            return $this->response_json($response);
        }
        $result = wp_delete_user($_POST['user']);
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

    function assign_reward_badges(){

        if (!is_user_logged_in()) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['user'])) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "User not found, Please reload the page and try again!";
            return $this->response_json($response);
        }
        // var_dump($_POST);
        // exit;
        $badge = $_POST['reward'] == 'quick_shipping' ? 'Quick Shipping' : 'Fast Responses';

        if($_POST['status']){
            update_user_meta($_POST['user'], $_POST['reward'], 'true');
            $response['message'] = "Badge assign successfully!";
            //Push Notification
            $notification_title = "Congratulations! You're Receiving a Reward!";
            $notification_content = "<p>Congratulations! You've earned a ". $badge ." reward for your engagement</p>";
            $notification = $this->push_notifications($notification_title , $notification_content, $_POST['user']);
            if($notification["success"] == true){
                // Add custom field for read/unread status
                add_post_meta($notification["post_id"], 'notification_status', 'unread');
                add_post_meta($notification["post_id"], 'notification_admin_status', 'unread');
                add_post_meta($notification["post_id"], 'user_id', $_POST['user']);
                add_post_meta($notification["post_id"], 'admin_id', '1');
            }

        } else {
            update_user_meta($_POST['user'], $_POST['reward'], 'false');
            $response['message'] = "Badge remove successfully!";
        }
     
        $response['status'] = true;
        $response['title'] = "Success";
        return $this->response_json($response);
       
    }

    function update_user_profile(){
        // parse_str($_POST['form_data'], $form_data); // Convert serialized string to array
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        $user = isset($_POST['user_id']) ? $_POST['user_id'] : get_current_user_id();
        $user = get_user_by('id', $user);

        if ($user) {
            // $user_meta = get_user_meta($user->ID);
            $first_name = get_user_meta($user->ID, 'first_name', true);
            $last_name = get_user_meta($user->ID, 'last_name', true);

            $user_data = array(
                'ID'         => $user->ID,
                'user_email' => isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : $user->user_email,
                'first_name'  => isset($_POST['f_name']) ? sanitize_text_field($_POST['f_name']) : $first_name,
                'last_name'  => isset($_POST['l_name']) ? sanitize_text_field($_POST['l_name']) : $last_name,
                'role'    => isset($_POST['user_role']) ? $_POST['user_role'] : $user->roles[0]
            );



            // if (!empty($_POST['password'])) {
            //     wp_set_password($_POST['password'], $user->ID);
            // }
            if (!empty($_POST['first_name'])) {
                $user_data['first_name'] = sanitize_text_field($_POST['first_name']);
                $user_data['display_name'] = $user_data['first_name'];
                update_user_meta($user->ID, 'first_name', $user_data['first_name']);
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
                $response['message'] = "Profile updated successfully!";
                $response['auto_redirect'] = false;
                $response['status'] = true;
                $response['redirect_url'] = home_url('users?type='.$user->roles[0]);
            }
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "User not found.";
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

        if (strlen($_POST['password']) < 8) {
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if (empty($_POST['user_id'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "User not found";
            return $this->response_json($response);
        }

        wp_set_password($_POST['password'], $_POST['user_id']);
        $response['icon'] = "success";
        $response['title'] = "Success";
        $response['message']  = "Password Changed Successfully";
        $response['status'] = true;

        return $this->response_json($response);
    }

    function forgot_password(){
        $get_user = get_user_by('email', $_POST['recovery_email']);

        if ($get_user) {
            $code = $this->generateRandomString($length = 4);
            setcookie("recovery_code", $code, time() + 3000, "/");
            setcookie("recovery_user_id", $get_user->ID, time() + 3000, "/");
            ob_start();
            include get_stylesheet_directory() . '/custom/email_template/email-recover.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $msg = wp_mail($_POST['recovery_email'], "Kainamo", $email_content, $headers);
            if ($msg) {
                $response['auto_redirect'] = true;
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = 'Verification Code Send Successfully Please Check Your Email';
                $response['status'] = true;
                $response['redirect_url'] = home_url() . '/reset-password/';
                return $this->response_json($response);
            } else {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = 'Please Check Your Internet Connection';
                $response['status'] = false;
                return $this->response_json($response);
            }
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message']  = "Try again this email doesn't exists";
            $response['status'] = false;
        }
        return $this->response_json($response);
    }

    function reset_password_custom(){

        if (!isset($_COOKIE['recovery_user_id']) || $_COOKIE['recovery_user_id'] == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'TimeOut Please Try Again';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if (!isset($_COOKIE['recovery_code']) || $_COOKIE['recovery_code'] != $_POST['recovery_code']) {
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

        wp_set_password($_POST['password'], $_COOKIE['recovery_user_id']);
        $response['auto_redirect'] = false;
        $response['icon'] = "success";
        $response['title'] = "Success";
        $response['message']  = "Password Reset Successfully";
        $response['status'] = true;
        $response['redirect_url'] = home_url("login");

        return $this->response_json($response);
    }
    
    function new_post_publish($post_id) {

        //Push Notification

        $customers = new WP_User_Query( array(
            'role'     => 'customer',
        ) );
        $all_customers = $customers->get_results();    
            foreach ($all_customers as $user) {
            
                $notification_title = 'New Blog is Live';
                $notification_content = '<p>We wanted to notify you a new blog has been published.</p>';
                $permalink = get_permalink($post_id);
                $notification = $this->push_notifications($notification_title , $notification_content, $user->ID);
                if($notification["success"] == true){
                    // Add custom field for read/unread status
                    add_post_meta($notification["post_id"], 'notification_status', 'unread');
                    add_post_meta($notification["post_id"], 'user_id', $user->ID);
                    add_post_meta($notification["post_id"], 'product_link', $permalink);
                }
            
        }
    }

    function add_user() {
        if (isset($_POST)) {
            foreach ($_POST as $key => $value) {
                if (empty($value)) {
                    $response['icon'] = "error";
                    $response['status'] = false;
                    $response['message'] = "Please Fill All Required Fields";
                    return $this->response_json($response);
                }
            }
        }

        if (email_exists(trim($_POST['user_email']))) {
            $response['icon'] = "error";
            $response['message']  = 'The E-mail , you enetered is already registered, Try another one.';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if (strlen($_POST['password']) < 8) {
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
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

        $userdata = array(
            'first_name' => $_POST['f_name'],
            'last_name' => $_POST['l_name'],
            'user_login' => $_POST['f_name'],
            'user_email' => $_POST['user_email'],
            'user_pass' =>  $_POST['password'],
            'role'    => $_POST['user_role'],
        );


        $user = wp_insert_user($userdata);

        if ($user) {
            update_user_meta($user, 'email_status', 'Verified');
            update_user_meta($user, 'account_status', 'Active');

            ob_start();
            include get_stylesheet_directory() . '/custom/email_template/email-welcome-user.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($_POST['user_email'], "Kainamo", $email_content, $headers);
        }


        if (is_wp_error($user)) {
            $response['icon'] = "error";
            $response['message'] = $user->get_error_message();
            $response['status'] = false;
        } else {

            $response['auto_redirect'] = true;
            $response['icon'] = "success";
            $response['message'] = "Succesfully Registerd";
            $response['status'] = true;
            $response['redirect_url'] = home_url('users');
        }

        return $this->response_json($response);
    }

    function vendor_settings(){
      
        if (!is_user_logged_in()) {
            $response['status'] = false;
            $response['title'] = "Error";
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        $required = ['subscription_price', 'subscription_tooltip', 'subscribed_commission', 'unsubscribed_commission'];
        foreach($required  as $value){
            if (empty( $_POST[ $value ])) {
                $response['status'] = false;
                $response['title'] = "Error";
                $response['message'] = "Please Fill All Required Fields";
                return $this->response_json($response);
            }
        }
        

        
        $subscription_data = [
            "monthly_price" => $_POST['subscription_price'],
            "subscribed_commission" => $_POST['subscribed_commission'],
            "unsubscribed_commission" => $_POST['unsubscribed_commission'],
            "tooltip" => $_POST['subscription_tooltip'],
        ];
        update_option('subscription_data', $subscription_data);

        $response['title'] = "Success";
        $response['status'] = true;
        $response['message'] = "Settings Saved";
        return $this->response_json($response);
    }

    function response_json($response){
        echo json_encode($response);
        wp_die();
    }

    function generateRandomString($length = 8)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
new MainClass();
