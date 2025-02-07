<?php
class MainClass {

    public $current_user;
	public $jeep_cpt = 'jeeps';
	public $contact_cpt = 'queries';
	public $duck_cpt = 'ducks';
	public $pub_key = 'pk_test_51MTv5mDvdkIAX53sPrbH9lKokXRpHH89qBb2WldkNBlHFzNOZX7FNSn0WubzTzOGNlCkh5DU3gicu2iHymq6veUj00fWeLPfCC';
	public $sec_key = 'sk_test_51MTv5mDvdkIAX53sJqrfeu6UJ6F7OhqP8WdLEelu9ZBwq8gfzXLEbs3NP9DDr8cHyXyfeSnbzcIMAQbJVBOjZFtr004sg69YVh';

    function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_files' ) );
		add_action('save_post', array( $this, 'save_custom_jeep_meta'));

		$cpt = array('register_post_type', 'register_contact_post_type', 'register_duck_post_type');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }

		$cpt_meta_box = array('add_custom_jeep_meta_box', 'add_custom_contact_meta_box');
        foreach ($cpt_meta_box as $k => $v) {
            add_action('add_meta_boxes',array($this,$v));
        }

		$variable = array('add_jeep', 'add_jeep_gallery',  'delete_jeep', 'delete_jeep_gallery', 'add_duck', 'getQRCode', 'getDuckJourney' , 'update_user_profile', 'add_contact');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }
    }

	function enqueue_custom_files() {
		$allowPageIds = [434, 436, 438, 440, 442, 444, 446, 448, 450, 452, 454];
		$id = get_queried_object_id();
		if (in_array($id, $allowPageIds)) {
			wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/templates/assets/front/css/style.css', array(), '1.0', 'all');
			wp_enqueue_style('bootstrap-style', get_stylesheet_directory_uri() . '/templates/assets/front/css/bootstrap.min.css', array(), '1.0', 'all');
			wp_enqueue_style('responsive-style', get_stylesheet_directory_uri() . '/templates/assets/front/css/responsive.css', array(), '1.0', 'all');
			wp_enqueue_style('fancybox-style', get_stylesheet_directory_uri() . '/templates/assets/front/css/jquery.fancybox.min.css', array(), '1.0', 'all');
			wp_enqueue_style('swiper-bundle-style', get_stylesheet_directory_uri() . '/templates/assets/front/css/swiper-bundle.min.css', array(), '1.0', 'all');

			wp_enqueue_script('jquery-script', get_stylesheet_directory_uri() . '/templates/assets/front/js/jquery-3.6.0.min.js', array('jquery'), true);
			wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/templates/assets/front/js/bootstrap.min.js', array(), true);
			wp_enqueue_script('fancybox-script', get_stylesheet_directory_uri() . '/templates/assets/front/js/jquery.fancybox.min.js', array(), true);
			wp_enqueue_script('swiper-script', get_stylesheet_directory_uri() . '/templates/assets/front/js/swiper-bundle.min.js', array(), true);
			wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
			wp_enqueue_script('qrcode', 'https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js', array(), null, true);
			// Enqueue DataTables CSS
			wp_enqueue_style('datatables', 'https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css');
			wp_enqueue_script('jquery');
			// Enqueue DataTables JavaScript
			wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js', array('jquery'), true);
		}
		$allowStripe = [434];
		if (in_array($id, $allowStripe)) {
			wp_enqueue_script('stripe', 'https://js.stripe.com/v3/', array(), '3.0', true); //Stripe
		}
			wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/templates/assets/front/js/custom.js', array(), true);
			wp_enqueue_script('scanner', 'https://unpkg.com/@zxing/library@0.20.0/umd/index.min.js', array(), null, true);

			$user_data =   array( 
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'pub_key' => $this->pub_key,
				'sec_key' => $this->sec_key
			);
			wp_localize_script('custom-script', 'ajax_script', $user_data);
	}

	
	// Add Jeep
	function add_jeep() {
		if(!is_user_logged_in()){
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
			return $this->jsonResponse($response);
		}
		$current_user = wp_get_current_user(); 
		$existing_post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
		$jeep_name = isset($_POST['jeep_name']) ? sanitize_text_field($_POST['jeep_name']) : '';
		$jeep_model = isset($_POST['jeep_model']) ? sanitize_text_field($_POST['jeep_model']) : '';
		$jeep_year = isset($_POST['jeep_year']) ? sanitize_text_field($_POST['jeep_year']) : '';
		$jeep_code = isset($_POST['jeep_code']) ? sanitize_text_field($_POST['jeep_code']) : '';
		$jeep_desc = isset($_POST['jeep_desc']) ? sanitize_text_field($_POST['jeep_desc']) : '';
		$jeep_category = isset($_POST['jeep_category']) ? sanitize_text_field($_POST['jeep_category']) : '';
		$latitide = isset($_POST['latitide']) ? sanitize_text_field($_POST['latitide']) : '';
		$longitude = isset($_POST['longitude']) ? sanitize_text_field($_POST['longitude']) : '';

		$post_data = array(
			'post_title'   => $jeep_name,
			'post_content' => $jeep_desc,
			'post_status'  => 'publish', 
			'post_type'    => $this->jeep_cpt,
			'author'	   => $current_user->ID,
		);

		if($existing_post_id){
			$post_data['ID'] = $existing_post_id;
			$post_id = wp_update_post($post_data);
		} else { 
			$post_id = wp_insert_post($post_data);
		}
			
		if($post_id){
			update_post_meta( $post_id, 'jeep_model', $jeep_model );
			update_post_meta( $post_id, 'jeep_year', $jeep_year );
			update_post_meta( $post_id, 'jeep_code', $jeep_code );
			update_post_meta( $post_id, 'latitide', $latitide );
			update_post_meta( $post_id, 'longitude', $longitude );
			// Set the selected category
			wp_set_object_terms($post_id, $jeep_category, 'jeep-category');
		
			if(isset($_FILES["image"])){
				$featured_image = $_FILES["image"];
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

		if (is_wp_error($post_id)) {
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
		} else {
			$response = array(
				'status' => 'success',
				'message' => "Jeep added successfully!",
				'redirect' => site_url('all-jeeps'),
			);
		}

		return $this->jsonResponse($response);
	}

	// Add Duck
	function add_duck() {
		if(!is_user_logged_in()){
			$response = array(
				'status' => 'error',
				'message' => "You're session is expired!",
			);
			return $this->jsonResponse($response);
		}

		$user_id = get_current_user_id();
		// Retrieve the token from the request
		$token = $_POST['stripeToken'];
		$existing_jeep_id = isset($_POST['jeep']) ? $_POST['jeep'] : '';
		$existing_duck_id =  isset($_POST['duck_id']) ? $_POST['duck_id'] : '';
		$duck_name =  sanitize_text_field($_POST['duck_name']);

		if( !empty($_POST['duck_name']) ){
			$duck_data = array(
				'post_title'   => $duck_name,
				'post_status'  => 'publish', 
				'post_type'    => $this->duck_cpt,
			);
			
		}
			
		if ($existing_duck_id){
			$duck_data['ID'] = $existing_duck_id;
			$duck_post_id = wp_update_post( $duck_data );
			$stripe_response = $this->makePayment($token);
		
		} else { 
			$duck_post_id = wp_insert_post( $duck_data );
			$stripe_response = $this->makePayment($token);
		}
		
		if($duck_post_id){
			$this->checkJeepStatus($existing_jeep_id);
			update_post_meta( $duck_post_id, 'active_duck', $existing_jeep_id );
			add_post_meta( $duck_post_id, 'duck_journey', $existing_jeep_id );
			update_post_meta( $duck_post_id, 'user_id', $user_id );
			update_post_meta( $duck_post_id, 'status', 'Assigned' );
		}

		if (is_wp_error($post_id)) {
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
		} else {
			$response = array(
				'status' => 'success',
				'message' => "Duck added successfully!",
				'redirect' =>  site_url('ducking-records'),
			);
		}

		return $this->jsonResponse($response);
	}

	function makePayment($token){
		// Set your Stripe secret key
		\Stripe\Stripe::setApiKey($this->sec_key);

		$charge_params = [
			'amount' => 100, // Amount in cents
			'currency' => 'usd',
			'source' => $token,
			'description' => 'Duck payment'
		];
		try {
				$charge = \Stripe\Charge::create($charge_params);
				return  ['success' => true];
			}
			catch(Exception $e) {
				return $this->jsonResponse(['status'=> false, 
					'message' =>  $e->getMessage() 
				]);
			}
	}

	function checkJeepStatus($checkJeepStatus){
		$args = array(
			'post_type'      => 'ducks',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => 'active_duck', 
					'value'   => $checkJeepStatus, 
					'compare' => '=', 
				),
			),
		);

		$query = new WP_Query($args);
		while ($query->have_posts()) : $query->the_post();
			update_post_meta(get_the_ID(), 'active_duck', 0); 
			update_post_meta(get_the_ID(), 'status', 'Unassigned'); 
		endwhile;
	}
	// Add Jeep Gallery
	function add_jeep_gallery() {
		if(!is_user_logged_in()){
			$response = array(
				'status' => 'error',
				'message' => "Try again, with login!",
			);
			return $this->jsonResponse($response);
		}
		$random_number = (rand(10,1000));
		//$existing_post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
		$post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
		//$existing_key = isset($_POST['meta_key']) ? $_POST['meta_key'] : '';
		$gallery_title = isset($_POST['gallery_title']) ? $_POST['gallery_title'] : '';
		$gallery_desc = isset($_POST['gallery_desc']) ? $_POST['gallery_desc'] : '';
		$gallery_image = isset($_FILES['gallery_image']) ? $_FILES['gallery_image'] : '';

		$post_data = [
			'gallery_title' => $gallery_title,
			'gallery_desc' => $gallery_desc,
			'gallery_image' => str_replace(' ', '-', $gallery_image['name']),
		];	
		//if(empty($existing_key)){
			update_post_meta( $post_id, 'gallery_'.$random_number, $post_data);

		// } else {
		// 	update_post_meta( $existing_post_id, $existing_key, $gallery);
		// }


		if(isset($gallery_image)){
			$featured_image = $gallery_image;
			// set post thumnail for the post
			if($featured_image['size'] != 0) {
				$res = $this->uploadImage($featured_image);
				if($res["success"]) {
					$post_featured_image = $res['attach_id'];
					
				}
			}
		}
		
		if (is_wp_error($post_id)) {
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
		} else {
			$response = array(
				'status' => 'success',
				'message' => "Image added successfully!",
				'redirect' => site_url('my-ducking-gallery?id='.$post_id),
			);
		}

		return $this->jsonResponse($response);
	}

	function jsonResponse($response){
		echo json_encode($response);
		wp_die(); 
	}
	
	
	function getQRCode(){
		$duck_id = $_POST['data'];
		$decyrpt_id = $this->decryptData($duck_id);
		if($decyrpt_id){
			$post = get_post( $decyrpt_id );
			$data = [
				'duck_id' => $post->ID,
				'duck_name' => $post->post_title,
				'duck_image' => get_the_post_thumbnail($post->ID),
			];
		}
		if (!isset($post->ID)) {
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
		} else {
			$response = array(
				'status' => 'success',
				'message' => "QR code retrieved sucessfully!",
				'data' =>  $data,
			);
		}

		return $this->jsonResponse($response);
	}

	function getDuckJourney(){
		$duck_id = $_POST['data'];
		$decyrpt_id = $this->decryptData($duck_id);
		$args = array(
			'post_type'      => 'ducks',
			'post__in'       => array($decyrpt_id),  // Specify the post IDs you want to retrieve
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => 'duck_journey',
					'compare' => 'EXISTS',
				),
				array(
					'key'     => 'active_duck',
					'compare' => 'EXISTS',
				),
			),
		);
		$query = new WP_Query($args);
		
		$locations = array();
	
		if ($query->have_posts()) {
			while ($query->have_posts()) : $query->the_post();
	
				$duck_journeys = get_post_meta(get_the_ID(), 'duck_journey');
				
				foreach ($duck_journeys as $duck_journey_id) {
					$lat = get_post_meta($duck_journey_id, 'latitide', true);
					$lng = get_post_meta($duck_journey_id, 'longitude', true);
					
					$active_ducks = get_post_meta(get_the_ID(), 'active_duck');
					$duck_id = $this->encryptData(get_the_ID());
					
					$duck_name = get_the_title();
					$duck_status = get_post_meta(get_the_ID(), 'status');
					$jeep_name = get_the_title($duck_journey_id);
					$permalink = site_url('add-duck?id='.get_the_ID());
	
					$locations[] = array(
						'duck_id'      => $duck_id,
						'duck_journey' => $duck_journey_id,
						'active_duck'  => $active_ducks,
						'lat'          => $lat,
						'lng'          => $lng,
						'duck_name'    => $duck_name,
						'duck_status'  => $duck_status,
						'jeep_name'    => $jeep_name,
						'permalink'    => $permalink,
					);
				}
	
			endwhile;
			// var_dump($locations);
			// 		exit;
			
			wp_reset_postdata(); // Restore original post data
		}

		
		if (!isset($query)) {
			$response = array(
				'status' => 'error',
				'message' => "Try again, something's amiss!",
			);
		} else {
			$response = array(
				'status' => 'success',
				'message' => "Duck retrieved sucessfully!",
				'locations' =>  $locations,
			);
		}

		return $this->jsonResponse($response);
	}

	// function edit_jeep_gallery(){
	// 	$post_id = $_REQUEST['post_id'];
	// 	if($post_id){
	// 		$data = array(
	// 			get_post_meta( $post_id, 'jeep_model', true ),
	// 			get_post_meta( $post_id, 'jeep_year', true ),
	// 			get_post_meta( $post_id, 'jeep_code', true),
	// 		);
			
	// 	}
	// 	if (is_wp_error($_REQUEST['post_id'])) {
	// 		$response = array(
	// 			'status' => 'error',
	// 			'message' => "Try again, something's amiss!",
	// 		);
	// 	} else {
	// 		$response = array(
	// 			'status' => 'success',
	// 			'message' => "Jeep found!",
	// 			'data' => $data,
	// 			'redirect' => site_url('add-jeeps'),
	// 		);
	// 	}
	// 	echo json_encode($response);
	// 	wp_die(); 
	// }

	function delete_jeep_gallery(){
		global $wpdb;
		$post_id = isset($_REQUEST['post_id']) ? intval($_REQUEST['post_id']) : 0;
		$key =  $_REQUEST['meta_key'];
		$table = $wpdb->prefix.'postmeta';
		$wpdb->delete ($table, array('meta_key' => $key));
		 if (is_wp_error($post_id)) {
		 	$response =  "Try again, something's amiss!";
		 } else {
			$response = 'Image deleted!';
		}
		echo json_encode($response);
		wp_die(); 
	}


	function delete_jeep(){
		wp_delete_post( $_REQUEST['post_id'] );
		 if (is_wp_error($_REQUEST['post_id'])) {
		 	$response =  "Try again, something's amiss!";
		 } else {
			$response = 'Jeep deleted!';
		}
		echo json_encode($response);
		wp_die(); 
	}

	function register_post_type(){
		register_post_type($this->jeep_cpt,
		$labels = array(
				'labels'      => array(
					'name'          => __('Jeeps', 'textdomain'),
					'singular_name' => __('Jeeps', 'textdomain'),
				),
					'public'      => true,
					'has_archive' => true,
					'supports' => array('title', 'editor', 'thumbnail')
			)
		);
		// Register Custom Taxonomy
		$taxonomy_labels = array(
			'name'              => _x('Jeep Categories', 'taxonomy general name', 'textdomain'),
			'singular_name'     => _x('Jeep Category', 'taxonomy singular name', 'textdomain'),
			'search_items'      => __('Search Jeep Categories', 'textdomain'),
			'all_items'         => __('All Jeep Categories', 'textdomain'),
			'parent_item'       => __('Parent Jeep Category', 'textdomain'),
			'parent_item_colon' => __('Parent Jeep Category:', 'textdomain'),
			'edit_item'         => __('Edit Jeep Category', 'textdomain'),
			'update_item'       => __('Update Jeep Category', 'textdomain'),
			'add_new_item'      => __('Add New Jeep Category', 'textdomain'),
			'new_item_name'     => __('New Jeep Category Name', 'textdomain'),
			'menu_name'         => __('Jeep Categories', 'textdomain'),
		);

		$taxonomy_args = array(
			'hierarchical'      => true,
			'labels'            => $taxonomy_labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'jeep-categories'),
		);

		register_taxonomy('jeep-category', array('jeeps'), $taxonomy_args);
	}

	// Add meta box for custom fields
	function add_custom_jeep_meta_box() {
		add_meta_box(
			'custom_jeep_fields', // Unique ID
			'Jeep Fields', // Box title
			array( $this, 'render_custom_jeep_meta_box' ), // Callback function to render the meta box
			$this->jeep_cpt, // Custom post type
		);
	}
	// Render meta box content
	function render_custom_jeep_meta_box($post) {
		// Retrieve existing values from the database
		$jeep_model = get_post_meta($post->ID, 'jeep_model', true);
		$jeep_code = get_post_meta($post->ID, 'jeep_code', true);
		$jeep_year = get_post_meta($post->ID, 'jeep_year', true);
		?>
		<label for="jeep_code">Jeep Code:</label>
		<input type="text" id="jeep_code" name="jeep_code" value="<?php echo esc_attr($jeep_code); ?>" />

		<label for="jeep_desc">Jeep Model:</label>
		<input type="text" id="jeep_code" name="jeep_model" value="<?php echo esc_attr($jeep_model); ?>" />

		<label for="jeep_desc">Jeep Year:</label>
		<input type="month" id="jeep_year" name="jeep_year" value="<?php echo esc_attr($jeep_year); ?>" />
		<?php
	}

	function save_custom_jeep_meta($post_id) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		// Save custom fields
		if (isset($_POST['jeep_code'])) {
			update_post_meta($post_id, 'jeep_code', sanitize_text_field($_POST['jeep_code']));
		 }
		if (isset($_POST['jeep_year'])) { 
			update_post_meta($post_id, 'jeep_year', sanitize_text_field($_POST['jeep_year']));
		} 
		if (isset($_POST['jeep_model'])) { 
			update_post_meta($post_id, 'jeep_model', sanitize_text_field($_POST['jeep_model']));
		}
	}

	function register_contact_post_type(){
		register_post_type($this->contact_cpt,
			array(
				'labels'      => array(
					'name'          => __('Queries', 'textdomain'),
					'singular_name' => __('Queries', 'textdomain'),
				),
					'public'      => true,
					'has_archive' => false,
					'supports' => array('title')
			)
		);
	}

	// Add meta box for contact form  fields
	function add_custom_contact_meta_box() {
		add_meta_box(
			'custom_contact_fields', // Unique ID
			'Contact form submission', // Box title
			array( $this, 'render_contact_meta_box' ), // Callback function to render the meta box
			$this->contact_cpt, // Custom post type
		);
	}

	// Render meta box content
	function render_contact_meta_box($post) {
		// Retrieve existing values from the database
		$name = get_post_meta($post->ID, 'c_name', true);
		$email = get_post_meta($post->ID, 'c_email', true);
		$subject = get_post_meta($post->ID, 'c_subject', true);
		$message = get_post_meta($post->ID, 'c_message', true);
		?>
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" value="<?php echo esc_attr($name); ?>" />

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" value="<?php echo esc_attr($email); ?>" />

		<label for="subject">Subject:</label>
		<input type="text" id="subject" name="subject" value="<?php echo esc_attr($subject); ?>" />

		<label for="message">Message:</label>
		<textarea id="message" name="message"><?=  esc_attr($message); ?></textarea>
		<?php
	}

	//Register Duck CPT
	function register_duck_post_type(){
		register_post_type($this->duck_cpt,
			array(
				'labels'      => array(
					'name'          => __('Ducks', 'textdomain'),
					'singular_name' => __('Ducks', 'textdomain'),
				),
					'public'      => true,
					'has_archive' => false,
					'supports' => array('title', 'editor', 'thumbnail')
			)
		);
	}

	// add contact form
	function add_contact() {
		//var_dump($_POST['form_data']);
		$admin_email = get_option('admin_email');
	   parse_str($_POST['form_data'], $form_data); // Convert serialized string to array
	   $c_name = isset($form_data['c_name']) ? sanitize_text_field($form_data['c_name']) : '';
	   $c_email = isset($form_data['c_email']) ? sanitize_text_field($form_data['c_email']) : '';
	   $c_subject = isset($form_data['c_subject']) ? sanitize_text_field($form_data['c_subject']) : '';
	   $c_message = isset($form_data['c_message']) ? sanitize_text_field($form_data['c_message']) : '';

	   $user_id = get_current_user_id();
	   if ($user_id) {
		   $post_data = array(
			   'post_title'   => $c_name,
			   'post_status'  => 'publish', 
			   'post_type'    => $this->contact_cpt,
		   );
		   
		   $post_id = wp_insert_post($post_data);
		   if($post_id){
			   update_post_meta( $post_id, 'c_name', $c_name );
			   update_post_meta( $post_id, 'c_email', $c_email );
			   update_post_meta( $post_id, 'c_subject', $c_subject );
			   update_post_meta( $post_id, 'c_message', $c_message );
		   }
		   if (is_wp_error($post_id)) {
			   $response = 'Something went wrong, please try again!';
		   } else {
			   $response = 'Thanks for contacting us!';
			   wp_mail( $admin_email, $c_subject, $c_message);
		   }
	   }
	   echo json_encode($response);
	   wp_die(); 
   }


	function update_user_profile() {
        parse_str($_POST['form_data'], $form_data); // Convert serialized string to array
        $user_id = get_current_user_id();
        if ($user_id) {
            $user_data = array(
                'ID'         => $user_id,
                'user_email' => sanitize_email($form_data['user_email']),
                'first_name'  => sanitize_text_field($form_data['first_name']), 
				'last_name'  => sanitize_text_field($form_data['last_name']),
            );

			if (!empty($form_data['user_password'])) {
				$user_data['user_pass'] = sanitize_text_field($form_data['user_password']);
			}

			
            $updated = wp_update_user($user_data); // Update the user

            if (is_wp_error($updated)) {
                $response = false;
            } else {
                $response = 'User updated successfully!';
            }
        } else {
            $response = 'User not found.';
        }
        echo json_encode($response);
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

	function encryptData($data) {
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
		$encryption_iv = '1234567891011121';
		$encryption_key = "W3docs";
		return  openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
	}

	function decryptData($data) {
		$ciphering = "AES-128-CTR";
		$decryption_iv = '1234567891011121';
		$options = 0;
		$decryption_key = "W3docs";
		return openssl_decrypt($data, $ciphering, $decryption_key, $options, $decryption_iv);
	  }

}
new MainClass();