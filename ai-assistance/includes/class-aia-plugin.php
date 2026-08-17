<?php
/**
 * Plugin bootstrap — instantiates all components.
 *
 * @package    AI_Woo_assistance
 * @author     Kbizsoft Solutions Pvt. Ltd.
 * @copyright  2010-2026 Kbizsoft Solutions Pvt. Ltd.
 * @license    http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstraps all plugin components. Singleton so we don't wire hooks twice.
 */
final class AIA_Plugin {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        load_plugin_textdomain( 'ai-woo-assistance', false, dirname( plugin_basename( AIA_PLUGIN_FILE ) ) . '/languages' );

        new AIA_Settings();
        new AIA_Rest_Api();
        new AIA_Widget();
    }
}
