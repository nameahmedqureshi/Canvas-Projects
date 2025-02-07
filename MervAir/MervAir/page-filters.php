<?php /* Template Name: Filters Page */ ?>

<?php include('header.php'); ?>
<?php include('title.php'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css">
<!-- To be replaced with your own stylesheet -->
<!-- <link
      rel="stylesheet"
      type="text/css"
      href="https://www.paypalobjects.com/webstatic/en_US/developer/docs/css/cardfields.css"
    /> -->
<script src="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include the PayPal JavaScript SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=AdiwKv4R1Szdgmh5TPtuZ1lucw4_tVzxAJU35CNq5lVVUtbJg0clRT4SK1k4BE49ZksusSKKMx_GZ4kw&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
<!-- <script src="https://www.paypal.com/sdk/js?client-id=AdudKmSwJFFIW0oUSj5dBpvhyH950Fa3y1C2qxKWqIY0yHKEDEr4CDVLWp_5syvMqoz0qtb9mz_CQu7O"></script> -->
<style>
	div#paypal-buttons {
		margin-top: 20px;
		opacity: 0.3;
		pointer-events: none;
	}

	div#filter-details {
		margin: 0 0 1rem;
		border-bottom: 1px solid black;
		padding: 0 0 1rem;
	}

	/*
	.filter-type.active .overlay {
		box-shadow: 0px 0px 10px 3px #00000045;
		border: 7px solid #2e3a8b;
		border-radius: 20px;
		filter: drop-shadow(2px 4px 6px black);
	}
	*/

	.filter-type.active {
		border: 7px solid black;
		border-radius: 20px;

	}

	.filter-type .overlay {
		border-radius: 20px;
	}

	.plan {
		display: none;
	}

	p.validation-msg {
		color: red;
		font-size: 15px;
		text-align: left;
		margin: 0;
	}

	a.l-link {
		color: black;
	}
</style>
<?php
$plan_1 = get_field('plan_1_price', 'option');
$plan_2 = get_field('plan_2_price', 'option');
$plan_3 = get_field('plan_3_price', 'option');

?>
<main>
	<div class='inner wide'>
		<? if (has_post_thumbnail()) { ?>
			<div class='featured-image'>
				<? the_post_thumbnail('large'); ?>
			</div>
		<? } ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<? the_content(); ?>
		<?php endwhile;
		endif; ?>
		<div class='progress'>
			<div class='progress-title'>Create Your Filter Plan</div>
			<ul>
				<li>
					Location <strong>1</strong>

				</li>
				<li>
					Amount <strong>2</strong>

				</li>
				<li>
					Size <strong>3</strong>

				</li>
				<li>
					Type <strong>4</strong>

				</li>
				<li>
					Summary <strong>5</strong>

				</li>
			</ul>
		</div>
		<h1>Select Your Plan</h1>
		<!-- <form class='filter-form'> -->
		<div class='fields' data-cycle-auto-height='container' data-pause-on-hover="true">
			<div class='field location field1 current' data-field='1' id='field1'>
				<div class='field-content'>
					<h2>What is your zip code?</h2>
					<div class='filter-location columns'>
						<input type='text' value='79765' placeholder="Enter your zip code." id='location' name='location'>
					</div>
					<div class='message zip-message hidden'></div>
				</div>
				<div class='navigation'>
					<a class='next' href='#'>Next</a>
				</div>
			</div>
			<div class='field  amount field2' data-field='2' id='field2'>
				<div class='field-content'>
					<h2>How many filters in your house?</h2>
					<div class='columns'>
						<a class='decrease change-amount' href='#'>-</a>
						<input type='text' name='' class='filter-number' value='1' id='filter-number' readonly>
						<a class='increase change-amount' href='#'>+</a>
					</div>
					<h4 class='fil_price'>Filter</h4>
				</div>
				<div class='navigation'>
					<a class='prev' href='#'>Back</a>
					<a class='next' href='#'>Next</a>
				</div>
			</div>
			<div class='field size field3' data-field='3' id='field3'>
				<div class='field-content'>
					<h2>What are the sizes of your filters?</h2>
					<div class='filter-size filter1 columns'>
						<div class='filter-label'> Filter 1 </div>
						<div class='width'>
							<label>Width</label>
							<select class="filter_select">
								<option>10"</option>
								<option>12"</option>
								<option>14"</option>
								<option>15"</option>
								<option class='essential-size'>16"</option>
								<option class='essential-size'>18"</option>
								<option class='essential-size'>20"</option>
								<option class='essential-size'>22"</option>
								<option class='essential-size'>24"</option>
								<option class='essential-size'>25"</option>
								<option class='essential-size'>26"</option>
								<option class='essential-size'>28"</option>
								<option class='essential-size'>30"</option>
							</select>
						</div>
						<div class='height'>
							<label>Height</label>
							<select class="filter_select">
								<option>10"</option>
								<option>12"</option>
								<option>14"</option>
								<option>15"</option>
								<option class='essential-size'>16"</option>
								<option class='essential-size'>18"</option>
								<option class='essential-size'>20"</option>
								<option class='essential-size'>22"</option>
								<option class='essential-size'>24"</option>
								<option class='essential-size'>25"</option>
								<option class='essential-size'>26"</option>
								<option class='essential-size'>28"</option>
								<option class='essential-size'>30"</option>
							</select>
						</div>
						<div class='thickness'>
							<label>Thickness</label>
							<select class="filter_select">
								<option>1"</option>
								<option>2"</option>
								<option>4"</option>
							</select>
						</div>
					</div>
					<!--/filter-->
				</div>
				<div class='navigation'>
					<a class='prev' href='#'>Back</a>
					<a class='next' href='#'>Next</a>
				</div>
			</div>
			<div class='field type field4' data-field='4' id='field4'>
				<div class='field-content'>
					<h2>What level of Merv rating do you need?</h2>
					<div class='filter-types columns'>
						<div class='filter-type good active'>
							<div class='overlay'>
								<h3>Good : merv rating 8</h3>
								<!--<p>Great for homeowners looking to catch some of the bigger annoyances, like dust and pollen particles.</p>-->
								<p class='filter-description'>Great for homeowners looking to catch some of the bigger annoyances.</p>
								<ul class='filter-items'>
									<li>Pollen</li>
									<li>Lint</li>
									<li>Dust</li>
									<li>Mold</li>
									<li>Mites</li>
									<li>Bacteria</li>
								</ul>
								<!-- <a class='button' href='#'>Select</a> -->
								<input type="radio" id="good" class="plan" plan-price="<?= $plan_1; ?>" name="plan" value="Good" checked>
								<!-- <label for="good">Good</label> -->
								<h4 class='annual'>Annualy Subscription Plan <br> $<span class="good_p_pr"><?= $plan_1; ?></span>/month </h4>
							</div>

						</div>
						<div class='filter-type better'>
							<div class='overlay'>
								<h3>Better : merv rating 10</h3>
								<p class='filter-description'>Awesome for those needing to catch smaller particles like pet dander in addition to dust and mold. A 'must' for pet owners.</p>
								<ul class='filter-items'>
									<li>Pollen</li>
									<li>Lint</li>
									<li>Dust</li>
									<li>Mold</li>
									<li>Mites</li>
									<li>Bacteria</li>
									<li>Skin Flakes</li>
									<li>Pet Dander</li>
								</ul>
								<!-- <a class='button' href='#'>Select</a> -->
								<input type="radio" id="better" plan-price="<?= $plan_2; ?>" class="plan" name="plan" value="Better">
								<!-- <label for="better">Better</label> -->
								<h4 class='annual'>Annualy Subscription Plan <br> $<span class="better_p_pr"><?= $plan_2; ?></span>/month </h4>
							</div>

						</div>
						<div class='filter-type best'>
							<div class='overlay'>
								<h3>Best : merv rating 13</h3>
								<p class='filter-description'>Perfect for folks who want to catch all the particles they can, even some of the smallest ones like cooking oil and cigarette smoke.</p>
								<ul class='filter-items'>
									<li>Pollen</li>
									<li>Lint</li>
									<li>Dust</li>
									<li>Mold</li>
									<li>Mites</li>
									<li>Bacteria</li>
									<li>Skin Flakes</li>
									<li>Pet Dander</li>
									<li>Cooking Oil</li>
									<li>Virus Carriers</li>
									<li>Smoke</li>
									<li>Smog</li>
								</ul>
								<!-- <a class='button' href='#'>Select</a> -->
								<input type="radio" id="best" plan-price="<?= $plan_3; ?>" class="plan" name="plan" value="Best">
								<!-- <label for="best">Best</label> -->
								<h4 class='annual'>Annualy Subscription Plan <br> $<span class="best_p_pr"><?= $plan_3; ?></span>/month </h4>
							</div>

						</div>
					</div>
					<!--/filter-->
				</div>
				<div class='navigation'>
					<a class='prev' href='#'>Back</a>
					<a class='next' href='#'>Next</a>
				</div>
			</div>

			<div class='field summary field5' data-field='5' id='field5'>
				<div class='field-content'>
					<div class='columns'>
						<div class='order-details'>
							<h2>Review Your Order</h2>
							<ul>
								<li>
									<strong>Filters</strong>: <span class="filter_count">1</span>
								</li>
								<div id="filter-details">
									<li>
										<strong>Filter 1</strong>: <span class="filter_val">24&quot; x 20&quot; x 1&quot;</span>
									</li>
								</div>
								<li>
									<strong>Filter Type</strong>: <span class="filter_plan">Good</span>
								</li>
								<li>
									<strong>Free Shiiping</strong>
								</li>
								<li>
									<strong>Tax Percentage</strong>: <span>8.25%</span>
								</li>
								<li>
									<strong>Total</strong>: $<span class="filter_price"><?= $plan_1; ?></span>/month
								</li>
							</ul>
							<div class='per_info_form'>
								<h4>Personal Information</h4>
								<form class="checkout">

									<input type="text" required placeholder="Your Name" name="c_name" value="<?= is_user_logged_in() ?  wp_get_current_user()->display_name : '' ?>" <?= is_user_logged_in() ?  'readonly' : '' ?>>
									<input class="user_email" type="email" required placeholder="Your Email" name="email" value="<?= is_user_logged_in() ?  wp_get_current_user()->user_login : '' ?>" <?= is_user_logged_in() ?  'readonly' : '' ?>>
									<span class="note"></span>
									<input type="tel" required placeholder="Phone Number" name="tel">
									<input type="text" required placeholder="Your Address" name="address">
									<input type="hidden" class="plan_price" name="plan_price" value="<?= $plan_1; ?>">
									<input type="hidden" class="plan_filter" name="plan_filter" value="Good">
									<input type="hidden" class="filter_type" name="filter_type" value="Good">
									<input type="hidden" class="filter_num" name="filter_num" value="1">
									<div id="paypal-buttons"></div>
									<button type="submit" name="submit" class='button submit'>Place Order</button>                                      
								</form>
							</div>
						</div>
						<div class='complete-purchase'>
							<img src='<? echo $theme; ?>/images/filter-stack.png' alt='Your Air Filters'>
						</div>
					</div>
				</div>
				<div class='navigation'>
					<a class='prev' href='#'>Back</a>
				</div>
			</div>
		</div>
		<!-- </form> -->
	</div>
	</div>
	<!--/inner-->
</main>

<? include('footer.php'); ?>
<script>
	$(document).ready(function() {

		var good_p_pr = <?= $plan_1 ?>;
		var better_p_pr = <?= $plan_2 ?>;
		var best_p_pr = <?= $plan_3 ?>;

		$('body').addClass('js');

		// 		$('.menu-toggle').click(function(){
		// 			$('nav > ul').toggleClass('hidden')	;
		// 		});

		$('.prev').click(function() {
			currentField = $('.current').attr('data-field');
			if (currentField > 1) {
				prevField = parseInt(currentField) - parseInt(1);
				prevField = "#field" + prevField;
				$('.field').removeClass('current');
				$(prevField).addClass('current');
				$('a[href=' + prevField + ']').parent('li').addClass('tab-active');
			}
		});



		$('.next').click(function() {
			currentField = $('.current').attr('data-field');
			if (currentField == "1") {
				zip = $('#location').val();
				if (zip == '') {
					Swal.fire({
						title: "Error",
						text: "Please enter a valid zip code",
						icon: "error",
					});
					return false;
				}
				var existing_zip_codes = <?php echo json_encode(get_field('zip_codes', 'option')); ?>;
				// Extract "code" values from the array
				var codesArray = existing_zip_codes.map(function(item) {
					return item.codes;
				});

				if (codesArray.includes(zip)) {
					$('.message').removeClass('hidden').removeClass('error-message').addClass('success-message').html("Valid zip code entered.");
					$('.field').removeClass('current');
					$('.field2').addClass('current');
				} else {
					// accepted range = 79760, 79761 last digit goes up to 9
					// $('.message').removeClass('hidden').removeClass('success-message').addClass('error-message').html('Please enter a valid zip code.') ;
					$('.message').removeClass('hidden').removeClass('success-message').html('');
					Swal.fire({
						title: "info",
						text: "Sorry we are not ready for your area yet",
						icon: "info",
					});
				}
			} else if ((currentField > 1) && (currentField < 5)) {
				nextField = parseInt(currentField) + parseInt(1);
				nextField = "#field" + nextField;
				//$('body').prepend(nextField);
				$('.field').removeClass('current');
				$(nextField).addClass('current');
			}
			return false;
		});

		/*$('.next').click(function(){
			if( $('#location').val() != "" && $('#location').val() != "79760" )
				// accepted range = 79760, 79761 last digit goes up to 9
				{ $('.error-message').removeClass('hidden') ;}
			return false;
		});*/

		$('.increase').click(function() {
			var slide = $('#filter-number').val();

			if (slide < 5) {
				slide++;
				$('#filter-number').val(slide); // Update the input value
				// $('#good').attr('plan-price',good_p_pr * slide);
				// $('#better').attr('plan-price',better_p_pr * slide);
				// $('#best').attr('plan-price',best_p_pr * slide);
				// $('#field5').find('.plan_price').val(good_p_pr * slide);
				// $('#field5').find('.filter_price').text(good_p_pr * slide);
				$('.filter_count').text(slide);
				$('.filter_num').val(slide);

				resetFilters();
				cloneFilters(slide);
				//document.getElementById('filter-number').value++; 
			}
			return false;
		});

		$('.decrease').click(function() {
			var slide = $('#filter-number').val();
			if (slide > 1) {
				slide--;
				$('#filter-number').val(slide); // Update the input value
				// $('#good').attr('plan-price',good_p_pr * slide);
				// $('#better').attr('plan-price',better_p_pr * slide);
				// $('#best').attr('plan-price',best_p_pr * slide);
				// $('#field5').find('.plan_price').val(good_p_pr * slide);
				// $('#field5').find('.filter_price').text(good_p_pr * slide);

				$('.filter_count').text(slide);
				$('.filter_num').val(slide);
				resetFilters();
				cloneFilters(slide);
				//document.getElementById('filter-number').value--;
			}
			return false;
		});

		function resetFilters() {
			$('.filter-size:gt(0)').remove(); // Remove all filters except the first one
		}

		function cloneFilters(number) {
			var originalFilter = $('.filter-size:first');
			for (var i = 1; i < number; i++) {
				var newFilter = originalFilter.clone().insertAfter('.filter-size:last');
				newFilter.removeClass('filter1').addClass('filter' + (i + 1));
				newFilter.find('.filter-label').text('Filter ' + (i + 1));
			}
		}


		/*$('.fields').cycle({
			fx: 'fade',
			//pager: '.navigation',
			pagerActiveClass: 'active',
			pagerTemplate: '<a href="#">{{title}}</a>',
			slides : ".field",
			timeout: 12000,
			height: 'auto',
				'prev' : '.prev',
				'next' : '.next'
		}); */


		$('.progress li a').click(function() {
			$('.tab-active').removeClass('tab-active');
			$(this).parent('li').addClass('tab-active');
			$('.field').removeClass('current');
			$($(this).attr('href')).addClass('current');
			return false;
		});



		$(document).on('change', '.thickness select', function() {

			if ($(this).val() == '2"' || $(this).val() == '4"') {
				$(this).parents('.filter-size').find('.width option, .height option').addClass('hidden');
				$(this).parents('.filter-size').find('.width option.essential-size, .height option.essential-size').removeClass('hidden');
				$(this).parents('.filter-size').find('.width .essential-size:first, .height .essential-size:first').prop('selected', true);
			}
			if ($(this).val() == '1"') {
				$(this).parents('.filter-size').find('.width option, .height option').removeClass('hidden');
				$(this).parents('.filter-size').find('.width option:first, .height option:first').prop('selected', true);

			}

		});

		$(document).on('change', '.filter_select', function() {
			$('#filter-details').empty(); // Clear previous filter details
			$('.filter-size').each(function(index) {
				var filterLabel = $(this).find('.filter-label').text();
				var width = $(this).find('.width select').val();
				var height = $(this).find('.height select').val();
				var thickness = $(this).find('.thickness select').val();

				var filterDetails = `<li><strong>${filterLabel}</strong>: <span class="filter_val">${width} x ${height} x ${thickness}"</span></li>`;
				$('#filter-details').append(filterDetails);
			});
		});

		$('.next').click(function() {
			currentField = $('.current').attr('data-field');
			if (currentField == "3") {
				$('#filter-details').empty(); // Clear previous filter details
				$('.filter-size').each(function(index) {
					var filterLabel = $(this).find('.filter-label').text();
					var width = $(this).find('.width select').val();
					var height = $(this).find('.height select').val();
					var thickness = $(this).find('.thickness select').val();

					var filterDetails = `<li><strong>${filterLabel}</strong>: <span class="filter_val">${width} x ${height} x ${thickness}"</span></li>`;
					$('#filter-details').append(filterDetails);
				});
			}
			return false;
		});


		$(document).on('click', '.filter-type', function() {
			$('.filter-type').removeClass('active');
			$(this).addClass('active');
			$(this).find('input').prop('checked', true);
			var plan_price = $(this).find('.plan').attr('plan-price');
			var plan_type = $(this).find('.plan').val();
			$('.filter_price').text(plan_price);
			$('.filter_plan').text(plan_type);
			$('.plan_price').val(plan_price);
			$('.plan_filter').val(plan_type);
			$('.filter_type').val(plan_type);
		});

		// Initialize the PayPal JavaScript SDK

		// var planid = <?php echo json_encode(get_field('subscription_plans', 'option')); ?>;
		// var planidArray = [];
		// var planPriceArray = [];
		// // Extract "code" values from the array
		// planid.forEach(function(item) {
		// 	planidArray.push(item.plan_id);
		// 	planPriceArray.push(item.plan_price);
		// });



		// console.log("planid", planidArray);
		// console.log("planPrice", planPriceArray);
		// $('.next').click(function(){
		// 	currentField = $('.current').attr('data-field');
		// 	var checkoutPrice = jQuery('.filter-type input:checked').attr('plan-price');
		// 	// var tax = (checkoutPrice/100) * 8.25;

		// 	// var fnlprice = tax + parseFloat(checkoutPrice);
		// 	// $('.plan_price').val(checkoutPrice);
		// 	// $('.filter_price').text(fnlprice.toFixed(2));
		// 	//console.log("checkoutPrice", checkoutPrice);
		// 	//var checkoutPrice = $('.plan_price').val();

		// 	var index = planPriceArray.indexOf(checkoutPrice);
		// 	//console.log("index", index);

		// 	// console.log("currentField", currentField);
		// 	if(currentField == "5" && index !== -1){
		// 		$('#paypal-buttons').empty(); // Clear previous paypal buttons
		// 		var correspondingPlanId = planidArray[index];

		// 		paypal.Buttons({
		// 			style: {
		// 				shape: 'pill',
		// 				color: 'gold',
		// 				layout: 'vertical',
		// 				label: 'subscribe'
		// 			},
		// 			createSubscription: function(data, actions) {
		// 				return actions.subscription.create({

		// 				plan_id: correspondingPlanId
		// 				});
		// 			},
		// 			onApprove: function(data, actions) {
		// 				//alert(data.subscriptionID); // You can add optional success message for the subscriber here
		// 				var form = $('.checkout').serialize();
		// 				jQuery('body').waitMe({
		// 					effect : 'bounce',
		// 					text : '',
		// 					bg : 'rgba(255,255,255,0.7)',
		// 					color : '#000',
		// 					maxSize : '',
		// 					waitTime : -1,
		// 					textPos : 'vertical',
		// 					fontSize : '',
		// 					source : '',
		// 				});
		// 				// Implement logic to handle successful payment
		// 				//console.log(details);
		// 				//alert('Transaction completed by ' + details.payer.name.given_name);
		// 				$.ajax({
		// 					type: 'post',
		// 					url: "<?= admin_url('admin-ajax.php') ?>",
		// 					data: {
		// 						action: 'purchase_plan',
		// 						form_data: form,
		// 						subscription_id: data.subscriptionID,
		// 					},
		// 					dataType : 'json',
		// 					success: function (response) {
		// 						jQuery('body').waitMe('hide');
		// 						Swal.fire({
		// 							icon: response.icon,
		// 							title: response.title,
		// 							text: response.message,
		// 							showConfirmButton: false,
		// 						});
		// 						if(response.status){
		// 							window.location.href = response.redirect;
		// 						}
		// 					},
		// 					error : function(errorThrown){
		// 						jQuery('body').waitMe('hide');
		// 						console.log(errorThrown);
		// 					}
		// 				});
		// 			}
		// 		}).render('#paypal-buttons'); // Renders the PayPal button
		// 	}
		// 	else {
		// 		// console.log("No plan found for the checkout price: " + checkoutPrice);
		// 		$('#paypal-buttons').empty(); // Clear previous paypal buttons
		// 	}
		// });

		$('.checkout input').on('input', function() {
			// Check if all input fields are filled
			var allFieldsFilled = $('.checkout input').filter(function() {
				return $(this).val() !== '';
			}).length === $('.checkout input').length;

			// Update styles of the "paypal-buttons" div based on the condition
			if (allFieldsFilled) {
				$('#paypal-buttons').css({
					'pointer-events': 'auto',
					'opacity': '1'
				});
			} else {
				$('#paypal-buttons').css({
					'pointer-events': 'none',
					'opacity': '0.3'
				});
			}
		});




		$(document).on('change', '.user_email', function(e) {
			var email = $(this).val();

			jQuery('body').waitMe({
				effect: 'bounce',
				text: '',
				bg: 'rgba(255,255,255,0.7)',
				color: '#000',
				maxSize: '',
				waitTime: -1,
				textPos: 'vertical',
				fontSize: '',
				source: '',
			});

			$.ajax({
				type: 'post',
				url: "<?= admin_url('admin-ajax.php') ?>",
				data: {
					action: 'email_validation',
					user_email: email,
				},
				dataType: 'json',
				success: function(response) {
					jQuery('body').waitMe('hide');
					console.log(response.status);
					jQuery('.note').empty();
					if (!response.status) {
						jQuery('.note').html(response.message);
						jQuery('#paypal-buttons').css({
							'pointer-events': 'none',
							'opacity': '0.3'
						});
					}
				},
				error: function(errorThrown) {
					jQuery('body').waitMe('hide');
					console.log(errorThrown);
				}
			});
		});

		var variations = <?php echo json_encode(get_field('thickness_variations_', 'option')); ?>;

		var priceLookup = {}; // Create an empty object for price lookup

		// // Populate the priceLookup object with variation_name as keys and variation_price as values
		variations.forEach(function(variation) {
			var plan = variation.plan;
			var thickness = variation.thickness;
			var price = variation.thickness_price;

			// Check if the plan already exists in the structured object
			if (!priceLookup[plan]) {
				priceLookup[plan] = {}; // Initialize an empty object for the plan if it doesn't exist
			}

			//Assign the price to the corresponding thickness under the plan
			priceLookup[plan][thickness] = price;
		});



		$('.next').click(function() {
			currentField = $('.current').attr('data-field');

			if (currentField == "4") {
				var goodPlan = 0;
				var betterPlan = 0;
				var bestPlan = 0;
				$('.filter-size').each(function(index) {
					var thickness = $(this).find('.thickness select').val();
					goodPlan += parseInt(priceLookup["Good"][thickness]);
					betterPlan += parseInt(priceLookup["Better"][thickness]);
					bestPlan += parseInt(priceLookup["Best"][thickness]);

				});

				jQuery('.filter-type.good input').attr('plan-price', goodPlan);
				jQuery('.filter-type.better input').attr('plan-price', betterPlan);
				jQuery('.filter-type.best input').attr('plan-price', bestPlan);
				jQuery('.good_p_pr').text(goodPlan);
				jQuery('.better_p_pr').text(betterPlan);
				jQuery('.best_p_pr').text(bestPlan);

			}
		});




		$('.next').click(function() {
			currentField = $('.current').attr('data-field');
			if (currentField == "5") {

				var selectedPlan = parseInt(jQuery('.filter-type input:checked').attr('plan-price'));
				var selectedPlanName = jQuery('.filter-type input:checked').val();

				var tax = (selectedPlan / 100) * 8.25;
				var fnlprice = tax + parseFloat(selectedPlan);
				$('.plan_price').val(selectedPlan);
				$('.filter_price').text(fnlprice.toFixed(2));

				// console.log("selectedPlan", selectedPlan);
				// console.log("fnlprice", fnlprice);
				showWaitIndicator();

				$.ajax({
					type: 'post',
					url: "<?= admin_url('admin-ajax.php') ?>",
					data: {
						action: 'create_plan',
						selectedPlan: selectedPlan,
						planPrice: fnlprice,
						selectedPlanName: selectedPlanName,
					},
					dataType: 'json',
					success: function(response) {
						hideWaitIndicator();
						console.log("plan_id", response.plan_id);

						clearPayPalButtons(); // Clear previous paypal buttons

						renderPayPalButtons(response.plan_id);


					},
					error: function(errorThrown) {
						hideWaitIndicator();
						console.log(errorThrown);
					}
				});
			}
		});

		function showWaitIndicator() {
			jQuery('body').waitMe({
				effect: 'bounce',
				text: '',
				bg: 'rgba(255,255,255,0.7)',
				color: '#000',
				maxSize: '',
				waitTime: -1,
				textPos: 'vertical',
				fontSize: '',
				source: '',
			});
		}

		function hideWaitIndicator() {
			jQuery('body').waitMe('hide');
		}

		function clearPayPalButtons() {
			$('#paypal-buttons').empty();
		}

		function renderPayPalButtons(planId) {
			paypal.Buttons({
				style: {
					shape: 'pill',
					color: 'gold',
					layout: 'vertical',
					label: 'subscribe'
				},
				createSubscription: function(data, actions) {
					return actions.subscription.create({
						plan_id: planId
					});
				},
				onApprove: function(data, actions) {
					showWaitIndicator();
					var formData = $('.checkout').serialize();

					$.ajax({
						type: 'post',
						url: '<?= admin_url('admin-ajax.php') ?>',
						data: {
							action: 'purchase_plan',
							form_data: formData,
							subscription_id: data.subscriptionID
						},
						dataType: 'json',
						success: function(response) {
							hideWaitIndicator();
							Swal.fire({
								icon: response.icon,
								title: response.title,
								text: response.message,
								showConfirmButton: false
							});
							if (response.status) {
								window.location.href = response.redirect;
							}
						},
						error: function(errorThrown) {
							hideWaitIndicator();
							console.log(errorThrown);
							Swal.fire({
								icon: "error",
								title: "Error",
								text: errorThrown.err,
								showConfirmButton: false
							});
						}
					});
				}
			}).render('#paypal-buttons');
		}


		jQuery(".checkout").submit(function(e){

			var formData = $(this).serialize();

			$.ajax({
				type: 'post',
				url: '<?= admin_url('admin-ajax.php') ?>',
				data: {
					action: 'purchase_plan',
					form_data: formData,
					subscription_id: 1
				},
				dataType: 'json',
				success: function(response) {
					hideWaitIndicator();
					Swal.fire({
						icon: response.icon,
						title: response.title,
						text: response.message,
						showConfirmButton: false
					});
					if (response.status) {
						window.location.href = response.redirect;
					}
				},
				error: function(errorThrown) {
					hideWaitIndicator();
					console.log(errorThrown);
					Swal.fire({
						icon: "error",
						title: "Error",
						text: errorThrown.err,
						showConfirmButton: false
					});
				}
			});

		});


		// $(document).on('click', '.filter-type', function(){
		// 	$(this).find('input').prop('checked', true);
		// });
		// var iframe = jQuery(".component-frame");
		// iframe.load(function() {
		// 	// Wait for the iframe to fully load
		// 	iframe.contents().find("head").append("<style>.paypal-button-number-1 { display: none; }</style>");
		// });


	});
</script>