(function ($) {
    $(document).ready(function () {

       

         // PASSWORD SHOW HIDE
        jQuery(".toggle_password").click(function($) {
            jQuery(this).toggleClass("fa-eye fa-eye-slash");
            var input = jQuery(jQuery(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        // add media
        $('.select_media').on('change', function(e) {
            // Check if a file is selected
            if (this.files.length > 0) {
                // Submit the form
                $('.upload_media').submit();
            }
        }); 

        jQuery(".upload_media").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            
			var form = new FormData(this);	
			var thiss = jQuery(this);
			jQuery('body').waitMe({
                effect : 'facebook',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: form,
                dataType : 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                    jQuery('body').waitMe('hide');
                    console.log(response);
                    if(!response.status){
                        toastr.error(response.message,  response.title);
					}
                    else{
                        toastr.success(response.message,  response.title);
                        $('#add_media .col_2').first().after(response.media);
					} 
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                   jQuery('body').waitMe('hide');
               }
            });
        }); 

        // add post or page
        jQuery(".add_post_or_page").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            
			var form = new FormData(this);	
			jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
			jQuery(this).find('button[type=submit]').prop('disabled',true);
			var thiss = jQuery(this);
			jQuery('body').waitMe({
                effect : 'facebook',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: form,
                dataType : 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
					jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                    console.log(response);
                    if(!response.status){
						Swal.fire({
							title: response.title,
							text:  response.message,
							icon: response.icon,
							})
					}
                    else{
						if (response.auto_redirect) {window.location.href = response.redirect_url;}
						else{ 
							Swal.fire({
								title: response.title,
								text:  response.message,
								icon: response.icon,
								
							  }).then((willDelete) => {
							  if (response.redirect_url) {window.location.href = response.redirect_url;}
							}); 
						}
					
					} 
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                   jQuery('body').waitMe('hide');
               }
            });
        }); 
        
        // delete media
        jQuery(document).on("click",".delete-image", function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            
			var post_id = $(this).attr('media');	
            console.log("media", post_id);
           
			var thiss = jQuery(this);
			jQuery('body').waitMe({
                effect : 'facebook',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: {
                    action: 'delete_media',
                    post_id: post_id,
                },
                dataType : 'json',
                success: function (response) {
                   
                    jQuery('body').waitMe('hide');
                    console.log(response);
                    if(!response.status){
                        toastr.error(response.message,  response.title);
					}
                    else{
                        toastr.success(response.message,  response.title);
                        thiss.parents('.image-container').fadeOut(1000);
					} 
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                   jQuery('body').waitMe('hide');
               }
            });
        }); 
        // add tags
        jQuery(".add_tags").click(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            
			var tags = $(this).parents('.ptags').find('.tags').val();	
            console.log("tags", tags);
            if(tags == ""){
                toastr.error("Error", "Please insert tags");
                return false;
            }
			jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
			jQuery(this).find('button[type=submit]').prop('disabled',true);
			var thiss = jQuery(this);
			jQuery('body').waitMe({
                effect : 'facebook',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: {
                    action: 'add_tags_catgs',
                    tags: tags,
                },
                dataType : 'json',
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
					jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                    console.log(response);
                    if(!response.status){
                        toastr.error(response.message,  response.title);
					}
                    else{
                        toastr.success(response.message,  response.title);
                        $('.post_all_tags').prepend(response.post_tags);
                        thiss.parents('.ptags').find('.js-example-basic-single').empty();
					} 
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                   jQuery('body').waitMe('hide');
               }
            });
        }); 

        // add category
        jQuery(".add_catgs").click(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            
			var catgs = $(this).parents('.p_catgs').find('.catgs').val();	
            console.log("catgs", catgs);
            if(catgs == ""){
                toastr.error("Error", "Please insert category");
                return false;
            }
			jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
			jQuery(this).find('button[type=submit]').prop('disabled',true);
			var thiss = jQuery(this);
			jQuery('body').waitMe({
                effect : 'facebook',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: {
                    action: 'add_tags_catgs',
                    catgs: catgs,
                },
                dataType : 'json',
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
					jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                    console.log(response);
                    if(!response.status){
                        toastr.error(response.message,  response.title);
					}
                    else{
                        toastr.success(response.message,  response.title);

                        $('.post_all_categories').prepend(response.post_categories);
                        thiss.parents('.p_catgs').find('.js-example-basic-single').empty();
                       
					} 
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                   jQuery('body').waitMe('hide');
               }
            });
        }); 

        // delete post or page
        jQuery(".delete-post-page").click(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            
			var post_id = $(this).attr('post_id');	
            console.log("post_id", post_id);
		
			var thiss = jQuery(this);
			jQuery('body').waitMe({
                effect : 'facebook',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: {
                    action: 'delete_post_page',
                    post_id: post_id,
                },
                dataType : 'json',
                success: function (response) {
                    jQuery('body').waitMe('hide');
                    console.log(response);
                    if(!response.status){
                        toastr.error(response.message,  response.title);
					}
                    else{
                        toastr.success(response.message,  response.title);
                        thiss.parents('.post-view').fadeOut(2000);
					} 
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                   jQuery('body').waitMe('hide');
               }
            });
        }); 
        //login
        jQuery(".login_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
          //  alert("works");
            var form = jQuery(this).serialize();
            console.log('form', form);
            jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            jQuery(this).find('button[type=submit]').prop('disabled',true);
            var thiss = jQuery(this);
            jQuery('body').waitMe({
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
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: {
                    action: 'login_user',
                    form_data: form
                },
                dataType : 'json',
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
					jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                    console.log(response);
                    if(!response.status){
						Swal.fire({
							title: response.title,
							text:  response.message,
							icon: response.icon,
							})
					}
                    else{
						if (response.auto_redirect) {window.location.href = response.redirect_url;}
						else{ 
							Swal.fire({
								title: response.title,
								text:  response.message,
								icon: response.icon,
								
							  }).then((willDelete) => {
							  if (response.redirect_url) {window.location.href = response.redirect_url;}
							}); 
						}
					
					} 
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                   jQuery('body').waitMe('hide');
               }
            });
        }); 

        //forgot password
		jQuery(".security_actions").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            
			var form = new FormData(this);	
			jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
			jQuery(this).find('button[type=submit]').prop('disabled',true);
			var thiss = jQuery(this);
			jQuery('body').waitMe({
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
            jQuery.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: form,
                dataType : 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
					jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                    console.log(response);
                    if(!response.status){
						Swal.fire({
							title: response.title,
							text:  response.message,
							icon: response.icon,
							})
					}
                    else{
						if (response.auto_redirect) {window.location.href = response.redirect_url;}
						else{ 
							Swal.fire({
								title: response.title,
								text:  response.message,
								icon: response.icon,
								
							  }).then((willDelete) => {
							  if (response.redirect_url) {window.location.href = response.redirect_url;}
							}); 
						}
					
					} 
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                   jQuery('body').waitMe('hide');
               }
            });
        }); 

        $(document).on( 'click', '.copy_url', function(e) {
			e.preventDefault(); 
			// Get the value of the input field
			var value = $(this).data('url');
            console.log("url", value)
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

     
    });
})(jQuery);