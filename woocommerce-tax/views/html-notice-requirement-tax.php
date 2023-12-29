<?php
/**
 * Admin View: Tax requirement
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="message" class="error">
	<p><?php echo sprintf( __( '<strong>%s</strong> requires WooCommerce tax settings to be enabled.', 'wc-tax' ), 'Tax Toggle for WooCommerce' ); ?></p>
</div>
