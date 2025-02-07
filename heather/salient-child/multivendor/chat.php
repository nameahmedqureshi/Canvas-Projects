<?php /* Template Name: inbox */ ?>

<?php
if(in_array('customer',wp_get_current_user()->roles)){
    $users = new WP_User_Query( array(
        'role'     => 'administrator',
    ) ); 
} else {
    $users = new WP_User_Query( array(
        'role'     => 'customer',
    ) );
}

$get_users = $users->get_results();

?>

<?php include "includes/styles.php"; ?>
<style>
    .users_tabs {
        margin-top: 10px;
        display: flex;
        justify-content: center;
    }

    p.tabs {
        padding: 10px;
        cursor: pointer;
       
    }
    p.tabs.active {
        background: #4a602f;
    }
</style>

 <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/app-chat.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/app-chat-list.css">
<!-- END: Page CSS-->


<!-- END: Head-->
<?php include "includes/header.php"; ?>

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
   
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
   <?php include "includes/manu.php"; ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    
    <div class="app-content content chat-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-area-wrapper container-xxl p-0">
            <div class="sidebar-left">
                <div class="sidebar">
                    <!-- Admin user profile area -->
                    <div class="chat-profile-sidebar">
                        <header class="chat-profile-header">
                            <span class="close-icon">
                                <i data-feather="x"></i>
                            </span>
                            <!-- User Information -->
                            <div class="header-profile-sidebar">
                                <div class="avatar box-shadow-1 avatar-xl avatar-border">
                                    <img src="<?= $directory_url ?>/app-assets/images/portrait/small/avatar-s-11.jpg" alt="user_avatar" />
                                    <span class="avatar-status-online avatar-status-xl"></span>
                                </div>
                                <h4 class="chat-user-name">John Doe</h4>
                                <span class="user-post">Admin</span>
                            </div>
                            <!--/ User Information -->
                        </header>
                        <!-- User Details start -->
                        <div class="profile-sidebar-area">
                            <h6 class="section-label mb-1">About</h6>
                            <div class="about-user">
                                <textarea data-length="120" class="form-control char-textarea" id="textarea-counter" rows="5" placeholder="About User">

                                Dessert chocolate cake lemon drops jujubes. Biscuit cupcake ice cream bear claw brownie brownie marshmallow.</textarea>
                                <small class="counter-value float-end"><span class="char-count">108</span> / 120 </small>
                            </div>
                            <!-- To set user status -->
                            <h6 class="section-label mb-1 mt-3">Status</h6>
                            <ul class="list-unstyled user-status">
                                <li class="pb-1">
                                    <div class="form-check form-check-success">
                                        <input type="radio" id="activeStatusRadio" name="userStatus" class="form-check-input" value="online" checked />
                                        <label class="form-check-label ms-25" for="activeStatusRadio">Active</label>
                                    </div>
                                </li>
                                <li class="pb-1">
                                    <div class="form-check form-check-danger">
                                        <input type="radio" id="dndStatusRadio" name="userStatus" class="form-check-input" value="busy" />
                                        <label class="form-check-label ms-25" for="dndStatusRadio">Do Not Disturb</label>
                                    </div>
                                </li>
                                <li class="pb-1">
                                    <div class="form-check form-check-warning">
                                        <input type="radio" id="awayStatusRadio" name="userStatus" class="form-check-input" value="away" />
                                        <label class="form-check-label ms-25" for="awayStatusRadio">Away</label>
                                    </div>
                                </li>
                                <li class="pb-1">
                                    <div class="form-check form-check-secondary">
                                        <input type="radio" id="offlineStatusRadio" name="userStatus" class="form-check-input" value="offline" />
                                        <label class="form-check-label ms-25" for="offlineStatusRadio">Offline</label>
                                    </div>
                                </li>
                            </ul>
                            <!--/ To set user status -->

                            <!-- User settings -->
                            <h6 class="section-label mb-1 mt-2">Settings</h6>
                            <ul class="list-unstyled">
                                <li class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="d-flex align-items-center">
                                        <i data-feather="check-square" class="me-75 font-medium-3"></i>
                                        <span class="align-middle">Two-step Verification</span>
                                    </div>
                                    <div class="form-check form-switch me-0">
                                        <input type="checkbox" class="form-check-input" id="customSwitch1" checked />
                                        <label class="form-check-label" for="customSwitch1"></label>
                                    </div>
                                </li>
                                <li class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="d-flex align-items-center">
                                        <i data-feather="bell" class="me-75 font-medium-3"></i>
                                        <span class="align-middle">Notification</span>
                                    </div>
                                    <div class="form-check form-switch me-0">
                                        <input type="checkbox" class="form-check-input" id="customSwitch2" />
                                        <label class="form-check-label" for="customSwitch2"></label>
                                    </div>
                                </li>
                                <li class="mb-1 d-flex align-items-center cursor-pointer">
                                    <i data-feather="user" class="me-75 font-medium-3"></i>
                                    <span class="align-middle">Invite Friends</span>
                                </li>
                                <li class="d-flex align-items-center cursor-pointer">
                                    <i data-feather="trash" class="me-75 font-medium-3"></i>
                                    <span class="align-middle">Delete Account</span>
                                </li>
                            </ul>
                            <!--/ User settings -->

                            <!-- Logout Button -->
                            <div class="mt-3">
                                <button class="btn btn-primary">
                                    <span>Logout</span>
                                </button>
                            </div>
                            <!--/ Logout Button -->
                        </div>
                        <!-- User Details end -->
                    </div>
                    <!--/ Admin user profile area -->

                    <!-- Chat Sidebar area -->
                    <div class="sidebar-content">
                        <span class="sidebar-close-icon">
                            <i data-feather="x"></i>
                        </span>
                        <!-- Sidebar header start -->
                        <div class="chat-fixed-search">
                            <div class="d-flex align-items-center w-100">
                                <div class="input-group input-group-merge ms-1 w-100">
                                    <span class="input-group-text round"><i data-feather="search" class="text-muted"></i></span>
                                    <input type="text" class="form-control round" id="chat-search" placeholder="Search or start a new chat" aria-label="Search..." aria-describedby="chat-search" />
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar header end -->

                       
                        <!-- Sidebar Users start -->
                        <div id="users-list" class="chat-user-list-wrapper list-group">
                            <h4 class="chat-list-title">Chats</h4>
                            <ul class="chat-users-list chat-list media-list">
                            <?php
                             if ( !empty( $get_users ) ) {
                                foreach ( $get_users as $user ) { 
                                    if ($user->ID === get_current_user_id()) { // Skip the current logged-in user
                                        continue;
                                    }
                                    $get_profile_image_id = get_user_meta( $user->ID, 'profile_pic', true );
                                    $get_profile_image_url = wp_get_attachment_image_url( $get_profile_image_id );
                            ?>
                            <li class="username" user="<?= $user->ID ?>">
                                <span class="avatar"><img src="<?= !empty($get_profile_image_url) ? $get_profile_image_url : $directory_url.'/assets/images/avatar.png' ?>" height="42" width="42" alt="Generic placeholder image" /></span>
                                <div class="chat-info flex-grow-1">
                                    <h5 class="mb-0"><?= !empty(get_user_meta($user->ID, 'first_name', true)) ? get_user_meta($user->ID, 'first_name', true) : $user->display_name ?></h5>
                                </div>
                            
                            </li>
                            <?php 
                            }
                            } else {
                                $users_html = 'No Chats Found!';
                            } ?>
                              
                                <li class="no-results">
                                    <h6 class="mb-0">No Chats Found</h6>
                                </li>
                            </ul>
                           
                        </div>
                        <!-- Sidebar Users end -->
                    </div>
                    <!--/ Chat Sidebar area -->

                </div>
            </div>
            <div class="content-right">
                <div class="content-wrapper container-xxl p-0">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="body-content-overlay"></div>
                        <!-- Main chat area -->
                        <section class="chat-app-window">
                            <!-- To load Conversation -->
                            <div class="start-chat-area">
                                <div class="mb-1 start-chat-icon">
                                    <i data-feather="message-square"></i>
                                </div>
                                <h4 class="sidebar-toggle start-chat-text">Start Conversation</h4>
                            </div>
                            <!--/ To load Conversation -->

                            <!-- Active Chat -->
                            <div class="active-chat d-none">
                                <!-- Chat Header -->
                                <div class="chat-navbar">
                                    <header class="chat-header">
                                        <div class="d-flex align-items-center">
                                            <div class="sidebar-toggle d-block d-lg-none me-1">
                                                <i data-feather="menu" class="font-medium-5"></i>
                                            </div>
                                            <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                                <img src="<?= $directory_url ?>/assets/images/avatar.png" alt="avatar" height="36" width="36" />
                                            </div>
                                            <h6 class="mb-0 active-chat-user"></h6>
                                        </div>
                                      
                                    </header>
                                </div>
                                <!--/ Chat Header -->

                                <!-- User Chat messages -->
                                <div class="user-chats">
                                    <div class="chats">
                                     
                                        <!-- <div class="divider">
                                            <div class="divider-text">Yesterday</div>
                                        </div>
                                        -->
                                      
                                    </div>
                                </div>
                                <!-- User Chat messages -->

                                <!-- Submit Chat form -->
                                <form class="chat-app-form" id="chat-form">
                                    <div class="input-group input-group-merge me-1 form-send-message">
                                        <input type="text" class="form-control message" name="message" placeholder="Type your message" />
                                       
                                    </div>
                                    <input type="hidden" name="action" value="send_message">
                                    <button type="submit" class="btn btn-primary send">
                                        <i data-feather="send" class="d-lg-none"></i>
                                        <span class="d-none d-lg-block">Send</span>
                                    </button>
                                </form>
                                <!--/ Submit Chat form -->
                            </div>
                            <!--/ Active Chat -->
                        </section>
                        <!--/ Main chat area -->

                        <!-- User Chat profile right area -->
                        <div class="user-profile-sidebar">
                            <header class="user-profile-header">
                                <span class="close-icon">
                                    <i data-feather="x"></i>
                                </span>
                                <!-- User Profile image with name -->
                                <div class="header-profile-sidebar">
                                    <div class="avatar box-shadow-1 avatar-border avatar-xl">
                                        <img src="<?= $directory_url ?>/assets/images/avatar.png" alt="user_avatar" height="70" width="70" />
                                        <span class="avatar-status-busy avatar-status-lg"></span>
                                    </div>
                                    <h4 class="chat-user-name">Kristopher Candy</h4>
                                    <span class="user-post">UI/UX Designer 👩🏻‍💻</span>
                                </div>
                                <!--/ User Profile image with name -->
                            </header>
                            <div class="user-profile-sidebar-area">
                                <!-- About User -->
                                <h6 class="section-label mb-1">About</h6>
                                <p>Toffee caramels jelly-o tart gummi bears cake I love ice cream lollipop.</p>
                                <!-- About User -->
                                <!-- User's personal information -->
                                <div class="personal-info">
                                    <h6 class="section-label mb-1 mt-3">Personal Information</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-1">
                                            <i data-feather="mail" class="font-medium-2 me-50"></i>
                                            <span class="align-middle">kristycandy@email.com</span>
                                        </li>
                                        <li class="mb-1">
                                            <i data-feather="phone-call" class="font-medium-2 me-50"></i>
                                            <span class="align-middle">+1(123) 456 - 7890</span>
                                        </li>
                                        <li>
                                            <i data-feather="clock" class="font-medium-2 me-50"></i>
                                            <span class="align-middle">Mon - Fri 10AM - 8PM</span>
                                        </li>
                                    </ul>
                                </div>
                                <!--/ User's personal information -->

                                <!-- User's Links -->
                                <div class="more-options">
                                    <h6 class="section-label mb-1 mt-3">Options</h6>
                                    <ul class="list-unstyled">
                                        <li class="cursor-pointer mb-1">
                                            <i data-feather="tag" class="font-medium-2 me-50"></i>
                                            <span class="align-middle">Add Tag</span>
                                        </li>
                                        <li class="cursor-pointer mb-1">
                                            <i data-feather="star" class="font-medium-2 me-50"></i>
                                            <span class="align-middle">Important Contact</span>
                                        </li>
                                        <li class="cursor-pointer mb-1">
                                            <i data-feather="image" class="font-medium-2 me-50"></i>
                                            <span class="align-middle">Shared Media</span>
                                        </li>
                                        <li class="cursor-pointer mb-1">
                                            <i data-feather="trash" class="font-medium-2 me-50"></i>
                                            <span class="align-middle">Delete Contact</span>
                                        </li>
                                        <li class="cursor-pointer">
                                            <i data-feather="slash" class="font-medium-2 me-50"></i>
                                            <span class="align-middle">Block Contact</span>
                                        </li>
                                    </ul>
                                </div>
                                <!--/ User's Links -->
                            </div>
                        </div>
                        <!--/ User Chat profile right area -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

   

    <?php include "includes/scripts.php"; ?>

  
    <!-- BEGIN: Page JS-->
    <script src="<?= $directory_url ?>/app-assets/js/scripts/pages/app-chat.js"></script>
    <!-- END: Page JS-->

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

        jQuery(document).ready(function(){


          //  change user image
            jQuery(document).on('click', '.username', function(e){
                var img = jQuery(this).find('.avatar img').attr('src');
                jQuery('.user-profile-toggle img').attr('src', img);
            });

            $(document).on('click', '.chat-users-list li', function(e){
                $('.chat-users-list li').removeClass('active'); 
                $(this).addClass('active'); 
                $('.start-chat-area').addClass('d-none'); 
                $('.active-chat').removeClass('d-none'); 
                $('.active-chat-user').text($(this).find('h5').text());
               // append user id in url
                var newUrl =  window.location.href.split('?')[0] + '?id=' + $(this).attr('user');
                window.history.pushState({path:newUrl},'',newUrl);
            });

            $('#chat-form').submit(function(e){
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = new FormData(this);
                var urlParams = new URLSearchParams(window.location.search);
                var receiver_id = urlParams.get('id');
                form.append("receiver_id", receiver_id);
                var thiss = jQuery(this);

                jQuery(this).find('button[type=submit]').prop('disabled',true);
              

                jQuery.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php')  ?>",
                    data: form,
                    dataType : 'json',
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        jQuery(thiss).find('button[type=submit]').prop('disabled',false);

                        if(!response.status){
                           toastr.error(response.message, response.title);
                        } else {
                            $('#chat-form')[0].reset();
                            $('.chats').append(response.html);
                            $('.user-chats ').scrollTop($('.user-chats ')[0].scrollHeight);
                        }
                      
                       
                    },
                    error : function(errorThrown){
                        console.log(errorThrown);
                    }
                });
            });
                
            function updateMessages(id) {
               
                jQuery.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php')  ?>",
                    data: {
                        action: 'get_messages',
                        id: id,
                    },
                    dataType: 'json',
                    success: function (response) {
                        //console.log(response.html);
                        if (response.html) {
                            $('.chats').html(response.html);
                            $('.user-chats ').scrollTop($('.user-chats ')[0].scrollHeight);

                        }
                    // console.log(response);
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
            // Execute the code for loading the chat
            setInterval(function () {
                var idFromUrl = new URLSearchParams(window.location.search).get('id');
                if(idFromUrl){
                    updateMessages(idFromUrl);
                }
            }, 3000);
        });
    </script>

    
</body>
