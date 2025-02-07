<?php
class MainClass
{

    function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_files'));

        $cpt = array('register_post_type', 'payment_detail_post_type', 'subscription_plan_id_post_type');
        foreach ($cpt as $k => $v) {
            add_action('init', array($this, $v));
        }

        $variable = array('purchase_plan', 'login_user', 'email_validation', 'reset_password_custom', 'create_plan');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }
    }

    function enqueue_custom_files()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/custom/css/style.css', array(), '1.0', 'all');

        // Enqueue DataTables CSS
        wp_enqueue_style('datatables', 'https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css');
        wp_enqueue_style('responsive-datatables', 'https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css');
        wp_enqueue_style('rowreorder-datatables', 'https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css');
        // Enqueue DataTables JavaScript
        wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js', array('jquery'), true);
        wp_enqueue_script('responsive-datatables-js', 'https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js', array('jquery'), true);
        wp_enqueue_script('row-reorder-datatables-js', 'https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js', array('jquery'), true);
        // wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');
        // wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
        // wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);

    }

    function generate_bearer_token()
    {

        $clientID = 'AdiwKv4R1Szdgmh5TPtuZ1lucw4_tVzxAJU35CNq5lVVUtbJg0clRT4SK1k4BE49ZksusSKKMx_GZ4kw';
        $secret = 'EHvnIw9o903klI2MTd1qWYo3cyu1SmKj60meVzEAHlrujwTQ40H8gBfivfGT_RLfb1cpnDrMXB29G53Z';

        // Encode client ID and secret for Basic Authorization
        $authHeader = base64_encode($clientID . ':' . $secret);
        // Prepare data for obtaining access token
        $data = array(
            'grant_type' => 'client_credentials'
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $authHeader,
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $result = curl_exec($curl);
        $accessToken = json_decode($result)->access_token;
        return  $accessToken;
    }

    function create_plan()
    {


        // $selectedPlan = isset($_POST['selectedPlan']) ? $_POST['selectedPlan'] : '';
        $custom_title = $_POST['selectedPlanName'] . '-' . $_POST['selectedPlan'];

        // var_dump($custom_title); 
        // exit;
        $args = [
            'post_type'      => 'plans_id',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];

        $plans_ids_query = new WP_Query($args);
        $post_titles = [];

        foreach ($plans_ids_query->posts ?? []  as $key => $value) {
            $post_titles[$value->ID]  = $value->post_title;
        }

        if (in_array($custom_title, $post_titles)) {
            $post_id = array_search($custom_title, $post_titles);
            $plan_id =  get_post_meta($post_id, 'plan_id', true);
            $response["plan_id"] = $plan_id;
            // var_dump($post_id);
            // var_dump($plan_id);
            return $this->jsonResponse($response);
        }


        //$this->create_bearer_token();
        // var_dump($this->create_bearer_token());
        // exit;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/billing/plans',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
        "product_id": "PROD-3UW38039WP309503T",
        "name": "MervAir-'.$custom_title.'",
        "billing_cycles": [
        {
        "frequency": {
        "interval_unit": "MONTH",
        "interval_count": 1
        },
        "tenure_type": "REGULAR",
        "sequence": 1,
        "total_cycles": 12,
        "pricing_scheme": {
        "fixed_price": {
        "value": ' . round($_POST['selectedPlan'], 2) . ',
        "currency_code": "USD"
        }
        }
        }
        ],
        "payment_preferences": {
        "auto_bill_outstanding": true,
        "setup_fee": {
        "value": "0",
        "currency_code": "USD"
        },
        "setup_fee_failure_action": "CONTINUE",
        "payment_failure_threshold": 3
        },
        "description": "Video Streaming Service basic plan",
        "status": "ACTIVE",
        "taxes": {
        "percentage": "8.25",
        "inclusive": false
        }
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->generate_bearer_token()
            ),
        ));

        $result = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($result, true);

        // var_dump($data);
        // exit;

        $response["plan_id"] = $data["id"];

        $post_data = array(
            'post_title'   => $custom_title,
            'post_status'  => 'publish',
            'post_type'    => 'plans_id',
        );

        $new_post = wp_insert_post($post_data);

        if ($new_post) {

            update_post_meta($new_post, 'plan_id', $data["id"]);
        }



        return $this->jsonResponse($response);
    }

    public function login_user()
    {

        $useremail = isset($_POST['user_email']) ? sanitize_text_field($_POST['user_email']) : '';
        $password = isset($_POST['password']) ? sanitize_text_field($_POST['password']) : '';
        $remember_me = isset($_POST['remember']) ? sanitize_text_field($_POST['remember']) : '';

        if ($useremail != "" && $password != "") {
            $remember_me = isset($remember_me);
            $isemail = filter_var($useremail, FILTER_VALIDATE_EMAIL);
            $user = get_user_by(($isemail) ? 'email' : 'login', $useremail);
            if (!$user) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = 'Invalid login or password';
                $response['status'] = $remember_me;
                return $this->jsonResponse($response);
            }
            if (wp_check_password($password, $user->data->user_pass, $user->ID)) {

                $creds = array(
                    'user_login' => $user->data->user_login,
                    'user_password' => $password,
                    'remember'      => false
                );
                $user = wp_signon($creds, false);
                if (is_wp_error($user)) {
                    $passwordErr = "Can't login";
                    $response['title'] = "Error";
                    $response['icon'] = "error";
                    $response['message'] = $user->get_error_message();
                    $response['status'] = false;
                } else {
                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['auto_redirect'] = true;
                    $response['status'] = true;
                    $response['redirect_url'] = home_url('subscriptions');
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
        return $this->jsonResponse($response);
    }

    public function email_validation()
    {

        if (empty($_REQUEST['user_email'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Email Field";
            return $this->jsonResponse($response);
        }

        if (email_exists(trim($_REQUEST['user_email']))) {
            $response['icon'] = "error";
            $response['message']  = '<p class="validation-msg">Account already exists with this email. Kindly log in to complete the purchase, <a class="l-link" href="' . home_url('login') . '">Login</a></p>';
            $response['status'] = false;
            return $this->jsonResponse($response);
        }

        $response['status'] = true;
        return $this->jsonResponse($response);
    }

    function purchase_plan()
    {
        // var_dump($_POST['form_data']);
        // exit;
        parse_str($_POST['form_data'], $form_data); // Convert serialized string to array

        $plan_price = isset($form_data['plan_price']) ? sanitize_text_field($form_data['plan_price']) : '';
        $filter_type = isset($form_data['filter_type']) ? sanitize_text_field($form_data['filter_type']) : '';
        $filter_num = isset($form_data['filter_num']) ? sanitize_text_field($form_data['filter_num']) : '';
        $password = 'yupRJoGpuJYq9YJ';

        if ($form_data['email'] == '') {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['title'] = "Error";
            $response['message'] = "Please Fill All Required Fields";
            return $this->jsonResponse($response);
        }


        // if (email_exists(trim($form_data['email']))) {
        //     $response['icon'] = "error";
        //     $response['message']  = 'The E-mail , you enetered is already registered, Try another one.';
        //     $response['title'] = "Error";
        //     $response['status'] = false;
        //     return $this->jsonResponse($response);
        // }


        if ($_POST['subscription_id'] == '') {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['title'] = "Error";
            $response['message'] = "Try again, something's amiss!";
            return $this->jsonResponse($response);
        }

        // var_dump($form_data['c_name']);
        // exit;

        if (is_user_logged_in()) {
            // User is logged in, get user by email
            $get_user = get_user_by('email', wp_get_current_user()->user_email);
            $response['message'] = "Thank you for buying!";
        } else {
            $userdata = array(
                'first_name' => $form_data['c_name'],
                'last_name' => '',
                'user_login' => $form_data['email'],
                'user_email' =>  $form_data['email'],
                'user_pass' =>   $password,
            );
            $user = wp_insert_user($userdata);
            // Get the newly created user by email
            $get_user = get_user_by('email', $form_data['email']);
            $response['message'] = "Thank you for buying! Set your password. a message was sent to your email address.";
        }

        if ($get_user) {
            $order_data = array(
                'post_title'   => $form_data['c_name'] . '_' . $_POST['subscription_id'],
                'post_status'  => 'publish',
                'post_type'    => 'filter-orders',
                'post_author'       =>  $get_user->ID,
            );
            $post_id = wp_insert_post($order_data);

            $order_detail_data = array(
                'post_title'   => $form_data['c_name'] . '_' . $_POST['subscription_id'],
                'post_status'  => 'publish',
                'post_type'    => 'payment-detail',
                'post_author'       =>  $get_user->ID,
            );
            $order_detail_id = wp_insert_post($order_detail_data);

            if (!is_user_logged_in()) {
                $code = $this->generateRandomString($length = 4);
                setcookie("verification_code", $code, time() + 3000, "/");
                setcookie("verific_user_id", $get_user->ID, time() + 3000, "/");
                ob_start();
                include get_stylesheet_directory() . '/custom/email_templates/set-password.php';
                $email_content = ob_get_contents();
                ob_end_clean();
                $headers = array('Content-Type: text/html; charset=UTF-8');
                $msg = wp_mail($form_data['email'], "Merv Air", $email_content, $headers);
                if ($msg) {
                    $response['icon'] = "success";
                    $response['status'] = true;
                }
            }
        }

        if ($post_id) {
            update_post_meta($post_id, 'plan_price', $plan_price);
            update_post_meta($post_id, 'c_name', $form_data['c_name']);
            update_post_meta($post_id, 'email', $form_data['email']);
            update_post_meta($post_id, 'tel', $form_data['tel']);
            update_post_meta($post_id, 'address', $form_data['address']);
            update_post_meta($post_id, 'filter_type', $filter_type);
            update_post_meta($post_id, 'filter_num', $filter_num);
            update_post_meta($post_id, 'subscription_id', $_POST['subscription_id']);
            update_post_meta($post_id, 'user', $get_user->ID);
            update_post_meta($post_id, 'start_date', date('Y-m-d'));
            update_post_meta($post_id, 'end_plan', date('Y-m-d', strtotime('+1 year', strtotime(date('Y-m-d')))));

            update_post_meta($order_detail_id, 'order_id', $post_id);
            update_post_meta($order_detail_id, 'next_payment', date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-d')))));
            update_post_meta($order_detail_id, 'user', $get_user->ID);
            update_post_meta($order_detail_id, 'plan_price', $plan_price);

            ob_start();
            include get_stylesheet_directory() . '/custom/email_templates/order_notifiy.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $msg = wp_mail($form_data['email'], "Merv Air", $email_content, $headers);
        }

        if (is_wp_error($post_id) || is_wp_error($user)) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['title'] = "Error";
            $response['message'] = "Try again, something's amiss!";
        } else {
            $creds = array(
                'user_login' => $form_data['email'],
                'user_password' =>  $password
            );

            wp_signon($creds, false);
            $response['icon'] = "success";
            $response['status'] = true;
            $response['title'] = "Success";
            // $response['message'] = "Thank you for buying! Set your password. a message was sent to your email address.";
            $response['redirect'] =  site_url('subscriptions');
        }

        return $this->jsonResponse($response);
    }

    function reset_password_custom()
    {

        if (!isset($_COOKIE['verific_user_id']) || $_COOKIE['verific_user_id'] == "") {
            $response['icon'] = "error";
            $response['message'] = 'TimeOut Please Try Again';
            $response['status'] = false;
            return $this->jsonResponse($response);
        }

        if (!isset($_COOKIE['verification_code']) || $_COOKIE['verification_code'] != $_POST['verification_code']) {
            $response['icon'] = "error";
            $response['message'] = 'Try again verification code is not match';
            $response['status'] = false;
            return $this->jsonResponse($response);
        }

        if ($_POST['password'] == "" or $_POST['password_re'] == "") {
            $response['icon'] = "error";
            $response['message'] = 'Please fill all required fields correctly';
            $response['status'] = false;
            return $this->jsonResponse($response);
        }

        if ($_POST['password'] != $_POST['password_re']) {
            $response['icon'] = "error";
            $response['message'] = 'Password not Match';
            $response['status'] = false;
            return $this->jsonResponse($response);
        }

        wp_set_password($_POST['password'], $_COOKIE['verific_user_id']);
        $response['icon'] = "success";
        $response['message']  = "Password Reset Successfully";
        $response['status'] = true;
        $response['redirect_url'] = home_url("login");

        return $this->jsonResponse($response);
    }

    public function generateRandomString($length = 8)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function register_post_type()
    {
        register_post_type(
            'filter-orders',
            array(
                'labels'      => array(
                    'name'          => __('Filter Orders', 'textdomain'),
                    'singular_name' => __('Filter Orders', 'textdomain'),
                ),
                'public'      => true,
                'has_archive' => false,
                'supports' => array('title')
            )
        );
    }

    function subscription_plan_id_post_type()
    {
        register_post_type(
            'plans_id',
            array(
                'labels'      => array(
                    'name'          => __('Subscription Plans Ids', 'textdomain'),
                    'singular_name' => __('Subscription Plans Ids', 'textdomain'),
                ),
                'public'      => true,
                'has_archive' => false,
                //'show_ui' => false,
                'supports' => array('title')
            )
        );
    }

    function payment_detail_post_type()
    {
        register_post_type(
            'payment-detail',
            array(
                'labels'      => array(
                    'name'          => __('Payment Details', 'textdomain'),
                    'singular_name' => __('Payment Details', 'textdomain'),
                ),
                'public'      => true,
                'has_archive' => false,
                'show_ui' => false,
                'supports' => array('title')
            )
        );
    }

    function jsonResponse($response)
    {
        echo json_encode($response);
        wp_die();
    }
}
new MainClass();
