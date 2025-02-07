<?php /* Template Name: Total Earnings */ ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/css/core/menu/menu-types/vertical-menu.css">

    <style>
        .dt-buttons button {
            border: 1px solid #82868b !important;
            background-color: transparent;
            color: #82868b;
            padding: 0.386rem 1.2rem;
            font-weight: 500;
            font-size: 1rem;
            border-radius: 0.358rem;
        }
        .dt-buttons button:hover {
            color: #fff;
            background-color: #7367f0;
            border-color: #7367f0;
        }
        button.dt-button.add-new.btn.btn-primary {
            padding: 10px;
        }
    </style>
<!-- END: Head-->
<?php include "includes/header.php"; ?>
<!-- BEGIN: Body-->

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
            </div>
            <div class="content-body">
                <!--list start -->
                <section class="app-user-list">
                    <!-- Total Earnings -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h4 class="card-title">Monthly Total Earning</h4>
                            <section id="dropdown-with-outline-btn">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="demo-inline-spacing">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Select Month
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">2024</a>
                                                            <a class="dropdown-item" href="#">2023</a>
                                                            <a class="dropdown-item" href="#">2022</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Month Name</th>
                                        <th>Total Earning</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $months = ['January','Febuary','March','April','May','June','July','August','September','October','November', 'December'];
                                        foreach ($months as $key => $value) {
                                    ?>
                                        <tr>
                                           <td><?= $value ?></td>
                                           <td>$0</td>
                                        </tr>

                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- list ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


    <?php include "includes/scripts.php"; ?>

    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script> -->
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/js/scripts/components/components-dropdowns.js"></script>

    <script>
        var table = $('.datatables-basic').DataTable({

           // order: [[1, 'desc']],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
                '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            });
            table.on('draw', function () {
            feather.replace({
                width: 14,
                height: 14
            });
            });
    </script>
</body>
<!-- END: Body-->

</html>