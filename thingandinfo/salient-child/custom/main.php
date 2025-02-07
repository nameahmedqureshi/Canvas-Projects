<?php
class MainClass
{

	function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_files'));
		//add_action('template_redirect', array( $this,'custom_post_redirect') );

		$cpt = array('register_post_type', 'folder_post_type');
		foreach ($cpt as $k => $v) {
			add_action('init', array($this, $v));
		}
		$variable = array('get_link', 'create_folder', 'delete_link', 'delete_folder');
		foreach ($variable as $key => $value) {
			add_action('wp_ajax_' . $value, array($this, $value));
			add_action('wp_ajax_nopriv_' . $value, array($this, $value));
		}
	}

	function enqueue_custom_files()
	{
		wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/custom/assets/front/js/custom.js', array(), true);
		wp_enqueue_style('toastr-style', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
		wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');
		wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
		wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
		wp_enqueue_script('toastr-script', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array(), null, true);
		// Enqueue DataTables CSS
		wp_enqueue_style('datatables', 'https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css');
		wp_enqueue_script('jquery');

		$id = get_queried_object_id();
		$allowStripe = [112, 9];
		if (in_array($id, $allowStripe)) {
			wp_enqueue_script('stripe', 'https://js.stripe.com/v3/', array(), '3.0', true); //Stripe
		}

		// Enqueue DataTables JavaScript
		wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js', array('jquery'), true);
		$user_data =   array(
			'ajax_url' => admin_url('admin-ajax.php')
		);
		wp_localize_script('custom-script', 'ajax_script', $user_data);

		$test_credentials = get_field('test_credentials', 'option');
		$stripe_private_key = ($test_credentials == "Use Test Credentials") ? get_field('test_stripe_private_key', 'option') : get_field('live_stripe_private_key_copy', 'option');
		wp_localize_script('custom-script', 'stripe_private_key', ['key_url' => $stripe_private_key]);
	}

	// function custom_post_redirect() {

	// 	// Get the current post
	// 	$post = get_post(get_the_ID());
	// 	if ($post && $post->post_type === 'shareable-links') {
	// 		$redirect_url = get_post_meta($post->ID, 'downloadable_link', true);
	// 		if ($redirect_url) {
	// 			wp_redirect($redirect_url, 301); // 301 for permanent redirect
	// 			exit;
	// 		}
	// 	}

	// }

	function get_link()
	{
		if (!is_user_logged_in()) {
			$response = array(
				'status' => false,
				'icon' => 'error',
				'message' => "Try again, something's amiss!",
			);
			return $this->jsonResponse($response);
		}



		// Retrieve the token from the request
		$token = $_POST['stripeToken'];
		// var_dump($_POST);
		// exit;
		$user_id = get_current_user_id();
		$title =  isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
		$description =  isset($_POST['desciption']) ? sanitize_text_field($_POST['desciption']) : '';
		//$currency =  isset($_POST['currency']) ? sanitize_text_field($_POST['currency']) : 'usd';
		$folder =  isset($_POST['folders']) ? sanitize_text_field($_POST['folders']) : 137;
		$price =  isset($_POST['expiration_days']) ? sanitize_text_field($_POST['expiration_days']) : 1;



		if ($_FILES['upload_file']['error'] == 4 || ($_FILES['upload_file']['size'] == 0 && $_FILES['upload_file']['error'] == 0)) {

			$response = array(
				'status' => false,
				'icon' => "error",
				'message' => "Upload the file, it is required!",
			);
			return $this->jsonResponse($response);
		}

		if (empty($title)) {
			$response = array(
				'status' => false,
				'icon' => "error",
				'message' => "Enter the title, it is required!",
			);
			return $this->jsonResponse($response);
		}

		$test_credentials = get_field('test_credentials', 'option');
		$secret_key = ($test_credentials == "Use Test Credentials") ? get_field('test_stripe_secret_key', 'option') : get_field('live_stripe_secret_key_copy', 'option');
		// var_dump($test_credentials);
		// var_dump($secret_key);
		// exit;
		if ($secret_key == "") {
			$response = array(
				'status' => false,
				'icon' => "error",
				'message' => "Please Add Stripe key",
			);
			return $this->jsonResponse($response);
		}

		$stripe =  \Stripe\Stripe::setApiKey($secret_key);
		$charge_params = [
			'amount' => $price * 0.50 * 100, // Amount in cents
			'currency' => 'usd',
			'source' => $token,
			'description' => 'ThingsInfo Payment'
		];


		try {
			$generateUrl = $this->generateUrl($price);
			if (!$generateUrl) {
				$response = array(
					'status' => false,
					'icon' => "error",
					'message' => "Unkhown file type not supported. Please try again",
				);
				return $this->jsonResponse($response);
			}

			$charge = \Stripe\Charge::create($charge_params);
			$status = $charge->status;
			if ($status == "succeeded") {

				$data = array(
					'post_title'   => $title,
					'post_content' => $description,
					'post_status'  => 'publish',
					'post_type'    => 'shareable-links',
					'post_author'   => $user_id,
				);

				$post_id = wp_insert_post($data);
				if ($post_id) {
					update_post_meta($post_id, 'downloadable_link', $generateUrl["download_url"]);
					update_post_meta($post_id, 'post_link', get_permalink($post_id));
					update_post_meta($post_id, 'folder', $folder);
					update_post_meta($post_id, 'expiration_days', $price);
					$expire = date('Y-m-d', strtotime(get_the_date() . ' + ' . $price . ' days'));
					update_post_meta($post_id, 'expiration_date',  $expire);
					$downloadable_link = get_post_meta($post_id, 'post_link', false);
				}

				if (is_wp_error($post_id)) {
					$response['icon'] = "error";
					$response['title'] = "Error";
					$response['status'] = false;
					$response['message'] = "Try again, something's amiss!";
				} else {
					$response = array(
						'status' => true,
						'icon' => "success",
						'message' => "File upload successfully!",
						'url' => isset($downloadable_link) ? $downloadable_link : $generateUrl["download_url"],
					);
				}
			}
		} catch (Exception $e) {
			$response = array(
				'status' => false,
				'icon' => "error",
				'message' => $e->getMessage(),
			);
			return $this->jsonResponse($response);
		}

		return $this->jsonResponse($response);
	}

	function generateUrl($price)
	{

		$file_path = $this->uploadImage($_FILES['upload_file']);
		if ($file_path["success"] == true) {
			$upload_info = wp_get_upload_dir();
			$file  = $upload_info['path'] . '/' . $_FILES['upload_file']['name'];


			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://hussain9.pythonanywhere.com/upload',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => array('file' => new CURLFILE($file_path["url"]), 'expiration_days' => $price),
			));



			$resp = curl_exec($curl);
			$resp = json_decode($resp, true);
			curl_close($curl);
			wp_delete_file($file);
			return $resp;
		} else {
			return false;
		}
	}

	function create_folder()
	{
		if (!is_user_logged_in()) {
			$response = array(
				'status' => false,
				'icon' => 'error',
				'message' => "Try again, something's amiss!",
			);
			return $this->jsonResponse($response);
		}

		$user_id = get_current_user_id();
		$title =  isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
		$existing_post_id =  isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';

		// var_dump($existing_post_id);
		// exit;

		if (empty($title)) {
			$response = array(
				'status' => false,
				'icon' => "error",
				'message' => "Enter the title, it is required!",
			);
			return $this->jsonResponse($response);
		}

		$data = array(
			'post_title'   => $title,
			'post_status'  => 'publish',
			'post_type'    => 'folders',
			'post_author'   => $user_id,
		);

		if ($existing_post_id) {
			$data['ID'] = $existing_post_id;
			$post_id = wp_update_post($data);
			$response['message'] = "Folder name updated successfully!";
		} else {
			$post_id = wp_insert_post($data);
			$response['message'] = "Folder created successfully!";
		}

		if (is_wp_error($post_id)) {
			$response = array(
				'status' => "error",
				'message' => "Try again, something's amiss!",
			);
		} else {
			$response = array(
				'status' => true,
				'icon' => "success",
				'message' => $response['message'],
				'redirect' => site_url('upload'),
			);
		}

		return $this->jsonResponse($response);
	}

	function delete_link()
	{
		if (!is_user_logged_in()) {
			$response = array(
				'status' => false,
				'icon' => 'error',
				'message' => "Try again, something's amiss!",
			);
			return $this->jsonResponse($response);
		}
		global $wpdb;
		$user_id = get_current_user_id();
		$post_id =  isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';

		if ($post_id) {
			$deleted = wp_delete_post($post_id);
		}

		if (is_wp_error($deleted)) {
			$response = array(
				'status' => "error",
				'message' => "Try again, something's amiss!",
			);
		} else {
			$response = array(
				'status' => true,
				'icon' => "success",
				'message' => "Link deleted!",
				'redirect' => site_url('upload'),
			);
		}

		return $this->jsonResponse($response);
	}

	function delete_folder()
	{
		if (!is_user_logged_in()) {
			$response = array(
				'status' => false,
				'icon' => 'error',
				'message' => "Try again, something's amiss!",
			);
			return $this->jsonResponse($response);
		}
		global $wpdb;
		$user_id = get_current_user_id();
		$post_id =  isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : '';
		$post_type = 'shareable-links';
		$meta_key = 'folder';

		if ($post_id) {
			$deleted = wp_delete_post($post_id);
			$wpdb->query(
				$wpdb->prepare(
					"DELETE p, pm FROM {$wpdb->prefix}posts p
					LEFT JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
					WHERE p.post_type = %s
					AND pm.meta_key = %s
					AND pm.meta_value = %d",
					$post_type,
					$meta_key,
					$post_id
				)
			);
			$wpdb->query($sql);
		}

		if (is_wp_error($deleted)) {
			$response = array(
				'status' => "error",
				'message' => "Try again, something's amiss!",
			);
		} else {
			$response = array(
				'status' => true,
				'icon' => "success",
				'message' => "Folder deleted!",
				//	'redirect' => site_url('upload'),
			);
		}

		return $this->jsonResponse($response);
	}

	function register_post_type()
	{
		register_post_type(
			'shareable-links',
			$labels = array(
				'labels'      => array(
					'name'          => __('Shareable Links', 'textdomain'),
					'singular_name' => __('Shareable Links', 'textdomain'),
				),
				'public'      => true,
				'has_archive' => true,
				'show_ui' => false,
				'supports' => array('title', 'editor')
			)
		);
	}

	function folder_post_type()
	{
		register_post_type(
			'folders',
			$labels = array(
				'labels'      => array(
					'name'          => __('Folders', 'textdomain'),
					'singular_name' => __('Folders', 'textdomain'),
				),
				'public'      => true,
				'has_archive' => true,
				'show_ui' => false,
				'supports' => array('title', 'editor')
			)
		);
	}

	function uploadImage($file)
	{
		// fetch uploaded image
		$image = $file['tmp_name'];
		$filename = $file['name'];

		$upload_file = wp_upload_bits($filename, null, file_get_contents($image));

		// var_dump($upload_file);
		// exit;

		if (!$upload_file['error']) {
			return array(
				'success' => true,
				'url' => $upload_file['url'],
			);
			//}
		} else {
			//send upload error 
			return array(
				'success' => false,
				'msg' => $upload_file['error']
			);
		}
	}

	function jsonResponse($response)
	{
		echo json_encode($response);
		wp_die();
	}
}
new MainClass();
