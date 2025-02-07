<?php /*  Template Name: Dashboard  */ ?>
<?php get_header('header'); ?>
<?php $current_user = wp_get_current_user(); ?>

<section class="sec_main">
	<div class="sec_row">
	<?php get_template_part('templates/includes/menu', 'template'); ?>


		<div class="content_main">
			<div class="inner_header">
				<h1 class="heading_top">My Profile</h1>
				<div class="top_actions_btns_wrap">
				
					<div class="user_top_info" id="user_info">
						<p class="title"><?= isset($current_user->first_name) && $current_user->first_name ? $current_user->first_name : 'Jones Ferdinand' ?></p>
						<div class="user_img_box"><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/user-img.png' ?>" alt="img" class="img-fluid w-100 h-100"></div>
					</div>
					<div class="nav_dropdown">
						<ul class="list-unstyled">
							<li>
								<a href="#!"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/dd-icon-1.png' ?>" alt="img"></span>My Profile</a>
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
			<form class="user_info_form" id="edit-profile" enctype="multipart/form-data">
				<div class="inner_content_body">
					<div class="user_banner">
						<div class="user_info">
							<div class="user_img">
								<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/avatart1.png' ?>" alt="img" class="avatar" id="avatarImage">
								<label class="edit_dp_btn">
									<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/pen.png' ?>" alt="edit-profile">
									<input type="file" name="profile_image" class="d-none" id="avatarInput">
								</label>
							</div>
							<div class="text_box">
								<p class="p_name"><?= isset($current_user->first_name) && $current_user->first_name ? $current_user->first_name : 'Jones Ferdinand' ?></p>
							</div>
						</div>

						<div class="cover_img">
							<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/cover-bg.png' ?>" alt="img" class="img-fluid">
						</div>
					</div>
					
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-12">
								<div class="form_group mb-5">
									<label for="" class="gen_label">First Name:</label>
									<input type="text" name="first_name" value="<?=  $current_user->first_name  ?>" placeholder="Mark" class="gen_input">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-12">
								<div class="form_group mb-5">
									<label for="" class="gen_label">Last Name:</label>
									<input type="text" name= "last_name" value="<?=  $current_user->last_name  ?>" placeholder="Stonis" class="gen_input">
									
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-12">
								<div class="form_group mb-3">
									<label for="" class="gen_label">Email:</label>
									<input type="email" name="user_email" value="<?=  $current_user->user_email  ?>" placeholder="abc@gmail.com" class="gen_input">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-12">
								<div class="form_group mb-3">
									<label for="" class="gen_label">New Password:</label>
									<input type="text" name="user_password" placeholder="Set New Password" class="gen_input">
								</div>
							</div>
							<div class="form_btn_wrap">
									<button class="edit_btn submit_btn">Update Profile</button>
									<!-- <button class="edit_btn type1">Change Password</button> -->
							</div>
						</div>
					
				</div>
			</form>
		</div>
	</div>
</section>

<?php get_footer('footer'); ?>