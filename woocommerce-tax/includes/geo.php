<?php
/**
 * Geolocation
 *
 * @package WordPress
 * @subpackage wc-tax
 * @since 1.2.4
 */


// Beta Geo location - sets vat showing by default if in EU

function ip_location() {

	/**
	 * Detect plugin. For use on Front End only.
	 */
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$plugin = 'geoip-detect/geoip-detect.php';

	// check for GeoIP Detection | http://wordpress.org/plugins/geoip-detect/
	if ( is_plugin_active( $plugin ) ) {

		$userInfo = geoip_detect_get_info_from_current_ip();
		// print_r( $userInfo );
		if ( $userInfo && $userInfo->continent_code == 'EU' ) {
			echo '<script> var wootax_continent = "EU"; </script>';
		}
	}

}
add_action( 'wp_head', 'ip_location' );
