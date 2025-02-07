<?php 
class PollClass {

    function __construct()
    {
        $variable = array(
        'add_poll',
        'delete_poll', 
        'inactive_poll', 
        'poll_detail',
        'polling',
        'edit_poll'
        );
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_poll');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function add_poll() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};
      

        if (empty($_POST['question'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please fill question";
            return $this->response_json($response);
        }

        if (empty($_POST['options'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please fill options";
            return $this->response_json($response);
        }


        $post_data = array(
            'post_title'   => $_POST['question'],
            'post_type'    => 'poll',
            'post_status' => 'publish'
        );
       
        // var_dump($post_data);
        // exit;
       
        if(!empty($_POST['post_id'])){
			$post_data['ID'] = $_POST['post_id'];
			$post_id = wp_update_post($post_data);
		} else { 
			$post_id = wp_insert_post($post_data);
		}      

        if($post_id){
           

            $options = [];
            foreach ($_POST['options'] as $index => $val) {
                $options[] = $val;
            
            }
            update_post_meta($post_id, 'options', $options);

        }

        if (is_wp_error($post_id)) {
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
			
		} else {
                $response['title'] = "Success";
                $response['message'] = "Poll added successfully!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('poll');
		}

		return $this->response_json($response);
    }

    function delete_poll() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['poll_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This poll are not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['poll_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "Poll not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Poll deleted";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function inactive_poll() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['poll_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This poll are not found.";
            return $this->response_json($response);
        }
        $getPost = get_post($_POST['poll_id']);
        $postStatus = $getPost->post_status == 'draft' ? 'publish' : 'draft';
        // var_dump($getPost);
        // exit;
        $post_id = wp_update_post([
            'ID'   => $_POST['poll_id'],
            'post_type'    => 'poll',
            'post_status' => $postStatus 
        ]);
        if (is_wp_error($post_id)) {
            $response['icon'] = "error";
            $response['message'] = "something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Poll ".$postStatus;
            $response['auto_redirect'] = true;
            $response['status'] = true;
            $response['redirect_url'] = site_url('poll');
        }
        return $this->response_json($response);
    }

    function polling(){
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        $user_id = get_current_user_id();

        $pollData = get_post_meta($_POST['poll_id'], 'pollData', true);
        if (!is_array($pollData)) {
            $pollData = [];
        }
        if(array_key_exists($user_id ,$pollData)){
            // Unset the existing entry for the user
            unset($pollData[$user_id]);
        }
        
        $pollData[$user_id] = $_POST['poll_value'];
       
        update_post_meta($_POST['poll_id'], 'pollData', $pollData);

        $response['title'] = "Success";
        $response['message'] = "Thank you for poll";
        $response['status'] = true;
        return $this->response_json($response);
    }

    function edit_poll(){
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }
        $pollOptions = get_post_meta($_POST['poll_id'], 'options', true);
        $options = '';
        foreach($pollOptions as $val){ 
            $options .= '<div class="poll_options" style="display:flex !important"><div class="col-md-8 col-12">
                        <label class="form-label">+Add</label>
                        <input type="text" name="options[]" class="form-control" placeholder="+Add" value="'. $val .'" />
                    </div>
                    <div class="col-md-2 col-12 mb-50">
                        <div class="mb-1">
                            <button class="btn btn-outline-danger text-nowrap px-1 delete_option" type="button">
                                <i data-feather="x" class="me-25"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div></div>';

        }

        $response['title'] = get_the_title($_POST['poll_id']);
        $response['options'] = $options;
        $response['status'] = true;
        return $this->response_json($response);


    }

    function poll_detail(){
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};

        $post_detail = get_post($_POST['forum_id']);
        $author = get_userdata($post_detail->post_author);
        $profile_pic = get_user_meta($post_detail->post_author, 'profile_pic', true);
        $image_url = wp_get_attachment_image_url( $profile_pic );

        // Define the number of comments per page
        // $comments_per_page = 1;
        // Get the current page number from the request, default to 1
        // $current_page = isset($_POST['page']) ? intval($_POST['page']) : 1;

        $commentsrgs = array(
            'post_id' => $_POST['forum_id'], // ID of the post to get comments for
            'status'  => 'approve', // Get only approved comments
            // 'number'  => $comments_per_page,
            // 'offset'  => ($current_page - 1) * $comments_per_page,
        );

        // Retrieve the comments based on the arguments
        $comments = get_comments($commentsrgs);

        // Get the total number of comments
        // $total_comments = get_comments([
        //     'post_id' => $_POST['forum_id'],
        //     'status'  => 'approve',
        //     'count'   => true,
        // ]);

        // Calculate total pages
        // $total_pages = ceil($total_comments / $comments_per_page);

        $forum_html = '';
        $comment_html = '';

        $forum_html = '
            <div class="row">
                <div class="col-12">
                    <div class="email-label">
                        <span class="mail-label badge rounded-pill badge-light-primary">Latest</span>
                    </div>
                </div>
            </div>
            <div class="row question">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header email-detail-head">
                            <div class="user-details d-flex justify-content-between align-items-center flex-wrap">
                                <div class="avatar me-75">
                                    <img src="' . (!empty($image_url) ? $image_url : get_stylesheet_directory_uri() . '/store/assets/images/avatar.png') . '" alt="avatar img holder" width="48" height="48" />
                                </div>
                                <div class="mail-items">
                                    <h5 class="mb-0">'. get_the_title( $post_detail->ID ) .'</h5>
                                    <div>
                                        <span role="button" class="dropdown-toggle font-small-3 text-muted">
                                           '. $author->display_name .'
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mail-meta-item d-flex align-items-center">
                                <small class="mail-date-time text-muted">'. date("d M y, g:i A", strtotime($post_detail->post_date)) .'</small>
                            </div>
                        </div>
                        <div class="card-body mail-message-wrapper pt-2">
                            <div class="mail-message">
                                <p class="card-text postcontent">
                                    '. $post_detail->post_content .'
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

        // Check if comments are found
        if (!empty($comments)) { 
            foreach ($comments as $comment) { 
                $author = get_userdata($comment->comment_author);
                $profile_pic = get_user_meta($comment->comment_author, 'profile_pic', true);
                $image_url = wp_get_attachment_image_url( $profile_pic );
                $comment_html .= '
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header email-detail-head">
                                <div class="user-details d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="avatar me-75">
                                        <img src="' . (!empty($image_url) ? $image_url : get_stylesheet_directory_uri() . '/store/assets/images/avatar.png') . '" alt="avatar img holder" width="48" height="48" />
                                    </div>
                                    <div class="mail-items">
                                        <h5 class="mb-0">'. $author->display_name .'</h5>
                                    </div>
                                </div>
                                <div class="mail-meta-item d-flex align-items-center">
                                    <small class="mail-date-time text-muted">'. date("d M y, g:i A", strtotime($comment->comment_date)) .'</small>
                                </div>
                            </div>
                            <div class="card-body mail-message-wrapper pt-2">
                                <div class="mail-message">
                                    <p class="card-text postcontent">
                                        '. $comment->comment_content .'
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
              }
        }

        // Generate pagination HTML
        // $pagination_html = '';
        // if ($total_pages > 1) {
        //     $pagination_html .= '<div class="pagination">';
        //     for ($i = 1; $i <= $total_pages; $i++) {
        //         $active_class = ($i === $current_page) ? 'active' : '';
        //         $pagination_html .= '<button class="page-link ' . $active_class . '" data-page="' . $i . '">' . $i . '</button>';
        //     }
        //     $pagination_html .= '</div>';
        // }

        $response['forum_html'] = $forum_html;
        $response['pagination_html'] = $pagination_html;
        $response['comment_html'] = $comment_html;
        $response['status'] = true;
        return $this->response_json($response);
    }

    function register_poll() {
        register_post_type('poll',
            array(
                'labels'      => array(
                    'name'          => __('Poll', 'textdomain'),
                    'singular_name' => __('Poll', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title','editor', 'comments','thumbnail'),

            )
        );
    }

    function response_json($response) {
        echo json_encode($response);
        wp_die();
    }

} 
$poll = new PollClass();