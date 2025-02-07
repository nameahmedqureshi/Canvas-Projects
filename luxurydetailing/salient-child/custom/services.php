<?php 
class ManageServices {
    function __construct()
    {
        $variable = array('add_update_services', 'delete_services' , 'submit_review','load_more_reviews'  ,'update_review_status');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_services','service_orders','reviews_services');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function add_update_services() {
        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			
			return $this->response_json($response);
		}


        if (empty($_POST['single_price']) && (empty($_POST['cars_price']) || empty($_POST['truck_price']) || empty($_POST['over_sized']))) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required  main_service Fields";
            return $this->response_json($response);
        }

        if (empty($_POST['service_name'])  || empty($_POST['service_type']) ) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
      

        $user_id = get_current_user_id();
        $user = new WP_User( $user_id );
        // var_dump($user->roles[0]);
        // exit;
        // parse_str($_POST['form_data'], $form_data);
      
     
        $post_data = array(
			'post_title'   => $_POST['service_name'],
			'post_content'   => $_POST['description'],
			'post_status'  => 'publish', 
			'post_type'    => 'services',
			'author'	   => $user_id,
          //  'tags_input' => $topic_tags,
		);
       
        if(!empty($_POST['post_id'])){
			$post_data['ID'] = $_POST['post_id'];
			$post_id = wp_update_post($post_data);
		} else { 
			$post_id = wp_insert_post($post_data);
		}      

        if($post_id){
          
            update_post_meta($post_id,'cars_price',$_POST['cars_price']);
            update_post_meta($post_id,'truck_price',$_POST['truck_price']);
            update_post_meta($post_id,'over_sized',$_POST['over_sized']);
            update_post_meta($post_id,'single_price',$_POST['single_price']);
            update_post_meta($post_id,'single_price_text',$_POST['single_price_text']);
            update_post_meta($post_id,'service_type',$_POST['service_type']);
            update_post_meta($post_id,'status',$_POST['status']);

            if(isset($_FILES["service_image"])){
               
				$featured_image = $_FILES["service_image"];
				// set post thumnail for the post
				if($featured_image['size'] != 0) {
					$res = $this->uploadImage($featured_image);
					if($res["success"]) {
						$post_featured_image = $res['attach_id'];
                      
						// And finally assign featured image to post
						set_post_thumbnail( $post_id, $post_featured_image );
					}
				}
			}
        }
        // var_dump($post_id);
        // exit;

        if (is_wp_error($post_id)) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Try again, something's amiss!";
			
		} else {
                $response['icon'] = "success";
                $response['title'] = "Success";
                $response['message'] = "Service added successfully!";
                $response['auto_redirect'] = true;
                $response['status'] = true;
                $response['redirect_url'] = site_url('all-services');
		}

		return $this->response_json($response);
    }

   

    function delete_services() {
        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        if (empty($_POST['service_id'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "This service are not found.";
            return $this->response_json($response);
        }
        $result = wp_delete_post($_POST['service_id']);
        if (!$result) {
            $response['icon'] = "error";
            $response['message'] = "Service not deleted, something went wrong!";
            $response['status'] = false;
        } else {
            $response['icon'] = "success";
            $response['message'] = "Deleted Succesfully";
            $response['status'] = true;
        }
        return $this->response_json($response);
    }

    function register_services() {
        register_post_type('services',
            array(
                'labels'      => array(
                    'name'          => __('Services', 'textdomain'),
                    'singular_name' => __('Services', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title','editor', 'comments','thumbnail'),
                   // 'show_ui'   => false, 

            )
        );

    }
    function service_orders() {
        register_post_type('orders',
            array(
                'labels'      => array(
                    'name'          => __('Orders', 'textdomain'),
                    'singular_name' => __('Orders', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title','editor', 'comments'),
                    'menu_icon'   => 'dashicons-cart', 
                    // 'show_ui'   => false, 

            )
        );

    }
    function reviews_services() {
        register_post_type('reviews',
            array(
                'labels'      => array(
                    'name'          => __('Reviews', 'textdomain'),
                    'singular_name' => __('Reviews', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title','editor', 'comments','thumbnail'),
                   // 'show_ui'   => false, 

            )
        );

    }
    function submit_review() {
        if(isset($_POST['name']) && isset($_POST['rating']) && isset($_POST['description'])) {
            $new_review = array(
                'post_title' => sanitize_text_field($_POST['name']),
                'post_content' => sanitize_textarea_field($_POST['description']),
                'post_status' => 'pending',
                'post_type' => 'reviews',
            );
    
            $post_id = wp_insert_post($new_review);
    
            if($post_id) {
                update_post_meta($post_id, 'rating', intval($_POST['rating']));
                // send email
                ob_start();
                include get_stylesheet_directory() . '/custom/email_template/email-new-review.php';
                $email_content = ob_get_contents();
                ob_end_clean();
                $headers = array('Content-Type: text/html; charset=UTF-8');
                $msg = wp_mail(get_option('admin_email'), "Luxury Detailing", $email_content, $headers);
                wp_send_json_success();
            } else {
                wp_send_json_error();
            }
        } else {
            wp_send_json_error();
        }
    }
    function load_more_reviews() {
        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $reviews = new WP_Query(array('post_type' => 'reviews', 'post_status' => 'publish', 'posts_per_page' => 4, 'paged' => $paged));
    
        if($reviews->have_posts()) {
            ob_start();
            while($reviews->have_posts()) : $reviews->the_post();
                $rating = get_post_meta(get_the_ID(), 'rating', true);
                $description = get_the_content();
                ?>
                <div class="review-item">
                    <div class="review-image">
                        <img src="https://www.luxury-detailingllc.com/FIU/wp-content/uploads/2024/06/blank-profile-picture-973460_960_720.webp" alt="User Image">
                    </div>
                    <div class="review-content">
                        <div class="review-name"><?php the_title(); ?></div>
                        <div class="review-stars">
                            <?php for ($i = 0; $i < $rating; $i++) {
                                echo '&#9733;';
                            } ?>
                        </div>
                        <div class="review-description"><?php echo $description; ?></div>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
            $data = ob_get_clean();
            wp_send_json_success($data);
        } else {
            wp_send_json_error();
        }
    }

    function update_review_status() {
        if (!isset($_POST['post_id']) || !isset($_POST['status'])) {
            wp_send_json_error(array('message' => 'Invalid request.'));
        }
    
        $post_id = intval($_POST['post_id']);
        $new_status = sanitize_text_field($_POST['status']);
    
        // Update post status
        $updated = wp_update_post(array(
            'ID' => $post_id,
            'post_status' => $new_status,
        ));
    
        if ($updated !== 0) {
            $status_message = $new_status == 'publish' ? 'Published' : 'Pending';
            wp_send_json_success(array(
                'message' => 'Review status updated to ' . $status_message . '.',
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to update review status.'));
        }
        wp_die();
    }

    function uploadImage($file) {
        // fetch uploaded image
        $image = $file['tmp_name'];
        $filename = $file['name'];

        $upload_file = wp_upload_bits($filename, null, file_get_contents($image));

        if (!$upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'] );
            if (!is_wp_error($attachment_id)) {
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                wp_update_attachment_metadata( $attachment_id,  $attachment_data );

                return array(
                    'success' => true,
                    'url' => $upload_file['url'],
                    'attach_id' => $attachment_id
                );
            }
        } else {
            //send upload error 
            return array(
                'success' => false,
                'msg' => $upload_file['error']
            );
        }
    }

    function response_json($response) {
        echo json_encode($response);
        wp_die();
    }

} 
new ManageServices();