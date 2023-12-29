<?php
/**
* Template Name: About Page template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
if(!is_user_logged_in()){
 //   wp_redirect( home_url());
   // exit;
}

get_header();

// Banner Sections
$banner_title              = get_field('banner_title');
$banner_descriptions       = get_field('banner_descriptions');
$first_left_image          = get_field('first_left_image');
$left_small_image          = get_field('left_small_image');
$first_title               = get_field('first_title');
$first_descriptions        = get_field('first_descriptions');
$first_right_icon          = get_field('first_right_icon');


$second_image              = get_field('second_image');
$second_title              = get_field('second_title');
$second_descriptions       = get_field('second_descriptions');
$second_icon               = get_field('second_icon');


$Third_Title               = get_field('Third_Title');
$third_descriptions        = get_field('third_descriptions');
$third_left_image          = get_field('third_left_image');
$third_icon                = get_field('third_icon');

$faq_title                 = get_field('faq_title');
$faq_descriptions          = get_field('faq_descriptions');

?>


  <!-- Main Content -->
  <main>

    <!-- About section -->
    <section class="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 mx-auto about-head">
            <div class="title-img-outer">
              <h1 class="text-center"><?php echo $banner_title; ?></h1>
            </div>
            <p class="title-info">
              <?php echo $banner_descriptions;  ?>
            </p>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row about-img-section">
          <div class="fluid-img-block">

               <?php if( !empty( $first_left_image ) ): ?>
                <img class="full-img" src="<?php echo esc_url($first_left_image['url']); ?>" alt="<?php echo esc_attr($first_left_image['alt']); ?>" />
                <?php endif; ?>
                       <?php if( !empty( $left_small_image ) ): ?>
                <img class="fluid-small" src="<?php echo esc_url($left_small_image['url']); ?>" alt="<?php echo esc_attr($left_small_image['alt']); ?>" />
                <?php endif; ?>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-12 ml-auto fluid-content-outer">
                <div class="fluid-content">
                  <span class="about-title-text">   <?php if( !empty( $first_right_icon ) ): ?>
                <img class="full-img-icon" src="<?php echo esc_url($first_right_icon['url']); ?>" alt="<?php echo esc_attr($first_right_icon['alt']); ?>" /><?php endif; ?></span>
                  <h3><?php echo $first_title; ?></h3>
                  <p>
                   <?php echo $first_descriptions;  ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End About section -->

    <section class="about-row">
      <div class="container-fluid">
        <div class="row about-img-section ">
          <div class="fluid-img-block right-img">

                <?php if( !empty( $second_image ) ): ?>
                <img class="full-img" src="<?php echo esc_url($second_image['url']); ?>" alt="<?php echo esc_attr($second_image['alt']); ?>" />
                <?php endif; ?>
           
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-12 mr-auto fluid-content-outer">
                <div class="fluid-content">
                  <span class="about-title-text"> <?php if( !empty( $second_icon ) ): ?>
                <img class="full-img-icon" src="<?php echo esc_url($second_icon['url']); ?>" alt="<?php echo esc_attr($second_icon['alt']); ?>" /><?php endif; ?></span>
                  <h3><?php echo $second_title; ?></h3>
                  <p><?php echo $second_descriptions; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row about-img-section ">
          <div class="fluid-img-block">
                <?php if( !empty( $third_left_image ) ): ?>
                <img class="full-img" src="<?php echo esc_url($third_left_image['url']); ?>" alt="<?php echo esc_attr($third_left_image['alt']); ?>" />
                <?php endif; ?>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-12 ml-auto fluid-content-outer">
                <div class="fluid-content">
                  <span class="about-title-text"> <?php if( !empty( $third_icon ) ): ?>
                <img class="full-img-icon" src="<?php echo esc_url($third_icon['url']); ?>" alt="<?php echo esc_attr($third_icon['alt']); ?>" /><?php endif; ?></span>
                  <h3><?php echo $Third_Title; ?></h3>
                  <p>
                    <?php echo $third_descriptions; ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Faq section -->
    <section class="faq">
      <div class="container">
        <div class="faq-inner">
        <h2 class="text-center"><?php echo $faq_title; ?></h2>
        <p><?php echo $faq_descriptions; ?></p>
                    <div class="faq-content">

<?php

            // Check rows exists.
            if( have_rows('faq') ):
            $Cp = 1;
            // Loop through rows.
            while( have_rows('faq') ) : the_row();
            // Load sub field value.
            $maintitle        = get_sub_field('main_title');
            $faq_list         = get_sub_field('faq_list');
            // Do something...
            ?>
                 <div class="accordion" id="accordion<?php echo $Cp; ?>">
                    <h5><?php echo $maintitle; ?></h5>
                        <?php
            // Check rows exists.
            if( have_rows('faq_list') ):
            $C = 2*1*2*$Cp;
            // Loop through rows.
            while( have_rows('faq_list') ) : the_row();
            // Load sub field value.
            $questions        = get_sub_field('questions');
            $answer           = get_sub_field('answer');
            // Do something...
            ?>
            <div class="card">
              <div class="card-header" id="heading<?php echo $C; ?>">
                <h6 class="mb-0">
                 
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#c<?php echo $C; ?>" aria-expanded="false" aria-controls="c<?php echo $C; ?>">
                    <?php echo $questions; ?>
                    <span>
                      <img src="<?php echo get_template_directory_uri() ?>/assets/images/plus.svg" alt="open" class="plus">
                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/minus.svg" alt="close" class="minus">
                    </span>
                  </button>
                </h6>
              </div>
          
              <div id="c<?php echo $C; ?>" class="collapse" aria-labelledby="heading<?php echo $C; ?>" data-parent="#accordion<?php echo $Cp; ?>">
                <div class="card-body">
                  <?php echo $answer; ?>
                </div>
              </div>
            </div>      
            <?php
            $C++;
            // End loop.
            endwhile;

            // No value.
            else :
            // Do something...
            endif;
            ?>
                  </div>
              

        
            <?php
            $Cp++;
            // End loop.
            endwhile;

            // No value.
            else :
            // Do something...
            endif;
            ?>
          </div>     
      
      </div>
      </div>
    </section>
    <!-- End Faq section -->

     <?php get_template_part( 'template-parts/contentabout', 'middle' ); ?>

  </main>
  <!-- End Content -->

  <?php get_footer(); ?>