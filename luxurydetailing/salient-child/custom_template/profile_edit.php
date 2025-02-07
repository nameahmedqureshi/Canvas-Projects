<?php function profile_edit(){
  if(!is_user_logged_in() ) {
    wp_redirect(home_url('/'));
    echo '<script>window.location.href = "'.home_url('/').'"</script>';
    exit;
  }

    $user = wp_get_current_user();
    //  var_dump($user->roles[0]);
    $user_meta = get_user_meta( $user->ID );
    $first_name = get_user_meta( $user->ID, 'first_name', true );
    $last_name = get_user_meta( $user->ID, 'last_name', true );
    $email = get_user_meta($user->ID, 'email', true);
    $number = get_user_meta($user->ID, 'number', true);
    $type = get_user_meta($user->ID, 'type', true);
    $classification = get_user_meta($user->ID, 'classification', true);
    $panther_id = get_user_meta($user->ID, 'panther_id', true);
    $college = get_user_meta($user->ID, 'college', true);
?>
<style>
        .register_form i.fa-solid {
        position: absolute;
        right: 9px;
        top: 20px;
        z-index: 99999;
    }
        .password_div input {
        margin: unset;
        margin-top: 10px;
    }
    .password_div {
        margin: 0px 5px;
        width: 47.5%;
    }
</style>
<div class="profile_edit">
    <div class="profile_edit_inner">
        <div class="form-box">
            <i class="fa fa-times close" aria-hidden="true"></i>
            <div class="booking">
                <form class="form register_form basic_actions1">
                    <span class="title">Profile Edit</span>
                    <div class="form-container">
                        <input type="text"  name ="first_name" class="input" placeholder="First Name" value="<?= $first_name ?>">
                        <input type="text"  name ="last_name" class="input" placeholder="Last Name" value="<?= $last_name ?>">
                        <input type="email" name="email" class="input" placeholder="Email" value="<?= $user->user_email ?>">
                        <input type="tel" name="number" class="input" placeholder="Phone Number" value="<?= $number ?>">
                        <input type="text" name="college" class="input" placeholder="College/Unit" value="<?= $college ?>">
                        <select name="type" id="type">
                            <option value="student" <?php if ($type == 'student') echo 'selected'; ?>>Student</option>
                            <option value="faculty" <?php if ($type == 'faculty') echo 'selected'; ?>>Faculty/Staff</option>
                            <option value="admin" <?php if ($type == 'admin') echo 'selected'; ?>>Admin</option>
                            <option value="vendor" <?php if ($type == 'vendor') echo 'selected'; ?>>Vendors</option>
                            <option value="other" <?php if ($type == 'other') echo 'selected'; ?>>Other</option>
                        </select>
                        <input type="text" name="panther_id" class="input" placeholder="Panther id" value="<?= $panther_id ?>">
                        <input type="text" name="classification" class="input" placeholder="Classification" value="<?= $classification ?>">
                        <div class="password_div">
                            <i toggle="#password-field77" class="fa-solid fa-eye toggle_password"></i>
                            <input type="password" id="password-field77" class="form-control form-control-merge" name="old_password" placeholder="Old Password" />
                        </div>
                        <div class="password_div">
                            <i toggle="#password-field66" class="fa-solid fa-eye toggle_password"></i>
                            <input type="password" id="password-field66"  class="form-control form-control-merge" name="new_password" placeholder="New Password" />
                        </div>
                    </div>
                    <input type="hidden" name="action" value="update_user_profile">
                    <button type="submit">Profile Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
     jQuery(".basic_actions1").submit(function(e) {
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