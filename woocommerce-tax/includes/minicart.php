<?php
/**
 * Minicart
 *
 * @package WordPress
 * @subpackage wc-tax
 * @since 1.2.4
 */

if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {

	/**
	 * Mini Cart
	 */
	function min_cart_override( $product_price, $cart_item, $cart_item_key ) {

		$_product        = $cart_item['data'];
		$currency_symbol = '$';
		// formats to number of decimal points set in settings.
		$dp              = wc_get_price_decimals();
		// get's decimal seperator.
		$dep_seperator   = wc_get_price_decimal_separator();

		$product           = $cart_item['data'];
		$tax_value         = wc_price( wc_get_price_including_tax( $_product ) * 1 ); // Not sure what is that for.
		$product_quantity  = $cart_item['quantity'];
		$value_stripped    = wc_get_price_including_tax( $_product ) * 1;
		$value_stripped_ex = wc_get_price_excluding_tax( $_product ) * 1;
		$value_stripped    = wc_format_decimal( $value_stripped, $dp );
		$value_stripped_ex = wc_format_decimal( $value_stripped_ex, $dp );

		$wootax_text = get_option( 'wc_tax_text', 'VAT' );
		$wc_incl     = __( 'Incl.', 'wc-tax' );
		$wc_excl     = __( 'Excl.', 'wc-tax' );

		// set default tax word if option is not set.
		if ($wootax_text == '') {
			$wootax_text = __('VAT', 'wc-tax');
		}

		// check product is taxable.
		$tax_status = $_product->is_taxable();
		// get tax class to check for zero rated items (different to is_taxable check).
		$product_tax_class = $_product->get_tax_class();

		$wootax_incl_message = '<span class="wootax-suffix">' . $wc_incl . ' ' . $wootax_text . '</span>';
		$wootax_excl_message = '<span class="wootax-suffix">' . $wc_excl . ' ' . $wootax_text . '</span>';

		if ( $product_tax_class === 'zero-rate' || $product_tax_class === 'shipping' || !$tax_status) {
			return '<span style="display:none;" class="amount product-tax-on product-tax">' . $product_quantity . 'x ' . wc_price( $value_stripped ) . '</span><span class="amount product-tax-off product-tax"><span class="quantity">' . $product_quantity . '</span>x ' . wc_price( $value_stripped_ex ) . '</span>';
		} else {
			return '<span style="display:none;" class="amount product-tax-on product-tax">' . $product_quantity . 'x ' . wc_price( $value_stripped ) . ' ' . $wootax_incl_message . '</span><span class="amount product-tax-off product-tax"><span class="quantity">' . $product_quantity . '</span>x ' . wc_price( $value_stripped_ex ) . ' ' . $wootax_excl_message . '</span>';
		}
	}
	add_filter( 'woocommerce_widget_cart_item_quantity', 'min_cart_override', 100, 3 );

	/**
	 * Cart Prices
	 */
	function cart_price_html( $product_price, $cart_item, $cart_item_key ) {

		global $wootax_text, $wc_incl, $wc_excl;

		if ( is_cart() ) {
			return $product_price;
		} else {
			return $product_price;
			$product         = $cart_item['data'];
			$tax_value       = wc_price( wc_get_price_including_tax( $product ) * 1 ); // Not sure what is that for.
			$currency_symbol = '$';

			// formats to number of decimal points set in settings.
			$dp                = wc_get_price_decimals();
			$value_stripped    = wc_format_decimal( $value_stripped, $dp );
			$value_stripped_ex = wc_format_decimal( $value_stripped_ex, $dp );

			return '<span style="display:none;" class="amount product-tax-on product-tax">' . wc_price( $value_stripped ) . $wc_incl . $wootax_text . '</span><span class="amount product-tax-off product-tax">' . wc_price( $value_stripped_ex ) . '</span>';
		}

	}
	add_filter( 'woocommerce_cart_item_price', 'cart_price_html', 100, 3 );

	/**
	 * Variation Prices
	 */
	function wpa83367_variation_price_html( $price, $variation ) {

		global $wootax_text, $wootax_incl_message, $wootax_excl_message, $wc_incl, $wc_excl;

		// formats to number of decimal points set in settings.
		$dp                = wc_get_price_decimals();
		$value_stripped    = wc_get_price_including_tax( $variation ) * 1;
		$value_stripped_ex = wc_get_price_excluding_tax( $variation ) * 1;

		return '<span style="display:none;" class="amount product-tax-on product-tax">' . wc_price( $value_stripped ) . ' ' . $wc_incl . $wootax_text . '</span><span class="amount product-tax-off product-tax">' . wc_price( $value_stripped_ex ) . ' ' . $wootax_excl_message . '</span>';
	}
	add_filter( 'woocommerce_variation_price_html', 'wpa83367_variation_price_html', 100, 2 );

	/**
	 * Variation Sale Price
	 */
	function wpa83367_variation_sale_price_html( $price, $variation ) {

		global $wootax_text, $wc_incl, $wc_excl;
		$value_stripped    = wc_get_price_including_tax( $variation ) * 1;
		$value_stripped_ex = wc_get_price_excluding_tax( $variation ) * 1;

		return '<span style="display:none;" class="amount product-tax-on product-tax">' . wc_price( $value_stripped ) . ' ' . $wc_incl . $wootax_text . '</span><span class="amount product-tax-off product-tax">' . wc_price( $value_stripped_ex ) . '</span>';
	}
	add_filter( 'woocommerce_variation_sale_price_html', 'wpa83367_variation_sale_price_html', 100, 2 );

	/**
	 * Cart Subtotal
	 */
	function wpa83367_cart_subtotal_html( $cart_subtotal, $compound, $cart ) {
		$wc_incl     = null;
		$wootax_text = null;
		if ( is_cart() || is_checkout() || defined( 'WOOCOMMERCE_CHECKOUT' ) ) {

			return $cart_subtotal;

		} else {
			if ( $compound ) {

				$value_stripped    = $cart->cart_contents_total + $cart->shipping_total + $cart->get_taxes_total( false ) * 1;
				$value_stripped_ex = $cart->cart_contents_total + $cart->shipping_total - $cart->get_taxes_total( false ) * 1;

			} else {
				$value_stripped    = $cart->subtotal * 1;
				$value_stripped_ex = $cart->subtotal_ex_tax * 1;
			}

			$dp                = wc_get_price_decimals();
			$value_stripped    = wc_format_decimal( $value_stripped, $dp );
			$value_stripped_ex = wc_format_decimal( $value_stripped_ex, $dp );

			return '<span style="display:none;" class="amount product-tax-on product-tax" title="With tax added">' . wc_price( $value_stripped ) . ' ' . $wc_incl . $wootax_text . '</span><span class="amount product-tax-off product-tax" title="With tax removed">' . wc_price( $value_stripped_ex ) . '</span>';
		}
	}
	add_filter( 'woocommerce_cart_subtotal', 'wpa83367_cart_subtotal_html', 100, 3 );
}
