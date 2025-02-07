/* ONCLICK-TOP */
(function($) { 
		
	$(document).ready(function(){

		// Get the current page URL
		var currentUrl = window.location.href;
		$('.nav_bar a').each(function() {
			if (this.href == currentUrl) {
				$(this).closest('li').addClass('active');
			}

		});

		jQuery('li.active').parent('.drop_dwon_list').show();

		$(document).on( 'click', '.cross', function(e) {
			e.preventDefault(); 
			$('.right-open').hide(1000);
		});

		// create folder
		$(document).on( 'click', '.create-folder', function(e) {
			e.preventDefault();
			var thiss = $(this);
			Swal.fire({
				title: "Create a new folder.",
				// input: "email",
				html:
				'<input id="name" type="text" class="swal2-input" placeholder="Enter Folder Name" required>',
				showCancelButton: true,
				confirmButtonColor: "#1FAB45",
				confirmButtonText: "Create Folder",
				cancelButtonText: "Cancel",
				buttonsStyling: true
			}).then(function (result) {    
				if (result.isConfirmed) {
					// var email = result.value;   
					var name = $('#name').val();				
					// Check if both inputs are filled
					if (!name) {
						// Handle the case where one or both inputs are not filled
						Swal.fire('Name is required', '', 'error');
						return;
					}
					$('body').waitMe({
						effect : 'bounce',
						text : '',
						bg : 'rgba(255,255,255,0.7)',
						color : '#000',
						maxSize : '',
						waitTime : -1,
						textPos : 'vertical',
						fontSize : '',
						source : '',
					});
					$.ajax({
						type: "POST",
						url: ajax_script.ajax_url,
						data: {
							action: 'create_folder',
							name: name,
						},
						dataType : 'json',
						success: function(response) {
							$('body').waitMe('hide');
							Swal.fire({
								icon: response.icon,
								title: 'Success',
								text: response.message,
								showConfirmButton: false,

							});
							window.location.href = response.redirect;
						},
						failure: function (response) {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: response.message,
								showConfirmButton: true,
							});
						}
					});
				}
			});
		}); 

		// edit folder
		
		$(document).on( 'click', '.edit-folder', function(e) {
			e.preventDefault();
			var post_id = $(this).parents('li').find('a').attr('data-id')
			console.log("post_id", post_id);
			var thiss = $(this);
			Swal.fire({
				title: "Rename a folder.",
				// input: "email",
				html:
				'<input id="name" type="text" class="swal2-input edit" placeholder="Enter Folder Name" required>',
				showCancelButton: true,
				confirmButtonColor: "#1FAB45",
				confirmButtonText: "Rename Folder",
				cancelButtonText: "Cancel",
				buttonsStyling: true
			}).then(function (result) {    
				if (result.isConfirmed) {
					// var email = result.value;   
					var name = $('#name').val();				
					// Check if both inputs are filled
					if (!name) {
						// Handle the case where one or both inputs are not filled
						Swal.fire('Name is required', '', 'error');
						return;
					}
					$('body').waitMe({
						effect : 'bounce',
						text : '',
						bg : 'rgba(255,255,255,0.7)',
						color : '#000',
						maxSize : '',
						waitTime : -1,
						textPos : 'vertical',
						fontSize : '',
						source : '',
					});
					$.ajax({
						type: "POST",
						url: ajax_script.ajax_url,
						data: {
							action: 'create_folder',
							name: name,
							post_id, post_id,
						},
						dataType : 'json',
						success: function(response) {
							$('body').waitMe('hide');
							Swal.fire({
								icon: response.icon,
								title: 'Success',
								text: response.message,
								showConfirmButton: false,

							});
							window.location.href = response.redirect;
						},
						failure: function (response) {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: response.message,
								showConfirmButton: true,
							});
						}
					});
				}
			});
		}); 

		// get name on rename folder
		jQuery(document).on( 'click', '.edit-folder', function(e) {
			var folderName = jQuery(this).closest('li').children('a').text().replace(/\s|\|/g, '');
			jQuery('.swal2-input.edit').val(folderName);

		}); 
		
		$(document).on( 'click', '.link-deleted', function(e) {
			e.preventDefault();
    		var post_id = $(this).attr('data-id')
			console.log("post_id", post_id);
			var thiss = $(this);

			$('body').waitMe({
				effect : 'bounce',
				text : '',
				bg : 'rgba(255,255,255,0.7)',
				color : '#000',
				maxSize : '',
				waitTime : -1,
				textPos : 'vertical',
				fontSize : '',
				source : '',
			});
			// Make the API call
			$.ajax({
				type: 'post',
				url: ajax_script.ajax_url,
				data: {
					action: 'delete_link',
					post_id: post_id
				},
				dataType : 'json',
				success: function(response) {	
					$('body').waitMe('hide');
					if(response.status){
						toastr.success("Link Deleted");
						thiss.parents('tr').fadeOut();
					}
				},
				error: function(error) {
					$('body').waitMe('hide');
					// Handle the API error
					console.error(error);
				}
			});

		}); 

		$(document).on( 'click', '.folder-deleted', function(e) {
			e.preventDefault();
    		var post_id = $(this).attr('data-id')
			console.log("post_id", post_id);
			var thiss = $(this);

			$('body').waitMe({
				effect : 'bounce',
				text : '',
				bg : 'rgba(255,255,255,0.7)',
				color : '#000',
				maxSize : '',
				waitTime : -1,
				textPos : 'vertical',
				fontSize : '',
				source : '',
			});
			// Make the API call
			$.ajax({
				type: 'post',
				url: ajax_script.ajax_url,
				data: {
					action: 'delete_folder',
					post_id: post_id
				},
				dataType : 'json',
				success: function(response) {	
					$('body').waitMe('hide');
					Swal.fire({
						title: "Are you sure?",
						text: "You won't be able to revert this!",
						icon: "warning",
						showCancelButton: true,
						confirmButtonColor: "#3085d6",
						cancelButtonColor: "#d33",
						confirmButtonText: "Yes, delete it!"
					  }).then((result) => {
						if (result.isConfirmed) {
							if(response.status){
								toastr.success("Folder Deleted");
								thiss.parents('li').fadeOut();
							}
						}
					  });
				},
				error: function(error) {
					$('body').waitMe('hide');
					// Handle the API error
					console.error(error);
				}
			});

		}); 
		
		$(document).on( 'click', '.upload_btn_top', function(e) {
			e.preventDefault();
			$('.main_col_right').show(1000);
		}); 


	
		
		$(document).on( 'click', '.fa-copy', function(e) {
			e.preventDefault(); 
			// Get the value of the input field
			var value = $(this).data('url');
			// Create a temporary input element
			var $tempElement = $("<input>");
			// Append the temporary input element to the body
			$("body").append($tempElement);
			// Set the value of the temporary input element
			$tempElement.val(value).select();
			// Copy the text inside the temporary input element
			document.execCommand("Copy");
			// Remove the temporary input element from the DOM
			$tempElement.remove();
			// Alert the user that the link has been copied
			toastr.success("Link Copied");
			
		});

		$(document).on( 'click', '.copy-link', function(e) {
			e.preventDefault(); 
			// Get the value of the input field
			var value = $(this).siblings('.transfer-link__url').val();
			// Create a temporary input element
			var $tempElement = $("<input>");
			// Append the temporary input element to the body
			$("body").append($tempElement);
			// Set the value of the temporary input element
			$tempElement.val(value).select();
			// Copy the text inside the temporary input element
			document.execCommand("Copy");
			// Remove the temporary input element from the DOM
			$tempElement.remove();
			// Alert the user that the link has been copied
			toastr.success("Link Copied");
			$('.transfer-link').empty();
			$('.transfer-link').html('<div class="transfer-link"><button class="upload-again">Upload Another?</button></div>');
		});
		
		$(document).on( 'click', '.upload-again', function(e) {
			e.preventDefault();
			// Reload the current page
			location.reload();
			// $('.transfer-link').hide();
			// $('#upload').show();
		});

		$('#myTable').DataTable( {
    		responsive: true,
    		// paging: false,
    		scrollCollapse: true,
    		scrollY: '550px'    
    	} );

    	$(".drop_dwon_nav").click(function(){
    		$(this).toggleClass("collapsed");
    		$(".drop_dwon_list").slideToggle();
    	});

		
	
		//Scroll back to top
		
		// var progressPath = document.querySelector('.progress-wrap path');
		// var pathLength = progressPath.getTotalLength();
		// progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
		// progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
		// progressPath.style.strokeDashoffset = pathLength;
		// progressPath.getBoundingClientRect();
		// progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';		
		// var updateProgress = function () {
		// 	var scroll = $(window).scrollTop();
		// 	var height = $(document).height() - $(window).height();
		// 	var progress = pathLength - (scroll * pathLength / height);
		// 	progressPath.style.strokeDashoffset = progress;
		// }
		// updateProgress();
		// $(window).scroll(updateProgress);	
		// var offset = 50;
		// var duration = 50;
		// jQuery(window).on('scroll', function() {
		// 	if (jQuery(this).scrollTop() > offset) {
		// 		jQuery('.progress-wrap').addClass('active-progress');
		// 	} else {
		// 		jQuery('.progress-wrap').removeClass('active-progress');
		// 	}
		// });			

		// jQuery('.progress-wrap').on('click', function(event) {
		// 	event.preventDefault();
		// 	jQuery('html, body').animate({scrollTop: 0}, duration);
		// 	return false;
		// });

	});
})(jQuery); 
/* ONCLICK-TOP */