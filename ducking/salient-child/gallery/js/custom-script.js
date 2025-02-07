(function($){
    $(document).ready(function(){
        $('.form_for_submit').submit(function(e){
            e.preventDefault(); 
            // var stripeForm = $(this).serialize();
            var stripeForm = new FormData(this);
            $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            $(this).find('button[type=submit]').prop('disabled',true);
            var thiss = $(this);
                $.ajax({
                    type: 'post',
                    url: ajax_script.ajax_url,
                    data: stripeForm,
                    dataType : 'json',
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                    $('.fa.fa-spinner.fa-spin').remove();
                        $(thiss).find('button[type=submit]').prop('disabled',false);
                        if(!response.status){
                                swal({
                                    title: "Error!",
                                    text: response.error,
                                    icon: "warning",
                                    button: "Close",
                                });
                        }
                        else{
                            if (response.auto_redirect) {window.location.href = response.redirect_url;}
                            else{ 
                            swal({
                                    //title: "Good job!",
                                    text: response.error,
                                    icon: "success",
                                    button: "Close",
                                }).then((willDelete) => {
                                    if (response.redirect_url) {window.location.href = response.redirect_url;}
                                }); 
                            }
                        } 
                    },
                    error : function(errorThrown){
                    console.log(errorThrown);
                    }
                });
        });

        $('.category-link').click(function(e){
            e.preventDefault(); 
            var catType = $(this).attr('cat-type');
            $('.category-link').removeClass('active');
            $(this).addClass('active');
            var thiss = $(this);
            $('#myDIV').waitMe({
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
                    type: 'post',
                    url: ajax_script.ajax_url,
                    data: { cat_type : catType, action : 'get_category_data'},
                    dataType : 'json',
                    success: function (response) {
                        if(response.html){
                            $('#myDIV').html(response.html)
                            //console.log(response);
                        }
                        else{
                            $('#myDIV').html('No gallery found');
                        }
                        
                        
                    },
                    error : function(errorThrown){
                        console.log(errorThrown);
                    }
                });
        });

        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            console.log("value",value);
            $("#myDIV .genCard").filter(function() {
              $(this).toggle($(this).attr("title").toLowerCase().indexOf(value) > -1);
            });
        });
        
    });
})(jQuery);