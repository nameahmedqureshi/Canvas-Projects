<?php 
// include "notification-trait.php";
class DonationClass {
    // use NotificationTrait;

    function __construct()
    {
        $variable = array(
        'add_donation',
        'delete_donation', 
      
        );
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_donation');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

   

    function add_donation() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
      

        if (empty($_POST['amount'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
     
        $post_data = array(
			'post_title'   => $_POST['amount'],
			'post_status'  => 'publish', 
			'post_type'    => 'donations',
		);
        // var_dump($post_data);
        // exit;
       
        if(!empty($_POST['post_id'])){
			$post_data['ID'] = $_POST['post_id'];
			$post_id = wp_update_post($post_data);
		} else { 
			$post_id = wp_insert_post($post_data);
		}      

        if($post_id){
            update_post_meta($post_id, 'amount', $_POST['amount'] );
            update_post_meta($post_id, 'agent', wp_get_current_user()->display_name );
        }

        if (is_wp_error($post_id)) {
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
			
		} else {
                $response['title'] = "Success";
                $response['message'] = "Donation successfully!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('donation');
		}

		return $this->response_json($response);
    }

    function delete_donation() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['donation_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This donation are not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['donation_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "Not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Donation Succesfully";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function register_donation() {
        register_post_type('donations',
            array(
                'labels'      => array(
                    'name'          => __('Donations', 'textdomain'),
                    'singular_name' => __('Donations', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title','editor', 'comments','thumbnail'),

            )
        );
    }


    function response_json($response) {
        echo json_encode($response);
        wp_die();
    }

} 
$DonationClass = new DonationClass();