<?php
/**
* Template Name: Contact Page Template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

get_header();

$contact_form_shortcode              = get_field('contact_form_shortcode');
$contact_right_content               = get_field('contact_right_content');

?>

  <!-- Main Content -->
  <main>

    <!-- contact section -->
    <section class="contact">
      <div class="container">
        <h1 class="text-center"><?php echo get_the_title(); ?></h1>

        <div class="contact-main">
          <div class="row">
            <div class="col-md-6 contact-left">
              <?php the_content(); ?>
            </div>
            <div class="col-md-6 contact-right">
              <?php the_field('contact_right_content'); ?>
              <?php echo do_shortcode( $contact_form_shortcode ); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End contact section -->


    </section>
    <!-- End plan section -->
  <?php get_template_part( 'template-parts/content', 'middle' ); ?>
  </main>
  <!-- End Content -->

  
<?php get_footer(); ?>