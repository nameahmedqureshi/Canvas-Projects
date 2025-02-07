(function ($) {
    $(document).ready(function () {
        // tabs js //

        // Show the first tab and hide the rest
            $('#tabs-nav li:first-child').addClass('active');
            $('.tab-content').hide();
            $('.tab-content:first').show();

            // Click function
            $('#tabs-nav li').click(function(){
            $('#tabs-nav li').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').hide();
            
            var activeTab = $(this).find('a').attr('href');
            $(activeTab).fadeIn();
            return false;
            });

        // end // 
        
        // modal //
            // When the user clicks on the main_service_box, open the modal
            $(".sign_up").click(function(){
                $("#myModal").fadeIn();
            });
           
            // When the user clicks on <span> (x), close the modal
            $(".close").click(function(){
                $("#myModal").fadeOut();
            });
        
            // When the user clicks anywhere outside of the modal, close it
            $(window).click(function(event){
                if (event.target.id == "myModal") {
                    $("#myModal").fadeOut();
                }
            });


            jQuery(".login_form").hide();
            jQuery(".auth-forgot-password-form").hide();
            jQuery(".auth-reset-password-form").hide();

            jQuery("span#login_btn").click(function(){
                jQuery(".login_form").show();
                 jQuery(".register_form").hide();
                 jQuery(".auth-forgot-password-form").hide();
                 jQuery(".auth-reset-password-form").hide();
             });

             jQuery(".forget_pass").click(function(){
                 jQuery(".auth-forgot-password-form").show();
                jQuery(".login_form").hide();
                 jQuery(".register_form").hide();
                 jQuery(".auth-reset-password-form").hide();
             });
    
             jQuery("span#register_btn").click(function(){
                jQuery(".login_form").hide();
                jQuery(".auth-forgot-password-form").hide();
                jQuery(".auth-reset-password-form").hide();
                 jQuery(".register_form").show();
             });

             jQuery(".rest_link").click(function(){
                 jQuery(".auth-reset-password-form").show();
                jQuery(".login_form").hide();
                 jQuery(".register_form").hide();
                 jQuery(".auth-forgot-password-form").hide();
             });

             jQuery(".set_password").click(function() {
                var recoveryCode = jQuery("#verification-code").val();
                var password = jQuery("#reset-password-new").val();
                var passwordRe = jQuery("#reset-password-confirm").val();

                if (recoveryCode === "" || password === "" || passwordRe === "") {
                    Swal.fire({
                        title: "Set Password",
                        text: "All Fields Required",
                        icon: "error",
                    });
                } else {
                    jQuery(".login_form").show();
                    jQuery(".auth-reset-password-form").hide();
                    jQuery(".register_form").hide();
                    jQuery(".auth-forgot-password-form").hide();
                }
            });
            //  booking form

            // $(document).on('click', ".main_service_cart", function(){
            //     $("#Booking_Modal").fadeIn();
            // });

            // $(document).on('click', ".special_service_cart", function(){

            //     $("#special_Modal").fadeIn();
            //     console.log('multiple');
            // });

            // $(".single").click(function(){
            $(document).on('click', '.single', function(e){
                // $('.guest').attr('book_type', 'single');
                const service_id = $(this).parents('.main_service_box').attr('service_id');
                // $('.guest').attr('service_id', service_id);
                $("#Booking_Modal").fadeIn();
                $('.main_service_id').val(service_id);
                jQuery(".pickup input:radio[name='pickup_time']:first").click();
                // jQuery(".tip_div input:radio[name='tip']").prop('checked', false);
                $(".custom_tip_div").hide();
            });

            // $(".multiple").click(function(){
            $(document).on('click', '.multiple', function(e){

                // $('.guest').attr('book_type', 'multiple');
                $("#special_Modal").fadeIn();
                jQuery(".pickup input:radio[name='pickup_time']:first").click();
                // jQuery(".tip_div input:radio[name='tip']").prop('checked', false);
                $(".custom_tip_div").hide();
                // console.log('multiple');

            });
        
             $(document).on('click', '.guest', function(e){
                e.preventDefault();
                $("#myModal").fadeIn();
                $("#Booking_Modal").fadeOut();
                $("#special_Modal").fadeOut();
            });

            // $(document).on('click', '.guest', function(){
            //     $("#myModal").fadeOut();
            
            //     if ($(this).attr('book_type') == 'single') {
            //         $("#Booking_Modal").fadeIn();
            //         const service_id = $(this).attr('service_id');
            //         $('.main_service_id').val(service_id);

            //     } else if ($(this).attr('book_type') == 'multiple') {
            //         $("#special_Modal").fadeIn();
            //     }
            // });
            
      
            $(".close").click(function(){
                $("#Booking_Modal").fadeOut();
                $("#special_Modal").fadeOut();
                $("div#tab1 .cart_icon input").prop( 'checked', false);
            });
        
            $(window).click(function(event){
                if (event.target.id == "Booking_Modal") {
                    $("#Booking_Modal").fadeOut();
                }
                if (event.target.id == "special_Modal") {
                    $("#special_Modal").fadeOut();
                }
            });

            $(".special_service_cart").click(function() {
                var mainServiceBox = $(this).parents('.main_service_box');
                var service_img = mainServiceBox.find("img").attr("src");
                var service_id = mainServiceBox.attr("service_id");
                var service_title = mainServiceBox.find("h2").text();
                var car_price = mainServiceBox.find(".Cars_pricing h3").text();
                var truck_price = mainServiceBox.find(".trucks_pricing h3").text();
                var over_size_price = mainServiceBox.find(".Over-Sized_pricing h3").text();
                var single_price_text = mainServiceBox.find(".single_price h3").text();

                var service_count = $(".service_detail").find("#"+service_id).length;
                    // console.log("dasdada");

                if( service_count) {
                     return false;
                }
                
                var serviceDetail = `
                <div class="book_service_details ${single_price_text === '' ? 'multiple_service' : 'single_service'}" id="${service_id}">
                    <img src="${service_img}" alt="">
                    <h1>${service_title}</h1>
                    <div class="booK_pricing multiple_box">
                        <p>Cars: <span>${car_price}</span></p>
                        <p>SYV’s & Trucks: <span>${truck_price}</span></p>
                        <p>Over-Sized: <span>${over_size_price}</span></p>
                        <i class="fa fa-trash trash" id="${service_id}" aria-hidden="true"></i>
                    </div>
                    <div class="booK_pricing single_box">
                        <p><span>${single_price_text}</span></p>
                        <i class="fa fa-trash trash" id="${service_id}" aria-hidden="true"></i>
                    </div>
                    <input type="hidden" name="special_service_id[]" value="${service_id}">
                </div>
                `;
            
                 jQuery(this).removeClass("special_service_cart");
                 $(".service_detail").append(serviceDetail);

            });

            $(document).on("click",".trash",function() {
                var trash_id =  jQuery(this).attr("id");
                var service_id =  jQuery(".main_service_box").find("input[service_id="+trash_id+"]").prop( 'checked', false);
                jQuery(this).parents(".book_service_details").remove();
            });
            

            jQuery("div#tab1 .main_service_cart").click(function() {
                var service_id = jQuery(this).closest('.main_service_box').attr("service_id");
                jQuery("#Booking_Modal .main_service_id").val(service_id);
                
             });

             jQuery("div#tab2 .special_service_cart").click(function() {
                var service_id = jQuery(this).closest('.main_service_box').attr("service_id");
                jQuery("#special_Modal .specail_service_id").val(service_id);
             });
            
            
        // end // 
        jQuery(".toggle_password").click(function() {
            
            jQuery(this).toggleClass("fa-eye fa-eye-slash");
            var input = jQuery(jQuery(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        
    });
})(jQuery);

