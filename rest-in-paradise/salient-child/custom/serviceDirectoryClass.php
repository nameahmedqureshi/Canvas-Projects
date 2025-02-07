<?php 
// include "notification-trait.php";
class ServiceDirectory {
    // use NotificationTrait;

    function __construct()
    {
        $variable = array(
        'add_update_service',
        'delete_notice', 
        // 'approved_forum',
        // 'forum_detail',
        // 'replyForum',
        // 'get_comments_by_post_id'
      
        );
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_service_directory');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function add_update_service() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
      

        $required_fields = ['name', 'location', 'short_description'];
        foreach($required_fields as $val){
            if (empty($_POST[$val]) ) {
                $response['icon'] = "error";
                $response['status'] = false;
                $response['message'] = "Please Fill Required Fields";
                return $this->response_json($response);
            }
        }

        $post_data = array(
            'post_type'    => 'cpt-service-directry',
        );
       
        // var_dump($_POST['post_id']);
        // exit;
       
        if (!empty($_POST['post_id'])) {
            // Get the current post status
            // If current status is draft, keep it as draft, otherwise publish
            $post_data['ID'] = $_POST['post_id'];
        
            $post_id = wp_update_post($post_data);
        } else { 
            // If it's a new post, set it to draft
            $post_data['post_status'] = 'publish';
            $post_id = wp_insert_post($post_data);
        }
        
        
        if($post_id){
            foreach($_POST as $key => $values){
                update_post_meta($post_id, $key, $values);
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
        }

        if (is_wp_error($post_id)) {
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
			
		} else {
            // $redirect_url = $_POST['post_type'] == 'cpt-death-notice' ? home_url('all-death-notices/?type=cpt-death-notice') :  home_url('all-family-notices/?type=cpt-family-notice');
            $response['title'] = "Success";
            $response['message'] = "Success!";
            $response['auto_redirect'] = true;
            $response['status'] = true;
            $response['redirect_url'] =  home_url('all-services/') ;
		}

		return $this->response_json($response);
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

    function register_service_directory() {
        register_post_type('cpt-service-directry',
            array(
                'labels'      => array(
                    'name'          => __('Service Directory', 'textdomain'),
                    'singular_name' => __('Service Directory', 'textdomain'),
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
$Forum = new ServiceDirectory();