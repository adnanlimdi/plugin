<?php

/**
 * General
 *
 * @package WordPress
 * @subpackage wc-tax
 * @since 1.2.4
 */

if (! is_admin() || defined('DOING_AJAX')) {

	/**
	 * Update WooCommerce Price.
	 */
	function wpa83367_price_html($price, $product)
	{

		// if product has no price set (ie. 0), return.
		if (!wc_get_price_including_tax($product)) {
			return $price;
		}

		// setup globals.
		global $wootax_text, $wootax_incl_message, $wootax_excl_message, $wc_from;
		// check product is taxable.
		$tax_status = $product->is_taxable();
		// get tax class to check for zero rated items (different to is_taxable check).
		$product_tax_class = $product->get_tax_class();
		// grab custom text options.
		$wootax_text = get_option('wc_tax_text', 'VAT');
		$wc_incl = __('Incl.', 'wc-tax');
		$wc_excl = __('Excl.', 'wc-tax');
		$wc_zero = __('No Tax', 'wc-tax');
		$wc_from = __('From', 'wc-tax');

		// set default tax word if option is not set.
		if ($wootax_text == '') {
			$wootax_text = __('VAT', 'wc-tax');
		}

		// if product is simple, is not taxable or zero rate, return with no tax label.
		if ($product->is_type('simple') && ($product_tax_class === 'zero-rate' || $product_tax_class === 'shipping' || !$tax_status)) {
			return $price . ' <span class="wootax-suffix">(' . $wc_zero . ')</span>';
		}

		// setup defaults variables.
		$regular_price = $product->get_regular_price();
		$dp = wc_get_price_decimals();
		$qty = 1;
		$currency_symbol = null;
		$price_args = array(
			'qty'   => $qty,
			'price' => $regular_price,
		);

		$value_stripped = number_format((float) wc_get_price_including_tax($product) * 1, $dp, '.', '');
		$value_stripped_ex = number_format((float) wc_get_price_excluding_tax($product) * 1, $dp, '.', '');
		$value_stripped_sale = wc_price(number_format((float) wc_get_price_including_tax($product, $price_args) * 1, $dp, '.', ''));
		$value_stripped_sale_ex = wc_price(number_format((float) wc_get_price_excluding_tax($product, $price_args) * 1, $dp, '.', ''));

		// formats to number of decimal points set in settings.
		$value_stripped = wc_price(wc_format_decimal($value_stripped, $dp));
		$value_stripped_ex = wc_price(wc_format_decimal($value_stripped_ex, $dp));

		// finalise suffix messages.
		$wootax_incl_message = '<span class="wootax-suffix">' . $wc_incl . ' ' . $wootax_text . '</span>';
		$wootax_excl_message = '<span class="wootax-suffix">' . $wc_excl . ' ' . $wootax_text . '</span>';

		// Default Toggle Tax display.
		$default = '<span class="amount product-tax-on product-tax" style="display:none;" title="With ' . $wootax_text . ' added">' . ($product->has_child() ? $wc_from . ' ' : '') . sprintf(get_woocommerce_price_format(), $currency_symbol, $value_stripped) . ' ' . $wootax_incl_message . '</span><span class="amount product-tax-off product-tax" title="With ' . $wootax_text . ' removed">' . ($product->has_child() ? $wc_from . ' ' : '') . sprintf(get_woocommerce_price_format(), $currency_symbol, $value_stripped_ex) . ' ' . $wootax_excl_message . '</span>';

		// if variable and no tax
		if ($product->is_type('variable') && ($product_tax_class === 'zero-rate' || $product_tax_class === 'shipping' || !$tax_status)) {
			return '<span class="amount product-tax-on product-tax" style="display:none;">' . ($product->has_child() ? $wc_from . ' ' : '') . sprintf(get_woocommerce_price_format(), $currency_symbol, $value_stripped) . '</span><span class="amount product-tax-off product-tax">' . ($product->has_child() ? $wc_from . ' ' : '') . sprintf(get_woocommerce_price_format(), $currency_symbol, $value_stripped_ex) . '</span>';
		} elseif ($product->get_sale_price()) {
			// if the price is on sale, then you need to use del/ins markup.
			$productid = get_the_ID();
		    $sales_price_m2  = get_post_meta( $productid, 'sales_price_m2', true );
	
			if(empty($sales_price_m2)){
			return '<del><span class="amount product-tax-on product-tax" style="display:none;" title="With ' . $wootax_text . ' added">' . ($product->has_child() ? __('From', 'wc-tax') . ' ' : '') . sprintf(get_woocommerce_price_format(), $currency_symbol, $value_stripped_sale) . ' ' . $wootax_incl_message . '</span><span class="amount product-tax-off product-tax" title="With ' . $wootax_text . ' removed">' . ($product->has_child() ? $wc_from . ' ' : '') . sprintf(get_woocommerce_price_format(), $currency_symbol, $value_stripped_sale_ex) . ' ' . $wootax_excl_message . '</span></del><ins>' . $default . '</ins>';
				}
		} else {
			return $default;
		}

		//Sales Price code
		$productid = get_the_ID();
		$sales_price_m2  = get_post_meta( $productid, 'sales_price_m2', true );
		if(empty($sales_price_m2)){
		  return $price;
	    }
	}
	add_filter('woocommerce_get_price_html', 'wpa83367_price_html', 100, 99);
}