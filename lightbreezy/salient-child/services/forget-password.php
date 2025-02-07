<?php function forget_password(){ ?>
<?php  if(!is_user_logged_in() ){ ?>
<style>
    .select2-container--default .select2-selection--multiple.select2-selection.select2-selection--multiple {
        background: transparent;
        margin-bottom: -20px;
        border: 1px solid #77119f;
        padding: 9px 0px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: transparent;
        border: 1px solid #a62dd5;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: inline;
        list-style: none;
        padding: 0;
        margin-left: 0;
    }

    textarea.select2-search__field::placeholder {
        color: #d6cbdc;
        font-size: 15px;
        line-height:14px;
        font-family: 'Open Sans';
    }

    #create_acc input::Placeholder {font-family: 'Open Sans';font-size: 15px;}
</style>
<section class="register">
    <div class="container">
        <div class="row  wpb_row vc_row-fluid vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="forget">
            <form class="service_order forget">
                <div class="col span_6">
                    <label for="first_name">Email *</label><br>
                    <input type="email" id="email" name="recovery_email" placeholder="Enter your email" required>
                </div>
                <div class="col span_12">
                        <input type="hidden" value="forgot_password" name="action">
                    <input class="button" type="submit" value="forget" />
                </div>
            </form>   
        </div>
    </div>
</section>
<script>
        jQuery(".forget").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = new FormData(this);
        // console.log('form', form);
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
            url: "<?= admin_url('admin-ajax.php')  ?>",
            data: form,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                jQuery('.fa.fa-spinner.fa-spin').remove();
                jQuery('body').waitMe('hide');
                jQuery(thiss).find('button[type=submit]').prop('disabled', false);
                //  console.log(response);
                if (!response.status) {
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: response.icon,
                    })

                } else{
                        Swal.fire({
                            title: response.title,
                            text:  response.message,
                            icon: response.icon,
                        }).then((willDelete) => {
                        if (response.redirect_url) {window.location.href = response.redirect_url;}
                        }); 
                    
                    } 
            },
            error: function(errorThrown) {
                console.log(errorThrown);
                jQuery('body').waitMe('hide');
            }
        });
    });
</script>
<?php } else {
wp_redirect(home_url('/'));
} 
} 
add_shortcode('forget_password', 'forget_password');
?>