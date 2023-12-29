<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */


//Join Slick


$footer_logo            = get_field('footer_logo','option');
$facebook_link          = get_field('facebook_link','option');
$instagram_link         = get_field('instagram_link','option');
$twitter_link           = get_field('twitter_link','option');

$facebook_link  		    = (!empty($facebook_link)) ? $facebook_link : '#';
$instagram_link 		    = (!empty($instagram_link)) ? $instagram_link : '#';
$twitter_link   		    = (!empty($twitter_link)) ? $twitter_link : '#' ;

?>

<!-- Footer -->
  <footer>
    <div class="container">
      <div class="footer-top">
        <div class="row">
          <div class="col-md-7 col-sm-5 footer-left">
            <a href="<?php echo home_url(); ?>" class="footer-logo" title="Slik">
              <img src="<?php echo $footer_logo['url'] ?> " alt="Logo">
            </a>
          </div>
          <div class="col-md-5 col-sm-7 footer-right">
            <div class="row">
              <div class="col-6">
                <div class="footer-widget">
                  <h4>Pages</h4>
			 		<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => '',
							 'items_wrap' => '<ul class="">%3$s</ul>',
						)
					);
				?>

                </div>
              </div>
              <div class="col-6">
                <div class="footer-widget">
                  <h4 class="text-center">Follow us</h4>
                  <ul class="social-icon">
                    <li><a href="<?php echo $facebook_link; ?>" title="Facebook"><img src="<?php echo get_template_directory_uri() ?>/assets/images/facebook.svg" alt="facebook"></a></li>
                    <li><a href="<?php echo $instagram_link; ?>" title="Instagram"><img src="<?php echo get_template_directory_uri() ?>/assets/images/instagram.svg" alt="Instagram"></a></li>
                    <li><a href="<?php echo $twitter_link ?>" title="Twitter"><img src="<?php echo get_template_directory_uri() ?>/assets/images/twitter.svg" alt="Twitter"></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="row footer-bottom-inner">
          <div  class="col-sm-4 footer-bottom-left">
            <p>© Casaclub <?php echo date('Y') ?></p>
          </div>

          <div class="col-sm-8 footer-bottom-right">
          	 
            <ul>
            	<?php
                    // Check rows exists.
                    if( have_rows('footer_link','option') ):
                    // Loop through rows.
                    while( have_rows('footer_link','option') ) : the_row();

                    // Load sub field value.
                    $page_link        = get_sub_field('page_link');
                    if($page_link){
                    $title 			  =  $page_link['title'];
                   	$url 			  =  $page_link['url'];
                    // Do something...
                    ?>
                       <li><a href="<?php echo $url; ?>"><?php echo $title;  ?></a></li>
                    <?php
                	}	
                    // End loop.
                    endwhile;
                    endif;	
                    ?>
       
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- End Footer -->
  <?php wp_footer(); ?>
</body>

</html>
