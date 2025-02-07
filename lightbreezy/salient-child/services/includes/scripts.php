<!-- BEGIN: Vendor JS-->
<script src="<?= $directory_url ?>/app-assets/vendors/js/vendors.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="<?= $directory_url ?>/app-assets/vendors/js/extensions/toastr.min.js"></script>
<script src="<?= $directory_url ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?= $directory_url ?>/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?= $directory_url ?>/app-assets/js/core/app-menu.js"></script>
<script src="<?= $directory_url ?>/app-assets/js/core/app.js"></script>
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

    // if (session('status') == 'success')
    // toastr.success("Success");


    // if (session('status') == "failed")
    //     toastr.error("{{ session('message') }}");
</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });

    //Active Link
    var pageURL = jQuery(location).attr("href");
    var home_url = "<?= home_url()  ?>";

    jQuery('.navigation-main a').each(function() {
        var link = jQuery(this).attr('href');

        if (pageURL == link) {
            jQuery(this).parents('.has-sub').addClass('open');
            jQuery(this).parent('li').addClass('active');
        }

        if (pageURL.includes(home_url+"/service-view-orders/?id=")) {
         
            jQuery('.all-orders').addClass('open');
            jQuery('.orders-all').addClass('active');
        }

        if (pageURL.includes(home_url+"/add-new-service/?id=")) {
         
            jQuery('.all-services').addClass('open');
            jQuery('.services-all').addClass('active');
        }

    });

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
                        title: response.icon,
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