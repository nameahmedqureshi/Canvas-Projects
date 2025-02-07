<?php
if (!is_user_logged_in()) {
    wp_redirect(home_url());
    echo '<script>window.location = "'.home_url().'" </script>';
    exit;
}

$directory_url = get_stylesheet_directory_uri() . '/services';
?>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
    <title>Light and Breezy Coaching<?= $site_t ? $site_t : "" ?></title>
    <link rel="apple-touch-icon" href="<?= home_url('wp-content/uploads/2023/11/cropped-PNG.png') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= home_url('wp-content/uploads/2023/11/cropped-PNG.png') ?>">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="<?= $directory_url ?>/app-assets/vendors/css/extensions/toastr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/waitme@1.19.0/waitMe.min.css">

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

</head>