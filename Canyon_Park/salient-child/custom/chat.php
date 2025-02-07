<?php

class Chat{



    function __construct(){



        $variable = array('send_message', 'get_messages');

        foreach ($variable as $key => $value) {

            add_action('wp_ajax_'.$value,array($this,$value));

            add_action('wp_ajax_nopriv_'.$value,array($this,$value));

        }

    }



    function send_message(){
        global $wpdb;
    
        // var_dump($_POST);
        // exit;
        // Sanitize input
        $receiver_id = intval($_POST['receiver_id']);
        $message = sanitize_text_field($_POST['message']);

        
        // Handle file upload
        $attachment_url = '';
        if (!empty($_FILES['file']['name'])) {
            // Get uploaded file information
            $uploaded_file = $_FILES['file'];
        
            // Get WordPress upload directory
            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['basedir'] . '/chats_attachment/'; // Server path
            $upload_url = $upload_dir['baseurl'] . '/chats_attachment/'; // URL path
        
            // Create the directory if it doesn't exist
            if (!file_exists($upload_path)) {
                wp_mkdir_p($upload_path);
            }
        
            // Generate a sanitized file name to avoid issues
            $filename = sanitize_file_name($uploaded_file['name']);
            $file_path = $upload_path . $filename;
        
            // Move the uploaded file to the custom folder
            if (move_uploaded_file($uploaded_file['tmp_name'], $file_path)) {
                $attachment_url = $upload_url . $filename; // Save the URL for the database
            } else {
                // Handle upload failure
                return $this->response_json([
                    'status' => false,
                    'title' => "Error",
                    'message' => 'File upload failed. Please try again.',
                ]);
            }
        }

        if ( isset( $_POST['type'] ) ) {

            if (empty($message)){
                $response = array(
                    'status'  => false,
                    'title'  => 'error',
                    'message' => 'Message field required',
                );
                return $this->response_json( $response );

            }

            $users = new WP_User_Query( array(
                'role'   => 'customer',
                'fields' => 'ID', // Fetch only user IDs
            ) );
        
            $agents = $users->get_results();
        
            if ( ! empty( $agents ) ) {
                foreach ( $agents as $agent_id ) {
                    // Insert message into the database for each agent
                    $wpdb->insert( 
                        "wp_custom_chat", 
                        array(
                            "sender_id"   => get_current_user_id(),
                            "receiver_id" => $agent_id,
                            "body"        => $message,
                        )
                    );
                }
                // Response for success
                $response = array(
                    'status'  => true,
                    'title'  => 'success',
                    'message' => 'Messages sent successfully to all agents.',
                    'redirect_url' => home_url('chat')
                );
            } else {
                // Response if no agents found
                $response = array(
                    'status'  => false,
                    'title'  => 'error',
                    'message' => 'No agents found to send messages.',
                );
            }
        
            return $this->response_json( $response );
        }
        
        

        // var_dump($file_path);
        // var_dump($attachment_url);
        // exit;
       

        $get_sender_profile_image_id = get_user_meta( get_current_user_id() , 'profile_pic', true );
        $get_sender_profile_image_url = wp_get_attachment_image_url( $get_sender_profile_image_id );
        $sender_img = !empty($get_sender_profile_image_url) ? $get_sender_profile_image_url : get_stylesheet_directory_uri() .'/multivendor/assets/images/avatar.png';
        
        $html = '';

        // Build chat HTML
        $html = '<div class="chat">
                <div class="chat-avatar">
                    <span class="avatar box-shadow-1 cursor-pointer">
                        <img src="' . $sender_img . '" alt="avatar" height="36" width="36" />
                    </span>
                </div>
                <div class="chat-body">
                    <div class="chat-content">';

                        if (!empty($message)) {
                            $html .= '<p>' . $message . '</p>';
                        }

                        if (!empty($attachment_url)) {
                            $html .= '<a href="' . esc_url($attachment_url) . '" target="_blank" class="chat-attachment">
                                        <img src="' . esc_url($attachment_url) . '" alt="attachment" style="max-width: 100px; max-height: 100px;" />
                                    </a>';
                        }

                    $html .= '</div>
                </div>
        </div>';
       
		// $html .= '<div class="chat">
        //     <div class="chat-avatar">
        //         <span class="avatar box-shadow-1 cursor-pointer">
        //             <img src="'.$sender_img .'" alt="avatar" height="36" width="36" />
        //         </span>
        //     </div>
        //     <div class="chat-body">
        //         <div class="chat-content">
        //             <p>'.$message.'</p>
        //         </div>
        //     </div>
        // </div>';
    
        // var_dump($attachment_url);
        // Insert message into the database
        $query = $wpdb->insert("wp_custom_chat", array(
            "sender_id" => get_current_user_id(),
            "receiver_id" => $receiver_id,
            "body" => $message,
            "attachment" => $attachment_url, // Save the attachment URL in the database

        ));
    
        if (is_wp_error($query)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Try again, something's amiss!";
                
        } else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['status'] = true;
            $response['message'] = "Message sent successfully!";
            $response['html'] = $html;
        }
    
        return $this->response_json($response);
	}

	function get_messages(){
		if(!is_user_logged_in()){
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
			return $this->response_json($response);
		}


		global $wpdb;
		$current_user = wp_get_current_user(); 
		$message_id = isset($_POST['id']) ? $_POST['id'] : '';
        $type = get_post_meta($message_id, 'type', true);

        if($type && in_array( 'vendor', wp_get_current_user()->roles) ){
            $message_id = get_post_meta($_POST['id'], 'customer_id', true);

        }  elseif($type && in_array( 'customer', wp_get_current_user()->roles) ){
            $message_id = get_post_meta($_POST['id'], 'vendor_id', true);
        
        }
        // var_dump($message_id);
        // exit;

        if (empty($message_id)) {
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
            return $this->response_json($response);

		}
       
       // var_dump($current_user->ID);
		if($message_id){
           
			$messages = $wpdb->get_results( "SELECT `id`, `sender_id`, `receiver_id`, `body`, `attachment`,  `created_at` 
			FROM ".$wpdb->prefix."custom_chat 
			WHERE 
			(sender_id = $current_user->ID AND receiver_id = $message_id) 
			OR (receiver_id = $current_user->ID AND sender_id = $message_id) 
			ORDER BY id ASC", ARRAY_A);

            $wpdb->query($wpdb->prepare(
                "UPDATE wp_custom_chat 
                SET is_read = 1 
                WHERE sender_id = %d",
                $message_id
            ));
		}

        // var_dump($current_user->ID);
        // var_dump($message_id);
        // var_dump($messages);
        // exit;
	
		$html = '';

        if(!empty($messages)){
            foreach ($messages as $value) { 
                if($value['receiver_id'] == $current_user->ID) { 
                    
                    $get_sender_profile_image_id = get_user_meta( $value['sender_id'], 'profile_pic', true );
                    $get_sender_profile_image_url = wp_get_attachment_image_url( $get_sender_profile_image_id );
                    $sender_img = !empty($get_sender_profile_image_url) ? $get_sender_profile_image_url : get_stylesheet_directory_uri() .'/multivendor/assets/images/avatar.png';

                  
                    $html .= ' <div class="chat chat-left">
                        <div class="chat-avatar">
                            <span class="avatar box-shadow-1 cursor-pointer">
                                <img src="'. $sender_img .'" alt="avatar" height="36" width="36" />                            
                            </span>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>'.$value['body'].'</p>';
                                if (!empty($value['attachment'])) {
                                    $html .= '<a href="' . esc_url($value['attachment']) . '" target="_blank" class="chat-attachment">
                                    <img src="' . esc_url($value['attachment']) . '" alt="attachment" style="max-width: 100px; max-height: 100px;" />
                                    </a>';
                                }
                            $html .='</div>
                        </div>
                    </div>';
                } 
                if($value['sender_id'] == $current_user->ID) { 
                    $get_receiver_profile_image_id = get_user_meta( $value['sender_id']  , 'profile_pic', true );
                    $get_receiver_profile_image_url = wp_get_attachment_image_url( $get_receiver_profile_image_id );
                    $receiver_img = !empty($get_receiver_profile_image_url) ? $get_receiver_profile_image_url : get_stylesheet_directory_uri() .'/multivendor/assets/images/avatar.png';
                  
                    $html .= '<div class="chat">
                        <div class="chat-avatar">
                            <span class="avatar box-shadow-1 cursor-pointer">
                                <img src="'. $receiver_img .'" alt="avatar" height="36" width="36" />
                            </span>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>'.$value['body'].'</p>';
                                if (!empty($value['attachment'])) {
                                    $html .= '<a href="' . esc_url($value['attachment']) . '" target="_blank" class="chat-attachment">
                                    <img src="' . esc_url($value['attachment']) . '" alt="attachment" style="max-width: 100px; max-height: 100px;" />
                                    </a>';
                                }
                            $html .='</div>
                            </div>
                        </div>
                    </div>';
                } 
            
            } 
        } else {
            $html = '<div class="start-chat-area">
                <div class="mb-1 start-chat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                </div>
                <h4 class="sidebar-toggle start-chat-text">Start Conversation</h4>
            </div>';
        }
		
        $response = array(
            'status' => 'success',
            'message' => "Messages retreived successfully!",
            'html' => $html,
            
        );
		return $this->response_json($response);
	}

	// function get_messages(){

	// 	if(!is_user_logged_in()){

	// 		$response = array(

	// 			'status' => 'error',

	// 			'message' => "Try again, something's amiss!",

	// 		);

	// 		return $this->response_json($response);

	// 	}

	// 	global $wpdb;

	// 	$current_user = wp_get_current_user(); 

	// 	$message_id = isset($_POST['id']) ? $_POST['id'] : '';



    //     if (empty($message_id)) {

	// 		$response = array(

	// 			'status' => 'error',

	// 			'message' => "Try again, something's amiss!",

	// 		);

    //         return $this->response_json($response);



	// 	}

       

    //    // var_dump($current_user->ID);

	// 	if($message_id){

           

	// 		$messages = $wpdb->get_results( "SELECT `id`, `sender_id`, `receiver_id`, `body`, `created_at` 

	// 		FROM ".$wpdb->prefix."custom_chat 

	// 		WHERE 

	// 		(sender_id = $current_user->ID AND receiver_id = $message_id) 

	// 		OR (receiver_id = $current_user->ID AND sender_id = $message_id) 

	// 		ORDER BY id ASC", ARRAY_A);

	// 	}



    //     // var_dump($current_user->ID);

    //     // var_dump($message_id);

    //     // var_dump($messages);

    //     // exit;

	

	// 	$html = '';



    //     if(!empty($messages)){

    //         foreach ($messages as $value) { 

                

                

              



    //             if($value['receiver_id'] == $current_user->ID) { 

                  

    //                 $get_sender_profile_image_id = get_user_meta( $value['sender_id'], 'profile_pic', true );

    //                 $get_sender_profile_image_url = wp_get_attachment_image_url( $get_sender_profile_image_id );

    //                 $sender_img = !empty($get_sender_profile_image_url) ? $get_sender_profile_image_url : get_stylesheet_directory_uri() .'/multivendor/assets/images/avatar.png';



                  

    //                 //var_dump($receiver_img);



    //                 $html .= ' <div class="chat chat-left">

    //                     <div class="chat-avatar">

    //                         <span class="avatar box-shadow-1 cursor-pointer">

    //                             <img src="'. $sender_img .'" alt="avatar" height="36" width="36" />

    //                         </span>

    //                     </div>

    //                     <div class="chat-body">

    //                         <div class="chat-content">

    //                             <p>'.$value['body'].'</p>

    //                         </div>

    //                     </div>

    //                 </div>';

    //             } 

    //             if($value['sender_id'] == $current_user->ID) { 

    //                 $get_receiver_profile_image_id = get_user_meta( $value['sender_id']  , 'profile_pic', true );

    //                 $get_receiver_profile_image_url = wp_get_attachment_image_url( $get_receiver_profile_image_id );

    //                 $receiver_img = !empty($get_receiver_profile_image_url) ? $get_receiver_profile_image_url : get_stylesheet_directory_uri() .'/multivendor/assets/images/avatar.png';

                  

    //                 $html .= '<div class="chat">

    //                     <div class="chat-avatar">

    //                         <span class="avatar box-shadow-1 cursor-pointer">

    //                         <img src="'. $receiver_img .'" alt="avatar" height="36" width="36" />

    //                         </span>

    //                     </div>

    //                     <div class="chat-body">

    //                         <div class="chat-content">

    //                             <p>'.$value['body'].'</p>

    //                         </div>

    //                     </div>

    //                 </div>';

    //             } 

            

    //         } 

    //     } else {

    //         $html = '<div class="start-chat-area">

    //             <div class="mb-1 start-chat-icon">

    //                 <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>

    //             </div>

    //             <h4 class="sidebar-toggle start-chat-text">Start Conversation</h4>

    //         </div>';

    //     }

		

    //     $response = array(

    //         'status' => 'success',

    //         'message' => "Messages retreived successfully!",

    //         'html' => $html,

            

    //     );

	// 	return $this->response_json($response);

	// }



    function response_json($response){

		echo json_encode($response);

		wp_die(); 

	}



}

new Chat();