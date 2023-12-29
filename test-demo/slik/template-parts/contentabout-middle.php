<?php
/**
 * Displays the content when the cover template is used.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
$want_to_slik_title      = get_field('want_to_slik_title','option');
$descriptions            = get_field('Descriptions','option');
$slick_page_link         = get_field('slick_page_link','option');

 if ( !is_user_logged_in() ) { ?>


<section class="plan act-plan other-page">
        <div class="container">
          <div class="row plan-main">
            <div class="col-md-7 plan-left">
              <h2>Limited availability. Reserve your place.</h2>
              <p>Select from our weekly and fortnightly plans.</p>
            </div>
            <div class="col-md-5 plan-right">
         
             <?php if($slick_page_link) { ?>
            <a href="<?php echo $slick_page_link['url'];  ?>" class="slik-btn white-btn" title="<?php echo $slick_page_link['title'];  ?>"><?php echo $slick_page_link['title'];  ?></a>
            <?php } ?>
        
            </div>
          </div>
        </div>
      </section>
 <?php }else{ ?>
<section class="plan act-plan other-page">
        <div class="container">
          <div class="row plan-main">
            <div class="col-md-7 plan-left">
              <h2>Show us that home.</h2>
              <p>Be featured on our social. Send in what makes your home so dreamy.</p>
            </div>
            <div class="col-md-5 plan-right">
         
            <a href="#" class="slik-btn white-btn" title="Follow Us">Follow us</a>
        
            </div>
          </div>
        </div>
      </section>


 <?php } ?> 


