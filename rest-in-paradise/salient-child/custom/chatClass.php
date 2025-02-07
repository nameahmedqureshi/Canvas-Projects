<?php
class Chatting{

    function __construct(){

        // $variable = array('get_users', 'send_message', 'get_messages');
        $variable = array('get_users', 'onMessage', 'get_messages');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }
    }

    function get_users() {

        $users = new WP_User_Query( array(
            'role'     => $_POST['type'],
        ) );
        $get_users = $users->get_results();
        global $wpdb;
      
        $users_html = "";
        if ( !empty( $get_users ) ) {
            foreach ( $get_users as $user ) { 
               
                if ($user->ID === get_current_user_id()) { // Skip the current logged-in user
                    continue;
                }


               // Check if the user has unread messages
                $unread_messages = $wpdb->get_var($wpdb->prepare(
                    "SELECT COUNT(*) FROM 4AM2H5_custom_chat 
                    WHERE sender_id = %d 
                    AND is_read = 0", 
                    $user->ID
                ));

                // var_dump( $unread_messages ) ;
                // var_dump( $user->ID ) ;
         

                $get_profile_image_id = get_user_meta( $user->ID, 'profile_pic', true );
                $get_profile_image_url = wp_get_attachment_image_url( $get_profile_image_id );
                $profile_img = !empty($get_profile_image_url) ? $get_profile_image_url : get_stylesheet_directory_uri() .'/store/assets/images/avatar.png';
                $first_name = get_user_meta($user->ID, 'first_name', true);
                $last_name = get_user_meta($user->ID, 'last_name', true);
                $full_name = sprintf('%s %s', $first_name, $last_name);
                

                $users_html .= '<li class="username" user='.$user->ID.'>
                    <span class="avatar"><img src="'. $profile_img .'" height="42" width="42" alt="Generic placeholder image" /></span>
                    <div class="chat-info flex-grow-1">
                        <h5 class="mb-0">' . $full_name . ($unread_messages > 0 ? '<span class="badge bg-danger rounded-pill float-end">' . $unread_messages . '</span>' : '') . '</h5>
                    </div>
                   
                </li>';

            }
        } else {
            $users_html = 'No users Found!';
        }

        $response = array(
            'html' => $users_html,
        );
        return $this->response_json($response);

    }

    function onMessage() {
        global $wpdb;
    
        // var_dump($_POST);
        // exit;
        // Sanitize input
        $receiver_id = intval($_POST['receiver_id']);
        $message = sanitize_text_field($_POST['message']);

        // if ( isset( $_POST['type'] ) ) {

        //     if (empty($message)){
        //         $response = array(
        //             'status'  => false,
        //             'title'  => 'error',
        //             'message' => 'Message field required',
        //         );
        //         return $this->response_json( $response );

        //     }

        //     $users = new WP_User_Query( array(
        //         'role'   => 'customer',
        //         'fields' => 'ID', // Fetch only user IDs
        //     ) );
        
        //     $agents = $users->get_results();
        
        //     if ( ! empty( $agents ) ) {
        //         foreach ( $agents as $agent_id ) {
        //             // Insert message into the database for each agent
        //             $wpdb->insert( 
        //                 "4AM2H5_custom_chat", 
        //                 array(
        //                     "sender_id"   => get_current_user_id(),
        //                     "receiver_id" => $agent_id,
        //                     "body"        => $message,
        //                 )
        //             );
        //         }
        //         // Response for success
        //         $response = array(
        //             'status'  => true,
        //             'title'  => 'success',
        //             'message' => 'Messages sent successfully to all agents.',
        //             'redirect_url' => home_url('chat')
        //         );
        //     } else {
        //         // Response if no agents found
        //         $response = array(
        //             'status'  => false,
        //             'title'  => 'error',
        //             'message' => 'No agents found to send messages.',
        //         );
        //     }
        
        //     return $this->response_json( $response );
        // }

        $get_sender_profile_image_id = get_user_meta( get_current_user_id() , 'profile_pic', true );
        $get_sender_profile_image_url = wp_get_attachment_image_url( $get_sender_profile_image_id );
        $sender_img = !empty($get_sender_profile_image_url) ? $get_sender_profile_image_url : get_stylesheet_directory_uri() .'/store/assets/images/avatar.png';
        
        $html = '';
       
		$html .= '<div class="chat">
            <div class="chat-avatar">
                <span class="avatar box-shadow-1 cursor-pointer">
                    <img src="'.$sender_img .'" alt="avatar" height="36" width="36" />
                </span>
            </div>
            <div class="chat-body">
                <div class="chat-content">
                    <p>'.$message.'</p>
                </div>
            </div>
        </div>';
    
        if ( $_POST['type'] == 'individual' ) {
            // Insert message into the database
            $query = $wpdb->insert("4AM2H5_custom_chat", array(
                "sender_id" => get_current_user_id(),
                "receiver_id" => $receiver_id,
                "body" => $message,
                "type" => $_POST['type'],
            ));
        } else {
             // Insert message into the database
             $query = $wpdb->insert("4AM2H5_custom_chat", array(
                "sender_id" => get_current_user_id(),
                "body" => $message,
                "type" => $_POST['type'],
            ));
        }
    
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

    // function onMessage(){

    //     // var_dump($_POST);
    //     // exit;
	// 	if(!is_user_logged_in()){
    //         $response['icon'] = "error";
    //         $response['title'] = "Error";
    //         $response['status'] = false;
    //         $response['message'] = "You're session is expired, Login again!";
    //         return $this->response_json($response);
	// 	}
	// 	global $wpdb;
	// 	// var_dump($receiver_id);
	// 	// exit;
    //     if(empty($_POST['message'])){
    //         $response['icon'] = "error";
    //         $response['title'] = "Error";
    //         $response['status'] = false;
    //         $response['message'] = "Message should be filled";
    //         return $this->response_json($response);
    //     }

        
    //     $get_sender_profile_image_id = get_user_meta( get_current_user_id() , 'profile_pic', true );
    //     $get_sender_profile_image_url = wp_get_attachment_image_url( $get_sender_profile_image_id );
    //     $sender_img = !empty($get_sender_profile_image_url) ? $get_sender_profile_image_url : get_stylesheet_directory_uri() .'/store/assets/images/avatar.png';
        

	// 	$html = '';
       
	// 	$html .= '<div class="chat">
    //         <div class="chat-avatar">
    //             <span class="avatar box-shadow-1 cursor-pointer">
    //                 <img src="'.$sender_img .'" alt="avatar" height="36" width="36" />
    //             </span>
    //         </div>
    //         <div class="chat-body">
    //             <div class="chat-content">
    //                 <p>'.$_POST['message'].'</p>
    //             </div>
    //         </div>
    //     </div>';
		
	// 	$query = $wpdb->insert("4AM2H5_custom_chat", array(
	// 	   "sender_id" => get_current_user_id(),
	// 	   "receiver_id" => $_POST['receiver_id'],
	// 	   "body" => $_POST['message'],
	// 	));
	// 	if (is_wp_error($query)) {
    //         $response['icon'] = "error";
    //         $response['title'] = "Error";
    //         $response['status'] = false;
    //         $response['message'] = "Try again, something's amiss!";
			
	// 	} else {
    //         $response['icon'] = "success";
    //         $response['title'] = "Success";
    //         $response['status'] = true;
    //         $response['message'] = "Message sent successfully!";
    //         $response['html'] = $html;
	// 	}

	// 	return $this->response_json($response);
	// }

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
        // $type = get_post_meta($message_id, 'type', true);

        // if($type && in_array( 'vendor', wp_get_current_user()->roles) ){
        //     $message_id = get_post_meta($_POST['id'], 'customer_id', true);

        // }  elseif($type && in_array( 'customer', wp_get_current_user()->roles) ){
        //     $message_id = get_post_meta($_POST['id'], 'vendor_id', true);
        
        // }
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
		if($message_id && $_POST['messageType'] == 'individual'){
           
			$messages = $wpdb->get_results( "SELECT `id`, `type`,`sender_id`, `receiver_id`, `body`, `created_at` 
			FROM ".$wpdb->prefix."custom_chat 
			WHERE 
			(sender_id = $current_user->ID AND receiver_id = $message_id) 
			OR (receiver_id = $current_user->ID AND sender_id = $message_id) 
			ORDER BY id ASC", ARRAY_A);

            $wpdb->query($wpdb->prepare(
                "UPDATE ".$wpdb->prefix."custom_chat  
                SET is_read = 1 
                WHERE sender_id = %d",
                $message_id
            ));
		} else {
            $messages = $wpdb->get_results( "SELECT `id`, `type`, `sender_id`, `receiver_id`, `body`, `created_at` 
			FROM ".$wpdb->prefix."custom_chat 
			WHERE type = 'group'
			ORDER BY id ASC", ARRAY_A);

            $wpdb->query($wpdb->prepare(
                "UPDATE ".$wpdb->prefix."custom_chat  
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

        if (!empty($messages)) {
            foreach ($messages as $value) { 
                $get_profile_image_id = get_user_meta($value['sender_id'], 'profile_pic', true);
                $name = get_user_meta($value['sender_id'], 'first_name', true);
                $get_profile_image_url = wp_get_attachment_image_url($get_profile_image_id);
                $img = !empty($get_profile_image_url) ? $get_profile_image_url : get_stylesheet_directory_uri() . '/store/assets/images/avatar.png';
                // $reciver_name = get_userdata($value['receiver_id']);
                // var_dump($reciver_name);

                // $reciver_name = $reciver_name->display_name;
        
                if ($value['type'] === 'group') {
                    if ($value['sender_id'] == $current_user->ID) {
                        // Right-aligned message
                        $html .= '<div class="chat">
                        
                            <div class="chat-avatar">
                                <span class="avatar box-shadow-1 cursor-pointer">
                                    <img src="' . $img . '" alt="avatar" height="36" width="36" />
                                   
                                </span>
                                <div class="username"><span>'.$name.'</span></div>

                            </div>
                            
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>' . $value['body'] . '</p>
                                </div>
                            </div>
                        </div>';
                    } else {
                        // Left-aligned message
                        $html .= '<div class="chat chat-left">
                            <div class="chat-avatar">
                                <span class="avatar box-shadow-1 cursor-pointer">
                                    <img src="' . $img . '" alt="avatar" height="36" width="36" />

                                </span>
                                <div class="username"><span>'.$name.'</span></div>

                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>' . $value['body'] . '</p>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    // Handle individual messages as before
                    if ($value['receiver_id'] == $current_user->ID) { 
                        $html .= '<div class="chat chat-left">
                            <div class="chat-avatar">
                                <span class="avatar box-shadow-1 cursor-pointer">
                                    <img src="' . $img . '" alt="avatar" height="36" width="36" />
                                </span>
                                <div class="username"><span>'.$name.'</span></div>

                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>' . $value['body'] . '</p>
                                </div>
                            </div>
                        </div>';
                    } else {
                        $html .= '<div class="chat">
                            <div class="chat-avatar">
                                <span class="avatar box-shadow-1 cursor-pointer">
                                    <img src="' . $img . '" alt="avatar" height="36" width="36" />
                                </span>
                                <div class="username"><span>'.$name.'</span></div>

                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>' . $value['body'] . '</p>
                                </div>
                            </div>
                        </div>';
                    }
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

    function response_json($response){
		echo json_encode($response);
		wp_die(); 
	}

}
new Chatting();