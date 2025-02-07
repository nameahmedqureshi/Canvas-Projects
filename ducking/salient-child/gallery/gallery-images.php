<?php  /* Template Name: Gallery Images */ ?>
<?php get_header(); ?>
<?php
   $post_id = isset($_GET['id']) ? $_GET['id'] : '';
   $post = get_post( $post_id );
  
   global $wpdb;
   $table = $wpdb->prefix.'postmeta';
   $get_gallery = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $table  WHERE `meta_key` LIKE 'gallery%' AND `post_id`= $post_id"), ARRAY_A);
	// Get the base upload directory URL
	$upload_dir = wp_upload_dir();
	//var_dump($post);
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
    .sort_list {
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
        max-width: 250px;
        width: 100%;
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
        width: 100%;
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
        justify-content: space-between;
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
		<h1 class="heading">Gallery</h1>
		<div class="gen_row">
			<?php
				if ($get_gallery) {
					foreach($get_gallery as $data){
						// Unserialize the modified string
						$gallery = unserialize($data['meta_value']);
						?>
						<div class="gen_row xy-between">
							<div class="img_box" data-fancybox="gallery" data-src="<?= trailingslashit($upload_dir['baseurl']) . $upload_dir['subdir'] . '/' .$gallery['gallery_image'] ?>">
								<img src="<?= trailingslashit($upload_dir['baseurl']) . $upload_dir['subdir'] . '/' .$gallery['gallery_image'] ?>" alt="img">
							</div>

						</div>

						<?php
					}
				}
				else{
					echo 'No  gallery items found.';
				}
			?>
		</div>
	</div>
</section>
<?php get_footer(); ?>