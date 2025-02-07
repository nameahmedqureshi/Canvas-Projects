<?php
class ProductManage
{

    function __construct()
    {
        $variable = array('service_order', 'special_service_order');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }
    }


    public function service_order() {
        if (empty($_POST['vehicle_license_plate']) || empty($_POST['type']) || empty($_POST['garage_location']) || empty($_POST['classification']) || empty($_POST['model']) || empty($_POST['date']) ) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
    
        $current_user_id = get_current_user_id();
        $author_meta = get_user_meta($current_user_id);
        $author = get_userdata($current_user_id);
    
        // $test_credentials = get_field('test_credentials');
        // $secret_key = ($test_credentials == "sk_test_51MAZe4HnBjRuAp0i6FEIZsanltRn0GwMCtNOexCzqQaheGz1xuhw1iCShIywkSa3QNMtSuaWwiJqBTqb4u2JjnOb00Jm3Uhkj1") ? get_field('test_stripe_secret_key') : get_field('live_stripe_secret_key_copy');
    
        // if (empty($secret_key)) {
        //     $response['icon'] = "error";
        //     $response['title'] = "Error";
        //     $response['status'] = false;
        //     $response['message'] = "Please add Stripe key";
        //     return $this->response_json($response);
        // }
    
        \Stripe\Stripe::setApiKey("sk_test_51MAZe4HnBjRuAp0i6FEIZsanltRn0GwMCtNOexCzqQaheGz1xuhw1iCShIywkSa3QNMtSuaWwiJqBTqb4u2JjnOb00Jm3Uhkj1");
    
        $token = $_POST['stripeToken'];
        $charge_params = [
            'amount' => 100 * 100, // Amount in cents, adjust as needed
            'currency' => 'usd',
            'source' => $token,
            'description' => 'Service Order Payment'
        ];
    
        try {
            $charge = \Stripe\Charge::create($charge_params);
    
            if ($charge->status == "succeeded") {
                $post_data = array(
                    'post_title'   => $_POST['vehicle_license_plate'],
                    'post_content' => $_POST['client_requests'],
                    'post_status'  => 'publish',
                    'post_type'    => 'orders',
                );
    
                $post_id = wp_insert_post($post_data);
    
                if ($post_id) {
                    update_post_meta($post_id, 'panther_id', $_POST['panther_id']);
                    update_post_meta($post_id, 'garage_location', $_POST['garage_location']);
                    update_post_meta($post_id, 'classification', $_POST['classification']);
                    update_post_meta($post_id, 'service_id', $_POST['service_id']);
                    update_post_meta($post_id, 'type', $_POST['type']);
                    update_post_meta($post_id, 'make', $_POST['make']);
                    update_post_meta($post_id, 'model', $_POST['model']);
                    update_post_meta($post_id, 'year', $_POST['year']);
                    update_post_meta($post_id, 'date', $_POST['date']);
                    update_post_meta($post_id, 'usertype', $author_meta['type'][0]);
                    update_post_meta($post_id, 'birthday', $author_meta['birthday'][0]);
                    update_post_meta($post_id, 'number', $author_meta['number'][0]);
                    update_post_meta($post_id, 'first_name', $author_meta['first_name'][0]);
                    update_post_meta($post_id, 'last_name', $author_meta['last_name'][0]);
                    update_post_meta($post_id, 'user_email', $author->user_email);
                }
    
                if (is_wp_error($post_id)) {
                    $response['icon'] = "error";
                    $response['title'] = "Error";
                    $response['status'] = false;
                    $response['message'] = "Try again, something's amiss!";
                } else {
                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['message'] = "Order Successfully!";
                    $response['auto_redirect'] = true;
                    $response['status'] = true;
                    $response['redirect_url'] = home_url('');
                }
            } else {
                throw new Exception("Payment failed.");
            }
        } catch (Exception $e) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
    
        return $this->response_json($response);
    }

    public function special_service_order() {

        var_dump('ads');
        $get_data = [];
        foreach($_POST['special_service_id'] as $key => $value){
           
          $get_data[] =  get_post($value);


        }

        var_dump($get_data);
        exit;


        if (empty($_POST['vehicle_license_plate']) || empty($_POST['type']) || empty($_POST['garage_location']) || empty($_POST['classification']) || empty($_POST['model']) || empty($_POST['date']) ) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
    
        $current_user_id = get_current_user_id();
        $author_meta = get_user_meta($current_user_id);
        $author = get_userdata($current_user_id);
    
        // $test_credentials = get_field('test_credentials');
        // $secret_key = ($test_credentials == "sk_test_51MAZe4HnBjRuAp0i6FEIZsanltRn0GwMCtNOexCzqQaheGz1xuhw1iCShIywkSa3QNMtSuaWwiJqBTqb4u2JjnOb00Jm3Uhkj1") ? get_field('test_stripe_secret_key') : get_field('live_stripe_secret_key_copy');
    
        // if (empty($secret_key)) {
        //     $response['icon'] = "error";
        //     $response['title'] = "Error";
        //     $response['status'] = false;
        //     $response['message'] = "Please add Stripe key";
        //     return $this->response_json($response);
        // }
    
        \Stripe\Stripe::setApiKey("sk_test_51MAZe4HnBjRuAp0i6FEIZsanltRn0GwMCtNOexCzqQaheGz1xuhw1iCShIywkSa3QNMtSuaWwiJqBTqb4u2JjnOb00Jm3Uhkj1");
    
        $token = $_POST['stripeToken'];
        $charge_params = [
            'amount' => 100 * 100, // Amount in cents, adjust as needed
            'currency' => 'usd',
            'source' => $token,
            'description' => 'Service Order Payment'
        ];
    
        try {
            $charge = \Stripe\Charge::create($charge_params);
    
            if ($charge->status == "succeeded") {
                $post_data = array(
                    'post_title'   => $_POST['vehicle_license_plate'],
                    'post_content' => $_POST['client_requests'],
                    'post_status'  => 'publish',
                    'post_type'    => 'orders',
                );
    
                $post_id = wp_insert_post($post_data);
    
                if ($post_id) {
                    update_post_meta($post_id, 'panther_id', $_POST['panther_id']);
                    update_post_meta($post_id, 'garage_location', $_POST['garage_location']);
                    update_post_meta($post_id, 'classification', $_POST['classification']);
                    update_post_meta($post_id, 'service_id', $_POST['service_id']);
                    update_post_meta($post_id, 'type', $_POST['type']);
                    update_post_meta($post_id, 'make', $_POST['make']);
                    update_post_meta($post_id, 'model', $_POST['model']);
                    update_post_meta($post_id, 'year', $_POST['year']);
                    update_post_meta($post_id, 'date', $_POST['date']);
                    update_post_meta($post_id, 'usertype', $author_meta['type'][0]);
                    update_post_meta($post_id, 'birthday', $author_meta['birthday'][0]);
                    update_post_meta($post_id, 'number', $author_meta['number'][0]);
                    update_post_meta($post_id, 'first_name', $author_meta['first_name'][0]);
                    update_post_meta($post_id, 'last_name', $author_meta['last_name'][0]);
                    update_post_meta($post_id, 'user_email', $author->user_email);
                }
    
                if (is_wp_error($post_id)) {
                    $response['icon'] = "error";
                    $response['title'] = "Error";
                    $response['status'] = false;
                    $response['message'] = "Try again, something's amiss!";
                } else {
                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['message'] = "Order Successfully!";
                    $response['auto_redirect'] = true;
                    $response['status'] = true;
                    $response['redirect_url'] = home_url('');
                }
            } else {
                throw new Exception("Payment failed.");
            }
        } catch (Exception $e) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
    
        return $this->response_json($response);
    }

    function response_json($response)
    {
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
