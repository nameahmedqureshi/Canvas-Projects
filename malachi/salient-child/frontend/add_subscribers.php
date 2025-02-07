<?php function subscribers_shortcode() { ?>
<style>
    /* Unique styles for the newsletter form */
    .newsletter-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 2px solid #333;
    border-radius: 8px;
    background-color: #f7f7f7;
    font-family: Arial, sans-serif;
    box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
    }

    .heading {
    font-weight: bold;
    font-size: 20px;
    }

    .newsletter-form h2 {
    margin-top: 0;
    color: #333;
    font-size: 24px;
    }

    .newsletter-form label {
    display: block;
    font-weight: bold;
    color: #666;
    margin-bottom: 10px;
    }

    .newsletter-form input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    }

    .newsletter-form input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 4px;
    background-color: #ff6600;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    }

    .newsletter-form input[type="submit"]:hover {
    background-color: #ff8533;
    }
</style>
<div class="newsletter-form">
    <p class="heading"> Subscribe to Our Newsletter</p>
    <form id="subscribers">
      <label for="email">Email:</label>
      <input required="" placeholder="Enter your email address" name="email" id="email" type="email">
      <input type="hidden" name="action" value="add_subscribers">
      <!-- <input value="Subscribe" type="submit"> -->
      <button type="submit" class="btn_sub">Subscribe</button>
    </form>
</div>
<script>
    jQuery(document).ready(function() {
        // add subscribers
        jQuery("#subscribers").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = new FormData(this);
            // console.log('stripe', stripe);
            jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            jQuery(this).find('button[type=submit]').prop('disabled', true);
            var thiss = jQuery(this);
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
               
            jQuery.ajax({
                type: 'post',
                url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                data: form, // Use FormData directly
                dataType : 'json',
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled',false);
                    if(!response.status){
                        toastr.error(response.message, response.title);
                    }
                    else{
                        toastr.success(response.message, response.title);
                        jQuery('#subscribers')[0].reset();
                    } 
                },
                error : function(errorThrown){ 
                    console.log(errorThrown);
                    jQuery('body').waitMe('hide');

                }
            });
           
        });

    });
</script>
<?php } 
add_shortcode('subscriber_form', 'subscribers_shortcode');