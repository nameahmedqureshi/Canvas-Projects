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
   if(!in_array('administrator', $user->roles)){  
    $subscription_plan = get_user_meta($user->ID, 'subscription_plan', true);
    $stripe_membership_status = $userClass->get_subscription_status();
    $membership_status = update_user_meta($user->ID, 'membership_status', $stripe_membership_status['subscription_status']);
    $membership_status = get_user_meta($user->ID, 'membership_status', true);

    // var_dump($stripe_membership_status["subscription_status"]);
    // var_dump($membership_status);
   }
?>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="<?= home_url('/');?>"><span class="brand-logo">
                        <img src="<?= $directory_url ?>/assets/images/logo.png" alt=""></span>
                    <h2 class="brand-text">Fifu Food</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <!-- adminstrators -->
        <?php  if(in_array('administrator', $user->roles)){  ?>
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('main-dashboard/') ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a></li>

            <!-- Users Mangement -->
            <li class="nav-item users">
                <a class="d-flex align-items-center" href="#"><i data-feather="user">
                    </i><span class="menu-title text-truncate" data-i18n="Vendors Management ">Manage Users </span>
                </a>
                <ul class="menu-content">
                    
                    <li class="farmer">
                        <a class="d-flex align-items-center" href="<?= home_url('users/?type=farmer')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Vendors">Farmers</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('users/?type=supplier')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="suppliers">Suppliers</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('users/?type=restaurant')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="restaurants">Restaurants</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Subscription Packages -->
            <li class=" nav-item" ><a class="d-flex align-items-center" href="#"><i data-feather="box"></i><span class="menu-title text-truncate" data-i18n="Subscription Plan">Subscription Plans</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="<?= home_url('farmer-subscription-packages/') ?>"><i data-feather='circle'></i><span class="menu-item text-truncate" data-i18n="Farmers">Farmers </span></a></li>
                    <li><a class="d-flex align-items-center" href="<?= home_url('supplier-subscription-packages/') ?>"><i data-feather='circle'></i><span class="menu-item text-truncate" data-i18n="Suppliers">Suppliers </span></a></li>
                    <li><a class="d-flex align-items-center" href="<?= home_url('restaurant-subscription-packages/')  ?>"><i data-feather='circle'></i><span class="menu-item text-truncate" data-i18n="Restaurants ">Restaurants </span></a></li>
                </ul>
            </li>
            
            <!-- products -->
            <li class=" nav-item product-main"><a class="d-flex align-items-center" href="#"><i data-feather="shopping-cart"></i><span class="menu-title text-truncate" data-i18n="Product">Product</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="<?= home_url('category-list/') ?>"><i data-feather='circle'></i><span class="menu-item text-truncate" data-i18n="Categories">Categories </span></a></li>
                    <li><a class="d-flex align-items-center" href="<?= home_url('tags-list/') ?>"><i data-feather='circle'></i><span class="menu-item text-truncate" data-i18n="Tags">Tags </span></a></li>
                    <li class="product-all"><a class="d-flex align-items-center" href="<?= home_url('product/')  ?>"><i data-feather='circle'></i><span class="menu-item text-truncate" data-i18n="All Products ">All Products </span></a></li>
                </ul>
            </li>

            <!-- orders -->
            <li class="nav-item orders"><a class="d-flex align-items-center" href="<?= home_url('orders/') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="Orders">Orders</span></a>
            </li>
            
            <!-- Dispute Request -->
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#"><i data-feather="shopping-cart">
                    </i><span class="menu-title text-truncate" data-i18n="Dispute Request">Dispute Request</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('vendor-dispute-request/')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Supplier">Supplier</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('farmer-dispute-request/')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">Farmer</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Reviews -->
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#"><i data-feather="file-text">
                    </i><span class="menu-title text-truncate" data-i18n="Reviews">Reviews </span>
                </a>
                <ul class="menu-content">
                    <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('reviews/?type=product') ?>"><i data-feather='circle'></i><span class="menu-title text-truncate" data-i18n="reviews">Product Reviews</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('reviews/?type=store') ?>"><i data-feather='circle'></i><span class="menu-title text-truncate" data-i18n="reviews">Store Reviews</span></a></li>
                </ul>
            </li>
            <!-- settings -->
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('setting/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="setting">Settings</span></a></li>
            
            
        </ul>
        <?php } ?>

        <?php  if(in_array('supplier', $user->roles) && $stripe_membership_status["subscription_status"] != 'canceled'){  ?>
        <!-- supplier -->
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('main-dashboard/') ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather='message-square'></i><span class="menu-title text-truncate" data-i18n="Messages">Messages</span></a></li>
            <li class="product-all" ><a class="d-flex align-items-center" href="<?= home_url('product/')  ?>"><i data-feather='shopping-cart'></i><span class="menu-item text-truncate" data-i18n="All Products ">All Products </span></a></li>
            <li class="nav-item link_menu" style="display:none"><a class="d-flex align-items-center" href="<?= home_url('add-order/') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="add_order">Add Orders</span></a></li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#"><i data-feather="file-text">
                    </i><span class="menu-title text-truncate" data-i18n="Orders">Orders </span>
                </a>
                <ul class="menu-content">
                    <li class="nav-item purchased_orders"><a class="d-flex align-items-center" href="<?= home_url('orders/?type=purchased') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="Purchased Items">Purchased Items</span></a></li>
                    <li class="nav-item orders"><a class="d-flex align-items-center" href="<?= home_url('orders/') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="Orders">Orders</span></a></li>
                </ul>
            </li>
            <!-- Withdrawls -->
            <li class="nav-item">
                <a class="d-flex align-items-center" href="<?= home_url('payout/')  ?>">
                    <i data-feather="log-in"></i><span class="menu-item text-truncate" data-i18n="Shop">Withdraw Requests</span>
                </a>
            </li>
            <!-- Reviews -->
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#"><i data-feather="file-text">
                    </i><span class="menu-title text-truncate" data-i18n="Reviews">Reviews </span>
                </a>
                <ul class="menu-content">
                    <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('reviews/?type=product') ?>"><i data-feather='file-text'></i><span class="menu-title text-truncate" data-i18n="reviews">Product Reviews</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('reviews/?type=store') ?>"><i data-feather='file-text'></i><span class="menu-title text-truncate" data-i18n="reviews">Store Reviews</span></a></li>
                </ul>
            </li>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('profiles/') ?>"><i data-feather='users'></i><span class="menu-title text-truncate" data-i18n="Farmers">Farmers</span></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('setting/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="setting">Settings</span></a></li>
        </ul>
        <?php } ?>

        <?php  if(in_array('farmer', $user->roles)  && $stripe_membership_status["subscription_status"] != 'canceled'){  ?>
        <!-- farmers -->
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('main-dashboard/') ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather='message-square'></i><span class="menu-title text-truncate" data-i18n="Messages">Messages</span></a></li>
            <li class="product-all"><a class="d-flex align-items-center" href="<?= home_url('product/')  ?>"><i data-feather='shopping-cart'></i><span class="menu-item text-truncate" data-i18n="All Products ">All Products </span></a></li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#"><i data-feather="file-text">
                    </i><span class="menu-title text-truncate" data-i18n="Orders">Orders </span>
                </a>
                <ul class="menu-content">
                    <li class="nav-item purchased_orders"><a class="d-flex align-items-center" href="<?= home_url('orders/?type=purchased') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="Purchased Items">Purchased Items</span></a></li>
                    <li class="nav-item orders"><a class="d-flex align-items-center" href="<?= home_url('orders/') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="Orders">Orders</span></a></li>
                </ul>
            </li>            <!-- Withdrawls -->
            <li class="nav-item">
                <a class="d-flex align-items-center" href="<?= home_url('payout/')  ?>">
                    <i data-feather="log-in"></i><span class="menu-item text-truncate" data-i18n="Shop">Withdraw Requests</span>
                </a>
            </li> 
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#"><i data-feather="file-text">
                    </i><span class="menu-title text-truncate" data-i18n="Reviews">Reviews </span>
                </a>
                <ul class="menu-content">
                    <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('reviews/?type=product') ?>"><i data-feather='file-text'></i><span class="menu-title text-truncate" data-i18n="reviews">Product Reviews</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('reviews/?type=store') ?>"><i data-feather='file-text'></i><span class="menu-title text-truncate" data-i18n="reviews">Store Reviews</span></a></li>
                </ul>
            </li>
            <?php if($subscription_plan != 'standard'){ ?>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('profiles/') ?>"><i data-feather='users'></i><span class="menu-title text-truncate" data-i18n="Suppliers">Suppliers</span></a></li>
            <?php } ?>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('setting/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="setting">Settings</span></a></li>
        </ul>
        <?php } ?>

        <?php  if(in_array('restaurant', $user->roles)  && $stripe_membership_status["subscription_status"] != 'canceled'){  ?>
        <!-- restaurants users -->
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('main-dashboard/') ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather='message-square'></i><span class="menu-title text-truncate" data-i18n="Messages">Messages</span></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('orders/?type=purchased') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="Orders">Orders</span></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('setting/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="setting">Settings</span></a></li>
            <!-- <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('profiles/') ?>"><i data-feather='users'></i><span class="menu-title text-truncate" data-i18n="Vendor Profiles">Vendor Profiles</span></a></li> -->
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('product-listing/') ?>"><i data-feather='globe'></i><span class="menu-title text-truncate" data-i18n="Shop">Shop</span></a></li>
        
        </ul>
        <?php } ?>

        <?php  if( $stripe_membership_status["subscription_status"] == 'canceled'){  ?> 
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('setting/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="Renew Subscription">Renew Subscription</span></a>
                </li>
            </ul>
        <?php } ?>
    </div>
</div>