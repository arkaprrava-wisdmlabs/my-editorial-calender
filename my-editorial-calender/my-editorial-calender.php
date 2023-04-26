<?php

/*
Plugin Name: My Editorial Calendar
Description: This is a test Plugin
Version: 1.0.0
Author: Arkaprava
Text Domain:   myedcal
Domain Path:   /lang
*/

if(!defined('ABSPATH')){
    die();
}
include('includes/mec-activator.php');
register_activation_hook( __FILE__, 'myedcal_activation' );

include('includes/mec-deactivator.php');
register_deactivation_hook( __FILE__, 'myedcal_deactivation' );

include('admin/admin-menu.php');
add_action( 'admin_menu', 'myedcal_admin_menu' );


?>