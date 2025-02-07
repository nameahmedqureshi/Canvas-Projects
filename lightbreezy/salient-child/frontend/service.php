<?php 
function services(){
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<section class="services">
    <div class="container ">
        <div class="row wpb_row vc_row-fluid vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="booking_services">
            <?php 
            $args = array(
                'post_type' => 'services', 
                'posts_per_page' => -1,
                'post_status' => 'any',
                'meta_query' =>  [
                    [
                        'key' => 'status',
                        'value' => 'active',  // Replace 'desired_value' with the value you want to filter by
                        'compare' => '=',  // Comparison operator, can be '=', '!=', '>', '<', etc.
                    ]
                ]
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $service_id = get_the_ID();
                    $servic_type = get_post_meta( $service_id, 'servic_type', true );
                    ?>
                    <div class="col span_6">
                        <div class="service_box">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                            <h3><?php the_title(); ?><small></h3>
                            <p><?= the_excerpt(); ?></p>
                            <a href="<?= home_url("service-inner/")."?id=".$service_id ?>" class="read_more">Read More</a>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            } else {
                echo '<p>No services found</p>';
            }
            ?>
        </div>
    </div>
</section>
<?php 
}
add_shortcode('services', 'services');
?>