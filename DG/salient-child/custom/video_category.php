<?php /* Template Name: video category */ 
// get_header();
function video_category(){

$args = array(
    'post_type' => 'video', // your custom post name
    'orderby' => 'menu_order',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1
);
?>
<section class="main">
    <div class="container">
        <div class="slider">
        <?php
            $my_posts = new WP_Query($args); 
            if($my_posts->have_posts()) : 
                while ( $my_posts->have_posts() ) : $my_posts->the_post();
                $videoUrl = get_field('video_link', get_the_id());
                $videoLike = get_field('video_like', get_the_id());
                $videoDislike = get_field('video_dislike', get_the_id());
                ?>
                <div class="item">
                    <div class="video_box" video_url="<?= $videoUrl ?>"  video_title="<?php the_title(); ?>" video_desc="<?php the_content(); ?>" post_id="<?php the_ID(); ?>" Like="<?= $videoLike ?>" dislike="<?= $videoDislike?>">
                        <img src="<?= get_the_post_thumbnail_url($post->ID, 'thumbnail'); ?>" alt="Image 1">
                    </div>
                    <div class="video_title">
                        <h2><?php the_title(); ?></h2>  
                    </div>
                </div>
                <?php
                endwhile;
            endif;
            wp_reset_postdata(); 
            $latestVideo = get_post_meta($my_posts->posts[0]->ID,'video_link',true);
            $Like = get_post_meta($my_posts->posts[0]->ID,'video_like',true);
            $Dislike = get_post_meta($my_posts->posts[0]->ID,'video_dislike',true);
             $latestVideo_url = wp_get_attachment_url($latestVideo);
            ?>
   		 </div>
	</div>
</section>   
<section class="video_section" id="video_sec">
    <div class="container">
        <div class="lightbox-container">
            <div class="video-overlay"></div>
                <video class="video" controls>
                    <source src="<?= $latestVideo_url ?>" type="video/mp4">
                </video>
                <div class="play-button">
                    <i class="fa fa-play"></i>
                </div>
            </div>
        </div>   
</section>   
<section class="video_section">
    <div class="container">
        <div class="row video_detail">
            <div class="col span_9">
                <div class="video_desc">
                    <h2><?= $my_posts->posts[0]->post_title ?></h2>
                    <p class="desc"><?= $my_posts->posts[0]->post_content ?></p>
                </div>
            </div>
            <div class="col span_3">
                <div class="video_rating" data-post-id="<?= $my_posts->posts[0]->ID ?>">
                    <i class="fa fa-thumbs-up like-button" aria-hidden="true"><span class="count"><?= $Like ?></span></i>
                    <i class="fa fa-thumbs-down dislike-button" aria-hidden="true"><span class="count"><?= $Dislike ?></span></i>
                </div>
            </div>
        </div>
        <div class="row video_comment comment_option">
            <div class="col span_3">
                <div class="profile_img">
                    <img src="https://devu06.testdevlink.net/DG/wp-content/uploads/2024/05/dummy450x450-300x300-1.jpg" alt="">
                </div>
            </div>
            <div class="col span_9">
                <div class="comment_box">
                    <form id="add_comment">
                        <input type="text" name="name" placeholder="Name">
                        <textarea name="comment" placeholder="Add a comment"></textarea>
                        <input type="hidden" name="post_id" value="<?= $my_posts->posts[0]->ID ?>" class="c_post_id">
                        <input type="hidden" name="action" value="add_custom_comment">
                        <button type="submit"class="comment_submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row video_comment comments_show">
            <?php
                $commentsrgs = array(
                    'post_id' => $my_posts->posts[0]->ID, // ID of the post to get comments for
                    'status'  => 'approve' // Get only approved comments
                );

                // Retrieve the comments based on the arguments
                $comments = get_comments($commentsrgs);

                // Check if comments are found
                if (!empty($comments)) { 
                    foreach ($comments as $comment) { ?>
                      
                        <div class="reviews">
                            <div class="col span_3">
                                <div class="profile_img">
                                    <img src="https://devu06.testdevlink.net/DG/wp-content/uploads/2024/05/dummy450x450-300x300-1.jpg" alt="">
                                </div>
                            </div>
                            <div class="col span_9">
                                <div class="comment_box main_box">
                                    <h4><?= $comment->comment_author ?></h4>
                                    <p><?= $comment->comment_content ?></p>
                                </div>
                            </div>
                        </div> 
                <?php    }
                    } else {
                        echo 'No comments found.';
                    }
                ?>       
        </div>
    </div>    
</section>
<script>
    jQuery(document).ready(function($){
        jQuery('.slider').slick({
            autoplay: true,
            autoplaySpeed: 5000,
            slidesToShow: 4, // Show 4 slides at once
            slidesToScroll: 1, // Scroll 1 slide at a time
            infinite: true,
            dots: false,
            arrows: true, // Show arrows for navigation
            prevArrow: '<button type="button" class="slick-prev">Previous</button>',
            nextArrow: '<button type="button" class="slick-next">Next</button>',
            responsive: [
            {
                breakpoint: 840,
                settings: {
                slidesToShow: 2 // Show 2 slides at a time on screens wider than 840px
                }
            },
            {
                breakpoint: 480,
                settings: {
                slidesToShow: 1 // Show 1 slide at a time on screens between 480px and 360px
                }
            },
            {
                breakpoint: 360,
                settings: {
                slidesToShow: 1 // Show 1 slide at a time on screens narrower than 360px
                }
            }
            ]
        });
    
        // video lightbox //
        const $lightboxContainer = jQuery('.lightbox-container');
        const $video = $lightboxContainer.find('.video');
        const $overlay = $lightboxContainer.find('.video-overlay');
        const $playButton = $lightboxContainer.find('.play-button');

        $lightboxContainer.on('mouseenter', function() {
        $overlay.css('opacity', '1');
        $playButton.css('opacity', '1');
        });

        $lightboxContainer.on('mouseleave', function() {
        $overlay.css('opacity', '0');
        $playButton.css('opacity', '0');
        });

        $playButton.on('click', function() {
        $video[0].play();
        $overlay.hide();
        $playButton.hide();
        });
    
        jQuery(".item.slick-slide").on('click',function(){
                var target = jQuery(this).find(".video_box");
                var post_id = target.attr('post_id');
                var action = Cookies.get(post_id + '_action');
                console.log(action)
                
                $('.like-button, .dislike-button').removeClass('clicked');
                if (action == 'like') {
                    $('.like-button').addClass('clicked');
                } else if (action == 'dislike') {
                    $('.dislike-button').addClass('clicked');
                }
            window.location.href="#video_sec";
            
            var video_url =  target.attr("video_url");
            var video_title =  target.attr("video_title");
            var video_desc =  target.attr("video_desc");
            var post_id = target.attr("post_id");
            // var video_like = target.attr("like");
            // var video_dislike = target.attr("dislike");
            jQuery(".lightbox-container source").attr("src",video_url);
            jQuery(".video_rating").attr("data-post-id",post_id);
            jQuery('.lightbox-container .video')[0].load();
            jQuery('.lightbox-container .video')[0].play();
            jQuery(".video_desc h2").text(video_title); 
            // jQuery(".like-button span").text(video_like); 
            // jQuery(".dislike-button span").text(video_dislike); 
            jQuery(".video_desc p").html(video_desc); 
            jQuery(".c_post_id").val(post_id); 

            get_comments(post_id);
           
        });

        function get_comments(post_id){

            jQuery.ajax({
                type: 'post',
                url: "<?= admin_url('admin-ajax.php') ?>",
                data: {
                    action: 'get_comments_by_post_id',
                    post_id: post_id,
                },
                dataType: 'json',
                success: function (response) {
                    // jQuery('body').waitMe('hide');
                    jQuery('.comments_show').html(response.html);
                    jQuery(".like-button span").text(response.like); 
                    jQuery(".dislike-button span").text(response.dislike); 
                   // console.log(response.html);
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                    // jQuery('body').waitMe('hide');
                }
            });

        }
   

	$(document).ready(function() {
		// On page load, check cookies and set the clicked class appropriately
		$('.video_rating ').each(function() {
			var post_id = $(this).data('post-id');
            // console.log('post_id',post_id);
            // return;
			var action = Cookies.get(post_id + '_action');

			if (action === 'like') {
				$(this).find('.fa-thumbs-up').addClass('clicked');
			} else if (action === 'dislike') {
				$(this).find('.fa-thumbs-down').addClass('clicked');
			}
		});

		// Handle click events for like and dislike buttons
		$('.video_rating .fa-thumbs-up, .video_rating .fa-thumbs-down').on('click', function(e) {
			e.preventDefault();
			var button = $(this);
			var post_id = button.closest('.video_rating').attr('data-post-id');
			var action = button.hasClass('fa-thumbs-up') ? 'like' : 'dislike';
			var previous_action = Cookies.get(post_id + '_action');
            // console.log('post_id',post_id);
            // return;
			if (previous_action == action) {
				Cookies.remove(post_id + '_action');
				action = '';
			} else {
				Cookies.set(post_id + '_action', action);
			}

			$.ajax({
				url: "<?= admin_url('admin-ajax.php') ?>",
				type: 'POST',
				data: {
					action: 'update_post_like_dislike',
					post_id: post_id,
					current_action: action,
					previous_action: previous_action
				},
                dataType: 'json',
				success: function(response) {

                    var likeButton = button.closest('.video_rating').find('.fa-thumbs-up');
                    var dislikeButton = button.closest('.video_rating').find('.fa-thumbs-down');
                    var likeCountSpan = likeButton.find('.count');
                    var dislikeCountSpan = dislikeButton.find('.count');
                    // console.log('previous_action',previous_action);
                    // return;


                    if (previous_action == 'like') {
                        var likeCount = parseInt(likeCountSpan.text());
                        likeCountSpan.text(likeCount - 1);
                        likeButton.removeClass('clicked');

                    } else if (previous_action == 'dislike') {
                        var dislikeCount = parseInt(dislikeCountSpan.text());
                        dislikeCountSpan.text(dislikeCount - 1);
                        dislikeButton.removeClass('clicked');
                    }

                    if (action == 'like') {
                        var likeCount = parseInt(likeCountSpan.text());
                        likeCountSpan.text(likeCount + 1);
                        likeButton.addClass('clicked');

                    } else if (action == 'dislike') {
                        var dislikeCount = parseInt(dislikeCountSpan.text());
                        dislikeCountSpan.text(dislikeCount + 1);
                        dislikeButton.addClass('clicked');
                    }

                    // Swal.fire({
                    //     icon: response.icon,
                    //     title: 'Thank you!',
                    //     text: response.message
                    // });
					
				}
			});
		});
	});

        // add comments // 
        jQuery("#add_comment").submit(function(e) {
			e.preventDefault(); // avoid to execute the actual submit of the form.
			//  alert("works");
			var form = new FormData(this);
			//console.log('form', form);
			jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
			jQuery(this).find('button[type=submit]').prop('disabled',true);
			var thiss = jQuery(this);
			jQuery('body').waitMe({
				effect : 'bounce',
				text : '',
				bg : 'rgba(255,255,255,0.7)',
				color : '#000',
				maxSize : '',
				waitTime : -1,
				textPos : 'vertical',
				fontSize : '',
				source : '',
			});

			jQuery.ajax({
              type: 'post',
              url: "<?= admin_url('admin-ajax.php') ?>",
			  data: form,
			  dataType : 'json',
			  cache:false,
			  contentType: false,
			  processData: false,
              dataType : 'json',
              success: function (response) {
				jQuery('.fa.fa-spinner.fa-spin').remove();
				jQuery('body').waitMe('hide');
				jQuery(thiss).find('button[type=submit]').prop('disabled',false);
				if(!response.status){
				Swal.fire({
					title: response.title,
					text:  response.message,
					icon: response.icon,
					})
				}
				else{
          
					Swal.fire({
						title: response.title,
						text:  response.message,
						icon: response.icon,
						showConfirmButton: false,
						});
                        get_comments(response.post_id); 
                        jQuery("#add_comment")[0].reset();
				} 
			},
			error : function(errorThrown){
				console.log(errorThrown);
				jQuery('body').waitMe('hide');
			}
          });
      }); 

    });
 
</script>
<?php
}
add_shortcode('video_category', 'video_category');
// get_footer(); 
?>