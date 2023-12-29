<?php
/**
 * Enqueue Scripts
 *
 * @package WordPress
 * @subpackage wc-tax
 * @since 1.2.4
 */

 /**
  * Equeue Styles.
  */
function wootax_stylesheet() {
	wp_enqueue_style( 'wcvat-css', WOOTAX_URL . '/assets/css/wcvat.css', array(), WOOTAX_VERSION_NUM, 'all' );
}
add_action( 'wp_enqueue_scripts', 'wootax_stylesheet', 99 );

/**
 * Enqueue Scripts.
 */
function wootax_scripts() {

	wp_enqueue_script( 'wcvat-js', WOOTAX_URL . '/assets/js/wcvat.js', array( 'jquery' ), WOOTAX_VERSION_NUM, true );

	$wc_tax_display_default      = get_option( 'wc_tax_display_default', '0' );

	$wc_tax_display_default_code = "var wc_tax_display_default = '" . $wc_tax_display_default . "';";

	$wc_tax_theme_override      = get_option( 'wc_tax_theme_override', '0' );

	$wc_tax_theme_override_code = "var wc_tax_theme_override = '" . $wc_tax_theme_override . "';";

	$wootax_inline = $wc_tax_display_default_code . ' ' . $wc_tax_theme_override_code;

	wp_register_script( 'wcvat-inline', false, array( 'jquery', 'wcvat-js' ), WOOTAX_VERSION_NUM, false );
	wp_enqueue_script( 'wcvat-inline' );
	wp_add_inline_script( 'wcvat-inline', $wootax_inline );
}
add_action( 'wp_enqueue_scripts', 'wootax_scripts', 99 );

/**
 * Editor Styles.
 */
function wootax_editor_style() {
	wp_enqueue_style( 'wcvat-editor', WOOTAX_URL . '/assets/css/wcvat-editor.css', array(), WOOTAX_URL . '/assets/css/wcvat-editor.css', 'all' );
};
add_action( 'enqueue_block_editor_assets', 'wootax_editor_style' );
