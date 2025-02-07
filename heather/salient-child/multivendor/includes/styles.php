<?php $directory_url = get_stylesheet_directory_uri()."/multivendor"; ?>

<head>

    <title>Julianna Moda</title>
    <link rel="icon" type="image/x-icon" href="	https://devu11.testdevlink.net/heather/wp-content/uploads/2024/05/Logo.png">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/extensions/toastr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

     <!-- END: Vendor CSS-->

    <!-- Bootstrap CSS -->


    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/themes/semi-dark-layout.css">


     <!-- BEGIN: Page CSS-->
     <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
     <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/pages/dashboard-ecommerce.css">
     <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/css/plugins/extensions/ext-component-toastr.css">
     <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- END: Custom CSS-->

    <script>
        // Replace 'your-element-id' with the actual ID of your HTML element
        var element = document.querySelector('html');
		var light = localStorage.getItem('light-layout-current-skin');
		light = light ? light : 'light-layout';
        element.classList.add(light);
    </script>

    <style>
        #toast-container>.toast-success {
            background-color: white;
        }

        div.dataTables_wrapper div.dataTables_length select {
            background-position: calc(100% - 3px) 3px, calc(100% - 20px) 13px, 100% 0;
        }
		.dark-layout .main-menu .collapse-toggle-icon {
			color: #557026 !important;
		}
		
		.dark-layout .pagination:not([class*='pagination-']) .page-item.active .page-link {
			background-color: #556f28;
		}
		.dark-layout .dataTables_wrapper .dt-buttons .buttons-copy:active, .dark-layout .dataTables_wrapper .dt-buttons .buttons-excel:active, .dark-layout .dataTables_wrapper .dt-buttons .buttons-pdf:active, .dark-layout .dataTables_wrapper .dt-buttons .buttons-print:active, .dark-layout .dataTables_wrapper .dt-buttons .btn-secondary:active, .dark-layout .dataTables_wrapper .dt-buttons .dt-button-collection [class*='buttons-']:active {
    background-color: #556f28 !important;
    color: #fff;
}
		
		.dt-buttons button:hover {
			color: #fff;
			background-color: #577226 !important;
			border-color: #577226 !important;
		}
		
		.dark-layout a:hover {
			color: #577226;
		}
		.logo-wrapper h3.invoice-logo {
			margin-left: 12px;
		}
    </style>

</head>