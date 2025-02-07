<?php /* Template Name: Logout  */  ?>
<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;
// Perform logout action
wp_logout();

// Redirect to home page or any other page after logout
wp_redirect(home_url('/login'));
exit;