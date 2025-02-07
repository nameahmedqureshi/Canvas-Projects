<?php /* Template Name: Reset Password*/  ?>
<?php get_header(); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css">
<script src="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<section>
    <div class="container main-content">
        <div class="row" id="reset_pass">
            <h5>Welcome Back! Please set password</h5>
            <form class="form forgot_form">
                <div class="wpb_row vc_row-fluid vc_row full-width-section vc_row-o-equal-height vc_row-flex vc_row-o-content-middle reverse_columns_column_tablet">
                    <div class="row_col_wrap_12 col span_12 dark left cl12">
                        <div class="vc_column-inner">
                            <input type="number"  name="verification_code" placeholder="Verification Code">
                        </div>
                    </div>

                    <div class="row_col_wrap_12 col span_12 dark left cl12">
                        <div class="vc_column-inner">
                            <i toggle="#current-password-field" class="fa-solid fa-eye toggle_password"></i>
                            <input type="password" id="current-password-field" name="password" placeholder="New Password">
                        </div>
                    </div>

                    <div class="row_col_wrap_12 col span_12 dark left cl12">
                        <div class="vc_column-inner">
                            <i toggle="#password-field" class="fa-solid fa-eye toggle_password"></i>
                            <input type="password" id="password-field" name="password_re" placeholder="Confirm Password">
                        </div>
                    </div>
                    
                    <div class="row_col_wrap_12 col span_12 dark left cl12">
                        <div class="vc_column-inner">
                            <input type="hidden" name="action" value="reset_password_custom" >
                            <button type="submit" id="submit">Reset Password</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?php  get_footer(); ?>
<script>
	jQuery(document).ready(function(){

        
        // PASSWORD SHOW HIDE
        jQuery(".toggle_password").click(function() {
            
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        	//forgot password
		jQuery(".forgot_form").submit(function(e) {
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
                url: "<?= admin_url('admin-ajax.php') ?>",
                data: form,
                dataType : 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                   jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                   // console.log(response);
				  
				   Swal.fire({
					title: response.title,
					text:  response.message,
					icon: response.icon,
					}).then((willDelete) => {
					if (response.redirect_url) {window.location.href = response.redirect_url;}
					}); 
				},
                error : function(errorThrown){
                   console.log(errorThrown);
                  jQuery('body').waitMe('hide');
               }
            });
        }); 

    });
</script>