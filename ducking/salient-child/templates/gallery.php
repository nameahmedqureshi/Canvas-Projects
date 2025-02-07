<?php /*  Template Name: Gallery  */ ?>
<?php get_header('header'); ?>
<?php
 	$current_user = wp_get_current_user(); 
	 $args = array(
		'post_type' => 'jeeps',
		'post_status' => 'publish',
		'posts_per_page' => -1, // Display all jeeps
	);
	 $query = new WP_Query($args);
?>
<section class="sec_main">
	<div class="sec_row">
		<?php get_template_part('templates/includes/menu', 'template'); ?>

		<div class="content_main">
			<div class="inner_header">
				<h1 class="heading_top">My Duck Gallery</h1>
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
						<div class="gallery_card upload_card">
							<label class="upload_circle">
								<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/upload-icon.png' ?>" alt="img">
								<input type="file" class="d-none">
							</label>
							<p class="txt">Drag image here or <span>browse</span></p>
						</div>
						<!-- UPLOAD BOX -->
					</div>

					<?php if ($query->have_posts()) { while ($query->have_posts()) : $query->the_post(); ?>
						<div class="col-lg-3 col-md-4 col-sm-6 col-12">
							<div class="gallery_card">
								<div class="img_box">
									<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/g-img-1.png' ?>" alt="img" class="img-fluid">
								</div>
								<div class="text_box">
									<p class="title"><?= get_the_title() ?></p>

									<div class="btn_wrap">
										<button class="card_btn">
											<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/btn-icon-1.png' ?>" alt="download">
										</button>
										<button class="card_btn type1 delete_post" post="<?= get_the_ID() ?>">
											<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/btn-icon-2.png' ?>" alt="delete">
										</button>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer('footer'); ?>