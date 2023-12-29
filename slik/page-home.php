<?php
/**
* Template Name: Full Width Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

get_header();


// Banner Sections
$banner_title              = get_field('banner_title');
$banner_descriptions       = get_field('banner_description');
$link                      = get_field('link');


$banner_image              = get_field('banner_image');
$banner_image_second       = get_field('banner_image_second');
$third_banner_image        = get_field('third_banner_image');


//Clean home sections
$clean_title               = get_field('clean_title');
$descriptions              = get_field('descriptions');
$clean_sections            = get_field('clean_sections');


// How to work sections
$htw_title                 = get_field('htw_title');
$htw_left_image            = get_field('htw_left_image');
$left_small_image          = get_field('left_small_image');
$clean_sections            = get_field('work_list');
?>




  <!-- Main Content -->
  <main>
    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-4 hero-left wow slideInLeft">
            <div class="hero-title title-img-outer">
              <?php if($banner_title) {?>
              <h1 ><?php echo $banner_title; ?></h1>
              <?php } ?>
            </div>
            <p class="title-info">
             <?php echo $banner_descriptions  ?>
            </p>
            <?php
             if($link){
                  $title        =  $link['title'];
                  $url          =  $link['url'];
                  // Do something...
                  ?>
                   <a  class="blue-btn slik-btn" href="<?php echo $url; ?>" title="<?php echo $title;  ?>"><?php echo $title;  ?></a>
                  <?php
                } 
             ?>   
           
          </div>
          <div class="col-md-6 col-lg-8 hero-right">
            <div class="banner-img-block">      
                <?php if( !empty( $banner_image ) ): ?>
                <img class="hero-img1 wow fadeInRight"  data-wow-duration="2s" src="<?php echo esc_url($banner_image['url']); ?>" alt="<?php echo esc_attr($banner_image['alt']); ?>" />
                <?php endif; ?>              
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Hero Section -->

    <section class="service-section">
      <div class="container">
        <div class="row service">
          <div class="col-xl-9 mx-auto text-center">
            <h2  class="wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.5s" ><?php echo $clean_title; ?></h2>
            <p class="text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.5s">
              <?php echo $descriptions; ?>
            </p>

            <div class="row service-main">
            <?php

            // Check rows exists.
            if( have_rows('clean_sections') ):
            $count = 0;
            // Loop through rows.
            while( have_rows('clean_sections') ) : the_row();

            // Load sub field value.
            $title        = get_sub_field('title');
            $descriptions = get_sub_field('descriptions');
            $clean_icon = get_sub_field('clean_icon');
            // Do something...
            if($count == 0){
              $class = "wow bounceInLeft"; 
            }
            if($count == 1){
              $class = "wow bounceInUp"; 
            }
            if($count == 2){
              $class = "wow bounceInRight"; 
            }
            ?>
              <div class="col-lg-4 col-md-6 service-block <?php echo $class;  ?>" data-wow-duration="2s" data-wow-delay="0.5s">
                <div class="service-block-inner">
                  <div class="icon-img">
                    <span><img src="<?php echo $clean_icon['url']; ?>"></span>
                  </div>
                  <h4><?php echo $title; ?></h4>
                  <p>
                    <?php echo $descriptions; ?>
                  </p>
                </div>
              </div>

            <?php
            $count++;
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
      </div>
    </section>

    <!-- How it work section -->
    <section class="how-work">
      <div class="container-fluid">
        <div class="title-img-outer wow fadeInUp" data-wow-delay="0.5s" >
          <h2 class="text-center"><?php echo $htw_title ?></h2>     
        
        </div>

        <div class="row how-work-inner">

          <div class="fluid-img-block">
            <?php if( !empty( $htw_left_image ) ): ?>
            <img src="<?php echo esc_url($htw_left_image['url']); ?>" alt="title image" class="full-img wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.5s">
            <?php endif; ?>
            <?php if( !empty( $left_small_image ) ): ?>
            <img src="<?php echo esc_url($left_small_image['url']); ?>" class="fluid-small wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s" alt="How ir Work">
             <?php endif; ?>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-12 ml-auto fluid-content-outer">
                <div class="fluid-content">
                  <ul>
                            <?php

                    // Check rows exists.
                    if( have_rows('work_list') ):
                      $count = 1;
                    // Loop through rows.
                    while( have_rows('work_list') ) : the_row();

                    // Load sub field value.
                    $title        = get_sub_field('title');
                    $descriptions = get_sub_field('descriptions');
                    // Do something...
                 
                    ?>
                      <li>
                      <div class="left">
                        <span class="index-icon wow bounceInUp" data-wow-duration="1s">
                            <?php echo $count; ?>
                        </span>
                      </div>
                      <div class="right wow fadeInUp">
                        <h4>
                          <?php echo  $title; ?>
                        </h4>
                        <p><?php echo $descriptions; ?>
                        </p>
                      </div>
                    </li>

                    <?php
                    $count++;
                    // End loop.
                    endwhile;

                    // No value.
                    else :
                        echo "list Not found";
                    endif;
                    ?>
           
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End How it work section -->

    <!-- catching section -->
    <section class="catching">
      <div class="container">
        <h2 class="text-center">It’s catching on</h2>
        <div class="row catching-row">
              <?php

                    // Check rows exists.
                    if( have_rows('testimonial_list') ):
                      $count = 1;
                    // Loop through rows.
                    while( have_rows('testimonial_list') ) : the_row();

                    // Load sub field value.
                    $title        = get_sub_field('name');
                    $designations = get_sub_field('designations');
                    $descriptions = get_sub_field('descriptions');
                    $profile_photo = get_sub_field('profile_photo');
                    
                    if($count == 1){
                    $class = "wow bounceInLeft"; 
                    }
                    if($count == 2){
                    $class = "wow bounceInUp"; 
                    }
                    if($count == 3){
                    $class = "wow bounceInRight"; 
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 catching-block-outer <?php echo $class; ?>" data-wow-duration="1s">
                      <div class="catching-block">
                        <div class="catching-header">
                          <div class="catching-header-left">
                            <?php if( $profile_photo){ ?>
                            <img src="<?php echo $profile_photo; ?>" alt="<?php echo $title; ?>">
                            <?php } ?>
                          </div>
                          <div class="catching-header-right">
                            <h5><?php echo $title; ?></h5>
                            <span><?php echo $designations;  ?></span>
                          </div>
                        </div>
                        <div class="catching-body">
                          <p>
                            <?php echo $descriptions;  ?>
                          </p>
                          <div class="ratting">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/images/5stars.svg" alt="ratting">
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                    $count++;
                    // End loop.
                    endwhile;

                    // No value.
                    else :
                        echo "list Not found";
                    endif;
                    ?>
        </div>
      </div>
    </section>
    <!-- End catching section -->
<?php get_template_part( 'template-parts/contentabout', 'middle' ); ?>

  </main>
  <!-- End Content -->

  
<?php get_footer(); ?>