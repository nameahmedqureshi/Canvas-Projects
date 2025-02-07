<?php /* Template Name: inbox */ ?>

<?php
$current_chat_user = get_userdata( get_current_user_id() );
$users = new WP_User_Query( array(
    'role'     => 'supplier',
) );
$get_users = $users->get_results();

?>

<?php include "includes/styles.php"; ?>
<style>
    .users_tabs {
        margin-top: 10px;
        display: flex;
        justify-content: center;
    }
    p.no-users {
        text-align: center;
    }

    p.tabs {
        padding: 10px;
        cursor: pointer;
       
    }
    p.tabs.active {
        background: #4a602f;
    }
    p.tabs.active {
        color: white;
    }
    input#terms {
    margin: 15px 5px 0px;
	}
    .terms-conditions {
        padding: 15px;
        display: flex;
        text-align: left;
        font-size: 12px;
    }
    .tooltip1:hover .tooltiptext {
        visibility: visible;
    }
    .tooltip1 .tooltiptext{
        visibility: hidden;
        width: 339px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;
        
        position: absolute;
        z-index: 1;
    }
    .tooltip1{
        position: absolute;
        display: inline-block;
        border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
        top: 78px;
    	left: 20px;
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
                        <div class="tooltip1"><i data-feather='info'></i><span class="tooltiptext">Please note that all conversations on this website are monitored to ensure quality
                        and security</span></div>
                        <div class="terms-conditions">
                            <input type="checkbox" id="terms">
                            <label for="terms"> Please note that all conversations on this website are monitored to ensure quality
                            and security.</label><br>     
                        </div>
                                         
                        <div class="users_tabs">
                            <p class="tabs active" user_type="supplier">Suppliers</p>
                            <?php if(!in_array('restaurant', wp_get_current_user()->roles)){ ?>
                            <p class="tabs" user_type="restaurant" >Restaurants</p>
                            <?php } ?>
                            <p class="tabs" user_type="farmer">Farmers</p>
                        </div>
                        <!-- Sidebar Users start -->
                        <div id="users-list" class="chat-user-list-wrapper list-group">
                            <!-- <h4 class="chat-list-title">Chats</h4> -->
                            <ul class="chat-users-list chat-list media-list">
                            <?php
                             if ( !empty( $get_users ) ) {
                                foreach ( $get_users as $user ) { 
                                    if ($user->ID === get_current_user_id()) { // Skip the current logged-in user
                                        continue;
                                    }
                                    $get_profile_image_id = get_user_meta( $user->ID, 'profile_pic', true );
                                    $get_profile_image_url = wp_get_attachment_image_url( $get_profile_image_id );
                                    $first_name = get_user_meta($user->ID, 'first_name', true);
                                    $last_name = get_user_meta($user->ID, 'last_name', true);
                                    $full_name = sprintf('%s %s', $first_name, $last_name);
                            
                            ?>
                            <li class="username" user="<?= $user->ID ?>">
                                <span class="avatar"><img src="<?= !empty($get_profile_image_url) ? $get_profile_image_url : $directory_url.'/assets/images/avatar.png' ?>" height="42" width="42" alt="Generic placeholder image" /></span>
                                <div class="chat-info flex-grow-1">
                                    <h5 class="mb-0"><?= $full_name ?></h5>
                                </div>
                                <!-- <div class="chat-meta text-nowrap">
                                    <span class="badge bg-danger rounded-pill float-end">1</span>
                                </div> -->
                            
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
                                                <img src="<?= $directory_url ?>/app-assets/images/portrait/small/avatar-s-7.jpg" alt="avatar" height="36" width="36" />
                                            </div>
                                            <h6 class="mb-0 active-chat-user"></h6>
                                        </div>
                                    
                                    </header>
                                </div>
                                <!--/ Chat Header -->

                                <!-- User Chat messages -->
                                <div class="user-chats">
                                    <div class="chats">
                                     
                                    
                                      
                                    </div>
                                </div>
                                <!-- User Chat messages -->

                                <!-- Submit Chat form -->
                                <form class="chat-app-form" id="chat-form">
                                    <div class="input-group input-group-merge me-1 form-send-message">
                                        <input type="text" class="form-control message" name="message" placeholder="Type your message or use speech to text" />
                                       
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
                                        <img src="<?= $directory_url ?>/app-assets/images/portrait/small/avatar-s-7.jpg" alt="user_avatar" height="70" width="70" />
                                        <span class="avatar-status-busy avatar-status-lg"></span>
                                    </div>
                                    <h4 class="chat-user-name">Kristopher Candy</h4>
                                    <span class="user-post">UI/UX Designer 👩🏻‍💻</span>
                                </div>
                                <!--/ User Profile image with name -->
                            </header>
                       
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

            jQuery('.users_tabs, #users-list').hide();
            jQuery("#chat-search").css("pointer-events", "none");

            if (document.cookie.indexOf("termsAccepted=true") > -1) {
                jQuery('#terms').prop('checked', true);
                jQuery('.users_tabs, #users-list').show();
                jQuery("#chat-search").css("pointer-events", "auto");

            }

            // Set or unset the cookie when the checkbox is clicked
            jQuery(document).on('change', '#terms', function(e) {
                e.preventDefault();
                if (this.checked) {
                    document.cookie = "termsAccepted=true;path=/";
                    jQuery('#terms').prop('checked', true);
                    jQuery('.users_tabs, #users-list').show();
                    jQuery("#chat-search").css("pointer-events", "auto");

                } else {
                    document.cookie = "termsAccepted=;path=/;expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                    jQuery('#terms').prop('checked', true);
                    jQuery('.users_tabs, #users-list').hide();
                    jQuery('#terms').prop('checked', false);
                    jQuery("#chat-search").css("pointer-events", "none");

                }
            });

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
               // append user id in url
                var newUrl =  window.location.href.split('?')[0] + '?id=' + $(this).attr('user');
                window.history.pushState({path:newUrl},'',newUrl);
            });

            jQuery(".users_tabs .tabs:first").trigger("click");

            $('#chat-form').submit(function(e){
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = new FormData(this);
                var urlParams = new URLSearchParams(window.location.search);
                var receiver_id = urlParams.get('id');
                form.append("receiver_id", receiver_id);
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
