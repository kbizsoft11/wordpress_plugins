<?php
/**
 * Builds the site-context block injected into the AI system prompt.
 *
 * Supports:
 *  - WooCommerce products (with sale/offer detection)
 *  - WooCommerce order lookup (Order ID + email verified)
 *  - WordPress posts and pages
 *  - Unlimited custom post types configured in plugin settings
 *  - Auto site-type detection (food, clothing, services, etc.)
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
 * Assembles the context string appended to the AI system prompt each request.
 */
class AIA_Woo_Context {

	/**
	 * Build the full context block for the current visitor message.
	 *
	 * @param  string $user_message  Concatenated visitor messages for this session.
	 * @param  array  $sources       Enabled source flags from plugin settings.
	 * @param  array  $custom_types  Custom post type rows: array of ['slug'=>..,'label'=>..].
	 * @return string                Context text to append to the system prompt.
	 */
	public function build( $user_message, $sources = array(), $custom_types = array() ) {
		$defaults = array(
			'products' => 1,
			'orders'   => 1,
			'posts'    => 1,
			'pages'    => 1,
		);
		$sources = wp_parse_args( $sources, $defaults );

		$context  = 'Site name: ' . get_bloginfo( 'name' ) . "\n";
		$context .= 'Site URL: ' . get_bloginfo( 'url' ) . "\n";

		// Only pull WooCommerce data when WooCommerce is active.
		$woo_active = class_exists( 'WooCommerce' ) && function_exists( 'wc_get_products' );

		if ( ! empty( $sources['products'] ) && $woo_active ) {
			$context .= $this->site_type_context();
			$context .= $this->sale_context();
			$context .= $this->coupon_context();
			$context .= $this->product_context( $user_message );
			$context .= $this->shipping_context();
		}

		if ( ! empty( $sources['orders'] ) && $woo_active ) {
			$context .= $this->order_context( $user_message );
		}

		if ( ! empty( $sources['posts'] ) ) {
			$context .= $this->post_type_context( $user_message, 'post', __( 'Blog Posts', 'ai-woo-assistance' ) );
		}

		if ( ! empty( $sources['pages'] ) ) {
			$context .= $this->post_type_context( $user_message, 'page', __( 'Pages', 'ai-woo-assistance' ) );
		}

		// Registered custom post types from plugin settings.
		if ( ! empty( $custom_types ) && is_array( $custom_types ) ) {
			foreach ( $custom_types as $cpt ) {
				$slug  = isset( $cpt['slug'] )  ? sanitize_key( $cpt['slug'] )         : '';
				$label = isset( $cpt['label'] ) ? sanitize_text_field( $cpt['label'] ) : '';
				if ( $slug && $label ) {
					$context .= $this->post_type_context( $user_message, $slug, $label );
				}
			}
		}

		return $context;
	}


	// =========================================================================
	// Private context builders
	// =========================================================================

	/**
	 * Detect what kind of site this is based on WooCommerce product categories,
	 * then tell the AI so it can adapt its language and tone automatically.
	 *
	 * @return string
	 */
	private function site_type_context() {
		// Fetch all top-level product categories.
		$terms = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'parent'     => 0,
			'number'     => 20,
			'fields'     => 'names',
		) );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return '';
		}

		$all_cats   = array_map( 'strtolower', (array) $terms );
		$cats_csv   = implode( ', ', (array) $terms );
		$site_type  = $this->detect_site_type( $all_cats );

		$out  = "\nSite product categories: " . $cats_csv . "\n";
		$out .= 'Site type: ' . $site_type . "\n";
		$out .= "Tone guidance: Use language and terminology appropriate for a {$site_type} business when answering.\n\n";

		return $out;
	}

	/**
	 * Map category keywords to a human-readable site type.
	 *
	 * @param  string[] $categories Lowercase category names.
	 * @return string               Detected site type label.
	 */
	private function detect_site_type( array $categories ) {
		$type_map = array(
			'food & restaurant'  => array( 'food', 'meal', 'dish', 'pizza', 'burger', 'chicken', 'rice', 'curry', 'biryani', 'breakfast', 'lunch', 'dinner', 'snack', 'drink', 'beverage', 'juice', 'coffee', 'dessert', 'cake', 'bakery', 'restaurant', 'cafe', 'menu', 'recipe' ),
			'fashion & clothing' => array( 'clothing', 'clothes', 'fashion', 'shirt', 'polo', 'trouser', 'pant', 'dress', 'jeans', 'jacket', 'coat', 'hoodie', 'top', 'skirt', 'suit', 'wear', 'apparel', 'footwear', 'shoes', 'accessories', 'bag', 'handbag' ),
			'electronics'        => array( 'electronics', 'mobile', 'phone', 'laptop', 'computer', 'tablet', 'tv', 'camera', 'headphone', 'speaker', 'gadget', 'device', 'appliance' ),
			'beauty & health'    => array( 'beauty', 'skincare', 'makeup', 'cosmetic', 'hair', 'health', 'wellness', 'vitamin', 'supplement', 'pharmacy', 'medicine', 'personal care' ),
			'home & furniture'   => array( 'furniture', 'home', 'decor', 'kitchen', 'bedroom', 'living', 'sofa', 'chair', 'table', 'lamp', 'curtain', 'carpet', 'bedding' ),
			'sports & fitness'   => array( 'sports', 'fitness', 'gym', 'exercise', 'yoga', 'cycling', 'running', 'outdoor', 'equipment' ),
			'books & stationery' => array( 'books', 'stationery', 'office', 'study', 'educational', 'notebook', 'pen' ),
			'grocery'            => array( 'grocery', 'vegetables', 'fruits', 'dairy', 'organic', 'fresh', 'supermarket' ),
			'services'           => array( 'service', 'consulting', 'training', 'course', 'digital', 'agency', 'cleaning', 'repair', 'installation' ),
		);

		foreach ( $type_map as $type => $keywords ) {
			foreach ( $categories as $cat ) {
				foreach ( $keywords as $kw ) {
					if ( false !== strpos( $cat, $kw ) ) {
						return $type;
					}
				}
			}
		}

		return 'general e-commerce';
	}


	/**
	 * Build a dedicated "currently on sale" section so the AI can directly
	 * answer "any offers / discounts?" without needing to scan all products.
	 *
	 * @return string
	 */
	private function sale_context() {
		$sale_products = wc_get_products( array(
			'status'  => 'publish',
			'limit'   => 20,
			'on_sale' => true,
		) );

		$out = "ACTIVE OFFERS & DISCOUNTS (products currently on sale):\n";

		if ( ! empty( $sale_products ) ) {
			foreach ( $sale_products as $product ) {
				$regular = $product->get_regular_price();
				$sale    = $product->get_sale_price();
				$pct     = ( $regular > 0 && $sale !== '' )
					? round( ( ( $regular - $sale ) / $regular ) * 100 )
					: 0;

				$out .= sprintf(
					"- %s | Regular: %s | Sale: %s (%d%% off) | %s\n",
					$product->get_name(),
					wp_strip_all_tags( wc_price( $regular ) ),
					wp_strip_all_tags( wc_price( $sale ) ),
					$pct,
					esc_url( get_permalink( $product->get_id() ) )
				);
			}
		} else {
			$out .= "No products are currently on sale.\n";
		}

		return $out . "\n";
	}

	/**
	 * Build active WooCommerce coupons context.
	 * Shows coupon codes, descriptions, discount amounts, and any restrictions.
	 *
	 * @return string
	 */
	private function coupon_context() {
		$args = array(
			'posts_per_page' => 20,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'post_type'      => 'shop_coupon',
			'post_status'    => 'publish',
		);

		$coupons = get_posts( $args );

		if ( empty( $coupons ) ) {
			return '';
		}

		$out        = "ACTIVE COUPONS & PROMO CODES:\n";
		$has_active = false;

		foreach ( $coupons as $coupon_post ) {
			$coupon = new WC_Coupon( $coupon_post->ID );

			// Skip expired or usage-limit-reached coupons.
			$expiry = $coupon->get_date_expires();
			if ( $expiry && $expiry->getTimestamp() < time() ) {
				continue;
			}
			$usage_limit = $coupon->get_usage_limit();
			if ( $usage_limit > 0 && $coupon->get_usage_count() >= $usage_limit ) {
				continue;
			}

			$code        = $coupon->get_code();
			$description = $coupon_post->post_excerpt ?: $coupon_post->post_content;
			$description = $description ? wp_trim_words( wp_strip_all_tags( $description ), 15, '...' ) : '';

			// Discount details.
			$discount_type = $coupon->get_discount_type();
			$amount        = $coupon->get_amount();

			if ( 'percent' === $discount_type ) {
				$discount_str = $amount . '% off';
			} elseif ( 'fixed_cart' === $discount_type ) {
				$discount_str = wp_strip_all_tags( wc_price( $amount ) ) . ' off cart total';
			} elseif ( 'fixed_product' === $discount_type ) {
				$discount_str = wp_strip_all_tags( wc_price( $amount ) ) . ' off each product';
			} else {
				$discount_str = $discount_type;
			}

			// Restrictions.
			$restrictions = array();
			$min_amount   = $coupon->get_minimum_amount();
			if ( $min_amount > 0 ) {
				$restrictions[] = 'Min order: ' . wp_strip_all_tags( wc_price( $min_amount ) );
			}
			$max_amount = $coupon->get_maximum_amount();
			if ( $max_amount > 0 ) {
				$restrictions[] = 'Max order: ' . wp_strip_all_tags( wc_price( $max_amount ) );
			}
			if ( $coupon->get_free_shipping() ) {
				$restrictions[] = 'Grants free shipping';
			}
			$product_ids = $coupon->get_product_ids();
			if ( ! empty( $product_ids ) ) {
				$restrictions[] = 'Valid for specific products only';
			}
			$excluded_product_ids = $coupon->get_excluded_product_ids();
			if ( ! empty( $excluded_product_ids ) ) {
				$restrictions[] = 'Excludes some products';
			}

			// Expiry.
			$expiry_str = '';
			if ( $expiry ) {
				$expiry_str = ' | Expires: ' . $expiry->date( 'Y-m-d' );
			}

			$restrictions_str = ! empty( $restrictions ) ? ' | ' . implode( ', ', $restrictions ) : '';

			$out       .= sprintf(
				"- Code: %s | %s%s%s%s\n",
				strtoupper( $code ),
				$discount_str,
				$description ? ' | ' . $description : '',
				$restrictions_str,
				$expiry_str
			);
			$has_active = true;
		}

		if ( ! $has_active ) {
			return '';
		}

		return $out . "\n";
	}

	/**
	 * Build the main product listing (searched or recent).
	 * Includes variants, attributes, shipping class, dimensions, and stock per variation.
	 *
	 * @param  string $query Visitor message used as search term.
	 * @return string
	 */
	private function product_context( $query ) {
		$args = array(
			'status' => 'publish',
			'limit'  => 12,
		);

		if ( ! empty( $query ) ) {
			$args['s'] = sanitize_text_field( $query );
		} else {
			$args['orderby'] = 'date';
			$args['order']   = 'DESC';
		}

		$products = wc_get_products( $args );

		// No search hits — fall back to recent products so the AI still has
		// store context and can say "we don't carry that" confidently.
		if ( empty( $products ) && ! empty( $query ) ) {
			$products = wc_get_products( array(
				'status'  => 'publish',
				'limit'   => 12,
				'orderby' => 'date',
				'order'   => 'DESC',
			) );
		}

		if ( empty( $products ) ) {
			return '';
		}

		// Include currency symbol for the AI.
		$out  = 'CURRENCY: ' . get_woocommerce_currency_symbol() . "\n\n";
		$out .= "STORE PRODUCTS (use this data to answer all product questions):\n";

		foreach ( $products as $product ) {
			$regular = $product->get_regular_price();
			$sale    = $product->get_sale_price();
			$current = $product->get_price();
			$on_sale = $product->is_on_sale();

			if ( $on_sale && $sale !== '' && $regular !== '' ) {
				$price_str = sprintf(
					'Regular: %s | Sale: %s (ON SALE %.0f%% off)',
					wp_strip_all_tags( wc_price( $regular ) ),
					wp_strip_all_tags( wc_price( $sale ) ),
					( ( $regular - $sale ) / $regular ) * 100
				);
			} elseif ( $product->is_type( 'variable' ) ) {
				$min       = $product->get_variation_price( 'min' );
				$max       = $product->get_variation_price( 'max' );
				$price_str = ( (float) $min === (float) $max )
					? 'Price: ' . wp_strip_all_tags( wc_price( $min ) )
					: 'Price range: ' . wp_strip_all_tags( wc_price( $min ) ) . ' – ' . wp_strip_all_tags( wc_price( $max ) );
			} else {
				$price_str = 'Price: ' . wp_strip_all_tags( wc_price( $current ) );
			}

			// Categories.
			$cats    = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
			$cat_str = ( ! is_wp_error( $cats ) && ! empty( $cats ) ) ? implode( ', ', $cats ) : '';

			// Short description.
			$short_desc = wp_trim_words(
				wp_strip_all_tags(
					$product->get_short_description()
						? $product->get_short_description()
						: $product->get_description()
				),
				25,
				'...'
			);

			// Shipping class.
			$shipping_class = $product->get_shipping_class();

			// Weight / dimensions.
			$phys_parts = array();
			if ( $product->has_weight() ) {
				$phys_parts[] = 'Weight: ' . wc_format_weight( $product->get_weight() );
			}
			if ( $product->has_dimensions() ) {
				$phys_parts[] = 'Dimensions: ' . wc_format_dimensions( $product->get_dimensions( false ) );
			}

			$out .= sprintf(
				"- %s | %s | Stock: %s%s%s%s%s | URL: %s\n",
				$product->get_name(),
				$price_str,
				$product->is_in_stock() ? 'In stock' : 'Out of stock',
				$cat_str              ? ' | Category: ' . $cat_str                 : '',
				$shipping_class       ? ' | Shipping class: ' . $shipping_class    : '',
				! empty( $phys_parts ) ? ' | ' . implode( ', ', $phys_parts )      : '',
				$short_desc           ? ' | Info: ' . $short_desc                  : '',
				esc_url( get_permalink( $product->get_id() ) )
			);

			// Visible product attributes (Size, Colour, Material, etc.).
			foreach ( $product->get_attributes() as $attr ) {
				if ( ! $attr->get_visible() ) {
					continue;
				}
				$attr_name = wc_attribute_label( $attr->get_name(), $product );
				if ( $attr->is_taxonomy() ) {
					$terms     = wc_get_product_terms( $product->get_id(), $attr->get_name(), array( 'fields' => 'names' ) );
					$attr_vals = is_wp_error( $terms ) ? array() : $terms;
				} else {
					$attr_vals = $attr->get_options();
				}
				if ( ! empty( $attr_vals ) ) {
					$out .= '  → ' . $attr_name . ': ' . implode( ', ', $attr_vals ) . "\n";
				}
			}

			// Variable product: each variation with its own price and stock.
			if ( $product->is_type( 'variable' ) ) {
				foreach ( $product->get_available_variations() as $var_data ) {
					$variation = wc_get_product( $var_data['variation_id'] );
					if ( ! $variation ) {
						continue;
					}
					$v_attrs = array();
					foreach ( $var_data['attributes'] as $key => $val ) {
						if ( $val ) {
							$v_attrs[] = ucfirst( str_replace( 'attribute_pa_', '', str_replace( 'attribute_', '', $key ) ) ) . ': ' . $val;
						}
					}
					$v_reg  = $variation->get_regular_price();
					$v_sale = $variation->get_sale_price();
					if ( $variation->is_on_sale() && $v_sale !== '' ) {
						$v_price = wp_strip_all_tags( wc_price( $v_sale ) ) . ' (was ' . wp_strip_all_tags( wc_price( $v_reg ) ) . ')';
					} else {
						$v_price = wp_strip_all_tags( wc_price( $v_reg ) );
					}
					$out .= sprintf(
						"  [Variant] %s | %s | %s\n",
						implode( ', ', $v_attrs ) ?: 'Default',
						$v_price,
						$variation->is_in_stock() ? 'In stock' : 'Out of stock'
					);
				}
			}
		}

		return $out . "\n";
	}


	/**
	 * Build WooCommerce shipping zones and methods context.
	 * Lets the AI answer questions like "how much is shipping?" or "do you ship to London?".
	 *
	 * @return string
	 */
	private function shipping_context() {
		if ( ! class_exists( 'WC_Shipping_Zones' ) ) {
			return '';
		}

		$zones = WC_Shipping_Zones::get_zones();
		// Also include the "Rest of the world" zone (ID 0).
		$rest_of_world = new WC_Shipping_Zone( 0 );
		$zones[]       = array(
			'zone_id'           => 0,
			'zone_name'         => 'Rest of the World',
			'shipping_methods'  => $rest_of_world->get_shipping_methods( true ),
			'zone_locations'    => array(),
		);

		if ( empty( $zones ) ) {
			return '';
		}

		$out = "SHIPPING ZONES & METHODS:\n";

		foreach ( $zones as $zone_data ) {
			$zone_name = $zone_data['zone_name'] ?? 'Zone';
			$locations = array();

			if ( ! empty( $zone_data['zone_locations'] ) ) {
				foreach ( $zone_data['zone_locations'] as $loc ) {
					$locations[] = $loc->code;
				}
			}

			$methods = $zone_data['shipping_methods'] ?? array();
			if ( empty( $methods ) ) {
				continue;
			}

			$method_strs = array();
			foreach ( $methods as $method ) {
				if ( ! $method->is_enabled() ) {
					continue;
				}
				$title = $method->get_title();
				$cost  = '';
				// Flat rate — get the cost.
				if ( 'flat_rate' === $method->id ) {
					$raw_cost = $method->get_option( 'cost' );
					if ( $raw_cost !== '' ) {
						$cost = ' (' . wp_strip_all_tags( wc_price( $raw_cost ) ) . ')';
					}
				} elseif ( 'free_shipping' === $method->id ) {
					$min_amount = $method->get_option( 'min_amount' );
					$cost       = $min_amount
						? ' (free over ' . wp_strip_all_tags( wc_price( $min_amount ) ) . ')'
						: ' (free)';
				} elseif ( 'local_pickup' === $method->id ) {
					$cost = ' (local pickup)';
				}
				$method_strs[] = $title . $cost;
			}

			if ( ! empty( $method_strs ) ) {
				$loc_str = ! empty( $locations ) ? ' [' . implode( ', ', $locations ) . ']' : '';
				$out    .= '- ' . $zone_name . $loc_str . ': ' . implode( ' | ', $method_strs ) . "\n";
			}
		}

		return $out . "\n";
	}

	/**
	 * Fetch content for any registered post type and include it in context.
	 * Used for: posts, pages, and all custom post types (faq, menu_item, recipe, etc.)
	 *
	 * @param  string $query     Visitor search query.
	 * @param  string $post_type WordPress post type slug.
	 * @param  string $label     Human-readable section heading.
	 * @return string
	 */
	private function post_type_context( $query, $post_type, $label ) {
		// Try the slug as-is, then with an 's' appended (e.g. "faq" → "faqs").
		if ( ! post_type_exists( $post_type ) ) {
			if ( post_type_exists( $post_type . 's' ) ) {
				$post_type .= 's';
			} else {
				return '';
			}
		}

		$args = array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => 6,
			'no_found_rows'  => true,
		);

		if ( ! empty( $query ) ) {
			$args['s'] = sanitize_text_field( $query );
		}

		$posts = get_posts( $args );

		if ( empty( $posts ) ) {
			return '';
		}

		$out = strtoupper( $label ) . ":\n";

		foreach ( $posts as $post ) {
			$excerpt = wp_trim_words(
				wp_strip_all_tags(
					$post->post_excerpt ? $post->post_excerpt : $post->post_content
				),
				50,
				'...'
			);
			$out .= sprintf(
				"- %s | %s | URL: %s\n",
				$post->post_title,
				$excerpt,
				esc_url( get_permalink( $post ) )
			);
		}

		return $out . "\n";
	}

	/**
	 * Order lookup — requires BOTH order ID and billing email in the message.
	 * Protects customer privacy: no details are revealed unless both match.
	 *
	 * @param  string $query Combined visitor messages from the session.
	 * @return string
	 */
	private function order_context( $query ) {
		$order_id = $this->extract_order_id( $query );
		$email    = $this->extract_email( $query );

		if ( $order_id && $email ) {
			$order = wc_get_order( $order_id );

			if ( $order && strtolower( $order->get_billing_email() ) === strtolower( $email ) ) {
				$items = array();
				foreach ( $order->get_items() as $item ) {
					$items[] = $item->get_name() . ' x' . $item->get_quantity();
				}

				return sprintf(
					"VERIFIED ORDER — use ONLY these details when answering:\n- Order #%s | Status: %s | Total: %s | Date: %s | Items: %s\n\n",
					$order->get_order_number(),
					wc_get_order_status_name( $order->get_status() ),
					wp_strip_all_tags( $order->get_formatted_order_total() ),
					$order->get_date_created() ? $order->get_date_created()->date( 'Y-m-d' ) : 'n/a',
					! empty( $items ) ? implode( ', ', $items ) : 'n/a'
				);
			}

			// IDs provided but no match.
			return "ORDER LOOKUP RESULT: The Order ID and email provided do not match any order. Tell the visitor you could not find a matching order and ask them to double-check both, or offer to connect them with support. Do not invent order details.\n\n";
		}

		// Missing one or both — instruct the model to ask first.
		return "ORDER INSTRUCTIONS: The visitor has not yet provided both an Order ID and checkout email. If they ask about an order or delivery status, ask for their Order ID and the email used at checkout before proceeding. Never guess or invent order details.\n\n";
	}

	// =========================================================================
	// Extraction helpers
	// =========================================================================

	/**
	 * Extract a numeric order ID from free text.
	 * Handles: #31, order 31, order id: 31, and a bare number like "31" on its own line.
	 *
	 * @param  string $text Visitor message text.
	 * @return int          Order ID, or 0 if not found.
	 */
	private function extract_order_id( $text ) {
		// Pattern 1: #31 or # 31
		if ( preg_match( '/#\s*(\d{1,10})/', $text, $m ) ) {
			return absint( $m[1] );
		}
		// Pattern 2: "order id 31", "order number: 31", "order no. 31"
		if ( preg_match( '/\border\s*(?:id|number|no\.?)?\s*[:#]?\s*(\d{1,10})\b/i', $text, $m ) ) {
			return absint( $m[1] );
		}
		// Pattern 3: bare standalone number on its own line (visitor just typed "31")
		// Only match if the entire line is just a number (possibly with whitespace).
		foreach ( explode( "\n", $text ) as $line ) {
			$line = trim( $line );
			if ( preg_match( '/^\d{1,10}$/', $line ) ) {
				return absint( $line );
			}
		}
		return 0;
	}

	/**
	 * Extract the first email address found in free text.
	 *
	 * @param  string $text Visitor message text.
	 * @return string       Email address, or empty string if not found.
	 */
	private function extract_email( $text ) {
		if ( preg_match( '/[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}/', $text, $m ) ) {
			return sanitize_email( $m[0] );
		}
		return '';
	}
}
