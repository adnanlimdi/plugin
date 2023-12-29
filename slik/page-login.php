<?php
/**
* Template Name: Login Page template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
//session_start();
if ( is_user_logged_in() ) { 
      $url = home_url();
       wp_redirect( $url );
      //exit;
}
get_header();

?>
  <!-- Main Content -->
  <main>

  <!-- Join section -->
  <section class="join-page">
<!-- placeholder for Elements -->

    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">< Back to Home</a></li>
        </ol>
      </nav>
        <div class="container">
          <div class="join">
                 <div class="join-head">
                      <img src="<?php echo get_template_directory_uri() ?>/assets/images/join-logo.svg" class="join-logo" alt="Logo">
                       <div class="join-content ">
                       <div class="form-common  step-form-init ">
                              <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
  </section>
  <!-- end Join section -->
      <!-- End plan section -->
  <?php //get_template_part( 'template-parts/content', 'middle' ); ?>
  </main>
  <!-- End Content -->

  
<?php get_footer(); ?>
