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

        // var_dump($_POST);
        // exit;
		if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
		}
		global $wpdb;
		// var_dump($receiver_id);
		// exit;
        if(empty($_POST['message'])){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Message should be filled";
            return $this->response_json($response);
        }

        $get_sender_profile_image_id = get_user_meta( get_current_user_id() , 'profile_pic', true );
        $get_sender_profile_image_url = wp_get_attachment_image_url( $get_sender_profile_image_id );
        $sender_img = !empty($get_sender_profile_image_url) ? $get_sender_profile_image_url : get_stylesheet_directory_uri() .'/multivendor/assets/images/avatar.png';
        
    

		$html = '';
       
		$html .= '<div class="chat">
            <div class="chat-avatar">
                <span class="avatar box-shadow-1 cursor-pointer">
                    <img src="'. $sender_img .'" alt="avatar" height="36" width="36" />
                </span>
            </div>
            <div class="chat-body">
                <div class="chat-content">
                    <p>'.$_POST['message'].'</p>
                </div>
            </div>
        </div>';
		
		$query = $wpdb->insert("wp_custom_chat", array(
		   "sender_id" => get_current_user_id(),
		   "receiver_id" => $_POST['receiver_id'],
		   "body" => $_POST['message'],
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

        if (empty($message_id)) {
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
            return $this->response_json($response);

		}
       
       // var_dump($current_user->ID);
		if($message_id){
           
			$messages = $wpdb->get_results( "SELECT `id`, `sender_id`, `receiver_id`, `body`, `created_at` 
			FROM ".$wpdb->prefix."custom_chat 
			WHERE 
			(sender_id = $current_user->ID AND receiver_id = $message_id) 
			OR (receiver_id = $current_user->ID AND sender_id = $message_id) 
			ORDER BY id ASC", ARRAY_A);
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

                  
                    //var_dump($receiver_img);

                    $html .= ' <div class="chat chat-left">
                        <div class="chat-avatar">
                            <span class="avatar box-shadow-1 cursor-pointer">
                                <img src="'. $sender_img .'" alt="avatar" height="36" width="36" />
                            </span>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>'.$value['body'].'</p>
                            </div>
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
                                <p>'.$value['body'].'</p>
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

    function response_json($response){
		echo json_encode($response);
		wp_die(); 
	}

}
new Chat();