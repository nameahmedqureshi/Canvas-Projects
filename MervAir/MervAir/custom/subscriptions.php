<?php /* Template Name: Subscriptions  */  ?>
<?php  if(is_user_logged_in()){ get_header(); ?>
<?php

// echo get_current_user_ID();
if(current_user_can('administrator')){
    $args = array(
        'post_type' => 'filter-orders',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );
}
else {
    $args = array(
        'post_type' => 'filter-orders',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'author'	 =>  get_current_user_ID(),
    );
}

$data = new WP_Query($args);

?>
<section>
    <div class="container main-content">
        <div class="row" id="sub-detail">
            <h2>Orders</h2>
            <table id="myTable" class="display nowrap" style="width:100%">
                <thead>
                    <tr class="tab_head">
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Total Filters</th>
                        <th>Plan</th>
                        <th>Price</th>
                        <th>Address</th>
                        <th>Pay Date</th>
                        <th>End Subscription</th>
                        <th>Actions</th>
                        <!-- <?= (current_user_can('administrator')) ? '<th>Actions</th>' : '' ?> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; foreach ($data->posts ?? [] as $key => $value) {  ?>
                        <tr>
                            <td><?= $value->ID ?></td>
                            <td><?= get_post_meta($value->ID, 'c_name', true)  ?></td>
                            <td><?= get_post_meta($value->ID, 'tel', true)  ?></td>
                            <td><?=  get_post_meta($value->ID, 'filter_num', true); ?></td>
                            <td><?= get_post_meta($value->ID, 'filter_type', true)  ?></td>
                            <td>$<?=  get_post_meta($value->ID, 'plan_price', true) ?></td>
                            <td><?=  get_post_meta($value->ID, 'address', true); ?></td>
                            <td><?=  date("j F y", strtotime(get_post_meta($value->ID, 'start_date', true))); ?></td>
                            <td><?=  date("j F y", strtotime(get_post_meta($value->ID, 'end_plan', true))); ?></td>
                            <td><a href="<?= site_url('subscription-detail/?id='.$value->ID) ?>">Payment history</a></td>
                            <!-- <?= (current_user_can('administrator')) ? '<td><a href="'.site_url('subscription-detail/?id='.$value->ID).'">Payment history</a></td>' : '' ?> -->

                        </tr>
                    <?php $count ++; } ?>
                </tbody>
            </table>    
        </div>
    </div>
</section>            
<?php  get_footer(); } else { wp_redirect(home_url('/'));  } ?>
<!-- Initialize the DataTable -->
<script>
    jQuery(document).ready(function() {
    

        jQuery('#myTable').DataTable({
            "pagingType": "full_numbers",
            responsive: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            }
        });
    });
</script>
