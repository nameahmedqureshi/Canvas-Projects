<?php /*  Template Name: Add Jeeps  */ ?>
<?php get_header('header'); ?>
<?php 
	$current_user = wp_get_current_user(); 
 	$post_id = isset($_GET['id']) ? $_GET['id'] : '';
	$post = get_post( $post_id );
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
						<div class="col-lg-6 col-md-6 col-sm-12 col-12">
							<h1 class="gen_heading pb-5">Fill the form below to add new jeep</h1>
							<form method="post" class="row" id="addJeep" enctype="multipart/form-data">
								<div class="col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">Jeep Name</label>
										<input type="text" name= "jeep_name" placeholder="Enter Jeep Name Here" class="gen_input" value="<?= $post ? get_the_title() : '' ?>" required>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">Jeep Model</label>
										<input type="text" name= "jeep_model" placeholder="Enter Jeep Model" value="<?= $post ? get_post_meta($post->ID, 'jeep_model', true) : '' ?>" class="gen_input">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">Manufacturing Year</label>
										<input type="month" name= "jeep_year" placeholder="Enter Manufacturing Year" value="<?= $post ? get_post_meta($post->ID, 'jeep_year', true) : '' ?>" class="gen_input">
									</div>
								</div>
								<div class="col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">Jeep Number</label>
										<input type="text" name= "jeep_code" placeholder="Enter Jeep Number" value="<?= $post ? get_post_meta($post->ID, 'jeep_code', true) : '' ?>" class="gen_input" required> 
									</div>
								</div>
								<div class="col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">Jeep Category</label>
										<select name = "jeep_category" id="jeep_cat" required>
                                            <option value="" selected disabled hidden>Choose here</option>
												<?php
													$categories = get_terms(array(
														'taxonomy'      => 'jeep-category',
														'hide_empty'    =>  0,
													));
													foreach($categories as $category) { ?>
														<option value="<?= $category->name ?>" name="<?= $category->name ?>" ><?= $category->name ?></option>
												<?php }	 ?>	
										</select>																			
									</div>
								</div>
								<div class="col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">About Jeep</label>
										<textarea placeholder="Type..." name= "jeep_desc" value="<?= $post ? get_post_field('post_content', $post->ID) : '' ?>"class="gen_input gen_textarea"><?= $post->ID ? get_post_field('post_content', $post) : '' ?></textarea>
									</div>
								</div>
								<div class="col-12">	
									<span class="cross_mark" <?= $post_id ? 'style="display:block"' : 'style="display:none"'?>>✖</span>							
									<img src="<?= $post_id ? get_the_post_thumbnail_url() : '' ?>"  class="img-fluid img-size" id="avatarImage">
									<label class="add_new_btn upload_card" <?= $post_id ? 'style="display:none"' : 'style="display:block"'?>>
										<div class="upload_circle">
											<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/upload-icon.png' ?>" alt="img">
											<input type="file" name ="image" class="d-none" id="avatarInput">
										</div>
										<p class="txt">Drag image here or <span>browse</span></p>
									</label>
								</div>
								<div class="col-6">
									<div class="form_group mt-4">
										<button class="submit_btn edit_btn"><?= $post_id ? 'Update Jeep' : 'Add New Jeep'  ?></button>
										<p class="txt loc-check" style="color:red; display:none;">Location should be enabled! Please allow location and try again.</p>
									</div>
								</div>
								<input type="hidden" name="action" value="add_jeep" />
								<input type="hidden" name="post_id" value="<?= $post_id ?>" />
								<input type="hidden" name="duck_id" value="<?= get_post_meta($post->ID, 'duck_id', true)  ?>" />
								<input type="hidden" id= "latitide" name="latitide" value="" />
								<input type="hidden" id= "longitude" name="longitude" value="" />


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
<script>
  (function($){ 
    $(document).ready(function(){   

		var lat = $('#latitide');
		var lng = $('#longitude');
		var submit_btn = $('.submit_btn');
        // Check if geolocation is supported by the browser
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(successCallback, showError);
        } else {
            console.log("Geolocation is not supported by your browser");
        }

        function successCallback(position) {
            // Get latitude and longitude from the position object
			lat.val(position.coords.latitude);
			lng.val(position.coords.longitude);
        }

		function showError(error) {
			switch(error.code) {
				case error.PERMISSION_DENIED:
				$('.loc-check').show();
				submit_btn.prop('disabled', true);
				break;

				case error.POSITION_UNAVAILABLE:
				$('.loc-check').show();
				submit_btn.prop('disabled', true);
				break;

				case error.TIMEOUT:
				$('.loc-check').show();
				submit_btn.prop('disabled', true);
				break;

				case error.UNKNOWN_ERROR:
				$('.loc-check').show();
				submit_btn.prop('disabled', true);
				break;
			}
		}
		
    });
})(jQuery);
</script>