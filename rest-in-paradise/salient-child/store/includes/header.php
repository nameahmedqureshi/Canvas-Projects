<?php  $user = wp_get_current_user(); 
$image_url = get_user_meta( $user->ID, 'profile_pic', true );
$first_name = get_user_meta( $user->ID, 'first_name', true );
$last_name = get_user_meta( $user->ID, 'last_name', true );
$full_name = sprintf('%s %s', $first_name, $last_name);
$image_url = wp_get_attachment_image_url( $image_url );
?>
<style>
    .navbar-light a.back_home {
        color: #000000;
        padding: 10px;
    }
    .navbar-dark a.back_home {
        color: #ffff;
        padding: 10px;
    }
    .dark-layout .navbar-light a.back_home {
        color: #fff;
    }
</style>
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu ficon"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a></li>
                </ul>
              
            </div>
            <a class="back_home" href="<?=  home_url() ?>">Back to site</a>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
               
                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder"><?= $full_name ?></span><span class="user-status"><?= $user->roles[0] == 'customer' ? 'member' : $user->roles[0]; ?></span></div><span class="avatar"><img class="round" src="<?= !empty($image_url) ? $image_url : get_stylesheet_directory_uri().'/store/assets/images/avatar.png' ?>" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="<?= home_url('profile-settings/') ?>"><i class="me-50" data-feather="user"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= home_url('logout') ?>"><i class="me-50" data-feather="power"></i> Logout</a>
                    </div>
                </li>
            </ul>
         
           
        </div>
    </nav>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        jQuery(".dropdown-notification").click(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var user_id = <?= get_current_user_id() ?>;
            var type = jQuery(this).attr('type');
            var thiss = jQuery(this);
          
            jQuery.ajax({
                type: 'post',
                url: "<?= admin_url('admin-ajax.php')  ?>",
                data: {
                    action: 'read_all_notifications',
                    user_id: user_id,
                    type: type,
                },
                dataType: 'json',
              
                success: function(response) {
                   //  console.log(response);
                    if (response.status) {
                        jQuery('.notification_count').text('0');
                    }
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    </script>