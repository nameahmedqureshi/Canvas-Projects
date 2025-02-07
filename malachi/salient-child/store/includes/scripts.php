<!-- BEGIN: Vendor JS-->
<script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/vendors.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/extensions/toastr.min.js"></script>
<script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/js/core/app-menu.js"></script>
<script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- END: Page JS-->
<script src="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    toastr.options = {
        "closeButton": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "2000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
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

    //Active Link
    var pageURL = jQuery(location).attr("href");
    var home_url = "<?= home_url()  ?>";

     // Iterate through each navigation link
     jQuery('.navigation-main a').each(function() {
        var link = jQuery(this).attr('href');
        
        // Highlight current link and open parent menu if the link matches
        if (pageURL === link) {
            jQuery(this).closest('.has-sub').addClass('open');
            jQuery(this).parent('li').addClass('active');
        }
        
        // Inner pages handling based on URL patterns
        var urlPatterns = [
            { pattern: /add-product\/\?id=\d+&type=creations/, selector: '.creations' },
            { pattern: /add-product\/\?id=\d+&type=stl-library/, selector: '.stl-library' },
            { pattern: /add-product\/\?id=\d+&type=services/, selector: '.services' },
            { pattern: /order-details\/\?order_id=\d+&type=creations/, selector: '.order-creations' },
            { pattern: /order-details\/\?order_id=\d+&type=stl-library/, selector: '.order-stl-library' },
            { pattern: /order-details\/\?order_id=\d+&type=services/, selector: '.order-services' },
            { pattern: /service-invoice\/\?id=\d+&type=service-on-demand/, selector: '.order-sod' },
            { pattern: /service-invoice\/\?id=\d+&type=print-on-demand/, selector: '.order-pod' },
            { pattern: /service-invoice\/\?id=\d+&type=bulk-manufacturing/, selector: '.order-bulk' },
            { pattern: /pod-requests\/\?type=service-on-demand+&status=/, selector: '.request-sod' },
            { pattern: /pod-requests\/\?type=print-on-demand+&status=/, selector: '.request-pod' },
            { pattern: /pod-requests\/\?type=bulk-manufacturing+&status=/, selector: '.request-bulk' },
            { pattern: /view-quote-requests\/\?id=\d+&type=service-on-demand/, selector: '.quote-sod' },
            { pattern: /view-quote-requests\/\?id=\d+&type=print-on-demand/, selector: '.quote-pod' },
            { pattern: /view-quote-requests\/\?id=\d+&type=bulk-manufacturing/, selector: '.quote-bulk' },
            { pattern: /user-profile/, selector: '.add-vendor' }
        ];

        // Loop through each pattern and apply 'active' class to matching elements
        urlPatterns.forEach(function(item) {
            if (pageURL.match(item.pattern)) {
                jQuery(this).closest('.nav-item').find(item.selector).addClass('active');
            }
        }.bind(this)); // Bind `this` context to access `.closest()` properly within forEach
    });

    // jQuery('.navigation-main a').each(function() {
    //     var link = jQuery(this).attr('href');
    //     if (pageURL == link) {
    //         jQuery(this).parents('.has-sub').addClass('open');
    //         jQuery(this).parent('li').addClass('active');
    //     }

       
    //     // Add or edi product inner page
    //     if (pageURL.match(/add-product\/\?id=\d+&type=creations/)) {
    //         jQuery(this).parents('.nav-item').find('.creations').addClass('active');
    //     }
    //     if (pageURL.match(/add-product\/\?id=\d+&type=stl-library/)) {
    //         jQuery(this).parents('.nav-item').find('.stl-library').addClass('active');
    //     }
    //     if (pageURL.match(/add-product\/\?id=\d+&type=services/)) {
    //         jQuery(this).parents('.nav-item').find('.services').addClass('active');
    //     }
    //     // product order detail inner page
    //     if (pageURL.match(/order-details\/\?order_id=\d+&type=creations/) ) {
    //         jQuery(this).parents('.nav-item').find('.order-creations').addClass('active');
    //     }
    //     if (pageURL.match(/order-details\/\?order_id=\d+&type=stl-library/)) {
    //         jQuery(this).parents('.nav-item').find('.order-stl-library').addClass('active');
    //     }
    //     if (pageURL.match(/order-details\/\?order_id=\d+&type=services/)) {
    //         jQuery(this).parents('.nav-item').find('.order-services').addClass('active');
    //     }
    //     // on demand order inner page
    //     if (pageURL.match(/service-invoice\/\?id=\d+&type=service-on-demand/)) {
    //         jQuery(this).parents('.nav-item').find('.order-sod').addClass('active');
    //     }
    //     if (pageURL.match(/service-invoice\/\?id=\d+&type=print-on-demand/)) {
    //         jQuery(this).parents('.nav-item').find('.order-pod').addClass('active');
    //     }
    //     if (pageURL.match(/service-invoice\/\?id=\d+&type=bulk-manufacturing/)) {
    //         jQuery(this).parents('.nav-item').find('.order-bulk').addClass('active');
    //     }
    //     // view quote request inner page
    //     if (pageURL.match(/view-quote-requests\/\?id=\d+&type=service-on-demand/)) {
    //         jQuery(this).parents('.nav-item').find('.quote-sod').addClass('active');
    //     }
    //     if (pageURL.match(/view-quote-requests\/\?id=\d+&type=print-on-demand/)) {
    //         jQuery(this).parents('.nav-item').find('.quote-pod').addClass('active');
    //     }
    //     if (pageURL.match(/view-quote-requests\/\?id=\d+&type=bulk-manufacturing/)) {
    //         jQuery(this).parents('.nav-item').find('.quote-bulk').addClass('active');
    //     }
    //     // add or edit user inner page
    //     if (pageURL.match(/user-profile/)) {
    //         jQuery(this).parents('.nav-item').find('.add-vendor').addClass('active');
    //     }

     
    // });

    $('.nav-item').click(function() {
        $('li.open').siblings().removeClass('sidebar-group-active');
    });

    //signup user
    $(".basic_actions").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = new FormData(this);
        // console.log('form', form);
        $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        $(this).find('button[type=submit]').prop('disabled', true);
        var thiss = $(this);
        $('body').waitMe({
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
        $.ajax({
            type: 'post',
            url: "<?= admin_url('admin-ajax.php')  ?>",
            data: form,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $('.fa.fa-spinner.fa-spin').remove();
                $('body').waitMe('hide');
                $(thiss).find('button[type=submit]').prop('disabled', false);
                //  console.log(response);
                if (!response.status) {
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: response.icon,
                    })
                    

                } else{
						if (response.auto_redirect) {window.location.href = response.redirect_url;}
						else{ 
							Swal.fire({
								title: response.title,
								text:  response.message,
								icon: response.icon,
							}).then((willDelete) => {
							  if (response.redirect_url) {window.location.href = response.redirect_url;}
							}); 
						}
					
					} 
            },
            error: function(errorThrown) {
                console.log(errorThrown);
                $('body').waitMe('hide');
            }
        });
    });
</script>