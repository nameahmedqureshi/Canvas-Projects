(function ($) {
    $(document).ready(function () {
        // alert();
        // PASSWORD SHOW HIDE
        $(".toggle_password").click(function() {
      
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $('#submitInquiry').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission
            // alert();

            // Create a FormData object to combine all form data
            var form = new FormData(this);

            var thiss = $(this);
            // console.log('formData', form);
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
            // AJAX request to the server
            $.ajax({
                type: 'post',
                url: ajax_object.ajax_url,
                data: form, // Use FormData directly
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled', false);
                    if (!response.status) {
                        alert("Something went wrong");

                    } else{
                        alert("Your message sent successfully");
                        jQuery("#marketking_send_inquiry_textarea").val('');
                        
                    } 
                },
                error: function(errorThrown) {
                    jQuery('body').waitMe('hide');
                    console.log(errorThrown);
                }
            });
        });
        
    });
})(jQuery);

