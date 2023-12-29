<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://go6.media
 * @since             1.0.0
 * @package           Tax_calculator
 *
 * @wordpress-plugin
 * Plugin Name:       Tax calculator
 * Plugin URI:        https://go6.media
 * Description:       Used to calculate the PPT savings using council tax finder API
 * Version:           1.0.9
 * Author:            go6 media
 * Author URI:        https://go6.media
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tax_calculator
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
define( 'TAX_CALCULATOR_VERSION', '1.0.0' );
define( 'IPLIMIT',50 );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tax_calculator-activator.php
 */
function activate_tax_calculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tax_calculator-activator.php';
	Tax_calculator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tax_calculator-deactivator.php
 */
function deactivate_tax_calculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tax_calculator-deactivator.php';
	Tax_calculator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tax_calculator' );
register_deactivation_hook( __FILE__, 'deactivate_tax_calculator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tax_calculator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tax_calculator() {

	$plugin = new Tax_calculator();
	$plugin->run();

}
run_tax_calculator();

function wpf_dev_process_complete() {
    // Optional, you can limit to specific forms. Below, we restrict output to
    // form #5.
    if(isset($_REQUEST['emailverify'])){
		$entry_id = $_REQUEST['emailverify'];	
	}
    // Get the full entry object
    $entry = wpforms()->entry->get( $entry_id );
 

    // Fields are in JSON, so we decode to an array
    $entry_fields = json_decode( $entry->fields, true );

    // Check to see if user selected 'yes' for callback
    if($entry_fields[7]['value'] == 'NO') {
        // Set the hidden field to 'Needs Callback' to filter through entries
        $entry_fields[7]['value'] = 'YES';
    }
 
    // Convert back to json
    $entry_fields = json_encode( $entry_fields );

  //   echo "<pre>";
 	// print_r($entry_fields);
 	// echo "</pre>";
 
    // Save changes
    wpforms()->entry->update( $entry_id, array( 'fields' => $entry_fields ) );
}
//add_action( 'wp_head', 'wpf_dev_process_complete', 10 );

function wpf_dev_process_complete_cach( $fields, $entry, $form_data, $entry_id ) {
   
    if ( absint( $form_data['id'] ) === 11 ) {
        do_action( 'litespeed_purge_all' );
    }
}
add_action( 'wpforms_process_complete', 'wpf_dev_process_complete_cach', 10, 4 );