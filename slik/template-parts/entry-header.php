<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$entry_header_classes = '';

if ( is_singular() ) {
	$entry_header_classes .= ' header-footer-group';
}

?>


