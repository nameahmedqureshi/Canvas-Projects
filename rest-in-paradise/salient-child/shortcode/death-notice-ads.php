<style>
    ul.serviceDirectory.death-ads.ads.sidebar {
    background: white;
    box-shadow: 0 30px 60px rgba(0, 0, 0, .15);
    padding: 13px !important;
    border-radius: 10px;
}

ul.serviceDirectory.death-ads li .icon {
    width: 62px !important;
}
ul.serviceDirectory.death-ads li h6 {
    margin-bottom: 0;
    text-align: center;
}

ul.serviceDirectory.death-ads li span.count {
    color: #dabc5b;
    background: transparent;
}

ul.serviceDirectory.death-ads li {
    list-style-type: none;
    border: 1px solid #b9b9b9;
}

ul.serviceDirectory.death-ads li a {
    padding: 5px 10px;
}

ul.serviceDirectory.death-ads li .icon img {
    width: 100%;
    height: 50px;
    object-fit: cover;
}

</style>
<ul class="serviceDirectory death-ads ads sidebar">
        <?php 
             $args = array(
                'post_type' => 'cpt-death-notice',
                'post_status' => 'publish',
                'posts_per_page' => 5,
                'orderby' => 'rand'
            );
            $services = new WP_Query($args);
            foreach ($services->posts ?? [] as $key => $value) {
                $postMeta = get_post_meta($value->ID);
                
                ?>
                <li>
                    <a href="<?= esc_url(home_url('death-notice-details/?slug=' . $value->ID)) ?>">
                        <div class="icon">
                            <img src="<?= !empty($postMeta['person_image'][0]) ? wp_get_attachment_url($postMeta['person_image'][0]) :  get_stylesheet_directory_uri().'/store/assets/images/no-preview.png'  ?>" alt="">
                        </div>
                        <h6 class="title">
                            <span class="count"><?= $postMeta['county'][0] ?></span>
                            <?= $postMeta["name"][0] .' '. $postMeta["surname"][0] ?>
                        </h6>
                    </a>
                </li>
        <?php } ?>
        
        <li>
            <a class="browseAll" href="<?= esc_url(home_url('death-notices/')) ?>">
                All Recent Death Notices
                <svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m10.477 6.33-4.47-4.47L7.185.682l6.482 6.481-6.482 6.482-1.178-1.178 4.47-4.47H.333V6.33h10.144Z" fill="#3D320E"></path></svg>
            </a>
        </li>
    </ul>