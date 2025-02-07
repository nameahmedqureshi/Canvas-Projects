<?php 
class VideoCompetition {

    function __construct(){
        $variable = array('update_post_like');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }

    }
        // like dislike // 
        public function update_post_like() {
            $post_id = $_POST['post_id'];
            $key = $_POST['key'];
            $current_like_post_id = sanitize_text_field($_POST['current_like_post_id']);
            $previous_like_post_id = sanitize_text_field($_POST['previous_like_post_id']);
            
            // $like_count = get_field('video_'.$key.'_like', $post_id);
            $current_like_count = get_field($current_like_post_id, $post_id);
            $previous_like_count = get_field($previous_like_post_id, $post_id);
            // var_dump($current_like_count);
            // var_dump($previous_like_count);
            // $cookie_val = $_COOKIE[$post_id.'_action'];
            // exit;

           // $message = '';
            if ($previous_like_post_id) {
                $previous_like_count = $previous_like_count ? $previous_like_count - 1 : 0;
                update_field($previous_like_post_id, $previous_like_count, $post_id);
            }

            if ($current_like_post_id) {
                $current_like_count = $current_like_count ? $current_like_count + 1 : 1;
                update_field($current_like_post_id, $current_like_count, $post_id);
            } 

            $response['video_0_like'] = get_field('video_0_like', $post_id);
            $response['video_1_like'] = get_field('video_1_like', $post_id);
            $response['video_2_like'] = get_field('video_2_like', $post_id);
            $response['video_3_like'] = get_field('video_3_like', $post_id);
            $response['video_4_like'] = get_field('video_4_like', $post_id);
            return $this->response_json($response);
        }
      
        function response_json($response){
            echo json_encode($response);
            wp_die(); 
        }
}
new VideoCompetition();