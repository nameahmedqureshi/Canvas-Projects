<?php
if (!trait_exists('NotificationTrait')) {
    trait NotificationTrait {
    
        public function push_notifications($title, $content, $author){

            if (empty($title) || empty($content) || empty($author)) {
                return array(
                    'success' => false,
                    'message' => "Try again, something's amiss!",
                );
            }

            $post_data = array(
                'post_title'   => $title,
                'post_content' => $content,
                'post_status'  => 'publish', 
                'post_type'    => 'notifications',
                'post_author'	   => $author,
            );
        
            $post_id = wp_insert_post($post_data);

            
            
            if (is_wp_error($post_id)) {
            
                return array(
                    'success' => false,
                    'message' => "Try again, something's amiss!",
                );
            
            } else {
                return array(
                    'success' => true,
                    'post_id' => $post_id,
                    'message' => "Notification push successfully!!",
                );
            }
        }

    }
}
?>