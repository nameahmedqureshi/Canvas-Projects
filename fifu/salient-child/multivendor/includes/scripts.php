    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/js/core/app-menu.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/multivendor/app-assets/js/core/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>

<script>

    // toastr.options = {
    //     "closeButton": true,
    //     "newestOnTop": false,
    //     "progressBar": true,
    //     "positionClass": "toast-top-right",
    //     "preventDuplicates": false,
    //     "onclick": null,
    //     "showDuration": "300",
    //     "hideDuration": "2000",
    //     "timeOut": "5000",
    //     "extendedTimeOut": "1000",
    //     "showEasing": "swing",
    //     "hideEasing": "linear",
    //     "showMethod": "fadeIn",
    //     "hideMethod": "fadeOut"
    // }

    // @if (session('status') == 'success')
    //     toastr.success("{{ session('message') }}");
    // @endif

    // @if (session('status') == "failed")
    //     toastr.error("{{ session('message') }}");
    // @endif

</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(input).parents('.avatar-upload').find('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $(input).parents('.avatar-upload').find('#imagePreview').hide();
                $(input).parents('.avatar-upload').find('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload, #store_banner").change(function() {
        readURL(this);
    });

    // page active //
    // var page_url = jQuery(location).attr("href");
    // jQuery(".navigation-main a").each(function() {
    //     var href = jQuery(this).attr("href");
    //     if (page_url == href) {
    //         jQuery(this).parents(".nav-item").addClass("active");
    //         if( jQuery(this).parents(".nav-item").hasClass("link_menu") ){
    //             jQuery(this).parents(".nav-item").next("li").addClass("active");
    //         }
    //     }
    // });

    //Active Link
    var pageURL = jQuery(location).attr("href");
    var home_url = "<?= home_url()  ?>";

    jQuery('.navigation-main a').each(function() {
        var link = jQuery(this).attr('href');
        if (pageURL == link) {
            jQuery(this).parents('.has-sub').addClass('open');
            jQuery(this).parent('li').addClass('active');
        }
        if (pageURL.includes(home_url+"/add-product/")) {
            jQuery('.product-main').addClass('open');
            jQuery('.product-all').addClass('active');
        }

        if (pageURL.includes("type=purchased")) {
            jQuery('.purchased_orders').addClass('active');
        }
        else if (pageURL.includes(home_url + "/order-details/")) {
            // Check if the URL includes "/order-details/" and no "type=purchased" parameter
            jQuery('.orders').addClass('active');
        }
        if (pageURL.includes(home_url+"/edit-user/")) {
            jQuery('.users').addClass('open');
            jQuery('.farmer').addClass('active');
        }
    });

    $('.nav-item').click(function() {
        $('li.open').siblings().removeClass('sidebar-group-active');
    });

    

</script>
