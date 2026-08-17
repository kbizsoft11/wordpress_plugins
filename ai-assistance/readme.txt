=== AI WooCommerce assistance ===
Contributors: Kbizsoft
Tags: woocommerce, assistance, ai, claude, support
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

An AI-powered assistance for WooCommerce stores, using the Gemini API to answer product questions and check order status.

== Description ==

AI WooCommerce assistance adds a floating chat widget to your storefront. It's grounded in your real WooCommerce data:

* Searches your product catalog based on what the visitor asks and includes matching name/price/stock/link in the AI's context.
* For logged-in customers, includes their recent order status/totals so the bot can answer "where's my order?" accurately.
* Configurable system prompt so you control tone and boundaries (e.g. never invent discounts).
* Basic per-visitor rate limiting to protect your API budget.

Requires an Google Gemini API key from Google AI Studio.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`, or install the zip via Plugins → Add New → Upload Plugin.
2. Activate the plugin.
3. Go to Settings → AI assistance and enter your Gemini API key.
4. Adjust the system prompt and widget title as needed.

== Frequently Asked Questions ==

= Does this work without WooCommerce? =
No — WooCommerce must be installed and active. The plugin will show an admin notice and stay inactive otherwise.

= Where is my API key stored? =
In the WordPress options table (`AIA_settings`). For higher-security environments, consider modifying the settings class to read from a `wp-config.php` constant instead.

= Can it see order data for any customer? =
No — it only looks up orders for the currently logged-in visitor, never by guessing an order number from chat input.

== Changelog ==

= 1.0.0 =
* Initial release.
