<?php /*  Template Name: My Ducking Gallery  */ ?>
<?php get_header('header'); ?>
<?php
	$current_user = wp_get_current_user(); 
    $post_id = isset($_GET['id']) ? $_GET['id'] : '';
    $post = get_post( $post_id );
    //var_dump($post);
    global $wpdb;
    $table = $wpdb->prefix.'postmeta';
    $get_gallery = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $table  WHERE `meta_key` LIKE 'gallery%' AND `post_id`= $post_id"), ARRAY_A);
    // Get the base upload directory URL
    $upload_dir = wp_upload_dir();	
?>

<section class="sec_main">
	<div class="sec_row">
		<?php get_template_part('templates/includes/menu', 'template'); ?>		
		<div class="content_main">
			<div class="inner_header">
				<h1 class="heading_top">My Ducking Gallery</h1>
				<div class="top_actions_btns_wrap">
				
					<div class="user_top_info" id="user_info">
						<p class="title"><?= isset($current_user->first_name) && $current_user->first_name ? $current_user->first_name : 'Jones Ferdinand' ?></p>
						<div class="user_img_box"><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/user-img.png' ?>" alt="img" class="img-fluid w-100 h-100"></div>
					</div>
					<div class="nav_dropdown">
						<ul class="list-unstyled">
							<li>
								<a href="<?= site_url('dashboard') ?>"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-1.png' ?>" alt="img"></span>My Profile</a>
							</li>
							<li>
								<a href="#!"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-2.png' ?>" alt="img"></span>Terms & Conditions</a>
							</li>
							<li>
								<a href="#!"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-3.png' ?>" alt="img"></span>Privacy Policy</a>
							</li>
							<li>
								<a href="<?= site_url('logout') ?>"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-4.png' ?>" alt="img"></span>Logout</a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="inner_content_body">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-sm-6 col-12">
						<!-- UPLOAD BOX -->
						<a href="<?= site_url('add-jeep-gallery?id='.$post_id)  ?>" >
							<div class="gallery_card upload_card">
								<label class="upload_circle">
									<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/upload-icon.png' ?>" alt="img">
									<!-- <input type="file" class="d-none"> -->
								</label>
								<p class="txt">Add Gallery</p>
							</div>
						</a>
						<!-- UPLOAD BOX -->
					</div>
                    <?php
                       if ($get_gallery) {
                            foreach($get_gallery as $data){
                                // Unserialize the modified string
                                $gallery = unserialize($data['meta_value']);

                                // var_dump($gallery);
                                // exit;
                        ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    
                                    <div class="gallery_card">
                                        <div class="img_box">
                                            <img src="<?= trailingslashit($upload_dir['baseurl']) . $upload_dir['subdir'] . '/' .$gallery['gallery_image'] ?>" alt="img" class="img-fluid"> 
                                        </div>
                                        <div class="text_box">
                                            <p class="title"><?= isset($gallery['gallery_title']) && $gallery['gallery_title'] ? $gallery['gallery_title'] : '' ?></p>
                                            <p class="title"><?= isset($gallery['gallery_desc'])&& $gallery['gallery_desc'] ?  $gallery['gallery_desc'] : '' ?></p>
                                            <div class="btn_wrap">
                                            
                                                <!-- <a href="<?= site_url('add-jeep-gallery?id='.$post_id ) ?>" 	class="card_btn type1 edit_post">
                                                    <i class="fa fa-edit" style="font-size:18px"></i>
                                                </a> -->
                                                <button class="card_btn type1 delete_gallery" post="<?= $data['meta_id']  ?>" key="<?= $data['meta_key']  ?>">
                                                    <i class="fa fa-trash-o" style="font-size:18px"></i>
                                                </button>
									        </div>
                                        </div>
                                        
                                    </div>
                                </div>
                        <?php
                                
                            }
                        }
                        ?>

				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer('footer'); ?>
