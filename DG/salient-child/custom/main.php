<?php 
class MainClass {

    function __construct(){
        $variable = array('update_post_like_dislike','add_custom_comment','get_comments_by_post_id');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }

    }
        // like dislike // 
        public function update_post_like_dislike() {
            $post_id = $_POST['post_id'];
            $current_action = sanitize_text_field($_POST['current_action']);
            $previous_action = sanitize_text_field($_POST['previous_action']);
            
            $like_count = get_field('video_like', $post_id);
            $dislike_count = get_field('video_dislike', $post_id);
           
            // $cookie_val = $_COOKIE[$post_id.'_action'];
            // exit;

            // $message = '';
			if ($previous_action == 'like') {
					$like_count = $like_count ? $like_count - 1 : 0;
					update_field('video_like', $like_count, $post_id);
					// $message = 'Your liked has been removed';

			} elseif ($previous_action == 'dislike') {
					$dislike_count = $dislike_count ? $dislike_count - 1 : 0;
					update_field('video_dislike', $dislike_count, $post_id);
					// $message = 'Your disliked has been removed';

			}

			 if ($current_action == 'like') {
					$like_count = $like_count ? $like_count + 1 : 1;
					update_field('video_like', $like_count, $post_id);
				 	// $message = 'Your liked has been counted';

			 } elseif ($current_action == 'dislike') {
					$dislike_count = $dislike_count ? $dislike_count + 1 : 1;
					update_field('video_dislike', $dislike_count, $post_id);
				 	// $message = 'Your disliked has been counted';
			 }
			
        
				// $response['icon'] = "success";
				// $response['title'] = "Success";
				// $response['message'] = $message;

        
           	 return $this->response_json($response);
        }
       public function add_custom_comment() {
          
            if(empty($_POST['name']) || empty($_POST['comment']) ){
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "PLease Fill Required Field";
                return $this->response_json($response);
            }
            
            $commentdata = array(
                'comment_post_ID'      => $_POST['post_id'],
                'comment_author'       => $_POST['name'], // Name of the comment author
                'comment_author_email' => 'test@test.com', // Email of the comment author
                'comment_author_url'   => 'http://example.com', // URL of the comment author
                'comment_content'      => $_POST['comment'], // Content of the comment
                'comment_type'         => '', // Type of comment (empty string for standard comment)
                'comment_parent'       => 0, // ID of the parent comment if this is a reply
                'user_id'              => 0, // ID of the user (0 if not logged in)
                'comment_approved'     => 1, // Whether the comment is approved (1 for approved, 0 for not approved)
            );
            //   var_dump($commentdata);
            //  exit;
        
            // Insert the comment and retrieve the new comment ID
            $comment_id = wp_insert_comment($commentdata);
           
            if (is_wp_error($comment_id)) {
                    $response['icon'] = "error";
                    $response['title'] = "Error";
                    $response['status'] = false;
                    $response['message'] = "Try again, something's amiss!";
                
            } else {
                    $response['icon'] = "success";
                    $response['title'] = "Success";
                    $response['message'] = "Comment added successfully!";
                    $response['status'] = true;
                    $response['post_id'] = $_POST['post_id'];
                  //  $response['auto_redirect'] = true;
                  //  $response['redirect_url'] = home_url('categories');
            }

		    return $this->response_json($response);
            
        }

         function get_comments_by_post_id(){
            $html='';
            $commentsrgs = array(
                'post_id' => $_POST['post_id'], // ID of the post to get comments for
                'status'  => 'approve' // Get only approved comments
            );

            // Retrieve the comments based on the arguments
            $comments = get_comments($commentsrgs);

            $like_count = get_field('video_like', $_POST['post_id']);
            $dislike_count = get_field('video_dislike', $_POST['post_id']);

            // Check if comments are found
            if (!empty($comments)) { 
                foreach ($comments as $comment) { 
                    $html .= '<div class="reviews">
                        <div class="col span_3">
                            <div class="profile_img">
                                <img src="https://devu06.testdevlink.net/DG/wp-content/uploads/2024/05/dummy450x450-300x300-1.jpg" alt="">
                            </div>
                        </div>
                        <div class="col span_9">
                            <div class="comment_box main_box">
                                <h4>'.$comment->comment_author.'</h4>
                                <p>'. $comment->comment_content .'</p>
                            </div>
                        </div>
                    </div>';
                  }
            } else {
                $html =  'No comments found.';
            }

            if (empty($_POST['post_id']) ) {
              
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
                
            } else {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['status'] = true;
                $response['html'] = $html;
                $response['like'] = $like_count;
                $response['dislike'] = $dislike_count;
            }
        
            return $this->response_json($response);

         } 

        function response_json($response){
            echo json_encode($response);
            wp_die(); 
        }
        
        // Example usage: Add a comment to post with ID 123
        // add_custom_comment(123);
}
new MainClass();

// video Custom Post Type
function video_init() {
    // set up product labels
    $labels = array(
        'name' => 'Video',
        'singular_name' => 'Video',
        'add_new' => 'Add New Video',
        'add_new_item' => 'Add New Video',
        'edit_item' => 'Edit Video',
        'new_item' => 'New Video',
        'all_items' => 'All Videos',
        'view_item' => 'View Video',
        'search_items' => 'Search Videos',
        'not_found' =>  'No Videos Found',
        'not_found_in_trash' => 'No Videos found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Videos',
    );
    
    // register post type
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'video'),
        'query_var' => true,
        'menu_icon' => 'dashicons-format-video',
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
        )
    );
    register_post_type( 'video', $args );
    
    // register taxonomy
    // register_taxonomy('video_category', 'video', array('hierarchical' => true, 'label' => 'Category', 'query_var' => true, 'rewrite' => array( 'slug' => 'video-category' )));
}
add_action( 'init', 'video_init' );?>