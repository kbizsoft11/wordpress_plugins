<?php

/*
Plugin Name:  Woocommerce Save For Later Like Amazon
Plugin URI: https://kbizsoft.com/
Description: Save for Later Plugin , Specifically made for WooCommerce . It's being Used by millions, Save For Later helps in enhancing the conversion rate on the website . 
Version: 1.0.0
Author: Kabeer
License: GPLv2 or later
Text Domain: Save-For-Later-Like-Amazon
 */
require_once "core.php";
use \Woo\SaveForLater\WSFLLA_SaveForLater;
$ini = new WSFLLA_SaveForLater;
register_activation_hook( __FILE__, array( 'Woo\SaveForLater\WSFLLA_SaveForLater', 'wsflla_install' ) ); 
