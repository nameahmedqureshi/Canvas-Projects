<?php 
// include "notification-trait.php";
class EventClass {
    // use NotificationTrait;

    function __construct()
    {
        $variable = array(
        'add_event',
        'delete_event', 
        'approved_event',
        'event_detail',      
        );
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_event');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function add_event() {
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};

        // var_dump($_POST);
      

        if (empty($_POST['event_name']) || empty($_POST['event_location']) || empty($_POST['start_date']) || empty($_POST['end_date'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }

        $post_data = array(
            'post_title'   => $_POST['event_name'],
            'post_content'   => $_POST['event_description'],
            'post_type'    => 'events',
        );
     
        if(in_array('administrator', wp_get_current_user()->roles)){ 
            $post_data['post_status'] = 'publish';
        }else {
            $post_data['post_status'] = isset($_POST['post_id']) ? 'publish' : 'draft';
        }
       
        // var_dump($post_data);
        // exit;
       
        if(!empty($_POST['post_id'])){
			$post_data['ID'] = $_POST['post_id'];
			$post_id = wp_update_post($post_data);
		} else { 
			$post_id = wp_insert_post($post_data);
		}      

        if($post_id){
            foreach ($_POST as $key => $value) {
                update_post_meta($post_id, $key, $value);
            }
            update_post_meta($post_id, 'username', wp_get_current_user()->display_name);
            update_post_meta($post_id, 'userid', wp_get_current_user()->ID);
        }

        if (is_wp_error($post_id)) {
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
			
		} else {
                $response['title'] = "Success";
                $response['message'] = "Event added successfully!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('event');
		}

		return $this->response_json($response);
    }

    function delete_event() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['event_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This event are not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['event_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "Event not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Event Removed";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function event_detail(){
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		};

        $post_detail = get_post($_POST['event_id']);
        $author = get_userdata($post_detail->post_author);
        $profile_pic = get_user_meta($post_detail->post_author, 'profile_pic', true);
        $image_url = wp_get_attachment_image_url( $profile_pic );

        // Define the number of comments per page
        // $comments_per_page = 1;
        // Get the current page number from the request, default to 1
        // $current_page = isset($_POST['page']) ? intval($_POST['page']) : 1;

        $commentsrgs = array(
            'post_id' => $_POST['event_id'], // ID of the post to get comments for
            'status'  => 'approve', // Get only approved comments
            // 'number'  => $comments_per_page,
            // 'offset'  => ($current_page - 1) * $comments_per_page,
        );

        // Retrieve the comments based on the arguments
        $comments = get_comments($commentsrgs);

        // Get the total number of comments
        // $total_comments = get_comments([
        //     'post_id' => $_POST['event_id'],
        //     'status'  => 'approve',
        //     'count'   => true,
        // ]);

        // Calculate total pages
        // $total_pages = ceil($total_comments / $comments_per_page);

        $event_html = '';
        $comment_html = '';

        $event_html = '
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

        $response['event_html'] = $event_html;
        $response['pagination_html'] = $pagination_html;
        $response['comment_html'] = $comment_html;
        $response['status'] = true;
        return $this->response_json($response);
    }
    
    function approved_event(){
        if(!is_user_logged_in()){
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}; 
       
        // var_dump($_POST);
  
        $post_id = wp_update_post([
            'ID' => $_POST['event_id'],
            'post_status' => 'publish'
        ]);

        if (is_wp_error($post_id)) {
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
			
		} else {
                $response['title'] = "Success";
                $response['message'] = "Event published!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('draft-events/?type=draft');
		}

		return $this->response_json($response);
    }

    function register_event() {
        register_post_type('events',
            array(
                'labels'      => array(
                    'name'          => __('Events', 'textdomain'),
                    'singular_name' => __('Events', 'textdomain'),
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
$event = new EventClass();