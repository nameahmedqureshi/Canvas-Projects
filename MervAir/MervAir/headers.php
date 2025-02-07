<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="expires" content="0">
	
<?php $url = get_site_url(); ?>
<?php $theme = get_bloginfo('template_url'); ?>
	
	
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' at'; } ?> <?php bloginfo('name'); ?></title>
	
<link rel="icon" type="image/svg+xml" href="<? echo $theme; ?>/images/favicon.svg">
<meta name="viewport" content="width=device-width, initial-scale=1">
	
<meta name="keywords" content="TwoFish, technology, media, security, privacy, managed services">
<meta name="description" content="TwoFish is a technology company with a focus on helping small businesses succeed by removing distractions from doing what you love. Our purpose is to make running your business as simple and secure as possible. We’ll meet you exactly where you are, and devise a service, security and media plan custom-made for your business.">
<meta name="author" content="Derek Weathersbee">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet"> 
	
<link rel="stylesheet" href="https://use.typekit.net/rpq4img.css">
	
<link href='<? echo $theme; ?>/fonts.css' rel='stylesheet'>
	
<link href='<? echo $theme; ?>/style.css' rel='stylesheet'>
	
<link href='<? echo $theme; ?>/forms.css' rel='stylesheet'>
	
	<link href="<? echo $theme; ?>/wide.css" media="screen and (max-width:1400px)" type="text/css" rel="stylesheet">
	
	<link href="<? echo $theme; ?>/medium.css" media="screen and (max-width:1200px)" type="text/css" rel="stylesheet">
	
	<link href="<? echo $theme; ?>/narrow.css" media="screen and (max-width:800px)" type="text/css" rel="stylesheet">
	
	<link href="<? echo $theme; ?>/skinny.css" media="screen and (max-width:800px)" type="text/css" rel="stylesheet">
	

	
<script src='<? echo $theme; ?>/js/jquery-3.7.0.min.js'></script>
	
	
	<script src='<? echo $theme; ?>/js/slide-in.js'></script>
	
	<script src='<? echo $theme; ?>/js/jquery.countdown.js'></script>
	
	<script src='<? echo $theme; ?>/js/jquery.cycle2.min.js'></script>
	
	<?
			global $post ; 
			$currentID = $post->ID;
			$parentID = $post->post_parent;
			$parent = get_post($post->post_parent);
			$grandparentID = $parent->post_parent;
			$grandparent = get_post($grandparentID);
	
			  if ($grandparentID) { // if we are two levels deep into the hierarchy
				  
					$children = wp_list_pages("title_li=&child_of=".$parent->post_parent."&echo=0&depth=1");
					$sidebar_title = get_the_title($parent->post_parent."&echo=0") ;
			  
			  } else if ($parentID) { // if we are one level deep into the hierarchy
					
					$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&depth=1");
					$sidebar_title = get_the_title($post->post_parent."&echo=0") ; 
				
			  } else { // just check for children of the current page
				  
					$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&depth=1") ;
					$sidebar_title = get_the_title($post->ID."&echo=0") ;
				  
			  } // end the search for grandchildren, children, etc
			  
?>
	<? if($parentID) {
	$headerBG = get_post_meta($post->post_parent, 'fx-title-background-color', TRUE);
	} else {
	$headerBG = get_post_meta($post->ID, 'fx-title-background-color', TRUE);
	}
	if($headerBG == "") { $headerBG = "white"; }
	$headerBGImage = get_post_meta($post->ID, 'fx-title-background-image', TRUE);
	?>
	
	<script>
		$(document).ready(function(){
			
			
			$('.menu-toggle').click(function(){
				$('nav > ul').toggleClass('visible');
			});
			
			

			
		$('.process-image').cycle({
		fx: 'fade',
		//pager: '.hero-nav',
		pagerActiveClass: 'active',
			pager: '.process-content ul ',
		pagerTemplate: '<li><a href="#">{{title}}</a></li>',
		slides : "img",
		timeout: 8000,
		height: 'auto'

	});
			
			$('.search-link').click(function(){
				$('.searchform').addClass('visible');
			});
			
						$('.close').click(function(){
				$('.searchform').removeClass('visible');
			});
	
			
		});
	</script>
	
	<style>
		html {
	margin-top: 32px !important;
		}
	</style>
	
	<? wp_head(); ?>
	
</head>

<body class='<? if(is_home() || is_page('home')) { echo "home " ;} echo $post->post_name; ?>'>
	
			<div class='searchform'>
				<form role='search' method='get' action='<? echo $url; ?>'>
					<input type='search' name='s' placeholder="Search" title='Search Term'>
				</form>
				<a class='close' href='#'>x</a>
			</div>


<header>
	
		<div class='topnav'>
		<div class='inner wide columns'>
			
			<div class='address'>
			5215 South Coulter #300 : : : Amarillo TX 79124  : : :  (806) 839-6669 
			</div>

			<ul class='social'>
				<li class='facebook'><a href="#"><img src='<? echo $theme; ?>/images/icon-facebook-white.svg'></a></li>
				<li class='twitter'><a href="#"><img src='<? echo $theme; ?>/images/icon-twitter-white.svg'></a></li>
				<li class='instagram'><a href="#"><img src='<? echo $theme; ?>/images/icon-instagram-white.svg'></a></li>

			</ul>
			
		</div>
	</div><!--/topnav-->
	
	<div class='inner wide'>
	<nav>
	  	<a class='logo <? if($_REQUEST['logo'] == "tango") { echo "tango"; } ?>' href='<? echo $url; ?>'>
			<? if($_REQUEST['logo'] == "tango") { ?>
			<img src='<? echo $theme; ?>/images/tango-logo.svg'>
			<? } else { ?>
		<img src='<? echo $theme; ?>/images/twofish-logo_1.svg'>
			<? } ?>
			
		</a>
		<ul>
			<?php wp_nav_menu( array( 
				'theme_location' => 'header-menu',
				'container' => false,
				'menu_class' => '',
				'menu' => '',
				'depth' => '2',
				'items_wrap' => '%3$s'
			) ); ?>
		  </ul>
	
		<a class='menu-toggle' href='#'></a>
		
	</nav>
	</div>
</header>	
	
<? $subHead = get_post_meta($post->ID, 'fx-subhead', TRUE); ?>
<? $altTitle = get_post_meta($post->ID, 'fx-alt-title', TRUE); ?>
<? $heroVideo = get_post_meta($post->ID, 'fx-hero-video', TRUE); ?>	
	
	<div class='page'>