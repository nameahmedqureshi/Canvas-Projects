<?php 
// include "notification-trait.php";
class AnnouncementClass {
    // use NotificationTrait;

    function __construct()
    {
        $variable = array(
        'add_announcement',
        'delete_announcement', 
      
        );
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_announcement');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

   

    function add_announcement() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
      

        if (empty($_POST['subject']) || empty($_POST['description'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
     
        $post_data = array(
			'post_title'   => $_POST['subject'],
			'post_content'   => $_POST['description'],
			'post_status'  => 'publish', 
			'post_type'    => 'announcements',
		);
        // var_dump($post_data);
        // exit;
       
        if(!empty($_POST['post_id'])){
			$post_data['ID'] = $_POST['post_id'];
			$post_id = wp_update_post($post_data);
		} else { 
			$post_id = wp_insert_post($post_data);
		}      

        if (is_wp_error($post_id)) {
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
			
		} else {
                $response['title'] = "Success";
                $response['message'] = "Announcement added successfully!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('announcement');
		}

		return $this->response_json($response);
    }

    function delete_announcement() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['announcement_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This announcement are not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['announcement_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "Service not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Announcement Succesfully";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function register_announcement() {
        register_post_type('announcements',
            array(
                'labels'      => array(
                    'name'          => __('Announcements', 'textdomain'),
                    'singular_name' => __('Announcements', 'textdomain'),
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

    // function decryptData($data) {
	// 	$ciphering = "AES-128-CTR";
	// 	$decryption_iv = '1234567891011121';
	// 	$options = 0;
	// 	$decryption_key = "W3docs";
	// 	return openssl_decrypt($data, $ciphering, $decryption_key, $options, $decryption_iv);
    // }

    // function encryptData($data) {
    //     $ciphering = "AES-128-CTR";
    //     $iv_length = openssl_cipher_iv_length($ciphering);
    //     $options = 0;
    //     $encryption_iv = '1234567891011121';
    //     $encryption_key = "W3docs";
    //     return  openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
    // }

} 
$AnnouncementClass = new AnnouncementClass();