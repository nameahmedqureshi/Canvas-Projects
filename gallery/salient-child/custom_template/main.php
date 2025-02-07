<?php class Gallery{
    function __construct(){
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_files' ) );

		$cpt = array('register_post_type');
			foreach ($cpt as $k => $v) {
				add_action('init',array($this,$v));
			}
		$variable = array('get_artist_by_letter', 'get_selected_artist', 'get_artists_by_country');
			foreach ($variable as $key => $value) {
			add_action('wp_ajax_'.$value,array($this,$value));
			add_action('wp_ajax_nopriv_'.$value,array($this,$value));
			}
    }

    function enqueue_custom_files() {

        wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');
        wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);

        wp_enqueue_script('jquery');
        wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/custom_template/assets/js/custom.js', array(), true);

        $user_data =   array( 
            'ajax_url' => admin_url( 'admin-ajax.php' )
        );
        wp_localize_script('custom-script', 'ajax_script', $user_data);
    }
	
	function get_artist_by_letter() {

		// var_dump($url);
		// exit;
		global $wpdb;
	
		$alphabet = isset($_POST['letter']) ? $_POST['letter'] : 'All';
		$url = isset($_POST['url']) ? $_POST['url'] : '';

		// var_dump($alphabet);
		// exit;
		//$paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
		//set_query_var('paged', $paged);
		
		if($alphabet == "All"){
			$postids = $wpdb->get_col($wpdb->prepare("
			SELECT ID
			FROM $wpdb->posts
			ORDER BY $wpdb->posts.post_title"));
		} else {
			$postids = $wpdb->get_col($wpdb->prepare("
			SELECT ID
			FROM $wpdb->posts
			WHERE SUBSTR($wpdb->posts.post_title, 1, 1) = %s
			ORDER BY $wpdb->posts.post_title", $alphabet));
		}
		
		// var_dump($alphabet);
		// var_dump($url);
		
		//$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	
		if($alphabet == "All"){
			$args = array(
				'post_type' => 'artists',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'orderby' => 'title',
				'order' => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'countries', // Replace with your actual taxonomy name
						'field'    => 'slug',
						'terms'    => 'marine-arts', // Replace with the slug of the "Marine Art" category
					),
				),
				
			);
		} else{
			$args = array(
				'post__in' => $postids,
				'post_type' => 'artists',
				'post_status' => 'publish',
				//'paged' => $paged,
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'countries', // Replace with your actual taxonomy name
						'field'    => 'slug',
						'terms'    => 'marine-arts', // Replace with the slug of the "Marine Art" category
					),
				),
			);	
		}
		
		$query = new WP_Query($args);
	
		$html = '';
		//	$paginationhtml = '';
	
		if ($query->have_posts()) {
			while ($query->have_posts()) { 
				$query->the_post();
				$html .= '<input type="radio" id="'.get_the_ID().'" class="artists" name="artist" value="'. get_the_ID() .'">
				<label for="'.get_the_ID().'">' .get_the_title(get_the_ID()) .'</label><br>';
			}
	
			// $paginationhtml .= 
			// 	paginate_links(array(
			// 		'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(1))),
			// 		'format' => '?paged=%#%',
			// 		'current' => max(1, get_query_var('paged')),
			// 		'total' => $query->max_num_pages,
			// 		'prev_text' => __('« Previous'),
			// 		'next_text' => __('Next »'),
			// 	));
		} else {
			$html = '<p>No artists found</p>';
		}
	
		wp_reset_postdata();
	
		$response['status'] = true;
		$response['html'] = $html;
		//$response['pagination'] = $paginationhtml;
	
		echo json_encode($response);
		wp_die();
	}


	function get_selected_artist() {
		//global $wpdb;
	
		$artist = isset($_POST['artist']) ? $_POST['artist'] : [];
		$artistDesc = get_the_excerpt($artist);
		$artistTitle = get_the_title($artist);
		$args = array(
			'post__in' => array($artist),
			'post_type' => 'artists',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		);
		if($_POST['slug']){
			$args['tax_query'] = [
				'taxonomy' => 'countries', // Replace with your actual taxonomy name
				'field'    => 'slug',
				'terms'    => 'marine-arts', // Replace with the slug of the "Marine Art" category
			];
		}
		$query = new WP_Query($args);
		
		$html = '';
		//	$paginationhtml = '';
	
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$gallery = get_field('gallery', get_the_ID() );
				if ($gallery) { foreach ($gallery as $value) {
					$html .= '<a href="'. $value['image'] .'" class="image-link"><div class="item" style="background-image: url('.$value['image'].');">
							<div class="item-desc">
							<h3>'.$value['name'].'</h3>
							</div>
						</div></a>';
				} }
			}
			$artistHtml = "<h2 class='artist_title'>$artistTitle</h2><p class='artist_desc'>$artistDesc</p>";
			
		} else {
			$html = '<p>No data found</p>';
		}
	
		wp_reset_postdata();
	
		$response['status'] = true;
		$response['html'] = $html;
		$response['artistHtml'] = $artistHtml;
		//$response['pagination'] = $paginationhtml;
	
		echo json_encode($response);
		wp_die();
	}

	function get_artists_by_country(){
		$artist = isset($_POST['artist']) ? $_POST['artist'] : '';
		
		$args = array(
			'post_type' => 'artists',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'countries',
					'field' => 'term_id',
					'terms' => $artist,
				),
			),
		);

		$query = new WP_Query($args);
		//var_dump($query);
		$html = '';
		//	$paginationhtml = '';
	
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$html .= '<input type="radio" id="'.get_the_ID().'" class="artists" name="artist" value="'. get_the_ID() .'">
				<label for="'.get_the_ID().'">' .get_the_title(get_the_ID()) .'</label><br>';
			}
	
		} else {
			$html = '<p>No artist found</p>';
		}
	
		wp_reset_postdata();
	
		$response['status'] = true;
		$response['html'] = $html;
		//$response['pagination'] = $paginationhtml;
	
		echo json_encode($response);
		wp_die();
	}

	
	

    function register_post_type(){
		register_post_type('artists',
		$labels = array(
				'labels'      => array(
					'name'          => __('Artists', 'textdomain'),
					'singular_name' => __('Artists', 'textdomain'),
				),
					'public'      => true,
					'has_archive' => true,
					'supports' => array('title', 'editor', 'thumbnail')
			)
		);
		// Register Custom Taxonomy
		$taxonomy_labels = array(
			'name'              => _x('Countries', 'taxonomy general name', 'textdomain'),
			'singular_name'     => _x('Countries', 'taxonomy singular name', 'textdomain'),
			'search_items'      => __('Search Countries', 'textdomain'),
			'all_items'         => __('All Countries', 'textdomain'),
			'parent_item'       => __('Parent Countries', 'textdomain'),
			'parent_item_colon' => __('Parent Countries:', 'textdomain'),
			'edit_item'         => __('Edit Countries', 'textdomain'),
			'update_item'       => __('Update Countries', 'textdomain'),
			'add_new_item'      => __('Add New Countries', 'textdomain'),
			'new_item_name'     => __('New Countries Name', 'textdomain'),
			'menu_name'         => __('Countries', 'textdomain'),
		);

		$taxonomy_args = array(
			'hierarchical'      => true,
			'labels'            => $taxonomy_labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'countries'),
		);

		register_taxonomy('countries', array('artists'), $taxonomy_args);
	}
}
new Gallery();