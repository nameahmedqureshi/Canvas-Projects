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
                          <img class="dark-logo" src="<?= home_url( 'wp-content/uploads/2024/07/ggblack.png' ) ?>" alt="">
                          <img class="light-logo" src="<?= home_url( 'wp-content/uploads/2024/07/ggwhite.png' ) ?>" alt="">
                        </span>
                        <h2 class="brand-text">Julianna<br><small>Moda</small></h2>
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
                <li class="users"><a class="d-flex align-items-center" href="<?= home_url('users/')  ?>"><i data-feather="user"></i><span class="menu-item text-truncate" data-i18n="Users">Users</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather='message-square'></i><span class="menu-title text-truncate" data-i18n="Messages">Messages</span></a></li>
                <li class="nav-item link_menu" style="display:none"><a class="d-flex align-items-center" href="<?= home_url('add-product/') ?>"><i data-feather='shopping-cart'></i><span class="menu-title text-truncate" data-i18n="Products">Add Products</span></a></li>

                <li class=" nav-item product-main"><a class="d-flex align-items-center" href="#"><i data-feather="shopping-cart"></i><span class="menu-title text-truncate" data-i18n="Product">Product</span></a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('category-list/') ?>"><i data-feather='list'></i><span class="menu-item text-truncate" data-i18n="Categories">Categories </span></a></li>
                        <li><a class="d-flex align-items-center" href="<?= home_url('tags-list/') ?>"><i data-feather='list'></i><span class="menu-item text-truncate" data-i18n="Tags">Tags </span></a></li>
                        <li class="product-all"><a class="d-flex align-items-center" href="<?= home_url('products/')  ?>"><i data-feather='list'></i><span class="menu-item text-truncate" data-i18n="All Products ">All Products </span></a></li>
                    </ul>
                </li>
                <li class="nav-item orders"><a class="d-flex align-items-center" href="<?= home_url('orders/') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="Orders">Order List</span></a></li>
                <li class="nav-item invoice"><a class="d-flex align-items-center" href="<?= home_url('invoice/') ?>"><i data-feather='printer'></i><span class="menu-title text-truncate" data-i18n="Invoices">Invoices</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('setting/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="setting">Settings</span></a>
                </li>
            </ul>
            <?php } ?>

            <?php  if(in_array('customer', $user->roles)){  ?>
            <!-- restaurants users -->
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('main-dashboard/') ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather='message-square'></i><span class="menu-title text-truncate" data-i18n="Messages">Messages</span></a>
                </li>
                <li class="nav-item link_menu" style="display:none"><a class="d-flex align-items-center" href="<?= home_url('add-order/') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="add_order">Add Orders</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('orders/') ?>"><i data-feather='shopping-bag'></i><span class="menu-title text-truncate" data-i18n="Orders">Orders</span></a>
                </li>
                <li class="nav-item invoice"><a class="d-flex align-items-center" href="<?= home_url('invoice/') ?>"><i data-feather='printer'></i><span class="menu-title text-truncate" data-i18n="Invoices">Invoices</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('setting/') ?>"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="setting">Settings</span></a>
                </li>

              
            </ul>
            <?php } ?>
        </div>
    </div>