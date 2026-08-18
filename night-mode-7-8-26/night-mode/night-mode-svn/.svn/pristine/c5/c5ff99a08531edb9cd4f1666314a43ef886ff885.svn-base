<?php
/*
Plugin Name: Night Mode
Plugin URI: https://wordpress.org/plugins/night-mode/
Description: This is for change the admin end color with text.
Author: Mark Daniels
Version: 1.4.0
Author URI: http://www.kbizsoft.com
*/

$ntmode_path = plugin_dir_path(__FILE__);
$ntmode_path .= '/change_color.php'; 
include_once($ntmode_path);
$ntmode_Opts = new ntmode_options;

if (is_admin()) {
	
	// Add option page to setting
	add_action('admin_menu', array($ntmode_Opts, 'ntmode_AdminPage'));
	
	// add js file to admin footer
	add_action( 'admin_footer', array($ntmode_Opts, 'ntmod_Footer'));
	
}

add_action( 'admin_bar_menu', 'kbiz_ntmode_modify_admin_bar' );
function kbiz_ntmode_modify_admin_bar( $wp_admin_bar ){
	$wp_admin_bar->add_node(array(
		'id'    => 'kbiz_enable_night_mode',
		'title' => 'Enabled Night Mode'
	));
}

// plugin decativation
register_deactivation_hook( __FILE__, 'ntmode_option_del' );
function ntmode_option_del() {
	delete_option( 'ntmode_page_setting' );
}
?>
