<?php if(is_user_logged_in()) { ?>
<aside class="side_menu">
	<a href="<?= site_url('/') ?>" class="logo_box">
		<img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/logo-main.png' ?>" alt="img" class="img-fluid">
	</a>

	<ul class="nav_bar list-unstyled">
		<li>
			<a href="<?= site_url('dashboard') ?>/" class="nav_item"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/nav-icon-1.png' ?>" alt="icon"></span>My Profile</a>
		</li>
		<li>
			<a href="<?= site_url('journey') ?>/" class="nav_item"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/nav-icon-2.png' ?>" alt="icon"></span>My Duck Journey</a>
		</li>
	
		<!-- <li>
			<a href="<?= site_url('add-duck') ?>/" class="nav_item"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/nav-icon-3.png' ?>" alt="icon"></span>Add Duck</a>
		</li> -->

		<li>
			<a href="<?= site_url('ducking-records') ?>/" class="nav_item"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/nav-icon-3.png' ?>" alt="icon"></span>Ducking Records</a>
		</li>
		
		<li>
			<a href="<?= site_url('all-jeeps') ?>/" class="nav_item"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/nav-icon-4.png' ?>" alt="icon"></span>My Ducking Jeeps</a>
		</li>
		<!-- <li>
			<a href="<?= site_url('qr-code-generator') ?>/" class="nav_item"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/nav-icon-5.png' ?>" alt="icon"></span>New Duck QR</a>
		</li> -->
		<li>
			<a href="<?= site_url('contact') ?>/" class="nav_item"><span><img src="<?= get_stylesheet_directory_uri() . '/templates/assets/front/images/nav-icon-6.png' ?>" alt="icon"></span>Contact Us</a>
		</li>
	</ul>
</aside>
<script>
// PAGE ROUTING
document.addEventListener('DOMContentLoaded', function () {
const links = document.querySelectorAll('.nav_item');
const currentPageURL = window.location.href;
links.forEach((link) => {	
	if (currentPageURL == link.href) {
		console.log('if', currentPageURL);
		link.classList.add('active');
	}
});
});
</script>
<?php } else{
wp_redirect(home_url('/')); 
exit;
} ?>