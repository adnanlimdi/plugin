<?php
/**
* Template Name: Cancel Membership template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/



get_header();
if(is_user_logged_in()){
  $userid    = get_current_user_id();
global $wpdb;
$count = 0;
$table_name     = $wpdb->prefix . "user_subscriptions";
$paymenthistory = $wpdb->get_results( "SELECT * FROM $table_name 
WHERE `user_id` = $userid AND `status` = 'active' And item_frequency != 'Once'  ORDER BY created");


if(!empty($paymenthistory)){
  foreach ($paymenthistory as $value) {
       $paymentid          = $value->id;
       $subscriptions_type = $value->payment_method;
       $stripe_subscription_id  = $value->stripe_subscription_id;
       $stripe_customer_id = $value->stripe_customer_id;
       $payment_method     = $value->payment_method;

        $paymentmethod          = $paymenthistory[0]->payment_method;
        if($paymentmethod  == 'Stripe'){
                cancel_subscriptions_stripe($stripe_subscription_id,$paymentid);
         }else{

              $resd     = change_subscription_status( $stripe_customer_id, 'Cancel' );

              if ($resd['ACK'] != 'Failure'){
                        echo $resd['L_SHORTMESSAGE0'];
                        $_SESSION['meessage-cancel'] = $resd['L_SHORTMESSAGE0'];
                        global $wpdb;
                        $sql = "UPDATE `hc_user_subscriptions` SET `status` = 'canceled' WHERE `hc_user_subscriptions`.`id` = '".$paymentid."'"; 
                        $sqllast  = $wpdb->prepare($sql);
                        $wpdb->query($sqllast);
                        $_SESSION['meessage-cancel'] = "Your Membership Is Canceled";

                    }

         } 
  }
}else{
   $url = site_url().'/my-account';
   $_SESSION['meessage-cancel'] = "Your Membership Is already Canceled";
   wp_redirect($url);
}

}else{
   $url = home_url();
   wp_redirect($url);
}

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
          <div class="join-content mw350 payment confirm">
                  <p>
                  Your membership has <br>been cancelled.
            </p>
            <span>Sorry to see you go! You can restart this at any time by logging back into your account.</span>
            <br><br>
            <span>We miss your home already.</span>
            <br><br>
              <div class="button-group mt-sm-5 pt-sm-5">
                <a href="<?php echo home_url(); ?>"><button class="btn ">Back to Home</button></a>
              </div>
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