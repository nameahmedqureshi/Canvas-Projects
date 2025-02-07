<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class MainClass {

    function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_files' ) );

        $variable = array('signup_user', 'login_user','reset_password_custom','forgot_password','update_user_profile', 'change_password','delete_user', 'deactivate_account', 'add_user');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }

    }

    function enqueue_custom_files() {
        wp_enqueue_script('jquery');
      //  wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/custom/assets/css/style.css', array(), '1.0', 'all');
        wp_enqueue_style('toastr-style', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
        wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');       

        wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
        wp_enqueue_script('custom_script', get_stylesheet_directory_uri() . '/custom/assets/js/custom.js', array(), true);
       
        $user_data =   array( 
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        );
        wp_localize_script('custom_script', 'ajax_script', $user_data);
   
    }

    function add_user() {
        if (isset($_POST)) {
            foreach ($_POST as $key => $value) {
                if($key == 'l_name' || $key == 'ph_num' ){ continue; }
                if (empty($value)) {
                    $response['icon'] = "error";
                    $response['status'] = false;
                    $response['message'] = "Please Fill All Required Fields";
                    return $this->response_json($response);
                }
            }
        }

        if (email_exists(trim($_POST['user_email']))) {
            $response['icon'] = "error";
            $response['message']  = 'The E-mail , you enetered is already registered, Try another one.';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if (strlen($_POST['password']) < 8) {
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
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

        $userdata = array(
            'first_name' => $_POST['f_name'],
            'last_name' => $_POST['l_name'],
            'user_login' => $_POST['f_name'],
            'user_email' => $_POST['user_email'],
            'user_pass' =>  $_POST['password'],
            'role'    => 'customer',
        );


        $user = wp_insert_user($userdata);

        if ($user) {
            update_user_meta($user, 'account_status', 'Active');
            update_user_meta($user, 'ph_num', $_POST['ph_num']);

            ob_start();
            include get_stylesheet_directory() . '/custom/email_template/email-welcome-user.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail($_POST['user_email'], "Heather", $email_content, $headers);
        }


        if (is_wp_error($user)) {
            $response['icon'] = "error";
            $response['message'] = $user->get_error_message();
            $response['status'] = false;
        } else {

            $response['auto_redirect'] = true;
            $response['icon'] = "success";
            $response['message'] = "Succesfully Registerd";
            $response['status'] = true;
            $response['redirect_url'] = home_url('users');
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
            $account_status = get_user_meta($user->ID, 'account_status', true);
            if (!$user) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = 'Invalid login or password';
                $response['status'] = $remember_me;
                return $this->response_json($response);
            }
            if (wp_check_password($password, $user->data->user_pass, $user->ID)) {

                if (!in_array('administrator', $user->roles)) {
                   
                    if ($account_status == "Not Active") {
                        $response['icon'] = "error";
                        $response['title'] = "Error";
                        $response['message'] = 'Your account is deactivated';
                        $response['status'] = false;
                        return $this->response_json($response);
                    }
                 
                }

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
					$response['redirect_url'] = home_url('main-dashboard/');
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

    function signup_user(){

       
        // Check for required fields
        $required_fields = ['fname', 'lname', 'user_email', 'password'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                return $this->response_json([
                    'icon' => "error",
                    'status' => false,
                    'message' => "Please fill all required fields"
                ]);
            }
        }

        if (email_exists(trim($_POST['user_email']))) {
            $response['icon'] = "error";
            $response['message']  = 'The E-mail , you enetered is already registered, Try another one.';
            $response['status'] = false;
            return $this->response_json($response);
        }
        
        if(strlen($_POST['password']) < 8){
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
            $response['status'] = false;
            return $this->response_json($response);
        }


        if (username_exists(trim($_POST['user_name']))) {
            $response['icon'] = "error";
            $response['message']  = 'Username , you enetered is already registered, Try another one.';
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

        try 
        {

            $userdata = array(
                'first_name' => $_POST['fname'],
                'last_name' => $_POST['lname'],
                'user_login' => $_POST['user_email'],
                'user_email' => $_POST['user_email'],
                'user_pass' =>  $_POST['password'],
                'role'	=> 'customer',
            );
            $user = wp_insert_user($userdata);

            if (is_wp_error($user)) {
                throw new Exception($user->get_error_message());
            }

            if ($user) {
                update_user_meta($user, 'user_name', $_POST["user_name"]);
                update_user_meta($user, 'ph_num', $_POST["phno"]);
                update_user_meta($user, 'account_status', 'Active');

            }

            $response['auto_redirect'] = true;
            $response['icon'] = "success";
            $response['message'] = "Succesfully Registered!";
            $response['status'] = true;
            $response['redirect_url'] = home_url('login/');
            return $this->response_json($response);
           
        }
        catch(Exception $e) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return $this->response_json($response);
        }
    }


    
    function forgot_password(){
        // var_dump($_POST);
        // exit;
        $get_user = get_user_by('email', $_POST['recovery_email']);

        if ($get_user) {
            $code = $this->generateRandomString($length = 4);
            setcookie("verification_code", $code, time() + 3000 , "/"); 
            setcookie("verific_user_id", $get_user->ID, time() + 3000 , "/"); 
            ob_start();
            include get_stylesheet_directory() . '/multivendor/email_template/email-recover.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $msg = wp_mail($_POST['recovery_email'], "Heather", $email_content, $headers);

  
            if ($msg) {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = 'Verification Code Send Successfully Please Check Your Email';
                $response['status'] = true;
                $response['redirect_url']= home_url('reset-password/');
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
        
        if(strlen($_POST['password']) < 8){
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
            $response['status'] = false;
            return $this->response_json($response);
        }

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
        $response['redirect_url'] = home_url("login/");

        return $this->response_json($response);

    }
    
    function update_user_profile() {
        // Check if the user is logged in
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
		}
    
        $isemail = filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL);
        $user = get_user_by(($isemail) ? 'email':'login', $_POST['user_email']);
        if (empty($_POST['user_id'])) {
            $response['status'] = false;
            $response['message'] = "User not found.";
            return $this->response_json($response);
        }
    
     
        // Update user data
        $user_data = array(
            'ID' => $user->ID,
            'user_email' => sanitize_email($_POST['user_email']),
            'first_name' => isset($_POST['f_name']) ? sanitize_text_field($_POST['f_name']) : $user->first_name,
            'last_name' => isset($_POST['l_name']) ? sanitize_text_field($_POST['l_name']) : $user->last_name,
        );

        if (!empty($_POST['ph_num'])) {
            $user_data['ph_num'] = $_POST['ph_num'];
            update_user_meta($user->ID, 'ph_num', $user_data['ph_num']);
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
            $response['status'] = true;
            $response['message'] = "Profile updated successfully!";
            $response['redirect_url'] = home_url('users/');
        }
    
        return $this->response_json($response);
    }

    
    function change_password(){
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        // parse_str($_POST['form_data'], $form_data);

        if (empty($_POST['password'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please fill password field";
            return $this->response_json($response);
        }

        if (strlen($_POST['password']) < 8) {
            $response['icon'] = "error";
            $response['message'] = 'Password Must Be Atleast 8 Characters';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if (empty($_POST['user_id'])) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "User not found";
            return $this->response_json($response);
        }

        wp_set_password($_POST['password'], $_POST['user_id']);
        $response['icon'] = "success";
        $response['title'] = "Success";
        $response['message']  = "Password Changed Successfully";
        $response['status'] = true;

        return $this->response_json($response);
    }


    function delete_user() {
        // var_dump($_POST['user']);
        // exit;
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        $user_id = intval($_POST['user']);

        if (empty($user_id)) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Something went wrong.";
            return $this->response_json($response);
        }
       
        $result = wp_delete_user($user_id);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "User not found";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "User deleted";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function deactivate_account() {
        if (empty($_POST['user'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Something went wrong.";
            return $this->response_json($response);
        }

        $account_status = get_user_meta($_POST['user'], 'account_status', true);

        if ($account_status == "Not Active") {
            $result = update_user_meta($_POST['user'], 'account_status', 'Active');
            $message = "Account Activate";
        } else {
            $result = update_user_meta($_POST['user'], 'account_status', 'Not Active');
            $message = "Account Deactivate";
        }
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "User not found";
            $response['status'] = false;
        } else {
            $account_status = get_user_meta($_POST['user'], 'account_status', true);
            $response['icon'] = "success";
            $response['message'] = $message;
            $response['status'] = true;
            $response['account_status'] = $account_status;
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

    public function generateRandomString($length = 8) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
new MainClass();
