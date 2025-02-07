(function ($) {
    $(document).ready(function () {

	jQuery(document).on('click', '.author-link', function(e){
        e.preventDefault();
        e.stopPropagation();
        let url = jQuery(this).data('author');
        window.open(url, '_blank'); 
    });

   

    $(document).on('click', '.chat-icon', function(e) {
        e.preventDefault(); // Prevent default link behavior

        var user_id = ajax_script.current_user;
		console.log("userid", user_id);
        var thiss = jQuery(this);
    
        jQuery.ajax({
            type: 'post',
            url: ajax_script.ajax_url,
            data: {
                action: 'get_chats_for_menu',
                user_id: user_id,
            },
            dataType: 'json',
            success: function (response) {
// 				console.log(response.html);
				jQuery('#dialogBox').html(response.html);


            },
            error: function (errorThrown) {
                console.log(errorThrown);
                jQuery('body').waitMe('hide');
            }
        });

    });
        
    });
})(jQuery);