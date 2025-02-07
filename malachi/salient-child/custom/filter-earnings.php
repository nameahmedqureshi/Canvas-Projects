<?php 
class FilterEarning {
    function __construct() {
        $variable = array('filer_earning');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }

        $cpt = array('register_total_sales_post_type');
        foreach ($cpt as $k => $v) {
            add_action('init',array($this,$v));
        }
    }

    function filer_earning() {
        if(!is_user_logged_in()){
		
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired!";
			return $this->response_json($response);
		}

        $selected_year = date($_POST['filter_year']);
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $monthly_totals = array_fill_keys($months, ['total_sale' => 0, 'total_commission' => 0]);


        $arg = [
            'post_type' => 'total_sales',
            'posts_per_page' => -1,
            'date_query'     => [
                [
                    'year' => $selected_year,
                ],
            ],
            'meta_query'     => [
                [
                    'key'      => 'type',
                    'value'      => $_POST['filter_type'],
                    'compare'  => '=',
                ]
            ],
        ];
        $query = new WP_Query($arg);

        // Loop through posts and sum totals by month
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                // Get month as full name (e.g., "January")
                $post_month = date('F', strtotime(get_the_date('Y-m-d')));

                // Fetch meta values
                $total_price = (float) get_post_meta(get_the_ID(), 'total_price', true);
                $commission_amount = (float) get_post_meta(get_the_ID(), 'commission_amount', true);

                // Aggregate totals by month
                $monthly_totals[$post_month]['total_sale'] += $total_price;
                $monthly_totals[$post_month]['total_commission'] += $commission_amount;
            }
            wp_reset_postdata();
        }

        $html = '';
        foreach ($months as $month) { 
            $html .= '<tr>
                <td>'. $month .'</td>
                <td>$'. number_format($monthly_totals[$month]['total_commission'], 2) .'</td>
                <td>$'. number_format($monthly_totals[$month]['total_sale'], 2) .'</td>
            </tr>';
        }

        $response['icon'] = "success";
        $response['title'] = "Success";
        $response['html'] = $html;
        $response['status'] = true;
    
        return $this->response_json($response);
    }

    public static function total_sales($type, $commission_amount, $total_price, $customer_id, $vendor_id, $reference_order_id = '') {       

        $sales_data = array(
            'post_title'   => '#'.rand(10,10000),
            'post_status'  => 'publish', 
            'post_type'    => 'total_sales',
        );

        $new_post_id = wp_insert_post($sales_data);

        if ($new_post_id) {
            update_post_meta($new_post_id,'type',$type);
            update_post_meta($new_post_id,'commission_amount',$commission_amount);
            update_post_meta($new_post_id,'total_price', $total_price);
            update_post_meta($new_post_id, 'order_date', date('d-m-Y'));
            update_post_meta($new_post_id, 'customer_id', $customer_id);
            update_post_meta($new_post_id, 'vendor_id', $vendor_id);
            update_post_meta($new_post_id, 'reference_order_id', $reference_order_id);
        }

        return $new_post_id;
    }

    function register_total_sales_post_type() {
        register_post_type('total_sales',
            array(
                'labels'      => array(
                    'name'          => __('Sales', 'textdomain'),
                    'singular_name' => __('Sales', 'textdomain'),
                ),
                    'public'      => true,
                    'has_archive' => true,
                    'supports' => array('title'),
            )
        );
    }
    
    function response_json($response) {
        echo json_encode($response);
        wp_die();
    }

}
$TotalEarningClass = new FilterEarning();