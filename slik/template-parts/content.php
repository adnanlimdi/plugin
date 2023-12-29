<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<section class="privacy-policy inner-page">
      <div class="cms-banner">
        <div class="container">
          <h1><?php echo get_the_title(); ?></h1>
        </div>
      </div>
      <div class="cms-content">
        <div class="container">
          <?php the_content(); ?>
        </div>
      </div>
    </section>
