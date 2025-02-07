<?php
class ProductManage
{

    function __construct()
    {
        $variable = array('service_order','get_service_price', 'service_status_update', 'upload_recorded_video', 'promotion_notifications', 'read_all_notifications');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        
        $cpt = array('register_notification', 'register_promotions');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    } 
    
    function get_service_price() {
        if (isset($_POST['service_id'])) {
            $service_id = intval($_POST['service_id']);
            $price = get_field('price', $service_id);
            wp_send_json_success(['price' => $price]);
        } else {
            wp_send_json_error();
        }
    }    

    function promotion_notifications() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['title']) || empty($_POST['content']) ) {
            $response = [
                'icon' => "error",
                'status' => false,
                'message' => "Please fill in the required fields."
            ];
            return $this->response_json($response);
        }

        $users = new WP_User_Query( array(
            'role'     => 'subscriber',
        ) );
        $registered_users = $users->get_results();

        $post_data = [
            'post_title'   => $_POST['title'],
            'post_content' => $_POST['content'],
            'post_status'  => 'publish',
            'post_type'    => 'promotions',
        ];

        $post_id = wp_insert_post($post_data);
        if($post_id){
            if ( !empty( $registered_users ) ) {
                foreach ( $registered_users as $user ) { 

                    if(get_current_user_id() ==  $user->ID){ continue; }
                    ob_start();
                    include get_stylesheet_directory() . '/custom/email_template/email-promotion.php';
                    $email_content = ob_get_contents();
                    ob_end_clean();
                    $headers = array('Content-Type: text/html; charset=UTF-8');
                    wp_mail($user->user_email, "Coaching", $email_content, $headers);

                    $subscriber_promotion_data = [
                        'post_title'   => $_POST['title'],
                        'post_content' => $_POST['content'],
                        'post_status'  => 'publish',
                        'post_type'    => 'promotions',
                        'post_author'    => $user->ID,
                    ];

                    $notification_id = wp_insert_post($subscriber_promotion_data);

                    if($notification_id){
                        // Add custom field for read/unread status
                        add_post_meta($notification_id, 'notification_status', 'unread');
                        add_post_meta($notification_id, 'user_id', $user->ID);
                    }
        

                }
            }
        }

        
        if (is_wp_error($post_id)) {
            $response = [
                'icon' => "error",
                'title' => "Error",
                'status' => false,
                'message' => "Try again, something's amiss!"
            ];
        } else {
            $response = [
                'icon' => "success",
                'title' => "Success",
                'message' => "Promotion notified to registered users!",
                'auto_redirect' => true,
                'status' => true,
                'redirect_url' => home_url('promotions/')
            ];
        }
        return $this->response_json($response);

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
        $unread_orders = new WP_Query($unread_order_notifications);

        $unread_promotion_notifications = array(
            'post_type'  => 'promotions',
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
        $unread_promotions = new WP_Query($unread_promotion_notifications);

        if( $unread_orders->found_posts == 0 && $unread_promotions->found_posts == 0){
            $response['status'] = false;
            return $this->response_json($response);
        }
       
        foreach ($unread_orders->posts ?? [] as $key => $value) {
            update_post_meta($value->ID, 'notification_status', 'read');
        }

        foreach ($unread_promotions->posts ?? [] as $key => $value) {
            update_post_meta($value->ID, 'notification_status', 'read');
        }
        
        $response['status'] = true;
        return $this->response_json($response);
    }

    public function service_order() {
        if (!is_user_logged_in()) {
            $response = [
                'icon' => "error",
                'status' => false,
                'message' => "Please login to book the service.",
                'redirect_url' => home_url('login-account/')
            ];
            return $this->response_json($response);
        }
    
        parse_str($_POST['form_data'], $form_data); // Convert serialized string to array

        // var_dump($_POST);
        // exit;

        // if (empty($form_data['first_name']) || empty($form_data['last_name']) || empty($form_data['phone']) || empty($form_data['email']) || empty($form_data['service'])) {
        //     $response = [
        //         'icon' => "error",
        //         'status' => false,
        //         'message' => "Please fill in the required fields."
        //     ];
        //     return $this->response_json($response);
        // }

        $current_user_id = get_current_user_id();
        $meta = get_post_meta($form_data['service']);
        $total_price = floatval($meta['price'][0]);

        $service_name = get_the_title($form_data['service']);

        if ($meta['dna_option'][0] && isset($form_data['service_dna'])) {
            $total_price * count($form_data['service_dna']);
        }

        // if ($meta['dna_option'][0] && empty($form_data['service_dna'])) {
        //     $response = [
        //         'icon' => "error",
        //         'status' => false,
        //         'message' => "Please select DNA option"
        //     ];
        //     return $this->response_json($response);
        // }

        

        // if ($meta['servic_type'][0] != "recorded") {
        //     if (empty($form_data['date']) || empty($form_data['slots'])) {
        //         $response = [
        //             'icon' => "error",
        //             'status' => false,
        //             'message' => "Please Select Date & Time"
        //         ];
        //         return $this->response_json($response);
        //     }
        // }
    
        // var_dump($meta);
        // exit;
    
        try {
    
            if ($_POST["payment_status"] == "COMPLETED" || $meta['servic_type'][0] == "in_person") {
                $post_data = [
                    'post_title'   => $form_data['service'],
                    'post_content' => $form_data['client_requests'],
                    'post_status'  => 'publish',
                    'post_type'    => 'orders',
                    'post_author' => $current_user_id
                ];
    
                $post_id = wp_insert_post($post_data);
    
                if ($post_id) {
                    update_post_meta($post_id, 'payment_id', $_POST['payment_id']);
                    update_post_meta($post_id, 'service_id', $form_data['service']);
                    update_post_meta($post_id, 'service_name', $service_name);
                    update_post_meta($post_id, 'user_id', $current_user_id);
                    update_post_meta($post_id, 'service_type', $meta['servic_type'][0]);
                    update_post_meta($post_id, 'service_price', $total_price);
                    update_post_meta($post_id, 'first_name', $form_data['first_name']);
                    update_post_meta($post_id, 'last_name', $form_data['last_name']);
                    update_post_meta($post_id, 'phone', $form_data['phone']);
                    update_post_meta($post_id, 'user_email', $form_data['email']);
                    update_post_meta($post_id, 'order_status', "Pending");
                    update_post_meta($post_id, 'service_dna', $form_data['service_dna']);
                    update_post_meta($post_id, 'slots', $meta['servic_type'][0] != "recorded" ? $form_data['slots'] : "-");
                    update_post_meta($post_id, 'date', $meta['servic_type'][0] != "recorded" ? $form_data['date'] : "");

                    ob_start();
                    include get_stylesheet_directory() . '/custom/email_template/email-service-booking.php';
                    $email_content = ob_get_contents();
                    ob_end_clean();
                    $headers = array('Content-Type: text/html; charset=UTF-8');
                    wp_mail($form_data['email'], "Coaching", $email_content, $headers);
                    wp_mail(get_option('admin_email'), "Coaching", $email_content, $headers);

                    $notification_title = 'New Order #'.$post_id;
                    $notification_content = '<p>Service: '.get_the_title($form_data['service']).' has been ordered on '. date("l jS \of F Y ") .'</p>';
                    $notification = $this->push_notifications($notification_title , $notification_content, 1);
                    if($notification["success"] == true){
                        // Add custom field for read/unread status
                        add_post_meta($notification["post_id"], 'notification_status', 'unread');
                        add_post_meta($notification["post_id"], 'user_id', 1);
                    }
               
                }
    
                if (is_wp_error($post_id)) {
                    $response = [
                        'icon' => "error",
                        'title' => "Error",
                        'status' => false,
                        'message' => "Try again, something's amiss!"
                    ];
                } else {
                    $response = [
                        'icon' => "success",
                        'title' => "Success",
                        'message' => "Thank you for booking our services!",
                        'auto_redirect' => true,
                        'status' => true,
                        'redirect_url' => home_url('all-orders/')
                    ];
                }
            } else {
                throw new Exception("Payment failed.");
            }
        } catch (Exception $e) {
            $response = [
                'icon' => "error",
                'title' => "Error",
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    
        return $this->response_json($response);
    }

    public function service_status_update(){

        // var_dump($_POST);
        // exit;

        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        $service = get_the_title($_POST['post_id']);
        $buyer = $_POST['user_id'];
        $buyer_service_title = get_the_title($service);

        $user_email = get_post_meta($_POST['post_id'], 'user_email', true);
        $result =  update_post_meta($_POST['post_id'], "order_status", "Completed");
        $amount =  update_post_meta($_POST['post_id'], "upsell_amount", $_POST['amount']);

        
        $notification_title = 'Service Status #'.$_POST['post_id'];
        $notification_content = '<p>'.$buyer_service_title.' has been completed on '. date("l jS \of F Y ") .'</p>';
        $notification = $this->push_notifications($notification_title , $notification_content, $buyer );
        if($notification["success"] == true){
            // Add custom field for read/unread status
            add_post_meta($notification["post_id"], 'notification_status', 'unread');
            add_post_meta($notification["post_id"], 'user_id', $buyer);
        }
   

    
        //         ob_start();
        //         include get_stylesheet_directory() . '/custom/email_template/email-service-complete.php';
        //         $email_content = ob_get_contents();
        //         ob_end_clean();
        //         $headers = array('Content-Type: text/html; charset=UTF-8');
        //         $msg = wp_mail($user_email, "Luxury Detailing", $email_content, $headers);
        
        if(!$result){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Try again, something's amiss!";
        }else{
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Booking has been completed, User notified";
            $response['order_status'] = "Completed";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function upload_recorded_video() {

        // var_dump($_FILES);
        // exit;
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "Please login, your session is expired.";
            $response['status'] = false;
            return $this->response_json($response);
        }

        $video = $_FILES["video"];
        $fileType = $_FILES['video']['type'];

        // List of accepted video MIME types
        $allowedMimeTypes = [
            'video/mp4',
            'video/avi',
            'video/mpeg',
            'video/quicktime',
        ];

        // Check the file's MIME type
        if (!in_array($fileType, $allowedMimeTypes)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "The file is not a valid video format.";
            $response['status'] = false;
            return $this->response_json($response);
        }
        
        $res = $this->uploadImage($video);
        if(!$res["success"]) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = $res["msg"];
            $response['status'] = false;

        } else {
            update_post_meta($_POST['order_id'], 'uploaded_recorded_video', $res['attach_id']);
            $service_id = get_post_meta($_POST['order_id'], 'service_id', true);
            $buyer = get_post_meta($_POST['order_id'], 'user_id', true);

            $notification_title = 'Service Status #'.$_POST['order_id'];
            $notification_content = '<p>Recorded video has been uploaded on '. date("l jS \of F Y ") .'</p>';
            $notification = $this->push_notifications($notification_title , $notification_content, $buyer );
            if($notification["success"] == true){
                // Add custom field for read/unread status
                add_post_meta($notification["post_id"], 'notification_status', 'unread');
                add_post_meta($notification["post_id"], 'user_id', $buyer);
            }

            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Video added successfully!";
            $response['status'] = true;
            $response['redirect_url'] = home_url('service-view-orders/?id='.$_POST['order_id']);

        }
    
        return $this->response_json($response);
    }

    function push_notifications($title, $content, $author){

        
        if (empty($title) || empty($content) || empty($author)) {
            return array(
                'success' => false,
                'message' => "Try again, something's amiss!",
            );
        }

        $post_data = array(
			'post_title'   => $title,
			'post_content' => $content,
			'post_status'  => 'publish', 
			'post_type'    => 'notifications',
			'post_author'	   => $author,
		);
       
        $post_id = wp_insert_post($post_data);

        
        
        if (is_wp_error($post_id)) {
          
            return array(
                'success' => false,
                'message' => "Try again, something's amiss!",
            );
        
        } else {
          

            return array(
                'success' => true,
                'post_id' => $post_id,
                'message' => "Notification push successfully!!",
            );
            
        }

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

    function register_promotions(){
        register_post_type('promotions',
			array(
				'labels'      => array(
					'name'          => __('Promotions', 'textdomain'),
					'singular_name' => __('Promotions', 'textdomain'),
				),
					'public'      => true,
					'has_archive' => true,
					'supports' => array('title','editor'),
			)
		);
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
