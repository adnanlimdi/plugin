<?php
/**
* Template Name: Waitlist template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/



get_header();
?>
  <!-- Main Content -->
  <main>

  <!-- Join section -->
  <section class="join-page">
    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">&#x3c; Back to Home</a></li>
        </ol>
      </nav>
      <div class="container">
        <div class="join">
          <div class="join-head">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/join-logo.svg" class="join-logo mb-0" alt="Logo">
          </div>
          <div class="join-content mw350 payment confirm">
              <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end Join section -->

   <?php //get_template_part( 'template-parts/content', 'middle' ); ?>


<?php
?>

  </main>
  <!-- End Content -->

  <?php get_footer(); ?>