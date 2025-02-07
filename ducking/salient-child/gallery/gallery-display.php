<?php  /* Template Name: Gallery Display */ ?>
<?php
   $args = array(
    'post_type' => 'jeeps',
    'post_status' => 'publish',
    'posts_per_page' => -1, // Display all posts
);
 $query = new WP_Query($args);

 // Get taxonomies associated with the custom post type
 $categories = get_terms(array(
    'taxonomy'      => 'jeep-category', // Replace with the actual taxonomy name
    'hide_empty'    =>  1,
));
?>
<style>
    input[type=search]::-ms-clear { display: none; width : 0; height: 0; }
    input[type=search]::-ms-reveal { display: none; width : 0; height: 0; }
    input[type="search"]::-webkit-search-decoration,
    input[type="search"]::-webkit-search-cancel-button,
    input[type="search"]::-webkit-search-results-button,
    input[type="search"]::-webkit-search-results-decoration { display: none; }
    /*************GENRAL CLASSES START*************/
    @font-face {
        font-family: 'Libel-suit-reg';
        src: url(../fonts/libel-suit-rg.otf);
    }
    .gen_btn {
        font-family: 'Poppins', sans-serif;
        padding: 0px 24px;
        height: 55px;
        border-radius: 5px;
        background: #fed843;
        color: #000;
        transition: all .2s ease-in-out;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 16px;
        font-weight: 500;
        border: 0;
        width: fit-content;
        text-transform: uppercase;
        cursor: pointer;
    }
    .gen_btn:hover {
        color: #000;
    }
    /*************GENRAL CLASSES END*************/

    .track_duck_wrapper_1 {
        padding: 70px 0px;
    }
    .heading {
        font-size: 60px;
        font-family: 'Libel-suit-reg';
        color: #000;
        letter-spacing: 3px;
        margin-bottom: 10px;
    }	
    .search_bar {
        max-width: 100%;
        border: 1px solid rgba(17, 63, 89, 0.20);
        border-radius: 5px;
        height: 55px;
        width: 100%;
        display: flex;
        align-items: center;
        position: relative;
    }
    .search_input {
        font-family: 'Poppins', sans-serif;
        width: 100%;
        height: 100%;
        border: 0;
        background: transparent;
        font-size: 16px;
        padding: 0px 135px 0px 20px;
        outline: none;
    }
    .search_bar .gen_btn {
        height: 48px;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 3px;
    }
    .search_bar .gen_btn i {
        margin-left: 8px;
        font-size: 14px;
    } 
    .qr_btn {
        margin-bottom: 20px;
        width: 100%;
    }
    .qr_scan_box {
        width: 100%;
        height: 300px;
        border: 2px dashed #000;
        border-radius: 25px;
        display: none;
        justify-content: center;
        align-items: center;
    }
    .qr_scan_box i {
        font-size: 80px;
        color: #e8d9d9;
    }
    .map_wrap {
        padding: 15px;
        background: var(--white);
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        border-radius: 15px;
        margin-top: 25px;
    }
    .map_wrap .heading {
        font-size: 35px!important;
    }

    .gen_row {
        display: flex;
        gap: 20px;
    }
    .gen_col_1 {
        width: 60%;
    }
    .gen_col_2 {
        width: 40%;
    }
    .gallery_wrapper_1 .search_bar {
        margin-bottom: 30px;
    }
    .gallery_wrapper_1 {
        padding: 70px 0px;
    }
    .product_filters {
        max-width: 250px;
        width: 100%;
    }
    .content_main {
        width: calc(100% - 250px);
    }
    .product_filters {
        padding: 20px;
        border: 1px solid #E4E7E9;
        border-radius: 2px;
    }
    .product_filters .heading {
        font-size: 22px;
        font-weight: 500;
        color: #000;
        line-height: 1;
        padding-bottom: 15px;
    }
    ul.sort_list {
        margin-left: 10px;
        margin-bottom: 10px;
    }
    .sort_list li {
        list-style: none;
    }
    .sort_list li {
        margin: 10px 0px;
    }
    .sort_list li a {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        color: #000;
        display: block;
    }
    .sort_list li a:hover {
        color: #fed843;
    }
    .genCard {
        display: block;
        /* max-width: 250px;
        width: 100%; */
        padding: 15px;
        border-radius: 10px;
        background: var(--white);
        display: block;
        margin-bottom: 10px;
        transition: all 0.5s;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        height: 350px;
    }
    .genCard .imgBox {
        width: 100%;
        height: 200px;
        overflow: hidden;
        border-radius: 10px;
        overflow: hidden;
    }
    .genCard .imgBox img {
        width: 100% !important;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: all 0.5s;
        border-radius: 20px;
        overflow: hidden;
    }
    .genCard:hover .imgBox img { 
        filter: brightness(0.6);
        transform: scale(1.1);
    }
    .genCard .textBox {
        padding-top: 10px;
    }
    .genCard .title {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: #000;
        padding-bottom: 5px;
    }
    .genCard .desc {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: #000;
    }
    .xy-between {
        display: flex;
        /* justify-content: space-between; */
        align-items: center;
        flex-wrap: wrap;
    }
    .img_box {
        max-width: 285px;
        width: 100%;
        height: 285px;
        border-radius: 5px;
        overflow: hidden;
        cursor: pointer;
    }
    .img_box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
</style>
<section class="gallery_wrapper_1">
	<div class="container">
		<form class="search_bar">
			<input id="myInput" type="search" class="search_input"  placeholder="Search by location, duck design, or Jeep model..">
			<button class="gen_btn" type="button">
				<span>Search</span> 
				<i class="fa-solid fa-magnifying-glass"></i>
			</button>
		</form>
		<div class="gen_row">
			<aside class="product_filters">
				<div class="form_group">
					<ul class="sort_list">
						<li>
                            <a class="category-link active" href="#" cat-type="all">All</a>
						</li>
                        <?php foreach($categories as $category) { ?>
                            <li>
                                <a class="category-link" href="#" cat-type="<?= $category->term_id ?>"><?= $category->name ?></a>
                            </li>
                        <?php } ?>
					</ul>
				</div>
			</aside>
			<div class="content_main">
                <?php if ($query->have_posts()) { ?>
                    <div id="myDIV" class="row xy-between">
                        <?php $i=1; while ($query->have_posts()) : $query->the_post(); ?>

                            <a href="<?= site_url('gallery-images?id='.get_the_ID()) ?>" class="genCard col span_4 <?= ($i%3==0) ? 'col_last':''?>" title="<?= get_the_title() ?>">
                                <div class="imgBox">
                                    <img src="<?= get_the_post_thumbnail_url(get_the_ID()) ?>" alt="img">
                                </div>
                                <div class="textBox">
                                    <p class="title"><?= get_the_title() ?></p>
                                    <p class="desc"><?= get_the_content()  ?></p>
                                </div>
                            </a>

                        <?php $i++; endwhile; ?>
                    </div>
                <?php } else {
                echo 'No custom gallery items found.';
                } ?>
			</div>
		</div>
	</div>
</section>