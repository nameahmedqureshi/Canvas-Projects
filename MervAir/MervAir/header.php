<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="expires" content="0">
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' at'; } ?> <?php bloginfo('name'); ?></title>
	
<?php $url = get_site_url(); ?>
<?php $theme = get_bloginfo('template_url'); ?>	
	
<link rel="icon" type="image/svg+xml" href="<? echo $theme; ?>/images/favicon.svg">
<meta name="viewport" content="width=device-width, initial-scale=1">
	
<meta name="keywords" content="TwoFish, technology, media, security, privacy, managed services">
<meta name="description" content="TwoFish is a technology company with a focus on helping small businesses succeed by removing distractions from doing what you love. Our purpose is to make running your business as simple and secure as possible. We’ll meet you exactly where you are, and devise a service, security and media plan custom-made for your business.">
<meta name="author" content="Derek Weathersbee">
	
<link href='<? echo $theme; ?>/fonts.css' rel='stylesheet'>	
	<link href='<? echo $theme; ?>/forms.css' rel='stylesheet'>
<link href='<? echo $theme; ?>/style.css' rel='stylesheet'>

<link href="<? echo $theme; ?>/narrow.css" media="screen and (max-width:800px)" type="text/css" rel="stylesheet">
	<link href="<? echo $theme; ?>/filter-narrow.css" media="screen and (max-width:800px)" type="text/css" rel="stylesheet">
	
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;500;800&family=Karla:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&family=Montserrat:wght@200;400;500&display=swap" rel="stylesheet"> 
	
	<script src='<? echo $theme; ?>/js/jquery-3.7.1.min.js'></script>
	
	<script src='<? echo $theme; ?>/js/jquery.cycle2.min.js'></script>
	
	<? if(is_page('air-filters')) { ?>
	
	<link href='<? echo $theme; ?>/filters.css' rel='stylesheet'>
	
	<? } ?>
	
	
	

		<? wp_head(); ?>
</head>

<body class='<? if(is_home() || is_page('home')) { echo "home " ;} echo $post->post_name; ?>'>
	
	
<header>
	<nav class='inner columns'>
		

		<a class='logo' href='/'>
		<img src='<? echo $theme; ?>/images/cropped-mervair-1-1.webp' alt='Merv-Air'>
		</a>
		
		<ul class='hidden'>
			<?php wp_nav_menu( array( 
				'theme_location' => 'header-menu',
				'menu_class' => '',
				'menu' => '',
				'depth' => '2',
				'container'      => false,
				'items_wrap'    => '%3$s'
			) ); ?>
		</ul>
		
	<a class='menu-toggle' href='#'></a>
	
	</div>
</header>
	
<? $subHead = get_post_meta($post->ID, 'fx-subhead', TRUE); ?>
<? $altTitle = get_post_meta($post->ID, 'fx-alt-title', TRUE); ?>
<? $heroVideo = get_post_meta($post->ID, 'fx-hero-video', TRUE); ?>	
	
	<div class='page'>