<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


class ManageServices {
    function __construct()
    {
        $variable = array('add_update_services', 'delete_services', 'get_slots' );
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_services','service_orders');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function get_slots() {
        if (empty($_POST['id']) || empty($_POST['date'])) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "select date first";
            return $this->response_json($response);
        }

        $meta = get_post_meta( $_POST['id'] );
        $slots = isset($meta['slots'][0]) ? unserialize($meta['slots'][0]) : [];     
        $saveSlots = [];
        foreach ($slots as $key => $value) {
            if ( $value['days'] == $_POST['weekday']) {
                $saveSlots = $value;
                break;
            }
        }
        
        
        if (empty($saveSlots)) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Service Duration & Time not found Pleae contact to admin";
            return $this->response_json($response);
        }

        $slots = $this->getServiceScheduleSlots($saveSlots['duration'], $saveSlots['start_time'], $saveSlots['end_time']);

        $args = array(
            'post_type' => 'orders', // Specify the post type
            'meta_key' => 'date', // Replace 'your_meta_key' with the actual meta key
            'post_status'  => 'publish', 
            'meta_value' => $_POST['date'], // Replace 'your_meta_value' with the desired meta value
            'meta_compare' => '=', // Use '=' for exact match, or other comparison operators as needed
        );
        
        $query = new WP_Query($args);

        foreach ($query->posts as $key => $value) {
            $postMeta =  get_post_meta( $value->ID);
            $bookedSlots[] = $postMeta['slots'][0];
        }

        $response['slots'] = $slots;
        $response['booked'] = $bookedSlots;
        $response['status'] = true;
        return $this->response_json($response);
    }

    function add_update_services() {

        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			
			return $this->response_json($response);
		}

        if (empty($_POST['service_name']) || empty($_POST['price'])  ) {
            $response['icon'] = "error";
            $response['status'] = false;
            $response['message'] = "Please Fill Required Fields";
            return $this->response_json($response);
        }
      
        // if($_POST['dna_check'] && empty($_POST['dna_option']) ){
        //     $response['icon'] = "error";
        //     $response['status'] = false;
        //     $response['message'] = "Please Fill DNA Options";
        //     return $this->response_json($response);

        // }

     

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

            $exception = ['action', 'service_name', 'description', 'post_id', 'service_image', 'dna_check'];
            foreach ($_POST as $key => $value) {
                if (in_array($key, $exception)) { continue; }
                update_post_meta($post_id, $key, $value);
            }
            update_post_meta($post_id, 'dna_check', $_POST['dna_check']);
            // update_field('price', $_POST['service_price'], $post_id);

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

    function getServiceScheduleSlots($duration, $start,$end) {
        $orignalStart = $start;
        $orignalEnd = $end;
        $start = new DateTime($start);
        $end = new DateTime($end);
        $start_time = $start->format('Y-m-d H:i');
        $end_time = $end->format('Y-m-d H:i');
        $end_time = strtotime($start_time) <= strtotime($end_time) ? $end_time :  date('Y-m-d H:i',strtotime('+1 day', strtotime($start_time)));
        $i=0;
        while(strtotime($start_time) <= strtotime($end_time)){
            $start = $start_time;
            $end = date('Y-m-d H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
            $start_time = date('Y-m-d H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
            $i++;
            if(strtotime($start_time) <= strtotime($end_time)){

                $finalStart = date('h:ia', strtotime($start));
                $finalEnd = date('h:ia', strtotime($end));

                $time[$i] = $finalStart." - ".$finalEnd;
                // $time[$i]['start'] = $start;
                // $time[$i]['end'] = $end;
                // $time[$i]['isBooked'] = 'false';
                if ($orignalEnd == date('H:i:s', strtotime($end))) {
                   break;
                }
            }
        }
        return $time;
    }

    
    function response_json($response) {
        echo json_encode($response);
        wp_die();
    }

} 
new ManageServices();