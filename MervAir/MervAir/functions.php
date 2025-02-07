<?php add_theme_support('post-thumbnails'); ?>
<? add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) ); ?>
<?php include 'custom/main.php' ?>
<?php function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'footer-menu' => __( 'Footer Menu' ),
	  'social-media' => __( 'Social Media' ),
		 'top-links' => __( 'Top Links' )
    )
  );
}
add_action( 'init', 'register_my_menus' );
 ?>
<?
function enable_page_excerpt() {
  add_post_type_support('page', array('excerpt'));
}
add_action('init', 'enable_page_excerpt');
?>
<? 
// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => '.button',  
			'inline' => 'a',  
			'classes' => 'button',
			'wrapper' => true,
			
		), 
				array(  
			'title' => '.callout',  
			'block' => 'p',  
			'classes' => 'callout',
			'wrapper' => true,
			
		), 
		array(  
			'title' => '⇠.rtl',  
			'block' => 'blockquote',  
			'classes' => 'rtl',
			'wrapper' => true,
		),
		array(  
			'title' => '.ltr⇢',  
			'block' => 'blockquote',  
			'classes' => 'ltr',
			'wrapper' => true,
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = wp_json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );  
?>
<? // allow svg
function add_file_types_to_uploads($file_types){
$new_filetypes = array();
$new_filetypes['svg'] = 'image/svg+xml';
$file_types = array_merge($file_types, $new_filetypes );
return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');
?>
<?
add_action( 'init', 'create_post_types' );
function create_post_types() {

	register_post_type('slide', array(
	'label' => __('Slides'),
	'singular_label' => __('Slide'),
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'page',
	'hierarchical' => true,
	'has_archive' => true,
	'rewrite' => array( 'slug' => 'slide', 'with_front' => false ),
	'query_var' => true,
	'supports' => array('title', 'thumbnail', 'page-attributes', 'custom-fields', 'editor')
));

		register_post_type('event', array(
	'label' => __('Events'),
	'singular_label' => __('Event'),
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'page',
	'hierarchical' => true,
	'has_archive' => true,
	'rewrite' => array( 'slug' => 'events-list', 'with_front' => false ),
	'query_var' => true,
	'supports' => array('title', 'thumbnail', 'page-attributes', 'custom-fields', 'editor', 'excerpt')
));

}
?>
<?
$prefix = 'merv-';
$meta_boxes = array();

$meta_boxes[] = array(

    'id' => 'post-variables',
    'title' => 'Post Variables',
    'pages' => array('page', 'post', 'project'),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
			array(
            'name' => 'Subhead',
            'desc' => 'Subheading to appear where called in the template.',
            'id' => $prefix . 'subhead',
            'type' => 'text',
            'std' => ''
        	),
					array(
            'name' => 'Alternate Title',
            'desc' => 'Title to display other than the post/page name.',
            'id' => $prefix . 'alt-title',
            'type' => 'text',
            'std' => ''
        	),
							array(
            'name' => 'Landing Page Title',
            'desc' => 'Title to display in the hero on a landing page.',
            'id' => $prefix . 'landing-title',
            'type' => 'text',
            'std' => ''
        	),
									array(
            'name' => 'Landing Page Subtitle',
            'desc' => 'Title to display in the hero on a landing page under main title.',
            'id' => $prefix . 'landing-subtitle',
            'type' => 'text',
            'std' => ''
        	),
			array(
            'name' => 'Hero Video',
            'desc' => 'URL of video to play as hero graphic.',
            'id' => $prefix . 'hero-video',
            'type' => 'text',
            'std' => ''
        	),
			array(
            'name' => 'Title Background Image',
            'desc' => 'URL of image to use as title background.',
            'id' => $prefix . 'title-background-image',
            'type' => 'text',
            'std' => ''
        	),
			array(
            'name' => 'Title Background Color',
			'desc' => 'Select the color displayed under the main title.',
            'id' => $prefix . 'title-background-color',
            'type' => 'radio',
            'options' => array(
				array('name' => 'Blue', 'value' => 'blue'),
				array('name' => 'Red', 'value' => 'red'),
				array('name' => 'Green', 'value' => 'green'),
				array('name' => 'White', 'value' => 'white')
            )
        )


    ) // end fields

); // end instance


$meta_boxes[] = array(

    'id' => 'slide-variables',
    'title' => 'Slide Variables',
    'pages' => array('slide'),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
			array(
            'name' => 'Slide Content',
            'desc' => 'The content to appear if there is no post thumbnail.',
            'id' => $prefix . 'slide-content',
            'type' => 'wysiwyg',
            'std' => ''
        	),
			array(
            'name' => 'Slide Hero Background',
            'desc' => 'The text color to appear including the # if not white.',
            'id' => $prefix . 'slide-hero-background',
            'type' => 'text',
            'std' => ''
        	),
			array(
            'name' => 'Title Color',
            'desc' => 'Hex value of the title.',
            'id' => $prefix . 'slide-title-color',
            'type' => 'text',
            'std' => ''
        	),
			array(
            'name' => 'Text Color',
            'desc' => 'Hex value of the title.',
            'id' => $prefix . 'slide-text-color',
            'type' => 'text',
            'std' => ''
        	),
			array(
            'name' => 'Slide Image',
            'desc' => 'Paste the URL of the uploaded image, in the case of a two-column slide.',
            'id' => $prefix . 'slide-image',
            'type' => 'text',
            'std' => ''
        	),
			array(
            'name' => 'Slide Class',
            'desc' => 'Paste, separated by spaces, any classes to add to slide.',
            'id' => $prefix . 'slide-class',
            'type' => 'text',
            'std' => ''
        	),
			array(
            'name' => 'Slide Label',
            'desc' => 'The text to use for the link.',
            'id' => $prefix . 'slide-label',
            'type' => 'text',
            'std' => ''
        	)

    ) // end fields

); // end instance


foreach ($meta_boxes as $meta_box) {

    $my_box = new My_meta_box($meta_box);

}

class My_meta_box {

    protected $_meta_box;

    // create meta box based on given data

    function __construct($meta_box) {

        $this->_meta_box = $meta_box;
        add_action('admin_menu', array(&$this, 'add'));
        add_action('save_post', array(&$this, 'save'));
    }

    /// Add meta box for multiple post types

    function add() {

        foreach ($this->_meta_box['pages'] as $page) {

            add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);

        }
    }



    // Callback function to show fields in meta box

    function show() {

        global $post;



        // Use nonce for verification

        echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';



        echo '<table class="form-table">';


        foreach ($this->_meta_box['fields'] as $field) {
            // get current post meta data
            $meta = get_post_meta($post->ID, $field['id'], true);
            echo '<tr>',
                    '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                    '<td>';

            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
                        '<br />', $field['desc'];
                    break;

                case 'textarea':
                    echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
                        '<br />', $field['desc'];
                    break;
					
					case 'wysiwyg':
                    $content   = $meta ? $meta : $field['std'];
                    $editor_id = $field['id'];
                    wp_editor( $content, $editor_id );
                    echo "<br>"; echo $field['desc'];
                    break;

                case 'select':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                    }
                    echo '</select>';
                    break;

                case 'radio':
                    foreach ($field['options'] as $option) {
                        echo ' <input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                    }
                    break;

                case 'checkbox':
                    echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                    break;
            }

            echo     '<td>',
                '</tr>';
        }

        echo '</table>';
    }



    // Save data from meta box

    function save($post_id) {

        // verify nonce

        if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {

            return $post_id;

        }

        // check autosave

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // check permissions

        if ('page' == $_POST['post_type'] || 'attachment' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }

        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        foreach ($this->_meta_box['fields'] as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];

            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);

            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }

        }

    }

}

if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Extra Options',
        'menu_title' => 'Extra Options',
        'menu_slug' => 'extra-options',
        'capability' => 'edit_posts',
        'redirect' => false,
    ]);
}

//CronJob
function recurring_payment_cron_schedule( $schedules ) {
    $schedules['daily'] = array(
        'interval' => 86400, // Every 24 hour
        'display'  => __( 'Custom Daily' ),
    );
    return $schedules;
  }
  add_filter( 'cron_schedules', 'recurring_payment_cron_schedule' );
  
  //Schedule an action if it's not already scheduled
  if ( ! wp_next_scheduled( 'recurring_payment_cron_hook' ) ) {
    wp_schedule_event( time(), 'daily', 'recurring_payment_cron_hook' );
  }
  
  ///Hook into that action that'll fire every day
  add_action( 'recurring_payment_cron_hook', 'recurring_payment_cron_function' );
  
    function recurring_payment_cron_function(){
        $current_date = date('Y-m-d');

        $args = array(
            'post_type' => 'payment-detail',
            'posts_per_page' => -1,
            'meta_query'      => array(
            array(
                'key'     => 'next_payment',
                'value'   =>  $current_date,
                'compare' => '=',
            )
            ),
        );
        $payment_data = new WP_Query($args);

            foreach ($payment_data->posts ?? [] as $key => $value) {
            $order_id = get_post_meta($value->ID, 'order_id', true);    
            $next_payment = get_post_meta($value->ID, 'next_payment', true);    
            $user = get_post_meta($value->ID, 'user', true);    
            $end_plan_date = get_post_meta($order_id, 'end_plan', true);    
            $plan_price = get_post_meta( $order_id, 'plan_price', true );
            
            if (strtotime( $current_date ) == strtotime( $next_payment ) && strtotime($end_plan_date)  > strtotime( $current_date )) {
                $order_data = array(
                    'post_title'   => 'payment_'.$order_id,
                    'post_status'  => 'publish', 
                    'post_type'    => 'payment-detail',
                    'post_author'	   =>  $user,
                );
                $order_detail_id = wp_insert_post($order_data);
                add_post_meta( $order_detail_id, 'order_id', $order_id );
                add_post_meta( $order_detail_id, 'next_payment', date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-d') ) ) ) );
                add_post_meta( $order_detail_id, 'user', $user );
                add_post_meta( $order_detail_id, 'plan_price', $plan_price );

               // wp_mail('temp100@yopmail.com', 'Nonty', 'Partially payment deduct sucessfully!');

            }
    
        }
    }
  
  

?>