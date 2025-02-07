<?php
$directory_url = get_stylesheet_directory_uri() . '/store';
?>

<head>
    <title><?= get_the_title(get_the_ID())." >" ?>  Kainamo</title>
    <link rel="icon" type="image/x-icon" href="<?= home_url()?>/wp-content/uploads/2024/04/Group-261.png">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/extensions/toastr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.js"></script> -->


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
    <!-- END: Custom CSS-->

    <script>
        // Replace 'your-element-id' with the actual ID of your HTML element
        var element = document.querySelector('html');
        element.classList.add(localStorage.getItem('light-layout-current-skin'));
    </script>
<style>
		
	a:hover {
		color: #084025;
		text-decoration: none;
	}
	.dark-layout .dropdown-menu .dropdown-item:hover, .dark-layout .dropdown-menu .dropdown-item:focus {
		background: rgba(115, 103, 240, 0.12);
		color: #d0d0d0;
	}
	
.form-select-sm {
    padding-top: 9px !important;
    padding-bottom: 5px !important;
}
.main-menu .navbar-header .navbar-brand .brand-text {
    color: black;
}
.dark-layout .main-menu .navbar-header .navbar-brand .brand-text {
    color: #ffffff;
}
.dark-layout .main-menu .collapse-toggle-icon {
    color: #ffffff !important;
}
.dark-layout a:hover {
    color: #7d828e;
}
.dark-layout a {
    color: #fefffe;
}
.dark-layout .text-primary {
    color: #ffffff !important;
}
	
.btn-primary:focus, .btn-primary:active, .btn-primary.active {
    color: #fff;
    background-color: #084025 !important;
}
</style>
</head>
