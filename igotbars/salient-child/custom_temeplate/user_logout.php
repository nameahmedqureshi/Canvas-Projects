<?php /* Template Name: Logout  */ 
// ob_start();
wp_logout();
wp_redirect(home_url());

exit;
?>