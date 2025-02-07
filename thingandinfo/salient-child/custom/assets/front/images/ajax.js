(function($){

    $(document).ready(function(){

        // $('.form_for_submit').submit(function(e){
	       //  e.preventDefault(); 
	       //  //var stripeForm = $(this).serialize();
	       //  var stripeForm = new FormData(this);
	       //  $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
	       //  $(this).find('button[type=submit]').prop('disabled',true);
	       //  var thiss = $(this);
        //         $.ajax({
        //            type: 'post',
        //            url: ajax_script.ajax_url,
        //            data: stripeForm,
        //            dataType : 'json',
        //            cache:false,
        //            contentType: false,
        //            processData: false,
        //            success: function (response) {
        //             $('.fa.fa-spinner.fa-spin').remove();
        //                 $(thiss).find('button[type=submit]').prop('disabled',false);
        //                 if(!response.status){
        //                      swal({
        //                           title: "Error!",
        //                           text: response.error,
        //                           icon: "warning",
        //                           button: "Close",
        //                         });
        //                 }
        //                 else{
        //                     if (response.auto_redirect) {window.location.href = response.redirect_url;}
        //                     else{ 
        //                     swal({
        //                           //title: "Good job!",
        //                           text: response.error,
        //                           icon: "success",
        //                           button: "Close",
        //                         }).then((willDelete) => {
        //                           if (response.redirect_url) {window.location.href = response.redirect_url;}
        //                         }); 
        //                     }

        //                 } 
        //             },
        //             error : function(errorThrown){
        //             console.log(errorThrown);
        //             }
        //         });
        // });


        // swal({
        //   title: "Backup is already exists!",
        //   // text: "Backup is already exists!",
        //   icon: "warning",
        //   buttons: true,
        //   buttons: ["Create new backup", "Use old backup"],
        //   dangerMode: true,
        // })
        // .then((willDelete) => {
        //   if (willDelete) {
        //     swal("Use old Backup");
        //   } else {
        //     swal("Create new Backup");
        //   }
        // });



        var stripeForm;

        $(".the_cat_search , .the_tag_search ").on("change",function(e){
            the_search_func('checkbox',e);
        });


        $(".search_form").on("submit",function(e){
            the_search_func('button',e);
        });

        var categories = [];
        var tags = [];
        var search = '';
        function the_search_func(button_checkbox,e) {
            
            if(button_checkbox == 'button'){
                e.preventDefault();
                search = $("input[name=sr]").val();

                $('.the_cat_search:checked').each(function() {
                    $(this).prop("checked",false);
                });
                $('.the_tag_search:checked').each(function() {
                    $(this).prop("checked",false);
                });
            }
            else{
                 $("input[name=sr]").val("");
                 search = "";
            }

            categories = [];
            tags = [];
            
            $('.the_cat_search:checked').each(function() {
                categories.push(this.value);
            });
            $('.the_tag_search:checked').each(function() {
                tags.push(this.value);
            });

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
                type: 'post',
                url: ajax_script.ajax_url,
                data: {search:search,categories:categories,tags:tags,action:"ajax_search"},
                dataType : 'json',
                success: function (response) {
                    $('body').waitMe('hide');
                    // $(".cat_counter").html("<strong>"+response.count+"</strong>");
                    $("#the_parent").html(response.html);

                },
                error : function(errorThrown){
                    $('body').waitMe('hide');
                    console.log(errorThrown);
                }
            });
        }

    $(document).on("click",".ajex_login",function() {
        
        $('.varification').hide();
        $('.login').show();
        $('.login').css('display','block !important');
        $('.login').css('opacity','1');
        $('.login').css('z-index','99999');
        $('.login .poppup_box').css('transform','scale(1)');
        $('.login .poppup_box').css('top','100px');
//         $('.login .poppup_box').css('display','block'');
    });


    $('.hub_login').submit(function(e){
        e.preventDefault();
        var stripeForm = $(this).serialize();
         
        $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        $(this).find('button[type=submit]').prop('disabled',true);
        var thiss = $(this);

        $.ajax({
            type: 'post',
            url: ajax_script.ajax_url,
            data: stripeForm,
            dataType : 'json',
            
            success: function (response) {
                console.log(response);
                $('.fa.fa-spinner.fa-spin').remove();
                $(thiss).find('button[type=submit]').prop('disabled',false);
                
                if(!response.status){
                    //$(thiss).append('<p class="eer" style="color:red;">'+response.error+'</p>');
                    swal({
                    title: "Error!",
                    text: response.error,
                    icon: "warning",
                    button: "Close",
                    });
                }
                else{
                        if (response.auto_redirect) { location.href = response.redirect_url;}
                        $(thiss).find('.emailpass').hide();
                        $(thiss).find('input[name=action]').val('check_varification_code');
                        $(thiss).find('.varification').show();

                    }
            },
            error : function(errorThrown){
                 $('body').waitMe('hide');
                console.log(errorThrown);
            }
        });
    });



    $(document).on("click",".live_btn",function() {
        project_id = $(this).attr('data-id');
        project_name = $(this).attr('data-name');

        if(project_id == ""){alert("This Project File is Missing"); return false; }
        $('input[name=project_name]').val(project_id);
        $('input[name=set_project_name]').val(project_name);
        $('input[name=set_username]').val('admin');

        // $('.form_for_submit').trigger('submit');
        poppupShow('.Go_live');
    });

    function poppupShow(target) {
        $(target).css('opacity','1');
        $(target).css('z-index','99999');
        $(target+' .poppup_box').css('transform','scale(1)');
        $(target+' .poppup_box').css('opacity','1');
        $(target).show(2);
    }

    function poppup_close() {
        jQuery('.paypopup ').css('opacity','0');
        jQuery('.paypopup ').css('z-index','-1');
        jQuery('.poppup_box').css('transform','scale(0)');
        jQuery('.poppup_box').css('opacity','0');
        $('.paypopup').hide(2);

    }

    $(".closer").on("click",function(){
        poppup_close()
    });
        

    $('.form_for_submit').submit(function(e){
        e.preventDefault();
        var stripeForm = $(this).serialize();
        // var stripeForm = new FormData(this);
         $('body').waitMe({
                effect : 'bounce',
                text : 'Please wait project is moving...',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
		
    		// poppup_close();

        $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        $(this).find('button[type=submit]').prop('disabled',true);
        var thiss = $(this);

        $.ajax({
            type: 'post',
            url: ajax_script.ajax_url,
            data: stripeForm,
            dataType : 'json',
            // cache:false,
            // contentType: false,
            // processData: false,
            success: function (response) {
                console.log(response);
                $('.fa.fa-spinner.fa-spin').remove();
                $(thiss).find('button[type=submit]').prop('disabled',false);
                 $('body').waitMe('hide');
                if(!response.status){
                    //$(thiss).append('<p class="eer" style="color:red;">'+response.error+'</p>');
                    swal({
                    title: "Error!",
                    text: response.error,
                    icon: "warning",
                    button: "Close",
                    });
                }
                else{

                    // var a = document.createElement('a');
                    // a.href = response.redirect_url;
                    // a.setAttribute('target', '_blank');
                    // a.click();
                    
                    //swal({
                    //text: response.error,
                    //icon: "success",
                    //button: "Close",
                    //}).then((willDelete) => {
                    //location.reload(true);
                    //}); 
                    
                    poppup_close()
                    poppupShow('.Go_live_succ');
					
					html = `<a href="`+ response.redirect_url +`" target="_blank" class="theme_btn"><span>Continue</span></a>`
                    $('.addBtn').html(html);
					
                    setTimeout(function () {
                        let newTab = window.open(response.redirect_url, '_blank', '');
                    }, 3000);
                    
                    // if (response.auto_redirect) { //window.open(response.redirect_url, '_blank');
                    //      navigate(response.redirect_url,true);
                    // }
                }
            },
            error : function(errorThrown){
                 $('body').waitMe('hide');
                console.log(errorThrown);
            }
        });
    });

    // function navigate(href, newTab) {
    //    var a = document.createElement('a');
    //     a.href = href;
    //     a.setAttribute('target', '_blank');
    //     a.click();
    // }


    $(document).on("click",".load_more",function(e) {
        e.preventDefault();
        var data_id = $(this).attr('data-id');
        thiss = $(this);
        thiss.parent().remove();

        $('.loader-bg').css('display','flex');
        // $('body').waitMe({
        //     effect : 'bounce',
        //     text : '',
        //     bg : 'rgba(255,255,255,0.7)',
        //     color : '#000',
        //     maxSize : '',
        //     waitTime : -1,
        //     textPos : 'vertical',
        //     fontSize : '',
        //     source : '',
        // });

           $.ajax({
            type: 'post',
            url: ajax_script.ajax_url,
            data: {search:search, categories:categories, tags:tags, paged:data_id, action:"ajax_search"},
            dataType : 'json',
            
            success: function (response) {
                // console.log(response);
                thiss.parent().remove();
                $('.load_more').remove();

                // $('body').waitMe('hide');
                 // $(".cat_counter").html("<strong>"+response.count+"</strong>");
                $("#the_parent").append(response.html);

                $('.loader-bg').hide();
                

            },
            error : function(errorThrown){
                 $('body').waitMe('hide');
                console.log(errorThrown);
            }
        });
    });

    $(document).on("click",".project_preview",function(e) {
        e.preventDefault();
        var data_id = $(this).attr('data-id');

        var href = $(this).attr('href');
        window.open(href, '_blank');

        thiss = $(this);
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
            type: 'post',
            url: ajax_script.ajax_url,
            data: { project_id:data_id, action:"preview_count"},
            dataType : 'json',
            
            success: function (response) {
                console.log(response);
                $('body').waitMe('hide');
            },
            error : function(errorThrown){
                 $('body').waitMe('hide');
                console.log(errorThrown);
            }
        });
    });



    $(document).on("click",".tooltip",function() {
        var url = $(this).attr('data-url');
        navigator.clipboard.writeText(url);
        $(this).find('span').text('Copied!');
    });

    $(document).on("mouseout",".tooltip",function() {
         $(this).find('span').text('Copy to clipboard');
    })



    $("input[name=sr]").on("keyup",function(e){
        
        var search = $(this).val();

        $.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: {search:search,action:"autocomplete"},
                dataType : 'json',
                success: function (response) {
                    console.log(response);
                    jQuery( "input[name=sr]" ).autocomplete({
                      source: response
                    });  
                    
                },
                error : function(errorThrown){
                    $('body').waitMe('hide');
                    console.log(errorThrown);
                }
            });



        //    var availableTags = [
        //   "ActionScript",
        //   "AppleScript",
        //   "Asp",
        //   "BASIC",
        //   "C",
        //   "C++",
        //   "Clojure",
        //   "COBOL",
        //   "ColdFusion",
        //   "Erlang",
        //   "Fortran",
        //   "Groovy",
        //   "Haskell",
        //   "Java",
        //   "JavaScript",
        //   "Lisp",
        //   "Perl",
        //   "PHP",
        //   "Python",
        //   "Ruby",
        //   "Scala",
        //   "Scheme"
        // ];

        // jQuery( "input[name=sr]" ).autocomplete({
        //   source: availableTags
        // });    
    });


   


    // function myFunction(myInput,myTooltip) {
    //   var copyText = document.getElementById(myInput);
    //   copyText.select();
    //   copyText.setSelectionRange(0, 99999);
    //   navigator.clipboard.writeText(copyText.value);
      
    //   var tooltip = document.getElementById(myTooltip);
    //   tooltip.innerHTML = "Copied!";
    // }

    // function outFunc(myTooltip) {
    //   var tooltip = document.getElementById(myTooltip);
    //   tooltip.innerHTML = "Copy to clipboard";
    // }

  
});
})(jQuery);