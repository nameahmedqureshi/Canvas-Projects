<?php /* Template Name: Logout  */ 
wp_logout();
// Redirect to home page or any other page after logout
wp_redirect(home_url('login'));
exit;
?>