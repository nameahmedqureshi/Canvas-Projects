<?php 
// include "notification-trait.php";
class familyNoticeClass {
    // use NotificationTrait;

    function __construct()
    {
        $variable = array(
        'add_update_family_notice',
        'delete_family_notice', 
        'update_notice_status'
        // 'approved_forum',
        // 'forum_detail',
        // 'replyForum',
        // 'get_comments_by_post_id'
      
        );
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_family_notice');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function update_notice_status(){
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};

         // Admin check
        if (!current_user_can('administrator')) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You don't have permission to update this status!";
            return $this->response_json($response);

        }

        // Check POST data
        if (!isset($_POST['notice_id']) || !isset($_POST['status'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Invalid data received";
            return $this->response_json($response);
        }

        $notice_id = intval($_POST['notice_id']);
        $status = sanitize_text_field($_POST['status']);
    
        // Allowed status values
        $allowed_statuses = ['publish', 'draft'];
        if (!in_array($status, $allowed_statuses)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Invalid status selected";
            return $this->response_json($response);
          
        }
        // Update post status
        $post_data = [
            'ID'           => $notice_id,
            'post_status'  => $status
        ];
        $updated = wp_update_post($post_data, true);
        if (is_wp_error($updated)) {
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Failed to update status";
        
        } else {
            $response['title'] = "Success";
            $response['message'] = "Status updated successfully";
            // $response['auto_redirect'] = true;
            $response['status'] = true;
            // $response['redirect_url'] =  home_url('all-family-notices/?type=cpt-family-notice');
        }
        return $this->response_json($response);

    
    }

    function add_update_family_notice() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
      
        $required_fields = ['name', 'surname'];
        foreach($required_fields as $val){
            if (empty($_POST[$val]) ) {
                $response['icon'] = "error";
                $response['status'] = false;
                $response['message'] = "Please Fill Required Fields";
                return $this->response_json($response);
            }
        }

        $post_data = array(
            'post_type'    => 'cpt-family-notice',
        );

        $test_credentials = get_field( 'test_credentials' , 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        if ($secret_key == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please Add Stripe key";
            return $this->response_json($response); 
        }

        // Set your Stripe secret key
        $stripe = new \Stripe\StripeClient($secret_key);

        // Retrieve the token from the request
        $token = $_POST['stripeToken'];

        $price = 30;

        if (!empty($_POST['post_id'])) {
            // Get the current post status
            $current_status = get_post_status($_POST['post_id']);
        
            // If current status is draft, keep it as draft, otherwise publish
            $post_data['ID'] = $_POST['post_id'];
            $post_data['post_status'] = ($current_status === 'draft') ? 'draft' : 'publish';
        
            $post_id = wp_update_post($post_data);
            if (is_wp_error($post_id)) {
                return $this->response_json([
                    'title'   => 'Error',
                    'status'  => false,
                    'message' => "Try again, something went wrong!",
                ]);
            }

            
            foreach($_POST as $key => $values){
                update_post_meta($post_id, $key, $values);
            }

            if($_POST['cat_type']){
                // $categories = array_map('intval', $_POST['service_categories']);
                $categories =  array_map('intval', explode(',', $_POST['cat_type']));      
                wp_set_object_terms($post_id, $categories , 'family-notice-category');
            }

            if(isset($_FILES["person_image"])){
                $profile_pic = $_FILES["person_image"];
                if($profile_pic['size'] != 0) {
                    $res = $this->uploadImage($profile_pic);
                    if($res["success"]) {
                        $pic= $res['attach_id'];
                        update_post_meta($post_id, 'person_image', $pic);
                    }
                }
            }
        
            return $this->response_json([
                'title'         => 'Success',
                'message'       => 'Family notice updated successfully!',
                'auto_redirect' => true,
                'status'        => true,
                'redirect_url'  => home_url('all-family-notices/'),
            ]);
        } else {
       
            try {
                    
                $charge = $stripe->charges->create([
                    'amount' => $price * 100, // Amount in cents, adjust as needed
                    'currency' => 'gbp',
                    'source' => $token,
                    'description' => 'Family Notice Payment'
                ]);

                if ($charge->status !== 'succeeded') {
                    throw new Exception('Payment failed.');
                }

                // Insert new post as draft
                $post_data['post_status'] = 'draft';
                $post_id = wp_insert_post($post_data);

                if (is_wp_error($post_id)) {
                    throw new Exception('Failed to create family notice.');
                }

                foreach($_POST as $key => $values){
                    update_post_meta($post_id, $key, $values);
                }

                if($_POST['cat_type']){
                    // $categories = array_map('intval', $_POST['service_categories']);
                    $categories =  array_map('intval', explode(',', $_POST['cat_type']));      
                    wp_set_object_terms($post_id, $categories , 'family-notice-category');
                }
        
                if(isset($_FILES["person_image"])){
                    $profile_pic = $_FILES["person_image"];
                    if($profile_pic['size'] != 0) {
                        $res = $this->uploadImage($profile_pic);
                        if($res["success"]) {
                            $pic= $res['attach_id'];
                            update_post_meta($post_id, 'person_image', $pic);
                        }
                    }
                }
            
                return $this->response_json([
                    'title'         => 'Success',
                    'message'       => 'Family notice created successfully!',
                    'auto_redirect' => true,
                    'status'        => true,
                    'redirect_url'  => home_url('all-family-notices/'),
                ]);
                
                
            } catch (Exception $e) {
                return $this->response_json([
                    'icon'    => 'error',
                    'title'   => 'Error',
                    'status'  => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }
       
       
        // if (!empty($_POST['post_id'])) {
        //     // Get the current post status
        //     $current_status = get_post_status($_POST['post_id']);
        
        //     // If current status is draft, keep it as draft, otherwise publish
        //     $post_data['ID'] = $_POST['post_id'];
        //     $post_data['post_status'] = ($current_status === 'draft') ? 'draft' : 'publish';
        
        //     $post_id = wp_update_post($post_data);
        // } else { 
        //     // If it's a new post, set it to draft
        //     $post_data['post_status'] = 'draft';
        //     $post_id = wp_insert_post($post_data);
        // }
        
        
        // if($post_id){
        //     foreach($_POST as $key => $values){
        //         update_post_meta($post_id, $key, $values);
                
        //     }

        //     if($_POST['cat_type']){
        //         // $categories = array_map('intval', $_POST['service_categories']);
        //         $categories =  array_map('intval', explode(',', $_POST['cat_type']));      
        //         wp_set_object_terms($post_id, $categories , 'family-notice-category');
        //     }

        //     if(isset($_FILES["person_image"])){
        //         $profile_pic = $_FILES["person_image"];
        //         if($profile_pic['size'] != 0) {
        //             $res = $this->uploadImage($profile_pic);
        //             if($res["success"]) {
        //                 $pic= $res['attach_id'];
        //                 update_post_meta($post_id, 'person_image', $pic);
        //             }
        //         }
        //     }
        // }

        // if (is_wp_error($post_id)) {
        //         $response['title'] = "Error";
        //         $response['status'] = false;
        //         $response['message'] = "Try again, something's amiss!";
			
		// } else {
        //     // $redirect_url = $_POST['post_type'] == 'cpt-death-notice' ? home_url('all-death-notices/?type=cpt-death-notice') :  home_url('all-family-notices/?type=cpt-family-notice');
        //     $response['title'] = "Success";
        //     $response['message'] = "Success!";
        //     $response['auto_redirect'] = true;
        //     $response['status'] = true;
        //     $response['redirect_url'] =  home_url('all-family-notices/?type=cpt-family-notice');
		// }

		// return $this->response_json($response);
    }

    function delete_notice() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['notice_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This notice are not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['notice_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "Notice not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Notice Deleted!";
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

   
    function register_family_notice() {
        register_post_type('cpt-family-notice',
            array(
                'labels'      => array(
                    'name'          => __('Family Notice', 'textdomain'),
                    'singular_name' => __('Family Notice', 'textdomain'),
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
$Forum = new familyNoticeClass();