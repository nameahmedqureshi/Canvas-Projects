<?php 
function services_inner(){

    $service_id = $_GET["id"];
    $image =  get_the_post_thumbnail_url($service_id);
?>

<section class="service_inner">
        <div class="container">
            <div class="row  wpb_row vc_row-fluid vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="reg">
                <div class="col span_3">
                    <div class="service_img">
                        <img src="<?=  !empty($image) ? $image : get_stylesheet_directory_uri().'/store/assets/images/no-preview.png' ?>">
                    </div>
                </div>
                <div class="col span_9">
                    <h2><?= get_the_title($service_id) ?></h2>
                    <div class="d-flex pricing">
                      <?php if( empty(get_post_meta($service_id, 'single_price', true)) ) {  ?>
                        <div class="Cars_pricing">
                            <h3>$<?= get_post_meta($service_id, 'cars_price', true) ?></h3>
                            <h5>Cars</h5>
                        </div>
                        <div class="trucks_pricing">
                            <h3>$<?= get_post_meta($service_id, 'truck_price', true) ?></h3>
                            <h5>SUV’s &amp; Trucks</h5>
                        </div>
                        <div class="Over-Sized_pricing">
                            <h3>$<?= get_post_meta($service_id, 'over_sized', true) ?></h3>
                            <h5>Over-Sized</h5>
                        </div>
                        <?php }else{ ?>
                            <div class="single_price">
                            <h3>$<?= get_post_meta($service_id, 'single_price', true) ?></h3>
                            <h5><?= get_post_meta($service_id, 'single_price_text', true) ?></h5>
                        </div>
                        <?php } ?>
                    </div>
                    <p class="service_desc"><?= apply_filters('the_content', get_post_field('post_content', $service_id)) ?></p>
                </div>
            </div>
        </div>
</section>
<?php 
}
add_shortcode('services_inner', 'services_inner');
?>