<? include('header.php'); ?>

<? include('title.php'); ?>

<!--
<hero>	
	<div class='inner columns'>
	<div class='hero-image'>
	<img src='<? //echo $theme; ?>/images/filter-single.png' alt='Air Filter'>
	</div>
	
	<div class='hero-text'>
		<p>  
		MervAir – where convenience meets 
effectiveness one breath at a time!
		</p>
	</div>
		
	</div>
</hero>	-->

<hero>
	<div class='inner'>
	<img src='<? echo $theme; ?>/images/illustrated-banner.png' alt='Girl Breathing Fresh Air'>
	</div>
</hero>	
	


	
<main>
	<div class='inner medium'>
		
	<? if(has_post_thumbnail()) { ?>
		<div class='featured-image'>
	<? the_post_thumbnail('large'); ?>
		</div>
	<? } ?>
		
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<? the_content(); ?>
	<?php endwhile; endif; ?>
		
		
		<? $choose = $_REQUEST['slogan']; ?>
		<? if($choose=="yes") { ?>
		<p class='callout' style='margin: 0 auto 3rem; font-size: 1.75rem;'> 
					MervAir – where convenience meets 
effectiveness one breath at a time!
		</p>
		<? } ?>

		
		
	</div>			
</main>
		
<? include('footer.php'); ?>