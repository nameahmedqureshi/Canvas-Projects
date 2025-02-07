<?php 
function user_order_view(){
$post_id = $_GET["id"];
$post_data = get_post($post_id);
$meta = get_post_meta($post_id,);
$service_id = get_post_meta($post_id, 'service_id', true);
$service_type =  get_post_meta($service_id, 'servic_type', true);
$uploaded_video =  get_post_meta($post_id, 'uploaded_recorded_video', true);
$get_video_url =  wp_get_attachment_url(  $uploaded_video  );

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
            <div class="card-header">
                <h2 class="card-title">Order Details</h2>
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
                            <th scope="row" class="text-start">Booking ID</th>
                            <td>#<?= $post_id ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Service Name</th>
                            <td><?= get_the_title($service_id ) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Service Price</th>
                            <td>$<?= get_post_meta($post_id, 'service_price', true) ?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Service Type</th>
                            <td><?= ucfirst(get_post_meta($post_id, 'service_type', true)) ?></td>
                        </tr>
                        <?php if ($meta['service_type'][0] != "recorded") { ?>
                            <tr>
                                <th scope="row" class="text-start">Service Date</th>
                                <td><?= get_post_meta($post_id, 'date', true) ?></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Service Time</th>
                                <td><?= get_post_meta($post_id, 'slots', true) ?></td>
                            </tr>
                        <?php } if (isset($meta['service_dna'][0]) && $meta['service_dna'][0]) {?>
                        <tr>
                            <th scope="row" class="text-start">DNA</th>
                            <td><?= get_post_meta($post_id, 'service_dna', true) ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th scope="row" class="text-start">Status</th>
                            <td><?= get_post_meta($post_id, 'order_status', true) ?></td>
                        </tr>

                        <tr>
                            <th scope="row" class="text-start">Client Requests</th>
                            <td><?= apply_filters('the_content', get_post_field('post_content', $post_id)) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>


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
                            <td><?= get_post_meta($post_id, 'phone', true) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?php if($service_type == 'recorded') { ?>
                <div class="table-responsive mb-3">
                    <h4 class="card-title">Recorded Video</h4>
                    <?php if($service_type == 'recorded' && $get_video_url) { ?>
                        <div class="video_container">
                            <video width="100%" height="100%" controls controlsList="nodownload" oncontextmenu="return false;" style="border-radius: 15px;">
                                <source src="<?= $get_video_url ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php } else { echo "<p>Waiting for admin to upload a recorded video.</p>"; } ?>
                </div>
            <?php } ?>
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