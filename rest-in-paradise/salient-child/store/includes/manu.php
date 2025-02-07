<?php 
if (!is_user_logged_in()) {
    $redirect = home_url('login');
    echo "<script>
      
        window.location.href = '{$redirect}';
    </script>";
    wp_redirect(home_url('login/'));
    exit;
}
$user = wp_get_current_user();
$account_status = get_user_meta($user->ID, 'account_status', 'true');
$membership_status = get_user_meta($user->ID, 'membership_status', 'true');
if($account_status == 'Not Active'){
    wp_redirect(home_url('logout/'));
    exit;
}

?>
<style>
    .brand-logo img {
        max-width: 130px !important;
    }
    /* img.dark-logo, img.light-logo{
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
    } */
</style>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="<?= home_url('/') ?>">
                    <span class="brand-logo">
                        <img class="dark-logo" alt="restinpeace" src="<?= home_url('/wp-content/uploads/2025/01/logo.png') ?>">
                        <!-- <img class="light-logo" alt="bellewstownenvironmentalprotectiongroup" src="https://bellewstownenvironmentalprotectiongroup.org/wp-content/uploads/2023/07/Layer-621.png">  -->
                    </span>
                                
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        

        <!-- Admin Menu Items -->
        <?php  if( in_array('administrator', $user->roles) ) { ?>
            <!-- Admin Menu -->
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('annoucements/') ?>"><i data-feather="volume"></i><span class="menu-title text-truncate" data-i18n="Annoucements">Annoucements</span></a>
                <li class="nav-item death"><a class="d-flex align-items-center" href="<?= home_url('all-death-notices/') ?>"><i data-feather="grid"></i><span class="menu-title text-truncate" data-i18n="All Death Notice">All Death Notice</span></a>
                <li class="nav-item family"><a class="d-flex align-items-center" href="<?= home_url('all-family-notices/') ?>"><i data-feather="hexagon"></i><span class="menu-title text-truncate" data-i18n="All Family Notice">All Family Notice</span></a>
                <li class="nav-item services"><a class="d-flex align-items-center" href="<?= home_url('all-services/') ?>"><i data-feather="package"></i><span class="menu-title text-truncate" data-i18n="All Family Notice">All Service Directory</span></a>

              
               
                
                <li class="nav-item services-main members-main" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="users">
                        </i><span class="menu-title text-truncate" data-i18n="Members">Members</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center funeral_directory" href="<?= home_url('users/?type=funeral_directory')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Events">Funeral </span></a></li>
                        <li><a class="d-flex align-items-center service_directory" href="<?= home_url('users/?type=service_directory')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="My Events">Service</span></a></li>
                    </ul>
                </li>    
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather="message-square"></i><span class="menu-title text-truncate" data-i18n="Chat">Chat</span></a>
                <!-- <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('profile-settings/') ?>"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Profile Settings">Profile Settings</span></a> -->
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('logout/') ?>"><i data-feather='corner-down-left'></i><span class="menu-title text-truncate" data-i18n="Logout">Logout</span></a>

             
            </ul>
        <?php } ?>

       
        <!-- Customer Menu Items -->
        <?php  if( in_array('funeral_directory', $user->roles )) { ?>
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('annoucements/') ?>"><i data-feather="volume"></i><span class="menu-title text-truncate" data-i18n="Annoucements">Annoucements</span></a>

                <li class="nav-item services-main" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="grid">
                        </i><span class="menu-title text-truncate" data-i18n="Events">Death Notice</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('add-new-death-notice/')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Events">Add Death Notice </span></a></li>
                        <li><a class="d-flex align-items-center" href="<?= home_url('all-death-notices/')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="My Events">All Death Notice</span></a></li>
                    </ul>
                </li> 
                <li class="nav-item services-main" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="hexagon">
                        </i><span class="menu-title text-truncate" data-i18n="Events">Family Notice</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('add-new-family-notice/')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Events">Add Family Notice </span></a></li>
                        <li><a class="d-flex align-items-center" href="<?= home_url('all-family-notices/')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="My Events">All Family Notice</span></a></li>
                    </ul>
                </li>       
                
                  
                          
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather="message-square"></i><span class="menu-title text-truncate" data-i18n="Chat">Chat</span></a>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('logout/') ?>"><i data-feather="corner-down-left"></i><span class="menu-title text-truncate" data-i18n="Logout">Logout</span></a>  
            </ul>
        <?php } ?>

        <!-- Customer Menu Items -->
        <?php  if( in_array('service_directory', $user->roles)) { ?>
            <?php  if( $membership_status != 'active'){  ?> 
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('profile-settings/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="Renew Subscription">Renew Subscription</span></a>
                    </li>
                </ul>
            <?php } else { ?>

            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('annoucements/') ?>"><i data-feather="volume"></i><span class="menu-title text-truncate" data-i18n="Annoucements">Annoucements</span></a>

                <li class="nav-item services-main" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="package">
                        </i><span class="menu-title text-truncate" data-i18n="Events">Services</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('add-new-services/')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Events">Add New Service </span></a></li>
                        <li><a class="d-flex align-items-center" href="<?= home_url('all-services/')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="My Events">All Service Directory</span></a></li>
                    </ul>
                </li> 
                
               
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather="message-square"></i><span class="menu-title text-truncate" data-i18n="Chat">Chat</span></a>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('logout/') ?>"><i data-feather="corner-down-left"></i><span class="menu-title text-truncate" data-i18n="Logout">Logout</span></a>  
            </ul>
        <?php } } ?>

        

    </div>

</div>
<!-- <script>
    function setDefaultlogo(){
        // console.log(localStorage.getItem('light-layout-current-skin'));
        if (!localStorage.getItem('light-layout-current-skin') || localStorage.getItem('light-layout-current-skin') == 'light-layout') {
            // alert('if');

            // Default condition if the key does not exist
            const style = document.createElement('style');
            style.textContent = `
                .brand-logo img.dark-logo {
                    display: block;
                }
            `;
            document.head.appendChild(style);  

        } else {
            // alert('else');
            const style = document.createElement('style');
            style.textContent = `
                .brand-logo img.dark-logo {
                    display: none;
                }
            `;
            document.head.appendChild(style);  

        }
    }
    setDefaultlogo();

    $(document).on('click', '.sitemode ', function(e){
        setDefaultlogo();
    });
</script> -->