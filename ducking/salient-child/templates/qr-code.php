<?php /*  Template Name: Qr Code Generator */ ?>
<?php get_header('header'); ?>

<section class="sec_main">
	<div class="sec_row">
		<?php get_template_part('templates/includes/menu', 'template'); ?>

		<div class="content_main">
			<div class="inner_header">
				<h1 class="heading_top">New QR Code</h1>
				<div class="top_actions_btns_wrap">
				
					<div class="user_top_info" id="user_info">
						<p class="title">Jones Ferdinand</p>
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
					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="gen_new_box">
							<h1 class="gen_heading pb-5">QR Code Generator</h1>
							<div>
								<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/options-img.png' ?>" alt="img" class="img-fluid">
							</div>
							<form class="qr_text_dropbox mt-4" id="qr-code">
								<textarea class="gen_input mb-4 qr-content" placeholder="Enter your website, text or drop a file here"></textarea>
								<!-- <label for="qr" class="drop_qr_img">
									<p>Drag image here or browse</p>
									<input type="file" class="d-none" id="qr">

									<p class="up_circle">
										<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/upload-icon-1.png' ?>" alt="img">
									</p>
								</label> -->
								<div class="col-6">
									<div class="form_group">
										<button class="submit_btn edit_btn qrcode">Generate QR Code</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					
					<div class="col-lg-4 col-md-4 col-sm-12 col-12">
						<div class="gen_new_box xy-center">
						<div id="qrcode"></div>
						
							<!-- <img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/qr-generator.png' ?>" alt="img" class="img-fluid"> -->
						</div>
						<!-- <button class="card_btn download" style="display:none">
							<img src="http://localhost/ducking-dashboard/wp-content/themes/salient-child/templates/assets/front/images/btn-icon-1.png" alt="download">
						</button> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer('footer'); ?>