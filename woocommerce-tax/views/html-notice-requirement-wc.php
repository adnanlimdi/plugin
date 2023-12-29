<?php
/**
 * Admin View: WooCommerce requirement
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="message" class="error">
	<p><?php echo sprintf( __( '<strong>%s</strong> requires WooCommerce. Please install WooCommerce to use Tax Toggle for WooCommerce.', 'wc-tax' ), 'Tax Toggle for WooCommerce' ); ?></p>
</div>
