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
if($account_status == 'Not Active'){
    wp_redirect(home_url('logout/'));
    exit;
}

?>
<style>
    /* ul#main-menu-navigation {
        height: 100%;
    } */

    .boards  a, .directmsg a {
        background: #084025;
        color: #ffff !important;
    }

    li.nav-item.boards {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        bottom: 55px;
        width: 100%;
    }

    li.nav-item.boards a{
        height: 60px;
        display: block;
        text-align: center;
        border: 1px solid black;
        margin: 7px !important;
        padding: 2px !important;
        overflow: visible;
        white-space: break-spaces;
        display: flex;
        align-items: center;
        border-radius: 4px;
    }
    .main-menu.menu-fixed.expanded li.nav-item.boards, .main-menu.menu-fixed.expanded li.nav-item.directmsg {
        display: flex;
    }

    /* li.nav-item.boards, li.nav-item.directmsg {
        display: none;
    } */

   
    li.nav-item.directmsg {
        position: fixed;
        width: 100%;
        bottom: 7px;
        /* / margin: 0px 7px; /
        / border: 1px solid black; / */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    li.nav-item.directmsg a {
        white-space: break-spaces;
        border: 1px solid black;
        margin: 0px 7px 0px 7px !important;
        width: 100%;
        justify-content: center;
        border-radius: 4px;
    }
    .brand-logo img {
        max-width: 140px !important;
        height: 30px;
    }
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
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="<?= home_url('/') ?>">
                    <span class="brand-logo">
                        <img class="dark-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-003.png') ?>">
                        <img class="light-logo" alt="Kainamo" src="<?= home_url('/wp-content/uploads/2024/12/M-Logo-001.png') ?>"> 
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
                <li class="nav-item dashboard"><a class="d-flex align-items-center" href="<?= home_url('dashboard/')  ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboard</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>
                <!-- <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('earnings/')  ?>"><i data-feather="dollar-sign"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Earnings/Profits</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li> -->
                <!-- Total Earnings -->
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('total-earning/')  ?>"><i data-feather="dollar-sign"></i><span class="menu-title text-truncate" data-i18n="Total Earnings">Total Earnings</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>

                <!-- <li class="nav-item" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="dollar-sign">
                        </i><span class="menu-title text-truncate" data-i18n="eCommerce">Total Earnings</span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center" href="<?= home_url('total-earning/?type=services/')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Services">Services</span>
                            </a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="<?= home_url('total-earning/?type=products/')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Creations">Creations</span>
                            </a>
                        </li>
                    </ul>
                </li> -->

                <!--creations  -->
                <li class="nav-item product-main"><a class="d-flex align-items-center" href="#"><i data-feather="figma"></i><span class="menu-title text-truncate" data-i18n="Creations">Creations</span></a>
                    <ul class="menu-content">
                        <!-- <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Settings">Settings</span></a>
                            <ul class="menu-content">
                                <li><a class="d-flex align-items-center" href="#"><span class="menu-item text-truncate" data-i18n="Tax & Commission">Tax & Commission</span></a>
                                </li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('shipment-charges/') ?>"><span class="menu-item text-truncate" data-i18n="Shipment Charges">Shipment Charges</span></a>
                                </li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('s-product-report/') ?>"><span class="menu-item text-truncate" data-i18n="Report">Report </span></a>
                                </li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('s-product-coupon/') ?>"><span class="menu-item text-truncate" data-i18n="Coupons">Coupons</span></a>
                                </li>
                            </ul>
                        </li> -->

                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Manage Creations</span></a>
                            <ul class="menu-content">
                                <li><a class="d-flex align-items-center" href="<?= home_url('category-list/?type=product_cat&cat=creations') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Categories">Categories </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('tags-list/?tag=creations') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Tags">Tags </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('add-product/?type=creations') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add Product">Add Creation </span></a></li>
                                <li class="creations"><a class="d-flex align-items-center" href="<?= home_url('all-products/?type=creations')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Products ">All Creations </span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Service  -->
                <li class="nav-item services-main"><a class="d-flex align-items-center" href="#"><i data-feather="package"></i><span class="menu-title text-truncate" data-i18n="Service Bookings">Services</span></a>
                    <ul class="menu-content">
                        <!-- <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Settings">Settings</span></a>
                            <ul class="menu-content">
                                <li><a class="d-flex align-items-center" href="#"><span class="menu-item text-truncate" data-i18n="Tax & Commission">Tax & Commission</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('coupons/') ?>"><span class="menu-item text-truncate" data-i18n="Coupons">Coupons</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('reports/') ?>"><span class="menu-item text-truncate" data-i18n="Report">Report </span></a></li>
                            </ul>
                        </li> -->

                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Manage Services">Manage Services</span></a>
                            <ul class="menu-content">
                                <li><a class="d-flex align-items-center" href="<?= home_url('category-list/?type=product_cat&cat=services') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Categories">Categories </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('tags-list/?tag=services') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Tags">Tags </span></a></li>                                
                                <li><a class="d-flex align-items-center" href="<?= home_url('add-product/?type=services') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Create a Service">Add Service </span></a></li>
                                <li class="services"><a class="d-flex align-items-center" href="<?= home_url('all-products/?type=services')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All SERVICES ">All Services </span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Stl  -->
                <li class="nav-item services-main"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span class="menu-title text-truncate" data-i18n="Service Bookings">STL Library</span></a>
                    <ul class="menu-content">
                        <!-- <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Settings">Settings</span></a>
                            <ul class="menu-content">
                                <li><a class="d-flex align-items-center" href="#"><span class="menu-item text-truncate" data-i18n="Tax & Commission">Tax & Commission</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('coupons/') ?>"><span class="menu-item text-truncate" data-i18n="Coupons">Coupons</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('reports/') ?>"><span class="menu-item text-truncate" data-i18n="Report">Report </span></a></li>
                            </ul>
                        </li> -->

                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Manage Services">Manage STL Library</span></a>
                            <ul class="menu-content">
                                <li><a class="d-flex align-items-center" href="<?= home_url('category-list/?type=product_cat&cat=stl-library') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Categories">Categories </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('tags-list/?tag=stl-library') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Tags">Tags </span></a></li>                                
                                <li><a class="d-flex align-items-center" href="<?= home_url('add-product/?type=stl-library') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Create a STL Library">Add STL File </span></a></li>
                                <li class="stl-library"><a class="d-flex align-items-center" href="<?= home_url('all-products/?type=stl-library')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All STL Library ">All STL File </span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Qoute Requests  -->
                <li class="nav-item services-main" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="list">
                        </i><span class="menu-title text-truncate" data-i18n="Quote Requests">Requests</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('pod-requests/?type=print-on-demand')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Print On Demand Requests">Print On Demand </span></a></li>
                        <li><a class="d-flex align-items-center" href="<?= home_url('pod-requests/?type=service-on-demand')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service On Demand">Service On Demand</span></a></li>
                    </ul>
                </li>


                <!-- <li class="nav-item orders"><a class="d-flex align-items-center" href="<?= home_url('product-orders/')  ?>"><i data-feather="shopping-bag"></i><span class="menu-title text-truncate" data-i18n="Orders">Orders</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li> -->



                <!-- Bookings -->
                <li class="nav-item services-main"><a class="d-flex align-items-center" href="#"><i data-feather="gift"></i><span class="menu-title text-truncate" data-i18n="Bookings">Orders</span></a>
                    <ul class="menu-content">
                        <!-- Creation  -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Creations">Creations</span></a>
                            <ul class="menu-content">
                                <li class="order-creations"><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=creations')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=creations&status=wc-pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=creations&status=wc-completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- STL  -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="STL Library">STL Library</span></a>
                            <ul class="menu-content">
                                <li class="order-stl-library"><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=stl-library')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=stl-library&status=wc-pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=stl-library&status=wc-completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- Services  -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Services">Services</span></a>
                            <ul class="menu-content">
                                <li class="order-services"><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=services')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=services&status=wc-pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=services&status=wc-completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- Print On demand  -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Print On Demand">Print On Demand</span></a>
                            <ul class="menu-content">
                                <li class="order-pod"><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=print-on-demand')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=print-on-demand&status=pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=print-on-demand&status=completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- On demand services -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service On Demand">Service On Demand </span></a>
                            <ul class="menu-content">
                                <li class="order-sod"><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=service-on-demand')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=service-on-demand&status=pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=service-on-demand&status=completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- Bulk-Manufacturing -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Bulk-Manufacturing">Bulk Manufacturing</span></a>
                            <ul class="menu-content">
                                <li class="order-bulk"><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=bulk-manufacturing')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=bulk-manufacturing&status=pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=bulk-manufacturing&status=completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                    </ul>
                </li>

                <!-- Dispute Requests  -->
               
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('payout-requests/')  ?>"><i data-feather="wind"></i><span class="menu-title text-truncate" data-i18n="Dispute Requests">Dispute Requests</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>

                <!-- Vendor Mangement -->
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="users">
                        </i><span class="menu-title text-truncate" data-i18n="Vendors Management ">Vendors Management </span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center" href="<?= home_url('vendor-settings/')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Settings">Settings</span>
                            </a>
                        </li>
                        <li class="add-vendor">
                            <a class="d-flex align-items-center" href="<?= home_url('users/?type=vendor')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Vendors">Vendors</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Seller Management -->
                <!-- <li class="nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="user-check">
                        </i><span class="menu-title text-truncate" data-i18n="Seller Management">Seller Management </span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center" href="#!">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Settings">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="<?= home_url('users/?type=seller')  ?>">
                                <i data-feather="users"></i><span class="menu-item text-truncate" data-i18n="Sellers">Sellers</span>
                            </a>
                        </li>
                    </ul>
                </li> -->

                <!-- Customers -->
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('users/?type=customer')  ?>"><i data-feather="user-check"></i><span class="menu-title text-truncate" data-i18n="Customers">Customers</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>
                <!-- Subscribers -->
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="share-2">
                        </i><span class="menu-title text-truncate" data-i18n="Subscribers ">Subscribers </span>
                    </a>
                    <ul class="menu-content">
                        <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('promotions/')  ?>"><i data-feather="volume-2"></i><span class="menu-title text-truncate" data-i18n="Promotions">Promotions</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>

                        <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('subscriber/')  ?>"><i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Subscriber List">Subscriber</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>
                    </ul>
                </li>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('profile-settings/') ?>"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Profile Settings">Account Settings</span></a>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather="message-square"></i><span class="menu-title text-truncate" data-i18n="Chat">Chats</span></a>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('logout/') ?>"><i data-feather='corner-down-left'></i><span class="menu-title text-truncate" data-i18n="Logout">Logout</span></a>
                <!-- <li class=" navigation-header"><a data-i18n="User Interface"  href="!#">Need Help?</a><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                </li> -->
                <!-- <li class="nav-item boards">
                    <a data-i18n="User Interface"  href="<?= home_url('service-bookings/?type=service-on-demand') ?>"><span class="menu-title text-truncate">Service Board</span></a>
                    <a data-i18n="User Interface"  href="<?= home_url('service-bookings/?type=print-on-demand') ?>"><span class="menu-title text-truncate">Print on Demand Board</span></a>
                </li>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><span class="menu-title text-truncate" data-i18n="Chat">Messages</span></a> -->

             
            </ul>
            
        <?php } ?>

        <!-- Vendor Menu Items -->
        <?php  if( in_array('vendor', $user->roles) ) { ?>
            <!-- Vendor Menu -->
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item dashboard"><a class="d-flex align-items-center" href="<?= home_url('dashboard/')  ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>
                <!-- <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('earnings/')  ?>"><i data-feather="dollar-sign"></i><span class="menu-title text-truncate" data-i18n="Earnings">Earnings</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li> -->
                <!-- Transactions -->
                <!-- <li class="nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="dollar-sign">
                        </i><span class="menu-title text-truncate" data-i18n="Transactions">Transactions</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('service-transactions/') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Services">Services</span></a></li>
                        <li><a class="d-flex align-items-center" href="<?= home_url('product-transactions/') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Products">Products </span></a></li>
                    </ul>
                </li> -->



                <!-- Creations -->
                <li class="nav-item product-main" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="shopping-cart">
                        </i><span class="menu-title text-truncate" data-i18n="Creations">Creations</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('add-product/?type=creations') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add Product">Add Creation </span></a></li>
                        <li class="creations"><a class="d-flex align-items-center" href="<?= home_url('all-products/?type=creations')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Products ">All Creations </span></a></li>

                    </ul>
                </li>

                <!-- V Service  -->
                <li class="nav-item services-main" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="package">
                        </i><span class="menu-title text-truncate" data-i18n="Services">Services</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('add-product/?type=services') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Create a Service">Add Service </span></a></li>
                        <li class="services"><a class="d-flex align-items-center" href="<?= home_url('all-products/?type=services')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All SERVICES ">All Services </span></a></li>

                    </ul>
                </li>

                <!-- STL -->
                <li class="nav-item product-main" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="layout">
                        </i><span class="menu-title text-truncate" data-i18n="STL Library">STL Library</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('add-product/?type=stl-library') ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add Product">Add STL File </span></a></li>
                        <li class="stl-File"><a class="d-flex align-items-center" href="<?= home_url('all-products/?type=stl-library')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Products ">All STL Library </span></a></li>

                    </ul>
                </li>

                <!-- Sales -->
                <!-- <li class="nav-item" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="trending-up">
                        </i><span class="menu-title text-truncate" data-i18n="Sales">Sales</span>
                    </a>
                    <ul class="menu-content">
                        <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('product-orders/') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Creations">Creations </span></a>
                        <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?tyep=quick-service') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Services">Services </span></a> -->
                        <!-- <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('print-on-demand-bookings/') ?>"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Services">Print On Demand </span></a> -->
                        <!-- <li class=" nav-item"><a class="d-flex align-items-center" href="#!"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Services">STL </span></a> -->
                        <!-- <li class=" nav-item"><a class="d-flex align-items-center" href="#!"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Services">Creations </span></a> -->
                    <!-- </ul>
                </li> -->

                <!-- Requests  -->
                <li class="nav-item services-main" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="list">
                        </i><span class="menu-title text-truncate" data-i18n="Quote Requests">Requests</span>
                    </a>
                    <ul class="menu-content">
                        <li class="request-pod"><a class="d-flex align-items-center" href="<?= home_url('pod-requests/?type=print-on-demand')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Print On Demand Requests">Print On Demand </span></a></li>
                        <li class="request-sod"><a class="d-flex align-items-center" href="<?= home_url('pod-requests/?type=service-on-demand')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service On Demand">Service On Demand</span></a></li>
                        <li class="request-bulk"><a class="d-flex align-items-center" href="<?= home_url('pod-requests/?type=bulk-manufacturing')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Bulk-Manufacturing">Bulk Manufacturing</span></a></li>
                    </ul>
                </li>

                <!-- Bookings -->
                <li class="nav-item services-main"><a class="d-flex align-items-center" href="#"><i data-feather="gift"></i><span class="menu-title text-truncate" data-i18n="Bookings">Orders</span></a>
                    <ul class="menu-content">
                        <!-- Creation  -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Creations">Creations</span></a>
                            <ul class="menu-content">
                                <li class="order-creations"><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=creations')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=creations&status=wc-pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=creations&status=wc-completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- STL  -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="STL Library">STL Library</span></a>
                            <ul class="menu-content">
                                <li class="order-stl-library"><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=stl-library')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=stl-library&status=wc-pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=stl-library&status=wc-completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- Services  -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Services">Services</span></a>
                            <ul class="menu-content">
                                <li class="order-services"><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=services')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=services&status=wc-pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=services&status=wc-completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- Print On demand  -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Print On Demand">Print On Demand</span></a>
                            <ul class="menu-content">
                                <li class="order-pod"><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=print-on-demand')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=print-on-demand&status=pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=print-on-demand&status=completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- On demand services -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service On Demand">Service On Demand </span></a>
                            <ul class="menu-content">
                                <li class="order-sod"><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=service-on-demand')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=service-on-demand&status=pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=service-on-demand&status=completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                        <!-- Bulk-Manufacturing -->
                        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Bulk-Manufacturing">Bulk Manufacturing</span></a>
                            <ul class="menu-content">
                                <li class="order-bulk"><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=bulk-manufacturing')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="All Requests">All </span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=bulk-manufacturing&status=pending')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Pending Requests">Pending</span></a></li>
                                <li><a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=bulk-manufacturing&status=completed')  ?>"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Completed Requests">Completed</span></a></li>

                            </ul>
                        </li>

                    </ul>
                </li>

               
                <!-- Withdrawls -->
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="credit-card">
                        </i><span class="menu-title text-truncate" data-i18n="Withdrawls">Withdrawls </span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center" href="<?= home_url('payout/')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">Withdraw Requests</span>
                            </a>
                        </li>
                       
                    </ul>
                </li>    
                
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('profile-settings/') ?>"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Profile Settings">Account Settings</span></a>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather="message-square"></i><span class="menu-title text-truncate" data-i18n="Chat">Chats</span></a>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('logout/') ?>"><i data-feather='corner-down-left'></i><span class="menu-title text-truncate" data-i18n="Logout">Logout</span></a>
                <li class="nav-item boards">
                    <a data-i18n="User Interface"  href="<?= home_url('pod-requests/?type=service-on-demand') ?>">Service Board</a>
                    <a data-i18n="User Interface"  href="<?= home_url('pod-requests/?type=print-on-demand') ?>">Print on Demand Board</a>
                </li>
                <li class=" nav-item directmsg"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><span class="menu-title text-truncate" data-i18n="Chat">Messages</span></a>
            </ul>
        <?php } ?>

        <!-- Seller Menu Items -->
        <?php // if( in_array('seller', $user->roles) ) { ?>
            <!-- Seller Menu -->
            <!-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('seller-dashboard/')  ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('earnings/')  ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Earnings">Earnings</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="<?= home_url('seller-transactions/')  ?>">
                        <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">Transactions</span>
                    </a>
                </li>

                <li class="nav-item" >
                    <a class="d-flex align-items-center" href="#"><i data-feather="shopping-cart">
                        </i><span class="menu-title text-truncate" data-i18n="Products">Products</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?= home_url('add-product/') ?>"><i data-feather="menu"></i><span class="menu-item text-truncate" data-i18n="Add Product">Add Product </span></a></li>
                        <li><a class="d-flex align-items-center" href="<?= home_url('all-products/?type=seller/')  ?>"><i data-feather="menu"></i><span class="menu-item text-truncate" data-i18n="All Products ">All Products </span></a></li>

                    </ul>
                </li>
            
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('orders/') ?>"><i data-feather="menu"></i><span class="menu-title text-truncate" data-i18n="Sales">Sales </span></a>
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="shopping-cart">
                        </i><span class="menu-title text-truncate" data-i18n="Withdrawls">Withdrawls </span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center" href="<?= home_url('payout/')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">Withdraw Requests</span>
                            </a>
                        </li>
                       
                    </ul>
                </li>   
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('profile-settings/') ?>"><i data-feather="menu"></i><span class="menu-title text-truncate" data-i18n="Profile Settings">Profile Settings</span></a>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather="message-square"></i><span class="menu-title text-truncate" data-i18n="Chat">Chat</span></a>

                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('logout/') ?>"><i data-feather="menu"></i><span class="menu-title text-truncate" data-i18n="Logout">Logout</span></a>  
            </ul> -->
        <?php // } ?>

        <!-- Customer Menu Items -->
        <?php  if( in_array('customer', $user->roles) ) { ?>
            <!-- Seller Menu -->
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('dashboard/')  ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="layers">
                        </i><span class="menu-title text-truncate" data-i18n="My Requests">My Requests </span>
                    </a>
                    <ul class="menu-content">
                        <li class="quote-pod">
                            <a class="d-flex align-items-center" href="<?= home_url('pending-requests/?type=print-on-demand')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Print On Demand">Print On Demand</span>
                            </a>
                        </li>
                        <li class="quote-sod">
                            <a class="d-flex align-items-center" href="<?= home_url('pending-requests/?type=service-on-demand')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service On Demand">Service On Demand</span>
                            </a>
                        </li>
                        <li class="quote-bulk">
                            <a class="d-flex align-items-center" href="<?= home_url('pending-requests/?type=bulk-manufacturing')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Bulk Manufacturing">Bulk Manufacturing</span>
                            </a>
                        </li>
                       
                    </ul>
                </li> 

                <li class="nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="layers">
                        </i><span class="menu-title text-truncate" data-i18n="Bookings">Orders </span>
                    </a>
                    <ul class="menu-content">
                        <li class="order-creations">
                            <a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=creations')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Order(Creations)">Order (Creations)</span>
                            </a>
                        </li>
                        <li class="order-stl-library">
                            <a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=stl-library')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Order(STL Library)">Order (STL File)</span>
                            </a>
                        </li>
                        <li class="order-services">
                            <a class="d-flex align-items-center" href="<?= home_url('product-orders/?type=services')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Order(Services)">Order (Services)</span>
                            </a>
                        </li>
                        <li class="order-sod">
                            <a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=service-on-demand')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service On Demand">Service On Demand</span>
                            </a>
                        </li>

                        <li class="order-pod">
                            <a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=print-on-demand')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Print On Demand">Print On Demand</span>
                            </a>
                        </li>

                        <li class="order-bulk">
                            <a class="d-flex align-items-center" href="<?= home_url('service-bookings/?type=bulk-manufacturing')  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Bulk Manufacturing">Bulk Manufacturing</span>
                            </a>
                        </li>
                       
                    </ul>
                </li> 

                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('profile-settings/') ?>"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Profile Settings">Account Settings</span></a>
                
                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('product-category/creations/art/') ?>"><i data-feather="globe"></i><span class="menu-title text-truncate" data-i18n="Shop">Shop</span></a>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?= home_url('chat/') ?>"><i data-feather="message-square"></i><span class="menu-title text-truncate" data-i18n="Chat">Chats</span></a>

                <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('logout/') ?>"><i data-feather="corner-down-left"></i><span class="menu-title text-truncate" data-i18n="Logout">Logout</span></a>  

                
            </ul>
        <?php } ?>
    </div>

</div>
<script>
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
</script>
