<style>
    li.not-used {
    pointer-events: none;
    opacity: 0.4;
    }
</style>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="<?= home_url() ?>"><span class="brand-logo">
                        <img src="<?= home_url('wp-content/uploads/2024/05/LDI-Logo.png') ?>" alt="">
                        <!-- <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                            <defs>
                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                    <stop stop-color="#000000" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                        <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                        <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                    </g>
                                </g>
                            </g>
                        </svg> -->
                    </span>
                    <h3 class="brand-text">Luxury<small>Detailing</small></h3>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('dashboard/')  ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>
            <li class="nav-item users">
				<a class="d-flex align-items-center" href="<?= home_url('user/')  ?>">
					<i data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Users">Users</span>
					<span class="badge badge-light-warning rounded-pill ms-auto me-1"></span>
				</a>
				<ul class="menu-content">
                    <li class="user-all">
                        <a class="d-flex align-items-center" href="<?= home_url('user/?role=all')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">All</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('user/?role=student')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">Student</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('user/?role=faculty')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Faculty/Staff">Faculty/Staff</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('user/?role=admin')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Admin">Admin</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('user/?role=vendor')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Vendors">Vendors</span>
                        </a>
                    </li>
                   
					<li>
                        <a class="d-flex align-items-center" href="<?= home_url('user/?role=other')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">Other</span>
                        </a>
                    </li>
                </ul>
			</li>
            <li class="nav-item all-services">
                <a class="d-flex align-items-center" href="#"><i data-feather="shopping-cart">
                    </i><span class="menu-title text-truncate" data-i18n="Dispute Request">Services</span>
                </a>
                <ul class="menu-content">
                    <li class="services-all">
                        <a class="d-flex align-items-center" href="<?= home_url('all-services/')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">All</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('all-services/?type=main_service')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">Main</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('all-services/?type=special_service')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">Add-Ons</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="<?= home_url('add-services/')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">Add New</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item all-orders">
                <a class="d-flex align-items-center" href="<?= home_url('all-orders')  ?>">
                    <i data-feather="menu"></i><span class="menu-title text-truncate" data-i18n="V Service Bookings">Service Bookings</span>
                </a>
                <ul class="menu-content">
                    <li class="orders-all">
                        <a class="d-flex align-items-center" href="<?= home_url('all-orders/')  ?>">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">All</span>
                        </a>
                    </li>
    
                    <?php 
                   // $pages_with_links = ['PG1', 'PG3'];

                    $pages_with_links = ['PG1', 'PG3'];
                    $data['PG1'] = ['name'=>'Gold Garage'];
                    $data['PG2'] = ['name'=>'PG2'];
                    $data['PG3'] = ['name'=>'Panther Garage'];
                    $data['PG4'] = ['name'=>'PG4'];
                    $data['PG5'] = ['name'=>'PG5'];
                    $data['PG6'] = ['name'=>'PG6'];
                    $data['engr-campus-garage'] = ['name'=>'engr-campus-garage'];

                    //foreach (['PG1','PG2','PG3','PG4','PG5','PG6','engr-campus-garage'] as $key => $value) { 
                    foreach ($data as $key => $value) {
                        $link = in_array($key, $pages_with_links) ? home_url('all-orders/?garage='.$key) : '#';
                        $class = !in_array($key, $pages_with_links) ? 'not-used' : 'used'; ?>
                        <li class="<?= $class ?>">
                            <a class="d-flex align-items-center" href="<?= $link  ?>">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop"><?= str_replace("-"," ",ucwords($value['name'])) ?></span>
                            </a>
                        </li>

                    <?php } ?>
                </ul>
            </li>
            <li class="nav-item"><a class="d-flex align-items-center" href="<?= home_url('reviews-log/')  ?>"><i data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Users">Reviews</span><span class="badge badge-light-warning rounded-pill ms-auto me-1"></span></a></li>
        </ul>
    </div>
</div>