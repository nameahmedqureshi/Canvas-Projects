<?php
class MainClass
{

    function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_files'));

        $variable = array('signup_user', 'login_user', 'update_user_profile', 'change_password',  'forgot_password', 'reset_password_custom', 'deactivate_account', 'delete_user');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }
    }


    function enqueue_custom_files(){
        wp_enqueue_script('jquery');
        wp_enqueue_style('toastr-style', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
        wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');
        wp_enqueue_style('css-style', get_stylesheet_directory_uri() . '/custom/assets/css/style.css' );
        wp_enqueue_style('css-duDatepicker', get_stylesheet_directory_uri() . '/custom/assets/css/duDatepicker.min.css' );

        wp_enqueue_script('js-duDatepicker', get_stylesheet_directory_uri() . '/custom/assets/js/duDatepicker.min.js', array(), null, true);
        wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
        wp_enqueue_script('toastr-script', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array(), null, true);
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
        wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/custom/assets/js/custom.js', array(), true);

        $user_data =   array(
            'ajax_url' => admin_url('admin-ajax.php'),
        );
        wp_localize_script('custom-script', 'ajax_script', $user_data);
    }



    function signup_user() {

        // var_dump($_POST);
        // exit;
        if (empty($_POST['first_name']) || empty($_POST['email']) || empty($_POST['password'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill All Required Fields";
            return $this->response_json($response);
        }

        if (email_exists(trim($_POST['email']))) {
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


        $userdata = array(
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'user_login' => $_POST['number'],
            'user_email' => $_POST['email'],
            'user_pass' =>  $_POST['password'],
        );



        $user = wp_insert_user($userdata);
        if ($user) {
            update_user_meta($user, 'type', $_POST['type']);
            // update_user_meta($user, 'birthday', $_POST['birthday']);
            update_user_meta($user, 'number', $_POST['number']);
            update_user_meta($user, 'college', $_POST['college']);
            update_user_meta($user, 'classification', $_POST['classification']);
            update_user_meta($user, 'panther_id', $_POST['panther_id']);
            update_user_meta($user, 'account_status', 'Active');

            $creds = array(
                'user_login' => $_POST['email'],
                'user_password' => $_POST['password'],
                'remember'      => true
            );
            $user = wp_signon($creds, true);
        }

        if (is_wp_error($user)) {
            $response['icon'] = "error";
            $response['message'] = $user->get_error_message();
            $response['status'] = false;
        } else {

            $response['auto_redirect'] = true;
            $response['icon'] = "success";
            $response['message'] = "Succesfully Registered!";
            $response['status'] = true;
            $response['redirect_url'] = home_url();
        }

        return $this->response_json($response);
    }


    public function login_user(){

        $useremail = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
        $password = isset($_POST['password']) ? sanitize_text_field($_POST['password']) : '';

        if ($useremail != "" && $password != "") {
            $remember_me = isset($remember_me);
            $isemail = filter_var($useremail, FILTER_VALIDATE_EMAIL);
            $user = get_user_by(($isemail) ? 'email' : 'login', $useremail);
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
                        $response['message'] = 'Your account is deactivated.';
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
                } else {
                    $creds = array(
                        'user_login' => $_POST['user_email'],
                        'user_password' => $_POST['password']);
                    wp_signon($creds, false);

                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['message'] = 'Redirecting you to dashboard';
                    $response['auto_redirect'] = true;
                    $response['status'] = true;
                    $response['redirect_url'] = current_user_can('manage_options') ? home_url('dashboard') : home_url('');
                }
            } else {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $passwordErr = "Password is inncorrect";
                $response['message'] = $passwordErr;
                $response['status'] = false;
            }
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'Invalid login or password';
            $response['status'] = false;
        }
        return $this->response_json($response);
    }

    function update_user_profile(){
        // parse_str($_POST['form_data'], $form_data); // Convert serialized string to array
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }


        $user = isset($_POST['user_id']) ? $_POST['user_id'] : get_current_user_id();
        $user = get_user_by('id', $user);

        // $author_meta = get_user_meta(get_current_user_id());
        // var_dump($author_meta);
        // exit;
        // $author = get_userdata($user);

        if ($user) {
            // $user_meta = get_user_meta($user->ID);
            $first_name = get_user_meta($user->ID, 'first_name', true);
            $last_name = get_user_meta($user->ID, 'last_name', true);

            $user_data = array(
                'ID'         => $user->ID,
                'user_email' => isset($_POST['email']) ? sanitize_email($_POST['email']) : $user->user_email,
                'first_name'  => isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : $first_name,
                'last_name'  => isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : $last_name,
                'display_name'   => isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : $first_name,
            );

            

            $redirect_url = home_url('profile-edit/');
            $msg = "Profile updated successfully!";

            if (!empty($_POST['new_password']) && !empty($_POST['old_password'])) {
                if (strlen($_POST['new_password']) < 8) {
                    $response['icon'] = "error";
                    $response['message'] = 'Password Must Be Atleast 8 Characters';
                    $response['status'] = false;
                    return $this->response_json($response);
                }
                if(wp_check_password($_POST['old_password'], $user->data->user_pass, $user->ID)){
                    wp_set_password($_POST['new_password'], $user->ID);
                    $redirect_url = home_url();
                    $msg = "Password updated successfully, Please login again";
                }
                else {
                    $response['icon'] = "error";
                    $response['title'] = "Error";
                    $response['message'] = "Old Password is inncorrect";
                    $response['status'] = false;
                    return $this->response_json($response);
                }
    
            } 

            update_user_meta($user->ID, 'number', $_POST['number']);
            // update_user_meta($user->ID, 'birthday', $_POST['birthday']);
            update_user_meta($user->ID, 'classification', $_POST['classification']);
            update_user_meta($user->ID, 'panther_id', $_POST['panther_id']);
            update_user_meta($user->ID, 'type', $_POST['type']);
            update_user_meta($user, 'college', $_POST['college']);


            $updated = wp_update_user($user_data); // Update the user


            if (is_wp_error($updated)) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss";
            } else {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = $msg;
                $response['auto_redirect'] = false;
                $response['status'] = true;
                $response['redirect_url'] =  isset($_POST['redirect']) ?  home_url('user-profile/?id='.$user->ID) : $redirect_url;
            }
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "User not found.";
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

    function forgot_password() {
        $get_user = get_user_by('email', $_POST['recovery_email']);

        if ($get_user) {
            $code = $this->generateRandomString($length = 4);
            setcookie("recovery_code", $code, time() + 3000, "/");
            setcookie("recovery_user_id", $get_user->ID, time() + 3000, "/");
            ob_start();
            include get_stylesheet_directory() . '/custom/email_template/email-recover.php';
            $email_content = ob_get_contents();
            ob_end_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $msg = wp_mail($_POST['recovery_email'], "Malachi", $email_content, $headers);
            if ($msg) {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = 'Verification Code Send Successfully Please Check Your Email';
                $response['status'] = true;
                return $this->response_json($response);
            } else {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['message'] = 'Please Check Your Internet Connection';
                $response['status'] = false;
                return $this->response_json($response);
            }
        } else {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message']  = "Try again this email doesn't exists";
            $response['status'] = false;
        }
        return $this->response_json($response);
    }

    function reset_password_custom(){

        if (!isset($_COOKIE['recovery_user_id']) || $_COOKIE['recovery_user_id'] == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['message'] = 'TimeOut Please Try Again';
            $response['status'] = false;
            return $this->response_json($response);
        }

        if (!isset($_COOKIE['recovery_code']) || $_COOKIE['recovery_code'] != $_POST['recovery_code']) {
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

        wp_set_password($_POST['password'], $_COOKIE['recovery_user_id']);
        $response['icon'] = "success";
        $response['title'] = "Success";
        $response['message']  = "Password Reset Successfully";
        $response['status'] = true;

        return $this->response_json($response);
    }

    function deactivate_account(){
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        
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

    function delete_user() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['user'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Something went wrong.";
            return $this->response_json($response);
        }
        $result = wp_delete_user($_POST['user']);
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

    function response_json($response)
    {
        echo json_encode($response);
        wp_die();
    }

    public function generateRandomString($length = 8)
    {
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
