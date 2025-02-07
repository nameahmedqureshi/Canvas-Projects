<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
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
    /* .topParent .grand {
        font-weight: bold;
    } */

    .box_seprator.topParent.sub_child {
        font-weight: bold;
    }
    /* .box_seprator.sc.sub_child {
        margin-left: 15px;
    } */

    .checkbox-wrapper-4.testClass {
        margin-left: 20px;
    }

    .category_box.sub_material_box {
        margin-bottom: 0;
        padding: 0px 25px 10px 0px;
        border: 0;
        /* margin-top: -15px; */
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
    /* .category_box.sub_category_box .sub_child:nth-child(n+9){
        display: none;
    } */

    /* .child-category-link:before {
        content: "\f107" !important;
        font-family: 'FontAwesome';
        float: right;
    }

    .child-category-link.open:before {
        transform: rotate(180deg);
    } */
    /* .category_box.product_category {
        padding: 30px 20px;
        border: unset;
        border-left: 1px solid #e1e1e1;
        border-right: 1px solid #e1e1e1;
        margin-bottom: 30px;
    }

    .catbtn {
        padding: 30px 20px;
        border-top: 1px solid #e1e1e1;
        border-left: 1px solid #e1e1e1;
        border-right: 1px solid #e1e1e1;
    } */

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
    .pagination {
        padding: 10px;
    }

    span.page-numbers.current {
        background: #328d50;
        color: #ffff;
        padding: 5px 12px;
    }
    .rate {

        float: inline-start;
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
        max-width: 270px;
    }



    ul.products a:hover{
        background: #084025;
    }

    ul.products a:hover p, ul.products a:hover h3 , ul.products a:hover h4 {
        color: white;
    }

    .sub_child_category_box {
        margin-left: 0px;
        /* margin-top: 15px; */
    }

    .second_child_category_box {
        margin-left: 15px;
        margin-top: 15px;
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

    /* .category_box.product_category {
        max-height: 500px;
        overflow-y: scroll;
    } */

    .slice_side_left {
        /* max-height: 1359px  !important;
        overflow-y: scroll !important; */
    }
    .products_first_holder {
        padding: 10px 0px;
    }
   
    .productType .box_seprator{
        border: unset;
    }
    .category_box.productType {
        display: flex;
        justify-content: center;
        align-items: center;
        border: unset;
        padding: 10px 15px;
    }
	
	.category_box.productType label.cbx.labelProductType {
		border-radius: 0px;
	}
	
    .productType .labelProductType {
        padding: 20px 80px !important;
        background: #000;
        cursor: pointer;
    }
    /* .productType .inp-cbx:checked + .cbx span:first-child{
        border-color: #084025;
    } */
    .productType .checkbox-wrapper-4 .cbx span:first-child{
        border: unset;
        color: #ffff !important;
        background: unset;
    }
    .productType .checkbox-wrapper-4 .cbx span{
        float: none;
        font-size: 20px !important;
    }
    .productType .inp-cbx:checked + .labelProductType  {
        background: #084025;
        border-color: #084025;
    }
    .productType  .checkbox-wrapper-4 .inp-cbx:checked + .cbx span:first-child{
        background: unset;
    }

    .category_box_heading:after {
        transform: rotate(180deg);
    }

    .category_box_heading.boxParent:after {
        transform: rotate(0deg);
    }
    



</style>

<section class="products_first_holder">
    <div class="box_frame">

        <!-- <h3 class="">Product Type</h3> -->
        <div class="category_box productType">
            <!-- <button class="category_box_heading">Product Type</button> -->

            <div class="box_seprator">
                <div class="checkbox-wrapper-4">
                    <input class="inp-cbx product_type filter" id="654" data-filter="product_type" name="product_type" value="creations" type="radio">
                    <label class="cbx labelProductType" for="654">
                        <!-- <span>
                            <svg width="12px" height="10px">

                            </svg></span> -->
                            <span>Creations</span>
                        </label>
                    <!-- <svg class="inline-svg">
                        <symbol id="check-1" viewBox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </symbol>
                    </svg> -->
                </div>
            </div>

            <div class="box_seprator">
                <div class="checkbox-wrapper-4">
                    <input class="inp-cbx product_type filter" id="674" data-filter="product_type" name="product_type" value="services" type="radio">
                    <label class="cbx labelProductType" for="674">
                        <!-- <span>
                            <svg width="12px" height="10px"></svg>
                        </span> -->
                        <span>Services</span>
                    </label>
                    <!-- <svg class="inline-svg">
                        <symbol id="check-2" viewBox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </symbol>
                    </svg> -->
                </div>
            </div>

            <div class="box_seprator">
                <div class="checkbox-wrapper-4">
                    <input class="inp-cbx product_type filter" id="716" data-filter="product_type" name="product_type" value="stl-library" type="radio">
                    <label class="cbx labelProductType" for="716">
                        <!-- <span>
                            <svg width="12px" height="10px">

                            </svg></span> -->
                            <span>STL Files</span>
                        </label>
                    <!-- <svg class="inline-svg">
                        <symbol id="check-3" viewBox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </symbol>
                    </svg> -->
                </div>
            </div>

        </div>
       
        <div class="stripe">

            <aside class="slice_side_left">

                

                <!-- <div class="catbtn"> -->
                    <!-- </div> -->
                <div class="category_box product_category">
                    <button class="category_box_heading cat-heading">Categories</button>
                    <?php 
                    // Get all categories in one go
                    $categories = get_categories(array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hierarchical' => true,  // Ensures hierarchical order
                    ));

                    // Function to display categories and children (hide parent categories, show child categories, hide sub-child categories)
                    function display_category_hierarchy($categories, $parent_id = 0) {
                        foreach ($categories as $category) {
                            // Display only top-level categories (parents)
                            if ($category->parent == $parent_id) {
                                // Get child categories of the current category
                                $child_categories = array_filter($categories, function($cat) use ($category) {
                                    return $cat->parent == $category->term_id;
                                });
                             
                    
                                // Display the parent category link
                                ?>
                    
                                    <?php if (!empty($child_categories)) { ?>
                                        <div class="category_box sub_category_box <?= $category->term_id ?>"> <!-- Hide sub-child categories by default -->
                                            <?php foreach ($child_categories as $child_cat) { 
                                                // Check for sub-child categories
                                                $sub_child_categories = array_filter($categories, function($sub_cat) use ($child_cat) {
                                                    return $sub_cat->parent == $child_cat->term_id;
                                                });
                                                // echo "<pre>";
                                                // var_dump($child_cat);
                    
                                                // Display the child category
                                                ?>
                                                <div class="box_seprator <?= !empty($sub_child_categories) ? 'sub_child' : '' ?>">
                                                    <a href="javascript:void(0);" data-id="<?= esc_attr($child_cat->term_id); ?>" class="side_tab_item child-category-link"><?= esc_html($child_cat->name); ?></a>
                    
                                                    <?php if (!empty($sub_child_categories)) { ?>

                                                        <div class="sub_child_category_box" style="display: none;">
                                                            <?php foreach ($sub_child_categories as $sub_child_cat) { 
                                                                // Check for sub-child categories
                                                                $under_sub_child_categories = array_filter($categories, function($u_sub_cat) use ($sub_child_cat) {
                                                                    return $u_sub_cat->parent == $sub_child_cat->term_id;
                                                                });
                                                                // var_dump($under_sub_child_categories);
                                                                ?>
                                                                <div class="checkbox-wrapper-4">
                                                                    <input class="inp-cbx filter" data-filter="category" id="<?= esc_attr($sub_child_cat->term_id); ?>" value="<?= esc_html($sub_child_cat->slug); ?>" type="checkbox">
                                                                    <label class="cbx" for="<?= esc_attr($sub_child_cat->term_id); ?>"><span>
                                                                            <svg width="12px" height="10px">

                                                                            </svg></span><span><?= esc_html($sub_child_cat->name); ?></span></label>
                                                                    <svg class="inline-svg">
                                                                        <symbol id="check-1" viewBox="0 0 12 10">
                                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                        </symbol>
                                                                    </svg>
                                                                </div>
                                                                <?php if (!empty($under_sub_child_categories)) { ?>
                                                                    <?php foreach ($under_sub_child_categories as $sub_child_cat) { ?>
                                                                        <div class="checkbox-wrapper-4 testClass">
                                                                            <input class="inp-cbx filter" data-filter="category" id="<?= esc_attr($sub_child_cat->term_id); ?>" value="<?= esc_html($sub_child_cat->slug); ?>" type="checkbox">
                                                                            <label class="cbx" for="<?= esc_attr($sub_child_cat->term_id); ?>"><span>
                                                                                    <svg width="12px" height="10px">

                                                                                    </svg></span><span><?= esc_html($sub_child_cat->name); ?></span></label>
                                                                            <svg class="inline-svg">
                                                                                <symbol id="check-1" viewBox="0 0 12 10">
                                                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                                </symbol>
                                                                            </svg>
                                                                        </div>
                                                                <?php } } ?>

                                                            <?php } ?>
                                                        </div>

                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                <?php
                            }
                        }
                    }
                    


                    // Call the function to display categories, but skip the top-level parent categories
                    display_category_hierarchy($categories, 0);
                    ?>
                </div>

                <div class="category_box location">
                    <button class="category_box_heading">Location</button>

                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <label class="cbx" for="loc_3">
                               <input type="text" data-filter="country" name="country" placeholder="Country" class="zip_input">
                            </label>
                        </div>
                    </div>
                   
                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <label class="cbx" for="loc_3">
                               <input type="text" data-filter="state" name="state" placeholder="State" class="zip_input">
                            </label>
                        </div>
                    </div>
                   
                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <label class="cbx" for="loc_3">
                                <input type="text" data-filter="city_zip" name="city" placeholder="City" class="zip_input">
                            </label>
                        </div>
                    </div>

                    <div class="box_seprator">
                        <div class="checkbox-wrapper-4">
                            <label class="cbx" for="loc_3">
                                <input type="text" data-filter="zip_code" name="zip_code" placeholder="Zip Code" class="zip_input">
                            </label>
                        </div>
                    </div>
                </div>


                <div class="category_box ratingParent">
                    <button class="category_box_heading rating ">Ratings</button>
                    <div class="box_seprator rating_stars rate">
                        <?php for($i=5; $i >= 1; $i--){ ?>
                            <input id="star_<?= $i ?>" name="rate" type="radio" value="<?= $i ?>" <?= ($i == $rating) ? 'checked' : '' ?> />
                            <label for="star_<?= $i ?>" class="review-rating" title="Rating"><?= $i ?> star</label>
                        <?php  } ?>
                    </div>
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
                                <input class="inp-cbx filter" value="<?= $term->name ?>" data-filter="properties" id="<?= $term->slug ?>" type="checkbox">
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

                <!-- <div class="category_box materials_box">
                    <button class="category_box_heading">Materials</button>

                    <?php
                        $taxonomy = wc_attribute_taxonomy_name('materials');
                        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]); 
                        foreach ($terms as $term) { ?>
                        <div class="box_seprator">
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx filter" value="<?= $term->name ?>" data-filter="materials" id="<?= $term->slug ?>" type="checkbox">
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

                </div> -->
                
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
                                if (!empty($children)) {
                                    foreach ($children as $child) { ?>

                                    <div class="box_seprator sc sub_child" style="display: none;">
                                        <a href="javascript:void(0);" data-id="<?= $parent->term_id ?>" class="side_tab_item child-category-link"><?= $child->name  ?></a>

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
                                                    <input class="inp-cbx filter <?= esc_html($subchild->slug); ?>" data-filter="category" id="<?= esc_html($subchild->term_id); ?>" value="<?= esc_html($subchild->slug); ?>" type="checkbox">
                                                    <label class="cbx" for="<?= esc_html($subchild->term_id); ?>">
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

                                            <?php } } ?>
                                        </div>
                                    </div>
                                    
                                <?php } } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>


                
            </aside>
            <div class="slice_side_right">
            
                <div class="grid__strip">
                    <?php
                        $args = array(
                            'post_type'      => 'product',
                            'posts_per_page' => 24,
                            'post_status'    => 'publish',
                            'meta_query'     => [
                                'relation' => 'OR',
                                [
                                    'key'     => 'sponsored',
                                    'value'   => 'active',
                                    'compare' => '=',
                                ],
                                // [
                                //     'key'     => 'sponsored',
                                //     'compare' => 'NOT EXISTS', // Includes products without the 'sponsored' meta key
                                // ],
                                // [
                                //     'key'     => 'sponsored',
                                //     'value'   => 'expired',
                                //     'compare' => '=',
                                // ],
                                [
                                    'relation' => 'AND',
                                    [
                                        'key'     => 'product_type',
                                        'value'   => 'creations',
                                        'compare' => '=',
                                    ]
                                ],
                            ],
                            'orderby'  => [
                                'meta_value' => 'ASC',  // Orders sponsored products first
                                'date'       => 'DESC',  // Orders by date within each group
                            ],
                            'meta_key' => 'sponsored',  // Required for 'meta_value' ordering
                        );
                    
                        if(isset($_GET['id'])){
                            $args['post_author'] =  $_GET['id'];
                        }
                        $the_query = new WP_Query( $args );


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
                                $product_type =  get_post_meta(get_the_ID(), 'product_type', true);
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
                                        <small class="product_type"><?= $product_type ?></small>
                                        <h3><?= get_the_title(); ?> </h3>
                                        <div class="p-desc">
                                            <?= substr(get_the_excerpt(), 0,50); ?>
                                        </div>

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
                           
                        } else {
                            echo '<p class="p_not_found">No products found.</p>';
                        }
                        wp_reset_postdata();
                
                    ?>
                </div>
                <div class="pagination">
                    <?php
                    echo paginate_links( array(
                        'base' => get_pagenum_link(1) . '%_%',
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $the_query->max_num_pages,
                        'prev_text' => __('« Previous'),
                        'next_text' => __('Next »'),
                        ));
                    ?>
                </div>
                <!-- <a href="<?= home_url('shop') ?>" class="view_all_click">View All Products</a> -->
            </div>
        </div>

    </div>
</section>

<script>

    jQuery(document).ready(function(){

       // jQuery(document).on('change', '.product_type', function(){
        //     jQuery('.sub_category_box').hide();
        //     id = jQuery(this).attr('id');
        //     if(jQuery(this).is(':checked')){
        //         jQuery('.'+id).show();
        //     } else {
        //         jQuery('.'+id).hide();
        //     }
        // });



        jQuery('.sc .child-category-link').click(function(){
            if(jQuery(this).hasClass('open')){
                jQuery(this).parent('.sub_child').find('.sub_child_category_box').slideUp();
                jQuery(this).removeClass('open');
                return false;
            }
            jQuery('.sc .sub_child_category_box').slideUp();
            jQuery(this).parent('.sub_child').find('.sub_child_category_box').show();
            jQuery('.child-category-link').removeClass('open');
            jQuery(this).addClass('open');

        });

        jQuery('.product_category .child-category-link').click(function(){
            if(jQuery(this).hasClass('open')){
                jQuery(this).parent('.sub_child').find('.sub_child_category_box').slideUp();
                jQuery(this).removeClass('open');
                return false;
            }
            jQuery('.product_category .sub_child_category_box').slideUp();
            jQuery(this).parent('.sub_child').find('.sub_child_category_box').show();
            jQuery('.child-category-link').removeClass('open');
            jQuery(this).addClass('open');

        });

        
        jQuery('.grand').click(function(){
            jQuery('.sc.sub_child').slideUp();
            jQuery(this).parents('.sub_child').find('.sc.sub_child').show();
        
        });

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
                jQuery('.category_box.product_category .sub_category_box .box_seprator:nth-child(n+9)').hide();
                jQuery('.category_box.properties_box .box_seprator:nth-child(n+8)').hide();
                return false;
            }
            jQuery(this).closest('.category_box').find('.box_seprator').hide();
            jQuery(this).closest('.category_box').find('.toggleButton').hide();

        });

        document.querySelectorAll('.child').forEach(function(element) {
            element.style.display = 'none';
        });

        jQuery(document).on("click", "a.page-numbers", function(e){
            e.preventDefault();
            var page = jQuery(this).text();
            if(jQuery(this).hasClass('next')){
                page = jQuery('.page-numbers.current').next().text();
            } else if(jQuery(this).hasClass('prev')){
                page = jQuery('.page-numbers.current').prev().text();
            }
            
            the_search_func(e, page);
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


        jQuery(document).on('change', '.product_type', function(){

            jQuery('.sub_category_box').hide();

            // Clear all filter arrays
            Object.keys(filters).forEach(key => filters[key] = []);
            jQuery('aside.slice_side_left input[type=text]').text('');
            jQuery('aside.slice_side_left input').prop('checked', false)

            id = jQuery(this).attr('id');
            if(jQuery(this).is(':checked')){
                jQuery('.'+id).show();
            } else {
                jQuery('.'+id).hide();
            }

        });

        jQuery(document).on('change', '.filter', function(e){
            
            const filterType = jQuery(this).data('filter');
            filters[filterType] = [];
            //filters['category'] = []; 
            jQuery(`.filter[data-filter="${filterType}"]:checked`).each(function() {
                filters[filterType].push(jQuery(this).val());
            });
            // alert();
            the_search_func(e, 1);
			
        });

        jQuery(document).on('change', 'input[name="country"], input[name="city"] , input[name="state"], input[name="zip_code"]', function(e){
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

            var store_profile_id = "<?= isset($_GET['id']) ? $_GET['id'] : 0  ?>";

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
                store_profile_id: store_profile_id,
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

        jQuery('.sub_category_box').append('<button  class="toggleButton show-more">Show More</button>');
        jQuery('.properties_box').append('<button  class="toggleButton show-more">Show More</button>');
        const toggleButton = jQuery('.toggleButton');
      
        // Hide items initially
        jQuery('.category_box.product_category .sub_category_box .box_seprator:nth-child(n+9)').hide();
        jQuery('.category_box.properties_box .box_seprator:nth-child(n+8)').hide();

        // Add click event to each button
        jQuery('.toggleButton').click(function () {
            const parentContainer = jQuery(this).closest('.category_box'); // Identify the parent category
            let hiddenItems;

            if (parentContainer.hasClass('sub_category_box')) {
                hiddenItems = parentContainer.find('.box_seprator:nth-child(n+9)');
            } else if (parentContainer.hasClass('properties_box')) {
                hiddenItems = parentContainer.find('.box_seprator:nth-child(n+8)');
            }

            // Toggle visibility and button text
            if (hiddenItems) {
                hiddenItems.toggle();
                const isHidden = hiddenItems.is(':hidden');
                jQuery(this).text(isHidden ? 'Show More' : 'Show Less');
            }
        });

        jQuery('.inp-cbx.product_type').first().trigger('click');

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