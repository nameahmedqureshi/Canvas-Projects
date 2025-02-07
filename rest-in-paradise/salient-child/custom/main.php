<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class MainClass {
    function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_files' ) );
   
        add_filter('acf/load_field/name=constituency_select_city', array( $this, 'acf_load_city_field_choices') );
        add_filter('acf/load_field/name=constituency_select_td', array( $this, 'acf_load_constituency_field_choices') );

       // add_action('init',array($this,'getData'));
        $actions = ['get_data', 'get_constituencies', 'get_td_senators', 'submit_form'];
        foreach ($actions as $key => $value) {
			add_action('wp_ajax_'.$value,array($this,$value));
      		add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }

        $cpt = array('register_enquiry_form_post_type');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }


        if (function_exists('acf_add_options_page')) {
			acf_add_options_page([
				'page_title' => 'Enquiry Details',
				'menu_title' => 'Enquiry Details',
				'menu_slug' => 'enquiry-details',
				'capability' => 'edit_posts',
				'redirect' => false,
			]);
		}
    }

    function enqueue_custom_files() {

        wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/custom/css/custom-style.css', array(), '1.0', 'all');
        wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');
        wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);

        wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/custom/js/custom-script.js', array(), true);
        wp_enqueue_script('jquery');

        $user_data =   array( 
            'ajax_url' => admin_url( 'admin-ajax.php' )
            
        );
        wp_localize_script('custom-script', 'ajax_script', $user_data);

    }

    function submit_form(){
        parse_str($_POST['form_data'], $form_data);
        // $emails = ["testingserver442@gmail.com", "raheel.zafar@canvasdigital.net"];
        //   // Email 
        //   $subject = $form_data['petition'];
        //   $message =   '<pre style="font-family: sans-serif;">'.$form_data['petition_description'].'</pre>';
        //   $headers = array('Content-Type: text/html; charset=UTF-8',
        //   'From: ' . $form_data['from_email'], );
        //   wp_mail($emails, $subject, $message, $headers);
        //   exit;
      
      
        // EIR Code Validate
        $eir_code =  isset($form_data['EIRCode']) ? $form_data['EIRCode'] : '';
        $existing_eir_codes = get_field('eir_code', 'option');
        $result = explode(' ', $eir_code);
        // Get the characters before the hyphen
        $code = $result[0];
        // Extract the 'eir_code' column from the array
        $default_eir_codes = array_column($existing_eir_codes, 'eir_code');
        
        if (preg_match('/[a-z]/',  $form_data['EIRCode'])) {
			 $response = array(
                'status' => 'warning',
                'message' => "EIR Code should be uppercase",
            );
            return $this->jsonResponse($response);
		}
     
        
        if(!in_array($code ,  $default_eir_codes)){
            $response = array(
                'status' => 'warning',
                'message' => "EIR Code Not Validate",
            );
            return $this->jsonResponse($response);
        }

        if( empty($form_data['firstname']) || 
            empty($form_data['lastname']) || 
            empty($form_data['PhoneNumber']) || 
            empty($form_data['EIRCode']) || 
            empty($form_data['City']) || 
            empty($form_data['Constituency']) || 
            empty($form_data['send_email_to']) || 
            empty($form_data['from_email']) || 
            empty($form_data['petition']) || 
            empty($form_data['petition_description']) ) {
            $response = array(
                'status' => 'warning',
                'message' => "Fill the required fields",
            );
            return $this->jsonResponse($response);
        }

        $default_senators_list = get_field('senators_emails', 'option');
        $prime_minister_email = get_field('prime_minister_email', 'option');
        $uniqueName = 'enquiry_' . rand(10,100);
       
        $post_data = array(
			'post_title'   => $uniqueName,
			'post_status'  => 'publish', 
			'post_type'    => 'enquiry-form',
		);
		
		$post_id = wp_insert_post($post_data);
        // $data_to_insert = [];
        if($post_id){
            foreach ($form_data as $key => $value) {

                if ($key === 'send_email_to' ) {
                    $value = serialize($value);
                }
                // Sanitize and prepare the data
                $value = sanitize_text_field($value);
                $key = sanitize_text_field($key);

                update_post_meta( $post_id, $key, $value );
		    }

            // Email 
            $senators_list = explode(',', $default_senators_list);
            // $emails = ["testingserver442@gmail.com"];
            // $sentemails = ["yennoifreyimma-8215@yopmail.com", "temp100@yopmail.com"];
            $cc_emails = implode(', ', $senators_list);

            $subject = $form_data['petition'];
            $message =   '<pre style="font-family: sans-serif;">'.$form_data['petition_description'].'</pre>';

            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: ' . $form_data['from_email'],
                'Cc: ' . $cc_emails,
            );
            // $headers = array('Content-Type: text/html; charset=UTF-8',
            // 'From: ' . $form_data['from_email']);

            // $headers[] = 'Cc: testingserver442@gmail.com';
          
            // var_dump($headers);
            // exit;
         

            if(isset($form_data['send_email_to']) && $form_data['send_email_to']){
                $recipient_list = explode(',', $form_data['send_email_to']);
                wp_mail($recipient_list, $subject, $message, $headers);
              
            }

            if( isset($default_senators_list) ){
                wp_mail($senators_list, $subject, $message, $headers);
            }


            if(isset($form_data['inputbcc']) && $form_data['inputbcc']){
                $bbc_list = explode(',', $form_data['inputbcc']);
                $headers = array(
                    'Content-Type: text/html; charset=UTF-8',
                    'From: ' . $form_data['from_email'],
                    'Cc: ' . $cc_emails,
                    'bcc: ' . $form_data['inputbcc'],
                );
               
                wp_mail($bbc_list, $subject, $message, $headers);
            }

            if(isset($form_data['inputccc']) && $form_data['inputccc']){
                $ccc_list = explode(',', $form_data['inputccc']);
                $merged_cc_emails = array_merge($ccc_list, $sentemails);
                $cc_emails = implode(', ', $merged_cc_emails);

                $headers = array(
                    'Content-Type: text/html; charset=UTF-8',
                    'From: ' . $form_data['from_email'],
                    'Cc: ' . $cc_emails,
                );
                wp_mail($ccc_list, $subject, $message, $headers);
            }

        }

		if (is_wp_error($post_id)) {
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
		} else {
			$response = array(
				'status' => 'success',
				'message' => "Form Submit Succesfully!",
				'redirect_url' => site_url('enquiry'),
			);
		}

		return $this->jsonResponse($response);
    }

    function get_data(){
        $cities= get_field('city', 'option');
        $petition_subject = get_field('petition_subject', 'option');
        $petition_description = get_field('petition_description', 'option');
        // var_dump($petition_description);
        // exit;
        $response = array(
            'status' => 'success',
            'cities' => $cities,
            'petition_subject' => $petition_subject,
            'petition_description' => $petition_description,
        );
        return $this->jsonResponse($response);
    }

    function get_constituencies(){
        $selected_city = isset($_POST['selected_city']) && $_POST['selected_city'] ? $_POST['selected_city'] : '';
        $constituency = get_field('enter_constituency', 'option');
        $constituencies = [];

        foreach ($constituency as $entry) {
            if ($entry['constituency_select_city'] == $selected_city) {
                $constituencies[] = $entry;
            }
        }
       
        $response = array(
            'status' => 'success',
            'constituency' => $constituencies,
        );
        return $this->jsonResponse($response);
    }

    function get_td_senators(){
        $selected_constituency = isset($_POST['selected_constituency']) && $_POST['selected_constituency'] ? $_POST['selected_constituency'] : '';
        $tds_senators_list = get_field('tds_senators_list', 'option');
        $default_senators_list = get_field('senators_emails', 'option');
        $prime_minister_email = get_field('prime_minister_email', 'option');
        // var_dump($default_senators_list);
        // var_dump($prime_minister_email);

        $senators = [];

        foreach ($tds_senators_list as $entry) {

            if ($entry['constituency_select_td'] == $selected_constituency) {
                $senators[] = $entry;
            }
        }
        // var_dump($tds_senators_list);
        // exit;
        $response = array(
            'status' => 'success',
            'senators' => $senators,
            'default_senators_list' => $default_senators_list,
            'prime_minister_email' => $prime_minister_email,
        );
        return $this->jsonResponse($response);
    }

    function acf_load_city_field_choices( $field ) {
    
        // Reset choices
        $field['choices'] = array();
    
        // Check to see if Repeater has rows of data to loop over
        if( have_rows('city', 'option') ) {
            
            // Execute repeatedly as long as the below statement is true
            while( have_rows('city', 'option') ) {
                
                // Return an array with all values after the loop is complete
                the_row();
                
                // Variables
                $value = get_sub_field('city_name');
                $label = get_sub_field('city_name');
    
                
                // Append to choices
                $field['choices'][ $value ] = $label;
            }
        }
        // Return the field
        return $field;
    }

    function acf_load_constituency_field_choices( $field ) {
    
        // Reset choices
        $field['choices'] = array();
    
        // Check to see if Repeater has rows of data to loop over
        if( have_rows('enter_constituency', 'option') ) {
            
            // Execute repeatedly as long as the below statement is true
            while( have_rows('enter_constituency', 'option') ) {
                
                // Return an array with all values after the loop is complete
                the_row();
                
                // Variables
                $value = get_sub_field('constituency_name');
                $label = get_sub_field('constituency_name');
    
                
                // Append to choices
                $field['choices'][ $value ] = $label;
            }
        }
        // Return the field
        return $field;
    }

    function register_enquiry_form_post_type(){
        register_post_type('enquiry-form',
			array(
				'labels'      => array(
					'name'          => __('Enquiries', 'textdomain'),
					'singular_name' => __('Enquiries', 'textdomain'),
				),
					'public'      => true,
					'has_archive' => false,
					 'supports' => array('title')
			)
		);
    }
 

    function jsonResponse($response){
		echo json_encode($response);
		wp_die(); 
	}
}
new MainClass();