<?php
/**
 * Plugin Name:       AI WooCommerce Assistance
 * Plugin URI:        https://www.kbizsoft.com/
 * Description:       AI-powered assistance for your WordPress/WooCommerce site. Supports Google Gemini, OpenAI, and Anthropic Claude. Answers are strictly limited to your site's products, orders, pages, posts, FAQs, and offers — never off-topic responses.
 * Version:           1.2.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Kbizsoft Solutions Pvt. Ltd.
 * Author URI:        https://www.kbizsoft.com/
 * License:           AFL-3.0
 * License URI:       http://opensource.org/licenses/afl-3.0.php
 * Text Domain:       ai-woo-assistance
 * Domain Path:       /languages
 *
 * @package    AI_Woo_Assistance
 * @author     Kbizsoft Solutions Pvt. Ltd.
 * @copyright  2010-2026 Kbizsoft Solutions Pvt. Ltd.
 * @license    http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ---- Constants -------------------------------------------------------

define( 'AIA_VERSION',     '1.2.0' );
define( 'AIA_PLUGIN_FILE', __FILE__ );
define( 'AIA_PLUGIN_DIR',  plugin_dir_path( __FILE__ ) );
define( 'AIA_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );
define( 'AIA_OPTION_NAME', 'aia_settings' );

// ---- Bootstrap -------------------------------------------------------

function aiwc_init_plugin() {
    require_once AIA_PLUGIN_DIR . 'includes/class-aia-settings.php';
    require_once AIA_PLUGIN_DIR . 'includes/class-aia-woo-context.php';
    require_once AIA_PLUGIN_DIR . 'includes/class-aia-rest-api.php';
    require_once AIA_PLUGIN_DIR . 'includes/class-aia-history.php';
    require_once AIA_PLUGIN_DIR . 'includes/class-aia-widget.php';
    require_once AIA_PLUGIN_DIR . 'includes/class-aia-plugin.php';

    AIA_Plugin::instance();
}
add_action( 'plugins_loaded', 'aiwc_init_plugin' );

// ---- Activation ------------------------------------------------------

function aiwc_activate() {
    if ( ! get_option( AIA_OPTION_NAME ) ) {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-aia-settings.php';
        add_option( AIA_OPTION_NAME, AIA_Settings::defaults() );
    }

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-aia-history.php';
    AIA_History::create_tables();
    AIA_History::instance()->schedule_cleanup();
}
register_activation_hook( __FILE__, 'aiwc_activate' );

// ---- Deactivation ----------------------------------------------------

function aiwc_deactivate() {
    if ( class_exists( 'AIA_History' ) ) {
        AIA_History::instance()->clear_cleanup_schedule();
    }
}
register_deactivation_hook( __FILE__, 'aiwc_deactivate' );
