<?php
class PayoutClass{

    function __construct() {
        $variable = array('payout_request', 'send_payout_using_stripe', 'send_payout_using_bank','get_publishable_key');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_payout_post_type');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function get_publishable_key() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

      
        $user_id = $this->decryptData($_POST['user']); 
       
        $stripe_data = get_user_meta($user_id, 'stripe_details', true);
        // var_dump($user_id);
        // exit;
        if(empty($stripe_data)){
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Stripe not set";
		}
        else {
            $publishable_key = $stripe_data['publishable_key'];
            $response['title'] = "Success";
            $response['publishable_key'] = $publishable_key;
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function payout_request() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

        if (empty($_POST['payout_amount']) || empty($_POST['payout_description'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['title'] = "Error";
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }

        // global $wpdb;
        // Prepare the SQL query for service orders sales count
        // $query = $wpdb->prepare("
        // SELECT SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
        // FROM {$wpdb->postmeta} pm
        // JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        // JOIN {$wpdb->postmeta} pm_vendor ON p.ID = pm_vendor.post_id
        // WHERE pm.meta_key = %s
        // AND pm_vendor.meta_key = %s
        // AND pm_vendor.meta_value = %d
        // AND p.post_type = %s
        // AND p.post_status IN ('draft', 'publish')
        // ", 'total_price', 'vendor_id', get_current_user_id() ,'services-order');

        // Execute the query
        // $services_sales_query = $wpdb->get_var($query);

        // Prepare the SQL query for product orders sales count
        // $query = $wpdb->prepare('
        // SELECT SUM(CAST(wp_wc_order_stats.net_total AS UNSIGNED))  AS total_amount
        // FROM wp_wc_order_stats 
        // INNER JOIN wp_wc_orders_meta ON 
        // wp_wc_order_stats.order_id = wp_wc_orders_meta.order_id 
        // WHERE wp_wc_orders_meta.meta_key = "_seller_id"
        // AND wp_wc_orders_meta.meta_value = "'.get_current_user_id().'"');
        // // Execute the query
        // $product_sales_query = $wpdb->get_var($query);

        // Prepare the SQL query for commission_amount
        // $com = $wpdb->prepare('
        // SELECT SUM(CAST(commission_meta.meta_value AS UNSIGNED)) AS commission_amount
        // FROM wp_wc_order_stats
        // INNER JOIN wp_wc_orders_meta AS seller_meta ON wp_wc_order_stats.order_id = seller_meta.order_id
        // INNER JOIN wp_wc_orders_meta AS commission_meta ON wp_wc_order_stats.order_id = commission_meta.order_id
        // WHERE seller_meta.meta_key = "_seller_id"
        // AND seller_meta.meta_value = "'.get_current_user_id().'"
        // AND commission_meta.meta_key = "commission_amount"');
        // // Execute the query
        // $commission_amount = $wpdb->get_var($com);

        // Prepare the SQL query for on demand services commission_amount
        // $ondemand = $wpdb->prepare("
        // SELECT SUM(CAST(pm.meta_value AS UNSIGNED)) AS commission_amount
        // FROM {$wpdb->postmeta} pm
        // JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        // JOIN {$wpdb->postmeta} pm_vendor ON p.ID = pm_vendor.post_id
        // WHERE pm.meta_key = %s
        // AND pm_vendor.meta_key = %s
        // AND pm_vendor.meta_value = %d
        // AND p.post_type = %s
        // AND p.post_status IN ('draft', 'publish')
        // ", 'commission_amount', 'vendor_id', get_current_user_id() ,'services-order');
        // // Execute the query
        // $on_demand_commission_amount = $wpdb->get_var($ondemand);

        // $commisions = abs($on_demand_commission_amount + $commission_amount);

        // $total_amount_of_product_and_serives_sales = $product_sales_query + $services_sales_query;
        // $total_amount_of_product_and_serives_sales  = $total_amount_of_product_and_serives_sales - $commisions;

        // get payout amount 
        // $payout_amount = $wpdb->prepare('SELECT SUM(CAST(pm.meta_value AS UNSIGNED))  AS total_amount
        // FROM wp_posts as p 
        // INNER JOIN wp_postmeta as pm ON 
        // p.ID = pm.post_id 
        // WHERE pm.meta_key = "payout_amount"
        // AND p.post_type = "payouts"
        // AND p.post_author = "'.get_current_user_id().'"');
        // // Execute the query
        // $get_payout_amount = $wpdb->get_var($payout_amount);

        // $available_payout_amount = $total_amount_of_product_and_serives_sales - $get_payout_amount;
        
        $sales_and_commission_data = $this->get_user_sales_and_commission_data(get_current_user_id());

        $available_payout_amount = $sales_and_commission_data['net_amount'];

        if($_POST['payout_amount'] <= 0  || $_POST['payout_amount'] > $available_payout_amount ){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You have insufficient balance";
            return $this->response_json($response);
        }
            
        $stripe_data = get_user_meta(get_current_user_id(), 'stripe_details', true);
        $bank_data = get_user_meta(get_current_user_id(), 'bank_details', true);
        if(empty($stripe_data)){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please set your stripe account keys";
            return $this->response_json($response);
		}

        if( empty($bank_data )){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please set your bank account details";
            return $this->response_json($response);
		}

        $post_data = array(
			'post_title'   => '#'.wp_get_current_user()->ID.'-'.wp_get_current_user()->first_name,
			'post_content'  => $_POST['payout_description'], 
			'post_status'  => 'draft', 
			'post_type'    => 'payouts',
			'post_author'	   => get_current_user_id(),
		);
       
        $post_id = wp_insert_post($post_data);

        if($post_id){
            update_post_meta($post_id, 'vendor', wp_get_current_user()->first_name);
            update_post_meta($post_id, 'payout_amount', $_POST['payout_amount']);
            update_post_meta($post_id, 'user_type', wp_get_current_user()->roles[0]);
        }

        if (is_wp_error($post_id)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $post_id->get_error_message();
        
        } else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Payout Request Sent successfully!";
            $response['auto_redirect'] = true;
            $response['status'] = true;
            $response['redirect_url'] = site_url('payout');
        }

        return $this->response_json($response);

    }

    function send_payout_using_stripe() {
      
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

        if (empty($_POST['stripeToken'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Stripe token not initialized.";
            return $this->response_json($response);
        }

 
       
        $post_id = $this->decryptData($_POST['request_id']); 
        $get_post = get_post($post_id);

        if ($get_post->post_status == 'publish') {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This payout request already been paid.";
            return $this->response_json($response);
        }

        $price = get_post_meta($post_id, 'payout_amount', true );
        $stripe_data = get_user_meta($get_post->post_author, 'stripe_details', true);
        if(empty( $stripe_data)){
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Stripe not configure by vendor.";
            return $this->response_json($response);
        }
        $secret_key = $stripe_data['secret_key'];
        // Set Stripe secret key
        $token = $_POST['stripeToken'];
        \Stripe\Stripe::setApiKey($secret_key);
        // var_dump( $get_post );
        // exit;

        $charge_params = [
            'amount' => $price * 100, // Amount in cents
            'currency' => 'usd',
            'source' => $token,
            'description' => 'Payout Request Payment'
        ];
        try {
            $charge = \Stripe\Charge::create($charge_params);
            if ($charge->status == "succeeded") {
                $post_data = array(
                    'ID' => $get_post->ID,
                    'post_status' => 'publish',
                    'post_type'    => 'payouts',
                );
                $updated_post_id = wp_update_post($post_data);


                if (is_wp_error($updated_post_id)) {
                    throw new Exception($updated_post_id->get_error_message());
                }

                if ($updated_post_id) {
                    update_post_meta($updated_post_id, 'status', $charge->status);
                    update_post_meta($updated_post_id, 'paid_date', date('Y/m/d'));
                }

                $response['auto_redirect'] = true;
                $response['icon'] = "success";
                $response['message'] = "Amount transfered succesfully.";
                $response['status'] = true;
                $response['redirect_url'] = home_url('payout-requests/');
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

    function send_payout_using_bank() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

        $post_id = $_POST['post_id']; 
       
        $get_post = get_post($post_id);
        $bank_details = get_user_meta($get_post->post_author, 'bank_details', true);
        // var_dump($_POST);
        // exit;
        if(empty($bank_details)){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Bank details not set by vendor";
			return $this->response_json($response);
        }

        if ($get_post->post_status == 'publish') {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This payout request already been paid.";
            return $this->response_json($response);
        }

        $post_data = array(
            'ID' => $get_post->ID,
            'post_status' => 'publish',
            'post_type'    => 'payouts',
        );
        $updated_post_id = wp_update_post($post_data);

        if ($updated_post_id) {
            update_post_meta($updated_post_id, 'status', 'succeeded');
            update_post_meta($updated_post_id, 'paid_date', date('Y/m/d'));
        }

        if (is_wp_error($updated_post_id)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $updated_post_id->get_error_message();
        } else {
            $response['auto_redirect'] = true;
            $response['icon'] = "success";
            $response['message'] = "Amount transfered succesfully.";
            $response['status'] = true;
            $response['redirect_url'] = home_url('payout-requests/');
        }
        return $this->response_json($response);

    }

    // Function to retrieve total sales and commission data for a vendor
    function get_user_sales_and_commission_data($user_id) {
        global $wpdb;

        // Services sales query
        // $services_sales_query = $wpdb->get_var($wpdb->prepare("
        //     SELECT SUM(CAST(pm.meta_value AS UNSIGNED)) AS total_amount
        //     FROM {$wpdb->postmeta} pm
        //     JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        //     JOIN {$wpdb->postmeta} pm_vendor ON p.ID = pm_vendor.post_id
        //     WHERE pm.meta_key = %s
        //     AND pm_vendor.meta_key = %s
        //     AND pm_vendor.meta_value = %d
        //     AND p.post_type = %s
        //     AND p.post_status IN ('draft', 'publish')
        // ", 'total_price', 'vendor_id', $user_id, 'services-order'));

        // Products sales query
        // $product_sales_query = $wpdb->get_var($wpdb->prepare("
        //     SELECT SUM(CAST(wp_wc_order_stats.net_total AS UNSIGNED)) AS total_amount
        //     FROM wp_wc_order_stats 
        //     INNER JOIN wp_wc_orders_meta ON wp_wc_order_stats.order_id = wp_wc_orders_meta.order_id 
        //     WHERE wp_wc_orders_meta.meta_key = %s
        //     AND wp_wc_orders_meta.meta_value = %d
        // ", '_seller_id', $user_id));

        // Commission amount query
        // $commission_query = $wpdb->get_var($wpdb->prepare("
        //     SELECT SUM(CAST(commission_meta.meta_value AS UNSIGNED)) AS commission_amount
        //     FROM wp_wc_order_stats
        //     INNER JOIN wp_wc_orders_meta AS seller_meta ON wp_wc_order_stats.order_id = seller_meta.order_id
        //     INNER JOIN wp_wc_orders_meta AS commission_meta ON wp_wc_order_stats.order_id = commission_meta.order_id
        //     WHERE seller_meta.meta_key = %s
        //     AND seller_meta.meta_value = %d
        //     AND commission_meta.meta_key = %s
        // ", '_seller_id', $user_id, 'commission_amount'));

        // On-demand services commission amount query
        // $on_demand_commission_query = $wpdb->get_var($wpdb->prepare("
        //     SELECT SUM(CAST(pm.meta_value AS UNSIGNED)) AS commission_amount
        //     FROM {$wpdb->postmeta} pm
        //     JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        //     JOIN {$wpdb->postmeta} pm_vendor ON p.ID = pm_vendor.post_id
        //     WHERE pm.meta_key = %s
        //     AND pm_vendor.meta_key = %s
        //     AND pm_vendor.meta_value = %d
        //     AND p.post_type = %s
        //     AND p.post_status IN ('draft', 'publish')
        // ", 'commission_amount', 'vendor_id', $user_id, 'services-order'));

        $total_sales = $wpdb->get_var($wpdb->prepare("
        SELECT SUM(CAST(pm.meta_value AS DECIMAL(10,2))) AS total_amount
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        INNER JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id
        WHERE pm.meta_key = %s
        AND pm2.meta_key = %s
        AND pm2.meta_value = %d
        AND p.post_type = %s
        ", 'total_price', 'vendor_id', $user_id, 'total_sales'));

        $total_commission = $wpdb->get_var($wpdb->prepare("
        SELECT SUM(CAST(pm.meta_value AS DECIMAL(10,2))) AS commission_amount
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        INNER JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id
        WHERE pm.meta_key = %s
        AND pm2.meta_key = %s
        AND pm2.meta_value = %d
        AND p.post_type = %s
        ", 'commission_amount', 'vendor_id', $user_id, 'total_sales'));

    
        // Payout amount query
        $payout_query = $wpdb->get_var($wpdb->prepare("
            SELECT SUM(CAST(pm.meta_value AS DECIMAL(10,2))) AS total_amount
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
            WHERE pm.meta_key = %s
            AND p.post_type = %s
            AND p.post_author = %d
        ", 'payout_amount', 'payouts', $user_id));

        // Calculate total commissions and net sales
        // $total_commissions = abs($on_demand_commission_query + $commission_query);
        // $total_sales = $product_sales_query + $services_sales_query - $total_commissions;
        $net_amount = abs($total_sales - $total_commission);
        $net_amount = $net_amount - $payout_query;

        // var_dump($total_sales);
        // var_dump($total_commission);
        // var_dump($net_amount);

        // Return all results as an array
        return [
            // 'services_sales' => $services_sales_query,
            // 'product_sales' => $product_sales_query,
            // 'commission_amount' => $commission_query,
            // 'on_demand_commission' => $on_demand_commission_query,
            // 'total_commissions' => $total_commissions,
            'payout_amount' => $payout_query,
            'net_amount' => $net_amount
        ];
    }

    function register_payout_post_type() {
        register_post_type('payouts',
            array(
                'labels'      => array(
                    'name'          => __('Payouts', 'textdomain'),
                    'singular_name' => __('Payouts', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title','editor'),
            )
        );
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


}
$payoutClass = new PayoutClass();