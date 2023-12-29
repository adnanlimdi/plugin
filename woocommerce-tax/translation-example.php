<?php
/**
 * Change text strings
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 * @package WordPress
 * @subpackage wc-tax
 * @since 1.2.4
 */

 /**
  * Change text strings for WooCommerce Tax Toggle
  *
  * Translate the text used in Tax Toggle plugin.
  * Copy the code below to your theme functions.php file.
  *
  * @param string $translated_text Translated text.
  * @param string $text Text to translate.
  * @param string $domain Text domain. Unique identifier for retrieving translated strings.
  */
function wctax_text_strings( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case 'Excl.':
			$translated_text = __( 'Exkl', 'wc-tax' );
			break;
		case 'From':
			$translated_text = __( 'Von', 'wc-tax' );
			break;
		case 'Incl.':
			$translated_text = __( 'Inkl', 'wc-tax' );
			break;
		case 'No Tax':
			$translated_text = __( '(Zero Tax)', 'wc-tax' );
			break;
	}
	return $translated_text;
}
add_filter( 'gettext', 'wctax_text_strings', 20, 3 );
