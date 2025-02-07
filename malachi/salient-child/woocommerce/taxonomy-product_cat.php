<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header(); 

// var_dump(get_queried_object());
// var_dump($products_query->posts);

// exit;

// $ProductManage->check_sponsored_products_status();
// var_dump($ProductManage->check_sponsored_products_status());
?>
   
<?php 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<!-- <link rel="stylesheet" href="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/css/all.css' ?>"> -->
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/css/main.css' ?>">
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/css/responsive.css' ?>">

<style>

    .product_type_box{
        display: none;
    }
    .box_seprator.sc.sub_child {
        padding-left: 20px;
    }
    a.side_tab_item.grand.child-category-link {
        /* padding-top: 15px;
        padding-bottom: 10px; */
    }
    .topParent a.side_tab_item.grand:after {
        content: "\f107" !important;
        font-family: 'FontAwesome';
        float: right;
    }
    a.side_tab_item.grand:after {
        transform: rotate(0deg);
    }
    /* .topParent .grand {
        font-weight: bold;
    } */
    button.rating {
        font-family: var(--akira-bold) !important;
        font-size: 18px;
        color: #000;
        margin-bottom: 10px;
        cursor: pointer;
        position: relative;
        border: 0;
        background: transparent;
    }
    .box_seprator.topParent.sub_child {
        font-weight: bold;
    }
    .box_seprator.sc.sub_child {
        margin-left: 15px;
    }

    .hh.child-category-link:before {
        content: "\f107" !important;
        font-family: 'FontAwesome';
        float: right;
    }

    .hh.child-category-link.open:before {
        transform: rotate(180deg);
    }

    .toggleButton {
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #084025;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .toggleButton:hover {
        background-color: #328d50;
    }

    /* .childParent{
        margin-left: 12px;
    }

    .categorySubChild {
        margin-left: 25px;
    } */

    .category_box.sub_material_box {
        margin-bottom: 0;
        padding: 0px 0px 10px 0px;
        border: 0;
        /* margin-top: -15px; */
    }

    /* .categoryParent:after  {
        content: "\f101" !important;
        font-family: 'FontAwesome';
        float: right;
    } */
    /* .firstParent:before {
        content: "\f101" !important;
        font-family: 'FontAwesome';
        float: right;
    } */

    .categoryParent span {
        font-size: 15px !important;
        font-weight: bold
    }

    .clear-filter {
        /* position: absolute;
        left: 415px; */
        float: right;
    }

    .clear-filter button {
        width: 100%;
        height: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: var(--avantGarde-medium) !important;
        font-size: 11px;
        color: #084025;
        background: #ffffff;
        transition: all 0.25s;
        border: 2px solid #084025;
        border-radius: 30px;
        padding: 5px;
        cursor: pointer;
    }

    .rate {

        float: inline-start;
    }

    .categoryChild:after {
        content: "\f107" !important;
        font-family: 'FontAwesome';
        float: right;
    }

    .rate:not(:checked) > input {
        /* position:absolute;
        top:-9999px; */
        display: none;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px !important;
        color:#ccc !important;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked ~ label {
        color: #ffc700 !important;    
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217 !important;  
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08 !important;
    }


    /* width */
    ::-webkit-scrollbar {
    width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
    background: #f1f1f1; 
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
    background: #888; 
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
    background: #555; 
    }

    ul.products.columns-3 a {
        margin-left: 10px;
    }

    .info__block {
        max-width: 245px;
    }

    ul.products a:hover{
        background: #084025;
    }

    ul.products a:hover p, ul.products a:hover h3 , ul.products a:hover h4 {
        color: white;
    }

    .sub_child_category_box {
        margin-left: 15px;
        margin-top: 0px;
    }

    .woocommerce .products ul, .woocommerce ul.products {
        margin: 0;
    }

    h2.products_first_holder_note_lite {
        line-height: 50px;
    }

    button.cat-heading {
        font-family: var(--akira-bold) !important;
        font-size: 18px;
        color: #000;
        margin-bottom: 10px;
        cursor: pointer;
        position: relative;
        border: 0;
        background: transparent;
        padding-left: 16px;
    }

    .category_box.product_category {
        max-height: 500px;
        overflow-y: scroll;
    }

    .category_box_heading:after {
        transform: rotate(180deg);
    }

    .category_box_heading.boxParent:after {
        transform: rotate(0deg);
    }

</style>

<!-- <section class="products_top_holder">
    <div class="box_frame">
        <div class="products_top_holder_txt">
            <h1 class="products_top_holder_note">OUR</h1>
            <h2 class="products_top_holder_note_lite">PRODUCTS</h2>
        </div>

        <div class="pic_frame">
            <img src="<?= get_stylesheet_directory_uri(  ). '/frontend/assets/front/images/sclupture_img.png' ?>" alt="img" class="">
        </div>
    </div>
</section> -->


<section class="products_first_holder">
    <div class="box_frame">
        <div class="products_first_holder_upper_txt">
            <h2 class="products_first_holder_note_lite">Best Of Our 3D <br> <?= single_cat_title(); ?></h2>
        </div>

        <div class="stripe">
            <aside class="slice_side_left">

                <div class="category_box product_type_box">
                    <button class="category_box_heading">Product Type</button>

                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <input class="inp-cbx product_type filter creations" id="654" data-filter="product_type" name="product_type" value="creations" type="radio">
                            <label class="cbx" for="654"><span>
                                    <svg width="12px" height="10px">

                                    </svg></span><span>Creation</span></label>
                            <svg class="inline-svg">
                                <symbol id="check-1" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </symbol>
                            </svg>
                        </div>
                    </div>

                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <input class="inp-cbx product_type filter services" id="674" data-filter="product_type" name="product_type" value="services" type="radio">
                            <label class="cbx" for="674"><span>
                                    <svg width="12px" height="10px">

                                    </svg></span><span>Services</span></label>
                            <svg class="inline-svg">
                                <symbol id="check-2" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </symbol>
                            </svg>
                        </div>
                    </div>

                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <input class="inp-cbx product_type filter stl-library" id="716"  data-filter="product_type" name="product_type" value="stl-library" type="radio">
                            <label class="cbx" for="716"><span>
                                    <svg width="12px" height="10px">

                                    </svg></span><span>STL File</span></label>
                            <svg class="inline-svg">
                                <symbol id="check-3" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </symbol>
                            </svg>
                        </div>
                    </div>

                </div>

                <div class="category_box product_category">
                    <button class="category_box_heading cat-heading">Categories</button>
                    <?php 
                    $main_term = get_queried_object();

                    $args_query = array(
                        'taxonomy' => 'product_cat', 
                        'hide_empty' => false, 
                        'child_of' => $main_term->parent
                    );
                    $query = get_terms( $args_query );
                    $grand_parent_term = get_term($main_term->parent,'product_cat'); 
                    $child_terms_ids = get_term_children( $main_term->term_id, 'product_cat' ); 
                  
                    ?>

                    <div class="category_box sub_category_box">
                        <div class="box_seprator sub_child">
                            <div class="checkbox-wrapper-4 categoryParent">
                                <input class="inp-cbx filter <?= esc_html($main_term->slug); ?>" id="<?= esc_attr($main_term->term_id); ?>" data-filter="category" value="<?= esc_html($main_term->slug); ?>" type="checkbox">
                                <label class="cbx" for="<?= esc_attr($main_term->term_id); ?>"><span>
                                        <svg width="12px" height="10px">

                                        </svg></span><span><?= esc_html($main_term->name); ?></span></label>
                                <svg class="inline-svg">
                                    <symbol id="check-1" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </symbol>
                                </svg>
                            </div>
                            <div class="sub_child_category_box">

                                <?php //foreach ( $query as $child ) { 
                                foreach ( $child_terms_ids as $child_term_id  ) {
                                    $child = get_term_by( 'term_id', $child_term_id , 'product_cat' );
                                  // var_dump($child);  
                                    ?>                        
                
                                    <div class="checkbox-wrapper-4">
                                        <input class="inp-cbx filter <?= esc_html($child->slug); ?>" id="<?= esc_attr($child->term_id); ?>" data-filter="category"  value="<?= esc_html($child->slug); ?>" type="checkbox">
                                        <label class="cbx" for="<?= esc_attr($child->term_id); ?>"><span>
                                                <svg width="12px" height="10px">

                                                </svg></span><span><?= esc_html($child->name); ?></span></label>
                                        <svg class="inline-svg">
                                            <symbol id="check-1" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </symbol>
                                        </svg>
                                    </div>
                                                        
                                <?php }  ?>
                            </div>
                        </div>
                    </div>
                
                </div>

                <div class="category_box location">
                    <button class="category_box_heading">Location</button>

                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <!-- <input class="inp-cbx" id="loc_3" type="checkbox"> -->
                            <label class="cbx" for="loc_3">
                                <!-- <span>
                                    <svg width="12px" height="10px">
                                    </svg>
                                </span> -->
                               <input type="text" data-filter="country" name="country" placeholder="Country" class="zip_input">
                            </label>
                            <!-- <svg class="inline-svg">
                                <symbol id="loc-1" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </symbol>
                            </svg> -->
                        </div>
                    </div>
                   
                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <!-- <input class="inp-cbx" id="loc_3" type="checkbox"> -->
                            <label class="cbx" for="loc_3">
                                <!-- <span>
                                    <svg width="12px" height="10px">
                                    </svg>
                                </span> -->
                               <input type="text" data-filter="state" name="state" placeholder="State" class="zip_input">
                            </label>
                            <!-- <svg class="inline-svg">
                                <symbol id="loc-1" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </symbol>
                            </svg> -->
                        </div>
                    </div>

                   
                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <!-- <input class="inp-cbx" id="loc_3" type="checkbox"> -->
                            <label class="cbx" for="loc_3">
                                <!-- <span>
                                    <svg width="12px" height="10px">
                                    </svg>
                                </span> -->
                                <input type="text" data-filter="city_zip" name="city" placeholder="City" class="zip_input">
                            </label>
                            <!-- <svg class="inline-svg">
                                <symbol id="loc-1" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </symbol>
                            </svg> -->
                        </div>
                    </div>
                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <!-- <input class="inp-cbx" id="loc_3" type="checkbox"> -->
                            <label class="cbx" for="loc_3">
                                <!-- <span>
                                    <svg width="12px" height="10px">
                                    </svg>
                                </span> -->
                                <input type="text" data-filter="zip_code" name="zip_code" placeholder="Zip Code" class="zip_input">
                            </label>
                            <!-- <svg class="inline-svg">
                                <symbol id="loc-1" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </symbol>
                            </svg> -->
                        </div>
                    </div>
                </div>

                <div class="category_box ratingParent">
                    <button class="category_box_heading rating ">Ratings</button>
                    <div class="box_seprator rating_stars rate">
                        <?php for($i=5; $i >= 1; $i--){ ?>
                            <input id="<?= $i ?>" name="rate" type="radio" value="<?= $i ?>" <?= ($i == $rating) ? 'checked' : '' ?> />
                            <label for="<?= $i ?>" class="review-rating" title="Rating"><?= $i ?> star</label>
                        <?php  } ?>
                    </div>

                    <!-- <div class="rating_stars">
                        <ul>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                             <li>
                                <p>and up</p>
                            </li> 
                        </ul>
                    </div> -->
                </div>

                <div class="category_box">
                    <button class="category_box_heading">Shipping</button>

                    <?php
                        $taxonomy = wc_attribute_taxonomy_name('shipping');
                        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]); 
                        foreach ($terms as $term) { ?>
                        <div class="box_seprator">
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx filter" value="<?= $term->slug ?>" data-filter="shipping" id="<?= $term->slug ?>" type="checkbox">
                                <label class="cbx" for="<?= $term->slug ?>"><span>
                                        <svg width="12px" height="10px">
                                        </svg></span><span><?= $term->name ?></span></label>
                                <svg class="inline-svg">
                                    <symbol id="loc-1" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </symbol>
                                </svg>
                            </div>
                        </div>
                    <?php }  ?>
                   
                </div>

                <div class="category_box properties_box">
                    <button class="category_box_heading">Properties</button>
                    <?php
                        $taxonomy = wc_attribute_taxonomy_name('properties');
                        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]); 
                        foreach ($terms as $term) { ?>
                        <div class="box_seprator">
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx filter" value="<?= $term->slug ?>" data-filter="properties" id="<?= $term->slug ?>" type="checkbox">
                                <label class="cbx" for="<?= $term->slug ?>"><span>
                                        <svg width="12px" height="10px">
                                        </svg></span><span><?= $term->name ?></span></label>
                                <svg class="inline-svg">
                                    <symbol id="loc-1" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </symbol>
                                </svg>
                            </div>
                        </div>
                    <?php }  ?>
                    
                </div>  
                
                <div class="category_box materials_box">
                    <button class="category_box_heading">Materials</button>
                    <?php
                        // Fetch top-level parents
                        $args = array('taxonomy' => 'materials', 'parent' => 0, 'hide_empty' => false);
                        $parents = get_terms($args);
                    ?>
                    <div class="category_box sub_material_box">

                        <?php foreach ($parents as $parent) { ?>
                            <div class="box_seprator topParent sub_child">
                                <a href="javascript:void(0);" data-id="<?= $parent->term_id  ?>" class="side_tab_item grand child-category-link"><?= $parent->name  ?></a>
                            
                                <?php
                                // Fetch first-level children
                                $args['parent'] = $parent->term_id;
                                $children = get_terms($args);
                                foreach ($children as $child) { ?>
                                    <div class="box_seprator sc sub_child" style="display: none;">
                                        <div class="checkbox-wrapper-4 hh child-category-link">
                                            <!-- Generate a unique ID for the child checkbox -->
                                            <input class="inp-cbx filter <?= esc_html($child->slug); ?>" 
                                                   data-filter="category" 
                                                   id="child-<?= esc_html($child->term_id); ?>" 
                                                   value="<?= esc_html($child->slug); ?>" 
                                                   type="checkbox">
                                            <label class="cbx" for="child-<?= esc_html($child->term_id); ?>">
                                                <span>
                                                    <svg width="12px" height="10px"></svg>
                                                </span>
                                                <span><?= esc_html($child->name); ?></span>
                                            </label>
                                            <svg class="inline-svg">
                                                <symbol id="check-1" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </symbol>
                                            </svg>
                                        </div>
                                        <!-- First-level Child -->
                                        <div class="sub_child_category_box" style="display: none;">
                                            <?php
                                            // Fetch second-level children
                                            $args['parent'] = $child->term_id;
                                            $sub_children = get_terms($args);
                                
                                            if (!empty($sub_children)) {
                                                foreach ($sub_children as $subchild) { ?>
                                                    <!-- Second-level Child -->
                                                    <div class="checkbox-wrapper-4 categorySubChild">
                                                        <!-- Generate a unique ID for the sub-child checkbox -->
                                                        <input class="inp-cbx filter <?= esc_html($subchild->slug); ?>" 
                                                               data-filter="category" 
                                                               id="subchild-<?= esc_html($subchild->term_id); ?>" 
                                                               value="<?= esc_html($subchild->slug); ?>" 
                                                               type="checkbox">
                                                        <label class="cbx" for="subchild-<?= esc_html($subchild->term_id); ?>">
                                                            <span>
                                                                <svg width="12px" height="10px"></svg>
                                                            </span>
                                                            <span><?= esc_html($subchild->name); ?></span>
                                                        </label>
                                                        <svg class="inline-svg">
                                                            <symbol id="check-1" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </symbol>
                                                        </svg>
                                                    </div>
                                                <?php }
                                            } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </aside>

            <div class="slice_side_right">
                <?php 
                if($grand_parent_term->slug != 'creations') { ?>
                <a href="<?= $grand_parent_term->slug == 'stl-library' ? home_url('add-new-request/?type=print-on-demand') : home_url('add-new-request/?type=service-on-demand') ?>" class="action_click"><?= $grand_parent_term->slug == 'stl-library' ? 'Print on Demand' : 'Service on Demand' ?></a>
                <?php } ?>
                <div class="grid__strip">
                    <?php
                    // Set number of products per page for WooCommerce's default query

                    // if (have_posts()) {
                    //     woocommerce_product_loop_start();

                    //     while (have_posts()) {
                    //         the_post(); 
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            // Get product object
                            $product = wc_get_product(get_the_ID());

                            // Get product price
                            $price = $product->get_price_html();

                            // Get average rating and number of reviews
                            $average_rating = $product->get_average_rating();
                            $review_count = $product->get_review_count();
                            $categories = wc_get_product_category_list($product->get_id());
                            $sponsored =  get_post_meta(get_the_ID(), 'sponsored', true);
                            $author_id = get_post_field('post_author', $product->get_id()); // Get the author ID
                            // $author_name = get_the_author_meta('display_name', $author_id); // Get the author's display name
                            $author_name = get_user_meta($author_id, 'store_details', true);
                            $categories = wc_get_product_category_list($product->get_id());
                            // var_dump($categories);

                            ?>
                            <a href="<?php the_permalink(); ?>" class="info__block">
                                <?php if($sponsored == 'active'){ ?>
                                    <div class="sponsored">
                                        <p>HOT</p>
                                    </div>
                                <?php } ?>
                                <div class="info__block_img_block">
                                    <?php if (has_post_thumbnail()) { 
                                    the_post_thumbnail('medium'); 
                                    } else { ?>
                                        <img src="<?= get_stylesheet_directory_uri().'/frontend/assets/front/images/card_img_1.png'; ?>" alt="img">
                                    <?php } ?>                            
                                </div>
                                <div class="info__block_txt_block">
                                    <!-- <p class="categories"><?= strip_tags($categories) ?></p> -->
                                    <h3><?= get_the_title(); ?></h3>
                                    

                                    <div class="p-desc"><?= substr(wp_strip_all_tags(get_the_excerpt()), 0,50); ?></div>

                                    <div class="grid_seprator">
                                        <h4><?= $price; ?></h4>                                       
                                        <!-- <p>$799.55</p> -->
                                    </div>
                                    <p class="author" > Shop: <span class="author-link" data-author="<?= home_url('store-profile?id=' . $author_id) ?>"><?=   !empty($author_name['store_name']) ? $author_name['store_name'] : '---' ?></span></p>

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
                        <?php }
                        // woocommerce_product_loop_end();
   
                        
                    } else {
                        echo '<p class="p_not_found">No products found.</p>';
                    }
                    ?>
                </div>
                <!-- <a href="<?= home_url('shop') ?>" class="view_all_click">View All Products</a> -->
            </div>

        </div>

    </div>
</section>

<script>

    jQuery(document).ready(function(){

        // jQuery('.inp-cbx.product_type').first().trigger('click');

        // jQuery('.child-category-link').click(function(){
        //     jQuery('.sub_child_category_box').slideUp();
        //     jQuery(this).parents('.sub_child').find('.sub_child_category_box').show();
        //     if( jQuery(this).next('.sub_child_category_box').attr("style") == 'display:block'){
        //         jQuery(this).parents('.sub_child').find('.sub_child_category_box').slideUp();
        //     }

        // });

        // jQuery('.child-category-link').click(function(){
        //     if(jQuery(this).hasClass('open')){
        //         jQuery(this).parents('.sub_child').find('.sub_child_category_box').slideUp();
        //         jQuery(this).removeClass('open');
        //         return false;
        //     }
        //     jQuery('.sub_child_category_box').slideUp();
        //     jQuery(this).parents('.sub_child').find('.sub_child_category_box').show();
        //     jQuery('.child-category-link').removeClass('open');
        //     jQuery(this).addClass('open');

        // });

        jQuery('.sc .child-category-link').click(function(e){

            if(jQuery(this).hasClass('open')){
                jQuery(this).parent('.sub_child').find('.sub_child_category_box').slideUp();
                jQuery(this).removeClass('open');
                
            } else {
            jQuery('.sc .sub_child_category_box').slideUp();
            jQuery(this).parent('.sub_child').find('.sub_child_category_box').show();
            jQuery('.child-category-link').removeClass('open');
            jQuery(this).addClass('open');
            }
            var parentCheckbox = jQuery(this).next('.checkbox-wrapper-4 input[type="checkbox"]');

            jQuery(this).prop('checked', !jQuery(this).prop('checked'));
            return false;
        });

       


       
        jQuery('.grand').click(function(){
            jQuery('.sc.sub_child').slideUp();
            jQuery(this).parents('.sub_child').find('.sc.sub_child').show();
        
        });

        

        // const categoryTitles = document.querySelectorAll('.category_box_heading');

        // categoryTitles.forEach(function (categoryTitle) {
        //     const separators = categoryTitle.parentElement.querySelectorAll('.box_seprator');
        //     separators.forEach(function (sep) {
        //         sep.style.display = 'block';
        //     });

        //     categoryTitle.addEventListener('click', function () {
        //         categoryTitle.classList.toggle('open');

        //         separators.forEach(function (sep) {
                
        //             if (sep.style.display === 'none') {
        //                 sep.style.display = 'block';
        //             } else {
        //                 sep.style.display = 'none';
        //             }
        //         });
        //     });
        // });

        jQuery('.category_box_heading').click(function(e){
            if( jQuery(this).hasClass('boxParent')){
                jQuery(this).removeClass('boxParent');
                return false;
            }
            jQuery('.category_box_heading').removeClass('boxParent');
            jQuery(this).addClass('boxParent');

        }); 

        jQuery('.category_box_heading').click(function(e){

            if( jQuery(this).closest('.category_box').find('.box_seprator').attr("style") == 'display: none;'){
               
                jQuery(this).closest('.category_box').find('.box_seprator').show();
                jQuery(this).closest('.category_box').find('.toggleButton').show();
                jQuery('.category_box.properties_box .box_seprator:nth-child(n+8)').hide();
                return false;
            }

            // console.log(jQuery(this).closest('.category_box').find('.box_seprator'));
            jQuery(this).closest('.category_box').find('.box_seprator').hide();
            jQuery(this).closest('.category_box').find('.toggleButton').hide();


        });

        document.querySelectorAll('.child').forEach(function(element) {
            element.style.display = 'none';
        });

        var filters = {
            category: [],
            properties: [],
            materials: [],
            rating: [],
            product_type: [],
            state: [],
            city: [],
            zip_code: []
        };



        // jQuery(document).on('change', '.product_type', function(){

        //   //  jQuery('.sub_category_box').hide();
        //   alert();

        //     // Clear all filter arrays
        //     Object.keys(filters).forEach(key => filters[key] = []);

        //     id = jQuery(this).attr('id');
        //     if(jQuery(this).is(':checked')){
        //         jQuery('.'+id).show();
        //     } else {
        //         jQuery('.'+id).hide();
        //     }
        // });

        // alert();

        jQuery(document).on('change', '.filter', function(e){
            const filterType = jQuery(this).data('filter');
            filters[filterType] = [];
            // filters['category'] = []; 
            jQuery(`.filter[data-filter="${filterType}"]:checked`).each(function() {
                filters[filterType].push(jQuery(this).val());
            });
            // alert();
            the_search_func(e, 1);
			
        });

        // alert();

        jQuery(document).on('change', 'input[name="city"] , input[name="state"], input[name="zip_code"]', function(e){
            const filterType = jQuery(this).data('filter');
            filters[filterType] = [];
            if(jQuery(this).val()){
                filters[filterType].push(jQuery(this).val());
            }
            the_search_func(e, 1);
        });

        jQuery(document).on('change', 'input[name="rate"]', function(e){
            filters['rating'] = []; 
            jQuery('.rating_stars').find('input[type=radio]:checked').each(function() {
                filters['rating'].push(jQuery(this).val());
            });
            the_search_func(e, 1);
            jQuery('.clear-filter').remove();
            jQuery('.rate').prepend('<div class="clear-filter"><button type="button">Clear</button></div>');
          	
        });

        jQuery(document).on('click', '.clear-filter', function(e){
            jQuery('.rating_stars').find('input[type=radio]').prop('checked', false);
            jQuery('.clear-filter').remove();
            filters['rating'] = []; 
            the_search_func(e, 1);
        });

        function the_search_func(e,page=1) {

            let parent_cat = "<?= $main_term->slug  ?>";
          

            jQuery('.slice_side_right').waitMe({
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
                 url: ajax_script.ajax_url,
                 data: { 
                    action:"product_filter", 
                    paged: page, 
                    search_filters: filters,
                    parent_cat: parent_cat
                },
                 dataType : 'json',
                 success: function (response) {
                     jQuery('.slice_side_right').waitMe('hide');
                    // console.log(response);
                     jQuery(".grid__strip").html(response.html);
                     jQuery(".found_result").text(response.foundResults);
                     jQuery('.pagination').html(response.pagination);
 
                 },
                 error : function(errorThrown){
                     jQuery('.slice_side_right').waitMe('hide');
                     console.log(errorThrown);
                 }
             });
        }

        jQuery('.properties_box').append('<button  class="toggleButton show-more">Show More</button>');
        const toggleButton = jQuery('.toggleButton');
      
        // Hide items initially
        jQuery('.category_box.properties_box .box_seprator:nth-child(n+8)').hide();

        // Add click event to each button
        jQuery('.toggleButton').click(function () {
            const parentContainer = jQuery(this).closest('.category_box'); // Identify the parent category
            let hiddenItems;

           if (parentContainer.hasClass('properties_box')) {
                hiddenItems = parentContainer.find('.box_seprator:nth-child(n+8)');
            }

            // Toggle visibility and button text
            if (hiddenItems) {
                hiddenItems.toggle();
                const isHidden = hiddenItems.is(':hidden');
                jQuery(this).text(isHidden ? 'Show More' : 'Show Less');
            }
        });

        jQuery('.categoryParent .filter').click();

        // let category = "<?= $grand_parent_term->slug  ?>";
        // alert('.filter.'+category);
        // jQuery('.filter.'+category).click();

        


        const sliderTrack = document.querySelector('.slider-track');
        const sliderThumb = document.getElementById('sliderThumb');
        const sliderValue = document.getElementById('sliderValue');
        const defaultValue = 50;
        let isDragging = false;

        function updateSlider(value) {
            const trackWidth = sliderTrack.offsetWidth;
            const thumbWidth = sliderThumb.offsetWidth;

            const offsetX = (value / 100) * (trackWidth - thumbWidth);
            sliderThumb.style.left = `${offsetX}px`;
            sliderValue.textContent = value;
        }

        updateSlider(defaultValue);

        sliderThumb.addEventListener('mousedown', (e) => {
            isDragging = true;
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;

            const rect = sliderTrack.getBoundingClientRect();
            let offsetX = e.clientX - rect.left;
            const thumbWidth = sliderThumb.offsetWidth;
            const trackWidth = rect.width;

            // Clamp the offset to the track width
            offsetX = Math.max(0, Math.min(offsetX, trackWidth - thumbWidth));

            const value = Math.round((offsetX / (trackWidth - thumbWidth)) * 100);
            sliderThumb.style.left = `${offsetX}px`;
            sliderValue.textContent = value;
        });

        sliderTrack.addEventListener('click', (e) => {
            const rect = sliderTrack.getBoundingClientRect();
            let offsetX = e.clientX - rect.left;
            const thumbWidth = sliderThumb.offsetWidth;
            const trackWidth = rect.width;

            offsetX = Math.max(0, Math.min(offsetX, trackWidth - thumbWidth));
            const value = Math.round((offsetX / (trackWidth - thumbWidth)) * 100);
            sliderThumb.style.left = `${offsetX}px`;
            sliderValue.textContent = value;
        });

    });


</script>

<?php get_footer(); ?>
