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
                <p class="card-text mb-2">Quantity Needed: <span><?= get_post_meta($post->ID, 'quantity', true) ?></span></p>
                <p class="card-text mb-2">Deadline Date: <span><?= get_post_meta($post->ID, 'deadline_date', true) ?></span></p>
                
            </div>
        </div>
    </div>
<?php get_footer(); ?>