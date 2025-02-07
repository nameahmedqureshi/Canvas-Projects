<?php
/*
Template Name: Property Managers
*/
?>
<? include('header.php'); ?>

<? include('title.php'); ?>
	
<main>
	<div class='inner medium'>
		
	<? if(has_post_thumbnail()) { ?>
		<div class='featured-image'>
	<? the_post_thumbnail('medium'); ?>
		</div>
	<? } ?>
		

			
    <? $message=$_REQUEST['message']; ?>
    <? $error=$_REQUEST['error']; ?>	
		
    <? if($message == "error") { ?>
    <div class='message error'>
    <p>Please fill out all the required fields or address the following error(s).</p>
    <p><? echo $error; ?></p>
    </div>
 

    <? } else if($message == "success") { ?>
    <div class='message success'>
    <p>Thanks for your submission! We will get back with you as soon as we can.</p>
    </div>
    <? } else { ?>
				

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<? the_content(); ?>
	<?php endwhile; endif; ?>
				
	<? } ?>


			<form action='<? echo $theme; ?>/sendmail.php' method='post' id='contact-form' class='<? if($message=="error") { echo "form-error" ; } ?>'>
			<h2>Request Consultation</h2>
			<div class='form-fields'>
			<div class='field textfield'>
				<input name='name' id='name' type='text' required>
				<label for='name'>Name</label>
			</div>
			<div class='field textfield'>
				<input name='email' id='email' type='text' required>
				<label for='email'>Email</label>
			</div>
			<div class='field textfield'>
				<input name='phone' id='phone' type='text'>
				<label for='phone'>Phone</label>
			</div>
			<div class='field textfield'>
				<input name='address' id='website' type='text'>
				<label for='address'>Property Address</label>
			</div>
			<div class='field'>
				<textarea name='comments' id='comments' type='text' required></textarea>
				<label for='comments'>Comments</label>
			</div>
			<div class='field'>
				<input name='submit' id='submit' type='submit' class='button' value="Submit">
			</div>
			</div><!--/form fields-->
				<input type='hidden' value='<? echo strtok($_SERVER['REQUEST_URI'], '?') ?>' name='url'>
				<input type="checkbox" name="contact_me_by_electronic_mail_but_not_really" value="1" style="display:none !important" tabindex="-1" autocomplete="off">
			</form>
			

				
		
	</div>			
</main>

<? include('contact-banner.php'); ?>

		
<? include('footer.php'); ?>