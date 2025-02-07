<?php
class SubscribersManage
{

    function __construct() {
        $variable = array( 'add_subscribers', 'delete_subscribers', 'send_promotion_email');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        
        $cpt = array( 'register_subscribers');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function add_subscribers() {

        if (empty($_POST['email']) ) {
            $response = [
                'icon' => "error",
                'title' => "Error",
                'status' => false,
                'message' => "Please fill in the required field."
            ];
            return $this->response_json($response);
        }

        global $wpdb;
        // Prepare the SQL query for get_subscribers
      
        $get_subscribers = $wpdb->get_results($wpdb->prepare("SELECT  p.post_title AS emails FROM {$wpdb->posts} AS p
        WHERE p.post_status = 'publish'
        AND p.post_type = 'subscribers'"), ARRAY_A);
        $emails = array_column($get_subscribers, 'emails');
        // var_dump($emails);
        // exit;

        if(in_array($_POST['email'], $emails)) {
            $response = [
                'icon' => "error",
                'title' => "Error",
                'status' => false,
                'message' => "This email address already subscribed our newsletter."
            ];
            return $this->response_json($response);
        }

        $post_data = [
            'post_title'   => $_POST['email'],
            'post_status'  => 'publish',
            'post_type'    => 'subscribers',
        ];

        $post_id = wp_insert_post($post_data);
        if($post_id){

            ob_start();
            include get_stylesheet_directory() . '/custom/email_template/welcome-subscriber.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($_POST['email'], "Kainamo", $email_content, $headers);
               
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
                'message' => "Thank you for subscribe our newsletter",
                'status' => true,
            ];
        }
        return $this->response_json($response);

    }

    function delete_subscribers() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['sub_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This subscriber are not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['sub_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "Subscriber not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Subscriber has been removed from list";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function send_promotion_email() {
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
                'title' => "Error",
                'status' => false,
                'message' => "Please fill in the required fields."
            ];
            return $this->response_json($response);
        }

        global $wpdb;
        $get_subscribers = $wpdb->get_results($wpdb->prepare("SELECT  p.post_title AS emails FROM {$wpdb->posts} AS p
        WHERE p.post_status = 'publish'
        AND p.post_type = 'subscribers'"), ARRAY_A);
        $emails = array_column($get_subscribers, 'emails');
       
        if ( !empty( $emails ) ) {
            ob_start();
            include get_stylesheet_directory() . '/custom/email_template/email-promotion.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $msg =  wp_mail($emails, "Kainamo", $email_content, $headers);
            if ($msg) {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = 'Promotional Email Send Successfully';
                $response['status'] = true;
                return $this->response_json($response);
            }
            else{
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = 'Please Check Your Internet Connection';
                $response['status'] = false;
                return $this->response_json($response);
            }
        } else {
    
            $response = [
                'icon' => "error",
                'title' => "Error",
                'status' => false,
                'message' => "No susbcribers found in list"
            ];
        }
        return $this->response_json($response);

    }
    
    function register_subscribers(){
        register_post_type('subscribers',
			array(
				'labels'      => array(
					'name'          => __('Subscribers', 'textdomain'),
					'singular_name' => __('Subscribers', 'textdomain'),
				),
					'public'      => true,
					'has_archive' => true,
					'supports' => array('title'),
			)
		);
    }


    function response_json($response){
        echo json_encode($response);
        wp_die();
    }
}
new SubscribersManage();