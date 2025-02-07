<?php get_header(); ?>
<style>
    .card {
        padding: 50px;
    }
</style>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= $post->post_title ?></h3>
                <p><?= $post->post_content ?></p>
                <p class="card-text mb-2">Demanded Price: <span>$<?= get_post_meta($post->ID, 'price', true) ?></span></p>
                <p class="card-text mb-2">Deadline date: <span><?= get_post_meta($post->ID, 'deadline_date', true) ?></span></p>
                <p class="card-text mb-2">Item Type: <span><?= get_post_meta($post->ID, 'item_type', true) ?></span></p>
                <div class="c-images">
                    <h5>Example Images</h5>
                    <?php
                    $images =  get_post_meta($post->ID, 'example_files', true);
                    foreach($images as $val){ 
                        $attachment = wp_get_attachment_url( $val )
                    ?>
                        <img src="<?= $attachment ?>" height="150px" width="150px" alt="Image">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>