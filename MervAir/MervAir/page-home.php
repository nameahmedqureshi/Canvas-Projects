<?php
/*
Template Name: Home Page
*/
?>

<? include('header.php'); ?>
	
<hero>
	<img src='<? echo $theme; ?>/images/cropped-merv-hero.jpeg' alt='Girl Breathing Fresh Air'>
	<a class='button' href='<? echo $url; ?>/air-filters'>Get Started</a>
</hero>	
	
<main>
	<div class='inner'>
	  <h1>Pure Air Delivered</h1>
      <div>
        <h2><em>Changing your Air Filter just got Easier.
          Just Order, Receive and Install.</em></h2>
        <p class='callout'><strong>FREE</strong> Delivery! All Filter Sizes Available! Cancel at <strong>ANYTIME!</strong></p>
        <h2>How do I Benefit?</h2>
		  <div class='columns benefits'>
			  
			  <div class='benefit'>
		     <img src="<? echo $theme; ?>/images/benefit1.svg" alt=""/>
				  More Efficient HVAC System
			  </div>
			  
			  <div class='benefit'>
		     <img src="<? echo $theme; ?>/images/benefit2.svg" alt=""/>
				  Lower Electricity Bill
			  </div>
			  
			  <div class='benefit'>
		     <img src="<? echo $theme; ?>/images/benefit3.svg" alt=""/>
				  Breathe with Confidence
			  </div>
			  
	    </div>
        <hr>
        <h2>What is MERV?</h2>
        <p>MERV  (Minimum Efficiency Reporting Value) ratings are used to measure  effectiveness of air filters removing airborne particles from the air.  There are 3 basic types of Merv Ratings: MERV 8, MERV 10 and MERV 13.</p>
      </div>
	</div>
</main>	
	
<? include('footer.php'); ?>