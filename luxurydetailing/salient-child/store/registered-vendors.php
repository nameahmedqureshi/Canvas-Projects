<?php /* Template Name: Registered Vendors */ ?>
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
                            <h4 class="card-title">Registered Vendors</h4>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email </th>
                                        <th>Phone</th>
                                        <th>Account Status  </th>
                                        <th>Email Status </th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sellers_earnings = array(
                                        array(
                                            'ID' => 'ce435t',
                                            'Username' => 'ABC',
                                            'Email' => 'Staphene@test.com',
                                            'Phone' => '+111-333-444',
                                            'AccountStatus' => 'Active',
                                            'EmailStatus' => 'Not Verified',
                                        ),
                                        array(
                                            'ID' => 'ce435t',
                                            'Username' => 'ABC',
                                            'Email' => 'Staphene@test.com',
                                            'Phone' => '+111-333-444',
                                            'AccountStatus' => 'Active',
                                            'EmailStatus' => 'Not Verified',
                                        ),
                                        array(
                                            'ID' => 'ce435t',
                                            'Username' => 'ABC',
                                            'Email' => 'Staphene@test.com',
                                            'Phone' => '+111-333-444',
                                            'AccountStatus' => 'Not Active',
                                            'EmailStatus' => 'Not Verified',
                                        ),
                                        array(
                                            'ID' => 'ce435t',
                                            'Username' => 'ABC',
                                            'Email' => 'Staphene@test.com',
                                            'Phone' => '+111-333-444',
                                            'AccountStatus' => 'Not Active',
                                            'EmailStatus' => 'Verified',
                                        ),
                                        array(
                                            'ID' => 'ce435t',
                                            'Username' => 'ABC',
                                            'Email' => 'Staphene@test.com',
                                            'Phone' => '+111-333-444',
                                            'AccountStatus' => 'Active',
                                            'EmailStatus' => 'Verified',
                                        ),
                                    );
                                    
                                    foreach ($sellers_earnings as $key => $seller) {
                                    ?>

                                        <tr>
                                            <td><?= $seller['ID'] ?></td>
                                            <td><?= $seller['Username'] ?></td>
                                            <td><?= $seller['Email'] ?></td>
                                            <td><?= $seller['Phone'] ?></td>
                                            <td><?= $seller['AccountStatus'] ?></td>
                                            <td><?= $seller['EmailStatus'] ?></td>
                                            <td>
                                                <a href="#!" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Details">
                                                    <i data-feather='list'></i>
                                                </a> 

                                                <a href="#!" class="item-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit">
                                                    <i data-feather='edit'></i>

                                                </a>

                                                <a href="#!" class="delete-record" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete">
                                                    <i data-feather='trash-2'></i>
                                                </a>

                                                <a href="#!" class="delete-record" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change Password">
                                                    <i data-feather='trash-2'></i>
                                                </a>

                                                <a href="#!" class="delete-record" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Deactivate Account">
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
            // language: {
            //     sLengthMenu: 'Show _MENU_',
            //     search: 'Search',
            //     searchPlaceholder: 'Search..'
            // },
            // Buttons with Dropdown
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',

                {
                    text: 'Add New Vendor',
                    className: 'add-new btn btn-primary',
                    attr: {
                        // 'data-bs-toggle': 'modal',
                        // 'data-bs-target': '#addservicemodal'
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
            ],
            });

            $(document).on("click",".add-new",function() {
                $(location).prop('href', "#");
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
