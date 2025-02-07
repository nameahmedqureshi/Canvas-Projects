<?php 
if (!is_user_logged_in()) {
    $redirect = home_url('login');
    echo "<script>
      
        window.location.href = '{$redirect}';
    </script>";
    exit;
}
$user = wp_get_current_user();
?>

    <style>
        img.dark-logo, img.light-logo{
            display: none;
        }
       
        html.light-layout.dark-layout img.dark-logo {
            display: none;
        }
        html.dark-layout img.light-logo, html.light-layout.dark-layout img.light-logo{
            display: block;
        }
        html.light-layout img.dark-logo {
            display: block;
        }

    </style>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto"><a class="navbar-brand" href="<?= home_url() ?>"><span class="brand-logo">
                          <img class="dark-logo" src="<?= home_url( 'wp-content/uploads/2024/07/Vector-8.png' ) ?>" alt="">
                          <img class="light-logo" src="<?= home_url( 'wp-content/uploads/2024/07/Vector-8.png' ) ?>" alt="">
                        </span>
                        <h2 class="brand-text">Canyon<br><small>Park</small></h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <!-- adminstrators -->
            <?php  if(in_array('administrator', $user->roles)){  ?>
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('announcement/') ?>"><i data-feather="volume-2"></i><span class="menu-title text-truncate" data-i18n="Announcements">Announcements</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('schedule-a-pickup/') ?>"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Schedule A Pickup">Schedule A Pickup</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('calendar/') ?>"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="calendar">Calendar</span></a></li>

                <!-- Users Mangement -->
                <li class="users"><a class="d-flex align-items-center" href="<?= home_url('users/')  ?>"><i data-feather="user"></i><span class="menu-item text-truncate" data-i18n="Users">Agents</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather='message-square'></i><span class="menu-title text-truncate" data-i18n="Messages">Messages</span></a></li>

               
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('setting/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="Profile">Profile</span></a>
                </li>
            </ul>
            <?php } ?>

            <?php  if(in_array('customer', $user->roles)){  ?>
            <!-- restaurants users -->
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('announcement/') ?>"><i data-feather="volume-2"></i><span class="menu-title text-truncate" data-i18n="Announcements">Announcements</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('schedule-a-pickup/') ?>"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Schedule A Pickup">Schedule A Pickup</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather='message-square'></i><span class="menu-title text-truncate" data-i18n="Messages">Messages</span></a></li>
               
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('setting/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="Profile">Profile</span></a></li>

              
            </ul>
            <?php } ?>
        </div>
    </div>