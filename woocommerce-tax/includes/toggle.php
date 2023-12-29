<?php
/**
 * Toggle
 *
 * @package WordPress
 * @subpackage wc-tax
 * @since 1.2.4
 */

 /**
  * Add Settings
  *
  * @param array $settings Settings.
  */
function add_wootax_settings( $settings ) {

	$updated_settings = array();

	foreach ( $settings as $section ) {

		if ( isset( $section['id'] ) && 'tax_options' == $section['id'] &&

		isset( $section['type'] ) && 'sectionend' == $section['type'] ) {

			$updated_settings[] = array(
				'name'     => __( 'Floating Tax Toggle', 'wc-tax' ),
				'desc_tip' => __( 'Remove the floating toggle for the Tax Toggle for WooCommerce plugin. This is useful if you are using the Widget or Shortcode instead. ', 'wc-tax' ),
				'id'       => 'woocommerce_tax_toggle_hide',
				'type'     => 'checkbox',
				'css'      => '',
				'std'      => '1',  // WC < 2.0.
				'default'  => '1',  // WC >= 2.0.
				'desc'     => __( 'Remove the floating tax toggle', 'wc-tax' ),
			);
			$updated_settings[] = array(
				'name'     => __( 'Tax Button Text', 'wc-tax' ),
				'desc_tip' => __( 'This changes the button text - which is Include by default', 'wc-tax' ),
				'id'       => 'wc_tax_button_text',
				'type'     => 'text',
				'css'      => 'width:125px;',
				'std'      => 'Include',  // WC < 2.0.
				'default'  => 'Include',  // WC >= 2.0.
				'desc'     => __( 'This changes the button action text - we recommend Include or Show', 'wc-tax' ),
			);
			$updated_settings[] = array(
				'name'     => __( 'Tax Text', 'wc-tax' ),
				'desc_tip' => __( 'This changes the word Tax when it is Incl. and Excl. on front end', 'wc-tax' ),
				'id'       => 'wc_tax_text',
				'type'     => 'text',
				'css'      => 'width:125px;',
				'std'      => 'VAT',  // WC < 2.0.
				'default'  => 'VAT',  // WC >= 2.0.
				'desc'     => __( 'Your name for tax - i.e. VAT. It should probably match your tax rate name as this is used by WooCommerce on Checkout.', 'wc-tax' ),
			);
			$updated_settings[] = array(
				'name'     => __( 'Default Toggle Status', 'wc-tax' ),
				'desc_tip' => __( 'If activated, the toggle with be activated when the page loads - for example so you can default to showing prices inclusive of tax.', 'wc-tax' ),
				'id'       => 'wc_tax_display_default',
				'type'     => 'checkbox',
				'css'      => '',
				'std'      => '0',  // WC < 2.0.
				'default'  => '0',  // WC >= 2.0.
				'desc'     => __( 'Activate Tax Toggle on load', 'wc-tax' ),
			);
			$updated_settings[] = array(
				'name'     => __( 'Restrict Tax Toggle to shop pages', 'wc-tax' ),
				'desc_tip' => __( 'If activated, the floating tax toggle will only appear on the frontpage, categories, products and the cart.', 'wc-tax' ),
				'id'       => 'wc_tax_display_woo_pages_only',
				'type'     => 'checkbox',
				'css'      => '',
				'std'      => '0',  // WC < 2.0.
				'default'  => '0',  // WC >= 2.0.
				'desc'     => __( 'Restrict the floating toggle only to Shop pages', 'wc-tax' ),
			);
			$updated_settings[] = array(
				'name'     => __( 'Theme Override', 'wc-tax' ),
				'desc_tip' => __( 'This may help to fix your theme if the tax toggle does not seem to work', 'wc-tax' ),
				'id'       => 'wc_tax_theme_override',
				'type'     => 'checkbox',
				'css'      => '',
				'std'      => '0',  // WC < 2.0.
				'default'  => '0',  // WC >= 2.0.
				'desc'     => __( 'Fix double cart sub-total issue with some themes', 'wc-tax' ),
			);

		}
		$updated_settings[] = $section;
	}
	return $updated_settings;

}
add_filter( 'woocommerce_tax_settings', 'add_wootax_settings' );

/**
 * Get Button text from Options.
 */
function wootax_get_button_text() {
	$wootax_button_text = get_option( 'wc_tax_button_text', 'Include' );
	$wootax_tax_text    = get_option( 'wc_tax_text', 'Tax' );

	return $wootax_button_text . ' ' . $wootax_tax_text;
}

/**
 * Tax Toggle
 */
function wootax_toggle() {
	$wootax_hide = get_option( 'woocommerce_tax_toggle_hide', 'no' );
	$wootax_woo_only = get_option( 'wc_tax_display_woo_pages_only', 'no' );

	// Option: Don't show floating tax toggle.
	if ( 'yes' == $wootax_hide ) {
		return;
	}

	// Option: Only show on woocommerce pages
	if ( 'yes' == $wootax_woo_only && ! woo_tax_is_woo_page() ) {
		return;
	}

	// Don't show floating tax toggle on checkout anyway.
	if ( is_checkout() ) {
		return;
	}

	echo '<a id="wcvat-toggle" class="wcvat-toggle-product" href="javascript:void(0)"><span>' . esc_html( wootax_get_button_text() ) . '</span></a>';

}
add_action( 'wp_head', 'wootax_toggle', 100 );

/**
 * Detect non-woocommerce pages
 */
function woo_tax_is_woo_page() {

	if ( function_exists('is_woocommerce') && is_woocommerce() ) return true;
	if ( is_cart() ) return true;
	if ( is_front_page() ) return true;
	return false;
}

/**
 * Output Function
 */
function woo_tax_output() {
	echo '<a id="wcvat-toggle" class="wcvat-toggle-widget wcvat-toggle-product" href="javascript:void(0)"><span>' . esc_html( wootax_get_button_text() ) . '</span></a>';
}

/**
 * Shortcode.
 */
function woo_tax_shortcode() {
	woo_tax_output();
}
add_shortcode( 'wootax', 'woo_tax_shortcode' );
