<?php /*  Template Name: Contact Us  */ ?>
<?php get_header('header'); 
    $current_user = wp_get_current_user(); 
?>

<section class="sec_main">
	<div class="sec_row">
		<?php get_template_part('templates/includes/menu', 'template'); ?>

		<div class="content_main">
			<div class="inner_header">
				<h1 class="heading_top">Contact Us</h1>
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
							<h1 class="gen_heading pb-5">Get in touch with us</h1>
							<form class="row" id="contact">
								<div class="col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">Full Name</label>
										<input type="text" name="c_name" placeholder="Enter Full Name Here" class="gen_input" required>
									</div>
								</div>
								<div class="col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">Email</label>
										<input type="text" name="c_email" placeholder="Enter Email Address" class="gen_input" required>
									</div>
								</div>
								<div class="col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">Subject</label>
										<input type="text" name="c_subject" placeholder="Enter Subject" class="gen_input" required>
									</div>
								</div>
								<div class="col-12">
									<div class="form_group mb-4">
										<label for="" class="gen_label">Message</label>
										<textarea name="c_message" placeholder="Type..." class="gen_input gen_textarea" required></textarea>
									</div>
								</div>
								<div class="col-6">
									<div class="form_group">
										<button class="submit_btn edit_btn">Send Message</button>
									</div>
								</div>
								<div class="col-12 mt-5">
									<h1 class="gen_heading pb-3">Follow Us</h1>
									<ul class="list-unstyled social_list">
										<li>
											<a href="#!" class="social_icon">
												<i class="fa-brands fa-facebook-f"></i>
											</a>
										</li>
										<li>
											<a href="#!" class="social_icon">
												<i class="fa-brands fa-twitter"></i>
											</a>
										</li>
										<li>
											<a href="#!" class="social_icon">
												<i class="fa-brands fa-instagram"></i>
											</a>
										</li>
									</ul>
								</div>
							</form>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-12">
							<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/contact-img.png' ?>" alt="img" class="img-fluid">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer('footer'); ?>