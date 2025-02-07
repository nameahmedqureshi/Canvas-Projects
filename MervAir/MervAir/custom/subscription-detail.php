<?php /* Template Name: Subscription Detail  */  ?>

<?php if(is_user_logged_in()){
get_header(); ?>
<?php
$args = array(
    'post_type' => 'payment-detail',
    'posts_per_page' => -1,
    'meta_query'      => array(
    array(
        'key'     => 'order_id',
        'value'   =>  $_GET['id'],
        'compare' => '=',
    )
    ),
    'order' => 'ASC'
);


$data = new WP_Query($args);

?>
<section>
    <div class="container main-content">
        <div class="row" id="sub-detail">
            <h2>Payment History</h2>
            <div class="info">
                <p class="spend">Total Spend: $<span class="price"><?=  $price  ?></span></p>
                <p class="spend pp"  style="display:none">Next Payment: <span class="nxt_pay"><?=  $nxt_pay  ?></span></p>
            </div>
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr class="tab_head">
                        <th>ID</th>
                        <th>Pay Date</th>
                        <!-- <th>Next Payment</th> -->
                        <th>Amount</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $price = 0; 
                        $count = 1; 
                        $current_month = date('Y-m-d');
                        foreach ($data->posts ?? [] as $key => $value) { 
                        $price +=  get_post_meta($value->ID, 'plan_price', true); 
                        $order_id = get_post_meta($value->ID, 'order_id', true);    
                        $end_plan_date = get_post_meta($order_id, 'end_plan', true); 
                        $nxt_payment = date("j F y", strtotime(get_post_meta($value->ID, 'next_payment', true))); ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?=  date("j F y", strtotime(get_post_meta($_GET['id'], 'start_date', true))); ?></td>
                            <td>$<?=  get_post_meta($value->ID, 'plan_price', true) ?></td>

                        </tr>
                    <?php $count ++; } ?>
                </tbody>
            </table>
          
            <?php  
            
             if (date("Y-m", strtotime($end_plan_date)) <= date("Y-m", strtotime($current_month))) { 
                $nxp_pay_status = true; 
            } else {   
                $nxp_pay_status = false;  
            }
            
            ?>
            <p class="nxt_payment" style="display:none"><?= $nxt_payment  ?></p>
            <p class="total_price" style="display:none"><?=  $price  ?></p>
        </div>
    </div>
</section>    
<?php  get_footer(); } else { wp_redirect(home_url('/'));  } ?>
<!-- Initialize the DataTable -->
<script>
    jQuery(document).ready(function() {
        jQuery("#myTable").DataTable();
    });

    var pay_status = <?= json_encode($nxp_pay_status) ?>;
    console.log("pay_status", pay_status);
    var  total_price = jQuery('.total_price').text();
    jQuery('.price').text(total_price);
    var  nxt_payment = jQuery('.nxt_payment').text();
    if(!pay_status){

        jQuery('.nxt_pay').text(nxt_payment);
        jQuery('.pp').show();
    }
   
</script>
