<?php  $user = wp_get_current_user(); 

$image_url = get_user_meta( $user->ID, 'profile_pic', true );

$first_name = get_user_meta( $user->ID, 'first_name', true );

$last_name = get_user_meta( $user->ID, 'last_name', true );
$store_name = get_user_meta( $user->ID, 'store_details', true );

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

            <?php if(in_array('vendor', $user->roles)){ ?>

            <a class="back_home" href="<?=  home_url('store-profile?id='.$user->ID) ?>">Visit Store</a>

            <?php } ?>

            <ul class="nav navbar-nav align-items-center ms-auto">

                <li class="nav-item  sitemode d-none d-lg-block"><a class="nav-link sitemode nav-link-style"><i class="sitemode ficon" data-feather="moon"></i></a></li>

               

                <?php

                global $post;



                $unread_notifications = array(

                    'post_type'  => 'notifications',

                );

                if(in_array('administrator', $user->roles)){

                    $unread_notifications['meta_query'] = [

                        'relation' => 'AND',

                        array(

                            'key'   => 'notification_admin_status',

                            'value' => 'unread',

                        ),

                        array(

                            'key'   => 'admin_id',

                            'value' => get_current_user_id(),

                            'compare' => '='

                        ),

                    ];



                } else {

                    $unread_notifications['meta_query'] = [

                        'relation' => 'AND',

                        array(

                            'key'   => 'notification_status',

                            'value' => 'unread',

                        ),

                        array(

                            'key'   => 'user_id',

                            'value' => get_current_user_id(),

                            'compare' => '='

                        ),

                    ];

                }

                $get_unread_notifications = new WP_Query($unread_notifications);



                $args = array(

                    'post_type' => 'notifications',

                    'post_status' => 'any',

                    'posts_per_page' => -1,

                    'author' => get_current_user_id(),

                    'order' => 'DESC'

                );

                if(in_array('administrator', $user->roles)){

                    $args = array(

                        'post_type' => 'notifications',

                        'post_status' => 'any',

                        'posts_per_page' => -1,

                        'order' => 'DESC',

                        'meta_query'     => [

                            [

                                'key'      => 'admin_id',

                                'value'    =>  get_current_user_id(),

                                'compare'  => '=',

                            ]

                        ],

                    );

                }

               

                $notifications = new WP_Query($args);

                ?>

                <li class="nav-item dropdown dropdown-notification me-25" type="<?= $user->roles[0] ?>">

                    <a class="nav-link" href="#" data-bs-toggle="dropdown">

                        <i class="ficon" data-feather="bell"></i>

                        <span class="badge rounded-pill bg-danger badge-up notification_count"><?= $get_unread_notifications->found_posts  ?></span>

                    </a>

                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">

                        <li class="dropdown-menu-header">

                            <div class="dropdown-header d-flex">

                                <h4 class="notification-title mb-0 me-auto">Notifications</h4>

                                <div class="badge rounded-pill badge-light-primary"><?= $notifications->found_posts;  ?></div>

                            </div>

                        </li>

                       

                        <li class="scrollable-container media-list">

                        

                        

                            <?php foreach($notifications->posts ?? [] as $key => $value) { 

                            $notifiy_id= $value->ID; 

                            $title = get_the_title($notifiy_id);

                            $message = get_the_excerpt( $notifiy_id );

                            $product_link = get_post_meta( $notifiy_id, 'product_link', true );

                            $order_number = substr($title, strpos($title, '#') + 1);

                           

                            ?>

                            <a class="d-flex" href="<?= stripos($title, 'New') !== false ? $product_link : 

                                (stripos($title, 'Product Order') !== false ? home_url('order-details/?order_id='.$order_number) : 

                                (stripos($title, 'reward') !== false ? '#!' : home_url('service-invoice/?id='.$order_number))); ?>">

                                

                                <div class="list-item d-flex align-items-start">

                                    <div class="me-1">

                                        <div class="avatar bg-light-success">

                                            <div class="avatar-content"><i class="avatar-icon" data-feather="check"></i></div>

                                        </div>

                                    </div>

                                    <div class="list-item-body flex-grow-1">

                                        <p class="media-heading"><span class="fw-bolder"><?= $title  ?></span></p><small class="notification-text"> <?= $message ?></small>

                                    </div>

                                </div>

                            </a>

                            <?php } ?>

                            

                        </li>

                    

                        <!-- <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="#">Read all notifications</a></li> -->

                    </ul>

                </li>

                <li class="nav-item dropdown dropdown-user">

                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder"><?= !empty($store_name['store_name'] ) ? $store_name['store_name'] : '' ?></span><span class="user-status"><?= $full_name ?></span></div><span class="avatar"><img class="round" src="<?= !empty($image_url) ? $image_url : get_stylesheet_directory_uri().'/store/assets/images/avatar.png' ?>" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>

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