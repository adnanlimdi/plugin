<?php
/**
* Template Name: Confirmed template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
//session_start();
//echo $cookieValue = $_COOKIE['my_cookie'];

if(!isset($_SESSION)  && !isset($_REQUEST)){
   wp_redirect($url);
} 

if(!isset($_REQUEST["token"])  && $_REQUEST["res"] != 'complete' ){
if(!isset($_SESSION['stepsno']) == 1){
	if(!isset($_SESSION["emailaddress"]) || $_SESSION["payment-staus"] != 1   ){
    	 $url = home_url();
       if($_SESSION['bedroomsvalue'] != '4+' ){
	        wp_redirect($url);
      }
	}
}
}


$paymentstaus = 0;
if(isset($_SESSION["emailaddress"])  && $_SESSION["payment-staus"] === 1 ){
    $paymentstaus = 1;
}

if(isset($_REQUEST["token"])  && $_REQUEST["res"] == 'complete' ){
    $paymentstaus = 1;
    $paymenmethod = 'paypal';
}
$userdata = '';
if(isset($_SESSION["emailaddress"])  && $paymentstaus === 1 || $_SESSION['bedroomsvalue'] == '4+' ){

  $firstname          = $_SESSION["fullname"];       
  $emailaddress       = $_SESSION["emailaddress"];    
  $userpasssword      = $_SESSION["userpasssword"];
  $postcode           = $_SESSION["postcode"];
  $housenumber        = $_SESSION["housenumber"];
  $streetaddress      = $_SESSION["streetaddress"];
  $fulladdress        = $_SESSION["fulladdress"];
  $bedroomsvalue      = $_SESSION["bedroomsvalue"];
  $bathroomsvalue     = $_SESSION["bathroomsvalue"];
  $subscriptionplan   = $_SESSION["subscriptionplan"];
  $subscriptionptype  = $_SESSION["subscriptionptype"];
  $paymentmode        = $_SESSION["paymentmode"];
  $howltp             = $_SESSION["howltp"];
  $whichday           = $_SESSION["whichday"];
  $whattime           = $_SESSION["whattime"];
  $whereyouleavekey   = $_SESSION["whereyouleavekey"];
  $homedescritions    = $_SESSION["homedescritions"];

// $_SESSION["lastname"] = "Parker";
  if(!email_exists($emailaddress)){

    // $user_login = wp_slash( $emailaddress );
    // $user_email = wp_slash( $emailaddress );
    // $user_pass  = $password;

  // $userdata = compact( 'user_login', 'user_email', 'user_pass' );
  // return wp_insert_user( $userdata );
  $username = preg_replace('/\s/', '', $firstname);
  if(username_exists($username)){
     $username = preg_replace('/\s/', '', $emailaddress);
  }
  $user_id = wp_create_user($username,$userpasssword, $emailaddress );
  update_user_meta( $user_id, 'hc_fullname',$firstname, true );
  update_user_meta( $user_id, 'hc_postcode',$postcode, true );
  update_user_meta( $user_id, 'hc_housenumber',$housenumber, true );
  update_user_meta( $user_id, 'hc_streetaddress',$streetaddress, true );
  update_user_meta( $user_id, 'hc_bedroomsvalue',$bedroomsvalue, true );
  update_user_meta( $user_id, 'hc_bathroomsvalue',$bathroomsvalue, true );
  update_user_meta( $user_id, 'hc_bathroomsvalue',$bathroomsvalue, true );
  update_user_meta( $user_id, 'hc_subscriptionplan',$subscriptionplan, true );
  update_user_meta( $user_id, 'hc_subscriptionptype',$subscriptionptype, true );
  update_user_meta( $user_id, 'hc_paymentmode',$paymentmode, true );
  update_user_meta( $user_id, 'hc_howltp',$howltp, true );
  update_user_meta( $user_id, 'hc_whichday',$whichday, true );
  update_user_meta( $user_id, 'hc_whattime',$whattime, true );
  update_user_meta( $user_id, 'hc_whereyouleavekey',$whereyouleavekey, true );
  update_user_meta( $user_id, 'hc_homedescritions',$homedescritions, true );
   $fulladdress  = $housenumber.', '.$streetaddress.', '.$postcode;
  update_user_meta( $user_id, 'fulladdress',$fulladdress, true );
  $creds = array(
        'user_login'    =>$username,
        'user_password' =>$userpasssword,
        'remember'      =>true
    );
 
  $userdata = wp_signon( $creds, true);

  // print_r($user);
  // exit();


 get_header();
  if($user_id){
    global $wpdb;
    
  if($paymenmethod  == 'paypal'){
    //9$_GET['userid'] = $user_id; 
    $sql = "UPDATE `hc_user_subscriptions` SET `user_id` = $user_id WHERE `hc_user_subscriptions`.`payer_email` = '".$emailaddress."'"; 
      $sqllast  = $wpdb->prepare($sql);
    $wpdb->query($sqllast);
     session_unset();
  }
  if($_SESSION['payment-mode'] === 'stripe'){ 
          // $data = [ 'user_id' => $user_id ]; // NULL value.
     // $where = [ 'payer_email' =>$emailaddress]; // NULL value in WHERE clause.
     // $wpdb->update( $wpdb->prefix . 'user_subscriptions', $data, $where ); // Also works in this case.
     //update Subscriptions table
      $sql = "UPDATE `hc_user_subscriptions` SET `user_id` = $user_id WHERE `hc_user_subscriptions`.`payer_email` = '".$emailaddress."'"; 
      $sqllast  = $wpdb->prepare($sql);
      $wpdb->query($sqllast);
      session_unset();

   } 


 }

  if($user_id){
  $subject = "Welcome To Slik";
  ob_start();
      ?>
      <table border="0" cellpadding="10" cellspacing="0" style=
      "background-color: #FFFFFF" width="100%">
        <tr>
          <td id="templateContainerHeader" valign="top" mc:edit="welcomeEdit-01" style="font-size:14px; padding-top:2.429em; padding-bottom:.929em">
            <p style="text-align:center;margin:0;padding:0; color:#545454; display:block; font-family:Helvetica; font-size:16px; line-height:1.5em; font-style:normal; font-weight:400; letter-spacing:normal;"><img  src="<?php echo get_template_directory_uri() ?>/assets/images/logo.png"
            style="display:inline-block;"></p>
          </td>
        </tr>
        <tr>
          <td align="center" class="unSubContent" id="bodyCellFooter" valign=
          "top" style="margin:0;padding:0;width:100%!important;padding-top:10px;padding-bottom:15px">
            <table border="0" cellpadding="0" cellspacing="0" id=
            "templateContainerFooter" width="100%" style="border-collapse:collapse;">
              <tr>
                <td valign="top" width="100%" mc:edit="welcomeEdit-11">
                  <h6 style="text-align:center;margin-top: 9px; color:#a1a1a1; display:block; font-family:Helvetica; font-size:12px; line-height:1.5em; font-style:normal; font-weight:400; letter-spacing:normal; margin-right:0; margin-bottom:0; margin-left:0;">Thank you for purchasing Subscription</h6>
                    <a style="text-align:center;margin-top: 9px;"href=
                  "<?php echo site_url();?>/login/">Click here</a> to go to login page.</p>
                </a>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    <?php
      $html = ob_get_contents();
      ob_end_clean();
      $headers = array('Content-Type: text/html; charset=UTF-8');
      //echo $html;
      wp_mail($emailaddress, $subject, $html, $headers);

    }  

  }else{
  //echo "Email alerdy exists";
   get_header();
   //   $url = home_url();
   //   wp_redirect($url);
   //   exit();

  }
}
?>
  <!-- Main Content -->
  <main>

    <?php $class = ''; if($_SESSION['stepsno'] == 2){ ?>

    <?php $class = 'confirm-postcode'; } ?>  

  <!-- Join section -->
  <section class="join-page <?php echo $class; ?>">
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
          <div class="join-content mw260 payment confirm">
            <div class="overlay">
                <div class="overlay__inner">
                <div class="spinner" style="">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/spinner.svg" alt="Loading">
                </div>
            </div>
          </div>
            <?php if($_SESSION['stepsno'] == 2){ ?>
               <p>
              Thanks for visiting site! 
            </p>
            <span>We’ll contact you for that.</span>
            <?php  session_unset(); ?>
            <?php }else{ ?>
                  <p>
              Confirmed! <br>Welcome to Slik
            </p>
            <span>We’ll send you a confirmation email and get everything set up for your first home clean.</span>
             <?php } ?> 
             <?php if(empty($userdata)){ ?>
              <div class="button-group mt-sm-5 pt-sm-5">
                <a href="<?php echo home_url();  ?>"><button class="btn ">Done</button></a>
              </div>
            <?php }else{ ?>
            <div class="button-group mt-sm-5 pt-sm-5">
                <a href="<?php echo home_url('/my-account');  ?>"><button class="btn ">Done</button></a>
              </div>
             <?php } ?> 
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end Join section -->

   <?php get_template_part( 'template-parts/content', 'middle' ); ?>


<?php
?>

  </main>
  <!-- End Content -->

  <?php get_footer(); ?>