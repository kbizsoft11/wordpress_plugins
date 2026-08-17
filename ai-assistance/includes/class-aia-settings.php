<?php
/**
 * Admin settings page for AI WooCommerce assistance.
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
 * Handles the plugin settings registration, sanitization, and admin UI.
 */
class AIA_Settings {

	/** Constructor – wire WP hooks. */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Register the top-level "AI Assistance" menu and its three sub-menu pages.
	 *
	 * Menu structure:
	 *   AI Assistance  (top-level, collapses to Dashboard)
	 *   ├── Dashboard
	 *   ├── Settings
	 *   └── Help & Docs
	 */
	public function add_admin_menu() {
		// Top-level menu item (points to Dashboard).
		add_menu_page(
			__( 'AI Assistance', 'ai-woo-assistance' ),          // Page <title>.
			__( 'AI Assistance', 'ai-woo-assistance' ),          // Left-menu label.
			'manage_options',
			'ai-woo-assistance',                              // Slug – parent slug for sub-menus.
			array( $this, 'render_dashboard_page' ),       // Default page = Dashboard.
			'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 9h8M8 13h5"/><circle cx="16" cy="13" r="1" fill="currentColor"/></svg>' ),
			58   // Position: just below WooCommerce (56).
		);

		// Sub-menu 1 — Dashboard (replaces the auto-duplicate of parent).
		add_submenu_page(
			'ai-woo-assistance',
			__( 'AI Assistance Dashboard', 'ai-woo-assistance' ),
			__( 'Dashboard', 'ai-woo-assistance' ),
			'manage_options',
			'ai-woo-assistance',
			array( $this, 'render_dashboard_page' )
		);

		// Sub-menu 2 — Chat History.
		add_submenu_page(
			'ai-woo-assistance',
			__( 'AI Assistance Chat History', 'ai-woo-assistance' ),
			__( 'Chat History', 'ai-woo-assistance' ),
			'manage_options',
			'ai-woo-assistance-history',
			array( $this, 'render_history_page' )
		);

		// Sub-menu 3 — Settings.
		add_submenu_page(
			'ai-woo-assistance',
			__( 'AI Assistance Settings', 'ai-woo-assistance' ),
			__( 'Settings', 'ai-woo-assistance' ),
			'manage_options',
			'ai-woo-assistance-settings',
			array( $this, 'render_settings_page' )
		);

		// Sub-menu 4 — Help & Docs.
		add_submenu_page(
			'ai-woo-assistance',
			__( 'AI Assistance Help & Docs', 'ai-woo-assistance' ),
			__( 'Help &amp; Docs', 'ai-woo-assistance' ),
			'manage_options',
			'ai-woo-assistance-help',
			array( $this, 'render_help_page' )
		);
	}

	/** Register the setting with WordPress. */
	public function register_settings() {
		register_setting(
			'AIA_settings_group',
			AIA_OPTION_NAME,
			array( $this, 'sanitize_settings' )
		);
	}


	/**
	 * Enqueue the admin-page assets (inline JS only – no extra HTTP request).
	 *
	 * @param string $hook Current admin page hook suffix.
	 */
	public function enqueue_admin_assets( $hook ) {
		// Only load on our own admin pages.
		$our_hooks = array(
			'toplevel_page_ai-woo-assistance',
			'ai-assistance_page_ai-woo-assistance-settings',
			'ai-assistance_page_ai-woo-assistance-history',
			'ai-assistance_page_ai-woo-assistance-help',
		);
		if ( ! in_array( $hook, $our_hooks, true ) ) {
			return;
		}

		$models_endpoint = esc_url_raw( rest_url( 'aia/v1/models' ) );
		$nonce           = wp_create_nonce( 'wp_rest' );

		/* phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped */
		$inline_js = <<<JS
(function(){
	var REST_URL  = '{$models_endpoint}';
	var REST_NONCE = '{$nonce}';

	var keyLabels = {
		gemini: 'Google AI Studio API Key',
		openai: 'OpenAI API Key',
		claude: 'Anthropic API Key'
	};
	var keyLinks = {
		gemini: 'https://aistudio.google.com/app/apikey',
		openai: 'https://platform.openai.com/api-keys',
		claude: 'https://console.anthropic.com/settings/keys'
	};

	// Cache fetched model lists to avoid redundant API calls per page load.
	var modelCache = {};

	/**
	 * Fetch live models from /aia/v1/models?provider=X
	 * Uses cache to avoid repeat calls within the same page load.
	 */
	function fetchModels( provider, callback ) {
		if ( modelCache[ provider ] ) {
			callback( null, modelCache[ provider ] );
			return;
		}
		var xhr = new XMLHttpRequest();
		xhr.open( 'GET', REST_URL + '?provider=' + encodeURIComponent( provider ), true );
		xhr.setRequestHeader( 'X-WP-Nonce', REST_NONCE );
		xhr.onload = function() {
			var data;
			try { data = JSON.parse( xhr.responseText ); } catch(e) { data = {}; }
			if ( xhr.status === 200 && data.models ) {
				modelCache[ provider ] = data.models;
				callback( null, data.models );
			} else {
				var msg = ( data.message || data.code || 'Unknown error' );
				callback( msg, [] );
			}
		};
		xhr.onerror = function() { callback( 'Network error', [] ); };
		xhr.send();
	}

	/**
	 * Populate the model <select> for the given provider.
	 * Tries to keep the previously saved/selected value.
	 */
	function syncModels( provider ) {
		var sel     = document.getElementById( 'AIA_model' );
		var saved   = sel ? ( sel.getAttribute( 'data-saved' ) || sel.value || '' ) : '';
		var loading = document.getElementById( 'aia-model-loading' );

		if ( ! sel ) return;

		// Show loading state.
		sel.disabled = true;
		sel.innerHTML = '<option>Loading models\u2026</option>';
		if ( loading ) loading.style.display = 'inline';

		fetchModels( provider, function( err, models ) {
			if ( loading ) loading.style.display = 'none';

			if ( err || ! models.length ) {
				sel.innerHTML = '<option value="">Could not load models \u2014 ' + ( err || 'no models returned' ) + '</option>';
				sel.disabled = false;
				return;
			}

			sel.innerHTML = '';
			var matched = false;
			models.forEach( function( m, idx ) {
				var opt         = document.createElement( 'option' );
				opt.value       = m.id;
				opt.textContent = m.name + ( idx === 0 ? ' (latest)' : '' );
				if ( m.id === saved ) {
					opt.selected = true;
					matched = true;
				}
				sel.appendChild( opt );
			} );

			// If saved model is not in the live list, select the newest one.
			if ( ! matched && sel.options.length ) {
				sel.options[0].selected = true;
			}

			sel.disabled = false;

			// Update data-saved so subsequent provider-switches restore correctly.
			sel.setAttribute( 'data-saved', sel.value );
		} );
	}

	/** Update API key label and link to match the active provider. */
	function syncKeyLabel( provider ) {
		var lbl  = document.getElementById( 'AIA_api_key_label' );
		var link = document.getElementById( 'AIA_api_key_link' );
		if ( lbl  ) lbl.textContent = keyLabels[ provider ] || 'API Key';
		if ( link ) link.href       = keyLinks[ provider ]  || '#';
	}

	document.addEventListener( 'DOMContentLoaded', function() {
		var providerEl = document.getElementById( 'AIA_provider' );
		if ( ! providerEl ) return;

		var currentProvider = providerEl.value;
		syncKeyLabel( currentProvider );
		syncModels( currentProvider );

		providerEl.addEventListener( 'change', function() {
			var p = this.value;
			syncKeyLabel( p );
			syncModels( p );
		} );
	} );
})();
JS;
		/* phpcs:enable */

		wp_add_inline_script( 'jquery', $inline_js );
	}


	/**
	 * Plugin option defaults.
	 *
	 * @return array<string, mixed>
	 */
	public static function defaults() {
		return array(
			'enabled'           => 1,
			'provider'          => 'gemini',
			'api_key'           => '',
			'model'             => 'gemini-2.5-flash',
			'system_prompt'     => self::default_system_prompt(),
			'widget_title'      => 'Chat with us',
			'chat_language'     => '',
			'rate_limit'        => 20,
			'sources'           => array(
				'products' => 1,
				'orders'   => 1,
				'posts'    => 1,
				'pages'    => 1,
			),
			// Each item: array( 'slug' => 'menu_item', 'label' => 'Menu Items' )
			'custom_post_types' => array(),
		);
	}

	/**
	 * The default AI system prompt – site-agnostic, works for any niche.
	 *
	 * @return string
	 */
	public static function default_system_prompt() {
		return 'You are a helpful assistant for THIS website only. Answer ONLY questions about this site\'s own content: products, services, orders, pages, posts, menus, FAQs, or any other data provided in the context below.

STRICT RULES — never break these:
1. NEVER answer questions about external topics, other websites, general knowledge, news, science, cooking tips unrelated to the store, sports, finance, or anything not in the site context.
2. If someone asks about anything outside this site, reply: "I can only help with questions about this website. Can I assist you with our products, services, or orders?"
3. NEVER invent prices, stock levels, order details, policies, discounts, or offers. Use ONLY the context data provided.
4. For order status: always ask for Order ID + checkout email first. Never reveal order details without both verified.
5. If the context does not contain the answer, say so honestly and offer to connect the visitor with support.
6. Keep responses concise, friendly, and relevant.

OFFERS & DISCOUNTS:
- The context includes a "Products currently on sale" section. When asked about offers or discounts, report every product listed there with its sale price and discount %.
- If no products are on sale, say so honestly.
- Never say you lack offer information when a product context is provided.

COUPONS & PROMO CODES:
- The context includes an "ACTIVE COUPONS & PROMO CODES" section with all valid coupon codes, their discount amounts, restrictions, and expiry dates.
- When asked about coupons, discount codes, promo codes, or vouchers, list every code from that section with its details.
- If the section is empty or missing, say: "We do not have any active coupon codes at this time, but we do have sale items [list them if any]."
- Always provide the exact coupon code in UPPERCASE so the customer can copy-paste it.

PRODUCT & MENU QUERIES:
- Look up every product/item question in the "Store products" or custom post type sections of the context.
- Report name, price (or rate), availability, and any active offer.
- If the item is not in the context, say it was not found and suggest browsing the site.

SITE TYPE AWARENESS:
- The context will tell you the site name and categories/types of content (food, clothing, services, etc.).
- Adapt your tone and answers to match: use food language for food sites, fashion language for clothing sites, etc.
- Always refer to the specific product names, prices, and details exactly as provided in the context.';
	}


	/**
	 * Sanitize and validate settings on save.
	 *
	 * @param  array $input Raw POST data.
	 * @return array        Sanitized option value.
	 */
	public function sanitize_settings( $input ) {
		$defaults   = self::defaults();
		$providers  = array( 'gemini', 'openai', 'claude' );
		$clean      = array();

		// Enabled toggle.
		$clean['enabled'] = empty( $input['enabled'] ) ? 0 : 1;

		// Provider.
		$clean['provider'] = ( isset( $input['provider'] ) && in_array( $input['provider'], $providers, true ) )
			? $input['provider']
			: $defaults['provider'];

		// Model – accept any non-empty value from the live provider list.
		$clean['model'] = ( isset( $input['model'] ) && '' !== trim( sanitize_text_field( $input['model'] ) ) )
			? sanitize_text_field( $input['model'] )
			: $defaults['model'];

		// Text / textarea fields.
		$clean['api_key']       = isset( $input['api_key'] )      ? trim( sanitize_text_field( $input['api_key'] ) )      : '';
		$clean['system_prompt'] = isset( $input['system_prompt'] ) ? sanitize_textarea_field( $input['system_prompt'] )   : $defaults['system_prompt'];
				$clean['widget_title']  = isset( $input['widget_title'] )  ? sanitize_text_field( $input['widget_title'] )        : $defaults['widget_title'];
		$clean['chat_language'] = isset( $input['chat_language'] ) ? sanitize_text_field( $input['chat_language'] )      : $defaults['chat_language'];
		$clean['rate_limit']    = isset( $input['rate_limit'] )    ? max( 1, absint( $input['rate_limit'] ) )              : 20;
		$clean['auto_delete_days'] = isset( $input['auto_delete_days'] ) ? max( 1, absint( $input['auto_delete_days'] ) ) : 7;


		// Core data sources (products, orders, posts, pages).
		$clean['sources'] = array();
		foreach ( array_keys( $defaults['sources'] ) as $source ) {
			$clean['sources'][ $source ] = empty( $input['sources'][ $source ] ) ? 0 : 1;
		}

		// Custom post types – each row has 'slug' and 'label'.
		$clean['custom_post_types'] = array();
		if ( isset( $input['custom_post_types'] ) && is_array( $input['custom_post_types'] ) ) {
			foreach ( $input['custom_post_types'] as $cpt ) {
				$slug  = sanitize_key( $cpt['slug'] ?? '' );
				$label = sanitize_text_field( $cpt['label'] ?? '' );
				if ( $slug !== '' && $label !== '' ) {
					$clean['custom_post_types'][] = array(
						'slug'  => $slug,
						'label' => $label,
					);
				}
			}
		}

		return $clean;
	}


	/** Render the Settings sub-page. */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$opts = wp_parse_args( get_option( AIA_OPTION_NAME, array() ), self::defaults() );
		$opts['sources']           = wp_parse_args( $opts['sources'] ?? array(), self::defaults()['sources'] );
		$opts['custom_post_types'] = isset( $opts['custom_post_types'] ) && is_array( $opts['custom_post_types'] )
			? $opts['custom_post_types']
			: array();

		$name   = esc_attr( AIA_OPTION_NAME );
		?>
		<div class="wrap aia-admin">
			<?php $this->render_page_header( __( 'Settings', 'ai-woo-assistance' ), 'settings' ); ?>
			<?php $this->render_admin_styles(); ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'AIA_settings_group' ); ?>

				<?php $this->render_general_card( $name, $opts ); ?>
				<?php $this->render_provider_card( $name, $opts ); ?>
				<?php $this->render_sources_card( $name, $opts ); ?>
				<?php $this->render_experience_card( $name, $opts ); ?>

				<?php
				submit_button(
					__( 'Save Settings', 'ai-woo-assistance' ),
					'primary',
					'submit',
					true,
					array( 'style' => 'font-size:14px;padding:8px 24px;' )
				);
				?>
			</form>
		</div>
		<?php
	}


	
	// -------------------------------------------------------------------------
	// Private render helpers
	// -------------------------------------------------------------------------

	/**
	 * Shared page header with navigation tabs (Dashboard / Settings / Help).
	 *
	 * @param string $title   Current page title shown under the header.
	 * @param string $current Active tab key: 'dashboard' | 'settings' | 'help'.
	 */
	private function render_page_header( $title, $current ) {
		$tabs = array(
			'dashboard' => array(
				'label' => __( 'Dashboard', 'ai-woo-assistance' ),
				'url'   => admin_url( 'admin.php?page=ai-woo-assistance' ),
				'icon'  => '🏠',
			),
			'history' => array(
				'label' => __( 'Chat History', 'ai-woo-assistance' ),
				'url'   => admin_url( 'admin.php?page=ai-woo-assistance-history' ),
				'icon'  => '📜',
			),
			'settings'  => array(
				'label' => __( 'Settings', 'ai-woo-assistance' ),
				'url'   => admin_url( 'admin.php?page=ai-woo-assistance-settings' ),
				'icon'  => '⚙️',
			),
			'help'      => array(
				'label' => __( 'Help &amp; Docs', 'ai-woo-assistance' ),
				'url'   => admin_url( 'admin.php?page=ai-woo-assistance-help' ),
				'icon'  => '📖',
			),
		);
		?>
		<div style="display:flex;align-items:center;gap:12px;margin-bottom:4px;margin-top:8px;">
			<span style="font-size:32px;line-height:1;" aria-hidden="true">🤖</span>
			<div>
				<h1 style="margin:0;font-size:22px;font-weight:700;color:#1d2327;">
					<?php esc_html_e( 'AI Assistance', 'ai-woo-assistance' ); ?>
					<span style="font-size:12px;font-weight:400;background:#f0f0f1;color:#50575e;padding:2px 9px;border-radius:20px;margin-left:8px;vertical-align:middle;">
						v<?php echo esc_html( AIA_VERSION ); ?>
					</span>
				</h1>
				<p style="margin:2px 0 0;color:#646970;font-size:13px;">
					<?php esc_html_e( 'AI-powered chat assistant for your WordPress site', 'ai-woo-assistance' ); ?>
				</p>
			</div>
		</div>

		<nav class="nav-tab-wrapper wp-clearfix" style="margin-bottom:0;">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<a href="<?php echo esc_url( $tab['url'] ); ?>"
				   class="nav-tab<?php echo ( $current === $key ) ? ' nav-tab-active' : ''; ?>"
				   style="display:inline-flex;align-items:center;gap:5px;">
					<span aria-hidden="true"><?php echo $tab['icon']; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<?php echo wp_kses_post( $tab['label'] ); ?>
				</a>
			<?php endforeach; ?>
		</nav>
		<div style="height:1px;background:#dcdcde;margin-bottom:20px;"></div>
		<?php
	}



	// -------------------------------------------------------------------------
	// Dashboard page
	// -------------------------------------------------------------------------

	/** Render the Dashboard sub-page. */
	public function render_dashboard_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$opts     = wp_parse_args( get_option( AIA_OPTION_NAME, array() ), self::defaults() );
		$enabled  = ! empty( $opts['enabled'] );
		$provider = ucfirst( $opts['provider'] ?? 'gemini' );
		$model    = $opts['model'] ?? '—';
		$has_key  = ! empty( $opts['api_key'] );
		?>
		<div class="wrap aia-admin">
			<?php $this->render_page_header( __( 'Dashboard', 'ai-woo-assistance' ), 'dashboard' ); ?>
			<?php $this->render_admin_styles(); ?>
			<style>
				.aia-stat-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:20px;}
				.aia-stat{background:#fff;border:1px solid #dcdcde;border-radius:10px;padding:20px 22px;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,.05);}
				.aia-stat .aia-stat-icon{font-size:30px;display:block;margin-bottom:8px;}
				.aia-stat .aia-stat-value{font-size:18px;font-weight:700;color:#1d2327;display:block;}
				.aia-stat .aia-stat-label{font-size:12px;color:#646970;margin-top:2px;display:block;}
				.aia-steps{counter-reset:step;list-style:none;padding:0;margin:0;}
				.aia-steps li{counter-increment:step;display:flex;gap:14px;align-items:flex-start;padding:12px 0;border-bottom:1px solid #f0f0f1;}
				.aia-steps li:last-child{border-bottom:none;}
				.aia-steps li::before{content:counter(step);min-width:26px;height:26px;background:#635bff;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;margin-top:1px;}
				.aia-steps li.done::before{content:"✓";background:#00a32a;}
				@media(max-width:700px){.aia-stat-grid{grid-template-columns:1fr;}}
			</style>

			<?php if ( ! $has_key ) : ?>
			<div style="background:#fff3cd;border:1px solid #ffc107;border-radius:8px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:12px;">
				<span style="font-size:22px;" aria-hidden="true">⚠️</span>
				<div>
					<strong><?php esc_html_e( 'Setup required', 'ai-woo-assistance' ); ?></strong> —
					<?php
					printf(
						/* translators: %s: link to settings page */
						wp_kses_post( __( 'No API key saved yet. <a href="%s">Go to Settings</a> to add your key and start the assistance.', 'ai-woo-assistance' ) ),
						esc_url( admin_url( 'admin.php?page=ai-woo-assistance-settings' ) )
					);
					?>
				</div>
			</div>
			<?php endif; ?>

			<div class="aia-stat-grid">
				<div class="aia-stat">
					<span class="aia-stat-icon"><?php echo $enabled ? '🟢' : '🔴'; ?></span>
					<span class="aia-stat-value"><?php echo $enabled ? esc_html__( 'Active', 'ai-woo-assistance' ) : esc_html__( 'Inactive', 'ai-woo-assistance' ); ?></span>
					<span class="aia-stat-label"><?php esc_html_e( 'AI Assistance Status', 'ai-woo-assistance' ); ?></span>
				</div>
				<div class="aia-stat">
					<span class="aia-stat-icon">🤖</span>
					<span class="aia-stat-value"><?php echo esc_html( $provider ); ?></span>
					<span class="aia-stat-label"><?php esc_html_e( 'AI Provider', 'ai-woo-assistance' ); ?></span>
				</div>
				<div class="aia-stat">
					<span class="aia-stat-icon">🧠</span>
					<span class="aia-stat-value" style="font-size:13px;"><?php echo esc_html( $model ); ?></span>
					<span class="aia-stat-label"><?php esc_html_e( 'Active Model', 'ai-woo-assistance' ); ?></span>
				</div>
			</div>

			<div class="aia-card">
				<h2>🚀 <?php esc_html_e( 'Quick Setup Guide', 'ai-woo-assistance' ); ?></h2>
				<ol class="aia-steps">
					<li class="<?php echo $has_key ? 'done' : ''; ?>">
						<div>
							<strong><?php esc_html_e( 'Get a free API key', 'ai-woo-assistance' ); ?></strong><br>
							<span style="font-size:13px;color:#646970;">
								<?php esc_html_e( 'Create a free key at ', 'ai-woo-assistance' ); ?>
								<a href="https://aistudio.google.com/app/apikey" target="_blank" rel="noopener noreferrer">Google AI Studio</a>
								<?php esc_html_e( ' (Gemini), ', 'ai-woo-assistance' ); ?>
								<a href="https://platform.openai.com/api-keys" target="_blank" rel="noopener noreferrer">OpenAI</a>
								<?php esc_html_e( ', or ', 'ai-woo-assistance' ); ?>
								<a href="https://console.anthropic.com/settings/keys" target="_blank" rel="noopener noreferrer">Anthropic</a>.
							</span>
						</div>
					</li>
					<li class="<?php echo $has_key ? 'done' : ''; ?>">
						<div>
							<strong><?php esc_html_e( 'Paste the key in Settings', 'ai-woo-assistance' ); ?></strong><br>
							<span style="font-size:13px;color:#646970;">
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=ai-woo-assistance-settings' ) ); ?>">
									<?php esc_html_e( 'AI Assistance → Settings', 'ai-woo-assistance' ); ?>
								</a>
								<?php esc_html_e( ' → AI Provider & Model → paste your key → Save.', 'ai-woo-assistance' ); ?>
							</span>
						</div>
					</li>
					<li class="<?php echo $enabled ? 'done' : ''; ?>">
						<div>
							<strong><?php esc_html_e( 'Enable the assistance', 'ai-woo-assistance' ); ?></strong><br>
							<span style="font-size:13px;color:#646970;">
								<?php esc_html_e( 'Tick "Enable assistance on the website" in Settings → General and save.', 'ai-woo-assistance' ); ?>
							</span>
						</div>
					</li>
					<li>
						<div>
							<strong><?php esc_html_e( 'Add your content sources', 'ai-woo-assistance' ); ?></strong><br>
							<span style="font-size:13px;color:#646970;">
								<?php esc_html_e( 'Enable products, orders, posts, pages, or custom post types (FAQs, menus, recipes…) so the AI knows your site.', 'ai-woo-assistance' ); ?>
							</span>
						</div>
					</li>
					<li>
						<div>
							<strong><?php esc_html_e( 'Preview on your site', 'ai-woo-assistance' ); ?></strong><br>
							<span style="font-size:13px;color:#646970;">
								<?php
								printf(
									/* translators: %s: site front-end URL */
									wp_kses_post( __( 'Visit <a href="%s" target="_blank" rel="noopener noreferrer">your website</a> — the chat bubble appears in the bottom-right corner.', 'ai-woo-assistance' ) ),
									esc_url( home_url( '/' ) )
								);
								?>
							</span>
						</div>
					</li>
				</ol>
			</div>

			<div class="aia-card" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
				<div>
					<strong style="font-size:14px;"><?php esc_html_e( 'Ready to configure?', 'ai-woo-assistance' ); ?></strong>
					<p class="aia-help" style="margin:4px 0 0;"><?php esc_html_e( 'Set your provider, API key, data sources, and custom post types.', 'ai-woo-assistance' ); ?></p>
				</div>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=ai-woo-assistance-settings' ) ); ?>"
				   class="button button-primary"
				   style="font-size:14px;padding:8px 22px;height:auto;">
					⚙️ <?php esc_html_e( 'Go to Settings', 'ai-woo-assistance' ); ?>
				</a>
			</div>
		</div>
		<?php
	}

	// -------------------------------------------------------------------------
	// Chat history page

	/** Render the Chat History sub-page. */
	public function render_history_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$search   = sanitize_text_field( wp_unslash( $_GET['search'] ?? '' ) );
		$page     = max( 1, absint( $_GET['paged'] ?? 1 ) );
		$per_page = 20;

		if ( isset( $_GET['delete_id'] ) ) {
			AIA_History::instance()->delete_conversation( absint( $_GET['delete_id'] ) );
			wp_redirect( remove_query_arg( 'delete_id' ) );
			exit;
		}

		if ( isset( $_GET['export'] ) ) {
			$rows = AIA_History::instance()->export_conversations( $search );
			if ( $rows ) {
				nocache_headers();
				header( 'Content-Type: text/csv; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename="aia-chat-history.csv"' );
				$out = fopen( 'php://output', 'w' );
				fputcsv( $out, array( 'ID', 'Visitor ID', 'User ID', 'Language', 'Messages', 'Created At', 'Updated At' ) );
				foreach ( $rows as $row ) {
					fputcsv( $out, array(
						$row['id'],
						$row['visitor_id'],
						$row['user_id'],
						$row['language'],
						$row['messages'],
						$row['created_at'],
						$row['updated_at'],
					) );
				}
				exit;
			}
		}

		$result = AIA_History::instance()->query_conversations( $search, $page, $per_page );
		$total   = $result['total'];
		$rows    = $result['rows'];
		$total_pages = ceil( $total / $per_page );
		$start = ( $page - 1 ) * $per_page + 1;
		$end   = min( $total, $page * $per_page );

		?>
		<div class="wrap aia-admin">
			<?php $this->render_page_header( __( 'Chat History', 'ai-woo-assistance' ), 'history' ); ?>
			<?php $this->render_admin_styles(); ?>

			<div class="aia-card">
				<h2>📜 <?php esc_html_e( 'Chat History', 'ai-woo-assistance' ); ?></h2>
				<form method="get" action="">
					<input type="hidden" name="page" value="ai-woo-assistance-history" />
					<div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
						<input type="search" name="search" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php esc_attr_e( 'Search visitor, user ID, language or content…', 'ai-woo-assistance' ); ?>" style="width:320px;max-width:100%;padding:8px 10px;border:1px solid #c3c4c7;border-radius:6px;" />
						<button type="submit" class="button button-primary"><?php esc_html_e( 'Search', 'ai-woo-assistance' ); ?></button>
						<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'ai-woo-assistance-history', 'export' => '1', 'search' => $search ) ) ); ?>" class="button"><?php esc_html_e( 'Export CSV', 'ai-woo-assistance' ); ?></a>
					</div>
				</form>
				<p class="aia-help"><?php printf( esc_html__( 'Showing %1$d-%2$d of %3$d conversations.', 'ai-woo-assistance' ), $start, $end, $total ); ?></p>
				<table class="widefat striped" style="margin-top:16px;">
					<thead>
						<tr>
							<th><?php esc_html_e( 'ID', 'ai-woo-assistance' ); ?></th>
							<th><?php esc_html_e( 'Visitor ID', 'ai-woo-assistance' ); ?></th>
							<th><?php esc_html_e( 'User ID', 'ai-woo-assistance' ); ?></th>
							<th><?php esc_html_e( 'Language', 'ai-woo-assistance' ); ?></th>
							<th><?php esc_html_e( 'Messages', 'ai-woo-assistance' ); ?></th>
							<th><?php esc_html_e( 'Updated At', 'ai-woo-assistance' ); ?></th>
							<th><?php esc_html_e( 'Action', 'ai-woo-assistance' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ( empty( $rows ) ) : ?>
							<tr><td colspan="7"><?php esc_html_e( 'No chats found.', 'ai-woo-assistance' ); ?></td></tr>
						<?php else : ?>
							<?php foreach ( $rows as $row ) : ?>
								<tr>
									<td><?php echo absint( $row['id'] ); ?></td>
									<td><?php echo esc_html( $row['visitor_id'] ); ?></td>
									<td><?php echo absint( $row['user_id'] ); ?></td>
									<td><?php echo esc_html( $row['language'] ); ?></td>
									<td><?php echo esc_html( wp_trim_words( strip_tags( $row['messages'] ), 20, '...' ) ); ?></td>
									<td><?php echo esc_html( $row['updated_at'] ); ?></td>
									<td><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'ai-woo-assistance-history', 'delete_id' => absint( $row['id'] ) ) ) ); ?>" class="button button-secondary" onclick="return confirm('<?php echo esc_js( __( 'Delete this conversation? This cannot be undone.', 'ai-woo-assistance' ) ); ?>');"><?php esc_html_e( 'Delete', 'ai-woo-assistance' ); ?></a></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
				<?php if ( $total_pages > 1 ) : ?>
					<p style="margin-top:16px;">
						<?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
							<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'ai-woo-assistance-history', 'paged' => $i, 'search' => $search ) ) ); ?>" class="button<?php echo $i === $page ? ' button-primary' : ''; ?>" style="margin-right:4px;">
								<?php echo absint( $i ); ?>
							</a>
						<?php endfor; ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	// -------------------------------------------------------------------------
	// Help page
	// -------------------------------------------------------------------------

	/** Render the Help & Docs sub-page. */
	public function render_help_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap aia-admin">
			<?php $this->render_page_header( __( 'Help &amp; Docs', 'ai-woo-assistance' ), 'help' ); ?>
			<?php $this->render_admin_styles(); ?>
			<style>
				.aia-faq dt{font-weight:700;font-size:13px;color:#1d2327;margin:0 0 4px;cursor:pointer;}
				.aia-faq dt::before{content:"▶ ";font-size:10px;color:#635bff;}
				.aia-faq dd{margin:0 0 16px 0;padding:8px 12px;background:#f6f7f7;border-left:3px solid #635bff;border-radius:0 6px 6px 0;font-size:13px;color:#3c434a;line-height:1.6;}
				.aia-provider-links{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-top:4px;}
				.aia-provider-link{background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px 18px;text-align:center;}
				.aia-provider-link .icon{font-size:26px;display:block;margin-bottom:8px;}
				.aia-provider-link a{font-size:13px;font-weight:600;text-decoration:none;color:#635bff;}
				.aia-provider-link a:hover{text-decoration:underline;}
				.aia-changelog dt{font-weight:700;font-size:13px;color:#1d2327;padding:6px 0 2px;}
				.aia-changelog dd{margin:0 0 10px 16px;font-size:13px;color:#3c434a;}
				@media(max-width:700px){.aia-provider-links{grid-template-columns:1fr;}}
			</style>

			<div class="aia-card">
				<h2>📖 <?php esc_html_e( 'How It Works', 'ai-woo-assistance' ); ?></h2>
				<p style="font-size:13px;line-height:1.7;color:#3c434a;">
					<?php esc_html_e( 'The Assistance reads your site\'s real data (products, pages, custom post types) on every message and sends it to the AI as context. The AI can only answer using that context — it never makes up prices, stock, or orders. This keeps answers accurate and specific to your site, whether you run a food delivery service, a clothing store, a services agency, or any other type of business.', 'ai-woo-assistance' ); ?>
				</p>
			</div>

			<div class="aia-card">
				<h2>❓ <?php esc_html_e( 'Frequently Asked Questions', 'ai-woo-assistance' ); ?></h2>
				<dl class="aia-faq">
					<dt><?php esc_html_e( 'Which AI providers are supported?', 'ai-woo-assistance' ); ?></dt>
					<dd><?php esc_html_e( 'Google Gemini, OpenAI (GPT-4o / GPT-4 Turbo), and Anthropic Claude. You can switch providers at any time in Settings.', 'ai-woo-assistance' ); ?></dd>

					<dt><?php esc_html_e( 'Does the Assistance work without WooCommerce?', 'ai-woo-assistance' ); ?></dt>
					<dd><?php esc_html_e( 'Yes. WooCommerce product and order features are skipped automatically if WooCommerce is not installed. The bot will still answer questions from pages, posts, and custom post types.', 'ai-woo-assistance' ); ?></dd>

					<dt><?php esc_html_e( 'How do I make the Assistance answer about my food menu / clothing items / services?', 'ai-woo-assistance' ); ?></dt>
					<dd><?php esc_html_e( 'Add your content as WooCommerce products, or register a custom post type (e.g. "menu_item", "service") and add it under Settings → Custom Post Types. The assistance will read and answer from that content automatically.', 'ai-woo-assistance' ); ?></dd>

					<dt><?php esc_html_e( 'Why did the Assistance say it cannot find a product?', 'ai-woo-assistance' ); ?></dt>
					<dd><?php esc_html_e( 'Make sure the product is published in WooCommerce and "WooCommerce Products" is checked under Settings → Core Data Sources. The search matches product names, so the visitor\'s wording must be close to the product name.', 'ai-woo-assistance' ); ?></dd>

					<dt><?php esc_html_e( 'Can I change what the Assistance is allowed to say?', 'ai-woo-assistance' ); ?></dt>
					<dd><?php esc_html_e( 'Yes — edit the AI System Instructions field in Settings → Chat Experience. The site data is appended automatically; only the behaviour rules need to go in that box.', 'ai-woo-assistance' ); ?></dd>

					<dt><?php esc_html_e( 'Is visitor data sent to the AI provider?', 'ai-woo-assistance' ); ?></dt>
					<dd><?php esc_html_e( 'Only the text of each chat message and the relevant site context (product names, prices, etc.) are sent. No personal visitor data (name, email, IP) is ever sent to the AI provider.', 'ai-woo-assistance' ); ?></dd>
				</dl>
			</div>

			<div class="aia-card">
				<h2>🔑 <?php esc_html_e( 'Get Your API Key', 'ai-woo-assistance' ); ?></h2>
				<p class="aia-help" style="margin-bottom:14px;">
					<?php esc_html_e( 'Create a free API key from any of these providers and paste it in Settings → AI Provider & Model.', 'ai-woo-assistance' ); ?>
				</p>
				<div class="aia-provider-links">
					<div class="aia-provider-link">
						<span class="icon">🔵</span>
						<strong style="display:block;margin-bottom:4px;">Google Gemini</strong>
						<span style="font-size:11px;color:#646970;display:block;margin-bottom:8px;"><?php esc_html_e( 'Free tier available', 'ai-woo-assistance' ); ?></span>
						<a href="https://aistudio.google.com/app/apikey" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Get key at AI Studio →', 'ai-woo-assistance' ); ?>
						</a>
					</div>
					<div class="aia-provider-link">
						<span class="icon">🟢</span>
						<strong style="display:block;margin-bottom:4px;">OpenAI</strong>
						<span style="font-size:11px;color:#646970;display:block;margin-bottom:8px;"><?php esc_html_e( 'GPT-4o Mini recommended', 'ai-woo-assistance' ); ?></span>
						<a href="https://platform.openai.com/api-keys" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Get key at OpenAI →', 'ai-woo-assistance' ); ?>
						</a>
					</div>
					<div class="aia-provider-link">
						<span class="icon">🔴</span>
						<strong style="display:block;margin-bottom:4px;">Anthropic Claude</strong>
						<span style="font-size:11px;color:#646970;display:block;margin-bottom:8px;"><?php esc_html_e( 'Claude 3.5 Haiku recommended', 'ai-woo-assistance' ); ?></span>
						<a href="https://console.anthropic.com/settings/keys" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Get key at Anthropic →', 'ai-woo-assistance' ); ?>
						</a>
					</div>
				</div>
			</div>

			<div class="aia-card">
				<h2>📋 <?php esc_html_e( 'Changelog', 'ai-woo-assistance' ); ?></h2>
				<dl class="aia-changelog">
					<dt>v1.2.0</dt>
					<dd>
						<?php esc_html_e( '• Top-level admin menu with Dashboard, Settings, and Help pages.', 'ai-woo-assistance' ); ?><br>
						<?php esc_html_e( '• Custom Post Types manager — add any CPT (FAQ, recipe, menu item, service…) as a assistance data source.', 'ai-woo-assistance' ); ?><br>
						<?php esc_html_e( '• Auto site-type detection from WooCommerce categories (food, clothing, electronics, etc.).', 'ai-woo-assistance' ); ?><br>
						<?php esc_html_e( '• Dedicated Active Offers section — assistance now answers "any discounts?" correctly.', 'ai-woo-assistance' ); ?><br>
						<?php esc_html_e( '• Full WordPress.org coding standards compliance.', 'ai-woo-assistance' ); ?>
					</dd>
					<dt>v1.1.0</dt>
					<dd>
						<?php esc_html_e( '• Added Google Gemini and OpenAI provider support alongside Claude.', 'ai-woo-assistance' ); ?><br>
						<?php esc_html_e( '• Improved sale price detection and product context.', 'ai-woo-assistance' ); ?><br>
						<?php esc_html_e( '• Rate limiting per visitor IP.', 'ai-woo-assistance' ); ?>
					</dd>
					<dt>v1.0.0</dt>
					<dd><?php esc_html_e( '• Initial release with Anthropic Claude support.', 'ai-woo-assistance' ); ?></dd>
				</dl>
			</div>
		</div>
		<?php
	}

	// -------------------------------------------------------------------------
	// Private render helpers
	// -------------------------------------------------------------------------

	/** Output all admin CSS (one block, no external file needed). */
	private function render_admin_styles() {
		?>
		<style>
			.aia-admin{max-width:920px;}
			.aia-card{background:#fff;border:1px solid #dcdcde;border-radius:10px;padding:24px 28px;margin:20px 0;box-shadow:0 1px 3px rgba(0,0,0,.06);}
			.aia-card h2{margin-top:0;font-size:15px;color:#1d2327;border-bottom:1px solid #f0f0f1;padding-bottom:12px;margin-bottom:18px;display:flex;align-items:center;gap:8px;}
			.aia-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px;}
			.aia-field{display:flex;flex-direction:column;gap:6px;}
			.aia-field label{font-weight:600;font-size:13px;color:#1d2327;}
			.aia-field input[type=text],.aia-field input[type=password],.aia-field input[type=number],.aia-field textarea,.aia-field select{width:100%;border-radius:6px;border:1px solid #c3c4c7;padding:8px 10px;font-size:13px;line-height:1.4;box-sizing:border-box;}
			.aia-field select{height:auto;}
			.aia-field input:focus,.aia-field select:focus,.aia-field textarea:focus{border-color:#635bff;box-shadow:0 0 0 2px rgba(99,91,255,.15);outline:none;}
			.aia-help{color:#646970;font-size:12px;margin:2px 0 0;}
			.aia-help a{color:#635bff;text-decoration:none;}
			.aia-help a:hover{text-decoration:underline;}
			.aia-badge{display:inline-block;background:#f0f0f1;color:#50575e;font-size:10px;font-weight:600;padding:2px 7px;border-radius:20px;vertical-align:middle;}
			.aia-badge.active{background:#d7f5e3;color:#00a32a;}
			.aia-source-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;}
			.aia-source-item{border:1px solid #dcdcde;border-radius:8px;padding:12px 14px;background:#fafafa;display:flex;align-items:center;gap:10px;cursor:pointer;transition:border-color .15s,background .15s;}
			.aia-source-item:has(input:checked){border-color:#635bff;background:#f5f4ff;}
			.aia-source-item label{font-size:13px;font-weight:600;cursor:pointer;margin:0;}
			.aia-source-item input[type=checkbox]{margin:0;width:15px;height:15px;accent-color:#635bff;}
			.aia-enabled-bar{background:linear-gradient(135deg,#f5f4ff,#eef0ff);border:1px solid #c7c4ff;border-radius:8px;padding:14px 18px;display:flex;align-items:center;gap:14px;}
			.aia-enabled-bar label{font-size:14px;font-weight:600;cursor:pointer;}
			.aia-enabled-bar input[type=checkbox]{width:18px;height:18px;accent-color:#635bff;cursor:pointer;}
			/* Custom post type rows */
			.aia-cpt-row{display:grid;grid-template-columns:1fr 1fr auto;gap:8px;margin-bottom:8px;align-items:center;}
			.aia-cpt-row input[type=text]{border-radius:6px;border:1px solid #c3c4c7;padding:7px 10px;font-size:13px;width:100%;box-sizing:border-box;}
			.aia-cpt-row input:focus{border-color:#635bff;box-shadow:0 0 0 2px rgba(99,91,255,.15);outline:none;}
			.aia-cpt-remove{color:#c00;border-color:#c00;cursor:pointer;}
			.aia-cpt-remove:hover{background:#c00;color:#fff;}
			.aia-cpt-head{display:grid;grid-template-columns:1fr 1fr auto;gap:8px;margin-bottom:6px;}
			.aia-cpt-head span{font-size:11px;font-weight:600;color:#646970;text-transform:uppercase;letter-spacing:.04em;}
			@media(max-width:700px){.aia-grid,.aia-source-grid,.aia-cpt-row,.aia-cpt-head{grid-template-columns:1fr;}}
		</style>
		<?php
	}

	/** General (enable/disable) card. */
	private function render_general_card( $name, $opts ) {
		?>
		<div class="aia-card">
			<h2>⚙️ <?php esc_html_e( 'General', 'ai-woo-assistance' ); ?></h2>
			<div class="aia-enabled-bar">
				<input type="checkbox"
					id="AIA_enabled"
					name="<?php echo esc_attr( $name ); ?>[enabled]"
					value="1"
					<?php checked( $opts['enabled'] ); ?> />
				<label for="AIA_enabled">
					<?php esc_html_e( 'Enable assistance on the website', 'ai-woo-assistance' ); ?>
					<span class="aia-badge <?php echo $opts['enabled'] ? 'active' : ''; ?>">
						<?php echo $opts['enabled'] ? esc_html__( 'Active', 'ai-woo-assistance' ) : esc_html__( 'Inactive', 'ai-woo-assistance' ); ?>
					</span>
				</label>
			</div>
		</div>
		<?php
	}


	/** AI provider, model, and API key card. */
	private function render_provider_card( $name, $opts ) {
		$key_labels = array(
			'gemini' => __( 'Google AI Studio API Key', 'ai-woo-assistance' ),
			'openai' => __( 'OpenAI API Key', 'ai-woo-assistance' ),
			'claude' => __( 'Anthropic API Key', 'ai-woo-assistance' ),
		);
		$key_links = array(
			'gemini' => 'https://aistudio.google.com/app/apikey',
			'openai' => 'https://platform.openai.com/api-keys',
			'claude' => 'https://console.anthropic.com/settings/keys',
		);
		?>
		<div class="aia-card">
			<h2>🔑 <?php esc_html_e( 'AI Provider &amp; Model', 'ai-woo-assistance' ); ?></h2>
			<div class="aia-grid" style="margin-bottom:20px;">
				<div class="aia-field">
					<label for="AIA_provider"><?php esc_html_e( 'AI Provider', 'ai-woo-assistance' ); ?></label>
					<select id="AIA_provider" name="<?php echo esc_attr( $name ); ?>[provider]">
						<option value="gemini" <?php selected( $opts['provider'], 'gemini' ); ?>>🔵 Google Gemini</option>
						<option value="openai" <?php selected( $opts['provider'], 'openai' ); ?>>🟢 OpenAI (ChatGPT)</option>
						<option value="claude" <?php selected( $opts['provider'], 'claude' ); ?>>🔴 Anthropic Claude</option>
					</select>
					<p class="aia-help"><?php esc_html_e( 'Choose your preferred AI provider.', 'ai-woo-assistance' ); ?></p>
				</div>
				<div class="aia-field">
					<label for="AIA_model">
						<?php esc_html_e( 'Model', 'ai-woo-assistance' ); ?>
						<span id="aia-model-loading" style="display:none;font-size:11px;color:#646970;font-weight:normal;margin-left:6px;">
							⏳ <?php esc_html_e( 'Loading models…', 'ai-woo-assistance' ); ?>
						</span>
					</label>
					<select id="AIA_model" name="<?php echo esc_attr( $name ); ?>[model]" data-saved="<?php echo esc_attr( $opts['model'] ); ?>" disabled>
						<option><?php esc_html_e( 'Loading models…', 'ai-woo-assistance' ); ?></option>
					</select>
					<p class="aia-help"><?php esc_html_e( 'Live models fetched from your selected AI provider. Newest models appear automatically.', 'ai-woo-assistance' ); ?></p>
				</div>
			</div>
			<div class="aia-field">
				<label for="AIA_api_key">
					<span id="AIA_api_key_label"><?php echo esc_html( $key_labels[ $opts['provider'] ] ?? __( 'API Key', 'ai-woo-assistance' ) ); ?></span>
					&nbsp;<a id="AIA_api_key_link"
						href="<?php echo esc_url( $key_links[ $opts['provider'] ] ?? '#' ); ?>"
						target="_blank"
						rel="noopener noreferrer"
						style="font-weight:normal;font-size:12px;"><?php esc_html_e( 'Get key →', 'ai-woo-assistance' ); ?></a>
				</label>
				<input id="AIA_api_key"
					type="password"
					autocomplete="new-password"
					name="<?php echo esc_attr( $name ); ?>[api_key]"
					value="<?php echo esc_attr( $opts['api_key'] ); ?>"
					placeholder="<?php esc_attr_e( 'Paste your API key here…', 'ai-woo-assistance' ); ?>" />
				<p class="aia-help"><?php esc_html_e( 'Your key is stored securely and used only on the server — never exposed to visitors.', 'ai-woo-assistance' ); ?></p>
			</div>
		</div>
		<?php
	}


	/** Core data sources card (products, orders, posts, pages). */
	private function render_sources_card( $name, $opts ) {
		$source_map = array(
			'products' => array(
				'icon'  => '🛍️',
				'label' => __( 'WooCommerce Products', 'ai-woo-assistance' ),
				'desc'  => __( 'Product names, prices, stock & sale offers', 'ai-woo-assistance' ),
			),
			'orders'   => array(
				'icon'  => '📋',
				'label' => __( 'Order Status', 'ai-woo-assistance' ),
				'desc'  => __( 'Verified by order ID + email', 'ai-woo-assistance' ),
			),
			'posts'    => array(
				'icon'  => '📝',
				'label' => __( 'Blog Posts', 'ai-woo-assistance' ),
				'desc'  => __( 'Published blog articles', 'ai-woo-assistance' ),
			),
			'pages'    => array(
				'icon'  => '📄',
				'label' => __( 'Pages', 'ai-woo-assistance' ),
				'desc'  => __( 'Static site pages', 'ai-woo-assistance' ),
			),
		);
		?>
		<div class="aia-card">
			<h2>📦 <?php esc_html_e( 'Core Data Sources', 'ai-woo-assistance' ); ?></h2>
			<p class="aia-help" style="margin-bottom:14px;">
				<?php esc_html_e( 'Select which built-in data the assistance can use. Only checked sources are included in the AI context.', 'ai-woo-assistance' ); ?>
			</p>
			<div class="aia-source-grid">
				<?php foreach ( $source_map as $key => $meta ) : ?>
				<div class="aia-source-item">
					<input type="checkbox"
						id="AIA_source_<?php echo esc_attr( $key ); ?>"
						name="<?php echo esc_attr( $name ); ?>[sources][<?php echo esc_attr( $key ); ?>]"
						value="1"
						<?php checked( $opts['sources'][ $key ] ?? 0 ); ?> />
					<div>
						<label for="AIA_source_<?php echo esc_attr( $key ); ?>">
							<?php echo esc_html( $meta['icon'] . ' ' . $meta['label'] ); ?>
						</label>
						<p class="aia-help" style="margin:2px 0 0;"><?php echo esc_html( $meta['desc'] ); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}


		/** Chat experience card (widget title, rate limit, system prompt). */
	private function render_experience_card( $name, $opts ) {
		?>
		<div class="aia-card">
			<h2>💬 <?php esc_html_e( 'Chat Experience', 'ai-woo-assistance' ); ?></h2>
			<div class="aia-grid" style="margin-bottom:20px;">
				<div class="aia-field">
					<label for="AIA_widget_title"><?php esc_html_e( 'Widget Title', 'ai-woo-assistance' ); ?></label>
					<input id="AIA_widget_title"
						type="text"
						name="<?php echo esc_attr( $name ); ?>[widget_title]"
						value="<?php echo esc_attr( $opts['widget_title'] ); ?>"
						placeholder="<?php esc_attr_e( 'Chat with us', 'ai-woo-assistance' ); ?>" />
				</div>
				<div class="aia-field">
					<label for="AIA_rate_limit"><?php esc_html_e( 'Messages per Visitor / Hour', 'ai-woo-assistance' ); ?></label>
					<input id="AIA_rate_limit"
						type="number"
						min="1"
						max="500"
						name="<?php echo esc_attr( $name ); ?>[rate_limit]"
						value="<?php echo esc_attr( $opts['rate_limit'] ); ?>" />
				</div>
				<div class="aia-field">
					<label for="AIA_chat_language"><?php esc_html_e( 'Default Chat Language', 'ai-woo-assistance' ); ?></label>
					<select id="AIA_chat_language" name="<?php echo esc_attr( $name ); ?>[chat_language]">
						<option value="en" <?php selected( $opts['chat_language'], 'en' ); ?>>English (en)</option>
						<option value="fr" <?php selected( $opts['chat_language'], 'fr' ); ?>>Français (fr)</option>
						<option value="it" <?php selected( $opts['chat_language'], 'it' ); ?>>Italiano (it)</option>
						<option value="ar" <?php selected( $opts['chat_language'], 'ar' ); ?>>العربية (ar)</option>
					</select>
				</div>
				<div class="aia-field">
					<label for="AIA_auto_delete"><?php esc_html_e( 'Auto-delete History (Days)', 'ai-woo-assistance' ); ?></label>
					<input id="AIA_auto_delete"
						type="number"
						min="1"
						name="<?php echo esc_attr( $name ); ?>[auto_delete_days]"
						value="<?php echo esc_attr( $opts['auto_delete_days'] ?? 7 ); ?>" />
				</div>
			</div>
			<div class="aia-field">
				<label for="AIA_prompt"><?php esc_html_e( 'AI System Instructions', 'ai-woo-assistance' ); ?></label>
				<textarea id="AIA_prompt"
					rows="12"
					name="<?php echo esc_attr( $name ); ?>[system_prompt]"><?php echo esc_textarea( $opts['system_prompt'] ); ?></textarea>
			</div>
		</div>
		<?php
	}

}
