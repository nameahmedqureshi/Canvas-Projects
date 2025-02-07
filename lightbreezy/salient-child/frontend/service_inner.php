<?php 
function services_inner(){
$service_id = $_GET["id"];
$image =  get_the_post_thumbnail_url($service_id);
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<section class="service_inner">
        <div class="container">
            <div class="row  wpb_row vc_row-fluid vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="service_inner">
                <div class="col span_6">
                    <h2><?= get_the_title($service_id) ?></h2>
                    <p class="service_desc"><?= apply_filters('the_content', get_post_field('post_content', $service_id)) ?></p>
                    <a href="<?= is_user_logged_in() ? home_url("service-booking/?id=").$service_id : home_url( 'login?redirect='.home_url("service-booking/?id=").$service_id ) ?>" id="book_now" class="read_more">Book Now</a>
                </div>
                <div class="col span_6">
                    <div class="service_img">
                        <img src="<?=  !empty($image) ? $image : get_stylesheet_directory_uri().'/store/assets/images/no-preview.png' ?>">
                    </div>
                </div>
            </div>
        </div>
</section>
<?php 
}
add_shortcode('services_inner', 'services_inner');
?>