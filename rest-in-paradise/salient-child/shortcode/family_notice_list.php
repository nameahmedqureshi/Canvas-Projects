
<ul class="wpb_tabs_nav familyNoticeCategory">

<?php 
            $category = get_terms([
                'taxonomy'   => 'family-notice-category',
                'hide_empty' => false, // Set to true to exclude empty categories
            ]);  
            ?>
                <!--<li class="tab-item <?= $key == 0 ? 'active' : '' ?>">-->

            <li class="tab-item <?= isset($_GET['cat_type'])  && $_GET['cat_type'] == 'all' ? 'active' : '' ?>">
                <a href="<?= home_url('family-notice') ?>">
                    <button data-name="all" type="button">
                        <span>All Family Notices</span>
                    </button>
                </a>
            </li>
           
    <?php foreach ($category as $key => $value) { ?>

    <li class="tab-item <?= isset($_GET['cat_type']) && $_GET['cat_type'] == $value->slug  ? 'active' : ''  ?>">
        <button data-name="<?= $value->slug ?>" type="button">
            <span><?= $value->name ?></span>
        </button>
    </li>
    <?php  } ?>
</ul>

<div class="familyNoticeListing">
    <?php
   
    // Search by first name
    if (!empty($_GET['first_name'])) {
        $first_name = [
            [
                'key'     => 'name', 
                'value'   => sanitize_text_field($_GET['first_name']), 
                'compare' => 'LIKE'
            ]
        ];
    }

    // Search by surname
    if (!empty($_GET['surname'])) {
        $surname = [
            [
                'key'     => 'surname',
                'value'   => sanitize_text_field($_GET['surname']),
                'compare' => 'LIKE'
            ]
        ];
    }

    // Search by county
    if (!empty($_GET['county'])) {
        $county = [
            [
                'key'     => 'country',
                'value'   => sanitize_text_field($_GET['county']),
                'compare' => '='
            ]
        ];
    }

    // Search by category
    if (!empty($_GET['cat_type'])) {
        $cat_type = [
            [
                'taxonomy' => 'family-notice-category', // Replace with your actual taxonomy slug
                'field'    => 'slug', // Can be 'id' if filtering by term ID
                'terms'    => sanitize_text_field($_GET['cat_type']),
                'operator' => 'IN',
            ]
        ];
    }

    $args = array(
        'post_type'      => 'cpt-family-notice',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => [$first_name, $surname, $county, $cat_type],
        'tax_query'      => [$cat_type]
    );

    // var_dump($args);



    $family_notices = new WP_Query($args);
    if ($family_notices->have_posts()) :
        while ($family_notices->have_posts()) : 
            $family_notices->the_post();
            $metaData = get_post_meta(get_the_ID());
            // var_dump($metaData);
            $categories = get_the_terms(get_the_ID(), 'family-notice-category');

    ?>

    <div class="list">
        <a href="<?= esc_url(home_url('family-notice-details/?slug=' . get_the_ID())) ?>">

        <h5><?= $categories[0]->name ?></h5>
        <p><img decoding="async" class="i1 alignnone wp-image-138 size-full" src="<?= !empty($metaData['person_image'][0]) ? wp_get_attachment_url($metaData['person_image'][0]) :  get_stylesheet_directory_uri().'/assets/images/no-preview.png' ?>" alt="" width="141" height="188"></p>
        <h4><?= esc_html($metaData['name'][0] ?? 'No Name') ?></h4>
        <h6><?= esc_html($metaData['country'][0] ?? 'N/A') ?></h6>
        </a>
	</div>
    <?php 
        endwhile;
        wp_reset_postdata();
    else:
    ?>
    <p>No family notices found.</p>
    <?php endif; ?>
</div>

<script>

    jQuery(document).ready(function() {
        jQuery('.familyNoticeCategory button').click(function (e) {
            jQuery('.familyNoticeCategory li').removeClass('active')
            jQuery(this).parent('li').addClass('active');
            jQuery('[name="cat_type"]').val(jQuery(this).data('name'));
            jQuery('#filterForm').submit();

        })
    });
</script>