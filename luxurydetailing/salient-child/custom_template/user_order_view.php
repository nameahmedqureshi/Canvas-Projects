<?php 
function user_order_view(){
$post_id = $_GET["id"];
$post_data = get_post($post_id);
$meta_data = get_post_meta($post_id);
?>
<style>
        th.text-start {
        background: transparent;
        color: #000;
    }
    table#example {
        margin-top: 40px;
    }
</style>
<section>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive mb-3">
                <h4 class="card-title">Vehicle Information</h4>
                <table class="table table-bordered text-nowrap text-center">
                    <thead>
                        <tr>
                            <th scope="col">Order</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="text-start">Vehicle License Plate</th>
                            <td> <?= get_the_title($post_id) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Make</th>
                            <td><?= get_post_meta($post_id, 'make', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Model</th>
                            <td><?= get_post_meta($post_id, 'model', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Year</th>
                            <td><?= get_post_meta($post_id, 'year', true) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive mb-3">
                <h4 class="card-title">Service Information</h4>
                <table class="table table-bordered text-nowrap text-center">
                    <thead>
                        <tr>
                            <th scope="col">Order</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="text-start">Type</th>
                            <td><?= get_post_meta($post_id, 'type', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Garage Location</th>
                            <td><?= get_post_meta($post_id, 'garage_location', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Date</th>
                            <td><?= get_post_meta($post_id, 'date', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Client Requests</th>
                            <td><?= apply_filters('the_content', get_post_field('post_content', $post_id)) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?php 
            $order_summary = get_post_meta($post_id, 'order_summary', true);
            if( !empty($order_summary) ){ ?>

                <div class="table-responsive mb-3">
                    <h4 class="card-title">Services</h4>
                    <table class="table table-bordered text-nowrap text-center">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($order_summary as $val) { 
                                // var_dump($val); 
                                ?>
                            
                            <tr>
                                <th scope="row" class="text-start"><?= $val["title"] ?></th>
                                <td>$<?= $val["price"] ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th scope="row" class="text-start">Tip</th>
                                <td>$<?= !empty(get_post_meta($post_id, 'tip_price',true)) ? get_post_meta($post_id, 'tip_price',true) : '0' ?></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Total</th>
                                <td>$<?= get_post_meta($post_id, 'total_price', true) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>

            <div class="table-responsive mb-3">
                <h4 class="card-title">User Information</h4>
                <table class="table table-bordered text-nowrap text-center">
                    <thead>
                        <tr>
                            <th scope="col">Order</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="text-start">First Name</th>
                            <td><?= get_post_meta($post_id, 'first_name', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Last Name</th>
                            <td><?= get_post_meta($post_id, 'last_name', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">User Email</th>
                            <td><?= get_post_meta($post_id, 'user_email', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Phone Number</th>
                            <td><?= get_post_meta($post_id, 'number', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Type</th>
                            <td><?= get_post_meta($post_id, 'usertype', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Panther ID Number</th>
                            <td><?= get_post_meta($post_id, 'panther_id', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Classification</th>
                            <td><?= get_post_meta($post_id, 'classification', true) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>   
    </div>
</section>      
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <?php 
}
add_shortcode('user_order_view', 'user_order_view');
?>