<?php
class ProfileSetting
{

    function __construct() {
        $variable = array('update_profile', 'password_change', 'send_query', 'payout_information', 'update_store_profile');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }
    }

    function update_profile() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
		}
       
         $user = wp_get_current_user();
         if ($user) {
            $user_meta = get_user_meta( $user->ID );
            $first_name = get_user_meta( $user->ID, 'first_name', true );
            $last_name = get_user_meta( $user->ID, 'last_name', true );

            $user_data = array(
                'ID'         => $user->ID,
                'user_email' => sanitize_email($_POST['user_email']),
                'first_name'  => isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : $first_name,
                'last_name'  => isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : $last_name,
            );
        
            if (!empty($_POST['phone_num'])) {
                $user_data['phone_num'] = $_POST['phone_num'];
                update_user_meta($user->ID, 'ph_num', $user_data['phone_num']);
            }

            if (!empty($_POST['address'])) {
                $user_data['address'] = $_POST['address'];
                update_user_meta($user->ID, 'address', $user_data['address']);
            }

            if (!empty($_POST['about'])) {
                $user_data['about'] = $_POST['about'];
                update_user_meta($user->ID, 'about', $user_data['about']);
            }

            if (!empty($_POST['first_name'])) {
                $user_data['first_name'] = sanitize_text_field($_POST['first_name']);
                $user_data['display_name'] = $user_data['first_name'];
                update_user_meta($user->ID, 'first_name', $user_data['first_name']);
            }

            if (!empty($_POST['last_name'])) {
                $user_data['last_name'] = sanitize_text_field($_POST['last_name']);
                update_user_meta($user->ID, 'last_name', $user_data['last_name']);
            }


            if(isset($_FILES["profile_pic"])){
                $profile_pic = $_FILES["profile_pic"];
                if($profile_pic['size'] != 0) {
                    $res = $this->uploadImage($profile_pic);
                    if($res["success"]) {
                        $pic= $res['attach_id'];
                        update_user_meta($user->ID, 'profile_pic', $pic);
                    }
                }
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
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = home_url('profile-settings/');
               
            }
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "User not found.";
        }
        return $this->response_json($response);
    }

    function password_change() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
		}

        if(strlen($_POST['new_password']) < 8){
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
            $response['status'] = false;
            return $this->response_json($response);
        }

       
        $user = wp_get_current_user();
      
        if (wp_check_password( $_POST['old_password'], $user->user_pass, $user->data->ID )) {
          
            
			if (!empty($_POST['new_password'])) {
				$user_data['user_pass'] = sanitize_text_field($_POST['new_password']);
                $user_data['ID'] = $user->data->ID;
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
                $response['message'] = "Password updated successfully!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['password_change'] = true;
                $response['redirect_url'] = home_url('logout/');
			
            }
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Current password is incorrect!";
			
        }
		return $this->response_json($response);
    }

    function send_query(){
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
		} 

        if(empty($_POST['query'])){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please fill the message field!";
            return $this->response_json($response);
		} 
 
        ob_start();
        include get_stylesheet_directory() . '/custom/email_template/email-query.php';
        $email_content = ob_get_contents();
        ob_end_clean();
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $msg = wp_mail(get_option('admin_email'), "Fifu", $email_content, $headers);
        if ($msg) {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = 'Your query has been sent to admin.';
            $response['status'] = true;
            $response['redirect_url']= home_url('profile-settings/');
        }
        else{
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Please Check Your Internet Connection';
            $response['status'] = false;
        }
        return $this->response_json($response);

    }

    function payout_information() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
		}

        
        $required_fields = ['secret_key', 'publishable_key'];
        foreach ($required_fields as $value) {
            if (empty($_POST[$value])) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Please fill required fields";
                return $this->response_json($response);
    
            }
        }

        $stripe_details = [
            "secret_key" => $_POST['secret_key'],
            "publishable_key" => $_POST['publishable_key'],
        ];

        $bank_details = [
            "account_name" => $_POST['account_name'],
            "account_number" => $_POST['account_number'],
        ];

        $user = wp_get_current_user();
        if ($user) {
            update_user_meta($user->ID, 'stripe_details', $stripe_details);
            update_user_meta($user->ID, 'bank_details', $bank_details);

            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Account Details Added Successfully!";
            $response['auto_redirect'] = true;
            $response['status'] = true;
            $response['redirect_url'] = home_url('profile-settings/');
            
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "User not found.";
        }
        return $this->response_json($response);
      
    }

    function update_store_profile() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
		}

        
        $required_fields = ['store_name', 'store_email', 'store_address', 'store_number'];
        foreach ($required_fields as $value) {
            if (empty($_POST[$value])) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Please fill required fields";
                return $this->response_json($response);
    
            }
        }

        $store_details = [
            "store_name" => $_POST['store_name'],
            "store_email" => $_POST['store_email'],
            "store_number" => $_POST['store_number'],
            "store_address" => $_POST['store_address'],
            "store_about" => $_POST['store_about'],
        ];

        if(isset($_FILES["store_pic"])){
            $profile_pic = $_FILES["store_pic"];
            if($profile_pic['size'] != 0) {
                $res = $this->uploadImage($profile_pic);
                if($res["success"]) {
                    $store_details['store_pic'] = $res['attach_id'];
                }
            }
        }

        $user = wp_get_current_user();
        if ($user) {
            update_user_meta($user->ID, 'store_details', $store_details);

            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['status'] = true;
            $response['message'] = "Successfully Added!";
            $response['auto_redirect'] = true;
            $response['redirect_url'] = home_url('profile-settings/');
            
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "User not found.";
        }
       
        return $this->response_json($response);
    }

    function uploadImage($file) {
        // fetch uploaded image
        $image = $file['tmp_name'];
        $filename = $file['name'];

        $upload_file = wp_upload_bits($filename, null, file_get_contents($image));

        if (!$upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'] );
            if (!is_wp_error($attachment_id)) {
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                wp_update_attachment_metadata( $attachment_id,  $attachment_data );

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

    function response_json($response){
		echo json_encode($response);
		wp_die(); 
	}

}
new ProfileSetting();