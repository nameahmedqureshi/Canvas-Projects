<?php 
function history(){

    if(!is_user_logged_in() ) {
        wp_redirect(home_url('/'));
        echo '<script>window.location.href = "'.home_url('/').'"</script>';
        exit;
    }

    $args = array(
        'post_type' => 'orders',
        'post_status' => 'any',
        'post_per_page' => -1,  
        'author' => get_current_user_id()
    );
    $orders = new WP_Query($args);

?>
<style>
        a.item-edit {
        color: #000;
        text-decoration: underline;
        font-size: 16px;
        text-align: center;
    }
        .container.main-content {
        max-width: 95%;
    }
    table#example {
        margin-top: 40px;
    }
    select#dt-length-0 {
        width: auto;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" />
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<table id="example" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <!-- <th>Panther ID</th> -->
                <th>Booking ID</th>
                <th>Service</th>
                <th>Type</th>
                <!-- <th>Name</th>
                <th>Phone</th>
                <th>Email</th> -->
                <th>Price</th>
                <th>Slots</th>
                <th>Date</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($orders->posts ?? [] as $key => $value) { 
                $service_id = get_post_meta($value->ID, 'service_id', true);
               
            ?>
                <tr>
                    <td>#<?= $value->ID?></td>
                    <td><?= get_the_title($service_id) ?></td>
                    <td><?= ucfirst(get_post_meta($value->ID, 'service_type', true)) ?></td>
                    <!-- <td><?= get_post_meta($value->ID, 'first_name', true) ?></td> -->
                    <!-- <td><?= get_post_meta($value->ID, 'phone', true) ?></td> -->
                    <!-- <td><?= get_post_meta($value->ID, 'user_email', true) ?></td> -->
                    <td>$<?= get_post_meta($value->ID, 'service_price', true) ?></td>
                    <td><?= get_post_meta($value->ID, 'slots', true) ?></td>
                    <td><?= get_post_meta($value->ID, 'date', true) ? date('d M Y', strtotime(get_post_meta($value->ID, 'date', true))) : '-' ?></td>
                    <td><?= get_post_meta($value->ID, 'order_status', true) ?></td>
                   
                    <td>
                        <a href="<?= home_url('user-order-details?id='.$value->ID) ?>" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit value Detail">
                           View More
                        </a>
                    </td> 
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <?php 
}
add_shortcode('history', 'history');
?>