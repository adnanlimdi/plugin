<?php
/**
 * The template for displaying the 404 template in the Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main">
    <section class="hero">
      <div class="container">
	<div class="section-inner thin error404-content">
		<h1> 404 </h1>
		<h1 class="entry-title"><?php _e( 'Page Not Found', 'slik' ); ?></h1>

		<div class="intro-text"><p><?php _e( 'The page you were looking for could not be found. It might have been removed, renamed, or did not exist in the first place.', 'slik' ); ?></p></div>

	</div><!-- .section-inner -->
</div>
</section>
</main><!-- #site-content -->

<?php
get_footer();
