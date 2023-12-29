/**
 * WooCommerce Tax Toggle
 *
 * @package WordPress
 * @subpackage wc-tax
 * @since 1.2.4
 */

 jQuery( window ).on(
	"load",
	function($){
		// Code here will be executed on document ready. Use $ as normal.

		jQuery(
			function ($) {
				var showTaxVar;

				// if no cookie is set.
				if (Cookies.get( 'woocommerce_show_tax' ) === undefined || Cookies.get( 'woocommerce_show_tax' ) === null ) {

					// checks for default state from options.
					if ( wc_tax_display_default === 'yes' ) {
						showTaxVar = 'true';
					} else {
						showTaxVar = 'false';
					}

					// sets a cookie now.
					Cookies.set( 'woocommerce_show_tax', showTaxVar, { expires: 7, path: '/' } );

				} else {
					// cookie is already set.
					showTaxVar = Cookies.get( 'woocommerce_show_tax' );
				}

				// Convert string into Boolean.
				showTaxVar === 'true' ? showTaxVar = true : showTaxVar = false;

				// Highlight Button if Show is true.
				showTaxVar === true ? $( "#wcvat-toggle.wcvat-toggle-product" ).toggleClass( "on" ) : $( "#wcvat-toggle.wcvat-toggle-product" ).toggleClass( "" );

				showTax();

				// Product Specific.
				$( "#wcvat-toggle.wcvat-toggle-product" ).on(
					'click',
					function(){
						showTaxVar = ! showTaxVar;
						// set cookie.
						Cookies.set( 'woocommerce_show_tax', showTaxVar, { expires: 7, path: '/' } );

						(showTaxVar === true) ? $( '#wcvat-toggle.wcvat-toggle-product' ).toggleClass( "on" ) : $( '#wcvat-toggle.wcvat-toggle-product' ).toggleClass( "on" ); // TODO: Remove this on?
						showTax();
						wooTaxThemeFragmentUpdate();
					}
				);

				function showTax() {

					if (showTaxVar === true) {
						// products.
						$( ".product-tax-on" ).show();
						$( ".product-tax-off" ).hide();
						// cart totals.
						$( '.cart_totals  .tax-rate' ).show();
						$( '.cart_totals  .tax-total' ).show();
						$( '.cart_totals  .order-total' ).show();
						// Cart Contents in Header.
						$( '.cart-contents .product-tax-on' ).show();
						$( '.cart-contents .product-tax-off' ).hide();

					} else {
						// products.
						$( ".product-tax-on" ).hide();
						$( ".product-tax-off" ).show();
						// cart totals.
						$( '.cart_totals  .tax-rate' ).hide();
						$( '.cart_totals  .tax-total' ).hide();
						$( '.cart_totals  .order-total' ).hide();
						// Cart Contents in Header.
						$( '.cart-contents .product-tax-on' ).hide();
						$( '.cart-contents .product-tax-off' ).show();

					}
					wooTaxThemeOverride();
				}

				// Fired on any cart interaction.
				$( 'body' ).on(
					'wc_fragments_loaded wc_fragments_refreshed',
					function() {
						setTimeout(
							function(){
								$( 'ul.currency_switcher li a.active' ).trigger( 'click' );
							},
							0
						);
						wooTaxUpdateCart();
						wooTaxThemeOverride();
					}
				);

				function wooTaxUpdateCart() {
					// Just for Cart Contents in Header.
					if ( showTaxVar === true ) {
						$( '.cart-contents .product-tax-on' ).show();
						$( '.cart-contents .product-tax-off' ).hide();
					} else {
						$( '.cart-contents .product-tax-on' ).hide();
						$( '.cart-contents .product-tax-off' ).show();
					}
				}

				// Wait for Ajax.
				$( document ).ajaxComplete(
					function() {
						if (showTaxVar === true) {
							showTax();
							$( '.cart_totals  .tax-rate' ).show();
							$( '.cart_totals  .tax-total' ).show();
							$( '.cart_totals  .order-total' ).show();
						}
					}
				);

				// Hook to the show_variation trigger and append the tax to the price right after the price is appended and displayed.
				$( '.variations_form' ).on(
					'show_variation',
					function( matching_variations ) {
						setTimeout(
							function() {
								setTaxOnVariationPrice();
							} ,
							0
						);
					}
				);

				/*
				* Append the Tax excl/incl only for the variations price.
				* The Variations price is removed and added for every selection, so this check needs to be done.
				*/
				function setTaxOnVariationPrice() {
					display = $( ".single_variation span.price .product-tax-on" ).css( "display" );
					if ( showTaxVar === true ) {
						if ( display === "none" ) {
							$( ".single_variation span.price .product-tax-off" ).css( "display","none" );
							$( ".single_variation span.price .product-tax-on" ).css( "display","inline" );
						}
					}
				}

				// Currency Switcher.
				$( '.currency_switcher a' ).on(
					'click',
					function() {
						setTimeout(
							function(){
							},
							0
						);
					}
				);

				/**
				 * Theme Override: Experimental
				 */
				function wooTaxThemeOverride(){
					if ( wc_tax_theme_override === 'yes' ) {
						// .cart-total = ShoppingCart Theme.
						// .amount-cart = Other themes.
						const shoppingCart = $( '.cart-total, .amount-cart' );

						if ( shoppingCart == undefined || shoppingCart.length === 0 ) {
							console.log( 'Tax Toggle Theme Override does not recognise this theme code, please turn off the Setting. You can contact the developer with your theme name for help.' );
							return;
						}

						let shoppingCartValue;
						// get the real values as array.
						shoppingCartValue = shoppingCart.html().split( " " ).filter( String );

						if ( showTaxVar === true ) {
							shoppingCart.html( shoppingCartValue[0] );
						} else {
							shoppingCart.html( shoppingCartValue[1] );
						}
					}

				}

				/**
				 * Trigger fragment refresh.
				 */
				function wooTaxThemeFragmentUpdate(){
						$( document.body ).trigger( 'wc_fragment_refresh' );
				}

				// END.
			}
		);

	}
);