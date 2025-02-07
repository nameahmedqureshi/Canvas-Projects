<?php /* Template Name: S Product Report */ ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<?php include "includes/styles.php"; ?>

    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
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


<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
   
    <!-- END: Header-->


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
                <!-- users list start -->
                <section class="app-user-list">
                  
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <h4 class="card-title">S Product Report</h4>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Coupon</th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sellers_earnings = array(
                                        array(
                                            'Id' => '1',
                                            'Coupon' => 'cfg345',
                                        ),
                                        array(
                                            'Id' => '2',
                                            'Coupon' => 'cfg345',
                                        ),
                                        array(
                                            'Id' => '3',
                                            'Coupon' => 'cfg345',
                                        ),
                                        array(
                                            'Id' => '4',
                                            'Coupon' => 'cfg345',
                                        ),
                                        array(
                                            'Id' => '5',
                                            'Coupon' => 'cfg345',
                                        ),
                                    );
                                    
                                    foreach ($sellers_earnings as $key => $seller) {
                                    ?>

                                        <tr>
                                            <td><?= $seller['Id'] ?></td>
                                            <td><?= $seller['Coupon'] ?></td>
                                            <td>
                                                <a href="#!" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit value Detail">
                                                    <i data-feather='edit'></i>
                                                </a>

                                                <a href="#!" class="delete-record" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete value">
                                                    <i data-feather='trash-2'></i>
                                                </a>
                                            </td>
                                        </tr>

                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->

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
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?= get_stylesheet_directory_uri()  ?>/store/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>

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
       
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
               
            ],
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