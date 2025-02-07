<?php /* Template Name: Chat */ ?>
<?php
// if(!isset($_GET['type'])){
    $current_chat_user = get_userdata( get_current_user_id() );
    if(in_array('administrator', wp_get_current_user()->roles)){ 
        $users = new WP_User_Query( array(
            'role'     => 'funeral_directory',
            // 'exclude' => array( $users->ID ),
        ) );
    } elseif(in_array('service_directory', wp_get_current_user()->roles) || in_array('funeral_directory', wp_get_current_user()->roles)){ 
        $users = new WP_User_Query( array(
            'role'     => 'administrator',
            // 'exclude' => array( $users->ID ),
        ) );
    } 
    $get_users = $users->get_results();
// }
// if(isset($_GET['id'])){
//     $userdata = get_userdata( $_GET['id'] );
// }
// echo "<pre>";
// var_dump($userdata->display_name);
?>
<?php include "includes/styles.php"; ?>
<style>
    .full {
        width: 100% !important;
    }
    .chat-application .sidebar-content .chat-list-title {
        color: #000000;
        text-align: center;
        text-decoration: underline;
    }
    .dark-layout .chat-application .sidebar-content .chat-list-title {
        color: #ffffff;
    }
    .chat-app-window .chats .chat-avatar{
        width: 60px;
    }
    p.tabs.active {
        color: white;
    }
    p#no-users-message {
        text-align: center;
        margin-top: 20px;
    }
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
        background: #084025;
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
                    
                    <?php //if(!isset($_GET['type'])) { ?>
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
                        <?php  if(in_array('administrator', wp_get_current_user()->roles)){ ?>

                        <div class="users_tabs">
                            <p class="tabs active" user_type="funeral_directory">Funeral Directory</p>
                            <p class="tabs" user_type="service_directory">Service Directory</p>
                        </div>
                        <?php } ?>
                        <!-- Sidebar Users start -->
                      
                        <div id="users-list" class="chat-user-list-wrapper list-group">
                            <!-- <h4 class="chat-list-title">Chats</h4> -->
                            <ul class="chat-users-list chat-list media-list">
                                <!-- <li class="username" user="<?= $user->ID ?>" data-type="group">
                                    <span class="avatar"><img src="<?=  get_stylesheet_directory_uri() .'/store/assets/images/avatar.png' ?>" height="42" width="42" alt="Generic placeholder image" /></span>
                                    <div class="chat-info flex-grow-1">
                                        <h5 class="mb-0"> Group <?= ($unread_messages > 0 ? '<span class="badge bg-danger rounded-pill float-end">' . $unread_messages . '</span>' : '') ?></h5>
                                    </div>
                                
                                </li> -->

                            <?php
                             if ( !empty( $get_users ) ) { foreach ( $get_users as $user ) {
                                if ($user->ID === get_current_user_id()) { // Skip the current logged-in user
                                    continue;
                                }
                                // Check if the user has unread messages
                                $unread_messages = $wpdb->get_var($wpdb->prepare(
                                    "SELECT COUNT(*) FROM 4AM2H5_custom_chat 
                                    WHERE sender_id = %d 
                                    AND is_read = 0", 
                                    $user->ID
                                ));
                                $get_profile_image_id = get_user_meta( $user->ID, 'profile_pic', true );
                                $get_profile_image_url = wp_get_attachment_image_url( $get_profile_image_id );
                                $first_name = get_user_meta($user->ID, 'first_name', true);
                                $last_name = get_user_meta($user->ID, 'last_name', true);
                                $full_name = sprintf('%s %s', $first_name, $last_name); ?>
                                <li class="username" user="<?= $user->ID ?>"  data-type="individual">
                                    <span class="avatar"><img src="<?= !empty($get_profile_image_url) ? $get_profile_image_url :  get_stylesheet_directory_uri() .'/store/assets/images/avatar.png' ?>" height="42" width="42" alt="Generic placeholder image" /></span>
                                    <div class="chat-info flex-grow-1">
                                        <h5 class="mb-0"><?= !empty($full_name) ? $user->display_name : $full_name . ($unread_messages > 0 ? '<span class="badge bg-danger rounded-pill float-end">' . $unread_messages . '</span>' : '') ?></h5>
                                    </div>
                                
                                </li>
                            <?php } }else {
                                $users_html = 'No Chats Found!';
                            } ?>
                                <!-- <li class="no-results">
                                    <h6 class="mb-0">No User Found</h6>
                                </li> -->
                               
                            </ul>
                            <p id="no-users-message" style="display: none;">No users found</p>
                           
                        </div>
                        <!-- Sidebar Users end -->
                    </div>
                    <!--/ Chat Sidebar area -->
                    <?php //} ?>
                </div>
            </div>
            <!-- <div class="content-right <?= isset($_GET['type']) ? 'full' : '' ?>"> -->
            <div class="content-right">
                <div class="content-wrapper container-xxl p-0">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="body-content-overlay"></div>
                        <!-- Main chat area -->
                        <section class="chat-app-window">
                           
                            <!-- To load Conversation -->
                            <!-- <div class="start-chat-area <?= isset($_GET['type']) ? 'd-none' : '' ?>"> -->
                            <div class="start-chat-area">
                                <div class="mb-1 start-chat-icon">
                                    <i data-feather="message-square"></i>
                                </div>
                                <h4 class="sidebar-toggle start-chat-text">Start Conversation</h4>
                            </div>
                            <!--/ To load Conversation -->
                            
                            <!-- Active Chat -->
                            <!-- <div class="active-chat <?= !isset($_GET['type']) ? 'd-none' : '' ?>"> -->
                            <div class="active-chat">
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
                                            <!-- <h6 class="mb-0 active-chat-user"><?= isset($_GET['id']) ? $userdata->display_name : '' ?></h6> -->
                                            <h6 class="mb-0 active-chat-user"></h6>
                                        </div>
                                      
                                    </header>
                                </div>
                                <!--/ Chat Header -->
                                <!-- User Chat messages -->
                                <div class="user-chats">
                                    <div class="chats"></div>
                                </div>
                                <!-- User Chat messages -->
                                <!-- Submit Chat form -->
                                <form class="chat-app-form" id="chat-form">
                                    <div class="input-group input-group-merge me-1 form-send-message">
                                        <input type="text" class="form-control message" name="message" placeholder="Type your message or use speech to text" />
                                    </div>
                                    <!-- <input type="hidden" name="type" value="<?= $_GET['type'] ?>">
                                    <input type="hidden" name="receiver_id" value="<?= $_GET['id'] ?>"> -->
                                    <input type="hidden" name="action" value="onMessage">
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
            var conn = new WebSocket('wss://37.27.71.8:2088');
            console.log("conn", conn);
            conn.onopen = function(e) {
                console.log("Connection established!");
            
            };
            conn.onmessage = function(e) {
                var getData=jQuery.parseJSON(e.data);
                console.log("getData", getData);
                var html="<b>Test: </b>: "+getData.msg+"<br/>";
                jQuery('.chats').append(html);
            };
            //  change user image
            jQuery(document).on('click', '.username', function(e){
                var img = jQuery(this).find('.avatar img').attr('src');
                jQuery('.user-profile-toggle img').attr('src', img);
            });
            $(document).on('click', '.tabs', function(e){
                e.preventDefault(); // avoid to execute the actual submit of the form.
			    var type = $(this).attr('user_type');
                $('.tabs').removeClass('active');
                $(this).addClass('active'); 
                jQuery.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php')  ?>",
                    data: {
                        action: 'get_users',
                        type: type,
                    },
                    dataType : 'json',
                    success: function (response) {
                        $('.chat-users-list').html(response.html);
                        $('.start-chat-area').removeClass('d-none'); 
                        $('.active-chat').addClass('d-none'); 
                        var newUrl =  window.location.href.split('?')[0];
                        window.history.pushState({path:newUrl},'',newUrl);
                            // Check if the ul has any li elements
                        if (jQuery('.chat-users-list li').length === 0) {
                            // If no li elements, show the "No users found" message
                            jQuery('#no-users-message').show();
                        } else{
                            jQuery('#no-users-message').hide();
                        }
                    },
                    error : function(errorThrown){
                        console.log(errorThrown);
                    }
                });
            });
            $(document).on('click', '.chat-users-list li', function(e){
                $('.chat-users-list li').removeClass('active'); 
                $(this).addClass('active'); 
                $('.start-chat-area').addClass('d-none'); 
                $('.active-chat').removeClass('d-none'); 
                $('.active-chat-user').text($(this).find('h5').text());
                $(this).find('.badge').text('0');
               // append user id in url
                var newUrl =  window.location.href.split('?')[0] + '?id=' + $(this).attr('user') + '&type=' + $(this).data('type');
                window.history.pushState({path:newUrl},'',newUrl);
            });
            $('#chat-form').submit(function(e){
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = new FormData(this);
                var urlParams = new URLSearchParams(window.location.search);
                var receiver_id = urlParams.get('id');
                var type = urlParams.get('type');
                form.append("receiver_id", receiver_id);
                form.append("type", type);
                var thiss = jQuery(this);
                jQuery.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php')  ?>",
                    data: form,
                    dataType : 'json',
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
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
                
            function updateMessages(id, messageType) {
               
                jQuery.ajax({
                    type: 'post',
                    url: "<?= admin_url('admin-ajax.php')  ?>",
                    data: {
                        action: 'get_messages',
                        id: id,
                        messageType, messageType
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
                var messageType = new URLSearchParams(window.location.search).get('type');
                if(idFromUrl && messageType){
                    updateMessages(idFromUrl, messageType);
                }
            }, 3000);
            // Check if the ul has any li elements
            if (jQuery('.chat-users-list li').length === 0) {
                // If no li elements, show the "No users found" message
                jQuery('#no-users-message').show();
            }
        });
    </script>
    
</body>
