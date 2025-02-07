<?php /*  Template Name: Add Jeep Gallery  */ ?>
<?php get_header('header'); ?>
<?php 
 	$current_user = wp_get_current_user(); 
 	$post_id = isset($_GET['id']) ? $_GET['id'] : '';
?>

<section class="sec_main">
	<div class="sec_row">
		<?php get_template_part('templates/includes/menu', 'template'); ?>
		<div class="content_main">
			<div class="inner_header">
					<h1 class="heading_top">Add New Jeeps</h1>
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
				<div class="gen_new_box">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<h1 class="gen_heading pb-5">Fill the form below to add new image in jeep gallery</h1>
							<form method="post" class="row" id="addJeepGallery" enctype="multipart/form-data">
								<!-- add gallery -->
								<div class="galleryDiv col-12">
										<div class="col-lg-6 col-md-6 col-sm-12 col-12">
											<div class="form_group mb-4">
												<label for="" class="gen_label">Title</label>
												<input type="text" name= "gallery_title" placeholder="Image Name" class="gen_input" required>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12 col-12">
											<div class="form_group mb-4">
											
												<label for="" class="gen_label">Description</label>
												<input type="text" name= "gallery_desc" placeholder="Image Caption"  class="gen_input">
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12 col-12">
											<span class="cross_mark" style="display:none">✖</span>							
											<img src="<?= $post_id ? get_the_post_thumbnail_url() : '' ?>"  class="img-fluid img-size" id="avatarImage">
											<label class="add_new_btn upload_card">
												<div class="upload_circle">
													<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/upload-icon.png' ?>" alt="img">
													<input type="file" name ="gallery_image" class="d-none" id="avatarInput">
												</div>
												<p class="txt">Drag image here or <span>browse</span></p>
											</label>
											<!-- <div class="form_group mb-4">
												<label for="" class="gen_label">Image</label>
												<input type="file" name= "gallery_image" class="gen_input">
											</div> -->
										</div>
										<!-- <button class="btn btn-danger delete-button">Delete?</button>	
										<button class="btn btn-success add_btn">Add New Image?</button>	 -->
										
								</div>
								
								<!-- end -->
								
								<div class="col-6">
									<div class="form_group mt-4">
										<button class="submit_btn edit_btn add_jeep">Add Image To Gallery</button>
									</div>
								</div>
								<input type="hidden" name="action" value="add_jeep_gallery" />
                                <input type="hidden" name="post_id" value="<?= $post_id ?>" /> 
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="abs_jeep_image">
		<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/abs-jeep.png' ?>" alt="img" class="img-fluid">
	</div>
</section>
<?php get_footer('footer'); ?>