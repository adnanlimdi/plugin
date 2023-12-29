<?php
/**
 * Admin View: Tax rate requirement
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="message" class="error">
	<p><?php echo sprintf( __( '<strong>%s</strong> requires at least one WooCommerce tax rate to be set.', 'wc-tax' ), 'Tax Toggle for WooCommerce' ); ?></p>
</div>
