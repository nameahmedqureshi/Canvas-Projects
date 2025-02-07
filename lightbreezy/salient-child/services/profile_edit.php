<?php function profile_edit(){ 
  if(is_user_logged_in() ) {

         $user = wp_get_current_user();
        //  var_dump($user->roles[0]);
        $user_meta = get_user_meta( $user->ID );
        $first_name = get_user_meta( $user->ID, 'first_name', true );
        $last_name = get_user_meta( $user->ID, 'last_name', true );
        $email = get_user_meta($user->ID, 'email', true);
        $number = get_user_meta($user->ID, 'phone', true);
?>
<section class="register">
    <div class="container">
        <div class="row  wpb_row vc_row-fluid vc_row top-level vc_row-o-equal-height vc_row-flex vc_row-o-content-middle" id="profile_edit">
            <form class="service_order profile_edit">
                <div class="col span_6">
                    <label for="first_name">first name</label><br>
                    <input type="text"  name ="first_name" class="input" placeholder="First Name" value="<?= $first_name ?>">
                </div>
                <div class="col span_6">
                    <label for="first_name">Last name</label><br>
                    <input type="text"  name ="last_name" class="input" placeholder="Last Name" value="<?= $last_name ?>">
                </div>
                <div class="col span_6">
                    <label for="first_name">Email</label><br>
                    <input type="email" name="email" class="input" placeholder="Email" value="<?= $user->user_email ?>">
                </div>
                <div class="col span_6">
                    <label for="first_name">Phone number</label><br>
                    <input type="number" name="number" class="input" placeholder="Phone Number" value="<?= $number ?>">
                </div>
                <div class="col span_6">
                    <label for="first_name">Old password</label><br>
                    <input type="password" class="form-control form-control-merge" name="old_password" placeholder="Old Password" />
                </div>
                <div class="col span_6">
                    <label for="first_name">New Password</label><br>
                    <input type="password" class="form-control form-control-merge" name="new_password" placeholder="New Password" />
                </div>
                <div class="col span_12">
                    <input type="hidden" name="action" value="update_user_profile">
                    <input type="hidden" name="redirect" value="true">
                    <input class="button" type="submit" value="Profile Update" />
                </div>
            </form>   
        </div>
    </div>
</section>
<?php } else {
wp_redirect(home_url('/'));
} ?>
<script>
     jQuery(".profile_edit").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = new FormData(this);
            // console.log('form', form);
            jQuery(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            jQuery(this).find('button[type=submit]').prop('disabled', true);
            var thiss = jQuery(this);
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
            jQuery.ajax({
                type: 'post',
                url: "<?= admin_url('admin-ajax.php')  ?>",
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    jQuery('.fa.fa-spinner.fa-spin').remove();
                    jQuery('body').waitMe('hide');
                    jQuery(thiss).find('button[type=submit]').prop('disabled', false);
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
                    jQuery('body').waitMe('hide');
                }
            });
        });
</script>
<?php 
}
add_shortcode('profile_edit', 'profile_edit');
?>