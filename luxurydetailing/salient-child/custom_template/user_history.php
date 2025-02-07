<?php 
function garage_name($garage){
    if($garage == 'pg1'){
        $name = 'Gold Garage';
    } elseif($garage == 'pg3'){
        $name = 'Panther Garage';
    }
    return $name;
}

function history(){

    if(!is_user_logged_in() ) {
        wp_redirect(home_url('/'));
        echo '<script>window.location.href = "'.home_url('/').'"</script>';
        exit;
    }

    $args = array(
        'post_type' => 'orders',
        'post_status' => 'any',
        'posts_per_page' => -1,
        'meta_query' => $type,
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
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" />
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<table id="example" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <!-- <th>Panther ID</th> -->
                <th>Garage</th>
                <!-- <th>Classification</th> -->
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>License Plate</th>
                <th>Date</th>
                <th>Total amount</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($orders->posts ?? [] as $key => $value) { 

                $author_meta = get_user_meta($value->post_author);
                $author = get_userdata($value->post_author);

                $service_id = get_post_meta($value->ID, 'service_id', true);
                $service_name = get_the_title($service_id);
                $order_summary = get_post_meta($value->ID, 'order_summary', true);
                $order_status = get_post_meta($value->ID, 'order_status', true);
                $garage = get_post_meta($value->ID, 'garage_location', true);
                
            ?>
                <tr>
                    <td><?= garage_name($garage) ?></td>
                    <td><?= get_post_meta($value->ID, 'make', true) ?></td>
                    <td><?= get_post_meta($value->ID, 'model', true) ?></td>
                    <td><?= get_post_meta($value->ID, 'year', true) ?></td>
                    <td><?= get_the_title($value->ID) ?></td>
                    <td><?= date('d M Y', strtotime(get_post_meta($value->ID, 'date', true))) ?></td>
                    <td>$<?= get_post_meta($value->ID, 'total_price', true) ?></td>
                    <td><?= $order_status ?></td>
                    <td>
                        <a href="<?= home_url('user-order-view?id='.$value->ID) ?>" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit value Detail">
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