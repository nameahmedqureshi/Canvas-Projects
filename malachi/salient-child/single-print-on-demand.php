<?php get_header(); ?>
<style>
    .card {
        padding: 50px;
    }
    .c-images {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .c-images h5 {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .stl-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Space between items */
        margin-bottom: 20px; /* Space between rows */
    }

    .stl-item {
        flex: 1 1 calc(20% - 20px); /* 20% width minus gap for 5 items per row */
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        text-align: center;
    }

    .stl-image {
        width: 100%; /* Full width of the container */
        height: 150px;
        object-fit: cover;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .stl-text {
        font-size: 14px;
        margin: 5px 0;
        color: #333;
    }

    .stl-text strong {
        color: #000;
    }

    @media screen and (max-width: 768px) {
        .stl-item {
            flex: 1 1 calc(33.33% - 20px); /* 3 items per row for smaller screens */
        }
    }

    @media screen and (max-width: 480px) {
        .stl-item {
            flex: 1 1 calc(50% - 20px); /* 2 items per row for mobile screens */
        }
    }

</style>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= $post->post_title ?></h3>
                <p><?= $post->post_content ?></p>
                <p class="card-text mb-2">Demanded Price: <span>$<?= get_post_meta($post->ID, 'price', true) ?></span></p>
                <p class="card-text mb-2">Deadline date: <span><?= get_post_meta($post->ID, 'deadline_date', true) ?></span></p>
                <div class="c-images">
                    <h5>STL Files</h5>
                    <div class="stl-row">
                        <?php
                        $stl_files = get_post_meta($post->ID, 'stl_files', true);
                        if (!empty($stl_files)) {
                            foreach ($stl_files as $key => $val) { 
                                $attachment = wp_get_attachment_url($val['img']);
                        ?>
                        <div class="stl-item">
                            <img src="<?= $attachment ?>" alt="Image" class="stl-image">
                            <p class="stl-text"><strong>Quantity:</strong> <span><?= $val['quantity'] ?></span></p>
                            <p class="stl-text"><strong>Material:</strong> <span><?= $val['material'] ?></span></p>
                        </div>
                        <?php 
                                // Add a row break after every 5th element
                                if (($key + 1) % 5 == 0) { 
                                    echo '</div><div class="stl-row">';
                                }
                            }
                        } else { 
                        ?>
                        <p>No STL files found.</p>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php get_footer(); ?>