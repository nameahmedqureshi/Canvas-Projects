<?php
class SubscriptionManage
{

    function __construct() {
        $variable = array('manage_subcription', 'get_plans_by_usertype');
        foreach ($variable as $key => $value) {
            add_action('wp_ajax_' . $value, array($this, $value));
            add_action('wp_ajax_nopriv_' . $value, array($this, $value));
        }
    }



    function manage_subcription() {

        if (!is_user_logged_in()) {
            $response['icon'] = "error";
            $response['title'] = "Error";
            $response['status'] = false;
            $response['message'] = "You're session is expired, Login again!";
            return $this->response_json($response);
        }

        $required_fields = ['basic_plan_title', 'basic_annual_price', 'basic_monthly_price', 'advanced_plan_title', 'advanced_annual_price', 'advanced_monthly_price', 'premium_plan_title', 'premium_annual_price', 'premium_monthly_price'];
        foreach ($required_fields as $value) {
            if (empty($_POST[$value])) {
                $response['icon'] = "error";
                $response['title'] = "Error";
                $response['status'] = false;
                $response['message'] = "Please fill required fields";
                return $this->response_json($response);
    
            }
        }
       

        $basic_plan = [
            "plan_title" => $_POST['basic_plan_title'],
            "short_desc" => $_POST['basic_short_desc'],
            "annual_price" => $_POST['basic_annual_price'],
            "monthly_price" => $_POST['basic_monthly_price'],
        ];

        $advanced_plan = [
            "plan_title" => $_POST['advanced_plan_title'],
            "short_desc" => $_POST['advanced_short_desc'],
            "annual_price" => $_POST['advanced_annual_price'],
            "monthly_price" => $_POST['advanced_monthly_price'],
        ];

        $premium_plan = [
            "plan_title" => $_POST['premium_plan_title'],
            "short_desc" => $_POST['premium_short_desc'],
            "annual_price" => $_POST['premium_annual_price'],
            "monthly_price" => $_POST['premium_monthly_price'],
        ];


        if($_POST['usertype'] == 'supplier'){
      
            update_option('supplier_basic_plan', $basic_plan);
            update_option('supplier_advanced_plan', $advanced_plan);
            update_option('supplier_premium_plan', $premium_plan);
        }
        elseif($_POST['usertype'] == 'restaurant'){
           
            update_option('restaurant_basic_plan', $basic_plan);
            update_option('restaurant_advanced_plan', $advanced_plan);
            update_option('restaurant_premium_plan', $premium_plan);
        } 
        else {
         
            update_option('basic_plan', $basic_plan);
            update_option('advanced_plan', $advanced_plan);
            update_option('premium_plan', $premium_plan);
        }
       
       
        $response['icon'] = "success";
        $response['title'] = "Success";
        $response['status'] = true;
        $response['message'] = "Successfully Added!";
       // $response['auto_redirect'] = true;
       // $response['redirect_url'] = home_url('subscription-packages/');
       
        return $this->response_json($response);
    }

    function get_plans_by_usertype() {
        if($_POST['user_type'] == 'farmer'){
            $basic_plan = get_option('basic_plan', true);
            $advanced_plan = get_option('advanced_plan', true);
            $premium_plan = get_option('premium_plan', true);
        }
        elseif($_POST['user_type'] == 'supplier'){
            $basic_plan = get_option('supplier_basic_plan', true);
            $advanced_plan = get_option('supplier_advanced_plan', true);
            $premium_plan = get_option('supplier_premium_plan', true);
        }
        else {
            $basic_plan = get_option('restaurant_basic_plan', true);
            $advanced_plan = get_option('restaurant_advanced_plan', true);
            $premium_plan = get_option('restaurant_premium_plan', true);
        }

        $html = '';

        $plan_type = isset($_POST['plan_type']) ? filter_var($_POST['plan_type'], FILTER_VALIDATE_BOOLEAN) : false;

        // if($plan_type){
        //     var_dump($plan_type);
        //     var_dump('true');

        // } else {
        //     var_dump('false');

        // }
        // exit;

        if(!$plan_type){
        $html .= '<!-- monthly plans -->
        <div class="radio-group sub monthly_plans">
            <input  type="radio" id="standard" name="subcription_plan" value="standard" checked>
            <label class="radio selected"  for="standard">
                <div class="acount_type">
                    <div class="hd">
                    <h4>'.$basic_plan["plan_title"].'</h4>';
                    if($_POST['user_type'] == 'farmer'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Suppliers and Restaurants subscribed to Fifu Standard</span></div>
                    </div>';
                    } elseif($_POST['user_type'] == 'supplier'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Restaurants subscribed to Fifu Standard. Buy produce from Farmers subscribed to Fifu Standard</span></div>
                    </div>';
                    } else {
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Buy produce from Farmers and Suppliers subscribed to Fifu Standard</span></div>
                    </div>';
                    }
                    $html .='<p>'. $basic_plan["short_desc"] .'</p>
                    <p class="price">annum/monthly: £<span>'. $basic_plan["monthly_price"] .'</span></p>
                </div>
            </label>
            <input  type="radio" id="advanced" name="subcription_plan" value="advanced">
            <label class="radio"  for="advanced">
                <div class="acount_type">
                    <div class="hd">
                    <h4>'. $advanced_plan["plan_title"] .'</h4>';
                    if($_POST['user_type'] == 'farmer'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Suppliers and Restaurants subscribed to Fifu Standard and Fifu Advanced</span></div>
                    </div>';
                    } elseif($_POST['user_type'] == 'supplier'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Restaurants subscribed to Fifu Standard and Fifu Advanced. Buy produce from Farmers subscribed to Fifu Standard and Fifu Advanced</span></div>
                    </div>';
                    } else {
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Buy produce from Farmers and Suppliers subscribed to Fifu Standard and Fifu Advanced</span></div>
                    </div>';
                    }
                    $html .='<p>'. $advanced_plan["short_desc"] .'</p>
                    <p class="price">annum/monthly: £<span>'. $advanced_plan["monthly_price"]  .'</span></p>
                </div>
            </label>
            <input  type="radio" id="premium" name="subcription_plan" value="premium">
            <label class="radio"  for="premium">
                <div class="acount_type">
                    <div class="hd">
                    <h4>'. $premium_plan["plan_title"]  .'</h4>';
                    if($_POST['user_type'] == 'farmer'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Suppliers and Restaurants subscribed to Fifu Standard, Fifu Advanced and Fifu Premium</span></div>
                    </div>';
                    } elseif($_POST['user_type'] == 'supplier'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Restaurants subscribed to Fifu Standard, Fifu Advanced and Fifu Premium. Buy produce from Farmers subscribed to Fifu Standard, Fifu Advanced and Fifu Premium</span></div>
                    </div>';
                    } else {
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Buy produce from Farmers and Suppliers subscribed to Fifu Standard, Fifu Advanced and Fifu Premium</span></div>
                    </div>';
                    }
                    $html .='<p>'. $premium_plan["short_desc"] .'</p>
                    <p class="price">annum/monthly: £<span>'. $premium_plan["monthly_price"]  .'</span></p>
                </div>
            </label>
            <br>
        </div>';
        } else {
        

        $html .= '<!-- Yearly plan -->
        <div class="radio-group sub annually_plans">
            <input  type="radio" id="yearly_standard" name="subcription_plan" value="standard" checked>
            <label class="radio selected"  for="yearly_standard">
                <div class="acount_type">
                    <div class="hd">
                    <h4>'.$basic_plan["plan_title"].'</h4>';
                    if($_POST['user_type'] == 'farmer'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Suppliers and Restaurants subscribed to Fifu Standard</span></div>
                    </div>';
                    } elseif($_POST['user_type'] == 'supplier'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Restaurants subscribed to Fifu Standard. Buy produce from Farmers subscribed to Fifu Standard</span></div>
                    </div>';
                    } else {
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Buy produce from Farmers and Suppliers subscribed to Fifu Standard</span></div>
                    </div>';
                    }
                    $html .='<p>'. $basic_plan["short_desc"] .'</p>
                    <p class="price">annum/yearly: £<span>'. $basic_plan["annual_price"]   .'</span></p>
                </div>
            </label>
            <input  type="radio" id="yearly_advanced" name="subcription_plan" value="advanced">
            <label class="radio"  for="yearly_advanced">
                <div class="acount_type">
                    <div class="hd">
                    <h4>'. $advanced_plan["plan_title"] .'</h4>';
                    if($_POST['user_type'] == 'farmer'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Suppliers and Restaurants subscribed to Fifu Standard and Fifu Advanced</span></div>
                    </div>';
                    } elseif($_POST['user_type'] == 'supplier'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Restaurants subscribed to Fifu Standard and Fifu Advanced. Buy produce from Farmers subscribed to Fifu Standard and Fifu Advanced</span></div>
                    </div>';
                    } else {
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Buy produce from Farmers and Suppliers subscribed to Fifu Standard and Fifu Advanced</span></div>
                    </div>';
                    }
                    $html .='<p>'. $advanced_plan["short_desc"] .'</p>
                    <p class="price">annum/yearly: £<span>'. $advanced_plan["annual_price"]  .'</span></p>
                </div>
            </label>
            <input  type="radio" id="yearly_premium" name="subcription_plan" value="premium">
            <label class="radio"  for="yearly_premium">
                <div class="acount_type">
                    <div class="hd">
                    <h4>'. $premium_plan["plan_title"]  .'</h4>';
                    if($_POST['user_type'] == 'farmer'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Suppliers and Restaurants subscribed to Fifu Standard, Fifu Advanced and Fifu Premium</span></div>
                    </div>';
                    } elseif($_POST['user_type'] == 'supplier'){
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Sell your produce to Restaurants subscribed to Fifu Standard, Fifu Advanced and Fifu Premium. Buy produce from Farmers subscribed to Fifu Standard, Fifu Advanced and Fifu Premium</span></div>
                    </div>';
                    } else {
                    $html .='<div class="tooltip"><i class="fas fa-info-circle"></i><span class="tooltiptext">Buy produce from Farmers and Suppliers subscribed to Fifu Standard, Fifu Advanced and Fifu Premium</span></div>
                    </div>';
                    }
                    $html .='<p>'. $premium_plan["short_desc"] .'</p>
                    <p class="price">annum/yearly: £<span>'. $premium_plan["annual_price"]  .'</span></p>
                </div>
            </label>
            <br>
        </div>';
        }

        $response["icon"] = "success";
        $response["title"] = "Success";
        $response["status"] = true;
        $response["html"] = $html;
   
        return $this->response_json($response);
    }
    
    function response_json($response){
        echo json_encode($response);
        wp_die();
    }

}
new SubscriptionManage();