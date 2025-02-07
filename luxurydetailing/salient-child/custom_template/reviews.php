<?php
function reviews() { ?>
<style>
    .review_form {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }
    .review1 {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .review1 .col {
        flex: 1;
        padding: 10px;
    }
    .review1 .col-12 {
        flex: 100%;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    input[type="text"],
    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .star-rating {
        display: flex;
        gap: 5px;
        direction: rtl;
        justify-content: left;
    }
    .star-rating input {
        display: none;
    }
    .star-rating label {
        font-size: 2em;
        color: gray;
        cursor: pointer;
    }
    .star-rating input:checked ~ label {
        color: gold;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: gold;
    }
     .reviews-display {
        display: flex;
        margin: auto;
        flex-wrap: wrap;
    }
    button#load-more {
        margin: auto;
        display: table;
        padding: 13px 20px;
        background: #000;
        color: #fff;
        font-size: 16px;
        border-radius: 50px !important;
        cursor: pointer;
    }
    .review-item {
        display: flex;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 10px 10px;
          width: 48%;
    }
    .review-image img {
        border-radius: 50px !important;
    }
    .review-image {
        flex: 1;
        max-width: 60px;
    }
    .review-image img {
        max-width: 100%;
        border-radius: 5px;
    }
    .review-content {
        flex: 2;
        padding-left: 20px;
    }
    .review-name {
        font-size: 1.2em;
        font-weight: bold;
    }
    .review-stars {
        color: gold;
    }
    .review-description {
        margin-top: 10px;
    }
</style>

<div class="review_form">
    <form class="review_submit">
        <div class="row review1">
            <div class="col span_6">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your name">
            </div>
            <div class="col span_6">
                <label for="rating">Star Rating</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5">&#9733;</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">&#9733;</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">&#9733;</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">&#9733;</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">&#9733;</label>
                </div>
            </div>
        </div>
        <div class="row review1">
            <div class="col span_12">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Write your review here..."></textarea>
            </div>
        </div>
        <div class="row review1">
            <div class="col span_12">
                <button class="review_submit" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>

<div class="reviews-display" id="reviews-display">
    <?php
    $reviews = new WP_Query(array('post_type' => 'reviews', 'post_status' => 'publish', 'posts_per_page' => 4));
    if ($reviews->have_posts()) : while ($reviews->have_posts()) : $reviews->the_post();
        $rating = get_post_meta(get_the_ID(), 'rating', true);
        $description = get_the_content();
    ?>
        <div class="review-item">
            <div class="review-image">
                <img src="https://devu01.testdevlink.net/Luxury_Detailing/wp-content/uploads/2024/06/blank-profile-picture-973460_960_720.webp" alt="User Image">
            </div>
            <div class="review-content">
                <div class="review-name"><?php the_title(); ?></div>
                <div class="review-stars">
                    <?php for ($i = 0; $i < $rating; $i++) {
                        echo '&#9733;';
                    } ?>
                </div>
                <div class="review-description"><?php echo $description; ?></div>
            </div>
        </div>
    <?php
    endwhile; endif; wp_reset_postdata();
    ?>
</div>

<button class="load-more" id="load-more">Load More Reviews</button>

<script>
    jQuery(document).ready(function($) {
        var page = 1;
        var postsPerPage = 4; // Number of posts per page
        var totalPosts = <?php echo $reviews->found_posts; ?>; // Total number of reviews found

        // Initial check to show/hide load more button
        if (totalPosts > postsPerPage) {
            $('.load-more').show(); // Show load more button if there are more than initial posts
        }

        $('.review_form').on('submit', function(e) {
            e.preventDefault();

            var name = $('#name').val();
            var rating = $('input[name="rating"]:checked').val();
            var description = $('#description').val();

            var data = {
                'action': 'submit_review',
                'name': name,
                'rating': rating,
                'description': description,
            };

            $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                if(response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your review has been submitted.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error submitting your review.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('#load-more').on('click', function() {
            page++;
            var data = {
                'action': 'load_more_reviews',
                'page': page
            };

            $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                if(response.success) {
                    $('#reviews-display').append(response.data);

                    // Check if there are more pages to load
                    if ((page * postsPerPage) >= totalPosts) {
                        $('#load-more').hide(); // Hide load more button if no more posts
                    }
                } else {
                    $('#load-more').prop('disabled', true).text('No more reviews');
                }
            });
        });
    });
</script>
<?php 
}
add_shortcode('reviews', 'reviews');
?>
