<?php 
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
get_header();
global $product;
$_product = $product;
$post_author = get_post_field('post_author', $_product->get_id());
// $postMeta = get_post_meta($_product->get_id(), true);
// var_dump($_product);
?>
<head>
    <!-- <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/css/all.css' ?>">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/css/single-product.css' ?>">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/css/single-product-responsive.css' ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri(  ) ?>/store/app-assets/vendors/css/editors/quill/quill.snow.css">
    <style>
        .holder_3_slice_left_rating p:nth-child(3) {
            width: 40px;
        }
        .attribute{
            gap:15px !important
        }
        .attribute-block {
            width: 130px;
        }
        .slice_mid_box_1.priceSec {
            border-bottom: unset;
            padding-bottom: unset;
        }
                .attribute-block select {
            background: #ffff;
            border: 1px solid #a39e9e;
        }
        p.stock.out-of-stock {
            display: none;
        }
        button.single_add_to_cart_button.button.alt {
            background: #fed73a !important;
        }
        button.single_add_to_cart_button {
            font-size: 16px !important;
            font-family: var(--avantGarde-medium) !important;
            color: var(--black) !important;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 45px !important;
            border-radius: 60px !important;
            margin-bottom: 10px ;
            border: 1px solid transparent;
        }
        .info_block:hover{
            background: #084025;
        }
        .woocommerce .cart .quantity {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<!-- <section class="products_top_holder">
    <div class="box_frame">
        <div class="products_top_holder_txt">
            <h1 class="products_top_holder_note">Detail</h1>
            <h2 class="products_top_holder_note_lite">PRODUCT</h2>
        </div>
        <div class="pic_frame">
            <img src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/images/sclupture_img.png' ?>" alt="img" class="">
        </div>
    </div>
</section> -->
<section class="products_first_holder">
    <form class="cart" id="submitProduct" action="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']  ?>" method="POST">
        <div class="box_frame">
            <div class="stripe_1">
                <div class="slice_left_side_slider">
                    <div class="slider_flex">
                        <!-- Main (right) slider -->
                        <div class="slider_right_side">
                            <div class="swiper mySwiper2">
                                <div class="swiper-wrapper">
                                    <?php
                                    // Featured image
                                    $featured_image = $_product->get_image_id();
                                    if ($featured_image) {
                                        $image_url = wp_get_attachment_image_url($featured_image, 'large');
                                    ?>
                                    <div class="swiper-slide">
                                        <img src="<?= esc_url($image_url) ?>" class="img-fluid" alt="Product Image" />
                                    </div>
                                    <?php } else { ?>
                                    <!-- Fallback image -->
                                    <div class="swiper-slide">
                                        <img src="<?= get_stylesheet_directory_uri() . '/store/assets/images/woocommerce-no-image.png' ?>" class="img-fluid" alt="Sample Image" />
                                    </div>
                                    <?php } ?>
                                    <?php
                                    // Gallery images
                                    $gallery_image_ids = $_product->get_gallery_image_ids();
                                    if ($gallery_image_ids) {
                                        foreach ($gallery_image_ids as $attachment_id) {
                                            $image_url = wp_get_attachment_image_url($attachment_id, 'large');
                                    ?>
                                    <div class="swiper-slide">
                                        <img src="<?= esc_url($image_url) ?>" class="img-fluid" alt="Product Image" />
                                    </div>
                                    <?php } } ?>
                                </div>
                            </div>
                        </div>
                        <!-- Thumbnail (left) slider -->
                        <div class="slider_left_side">
                            <div thumbsSlider="" class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    <?php
                                    // Featured image
                                    if ($featured_image) {
                                        $thumb_url = wp_get_attachment_image_url($featured_image, 'thumbnail');
                                    ?>
                                    <div class="swiper-slide slider_left_img">
                                        <img src="<?= esc_url($thumb_url) ?>" class="img-fluid" alt="Product Thumbnail" />
                                    </div>
                                    <?php } ?>
                                    <?php
                                    // Gallery images
                                    if ($gallery_image_ids) {
                                        foreach ($gallery_image_ids as $attachment_id) {
                                            $thumb_url = wp_get_attachment_image_url($attachment_id, 'thumbnail');
                                    ?>
                                    <div class="swiper-slide slider_left_img">
                                        <img src="<?= esc_url($thumb_url) ?>" class="img-fluid" alt="Product Thumbnail" />
                                    </div>
                                    <?php } } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="slice_mid_side">
                    <div class="slice_mid_box">
                        <div class="slice_mid_side_main_text">
                            <h6><?=  $_product->name  ?></h6>
                            <a href="<?= home_url('store-profile?id='. $post_author); ?>" target="_blank">Visit the vendor store</a>
                        </div>
                        <div>
                            <?php
                            $availability = get_post_meta($_product->get_id(), 'availability', true);
                            if($availability){ 
                                $availability_text = is_array($availability) ? implode(', ', $availability) : $availability;
                            ?>
                            <p class="light_desc">Available in <?= $availability_text  ?> </p>
                            <?php } ?>
                        </div>
                        <!-- <div>
                            <ul class="slice_mid_flex_box">
                                <li>
                                    <ul>
                                        <li> <p>4.3</p></li>
                                        <li> <span><i class="fa-solid fa-star"></i></span> </li>
                                        <li> <span><i class="fa-solid fa-star"></i></span> </li>
                                        <li> <span><i class="fa-solid fa-star"></i></span> </li>
                                        <li> <span><i class="fa-solid fa-star"></i></span> </li>
                                        <li> <span><i class="fa-solid fa-star"></i></span> </li>
                                    </ul>
                                </li>
                                <li>107,433 rating</li>
                            </ul>
                        </div> -->
                        <!-- <div class="slice_mid_flex_box">
                            <div class="slice_mid_img">
                                <img src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/images/slice_mid_flower_img.png' ?>" class="img-fluid" alt="">
                            </div>
                            <div class="slice_mid_dropdown">
                                <span><i class="fa-solid fa-angle-down"></i></span>
                                <select name="form_ddown" id="form_dropdown_1">
                                    <option value="sustainability">1 sustainability feature</option>
                                    <option value="sustainability">2 sustainability feature</option>
                                    <option value="sustainability">3 sustainability feature</option>
                                    <option value="sustainability">4 sustainability feature</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="slice_mid_img_text">
                            <img src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/images/slice_text_img1.png' ?>" class="img-fluid" alt="">
                            <p>Lorem ipsum odor amet consectetuer</p>
                        </div>
                        <div>
                            <p class="light_desc"><?= get_post_meta($_product->get_id(), 'total_sales', true)  ?> bought in USA</p>
                        </div>
                    </div>
                    <div class="slice_mid_box_1 priceSec">
                        <div class="slice_box_ttext">
                            <h5>
                                <?= !empty($_product->sale_price) ? '-'.round((($_product->regular_price - $_product->sale_price) / $_product->regular_price) * 100) . '%' : '0%' ?>
                            </h5>
                            <h6>$<?= !empty($_product->sale_price) ? round($_product->sale_price, 2) : round($_product->regular_price, 2)  ?></h6>
                        </div>
                        <div>
                            <p class="light_desc">List Price: $<?= round($_product->regular_price, 2) ?></p>
                            <!-- <div class="flex_p">
                                <p class="light_desc">$266.05 Shipping & Import Charges to USA <span class="cust_clr_gren">Details</span> </p>
                                <i class="fa-solid fa-angle-down"></i>
                                <div class="slice_mid_dropdown_1">
                                    <select name="form_ddown" id="form_dropdown_4">
                                        <option value="sustainability">Details</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <!-- <div class="slice_mid_img_text">
                            <img src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/images/slice_text_img2.png' ?>" class="img-fluid" alt="">
                            <div class="slice_right_check1">
                                <input class="form-check-input" type="checkbox" value="" id="covering_check_1">
                                <label class="light_desc" for="covering_check_1">Apply 15% coupon shop items | Terms</label>
                            </div>
                        </div> -->
                        <div>
                            <p class="light_desc">Available at a lower price from other sellers that may not offer free Prime shipping.</p>
                        </div>
                    </div>

                    <?php
                    // Get product object
                    $product = wc_get_product($_product->get_id());
                    $attributes = $product->get_attributes();

                    if ($attributes) { ?>
                        <div class="slice_mid_box_1">
                            <div class="slice_mid_ul_flex attribute">
                                <?php foreach ($attributes as $attribute) : ?>
                                    <div class="attribute-block">
                                        <?php
                                        // Display the attribute name
                                        $attribute_name = wc_attribute_label($attribute->get_name());
                                        echo '<h6>' . esc_html($attribute_name) . '</h6>';

                                        // Custom attribute: Get options
                                        $values = $attribute->get_options();
                                        if (!empty($values)) {
                                            echo '<label>';
                                            echo '<select name="attribute_' . esc_attr($attribute->get_name()) . '">';
                                            foreach ($values as $value) {
                                   
                                                echo '<option value="' . esc_attr($value) . '">' . ucfirst(esc_html($value)) . '</option>';

                                                // echo '<input type="radio" name="attribute_' . esc_attr($attribute->get_name()) . '" value="' . esc_attr($value) . '"> ' . esc_html($value);
                                                // echo '</label><br>';
                                            }
                                            echo '</select>';
                                            echo '</label>';
                                        }
                                    
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php } ?>


                    <div class="slice_mid_box_1">
                        <div class="slice_mid_ul_flex">
                            <ul class="dark">
                                <li>Product Type</li>
                                <li>State</li>
                                <li>City</li>
                                <li>Category</li>
                            </ul>
                            <ul class="light">
                                <?php $metadeta = get_post_meta($_product->get_id()); $cat = get_the_terms($_product->get_id(), 'product_cat' ); 
                                foreach($cat as $val){
                                    $category_names[] = $val->name; // Collect category names
                                } 
                                //$limited_categories = array_slice($category_names, 0, 3); ?>
                                <li><?= empty($metadeta['product_type'][0]) ? '---' : ucfirst($metadeta['product_type'][0]) ?></li>
                                <li><?= empty($metadeta['state'][0]) ? '---' : $metadeta['state'][0] ?></li>
                                <li><?= empty($metadeta['city'][0]) ? '---' : $metadeta['city'][0] ?></li>                       
                                <li><?= implode(', ', $category_names); ?></li>
                            </ul>
                        </div>
                    </div>
              


                    <div class="slice_mid_box_1">
                        <div class="slice_last_box_text">
                            <h6>About this item</h6>
                            <div class="ql-editor"><?= $_product->short_description ?></div>
                        </div>
                    </div>
                </div>
                <div class="slice_right_side">
                    <div class="slice_right_side_box_1">
                        <div class="slice_rifgt_side_ttext">
                            <h6>$<?= !empty($_product->sale_price) ? round($_product->sale_price, 2) : round($_product->regular_price, 2) ?></h6>
                            <!-- <p><span>$266.05 Shipping & Import Charges to Pakistan Details Delivery </span>Tuesday, November 19.</p> -->
                        </div>
                        <div class="holder_1_slice_right_pin">
                            <img src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/images/pin_icon.png' ?>" class="img_fluid" alt="">
                            <p>Deliver to Lorem ipsum</p>
                        </div>
                        <div class="slice_right_stock ">
                            <!-- <p><?= ucfirst($_product->stock_status) ?></p> -->
                            <p><?= empty($metadeta['made_to_order'][0]) ? '' : str_replace('_', ' ', $metadeta['made_to_order'][0]);   ?></p>
                        </div>
                        <?php   //if(in_array('customer', wp_get_current_user()->roles) ){ ?>
                        <div class="slice_right_select">
                            <?php woocommerce_template_single_add_to_cart(); // Add to Cart functionality ?>
                            <!-- <span><i class="fa-solid fa-angle-down"></i></span>
                            <select name="form_ddown" id="form_dropdown_2">
                                <option value="quality1">Quantity: 1</option>
                                <option value="quality2">Quantity: 2</option>
                                <option value="quality3">Quantity: 3</option>
                            </select> -->
                        </div>
                        <?php if($product->stock_status == 'instock'){ ?>
                        <div class="slice_right_btn">
                            <!-- <a href="#!" class="yello_light">Add to Cart</a> -->
                            <!-- <a href="#!" class="yello_dark">Buy Now</a> -->
                            <!-- <a href="<?= esc_url(add_query_arg(['add-to-cart' => $_product->get_id()], site_url('/cart/'))) ?>" class="direct_checkout yello_dark">Buy Now</a> -->
                            <button type="button" class="direct_checkout yello_dark">Buy Now</button>
                        </div>
                        <?php } ?>
                        <?php //} ?>
                        <div class="slice_right_shipment_box">
                            <div class="slice_right_shipment_text">
                                <p>Ships from</p>
                                <h5 class="clr_blk"><?= empty($metadeta['city'][0]) ? '---' : $metadeta['city'][0] ?></h5>
                            </div>
                            <div class="slice_right_shipment_text">
                                <p>Sold by</p>
                                <h5><?php $store_details = get_user_meta($post_author, 'store_details', true); echo empty($store_details['store_name']) ? '---' : $store_details['store_name'] ?></h5>
                            </div>
                            
                            <div class="slice_right_shipment_text">
                                <p>Payment</p>
                                <h5>Secure transaction</h5>
                            </div>
                            <div class="slice_right_shipment_text">
                                <p><a href="#">Return Policy</a></p>
                            </div>
                        </div>
                        <?php   if(!in_array('customer', wp_get_current_user()->roles) ){ ?>
                        <div class="slice_right_shipment_text">
                            <span>If you want to buy, register yourself as a customer or bussiness</span>
                        </div>
                        <?php } ?>
                        <!-- <div class="slice_right_check">
                            <input class="form-check-input" type="checkbox" value="" id="covering_check_010">
                            <label class="form-check-label" for="covering_check_010">Add a gift receipt for easy returns</label>
                        </div> -->
                        <!-- <div class="slice_right_lbtn">
                            <a href="#!" class="list_btn">Add to List</a>
                        </div> -->
                    </div>
                    <!-- <div class="slice_right_side_box_2">
                        <div class="slice_right_side_box_2_ttext">
                            <h6>Other seller on Amazon</h6>
                        </div>
                        <div class="slice_right_side_box_2_ltext">
                            <p>New <span>(6)</span> from</p>
                            <h6>$<span>22</span>99</h6>
                            <span><i class="fa-solid fa-chevron-right"></i></span>
                        </div>
                    </div> -->
                </div>
                
            </div>
        </div>
    </form>
</section>
<section class="products_second_holder">
    <div class="box_frame">
        <div class="stripe_1 cust_bdr">
            <div class="holder_5_slice_left">
                <div class="holder_2_slice_left_ttext">
                    <h6>CUSTOMERS ALSO BOUGHT</h6>
                    <p>Lorem ipsum odor amet consectetuer adipiscing elit nim tristique</p>
                </div>
                <div class="holder_2_slice_left_card">
                    <div class="holder_5_strip">
                        <?php
                        $ProductManage->check_sponsored_products_status();
                        function products_query($quantity){
                            $args = array(
                                'post_type'      => 'product',
                                'posts_per_page' => $quantity,
                                'post_status'    => 'publish',
                                'meta_query'     => [
                                    'relation' => 'OR',
                                    [
                                        'key'     => 'sponsored',
                                        'value'   => 'active',
                                        'compare' => '=', // Fetch sponsored products
                                    ],
                                    [
                                        'key'     => 'sponsored',
                                        'compare' => 'expired', // Fetch normal products if 'sponsored' meta key is missing
                                    ],
                                ],
                                'orderby'        => [
                                    'meta_value' => 'DESC', // Sponsored products appear first
                                    'date'       => 'DESC', // Sort by date within each group
                                ],
                                'meta_key'       => 'sponsored', // Required for 'meta_value' ordering
                            );
                            return new WP_Query( $args );
                        }
                        $the_query = products_query(5);
                        if ( $the_query->have_posts() ) {
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                // Get product object
                                $product = wc_get_product(get_the_ID());
                                // Get product price
                                $price = $product->get_price_html();
                                // Get average rating and number of reviews
                                $average_rating = $product->get_average_rating();
                                $review_count = $product->get_review_count();
                                $sponsored =  get_post_meta(get_the_ID(), 'sponsored', true);
                                ?>
                                <a href="<?php the_permalink(); ?>" class="info__block">
                                    <div class="info__block_img_block">
                                        <?php if (has_post_thumbnail()) { 
                                        the_post_thumbnail('medium'); 
                                        } else { ?>
                                            <img src="<?= get_stylesheet_directory_uri().'/frontend/assets/front/images/card_img_1.png'; ?>" alt="img">
                                        <?php } ?>                            
                                    </div>
                                    <div class="info__block_txt_block">
                                        <h3><?= get_the_title(); ?></h3>
                                        <div class="p-desc"><?= substr(get_the_excerpt(), 0,50); ?></div>
                                        <div class="grid_seprator">
                                            <h4><?= $price; ?></h4>
                                            <!-- <p>$799.55</p> -->
                                        </div>
                                        <div class="rating_stars">
                                            <ul>
                                                <?php for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $average_rating) { ?>
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                    <?php } else { ?>
                                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                                    <?php }
                                                } ?>
                                                <li><p><?= $review_count; ?> Reviews</p></li> <!-- Dynamic reviews -->
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            <?php  endwhile; 
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="products_third_holder">
    <?php
        $commentsrgs = array(
            'post_id' => $_product->get_id(), // ID of the post to get comments for
            'status'  => 'approve', // Get only approved comments
        );
        // Retrieve the comments based on the arguments
        $comments = get_comments($commentsrgs);
        // Initialize an array to count ratings
        $rating_counts = array_fill(1, 5, 0); // Keys: 1 to 5 (star ratings)
        // Process each comment to extract the rating
        foreach ($comments as $comment) {
            $rating = get_comment_meta($comment->comment_ID, 'rating', true); // Assuming the rating is stored in comment meta
            if ($rating >= 1 && $rating <= 5) {
                $rating_counts[$rating]++;
            }
        }
        // Calculate the total number of ratings
        $total_ratings = array_sum($rating_counts);
        // Calculate percentages for each star rating
        $rating_percentages = [];
        if ($total_ratings > 0) {
            foreach ($rating_counts as $stars => $count) {
                $rating_percentages[$stars] = ($count / $total_ratings) * 100;
            }
        }
    ?>
    <div class="box_frame">
        <div class="stripe_1 cust_bdr">
            <div class="holder_3_slice_left">
                <div class="holder_3_left_ratings">
                    <div class="holder_3_sleft_ttext">
                        <h6>CUSTOMERS REVIEWS</h6>
                        <?php
                            $rating_sum = 0;
                            foreach ($rating_counts as $stars => $count) {
                                $rating_sum += $stars * $count; // Multiply each star count by its value
                            }
                            $average_rating = $total_ratings > 0 ? $rating_sum / $total_ratings : 0;
                            // Calculate stars
                            $full_stars = floor($average_rating);
                            $half_star = ($average_rating - $full_stars) >= 0.5 ? 1 : 0;
                            $empty_stars = 5 - $full_stars - $half_star;
                        ?>
                        <span>
                            <ul>
                                <?php
                                echo str_repeat('<li><i class="fa-solid fa-star"></i></li>', $full_stars);
                                if ($half_star) echo '<li><i class="fa-solid fa-star-half-stroke"></i></li>';
                                echo str_repeat('<li><i class="fa-regular fa-star"></i></li>', $empty_stars);
                                ?>
                                <li><p><?php echo round($average_rating, 1); ?> out of 5</p></li>
                            </ul>
                        </span>
                        <p><?= number_format(count($comments)) ?> global ratings</p>
                    </div>
                    <div class="holder_3_slice_left_rating">
                        <?php for ($stars = 5; $stars >= 1; $stars--) { ?>
                            <div class="holder_3_item">
                                <p><?= $stars; ?></p>
                                <div class="item_rating">
                                    <span style="width: <?= isset($rating_percentages[$stars]) ? round($rating_percentages[$stars], 2) : 0; ?>%"></span>
                                </div>
                                <p><?= isset($rating_percentages[$stars]) ? round($rating_percentages[$stars], 2) : 0; ?>%</p>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- <div class="slice_mid_dropdown_3">
                        <span><i class="fa-solid fa-angle-down"></i></span>
                        <select name="form_ddown" id="form_dropdown_3">
                            <option value="" selected="" disabled="">How customer reviews and ratings work</option>
                        </select>
                    </div> -->
                </div>
                <div class="holder_3_review_box">
                    <h6>REVIEW THIS PRODUCT</h6>
                    <p>Share your thoughts with other customers</p>
                    <a href="#!" class="action_click" id="customer_review_btn">Write a customer review</a>
                </div>
                <div class="holder_3_review_form hidden" id="customer_review_form">
                    <form id="add_comment" class="review_demand_form">
                        <div class="form_strip_1">
                            <input type="text" name="name" placeholder="Enter Your Name">
                        </div>
                        <div class="form_strip_1">
                            <input type="email" name="email" placeholder="Enter Your Email">
                        </div>
                        <div class="form_strip_1">
                            <textarea name="comment" placeholder="Enter Your Review"></textarea>
                        </div>
                        <div class="form_rating_stripe">
                            <div class="form_strip_1">
                                <div class="form_main_flex upload_img">
                                    <label for="">Upload Image</label>
                                    <div class="file_upload_box">
                                        <a href="#!" class="add_click">
                                            <i class="fa-solid fa-file-image"></i>
                                        </a>
                                        <input type="file" name="review_image[]" class="file_input" multiple/>
                                    </div>
                                </div>
                            </div>
                            <div class="form_strip_1">
                                <div class="form_main_flex">
                                    <label for="">Rating</label>
                                    <div>
                                        <div class="star_rating_box" id="starRating">
                                            <i class="fa-solid fa-star" data-value="1"></i>
                                            <i class="fa-solid fa-star" data-value="2"></i>
                                            <i class="fa-solid fa-star" data-value="3"></i>
                                            <i class="fa-solid fa-star" data-value="4"></i>
                                            <i class="fa-solid fa-star" data-value="5"></i>
                                        </div>
                                        <input type="hidden" name="rating" id="ratingInput" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form_strip_1">
                            <div class="holder_from_slice_btn">
                                <input type="hidden" name="post_id" value="<?= $_product->get_id() ?>" class="c_post_id">
                                <input type="hidden" name="redirect_url" value="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']  ?>" class="c_post_id">
                                <input type="hidden" name="action" value="add_custom_comment">
                                <button class="action_click" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="holder_3_slice_right">
                <?php
                $customer_says = get_post_meta($_product->get_id(), 'customer_says', true);
                if($customer_says){ ?>
                <div class="holder_3_slice_right_ttext">
                    <h6>Customers say</h6>
                    <p><?= $customer_says ?></p>
                </div>
                <?php } 
                if (!empty($comments)) { 
                ?>
                <div class="holder_3_slice_right_comment">
                    <h6>TOP REVIEWS</h6>
                    <?php
                        foreach ($comments as $key => $value) {
                            $review_images = get_comment_meta($value->comment_ID, 'review_images', true);
                            $rating = get_comment_meta($value->comment_ID, 'rating', true);
                            // var_dump($review_images);
                    ?>
                    <div class="holder_3_comment_box">
                        <div class="holder_3_comment_img_flex">
                            <div class="comment_img">
                                <img src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/images/holder_3_comment_img1.png' ?>" class="img-fluid" alt="">
                            </div>
                            <h5><?= $value->comment_author  ?></h5>
                        </div>
                        <div class="holder_3_comment_taring_flex">
                            <div class="comment_rating_start">
                                <ul>
                                <?php for ($stars = 1; $stars <= 5; $stars++) { ?>
                                    <li><?= $stars <= $rating ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>' ?></li>
                                <?php } ?>
                                </ul>
                            </div>
                            <div class="comment_rating_text">
                                <!-- <p>Exceptional Gaming Headset: Comfort, Clarity, and Style at an Unbeatable Value</p> -->
                            </div>
                        </div>
                        <div class="holder_3_comment_para">
                            <p>Reviewed on <?= date('F j, Y', strtotime($value->comment_date))  ?></p>
                            <p><?= $value->comment_content ?></p>
                        </div>
                        <?php if($review_images) { ?>
                        <div class="holder_3_right_slider_box">
                            <div class="holder_3_right_slider">
                                <div class="swiper holder_3_slider">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($review_images as $image) {  ?>
                                        <div class="swiper-slide">
                                            <div class="holder_3_slider_img">
                                                <img src="<?= wp_get_attachment_image_url( $image ) ?>" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="holder_3_slider_nav_btn">
                                <div class="holder_3_btn_next">
                                    <i class="fa-solid fa-angle-right"></i>
                                </div>
                                <div class="holder_3_btn_prev">
                                    <i class="fa-solid fa-angle-left"></i>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <?php } else {
                    echo '<h6>No reviews yet</h6>';
                } ?>
                <div class="pagination">
                </div>
            </div>
        </div>
    </div>
</section>
<?php if($_product->description){ ?>
<section class="products_fourth_holder">
    <div class="box_frame">
        <div class="stripe_1 cust_bdr">
            <div class="holder_4_slice_right_text">
                <h6>Additional Description</h6>
                <div class="ql-editor"><?= $_product->description  ?></div>
            </div>
            <!-- <div class="holder_4_slice_left">
                <div class="holder_4_slice_left_box">
                    <div class="holder_4_slice_left_box_ttext">
                        <h6>Technical Details</h6>
                        <p>Consectetur volutpat euismod sodales lectus mattis</p>
                    </div>
                    <div class="holder_4_slice_left_box_flex">
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Headphones; Jack</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>3.5 mm Jack</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Model Name</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>G9000</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Connectivity Technology</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Wired</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Included Components</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Headphone</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Age Range (Description)</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Adult</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Material </p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Faux Leather, Metal</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Specific User For Product</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Gaming</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Recommended User For Product</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Calling, Gaming</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Compatible Devices</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>PS4, Xbox One, PS5, PC, NES, Mac</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Theme</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Video Game</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Control Type</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Volume Control</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Cable Feature</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Detachable</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Item Weight</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>0.6 Pounds</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Package Type</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>FFP (Flat Free Package) or Equivalent Amazon Certified Package</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Unit Count</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>1 Count</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Contril Method</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Touch</p>
                            </div>
                        </div>
                        <div class="holder_flex_box">
                            <div class="holder_4_slice_box_text_left">
                                <p>Audio Driver Type</p>
                            </div>
                            <div class="holder_4_slice_box_text_right">
                                <p>Dynamic Driver</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="holder_4_slice_right">
                <div class="holder_4_slice_left_box_ttext">
                    <h6>Additional Information</h6>
                    <p>Consectetur volutpat euismod sodales lectus mattis from this</p>
                </div>
                <div class="holder_4_slice_left_box_flex">
                    <div class="holder_flex_box">
                        <div class="holder_4_slice_right_flex">
                            <div class="holder_4_slice_flex_left">
                                <h6>Customer Reviews</h6>
                            </div>
                            <div class="holder_4_slice_flex_right">
                                <span>
                                    <p>4.3 out of 5</p>
                                    <ul>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                    </ul>
                                    <p class="cust_clr_gren">107,433 ratings</p>
                                </span>
                                <span>
                                    <p>4.3 out of 5</p>
                                </span>
                            </div>
                        </div>
                    </div>    
                    <div class="holder_flex_box">
                        <div class="holder_4_slice_right_flex">
                            <div class="holder_4_slice_flex_left">
                                <h6>Best Seller Rank</h6>
                            </div>
                            <div class="holder_4_slice_flex_right">
                                <span>
                                    <p>#22 in Video Games (See Top 100 in Video Games)</p>
                                </span>
                                <span>
                                    <p>#1 in PC Game Headsets</p>
                                </span>
                                <span>
                                    <p>#1 in Xbox One Headsets</p>
                                </span>
                                <span>
                                    <p>#1 in PlayStation 4 Headsets</p>
                                </span>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="holder_4_slice_right_text">
                    <h6>Warranty & Support</h6>
                    <p>Lorem ipsum odor amet, consectetuer adipiscing elit. Enim tristique curabitur mus duis tincidunt platea montes. Curabitur commodo tortor eu id parturient lobortis. Sem litora vulputate tortor cubilia pharetra, suscipit sed rhoncus. Maximus tellus finibus tempor duis litora. Cursus malesuada class est magna aliquet quam platea ante. Ante odio montes ligula pulvinar primis tellus Habitant pharetra aliquet urna interdum.</p>
                    <p><span>Product Warranty:</span> For warranty information about this product, please click here</p>
                </div>
                <div class="holder_4_slice_right_text">
                    <h6>Feedback</h6>
                    <p>Would you like to <span class="cust_clr_gren">tell us about a lower price?</span> </p>
                </div>
            </div> -->
        </div>
    </div>
</section>
<?php } ?>
<section class="products_fifth_holder">
    <div class="box_frame">
        <div class="stripe_1 cust_bdr">
            <div class="holder_5_slice_left">
                <div class="holder_2_slice_left_ttext">
                    <h6>CUSTOMERS ALSO BOUGHT</h6>
                    <p>Lorem ipsum odor amet consectetuer adipiscing elit nim tristique</p>
                </div>
                <div class="holder_2_slice_left_card">
                    <div class="holder_5_strip">
                        <?php
                        $ProductManage->check_sponsored_products_status();
                        $the_query = products_query(5);
                        if ( $the_query->have_posts() ) {
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                // Get product object
                                $product = wc_get_product(get_the_ID());
                                // Get product price
                                $price = $product->get_price_html();
                                // Get average rating and number of reviews
                                $average_rating = $product->get_average_rating();
                                $review_count = $product->get_review_count();
                                $sponsored =  get_post_meta(get_the_ID(), 'sponsored', true);
                                ?>
                                <a href="<?php the_permalink(); ?>" class="info__block">
                                    <div class="info__block_img_block">
                                        <?php if (has_post_thumbnail()) { 
                                        the_post_thumbnail('medium'); 
                                        } else { ?>
                                            <img src="<?= get_stylesheet_directory_uri().'/frontend/assets/front/images/card_img_1.png'; ?>" alt="img">
                                        <?php } ?>                            
                                    </div>
                                    <div class="info__block_txt_block">
                                        <h3><?= get_the_title(); ?></h3>
                                        <div class="p-desc"><?= substr(get_the_excerpt(), 0,50); ?></div>
                                        <div class="grid_seprator">
                                            <h4><?= $price; ?></h4>
                                            <!-- <p>$799.55</p> -->
                                        </div>
                                        <div class="rating_stars">
                                            <ul>
                                                <?php for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $average_rating) { ?>
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                    <?php } else { ?>
                                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                                    <?php }
                                                } ?>
                                                <li><p><?= $review_count; ?> Reviews</p></li> <!-- Dynamic reviews -->
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            <?php  endwhile; 
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="footer_wrapper section"></footer>
<!-- <script src="assets/front/js/jquery-3.6.3.min.js"></script> -->
<!-- <script src="assets/front/js/custom.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>

    $(document).ready(function() {
        var userRoles = <?php echo json_encode(wp_get_current_user()->roles); ?>;
        var made_to_order = "<?= !empty($metadeta['made_to_order'][0]) ? $metadeta['made_to_order'][0] : '' ?>";
        // console.log(made_to_order);
        if(made_to_order == 'made_to_order'){
            $('.slice_right_stock p').text('Made to order');
        }
        
        $("#customer_review_btn").click(function() {
            $("#customer_review_form").toggleClass("show hidden");
        });

        $("#holder_3_slice_ddown_1").click(function(){
            $("#holder_3_slice_ddown_2").toggleClass("show");
        });

        // add comments // 
        jQuery("#add_comment").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
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
                        if (response.auto_redirect) {window.location.href = response.redirect_url;}
						else{ 
							Swal.fire({
								title: response.title,
								text:  response.message,
								icon: response.icon,
							}).then((willDelete) => {
							  if (response.redirect_url) {window.location.href = response.redirect_url;}
							}); 
						}
                    } 
                },
                error : function(errorThrown){
                    console.log(errorThrown);
                    jQuery('body').waitMe('hide');
                }
            });
        }); 

        $(document).on("click", ".single_add_to_cart_button, .direct_checkout", function(e) {
            // alert();
            if (userRoles.length === 0) {
                // If userRoles array is empty (not logged in)
                alert("Please log in to continue.");
                e.preventDefault();

            } else if (userRoles.includes("administrator") || userRoles.includes("vendor")) {
                // If the user is admin or vendor
                alert("If you want to buy, register yourself as a customer or business.");
                e.preventDefault();
            }

        });   

        $(document).on("click", ".direct_checkout", function (e) {
            // e.preventDefault(); // Prevent default action of the button if it’s a link

            // Trigger the add-to-cart button click
            $(".single_add_to_cart_button").click();

            // Delay the redirect to ensure the product is added to the cart
            setTimeout(function() {
                window.location.href = '<?= home_url("cart") ?>';
            }, 1000); // Adjust the delay (e.g., 1000ms) based on your site's responsiveness
            });


        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            // loop: true,
            freeMode: true,
            watchSlidesProgress: true,
            direction: 'vertical', 
            allowTouchMove: false,
            });
            var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });

        var swiper = new Swiper(".holder_3_slider", {
            slidesPerView: 4,
            spaceBetween: 10,
            loop: true,
            breakpoints: {
                1400: {
                    slidesPerView: 4,
                    spaceBetweenSlides: 10
                },
                992: {
                    slidesPerView: 3,
                    spaceBetweenSlides: 10
                },
                767: {
                    slidesPerView: 2,
                    spaceBetweenSlides: 20
                },
                375: {
                    slidesPerView: 1,
                    spaceBetweenSlides: 10
                }
            },
            navigation: {
                nextEl: ".holder_3_btn_next",
                prevEl: ".holder_3_btn_prev",
            },
        });

    });
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#starRating i');
        const ratingInput = document.getElementById('ratingInput');
        console.log("stars-->", stars);
        console.log("ratingInput-->", ratingInput);
        stars.forEach(star => {
            star.addEventListener('click', function () {
                const value = parseInt(this.getAttribute('data-value'));
                console.log("value-->", value);
                ratingInput.value = value;
                // Update the visual appearance of the stars
                stars.forEach(star => {
                    star.classList.remove('active');
                    if (parseInt(star.getAttribute('data-value')) <= value) {
                        star.classList.add('active');
                    }
                });
            });
        });
    });
    const addClickButtons = document.querySelectorAll('.add_click');
    const fileInputs = document.querySelectorAll('.file_input');
    addClickButtons.forEach((addButton, index) => {
        addButton.addEventListener('click', function () {
            fileInputs[index].click();
        });
    });
</script>
</body>
<?php get_footer() ?>
