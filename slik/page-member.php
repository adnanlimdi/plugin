<?php
/**
* Template Name: Membership template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
//session_start();
//echo $cookieValue = $_COOKIE['my_cookie'];

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

// if(!isset($_SESSION['stepsno']) == 1){
// 	if(!isset($_SESSION["emailaddress"]) || $_SESSION["payment-staus"] != 1   ){
//     	 $url = home_url();
//        if($_SESSION['bedroomsvalue'] != '4+' ){
// 	      wp_redirect($url);
//       }
// 	}
// }


get_header();
?>
  <!-- Main Content -->
  <main>

  <!-- Join section -->
  <section class="join-page">
    <div class="container-fluid">
    
      <div class="container">
        <div class="join">
          <div class="join-head">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/join-logo.svg" class="join-logo mb-0" alt="Logo">
          </div>
          <div class="join-content mw480 payment confirm">
                  <p>
                  End your membership
            </p>
            <span>
            We will cancel your membership starting 48 hours from now. Any clean you have coming up in the next 48 hours is already scheduled and you will still be charged for it. Your product stash will be taken in for recycling and repurposing in line with our sustainability promise.
            </span>
            <br><br>
            <span>Would you like to go ahead and cancel now?</span>
            <br><br>
            <form>
              <div class="button-group mt-sm-5 pt-sm-5">
              <a href="<?php echo site_url().'/my-account'; ?>"><button type="button" class="btn back prevfirst">Go back</button></a>

              <a href="<?php echo site_url().'/cancel-your-membership'; ?>">
                <button type="button" class="btn ">Cancel</button></a>
              </div>
            </form>
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