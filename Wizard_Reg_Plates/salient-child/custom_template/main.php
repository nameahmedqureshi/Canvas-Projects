<?php
class MainClass {

    function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_files' ) );

        $variable = array('order_plates');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_'.$value,array($this,$value));
            add_action('wp_ajax_nopriv_'.$value,array($this,$value));
        }

        $cpt = array('register_plates');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
        add_action('manage_plate-orders_posts_custom_column', array($this, 'custom_column_content'), 10, 2);
        add_filter('manage_edit-plate-orders_columns', array($this, 'custom_columns_register'));
        add_filter('manage_edit-plate-orders_sortable_columns', array($this, 'sortable_columns'));
    }

    function enqueue_custom_files() {
        wp_enqueue_script('jquery');
        wp_enqueue_style('toastr-style', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
        wp_enqueue_style('waitme-style', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css');       

        wp_enqueue_script('waitme-script', 'https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js', array(), null, true);
        wp_enqueue_script('toastr-script','https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array(), null, true);	
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
        $id = get_queried_object_id();
        $allowStripe = [283];
		if (in_array($id, $allowStripe)) {
			wp_enqueue_script('stripe', 'https://js.stripe.com/v3/', array(), '3.0', true); //Stripe
		}
    }
    

    public function order_plates(){

        $test_credentials = get_field( 'test_credentials' , 'option');
        $secret_key = ($test_credentials == "Use Test Credentials") ? get_field( 'test_stripe_secret_key' , 'option') : get_field( 'live_stripe_secret_key_copy' , 'option');
        if ($secret_key == "") {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please Add Stripe key";
            return $this->response_json($response); 
        }

        // var_dump($_POST);
        // exit;
        $styles = get_field('letter_style', 'option');  
        $front_plate = get_field('front_plate', 'option');  
        $rear_plate = get_field('rear_plate', 'option');  
        $flag_border_price = get_field('flag_border_price', 'option');  
        $flags = get_field('flag', 'option');  
        $extra_items = get_field('extras', 'option');  

     
        // Validate required fields
        $required_fields = ['registration', 'customer_name', 'customer_email', 'customer_tel', 'customer_country', 'customer_address', 'customer_city', 'customer_zip'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {            
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Please fill required fields";
            return $this->response_json($response); 
            }
        }

        // Retrieve the token from the request
        $token = $_POST['stripeToken'];
        $customer_name = sanitize_text_field($_POST['customer_name']);
		$customer_email = sanitize_text_field($_POST['customer_email']);
		$customer_tel = sanitize_text_field($_POST['customer_tel']);
		$customer_country = sanitize_text_field($_POST['customer_country']);
		$customer_address = sanitize_text_field($_POST['customer_address']);
		$customer_city = sanitize_text_field($_POST['customer_city']);
		$customer_zip = sanitize_text_field($_POST['customer_zip']);

        // Price Calculations
        $letter_price = 0;
        // Find letter price from styles based on selected style
        if(isset($_POST['style']) && !empty($_POST['style'])){

            foreach ($styles as $key => $value) {
                if($value['letter_name'] == $_POST['style']){
                    $letter_price = $value['letter_price'];
                    break;
                }
            }
        }

       // Apply discount for skipping front or rear lettering
        if (isset($_POST['front_dont_need']) && $_POST['front_dont_need'] == 'yes' || isset($_POST['rear_dont_need']) && $_POST['rear_dont_need'] == 'yes') {
            $letter_price /= 2;
        }

        // Add front plate price based on selected style
        if(isset($_POST['front_style']) && !empty($_POST['front_style'])){

            foreach ($front_plate as $key => $value) {
                if($value['front_style'] == $_POST['front_style']){
                    $letter_price += $value['front_price'];
                    break;
                }
            }
        }

        // Add rear plate price based on selected style
        if(isset($_POST['rear_style']) && !empty($_POST['rear_style'])){

            foreach ($rear_plate as $key => $value) {
                if($value['rear_style'] == $_POST['rear_style']){
                    $letter_price += $value['rear_price'];
                    break;
                }
            }
        }

        // Add flag price based on selected style
        if(isset($_POST['flag_style']) && !empty($_POST['flag_style'])){
            foreach ($flags as $key => $value) {
                if($value['flag_name'] == $_POST['flag_style']){
                    $letter_price += $value['flag_price'];
                    break;
                }
            }
        }
        $letter_price += isset($_POST['black_border']) && $_POST['black_border'] == 'yes' ? $flag_border_price : '0';

       // Add extra items price based on selected style
       if(isset($_POST['extra_item']) && !empty($_POST['extra_item'])){
            foreach ($extra_items as $key => $value) {

                if(in_array($value['product_name'], $_POST['extra_item'])){
                    $letter_price += $value['product_price'];
                
                }
            }
       }
      
        $letter_price = round($letter_price);

        // Set your Stripe secret key
        \Stripe\Stripe::setApiKey($secret_key);

        $charge_params = [
            'amount' => $letter_price * 100, // Amount in cents
            'currency' => 'usd',
            'source' => $token,
            'description' => 'Plate payment'
        ];
        try 
        {
            $charge = \Stripe\Charge::create($charge_params);
            $pay_status = ['status'=> true];
        }
        catch(Exception $e) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return $this->response_json($response);
        }

        if($pay_status){
            $post_data = array(
                'post_title'   => $charge['id'],
                'post_status'  => 'publish', 
                'post_type'    => 'plate-orders',
            );   
            $plate_post_id = wp_insert_post( $post_data );


           

            if($plate_post_id){
                $vatPercentage = get_field('set_vat_percentage','options');
                $vat_percentage = ($vatPercentage * $letter_price) / 100;
                $order_price =  $letter_price - $vat_percentage;
                
                $front_plate = isset($_POST['front_dont_need']) && $_POST['front_dont_need'] == 'yes' ? 'None' : $_POST['front_style'];
                $rear_plate = isset($_POST['rear_dont_need']) && $_POST['rear_dont_need'] == 'yes' ? 'None' : $_POST['rear_style'];
                $flag = isset($_POST['dont_need_flag']) && $_POST['dont_need_flag'] == 'yes' ? 'None' : $_POST['flag_style'];
                $flag_border = isset($_POST['black_border']) && $_POST['black_border'] == 'yes' ? 'Yes' : 'None';
                $extra_items = isset($_POST['extra_item']) ? implode(',',$_POST['extra_item']) : 'None';
               
                update_post_meta( $plate_post_id, 'customer_name', $customer_name );
                update_post_meta( $plate_post_id, 'customer_email', $customer_email );
                update_post_meta( $plate_post_id, 'customer_tel', $customer_tel );
                update_post_meta( $plate_post_id, 'customer_country', $customer_country );
                update_post_meta( $plate_post_id, 'customer_zip', $customer_zip );
                update_post_meta( $plate_post_id, 'customer_city', $customer_city );
                update_post_meta( $plate_post_id, 'customer_address', $customer_address );
                update_post_meta( $plate_post_id, 'registration_num', $_POST['registration'] );
                update_post_meta( $plate_post_id, 'style', $_POST['style'] );
                update_post_meta( $plate_post_id, 'front_plate', $front_plate );
                update_post_meta( $plate_post_id, 'rear_plate', $rear_plate );
                update_post_meta( $plate_post_id, 'black_border', $flag_border );
                update_post_meta( $plate_post_id, 'flag_style', $flag );
                update_post_meta( $plate_post_id, 'extra_items', $extra_items );
                update_post_meta( $plate_post_id, 'order_price', number_format($order_price, 2) );
                update_post_meta( $plate_post_id, 'vat_percentage', number_format($vat_percentage, 2) );
                update_post_meta( $plate_post_id, 'total_price', number_format($letter_price, 2) );
                update_post_meta( $plate_post_id, 'charge_id', $charge['id'] );
                update_post_meta( $plate_post_id, 'payment_status', $charge['status'] );
                update_post_meta( $plate_post_id, 'order_status', 'Processing' );
            }
        }

        if (is_wp_error($plate_post_id)) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "Try again, something's amiss!";
		} else {
            $response['icon'] = "success";
            $response['title'] = "Success";
            $response['message'] = "Thanks for buying!";
            $response['auto_redirect'] = true;
            $response['status'] = true;
            $response['redirect_url'] = site_url('build-your-plates');
		}

		return $this->response_json($response);
       
    }

    public function custom_column_content($column, $post_id) {
        switch ($column) {
            case 'customer_name':
                // Retrieve and output customer_name
                echo get_post_meta($post_id, 'customer_name', true);
                break;
            case 'order_status':
                // Retrieve and output order_status
                echo get_post_meta($post_id, 'order_status', true);
                break;
            case 'total_price':
                // Retrieve and output total_price
                echo get_post_meta($post_id, 'total_price', true);
                break;
        }
    }

    public function custom_columns_register($columns) {
        // Add custom columns
        $columns['customer_name'] = 'Customer';
        $columns['order_status'] = 'Status';
        $columns['total_price'] = 'Total';
        // Move date column to the end
        unset($columns['date']);
        $columns['date'] = 'Date';
        return $columns;
    }
    
    public function sortable_columns($columns) {
        // Make date column sortable
        $columns['date'] = 'date';
        return $columns;
    }

    public function register_plates(){
        register_post_type('plate-orders',
        array(
            'labels'      => array(
                'name'          => __('Plate Orders', 'textdomain'),
                'singular_name' => __('Plate Orders', 'textdomain'),
            ),
                'public'      => true,
                'has_archive' => false,
                'supports' => array('title'),
                
        )
        );
    }

    public function response_json($response){
        echo json_encode($response);
        wp_die();
    }
}
new MainClass();