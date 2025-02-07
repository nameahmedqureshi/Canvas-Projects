(function($){

    $(document).ready(function(){

	// Add Jeep
	$("#addJeep").submit(function(e) {
		e.preventDefault();
		//var form = $(this).serialize();
		var form = new FormData(this);
		$(this).find('button.submit_btn').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
		$(this).find('button.submit_btn').prop('disabled',true);
		var thiss = $(this);
		$.ajax({
			type: 'post',
			url: ajax_script.ajax_url,
			data: form, // Use FormData directly
			dataType : 'json',
			cache:false,
			contentType: false,
			processData: false,
			success: function (response) {
				$('.fa.fa-spinner.fa-spin').remove();
				$(thiss).find('button.submit_btn').prop('disabled',false);
				$('#addJeep')[0].reset();
				Swal.fire({
					icon: 'success',
					title: response.message,
					showConfirmButton: false,
					timer: 2500
				  });
				  window.location.href = response.redirect;
			},
			error : function(errorThrown){ 
			   console.log(errorThrown);
		   }
		});
	}); 


	// // Add Duck
	// $("#addDuck").submit(function(e) {
	// 	e.preventDefault();
	// 	var form = new FormData(this);
	// 	console.log('form--->', form);
	// 			$.ajax({
	// 				type: 'post',
	// 				url: ajax_script.ajax_url,
	// 				data: form, // Use FormData directly
	// 				dataType : 'json',
	// 				cache:false,
	// 				contentType: false,
	// 				processData: false,
	// 				success: function (response) {
	// 					console.log("response", response);
	// 					$('#addDuck')[0].reset();
	// 					Swal.fire({
	// 						icon: 'success',
	// 						title: response.message,
	// 						showConfirmButton: false,
	// 						timer: 2500
	// 					});
	// 				},
	// 				error : function(errorThrown){ 
	// 				console.log(errorThrown);
	// 				}
	// 			});
	// }); 

	$("#addJeepGallery").submit(function(e) {
		e.preventDefault();
		var form = new FormData(this);
		$(this).find('button.submit_btn').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
		$(this).find('button.submit_btn').prop('disabled',true);
		var thiss = $(this);
		$.ajax({
			type: 'post',
			url: ajax_script.ajax_url,
			data: form,
			dataType : 'json',
			cache:false,
			contentType: false,
			processData: false,
			success: function (response) {
				$('.fa.fa-spinner.fa-spin').remove();
				$(thiss).find('button.submit_btn').prop('disabled',false);
				$('#addJeepGallery')[0].reset();
				Swal.fire({
					icon: 'success',
					title: response.message,
					showConfirmButton: false,
					timer: 2500
				  });
				  window.location.href = response.redirect;
			},
			error : function(errorThrown){ 
			   console.log(errorThrown);
		   }
		});
	}); 

	// alternative duck forms
	// var formCounter = 0;
	// $('.add_btn').on('click', function(e) {
	// 	e.preventDefault();
	// 	var clonedForm = $(this).closest('.galleryDiv').clone(true);
	// 	 // Increment the counter
	// 	 formCounter++;
	// 	// Update input names with the counter
	// 	clonedForm.find('input[name^="gallery_title_"]').attr('name', 'gallery_title_' + formCounter);
	// 	clonedForm.find('input[name^="gallery_desc_"]').attr('name', 'gallery_desc_' + formCounter);
	// 	clonedForm.find('input[name^="gallery_image_"]').attr('name', 'gallery_image_' + formCounter);
	
	// 	$(this).closest('.galleryDiv').after(clonedForm);
	// }); 

	// $(document).on('click', '.delete-button', function() {
	// 	if(confirm("Are you sure you want to delete this?")){
	// 		$(this).parent().remove();
	// 	}
	// 	return false;
  	// });

	//Delete Jeep
	
	$(document).on( 'click', '.delete_post', function(e) {
		e.preventDefault();
		var id = $(this).attr('post');
		var post= $(this);
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'post',
					url: ajax_script.ajax_url,
					data: {
						action: 'delete_jeep',
						post_id: id
					},
					dataType : 'json',
					success: function (response) {
						Swal.fire(
							'Deleted!',
							'Your jeep has been deleted.',
							'success'
						  )
						post.parents('.col-lg-3').fadeOut();
					},
					error : function(errorThrown){
						console.log(errorThrown);
					}
				});
			}
		});
	}); 

	//Delete jeep gallery
	$(document).on( 'click', '.delete_gallery', function(e) {
		e.preventDefault();
		var id = $(this).attr('post');
		var key = $(this).attr('key');
		var post= $(this);
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'post',
					url: ajax_script.ajax_url,
					data: {
						action: 'delete_jeep_gallery',
						post_id: id,
						meta_key: key,
					},
					dataType : 'json',
					success: function (response) {
						Swal.fire(
							'Deleted!',
							'Your gallery has been deleted.',
							'success'
						  )
						post.parents('.col-lg-3').fadeOut();	
					},
					error : function(errorThrown){
						console.log(errorThrown);
					}
				});
			}
		});
	}); 

	// Edit Profile
	$("#edit-profile").submit(function(e) {
		e.preventDefault(); // avoid to execute the actual submit of the form.
		var form = $(this).serialize();
		$(this).find('button.submit_btn').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
		$(this).find('button.submit_btn').prop('disabled',true);
		var thiss = $(this);
		$.ajax({
			type: 'post',
			url: ajax_script.ajax_url,
			data: {
				action: 'update_user_profile',
				form_data: form
			},
			dataType : 'json',
			// cache:false,
			// contentType: false,
			// processData: false,
			success: function (response) {
				$('.fa.fa-spinner.fa-spin').remove();
				$(thiss).find('button.submit_btn').prop('disabled',false);
				Swal.fire({
					icon: 'success',
					title: response,
					showConfirmButton: false,
					timer: 2500
				  });
			},
			error : function(errorThrown){
			   console.log(errorThrown);
		   }
		});
	}); 

	//Contact Form
	$("#contact").submit(function(e) {
		e.preventDefault(); // avoid to execute the actual submit of the form.
		var form = $(this).serialize();
		$(this).find('button.submit_btn').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
		$(this).find('button.submit_btn').prop('disabled',true);
		var thiss = $(this);
		$.ajax({
			type: 'post',
			url: ajax_script.ajax_url,
			data: {
				action: 'add_contact',
				form_data: form
			},
			dataType : 'json',
			success: function (response) {
				$('.fa.fa-spinner.fa-spin').remove();
				$(thiss).find('button.submit_btn').prop('disabled',false);
				$('#contact')[0].reset();
				Swal.fire({
					icon: 'success',
					title: response,
					showConfirmButton: false,
					timer: 2500
				  });
			},
			error : function(errorThrown){
			   console.log(errorThrown);
		   }
		});
	}); 

	// Qr code generate
	
	// $(document).on('click', '.showqr', function (e) {
	// 	e.preventDefault();
		
	// 	$('#qrcode').empty();
	// 	makeCode($(this).attr('data'));
	// });
	
	// function makeCode(id) {  
	// 	var qrcode = new QRCode("qrcode");
	// 	console.log("id-->",id); 
	// 	$.ajax({
	// 		type: 'post',
	// 		url: ajax_script.ajax_url,
	// 		data: {
	// 			action: 'getQRCode',
	// 			duck_id: id,
	// 		},
	// 		dataType : 'json',
	// 		success: function (response) {
	// 			//console.log(response);
	// 			Swal.fire({
	// 				icon: 'success',
	// 				title: response.message,
	// 				showConfirmButton: false,
	// 				timer: 2500
	// 			  });
	// 			qrcode.clear(); // clear the code.
	// 			qrcode.makeCode(response.data);
	// 		},
	// 		error : function(errorThrown){
	// 			console.log(errorThrown);
	// 		}
	// 	});
	
	// 	// var qrcode = new QRCode("qrcode");
	// 	// var elText = $('.qr-content').val();
	// 	// if (!elText) {
	// 	// 	alert("Enter text you want to get in qr code");
	// 	// 	$('.qr-content').focus();
	// 	// 	return;
	// 	// }
	// 	//  qrcode.clear(); // clear the code.
	// 	//  qrcode.makeCode(elText);
		
	// 	// $('.download').show();
	// }
	
	// Remove image
	
	jQuery('.fa-remove').on('click', function(){
		$(this).next('img').remove();
		$(this).remove();
		$(".upload_card").show();
	});

	// IMAGAE UPLOAD 
	$('#avatarInput').on('change', function (e) {
		var input = e.target;
		var imagePreview = $('#avatarImage');
		var uploadBox = $('.upload_card');

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				// Show cross mark
				imagePreview.before('<span class="cross_mark">✖</span>');
				$('#avatarImage').attr('src', e.target.result);
				// Hide upload box
				uploadBox.hide();
				
			};

			reader.readAsDataURL(input.files[0]);
		}
	});

	// Function to handle cross mark click
	$(document).on('click', '.cross_mark', function(){
		var imagePreview = $('#avatarImage');
		var uploadBox = $('.upload_card');
		var fileInput = $('#avatarInput');

		// Show upload box
		uploadBox.show();

		// Remove cross mark
		$('.cross_mark').remove();

		// Clear file input
		fileInput.val('');

		// Clear image preview
		imagePreview.attr('src', '');
	});

	// TOP DROPDOWN
	$("#user_info").click(function(event) {
		event.stopPropagation(); 
		$(".nav_dropdown").slideToggle();
	});

	$("body").click(function() {
		if (!$(event.target).closest('.nav_dropdown').length) {
			$(".nav_dropdown").slideUp();
		}
	});
});
})(jQuery);