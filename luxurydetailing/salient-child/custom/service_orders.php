<?php
class ProductManage
{

    function __construct()
    {
        $variable = array('service_order', 'special_service_order', 'service_status_update');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }
    }


    public function service_order() {

        //   var_dump(get_option('admin_email'));
        //   exit;
        
        if (empty($_POST['type']) || empty($_POST['garage_location']) || empty($_POST['model']) || empty($_POST['date']) ) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
    
        if(is_user_logged_in()){
            $current_user_id = get_current_user_id();
            $author_meta = get_user_meta($current_user_id);
            $author = get_userdata($current_user_id);
            $receipt_email = $author->user_email;
        } else {
            $receipt_email = $_POST['guest_email'];
        }

       
    
        // $payLater  = isset($_POST['pay_later']);
        $payLater  = false;
        $token = $_POST['stripeToken'];

        $total_price = 0;
        $order_summary = [];

        $cars_price = intval(get_post_meta($_POST['service_id'], 'cars_price', true));
        $truck_price =  intval(get_post_meta($_POST['service_id'],'truck_price',true));
        $over_sized =  intval(get_post_meta($_POST['service_id'],'over_sized',true));


        if($_POST['type'] == 'over_sized' ){
            $total_price += $over_sized;
            $order_summary[] = [
                "title" => get_the_title($_POST['service_id']),
                "price" => $over_sized,
            ];
        }
        if($_POST['type']  == 'car' ){
            $total_price += $cars_price;
            $order_summary[] = [
                "title" => get_the_title($_POST['service_id']),
                "price" => $cars_price,
            ];
        }
        if($_POST['type'] == 'trucks' ){
            $total_price += $truck_price;
            $order_summary[] = [
                "title" => get_the_title($_POST['service_id']),
                "price" => $truck_price,
            ];
        }

        $tip_price = intval($_POST['tip']);
        if($_POST['tip'] == 'other'){
            $tip_price = intval($_POST['custom_tip']);

        }
        $total_price += $tip_price;

        // var_dump($total_price);
        // exit;
    
        // $test_credentials = get_field('test_credentials');
        // $secret_key = ($test_credentials == "sk_test_51MAZe4HnBjRuAp0i6FEIZsanltRn0GwMCtNOexCzqQaheGz1xuhw1iCShIywkSa3QNMtSuaWwiJqBTqb4u2JjnOb00Jm3Uhkj1") ? get_field('test_stripe_secret_key') : get_field('live_stripe_secret_key_copy');
    
        // if (empty($secret_key)) {
        //     $response['icon'] = "error";
        //     $response['title'] = "Error";
        //     $response['status'] = false;
        //     $response['message'] = "Please add Stripe key";
        //     return $this->response_json($response);
        // }

        // $stripe = new \Stripe\StripeClient("sk_test_51MAZe4HnBjRuAp0i6FEIZsanltRn0GwMCtNOexCzqQaheGz1xuhw1iCShIywkSa3QNMtSuaWwiJqBTqb4u2JjnOb00Jm3Uhkj1");
        // live account 
        // $stripe = new \Stripe\StripeClient("sk_test_51PXpcrIIqqE89EoUyPnJYkHYqHqw21OC5zFS8JcdOJAibIQQ5FEeTVLoz9cHhmZRGaPhuln9GfLKrrLWLz3Bnc3z00wgSDhjQo");
        $stripe = new \Stripe\StripeClient("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");
    
        try {
            if (!$payLater) {
                
                $charge = $stripe->charges->create([
                    'amount' => $total_price * 100, // Amount in cents, adjust as needed
                    'currency' => 'usd',
                    'source' => $token,
                    'receipt_email' => $receipt_email,
                    'description' => 'Single Service Order Payment'
                ]);
            }
    
            if ($charge->status == "succeeded" || $payLater) {
                $post_data = array(
                    'post_title'   => $_POST['vehicle_license_plate'],
                    'post_content' => $_POST['client_requests'],
                    'post_status'  => $payLater ? 'draft' : 'publish',
                    'post_type'    => 'orders',
                );
    
                $post_id = wp_insert_post($post_data);
    
                if ($post_id) {
                    update_post_meta($post_id, 'garage_location', $_POST['garage_location']);
                    update_post_meta($post_id, 'service_id', $_POST['service_id']);
                    update_post_meta($post_id, 'type', $_POST['type']);
                    update_post_meta($post_id, 'make', $_POST['make']);
                    update_post_meta($post_id, 'model', $_POST['model']);
                    update_post_meta($post_id, 'year', $_POST['year']);
                    update_post_meta($post_id, 'date', $_POST['date']);
                    update_post_meta($post_id, 'order_status',"Pending");
                    update_post_meta($post_id, 'order_summary', $order_summary);
                    // update_post_meta($post_id, 'birthday', $author_meta['birthday'][0]);
                    update_post_meta($post_id, 'total_price', $total_price);
                    update_post_meta($post_id, 'tip_price',$tip_price);
                    update_post_meta($post_id, 'pickup_time',$_POST['pickup_time']);


                    if(!is_user_logged_in()){
                        update_post_meta($post_id, 'first_name', $_POST['guest_first_name']);
                        update_post_meta($post_id, 'last_name', $_POST['guest_last_name']);
                        update_post_meta($post_id, 'user_email', $_POST['guest_email']);
                        update_post_meta($post_id, 'number', $_POST['guest_phone']);
                        update_post_meta($post_id, 'user_buying_type', 'Quick Book');

                       $this->sendOrderEmail($_POST['guest_email'], false, 'single');
                    }else {
                        update_post_meta($post_id, 'number', $author_meta['number'][0]);
                        update_post_meta($post_id, 'first_name', $author_meta['first_name'][0]);
                        update_post_meta($post_id, 'last_name', $author_meta['last_name'][0]);
                        update_post_meta($post_id, 'user_email', $author->user_email);
                        update_post_meta($post_id, 'usertype', $author_meta['type'][0]);
                        update_post_meta($post_id, 'panther_id', $author_meta['panther_id'][0]);
                        update_post_meta($post_id, 'classification', $author_meta['classification'][0]);
                        update_post_meta($post_id, 'user_buying_type', 'Registered User');

                       $this->sendOrderEmail($author->user_email, false, 'single');
                    }

                   $this->sendOrderEmail( get_option('admin_email'), true, 'single');

                }
    
                if (is_wp_error($post_id)) {
                    $response['icon'] = "error";
                    $response['title'] = "Error";
                    $response['status'] = false;
                    $response['message'] = "Try again, something's amiss!";
                } else {
                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['message'] = "Thank You For Booking Our Services!";
                    $response['auto_redirect'] = true;
                    $response['status'] = true;
                    $response['redirect_url'] = home_url('history');
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

       

        if ( empty($_POST['type']) || empty($_POST['garage_location']) || empty($_POST['model']) || empty($_POST['date']) ) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }

        if(is_user_logged_in()){
            $current_user_id = get_current_user_id();
            $author_meta = get_user_meta($current_user_id);
            $author = get_userdata($current_user_id);
            $receipt_email = $author->user_email;
        } else {
            $receipt_email = $_POST['guest_email'];
        }

        // $payLater  = isset($_POST['pay_later']);
        $payLater  = false;

        $total_price = 0;
        $order_summary = [];
        foreach($_POST['special_service_id'] as $key => $value){
           
            $get_post_data = get_post($value);
            $single_price =  intval(get_post_meta($value,'single_price',true));
            $cars_price = intval(get_post_meta($value, 'cars_price', true));
            $truck_price =  intval(get_post_meta($value,'truck_price',true));
            $over_sized =  intval(get_post_meta($value,'over_sized',true));

            if($single_price){
                $total_price += $single_price;
                $order_summary[] = [
                    "title" => $get_post_data->post_title,
                    "price" => $single_price,
                ];
            }

            if($_POST['type'] == 'over_sized' && empty($single_price)){
                $total_price += $over_sized;
                $order_summary[] = [
                    "title" => $get_post_data->post_title,
                    "price" => $over_sized,
                ];
            }
            if($_POST['type']  == 'car' && empty($single_price)){
                $total_price += $cars_price;
                $order_summary[] = [
                    "title" => $get_post_data->post_title,
                    "price" => $cars_price,
                ];
            }
            if($_POST['type'] == 'trucks' && empty($single_price)){
                $total_price += $truck_price;
                $order_summary[] = [
                    "title" => $get_post_data->post_title,
                    "price" => $truck_price,
                ];
            }
            
           

        }

        $tip_price = intval($_POST['tip']);
        if($_POST['tip'] == 'other'){
            $tip_price = intval($_POST['custom_tip']);

        }
        $total_price += $tip_price;
     
        // var_dump($total_price);
        // exit;

        // $test_credentials = get_field('test_credentials');
        // $secret_key = ($test_credentials == "sk_test_51MAZe4HnBjRuAp0i6FEIZsanltRn0GwMCtNOexCzqQaheGz1xuhw1iCShIywkSa3QNMtSuaWwiJqBTqb4u2JjnOb00Jm3Uhkj1") ? get_field('test_stripe_secret_key') : get_field('live_stripe_secret_key_copy');
    
        // if (empty($secret_key)) {
        //     $response['icon'] = "error";
        //     $response['title'] = "Error";
        //     $response['status'] = false;
        //     $response['message'] = "Please add Stripe key";
        //     return $this->response_json($response);
        // }
    
        // $stripe = new \Stripe\StripeClient("sk_test_51MAZe4HnBjRuAp0i6FEIZsanltRn0GwMCtNOexCzqQaheGz1xuhw1iCShIywkSa3QNMtSuaWwiJqBTqb4u2JjnOb00Jm3Uhkj1");
        // live account 
        // $stripe = new \Stripe\StripeClient("sk_test_51PXpcrIIqqE89EoUyPnJYkHYqHqw21OC5zFS8JcdOJAibIQQ5FEeTVLoz9cHhmZRGaPhuln9GfLKrrLWLz3Bnc3z00wgSDhjQo");
        $stripe = new \Stripe\StripeClient("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");
    
        $token = $_POST['stripeToken'];
        try {
            if (!$payLater) {
                $charge = $stripe->charges->create([
                    'amount' => $total_price * 100, // Amount in cents, adjust as needed
                    'currency' => 'usd',
                    'source' => $token,
                    'receipt_email' => $receipt_email,
                    'description' => 'Service Order Payment'
                ]);
            }
    
            if ($charge->status == "succeeded" || $payLater) {
                $post_data = array(
                    'post_title'   => $_POST['vehicle_license_plate'],
                    'post_content' => $_POST['client_requests'],
                    'post_status'  => $payLater ? 'draft' : 'publish',
                    'post_type'    => 'orders',
                );
    
                $post_id = wp_insert_post($post_data);
    
                if ($post_id) {
                  
                    update_post_meta($post_id, 'garage_location', $_POST['garage_location']);
                    // update_post_meta($post_id, 'service_id', $_POST['service_id']);
                    update_post_meta($post_id, 'type', $_POST['type']);
                    update_post_meta($post_id, 'make', $_POST['make']);
                    update_post_meta($post_id, 'model', $_POST['model']);
                    update_post_meta($post_id, 'year', $_POST['year']);
                    update_post_meta($post_id, 'date', $_POST['date']);
                    update_post_meta($post_id, 'order_status',"Pending");
                    update_post_meta($post_id, 'order_summary', $order_summary);
                    update_post_meta($post_id, 'total_price', $total_price);
                    update_post_meta($post_id, 'tip_price',$tip_price);
                    update_post_meta($post_id, 'pickup_time',$_POST['pickup_time']);


                    $titles = array_column($order_summary, 'title');
                    $titlesString = implode(', ', $titles);

                    if(!is_user_logged_in()){
                        update_post_meta($post_id, 'first_name', $_POST['guest_first_name']);
                        update_post_meta($post_id, 'last_name', $_POST['guest_last_name']);
                        update_post_meta($post_id, 'user_email', $_POST['guest_email']);
                        update_post_meta($post_id, 'number', $_POST['guest_phone']);
                        update_post_meta($post_id, 'user_buying_type', 'Quick Book');

                       $this->sendOrderEmail($_POST['guest_email'], false, 'special', $titlesString);

                    } else {
                        update_post_meta($post_id, 'panther_id', $author_meta['panther_id'][0]);
                        update_post_meta($post_id, 'usertype', $author_meta['type'][0]);
                        update_post_meta($post_id, 'birthday', $author_meta['birthday'][0]);
                        update_post_meta($post_id, 'number', $author_meta['number'][0]);
                        update_post_meta($post_id, 'first_name', $author_meta['first_name'][0]);
                        update_post_meta($post_id, 'last_name', $author_meta['last_name'][0]);
                        update_post_meta($post_id, 'user_email', $author->user_email);
                        update_post_meta($post_id, 'classification', $author_meta['classification'][0]);
                        update_post_meta($post_id, 'user_buying_type', 'Registered User');

                        $this->sendOrderEmail($author->user_email, false, 'special', $titlesString);

                    }

               
                   
                    // var_dump($titlesString);
                    // exit;
                   $this->sendOrderEmail( get_option('admin_email'), true, 'special', $titlesString);
                }
    
                if (is_wp_error($post_id)) {
                    $response['icon'] = "error";
                    $response['title'] = "Error";
                    $response['status'] = false;
                    $response['message'] = "Try again, something's amiss!";
                } else {
                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['message'] = "Thank You For Booking Our Services!";
                    $response['auto_redirect'] = true;
                    $response['status'] = true;
                    $response['redirect_url'] = home_url('history');
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

    function sendOrderEmail($email, $isAdmin = false, $type, $titlesString = '') {
        // send email
        if(is_user_logged_in()){
            $current_user_id = get_current_user_id();
            $author_meta = get_user_meta($current_user_id);
            $author = get_userdata($current_user_id);
            $u_name = $author_meta['first_name'][0];
            $u_email = $author->user_email;
            $u_num = $author_meta['number'][0];
        } else {
            $u_name = $_POST['guest_first_name'];
            $u_email = $_POST['guest_email'];
            $u_num = $_POST['guest_phone'];
        }



        $email_send_to = $email;
        ob_start();
        include get_stylesheet_directory() . '/custom/email_template/email-service-order.php';
        $email_content = ob_get_contents();
        ob_end_clean();
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $msg = wp_mail($email_send_to, "Luxury Detailing", $email_content, $headers);
    }

    function response_json($response)
    {
        echo json_encode($response);
        wp_die();
    } 

    public function service_status_update(){

        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        $post_data = wp_update_post([
            'ID'           => $_POST['post_id'],
            'post_status'  => 'publish',
        ]);
    
        $service_title = get_the_title($_POST['post_id']);

        $user_email = get_post_meta($_POST['post_id'], 'user_email', true);
        $result =  update_post_meta($_POST['post_id'], "order_status", "Completed");

        ob_start();
        include get_stylesheet_directory() . '/custom/email_template/email-service-complete.php';
        $email_content = ob_get_contents();
        ob_end_clean();
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $msg = wp_mail($user_email, "Luxury Detailing", $email_content, $headers);
       
        if(!$result){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Try again, something's amiss!";
        }else{
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Booking has been completed, User notified via email";
            $response['order_status'] = "Completed";
            $response['status'] = true;
        }
        return $this->response_json($response);
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
