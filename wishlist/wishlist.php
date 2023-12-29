<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.iflair.com/
 * @since             1.0.0
 * @package           Wishlist
 *
 * @wordpress-plugin
 * Plugin Name:       Wish list
 * Plugin URI:        wishlist
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            iFlair Pvt Ltd
 * Author URI:        https://www.iflair.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wishlist
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WISHLIST_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wishlist-activator.php
 */
function activate_wishlist() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wishlist-activator.php';
	Wishlist_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wishlist-deactivator.php
 */
function deactivate_wishlist() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wishlist-deactivator.php';
	Wishlist_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wishlist' );
register_deactivation_hook( __FILE__, 'deactivate_wishlist' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wishlist.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wishlist() {

	$plugin = new Wishlist();
	$plugin->run();

}
run_wishlist();
