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

            $(".main_service_cart").click(function(){
                $("#Booking_Modal").fadeIn();
            });

            $(".special_service_cart").click(function(){
                $("#special_Modal").fadeIn();
            });
      
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

                var service_count = $(".service_detail").find("#"+service_id).length;
                    // console.log(service_count);

                if( service_count) {
                     return false;
                }
                
                var serviceDetail = `
                    <div class="book_service_details" id="${service_id}">
                        <img src="${service_img}" alt="">
                        <h1>${service_title}</h1>
                        <div class="booK_pricing">
                            <p>Cars: <span>$${car_price}</span></p>
                            <p>SYV’s & Trucks: <span>$${truck_price}</span></p>
                            <p>Over-Sized: <span>$${over_size_price}</span></p>
                            <i class="fa fa-trash trash" id="${service_id}" aria-hidden="true"></i>
                            <input type="hidden" name="service_id" value="${service_id}">
                        </div>
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
        
    });
})(jQuery);

