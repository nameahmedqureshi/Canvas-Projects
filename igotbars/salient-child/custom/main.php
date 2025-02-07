<?php
class MainClass {
    function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_files' ) );

		$variable = array( 'upload_media','login_user','forgot_password', 'reset_password_custom', 'add_post_or_page', 'add_tags_catgs', 'delete_post_page' ,'delete_media');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }
	
    }

    function enqueue_custom_files() {
			wp_enqueue_script('jquery');
			wp_enqueue_style('custom_style', get_stylesheet_directory_uri() . '/custom/assets/css/custom_style.css', array(), '1.0', 'all');
            wp_enqueue_style('toastr-style', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
            wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');
            wp_enqueue_style('select2-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
      
            wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, false);
			wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
            wp_enqueue_script('toastr-script','https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array(), null, true);	
           
	        wp_enqueue_script('select2-script', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array(), null, true);
            // Enqueue DataTables CSS
			wp_enqueue_style('datatables', 'https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css');
			wp_enqueue_style('responsive-datatables', 'https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css');
			wp_enqueue_style('rowreorder-datatables', 'https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css');
			// Enqueue DataTables JavaScript
			wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js', array('jquery'), true);
			wp_enqueue_script('responsive-datatables-js', 'https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js', array('jquery'), true);
			wp_enqueue_script('row-reorder-datatables-js', 'https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js', array('jquery'), true);
			wp_enqueue_script('custom_script', get_stylesheet_directory_uri() . '/custom/assets/js/custom_script.js', array(), true);

			$user_data =   array( 
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			);
			wp_localize_script('custom_script', 'ajax_script', $user_data);
	}

    public function delete_media(){
        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

        wp_delete_attachment( $_REQUEST['post_id'] );

        if (is_wp_error($_REQUEST['post_id'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "Try again, something's amiss!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Media Deleted Succesfully!";
            $response['status'] = true;
       }
       return $this->response_json($response);
    }

    public function upload_media(){
        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

        if(!isset($_FILES["image"])){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please select file!";
			return $this->response_json($response);
        }

        $media = '';       
        $media_image = $_FILES["image"];
        $res = $this->uploadImage($media_image);

        if(!$res["success"]) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $res["msg"];
        } else {
            
            $media .=  '<div class="col_2 image-container">
            <img src="'.$res["url"].'" alt="attachment" /><div class="delete-icon" media="'.$res["attach_id"].'">
            <i class="fa fa-trash delete-image" aria-hidden="true"></i>&nbsp&nbsp
            <i class="fa fa-link copy_url" data-url="'.wp_get_attachment_url($res["attach_id"]).'" aria-hidden="true"></i>
            </div>
            </div>';

            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['status'] = true;
            $response['message'] = "Media uploaded!";
            $response['media'] = $media;
        }
    
        return $this->response_json($response);
    }

    public function add_post_or_page(){
        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			
			return $this->response_json($response);
		}

        if (empty($_POST['post_title']) || empty($_POST['post_title'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }

        $user_id = get_current_user_id();
        // var_dump($user->roles[0]);
        // exit;
      
        $existing_post_id = isset($_POST['existing_post_id']) ? $_POST['existing_post_id'] : '';
		$post_title = isset($_POST['post_title']) ? sanitize_text_field($_POST['post_title']) : '';
		$post_tags = isset($_POST['post_tag']) ? $_POST['post_tag'] : [];
		$post_category = isset($_POST['post_category']) ? $_POST['post_category'] : [];
		$post_desc = isset($_POST['post_desc']) ? $_POST['post_desc'] : '';
     
        if($_POST['post_type'] == "page"){
            $post_data = array(
                'post_title'   => $post_title,
                'post_content' => $post_desc,
                'post_status'  => $_POST['post_status'], 
                'post_type'    => $_POST['post_type'],
                'author'	   => $user_id,
            );
            $response['message'] = "Page created successfully!";
            $response['redirect_url'] = site_url('view-page');
        }

        if($_POST['post_type'] == "post"){
            $post_data = array(
                'post_title'   => $post_title,
                'post_content' => $post_desc,
                'post_status'  => $_POST['post_status'], 
                'post_type'    => $_POST['post_type'],
                'author'	   => $user_id,
                'tags_input' => $post_tags,
                'post_category' => $post_category,
            );
            $response['message'] = "Post created successfully!";
            $response['redirect_url'] = site_url('view-post');
        }
      
        // var_dump( $post_data );
        // exit;
       
        if($existing_post_id){
            $post_data['ID'] = $existing_post_id;
            $post_id = wp_update_post($post_data);

        } else {
            $post_id = wp_insert_post($post_data);
        }
        
        if($post_id){
          
            if(isset($_FILES["image"])){
               
				$featured_image = $_FILES["image"];
				// set post thumnail for the post
				if($featured_image['size'] != 0) {
					$res = $this->uploadImage($featured_image);
					if($res["success"]) {
						$post_featured_image = $res['attach_id'];
                      
						// And finally assign featured image to post
						set_post_thumbnail( $post_id, $post_featured_image );
					}
				}
			}
        }
        // var_dump($post_id);
        // exit;

        if (is_wp_error($post_id)) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
			
		} else {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['auto_redirect'] = true;
                $response['status'] = true;
		}

		return $this->response_json($response);
    }

    public function add_tags_catgs(){
        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

        $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
        $catgs = isset($_POST['catgs']) ? $_POST['catgs'] : [];
       
        $post_categories = '';
        $post_tags = '';

       // Check if tags are provided
        if (!empty($tags)) {
            // Loop through each tag and add it to the site
            foreach ($tags as $tag) {
                // Check if the tag already exists
                if (term_exists($tag, 'post_tag')) {
                    continue;
                }
                // If the tag doesn't exist, add it to the tag taxonomy
                $term =    wp_insert_term($tag, 'post_tag');
                if (!is_wp_error($term)) {
                    // Append HTML for the newly added category
                    $post_tags .= '<input type="checkbox" id="' . $term['term_id'] . '" name="post_tag[]" value="' . $term['term_id'] . '" checked>
                        <label for="' . $term['term_id'] . '"> ' . get_term($term['term_id'], 'post_tag')->name. '</label><br>';
                }
            }

            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Tags added successfully!";
            $response['post_tags'] = $post_tags;
            $response['status'] = true;
        }

        // Check if there are categories to add
        if (!empty($catgs)) {
            foreach ($catgs as $category) {
                // If the category doesn't exist, add it
                if (term_exists($category, 'category')) {
                    continue;
                }
                $term = wp_insert_term($category, 'category');
                
                if (!is_wp_error($term)) {
                    // Append HTML for the newly added category
                    $post_categories .= '<input type="checkbox" id="' . $term['term_id'] . '" name="post_category[]" value="' . $term['term_id'] . '" checked>
                        <label for="' . $term['term_id'] . '"> ' . get_term($term['term_id'], 'category')->name. '</label><br>';
                }
            }
           
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Category added successfully!";
            $response['post_categories'] = $post_categories;
            $response['status'] = true;
        }

        

        return $this->response_json($response);
    }

    public function delete_post_page(){
        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

        wp_delete_post( $_REQUEST['post_id'] );

        if (is_wp_error($_REQUEST['post_id'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = "Try again, something's amiss!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Delete Succesfully!";
            $response['status'] = true;
       }
       return $this->response_json($response);
    }

	public function login_user() {
		parse_str($_POST['form_data'], $form_data);
		$useremail = isset($form_data['user_email']) ? sanitize_text_field($form_data['user_email']) : '';
		$password = isset($form_data['password']) ? sanitize_text_field($form_data['password']) : '';
		$remember_me = isset($form_data['remember']) ? sanitize_text_field($form_data['remember']) : '';

        if ($useremail != "" && $password != "") {
            $remember_me = isset($remember_me);
            $isemail = filter_var($useremail, FILTER_VALIDATE_EMAIL);
            $user = get_user_by(($isemail) ? 'email':'login', $useremail);
            if (!$user) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = 'Invalid login or password';
                $response['status'] = $remember_me;
                return $this->response_json($response);
            }
            if (wp_check_password($password, $user->data->user_pass, $user->ID)) {

                $creds = array(
                    'user_login' => $user->data->user_login,
                    'user_password' => $password,
                    'remember'      => true
                );
                $user = wp_signon($creds, true);
                if (is_wp_error($user)) {
                    $passwordErr = "Can't login";
                    $response['title'] = "Error";
                    $response['icon'] = "error";
                    $response['message'] = $user->get_error_message();
                    $response['status'] = false;
                } 
                else {
                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['auto_redirect'] = true;
                    $response['status'] = true;
					$response['redirect_url'] = home_url('dashboard');
                }
            } else {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $passwordErr = "Password is incorrect";
                $response['message'] = $passwordErr;
                $response['status'] = false;}
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Invalid login or password';
            $response['status'] = false;
        }
        return $this->response_json($response);
    }

	function forgot_password(){
        $get_user = get_user_by('email', $_POST['recovery_email']);

        if ($get_user) {
            $code = $this->generateRandomString($length = 4);
            setcookie("verification_code", $code, time() + 3000 , "/"); 
            setcookie("verific_user_id", $get_user->ID, time() + 3000 , "/"); 
            ob_start();
            include get_stylesheet_directory() . '/custom_temeplate/email_template/email-recover.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $msg = wp_mail($_POST['recovery_email'], "Envision", $email_content, $headers);
            if ($msg) {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = 'Verification Code Send Successfully Please Check Your Email';
                $response['status'] = true;
                $response['redirect_url']= home_url().'/reset-password/';
                return $this->response_json($response);
            }
            else{
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = 'Please Check Your Internet Connection';
                $response['status'] = false;
                return $this->response_json($response);
            }

        }else{
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message']  = "Try again this email doesn't exists";
            $response['status'] = false;
        }
        return $this->response_json($response);
    }

	function reset_password_custom(){

        if(!isset($_COOKIE['verific_user_id']) || $_COOKIE['verific_user_id'] == ""){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'TimeOut Please Try Again';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if(!isset($_COOKIE['verification_code']) || $_COOKIE['verification_code'] != $_POST['verification_code']){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Try again verification code is not match';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if ($_POST['password'] == "" || $_POST['password_re'] == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Please fill all required fields correctly';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if ($_POST['password'] != $_POST['password_re']) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Password not Match';
            $response['status'] = false;
            return $this->response_json($response);
        }

        wp_set_password($_POST['password'],$_COOKIE['verific_user_id']);
        $response['icon'] = "success";
        $response['title'] = "Success";
        $response['message']  = "Password Reset Successfully";
        $response['status'] = true;
        $response['redirect_url'] = home_url("login");

        return $this->response_json($response);

    }

	public function generateRandomString($length = 8) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
new MainClass();