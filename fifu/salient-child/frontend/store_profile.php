<?php /* Template Name: Store Profile */   ?>
<?php get_header(); ?> 
<?php
$user_id = isset($_GET['id']) ? $_GET['id'] : '';
if($user_id){
    $store_details = get_user_meta($user_id, 'store_details', true);
    $subscription_plan = get_user_meta($user_id, 'subscription_plan', true);
    $current_user_subscription_plan = get_user_meta(get_current_user_id(), 'subscription_plan', true);
    $store_pic = !empty($store_details) ? wp_get_attachment_url( $store_details['store_pic'] ) : get_stylesheet_directory_uri().'/multivendor/assets/images/no-preview.png';
    
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status'=> 'publish',
        'author' => $user_id, 
        'paged'=> $paged,
    ];

    if( $current_user_subscription_plan != $subscription_plan ){
        $args['meta_query'] = [
            [
                'key'      => 'featured_product',
                'value'      => 'true',
                'compare'  => '=',
            ]
            ];
    }
    $get_products = new WP_Query( $args );
} else {
    wp_redirect(home_url());
    exit;
}

?>
<style>

    div#tab1, div#tab2, div#tab3 {
        margin-top: 50px;
    }
    label.review-rating {
        pointer-events: none;
    }

    .rate {
        float: left;
        padding: 0 10px;
    }
    .rate:not(:checked) > input {
        position:absolute;
        top:-9999px;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked ~ label {
        color: #ffc700;    
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;  
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }

    span.page-numbers.current {
        background: #444444;
        color: #ffff;
        padding: 5px;
    }
    .pagination {
        text-align: center;
    }
    .search-container {
        display: flex;
        align-items: center;
        margin: 5px 0px 20px 0px;
        justify-content: end;
    }
    .search-input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 2px solid #ccc;
        border-radius: 5px 0 0 5px;
        outline: none;
    }

    .search-button {
        padding: 10px;
        border: none;
        background-color: #4CAF50;
        color: white;  /* Font Awesome icons inherit the color */
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }

    .search-button i {
        font-size: 16px;
    }

    .search-button:hover {
        background-color: #45a049;
    }
    .profile {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
    }


    .profile_img img {
        width: 160px !important;
        height: 160px !important;
        object-fit: cover;
        object-position: top;
    }

    .profile_desc {
        padding: 20px;
    }

    .profile_info {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
    }

        .profile_info .profile_info_detail {
        margin: 0px 30px;
    }
        div#pro_bann img {
        height: 430px;
        width: 100%;
        object-fit: cover;
        object-position: center;
    }

    .profile_info .profile_info_detail i {
        color: #000;
        font-size: 22px;
        margin-bottom: 10px;
        border-radius: 50px;
        width: 50px;
        height: 50px;
        border: 1px solid #000;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile_info .profile_info_detail a {
        color: gray;
        font-size: 15px;
    }

    ul#tabs-nav {
        display: flex;
        justify-content: center;
    }

    ul#tabs-nav li {
        background: #000;
        list-style: none;
        width: 100%;
        padding: 10px;
        text-align: center;
    }
    /* Tabs */
    /* .tabs {
    width: 600px;
    background-color: #09F;
    border-radius: 5px 5px 5px 5px;
    } */
    ul#tabs-nav {
    list-style: none;
    margin: 0;
    padding: 5px;
    overflow: auto;
    }
    ul#tabs-nav li {
    float: left;
    font-weight: bold;
    margin-right: 2px;
    padding: 8px 10px;
    border-radius: 5px 5px 5px 5px;
    /*border: 1px solid #d5d5de;
    border-bottom: none;*/
    cursor: pointer;
    }
        ul#tabs-nav li:hover, ul#tabs-nav li.active {
        background-color: green;
    }
    #tabs-nav li a {
    text-decoration: none;
    color: #FFF;
    }
    button.search-button {
        padding: 15px !important;
        border-radius: unset !important;
        background: green;
    }
        .item_box {
        padding: 10px;
        box-shadow: 0px 0px 5px 0px #80808052;
    }
    .item_box {
        padding: 10px;
        box-shadow: 0px 0px 5px 0px #80808052;
    }

    .item_box img {
        width: 300px !important;
        height: 200px !important;
    }
    button.search-button {
        padding: 15px !important;
        border-radius: unset !important;
        background: green;
    }

    .reviews_box {
        display: flex;
        flex-wrap: nowrap;
        box-shadow: 0px 0px 4px 0px #8080806e;
        width: 48%;
        margin: 10px 10px;
    }
    div#feedback button {
        width: 20%;
        padding: 10px;
        background: #000;
    }
    div#reviews {
        display: flex;
        flex-wrap: wrap;
    }

    div#product_description {
        margin-top: 30px;
    }
    div#feedback input {
        background: transparent;
        border: 1px solid;
    }
    .reviews_box .col.span_2 {
        width: 12%;
    }
    div#feedback textarea#comment {
        background: transparent;
        border: 1px solid;
    }
    div#feedback form {
        padding: 20px;
        box-shadow: 0px 0px 5px 0px #80808094;
        margin-top: 30px;
    }s
    div#reviews {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .review_detials p {
        padding-bottom: 0px;
    }

    .reviews_box img {
        margin-bottom: 0px !important;
        border-radius: 50px !important;
        padding: 8px;
    }

    .reviews_box .col.span_10 {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .item_box img {
        width: 300px !important;
        height: 200px !important;
    }
    .tab-content {
    padding: 10px;
    background-color: #FFF;
    }

</style>  
<section class="profile_banner">
    <div class="container main-content">
        <div class="row  wpb_row vc_row-fluid vc_row top-level full-width-content vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="pro_bann">
            <img src="<?= $store_pic ?>" alt="">
        </div>
    </div>
</section>
<section class="profile_deatils">
    <div class="container main-content">
        <div class="row  wpb_row vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="profile_detail">
            <div class="col span_6">
                <div class="profile">
                    <div class="profile_img">
                        <img src="<?= $store_pic ?>" alt="">
                    </div>
                    <div class="profile_desc">
                        <h3><?= !empty($store_details['store_name']) ? $store_details['store_name'] : 'Store Name Not Set'  ?></h3>
                        <p><?= !empty($store_details['store_about']) ? $store_details['store_about'] : 'Store About Not Set' ?></p>
                        <p>Subscription: <?= !empty($subscription_plan) ? $subscription_plan : 'subscription plan not set' ?></p>
                    </div>
                </div>
            </div>
            <div class="col span_6">
                <div class="profile_info">
                    <div class="profile_info_detail">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <h5>Phone Number</h5>
                        <a href="#"><?= !empty($store_details['store_number']) ? $store_details['store_number'] : 'Not Set' ?></a>
                    </div>
                    <div class="profile_info_detail">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <h5>Email</h5>
                        <a href="#"><?=  !empty($store_details['store_email']) ? $store_details['store_email'] : 'Not Set' ?></a>
                    </div>
                    <div class="profile_info_detail">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <h5>Address</h5>
                        <p><?= !empty($store_details['store_address']) ? $store_details['store_address'] : 'Not Set' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="profile_tabs">
    <div class="container main-content">
        <div class="row  wpb_row vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="products">
            <div class="tabs">
                <ul id="tabs-nav">
                    <li><a href="#tab1">Products</a></li>
                    <li><a href="#tab2">Reviews</a></li>
                    <li><a href="#tab3">Feedback</a></li>
                    <!-- <li><a href="#tab4">Description</a></li> -->
                </ul> <!-- END tabs-nav -->
                <div id="tabs-content">
                    <div id="tab1" class="tab-content">
                        <div class="row  wpb_row vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="items">
                            <!-- <div class="search-container">
                                <input type="text" name="search" placeholder="Search..." class="search-input">
                                <button class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div> -->

                            <div class="product_container">
                                <?php if ($get_products->have_posts()) { ?>
                                    <div class="woocommerce columns-4 ">
                                        <div class="woocommerce-notices-wrapper"></div>
                                        <ul class="products columns-4" data-n-lazy="off" data-rm-m-hover="off" data-n-desktop-columns="4" data-n-desktop-small-columns="3" data-n-tablet-columns="default" data-n-phone-columns="default" data-product-style="classic">
                                            <?php while ($get_products->have_posts()) {
                                                $get_products->the_post();
                                                wc_get_template_part('content', 'product');
                                            } ?>
                                        </ul>
                                    </div>
                                    <?php wp_reset_postdata();
                                } else { ?>
                                    <p>No product found.</p>
                                    <?php } ?>
                            </div>

                          
                        </div>
                        
                        <!-- <div class="pagination">
                            <?php 
                                // echo paginate_links( array(
                                // 'base' => get_pagenum_link(1) . '%_%',
                                // 'format' => '?paged=%#%',
                                // 'current' => max( 1, get_query_var('paged') ),
                                // 'total' => $get_products->max_num_pages,
                                // 'prev_text' => __('« Previous'),
                                // 'next_text' => __('Next »'),
                                // )); 
                            ?>
                        </div> -->
                    </div>
                    <div id="tab2" class="tab-content">
                        <div class="row  wpb_row vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="reviews">

                            <?php
                                $review_args = array(
                                    'post_type' => 'feedbacks',
                                    'posts_per_page' => -1,
                                    'post_status'=> 'publish',
                                    'author' => $user_id, 
                                );
                                $get_review = new WP_Query( $review_args );
                                if($get_review->found_posts) { foreach ($get_review->posts ?? [] as $key => $value) {
                                    $image_url = get_user_meta( $value->post_author, 'profile_pic', true );
                                    $image_url = wp_get_attachment_image_url( $image_url );
                                    $rating = get_post_meta($value->ID, 'rating', true);
                            ?>
                            <div class="reviews_box">
                                <div class="col span_2">
                                    <img src="<?=  !empty($image_url) ? $image_url :  'https://www.etsy.com/images/avatars/default_avatar_75x75.png' ?>" alt="">
                                </div>
                                <div class="col span_10">
                                    <div class="review_detials">
                                        <p><span class="review_name"><?= the_author_meta( 'display_name', $value->post_author ) ?> on <span class="review_date"><?= date('j, F, y', strtotime($value->post_date)) ?></span></p>
                                        <p class="review_desc"><?= get_the_excerpt($value->ID)  ?></p>
                                        <div class="rate">
                                            <?php for($i=1; $i <= 5; $i++){ ?>
                                                <input type="radio"  value="<?= $i ?>" <?= ($i == $rating) ? 'checked' : '' ?> />
                                                <label class="review-rating" title="text"><?= $i ?> star</label>
                                            <?php  } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           <?php } } else { ?>
                            <p>No Reviews yet</p>
                            <?php } ?>
                        </div> 
                    </div>
                    <div id="tab3" class="tab-content">
                         <div class="row  wpb_row vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="feedback">
                            <div class="form-container">
                                <form id="feedback_form">
                                    
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rate" value="5" />
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" name="rate" value="4" />
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" name="rate" value="3" />
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" name="rate" value="2" />
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" name="rate" value="1" />
                                        <label for="star1" title="text">1 star</label>
                                    </div><br>

                                    <div class="form-group">
                                        <label for="comment">Comment:</label>
                                        <textarea id="comment" name="comment" rows="8" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                        <input type="hidden" name="action" value="send_feedback">
                                        <button type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- <div id="tab4" class="tab-content">
                        <div class="row  wpb_row vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="product_description">
                            <p><?= !empty($store_details['store_about']) ? $store_details['store_about'] : '' ?></p>
                        </div>
                    </div> -->
                </div> <!-- END tabs-content -->
            </div> <!-- END tabs -->
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

    // jQuery(document).on("click", "a.page-numbers", function(e){
    //     e.preventDefault();
    //     var page = jQuery(this).text();
    //     if(jQuery(this).hasClass('next')){
    //         page = jQuery('.page-numbers.current').next().text();
    //     } else if(jQuery(this).hasClass('prev')){
    //         page = jQuery('.page-numbers.current').prev().text();
    //     }
       
    //     var search = jQuery('.search-input').val(); 
    //     paginate_search(e, page, search);
    // });

    // jQuery(document).on( 'click', '.search-button', function(e) {
    //     e.preventDefault();
    //     var search = jQuery('.search-input').val(); 
    //     paginate_search(e, 1, search); // Assuming you want to set page=1 initially
    // });

    // function paginate_search(e,page=1, search) {
    //     var user_id = "<?= $_GET['id'] ?>";
    //     console.log('user_id', user_id);
    //     console.log('search', search);
    //     jQuery('body').waitMe({
    //         effect : 'bounce',
    //         text : '',
    //         bg : 'rgba(255,255,255,0.7)',
    //         color : '#000',
    //         maxSize : '',
    //         waitTime : -1,
    //         textPos : 'vertical',
    //         fontSize : '',
    //         source : '',
    //     });
        
    //     jQuery.ajax({
    //         type: 'post',
    //         url: "<?= admin_url('admin-ajax.php') ?>",
    //         data: {action:"get_products_by_page", page:page, search: search, user_id: user_id},
    //         dataType : 'json',
    //         success: function (response) {
    //             jQuery('body').waitMe('hide');
    //             alert();
    //             console.log("producthtml", response.producthtml);
    //             console.log("status", response.status);
    //             if (response.status) {
    //                 jQuery('.woocommerce ').html(response.producthtml);
    //                 //jQuery('.pagination').html(response.paginationhtml);
    //             } else {
    //                 console.log("No products found or another error occurred.");
    //             }
          

    //         },
    //         error : function(errorThrown){
    //             jQuery('body').waitMe('hide');
    //             console.log(errorThrown);
    //         }
    //     });
    // }


    
    jQuery("#feedback_form").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        //  alert("works");
        var form = new FormData(this);
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
                        
                    }); 
                    $('#feedback_form')[0].reset();
                } 
            },
            error : function(errorThrown){
                console.log(errorThrown);
                jQuery('body').waitMe('hide');
            }
        });
    }); 

   // Show the first tab and hide the rest
    $('#tabs-nav li:first-child').addClass('active');
    $('.tab-content').hide();
    $('.tab-content:first').show();

    // Click function
    $('#tabs-nav li').click(function(){
    $('#tabs-nav li').removeClass('active');
    $(this).addClass('active');
    $('.tab-content').hide();
    
    var activeTab = $(this).find('a').attr('href');
    $(activeTab).fadeIn();
    return false;
    });
</script>
<?php get_footer();?>