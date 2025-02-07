<?php
class MyClass {

    public $current_user;
    public $custom_post_type = 'jeeps';

    function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_files' ) );

        add_action('wp_ajax_get_category_data', array($this, 'get_category_data' ) );
        add_action('wp_ajax_nopriv_get_category_data', array($this, 'get_category_data' ) );

        add_shortcode( 'display_categories', array( $this, 'display_categories_in_sidebar' ) );
        add_shortcode( 'upload_gallery', array( $this, 'displayForm' ) );
        add_shortcode( 'display_gallery', array( $this, 'displayGallery' ) );
    }

    function enqueue_custom_files() {
        wp_enqueue_style('gallery-style', get_stylesheet_directory_uri() . '/gallery/css/styling.css');
        wp_enqueue_script('gallery-script', get_stylesheet_directory_uri() . '/gallery/js/custom-script.js');
		wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');
		wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
        wp_localize_script( 'gallery-script', 'ajax_script',
            array( 
                'ajax_url' => admin_url( 'admin-ajax.php' ),
            )
        );
    }
     
    function displayForm(){
        ob_start(); 
        // Check if the user is logged in
        if (is_user_logged_in()) {
                // Check if the current user has the "customer" role
            if (current_user_can('customer')) {
                // Use the do_shortcode function to echo the Gravity Forms shortcode
                echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]');
            }	
        }
        else{ ?> <span>Ready to showcase your own gallery? Get started by </span><a class="register-text" href="<?= site_url('/my-account') ?>"> registering now</a> <?php	}
    
        return ob_get_clean();
    }

    function displayGallery(){
        ob_start(); 
            // Include your custom template file
            include 'gallery-display.php';
        return ob_get_clean();
    }     
     
    function display_categories_in_sidebar() {
    ob_start(); 
    $custom_post_type = $this->custom_post_type;
    // Get taxonomies associated with the custom post type
    $categories = get_terms(array(
        'taxonomy'      => 'jeep-category', // Replace with the actual taxonomy name
        'hide_empty'    =>  1,
    ));
    ?>
    <div class="col-md-4">
        <a class="category-link active" href="#" cat-type="all">All</a>
    </div>
    
    <?php
    //var_dump($categories);
    foreach($categories as $category) { 
        //var_dump($category->name);
        ?>
    
        <div class="col-md-4">
            <a class="category-link" href="#" cat-type="<?= $category->term_id ?>"><?= $category->name ?></a>
        </div>

    <?php }
    
    return ob_get_clean();
    }
     
     // Hook to delete data when the toggle switch is turned off via AJAX

    // For non-logged-in users as well
     
    function get_category_data() {
        if (isset($_POST['cat_type'])) {
            //var_dump($_POST);
            $catType = $_POST['cat_type'];
            if($catType == 'all'){
                $args = array(
                    'post_type'         => 'jeeps',
                    'posts_per_page'    => -1, // Display all posts
                    'post_status'       => 'publish',
                    //'cat'               => $catType,
                );
            }
            else{
                $args = array(
                    'post_type'      => 'jeeps',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'jeep-category',
                            'field'    => 'id',
                            'terms'    => $catType,
                        ),
                    ),
                );
            }

            $query = new WP_Query($args);
    
            $html = '';
            $i=1;
            while($query->have_posts() ) {
                $query->the_post();
                $url = site_url('gallery-images?id='.get_the_ID());
                $class = ($i%3==0) ? 'col_last' : '';
                $html .= '<a href="'.$url.'" class="genCard col span_4 '.$class.'">
                            <div class="imgBox">
                                <img src="'. get_the_post_thumbnail_url(get_the_ID()) .'" alt="img">
                            </div>
                            <div class="textBox">
                                <p class="title">'.get_the_title(get_the_ID()).'</p>
                                <p class="desc">'.get_the_content(get_the_ID()).'</p>
                            </div>
                        </a>';
                        $i++;
            }
    
    
            $responce['status'] = true;
            $responce['html'] = $html;
            echo json_encode($responce);
            wp_die();
        }

        $responce['status'] = false;
        $responce['msg'] = "Field is required";
        echo json_encode($responce);
        wp_die();
    }
}
new MyClass();