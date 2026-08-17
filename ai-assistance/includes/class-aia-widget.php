<?php
/**
 * Floating chat widget — renders HTML and enqueues frontend assets.
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
 * Renders the floating chat widget and enqueues its CSS/JS assets.
 */
class AIA_Widget {

    private $rendered = false;

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'wp_footer',          array( $this, 'render' ) );
        add_action( 'wp_body_open',       array( $this, 'render' ) );
    }

    public function enqueue_assets() {
        $opts = wp_parse_args( get_option( AIA_OPTION_NAME, array() ), AIA_Settings::defaults() );
        if ( empty( $opts['enabled'] ) ) return;

        wp_enqueue_style(
            'aia-widget',
            AIA_PLUGIN_URL . 'assets/css/widget.css',
            array(),
            AIA_VERSION
        );

        wp_enqueue_script(
            'aia-widget',
            AIA_PLUGIN_URL . 'assets/js/widget.js',
            array(),
            AIA_VERSION,
            false
        );

        wp_localize_script( 'aia-widget', 'aiaData', array(
            'restUrl'  => esc_url_raw( rest_url( 'aia/v1/chat' ) ),
            'nonce'    => wp_create_nonce( 'wp_rest' ),
            'siteName' => get_bloginfo( 'name' ),
            'i18n'     => array(
                'placeholder' => __( 'Type your question…', 'ai-woo-assistance' ),
                'send'        => __( 'Send', 'ai-woo-assistance' ),
                'error'       => __( 'Something went wrong. Please try again.', 'ai-woo-assistance' ),
            ),
        ) );
    }

    public function render() {
        if ( $this->rendered ) {
            return;
        }

        $opts = wp_parse_args( get_option( AIA_OPTION_NAME, array() ), AIA_Settings::defaults() );
        if ( empty( $opts['enabled'] ) ) return;

        $title = ! empty( $opts['widget_title'] ) ? $opts['widget_title'] : __( 'Chat with us', 'ai-woo-assistance' );
        $this->rendered = true;
        ?>
        <div id="aia-widget" role="region" aria-label="<?php esc_attr_e( 'Live chat', 'ai-woo-assistance' ); ?>">

            <!-- Toggle button -->
            <button id="aia-toggle"
                    aria-haspopup="dialog"
                    aria-expanded="false"
                    aria-label="<?php esc_attr_e( 'Open chat', 'ai-woo-assistance' ); ?>">
                💬
                <span class="aia-badge" aria-hidden="true">1</span>
            </button>

            <!-- Chat window -->
            <div id="aia-window"
                 style="display:none;"
                 role="dialog"
                 aria-label="<?php echo esc_attr( $title ); ?>"
                 aria-modal="false">

                <!-- Header -->
                <div id="aia-header">
                    <div class="aia-avatar" aria-hidden="true">🤖</div>
                    <div class="aia-header-info">
                        <div class="aia-header-title"><?php echo esc_html( $title ); ?></div>
                        <div class="aia-status">
                            <span class="aia-status-dot" aria-hidden="true"></span>
                            <span><?php esc_html_e( 'Online · Replies instantly', 'ai-woo-assistance' ); ?></span>
                        </div>
                    </div>
                    <button id="aia-close"
                            aria-label="<?php esc_attr_e( 'Close chat', 'ai-woo-assistance' ); ?>"
                            title="<?php esc_attr_e( 'Close', 'ai-woo-assistance' ); ?>">
                        ✕
                    </button>
                </div>

                <!-- Messages -->
                <div id="aia-messages"
                     role="log"
                     aria-live="polite"
                     aria-label="<?php esc_attr_e( 'Chat messages', 'ai-woo-assistance' ); ?>">
                </div>

                <!-- Input -->
                <div id="aia-input-row">
                    <input type="text"
                           id="aia-input"
                           autocomplete="off"
                           placeholder="<?php esc_attr_e( 'Type your question…', 'ai-woo-assistance' ); ?>"
                           aria-label="<?php esc_attr_e( 'Message', 'ai-woo-assistance' ); ?>" />
                    <button id="aia-send"
                            aria-label="<?php esc_attr_e( 'Send message', 'ai-woo-assistance' ); ?>"
                            title="<?php esc_attr_e( 'Send', 'ai-woo-assistance' ); ?>">
                        ➤
                    </button>
                </div>

                <!-- Powered-by footer -->
                <div id="aia-footer" aria-hidden="true">
                    <?php esc_html_e( 'Powered by AI · Answers based on this website only', 'ai-woo-assistance' ); ?>
                </div>

            </div><!-- #aia-window -->
        </div><!-- #aia-widget -->
        <?php
    }
}
