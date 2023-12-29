<?php
/**
 *
 *  WooCommerce Tax Toggle
 *
 * @package           wc-tax
 * @author            James Hunt
 * @copyright         2021 James Hunt
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: WooCommerce Tax Toggle
 * Plugin URI: https://www.thetwopercent.co.uk/plugins/tax-toggle-for-woocommerce/
 * Description: Adds a Tax Toggle to WooCommerce Sites to show prices with and without tax.
 * Version: 1.3.4
 * Author: James Hunt
 * Author URI: https://www.thetwopercent.co.uk
 * License: GPLv2 or later
 * Text Domain: wc-tax
 * Requires PHP: 5.6
 * Requires at least: 5.0
 * Tested up to: 5.8.1
 * WC requires at least: 2.6.0
 * WC tested up to: 5.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Bail if WooCommerce is not active.
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	/**
	 * See if WooCommerce is active.
	 */
	function is_woocommerce_activated() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

 /**
  * Plugin Initializer.
  */
function myplugin_init() {
	$plugin_dir = basename( dirname( __FILE__ ) );
	load_plugin_textdomain( 'wc-tax', false, $plugin_dir );
}
add_action( 'plugins_loaded', 'myplugin_init' );

/**
 * Get version number from this plugin version.
 */
function wootax_get_version() {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file   = basename( ( __FILE__ ) );
	return $plugin_folder[ $plugin_file ]['Version'];
}

define( 'WOOTAX_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );
define( 'WOOTAX_DIR', plugin_dir_url( __FILE__ ) . '/' . WOOTAX_NAME );
define( 'WOOTAX_URL', plugins_url() . '/' . WOOTAX_NAME );
define( 'WOOTAX_VERSION_NUM', wootax_get_version() );
add_option( 'WOOTAX_VERSION_KEY', 'WOOTAX_VERSION_NUM' );

if ( is_woocommerce_activated() ) {
	require_once 'includes/scripts.php';
	require_once 'includes/toggle.php';
	require_once 'includes/general.php';
	require_once 'includes/minicart.php';
	require_once 'includes/widget.php';
	require_once 'includes/geo.php';
}


if ( ! function_exists( 'wc_tax_enabled' ) ) {
	/**
	 * Are store-wide taxes enabled?
	 *
	 * @return bool
	 */
	function wc_tax_enabled() {
		return apply_filters( 'wc_tax_enabled', get_option( 'woocommerce_calc_taxes' ) === 'yes' );
	}
}

if ( ! is_woocommerce_activated() ) {
	/**
	 * Require WooCommerce.
	 */
	function requirement_wc_notice() {
		include( 'views/html-notice-requirement-wc.php' );
	}
	add_action( 'admin_notices', 'requirement_wc_notice', 10 );
}


if ( ! wc_tax_enabled() ) {
	/**
	 * Require Tax to be enabled in WooCommerce.
	 */
	function requirement_tax_notice() {
		include( 'views/html-notice-requirement-tax.php' );
	}
	add_action( 'admin_notices', 'requirement_tax_notice', 10 );
}