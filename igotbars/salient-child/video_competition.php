<?php

// $currentDate = date('Y-m-d');
$currentDate = date('Ymd');
// var_dump('$$$$' );
// var_dump($currentDate );
// exit;
// $currentDate = date('2024-08-01');
$currentTimestamp = strtotime($currentDate);

//get the active competition videos
$com_args = [
    'post_type' => 'bars_video',
    'posts_per_page' => 5,
    'post_status' => 'publish',
   
    'meta_query'     => [
        'relation' => 'AND',
        [
            'key'     => 'start_date',
            'value'   => $currentDate,
            'compare' => '<=',
        ],
        [
            'key'     => 'end_date',
            'value'   => $currentDate,
            'compare' => '>=',
        ],
    ],
];
$active_comp_bars_video = new WP_Query($com_args);

//get the inactive competition videos
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = [
    'post_type'      => 'bars_video',
    'posts_per_page' => 10,
    'post_status'    => 'publish',
    'paged'          => $paged,
    'meta_query'     => [
        'relation' => 'OR',
        [
            'key'     => 'start_date',
            'value'   => $currentDate,
            'compare' => '>',
        ],
        [
            'key'     => 'end_date',
            'value'   => $currentDate,
            'compare' => '<',
        ],
        [
            'key'     => 'start_date',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key'     => 'end_date',
            'compare' => 'NOT EXISTS',
        ],
    ],
];

$bars_video = new WP_Query($args);


$highestLikeCount['like'] = 0;
$highestLikeCount['count'] = 0;


    //  echo "<pre>";
    //  var_dump($videos);
?>
<style>
    i.fa-thumbs-up.clicked {
        color:  #5ab2e7 !important
    }    
    span.page-numbers.current {
        background: #5ab2e7;
        padding: 3px 8px;
    }
    .pagination {
        text-align: center;
    }

</style>
<div class="container" id="videoComp">

    <?php if ($paged == 1) {
        foreach ($active_comp_bars_video->posts  ?? [] as $key => $video) {
            // echo "<pre>";
            // var_dump($video);
            $video_id = $video->ID; 
            $videos = get_field('video', $video_id);
            $start_date = get_field('start_date', $video_id);
            $end_date = get_field('end_date', $video_id);
            $startTimestamp = strtotime($start_date);
            $endTimestamp = strtotime($end_date);
            // echo "<pre>";
            // var_dump($videos);
            // exit;
            foreach ($videos as $key => $value) { 
                $likeCount = get_field("video_".$key."_like", $video_id); 
                // $cookie_val = $_COOKIE[$video_id.'_'.$key.'_action'];
               $cookie_val = $_COOKIE['video_'.$key.'_like'];
                // echo "<pre>";
                // var_dump($key);
                // var_dump($value['video_title']);
                // exit;

                ?>
                <div class="row span_12 active_competition">
                    <div class="vc_col-sm-6  col">
                        <div class="video-wrap">
                            <video src="<?= !empty($value['upload_video']) ? $value['upload_video'] : '' ?>" controls loop muted poster="<?= !empty($value['upload_video_poster']) ? $value['upload_video_poster'] : '' ?>" preload="auto" width="640"
                                height="360" crossorigin="anonymous"></video>
                        </div>
                    </div>
                    
                    <div class="vc_col-sm-6  col">
                        <div class="text-wrap custom-text">
                            <span class="date"><?= date('d F Y', strtotime($start_date)) ?> to <?= date('d F Y', strtotime($end_date)) ?></span>
                        <h1><?= !empty($value['video_title']) ? $value['video_title'] : ''  ?></h1>
                            <h3>
                                <a href="<?= !empty($value['instagram_link']['url']) ? $value['instagram_link']['url'] : '' ?>">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                <span>@<?= !empty($value['instagram_username']) ? $value['instagram_username'] : ''  ?></span>
                                </a>
                            </h3>
                        </div>
                        <div class="button-wrap" data-post-id="<?= $video_id ?>">
                            <button class="butn like" data-key="<?= $key  ?>">
                                <i class="fa-solid fa-thumbs-up <?= !empty($cookie_val) ? 'clicked' : '' ?>"></i>
                                <span class="count <?= 'video_'.$key.'_like' ?>"><?= $likeCount ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php  }
        } 
    }
    
    // Display video with highest like count after competition ends
    foreach ($bars_video->posts ?? [] as $key => $video) {
        $video_id = $video->ID;
        $videos = get_field('video', $video_id);
        // echo "<pre>";
        // var_dump($videos);
        $likes = array_column($videos, 'like');
        $max = max($likes);
        $countHighestValue = array_count_values($likes)[$max];
        // var_dump(array_search($max, $likes));
        $start_date = get_field('start_date', $video_id);
        $end_date = get_field('end_date', $video_id);
        foreach ($videos as $key => $value) {
            $likeCount = get_field("video_" . $key . "_like", $video_id);
            if($currentTimestamp > strtotime($end_date) ) {
                if ( $max > 0 && $likeCount == $max) {
                    // Display video with highest likes
                    ?>
                    <div class="row span_12">
                        <div class="vc_col-sm-6  col">
                            <div class="video-wrap">
                                <video src="<?= !empty($value['upload_video']) ? $value['upload_video'] : '' ?>" controls loop muted poster="<?= !empty($value['upload_video_poster']) ? $value['upload_video_poster'] : ''?>" preload="auto" width="640"
                                    height="360" crossorigin="anonymous"></video>
                            </div>
                        </div>
                        <div class="vc_col-sm-6  col">
                            <div class="text-wrap custom-text">
                                <span class="date"><?= date('d F Y', strtotime($start_date)) ?> to <?= date('d F Y', strtotime($end_date)) ?></span>
                                <h1><?= !empty($value['video_title']) ? $value['video_title'] : '' ?></h1>
                                <h3>
                                    <a href="<?= !empty($value['instagram_link']['url']) ? $value['instagram_link']['url'] : '' ?>">
                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                    <span>@<?= !empty($value['instagram_username']) ? $value['instagram_username'] : '' ?></span>
                                    </a>
                                </h3>
                            </div>
                            <div class="button-wrap" data-post-id="<?= $video_id ?>">
                                <button class="butn " data-key="<?= $key  ?>">
                                    <i class="fa-solid fa-thumbs-up clicked"></i>
                                    <span class="count"><?= $likeCount ?></span>
                                </button>
                            </div>
                            <div class="winner">
                                <h2 class="winner-text"><?= $countHighestValue > 1 ? 'Draw' : 'Winner' ?></h2>
                            </div>
                        </div>
                    </div>
                    <?php
                    
                }
            }
        }
    } 
    ?>


    <div class="pagination">
        <?php 
            echo paginate_links( array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $bars_video->max_num_pages,
            'prev_text' => __('« Previous'),
            'next_text' => __('Next »'),
            )); 
        ?>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        

		// Handle click events for like and dislike buttons
		$('.like, .dislike').on('click', function(e) {
			e.preventDefault();
			var button = $(this);
			var post_id = button.closest('.button-wrap').attr('data-post-id');
            var key = button.attr('data-key');
            var current_like_post_id = 'video_' + key + '_like';
            var previous_like_post_id = Cookies.get('current_like_video');

            // console.log("previous_like_post_id",previous_like_post_id);
            // return;
            if(current_like_post_id == previous_like_post_id){
                alert("You already liked this video");
                return;
            }

            // If the user is trying to like a new video, remove the like from the previous video
            if (previous_like_post_id) {
                Cookies.remove(previous_like_post_id);
                Cookies.remove('current_like_video');
            }

            Cookies.set(current_like_post_id, 'like');
            Cookies.set('current_like_video', 'video_' + key + '_like');			
           
			$.ajax({
				url: "<?= admin_url('admin-ajax.php') ?>",
				type: 'POST',
				data: {
					action: 'update_post_like',
                    current_like_post_id: current_like_post_id,
                    previous_like_post_id: previous_like_post_id,
					post_id: post_id,
					key: key,
				},
                dataType: 'json',
				success: function(response) {
                    jQuery('.active_competition .button-wrap').find('.fa-thumbs-up').removeClass('clicked');
                    jQuery('.video_0_like').text(response.video_0_like);
                    jQuery('.video_1_like').text(response.video_1_like);
                    jQuery('.video_2_like').text(response.video_2_like);
                    jQuery('.video_3_like').text(response.video_3_like);
                    jQuery('.video_4_like').text(response.video_4_like);

                    if (current_like_post_id) {
                        button.closest('.button-wrap').find('.fa-thumbs-up').addClass('clicked');
                    } 
                 
				}
			});
		});
    });
</script>
