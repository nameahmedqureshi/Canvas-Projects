<?php
class StripeInvoice {

    function __construct(){

        $variable = array('create_invoice', 'delete_invoice');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }

        $cpt = array('register_invoice_post_type');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }

    }

    function create_invoice() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
   
        $required_fields = ['title', 'description', 'amount'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                return $this->response_json([
                    'icon' => "error",
                    'status' => false,
                    'message' => "Please fill all required fields"
                ]);
            }
        }

        if($_POST['amount'] <= 0){
            return $this->response_json([
                'icon' => "error",
                'status' => false,
                'message' => "Please enter a valid amount"
            ]);
        }

        $stripe =  \Stripe\Stripe::setApiKey('sk_test_51PNfoGAOqJbE4AIG60PBPpGQCAVI9i6t6K9xSwPwsfyrwGSMl7WCf4SoPRsKqrhDJ49dGEGiue1GMRD7cVNQypPm00Jf7F4l8Z');

        $user = get_userdata($_POST['user_id']);
        $user_email = $user->user_email;

        // Create a Checkout Session
        try {
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $_POST['description'],
                        ],
                        'unit_amount' => $_POST['amount'] * 100, // Amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $user_email,
                'success_url' => home_url('success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => home_url(),
            ]);

           

            // var_dump($checkout_session);
            // exit;
            if($checkout_session->url){
                $post_data = array(
                    'post_title'   => $_POST['title'],
                    'post_content' => $_POST['description'],
                    'post_status'  => 'publish', 
                    'post_type'    => 'invoices',
                );
               
                $post_id = wp_insert_post($post_data);

                if (is_wp_error($post_id)) {
                    throw new Exception($post_id->get_error_message());
                }

                if($post_id){
                    update_post_meta($post_id,'amount',$_POST['amount']);
                    update_post_meta($post_id,'payment_link',$checkout_session->url);
                    update_post_meta($post_id,'user_id',$_POST['user_id']);
                    update_post_meta($post_id,'status', 'unpaid');
                    update_post_meta($post_id,'checkout_id', $checkout_session->id);
                }

                $response['auto_redirect'] = true;
                $response['icon'] = "success";
                $response['message'] = "Invoice created";
                $response['status'] = true;
                $response['redirect_url'] = home_url('invoice/');
                return $this->response_json($response);
            }
            

        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return $this->response_json($response);
        }

    }


    function delete_invoice() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['invoice_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Invoice not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['invoice_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = $result->get_error_message();
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Invoice deleted";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function register_invoice_post_type(){
        register_post_type('invoices',
            array(
                'labels'      => array(
                    'name'          => __('Invoices', 'textdomain'),
                    'singular_name' => __('Invoices', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title','editor','thumbnail'),
            )
        );
    }

    function response_json($response){
		echo json_encode($response);
		wp_die(); 
	}
}
new StripeInvoice();