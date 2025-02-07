(function($){

    $(document).ready(function(){

       

        jQuery(document).on("click", "a.page-numbers", function(e){
            e.preventDefault();
            var letter = jQuery(".artist-link.active").text();
            var page = jQuery(this).text();
            if(jQuery(this).hasClass('next')){
                page = jQuery('.page-numbers.current').next().text();
            } else if(jQuery(this).hasClass('prev')){
                page = jQuery('.page-numbers.current').prev().text();
            }
            
            the_search_func(e, page, letter);
        });

       // var page = '';
        $(document).on( 'click', '.artist-link', function(e) {
            e.preventDefault();
            // Remove the active class from the previous active element
            $('.artist-link.active').removeClass('active');

            // Add the active class to the clicked element
            $(this).addClass('active');
            var letter = $(this).text();
            var url = $(this).parents('.alphabet').attr('data-url');
            the_search_func(e, 1, letter, url); // Assuming you want to set page=1 initially
        });

        function the_search_func(e,page=1, letter, url) {
           // var letter = jQuery(".artist-link.active").text();
          console.log("url", url);
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
                data: {letter:letter, url:url, action:"get_artist_by_letter"},
                dataType : 'json',
                success: function (response) {
                    jQuery('body').waitMe('hide');
                   // console.log(response);
                    // jQuery(".cat_counter").html("<strong>"+response.count+"</strong>");
                    $('#artistDiv').html(response.html);
                    $('#artistDiv input[type="radio"]:first').click();

                  
                   // $('.pagination').html(response.pagination);

                },
                error : function(errorThrown){
                    jQuery('body').waitMe('hide');
                    console.log(errorThrown);
                }
            });
        }




    });
})(jQuery);
