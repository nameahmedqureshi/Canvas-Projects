<?php /*Template Name: Shared & Committee */ ?>
<?php //if(is_user_logged_in()) {  wp_redirect(home_url('dashboard/')); exit; } ?>
    <!-- BEGIN: Head-->
    <?php include "includes/styles.php"; ?>

 

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <!-- END: Page CSS-->

    <?php include "includes/header.php"; ?>

    <body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    <!-- BEGIN: Main Menu-->
        <?php include "includes/manu.php"; ?>
        <!-- END: Main Menu-->

        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <h2 class="content-header-title float-start mb-0">Shared And Committee</h2>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="content-body">
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Shared And Committee</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text mb-2 pb-1">
                                    Use of any product you buy from PIXINVENT is bound by the license you purchase. It will allow you the
                                    non-exclusive access to use it in your personal as well as client projects.
                                </p>

                               

                                <!-- single license -->
                                <h5>Single License</h5>
                                <ul class="ps-25 ms-1">
                                    <li>You have rights to use our product for your personal or client project.</li>
                                    <li>You can modify our product as per your needs and use it for your personal or client project.</li>
                                </ul>
                                <p class="card-text mb-2 pb-75">
                                    With Single License you will be able to use our product for yourself or your client project for 1 time. If you
                                    want to use it for multiple times, you need to buy another regular license every time. Ownership and Copyright
                                    of our template will stay with ThemeSelection after purchasing single license. That means you are allowed to use
                                    our template in your project and use for one client or yourself,
                                </p>

                                <!-- multiple license -->
                                <h5>Multiple License</h5>
                                <ul class="ps-25 ms-1">
                                    <li>You can use our product for your personal or client project. 😎</li>
                                    <li>You can use our product for unlimited projects when end users are not charged.</li>
                                </ul>
                                <p class="card-text mb-2 pb-75">
                                    With Multiple Use License you will be able to use our product for yourself as well as your client projects. You
                                    can use product for unlimited projects. Ownership and Copyright of our template will stay with ThemeSelection
                                    after purchasing multiple use license. That means you are allowed to use our template in your project and use
                                    for multiple clients and yourself, but you are not allowed to create SaaS application and sell that,
                                </p>

                                <!-- extended license -->
                                <h5>Extended License</h5>
                                <ul class="ps-25 ms-1">
                                    <li>You can use our product for your personal or client project.</li>
                                    <li>You cannot resell, redistribute, lease, license or offer the product to any third party.</li>
                                </ul>
                                <p class="card-text mb-2 pb-1">
                                    With Extended License you will be able to use our product for yourself or your client project for one time. You
                                    can use it for building one project. Ownership and Copyright of our template will remain with ThemeSelection and
                                    that means, you are not allowed to sell, distribute or lease our template as it is to anyone
                                </p>

                                <!-- alert -->
                                <div class="alert alert-primary">
                                    <div class="alert-body d-flex align-items-center justify-content-between flex-wrap p-2">
                                        <div class="me-1">
                                            <h4 class="fw-bolder text-primary">Do you need custom license? 👩🏻‍💻</h4>
                                            <p class="fw-normal mb-1 mb-lg-0">
                                                If you’ve mass production demand and other custom use cases than we’re here to help you.
                                            </p>
                                        </div>
                                        <button class="btn btn-primary">Contact Us</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
        <!-- END: Content-->
        
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <?php include "includes/scripts.php"; ?>
      

        <script>
           

            $(window).on('load', function() {
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            })
        </script>

    </body>
    <!-- END: Body-->

</html>