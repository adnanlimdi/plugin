<?php
/**
* Template Name: Myaccount Page template
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

get_header();
$userid    = get_current_user_id();
if($userid){
$user_info = get_userdata($userid);
session_start();
$display_name = $user_info->display_name;
$emailaddress = $user_info->user_email;
$single = true;
$hc_fullname         = get_user_meta( $userid,'hc_fullname', $single ); 
$streetaddress       = get_user_meta( $userid,'hc_streetaddress', $single ); 
$bedroomsvalue       = get_user_meta( $userid,'hc_bedroomsvalue', $single ); 
$bathroomsvalue      = get_user_meta( $userid,'hc_bathroomsvalue', $single ); 
$subscriptionptype   = get_user_meta( $userid,'hc_subscriptionptype', $single ); 
$howltp              = get_user_meta( $userid,'hc_howltp', $single ); 
$whereyouleavekey    = get_user_meta( $userid,'hc_whereyouleavekey', $single ); 
$whichday            = get_user_meta( $userid, 'hc_whichday',$single);
$whattime            = get_user_meta( $userid, 'hc_whattime',$single );
if(empty($whichday) && empty($whattime)){
  $howltp = 'Sure i am flexible';
}
//$hc_homedescriptions = get_user_meta( $userid,'hc_homedescritions', $single ); 
$hc_homedescriptions  = $bedroomsvalue.' Bedroom , '.$bathroomsvalue.' Bathroom';
$postcode      =  get_user_meta( $userid, 'hc_postcode',true );
$housenumber   =  get_user_meta( $userid, 'hc_housenumber', true );
$streetaddress = get_user_meta( $userid, 'hc_streetaddress', true );
$fulladdress   = get_user_meta( $userid,'fulladdress', $single ); 

}


?>


  <!-- Main Content -->
  <main>

    <!-- Account section -->
    <section class="account">
      <div class="container-fluid">
        <div class="row account-main">
          <div class="account-sidebar">
            <div class="sidebar-title">
              <h6><?php echo get_the_title(); ?></h6>
            </div>
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab"
                aria-controls="v-pills-home" aria-selected="true">Overview</a>
              <a   class="nav-link" id="v-pills-upcoming-tab" data-toggle="pill" href="#v-pills-upcoming" role="tab"
                aria-controls="v-pills-upcoming" aria-selected="false">Your subscriptions</a> 
              <a style="display:none;" class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab"
                aria-controls="v-pills-profile" aria-selected="false">Notifications</a>
            </div>

          </div>
          <div class="account-right">
          	<?php 
            $message_alert =   get_user_meta( $userid,'message_alert', $single );
             if(!empty($message_alert)){ ?> 
            <div class="alert-box message-notifications" > 
              <p>
                  <?php echo  $message_alert; ?>
            
              </p>
            </div>
           <?php
              update_user_meta( $userid, 'message_alert','');
             } 
            ?>
            <?php if(isset($_SESSION['meessage-cancel'])) {?>
          	<div class="alert-box message-notifications" > 
          		<p>
                  <?php echo $_SESSION['meessage-cancel']; ?>
            
            	</p>
	      
        	</div> <?php session_unset(); } ?>
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                aria-labelledby="v-pills-home-tab">

                <h3>Hello, <?php echo $hc_fullname;  ?></h3>
                <?php if(get_user_account_active_status() == 1 ){ ?>

                <p>
                  From your account you can view and edit your subscription details, change your frequency and see
                  notifications.
                </p>

                <div class="swiper-container mySwiper account-swiper">
                  <div class="swiper-wrapper">
                          <?php

            // Check rows exists.
            if( have_rows('addon_listing') ):

            // Loop through rows.
            while( have_rows('addon_listing') ) : the_row();

            // Load sub field value.
            $title        = get_sub_field('title');
            $descriptions = get_sub_field('descriptions');
            // Do something...
            ?>
                    <div class="swiper-slide">
                      <span><img src="http://205.134.254.135/~projectdemoserve/homeservice/wp-content/themes/slik/assets/images/account-block.png" alt="add more"></span>
                      <h6><?php echo $title;  ?></h6>
                      <p>
                        <?php echo $descriptions; ?>
                      </p>
                    </div>

            <?php

            // End loop.
            endwhile;

            // No value.
            else :
            // Do something...
            endif;
            wp_reset_postdata();
            ?>
               
                  </div>
                  <!-- If we need navigation buttons -->
                  <div class="swiper-button-prev"></div>
                  <div class="swiper-button-next"></div>

                  <!-- If we need scrollbar -->
                  <div class="swiper-scrollbar"></div>
                </div>
           
                <h3>Your account overview</h3>
                <div class="table-responsive account-overview">
                <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <th>Name</th>
                      <td id="full-name" class="full-name"><input type="hidden" value="<?php echo $hc_fullname; ?>" class="full-name-input form-control" placeholder="Your name">
                        <span><?php echo $hc_fullname ?></span></td>
                      <td><a data-id="full-name" class="full-name-edit edit-button-profile" href="javascript:void(0);">Change</a></td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td ><input type="hidden" value="<?php echo $emailaddress; ?>" class="email-input form-control" placeholder="Email"><span><?php echo $emailaddress; ?></span></td>
                      <td><a  data-id="email-address" class="email-address edit-button-profile" href="javascript:void(0);">Change</a></td>
                    </tr>
                    <tr>
                      <th>Address</th>
                      <td id="street-address" class="street-address"><input type="hidden" value="<?php echo $fulladdress; ?>" class="Street-address form-control " placeholder="Street Address"><span><?php echo $fulladdress; ?></span></td>
                      <td><a  data-id="street-address" class="street-address-edit edit-button-profile" href="javascript:void(0);">Change</a></td>
                    </tr>
                    <tr>
                      <th>Home desc.</th>
                      <td id="home-descriptions" class="home-descriptions" >
                        <div class="row homedesc-dropdown-text" style="display:none;">
                           <div class=" col-md-6 bedrooms-value">
                            <select class="homedesc-dropdown-input">
                              <option <?php if($bedroomsvalue == '1'){ echo "selected"; }?> value="1">1 Bedroom</option>
                              <option <?php if($bedroomsvalue == '2'){ echo "selected"; }?> value="2">2 Bedroom</option>
                              <option <?php if($bedroomsvalue == '3'){ echo "selected"; }?> value="3">3 Bedroom</option>
                            </select>
                            </div>
                            <div class=" col-md-6 bathrooms-value">
                            <select class="homedesc-dropdown-input-two">
                              <option <?php if($bathroomsvalue == '1'){ echo "selected"; }?> value="1">1 Bathroom</option>
                              <option <?php if($bathroomsvalue == '2'){ echo "selected"; }?> value="2">2 Bathroom</option>
                              <option <?php if($bathroomsvalue == '3'){ echo "selected"; }?> value="3">3 Bathroom</option>
                            </select>
                            </div>
                        </div>
                      <span> <?php echo $hc_homedescriptions; ?> </span></td>
                      <td><a  data-id="home-descriptions" class="edit-button-profile home-descriptions-edit" href="javascript:void(0);">Change</a></td>
                    </tr>
                    <tr>
                      <th>Subscription</th>
                      <td id="home-subscriptions" class="home-subscriptions">
                        <div class="row subscriptionptype-box" style="display:none;" >
                        <select class="subscriptionp-type">
                          <option <?php if($subscriptionptype == 'Weekly'){ echo "selected"; }?> value="Weekly">Weekly</option>
                          <option <?php if($subscriptionptype == 'Every Two Week'){ echo "selected"; }?> value="Every Two Week">Every Two Week</option>
                        </select>
                        </div>
                       <span><?php echo $subscriptionptype; ?></span></td>
                      <td><a data-id="home-subscriptions" class="edit-button-profile home-subscriptions-edit"  href="javascript:void(0);">Change</a></td>
                    </tr>
                    <tr>
                      <th>Day/time</th>
                      <td id="how-to-help" class="how-to-help"><input type="hidden" value="<?php echo $howltp; ?>" class="howltp form-control " ><span><?php echo $howltp; ?></span></td>
                      <td><a data-id="how-to-help" class="edit-button-profile how-to-help-edit" href="javascript:void(0);">Change</a></td>
                    </tr>
                    <tr>
                      <th>Keys</th>
                      <td id="whereyouleavekey" class="whereyouleavekey">
                        <div class="row whereyouleavekey-box" style="display:none;" >
                         <select class="whereyouleave-key">
                          <option <?php if($whereyouleavekey == 'I will be home every time'){ echo "selected"; }?> value="I will be home every time">I will be home every time</option>
                          <option <?php if($whereyouleavekey == 'I want Slik to keep a key'){ echo "selected"; }?> value="I want Slik to keep a key">I want Slik to keep a key</option>
                          <option <?php if($whereyouleavekey == 'Leave key in a safe place'){ echo "selected"; }?> value="Leave key in a safe place">Leave key in a safe place</option>
                          <option <?php if($whereyouleavekey == 'Leave key with my porter'){ echo "selected"; }?> value="Leave key with my porter">Leave key with my porter</option>
                        </select>
                       </div>
                        <span><?php echo $whereyouleavekey;  ?></span></td>
                      <td><a data-id="whereyouleavekey" class="whereyouleavekey  edit-button-profile" href="javascript:void(0);">Change</a></td>
                    </tr>
                  </tbody>
                </table>
                </div>
                 <div class="cancel-your-subscriptions"><a href="<?php echo get_permalink(340); ?>">Want to cancel your subscription?</a></div>
                <?php }else{ ?> 
                    
                <p>You currently do not have an active membership. To reactivate your membership and get back into Casaclub, click below and follow the steps.</p>
                       <a href="#"  class="open-popup-code"  data-id=" <?php echo $key->ID;  ?>" data-toggle="modal" data-target="#addmore"><button class="btn want-to-in">I Want Back in</button></a> 
                
                 <?php } ?>   

              </div>
              <div class="tab-pane fade" id="v-pills-upcoming" role="tabpanel" aria-labelledby="v-pills-upcoming-tab">
                <h3>Your subscriptions</h3>
                <p>From your account you can view and edit your subscription details, change your frequency and see notifications.</p>

                <div class="current-subscription">
                  <div class="current-subscription-left">
                     <?php if(get_user_account_active_status() == 1 ){ ?>
                    <h5>Current subscriptions</h5>
                      <?php } ?>
                    <div class="table-responsive">
                      <table>
                        <?php
                        global $wpdb;
                        $count = 0;

                        $table_name     = $wpdb->prefix . "user_subscriptions";
                        $paymenthistory = $wpdb->get_results( "SELECT * FROM $table_name 
                         WHERE `user_id` =$userid AND `status` = 'active' ORDER BY created");
                        if(!empty( $paymenthistory)){
                        foreach ($paymenthistory as $value) {
                              # code...
                             $count++;
                             if($count == 1){
                               $isactive = "active";
                             }else{
                                $isactive = "";
                             }
                             $paymentid          = $value->id;
                             $subscriptions_type = $value->subscriptions_type;
                             $userid             = $value->user_id;
                             $Item_name          = $value->Item_name;
                             $stripe_subscription_id   = $value->stripe_subscription_id;
                             $stripe_customer_id  = $value->stripe_customer_id;
                             $stripe_plan_id  = $value->stripe_plan_id;
                             $plan_amount     = $value->plan_amount;
                             $payer_email     = $value->payer_email;
                             $item_frequency       = $value->item_frequency;
                             $status       = $value->status;
                             $ftitle = $item_frequency;
                            if($item_frequency == 1){
                              $ftitle = 'Once'; 
                            }

                            if($item_frequency == 2){
                              $ftitle = 'Weekly'; 
                            }
                            if($item_frequency == 3){
                              $ftitle = 'Every Other Week'; 
                            }
                            if($item_frequency == 4){
                              $ftitle = 'Monthly';
                            }

                            if($subscriptions_type === 1){
                            	$canceledlabel =  "Cancele All";
                            }else{
                            	$canceledlabel =  "Cancele";
                            }
                        ?>
                      <tr class="<?php echo $isactive; ?>">
                          <th><?php echo $Item_name; ?></th>
                          <td><?php echo $ftitle; ?></td>
                          <?php if($ftitle == 'Once'){ ?>
                          <td>£<?php echo $plan_amount; ?></td>
                          <?php }else{ ?>
                          <td>£<?php echo $plan_amount; ?>p/m </td>
                          <?php } ?> 

                          <?php if($ftitle == 'Once' ){  echo "<td>Onetime Service.</td>";  }else{?>
                          <?php if($subscriptions_type == 1){ ?>
                           <td><a href="<?php echo get_permalink(340); ?>">Cancel</a></td>
                          <?php }else{ ?>	
                          <td><?php if($status != 'canceled'){ ?><a class="open-popup-code-payment" data-toggle="modal" data-target="#cancelpayment" data-id="<?php echo  $paymentid;  ?>" href="#">Cancel</a> <?php }else{ ?> Cancelled <?php }  ?></td>
	                      <?php } }?>
                        </tr>
                      <?php } }?>
                     
                      </table>
                    </div>
                  </div>
                  <?php if(!empty( $paymenthistory)){ ?>
                  <div class="current-subscription-right">
                    <h5>Add more</h5>
                    <a href="#" style="display:none;" class="open-popup-code"  data-id=" <?php echo $key->ID;  ?>" data-toggle="modal" data-target="#addmore"></a>
                    <div class="add-more-box">
                      <p>
                        Add optional extras to your membership. Prices shown are per time.
                      </p>
                      <ul>
                        <?php
                          $args = array(
                          'numberposts' => 10,
                          'post_type'   => 'addons'
                          );

                          $latest_addons = get_posts( $args );
                          // echo "<pre>";
                          // print_r($latest_addons);
                          // echo "</pre>";
                          if($latest_addons){
                            foreach ($latest_addons as $key) {
                              # code...
                              ?>
                              <li>
                              <a href="#" class="open-popup-code-tow"  data-id=" <?php echo $key->ID;  ?>" data-toggle="modal" data-target="#addmore121">
                                  <span class="add">
                                  <img src="http://205.134.254.135/~projectdemoserve/homeservice/wp-content/themes/slik/assets/images/plus-round.svg" alt="add more">
                                    <?php echo $key->post_title;  ?>
                                  </span>
                                  <span>+£12</span>
                                </a>
                              </li>
                              <?php
                              
                              // echo $key['id'];
                            }
                          }
                          ?>
                      </ul>
                    </div>
                  </div>
                <?php } ?>
                </div>

              </div>
              <div  style="display:none;" class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <h3>Notification content</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
 <?php if(get_user_account_active_status() == 1 ){ ?>
 <!-- add more popup -->
<div class="modal fade" id="addmore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog rounded-box" role="document">
    <div class="modal-content">
      <div class="modal-body" >
            <div class="popup-price-content"></div>

                 <div class="join-content mw420 payment step-eight" style="">
              <div class="payment-inner">
                <input type="hidden" name="">
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="custom-radio checked">
                        Credit Card
                        <input type="radio" class="payment-method-account" checked="checked" name="number" value="stipe">
                        <span class="mark"></span>
                      </label>
                    </div>
                    <div class="col-sm-6">
                      <label class="custom-radio">
                        PayPal
                        <input type="radio" class="payment-method-account" name="number" value="paypal">
                        <span class="mark"></span>
                      </label>
                    </div>
                  </div>
                  
                </div>
                <div class="stripe-form">
                     <div class="form-group">
                      <div class="panel">

                    <form method="POST"  action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" id="paymentFrm">
                      <div class="stripe-value">
                      <input type="hidden" name="subscr_plan_name" class="subscr_plan_name" value="250">
                      <input type="hidden" name="subscr_frq_name" class="subscr_frq_name" value="Weekly">
                      <input type="hidden" name="subscr_plan_amount" class="subscr_plan_amount" value="250">
                      <input type="hidden" name="subscr_plan_type" class="subscr_plan_type" value="month">
                      <input type="hidden" name="subscr_paymentmode" class="subscr_paymentmode" value="month">
                      <input type="hidden" name="page-locations" class="subscr_paymentmode" value="account">
                      </div>
                            <div class="panel-heading">
                     </div>
                    <div class="panel-body">
                        <!-- Display errors returned by createToken -->
                        <div id="paymentResponse"></div>
                        <div id="card-result"></div>
                        <div id="card-result-succuess"></div>
                        <!-- Payment form -->
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $display_name; ?>" name="name" id="name" class="field stripe-firstname form-control" placeholder="Enter name" required="" autofocus="">
                        </div>
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $emailaddress; ?>" name="email" id="email" class="field stripe-email form-control" placeholder="Enter email" required="">
                        </div>
                        <div class="form-group">
                            <label>Card Number:</label>
                            <div id="card_number" class="field form-control"></div>
                        </div>
                        <div class="row">
                           <div class="left left-one">
                                  <div class="form-group">
                                       <label>Name on Card:</label>
                                       <input id="cardholder-name" placeholder="John Smith" type="text" class="field form-control">
                                 </div>
                            </div>
                            <div class="left">
                                <div class="form-group">
                                    <label>Expiry Date:</label>
                                    <div id="card_expiry"  placeholder="MM/YY" class="field form-control"></div>
                                </div>
                            </div>
                            <div class="right">
                                <div class="form-group">
                                    <label>CVC:</label>
                                    <div id="card_cvc" placeholder="000" class="field form-control"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="add_stripe_form">
                        <label class="checkbox">
                            Save card on file
                            <input type="checkbox" id="card-button" name="save-card" value="yes">
                            <span class="mark"></span>
                        </label>
                    </div>

                  </div>
                  
                </div>
                   <div class="button-group mt-sm-5">
                   <button type="submit" class="btn btn-success" id="payBtn">Add</button>
                  </div>

                </form>

                
                 </div>
              
                 <div class="paypal-form" style="display:none">

                  <a href="https://www.paypal.com/us/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" pa-marked="1">
                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" alt="PayPal-acceptance-mark-picture">
                  </a>
                  <div class="demo-button" style="display:none;" >

                  <?php
                  $amount =  200;
                  $stype  =  'ad';
                  $email  =  $emailaddress;

                  echo do_shortcode( '[wp_paypal  button="subscribe" name="Home Clean Package" custom="'.$email.'" src="1" a3="'.$amount.'" p3="1" t3="M" src="https://wordpress.org/plugins/wp-paypal/1" return="http://205.134.254.135/~projectdemoserve/homeservice/confirmations/?res=complete&id=100"]' );

                  ?>
                  </div>
                  <div class="button-group mt-sm-5">
                   <button type="submit" class="btn btn-success" id="payBtnpayment">Submit Payment</button>
                  </div>
                </div>
          </div>

        

          </div>
      </div>
      
    </div>
  </div>
</div>
<?php }else{ ?>
<?php
global $wpdb;
$userid    = get_current_user_id();
$count = 0;
$table_name     = $wpdb->prefix . "user_subscriptions";
$paymenthistory = $wpdb->get_results( "SELECT * FROM $table_name WHERE `user_id` = $userid AND `subscriptions_type` = '1' AND `status` = 'canceled' LIMIT 1 ",ARRAY_A);
$plan_amount    = $paymenthistory[0]['plan_amount'];
$plan_interval  = $paymenthistory[0]['plan_interval'];
$item_frequency = $paymenthistory[0]['item_frequency'];
               
// echo "<pre>";
// print_r($paymenthistory);
// echo "</pre>";
?>


<div class="modal fade" id="addmore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog rounded-box" role="document">
    <div class="modal-content">
      <div class="modal-body" >
         <div class="popup-price-content"> <h3>Home Clean Package</h3>
        <p>You currently do not have an active membership. To reactivate your membership and get back into Casaclub</p>
        <div class="clean-month">
          <ul>
            <li class="clean_price_month">
              <strong>£ <?php echo intval($plan_amount); ?></strong> per Month
            </li>
          </ul>
        </div>

                 <div class="join-content mw420 payment step-eight" style="">
              <div class="payment-inner">
                <input type="hidden" name="">
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="custom-radio checked">
                        Credit Card
                        <input type="radio" class="payment-method-account" checked="checked" name="number" value="stipe">
                        <span class="mark"></span>
                      </label>
                    </div>
                    <div class="col-sm-6">
                      <label class="custom-radio">
                        PayPal
                        <input type="radio" class="payment-method-account" name="number" value="paypal">
                        <span class="mark"></span>
                      </label>
                    </div>
                  </div>
                  
                </div>
                <div class="stripe-form">
                     <div class="form-group">
                      <div class="panel">

                    <form method="POST"  action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" id="paymentFrm">
                      <div class="stripe-value">
                      <input type="hidden" name="subscr_plan_name" class="subscr_plan_name" value="Home Clean Package">
                      <input type="hidden" name="subscr_frq_name" class="subscr_frq_name" value="<?php echo $item_frequency; ?>">
                      <input type="hidden" name="subscr_plan_amount" class="subscr_plan_amount" value="<?php echo intval($plan_amount); ?>">
                      <input type="hidden" name="subscr_plan_type" class="subscr_plan_type" value="month">
                      <input type="hidden" name="subscr_paymentmode" class="subscr_paymentmode" value="month">
                      <input type="hidden" name="page-locations" class="subscr_paymentmode" value="account">
                      <input type="hidden" name="subscription-main" class="subscr_main" value="1">
                      </div>
                            <div class="panel-heading">
                     </div>
                    <div class="panel-body">
                        <!-- Display errors returned by createToken -->
                        <div id="paymentResponse"></div>
                        <div id="card-result"></div>
                        <div id="card-result-succuess"></div>
                        <!-- Payment form -->
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $display_name; ?>" name="name" id="name" class="field stripe-firstname form-control" placeholder="Enter name" required="" autofocus="">
                        </div>
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $emailaddress; ?>" name="email" id="email" class="field stripe-email form-control" placeholder="Enter email" required="">
                        </div>
                        <div class="form-group">
                            <label>Card Number:</label>
                            <div id="card_number" class="field form-control"></div>
                        </div>
                        <div class="row">
                           <div class="left left-one">
                                  <div class="form-group">
                                       <label>Name on Card:</label>
                                       <input id="cardholder-name" placeholder="John Smith" type="text" class="field form-control">
                                 </div>
                            </div>
                            <div class="left">
                                <div class="form-group">
                                    <label>Expiry Date:</label>
                                    <div id="card_expiry"  placeholder="MM/YY" class="field form-control"></div>
                                </div>
                            </div>
                            <div class="right">
                                <div class="form-group">
                                    <label>CVC:</label>
                                    <div id="card_cvc" placeholder="000" class="field form-control"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="add_stripe_form">
                        <label class="checkbox">
                            Save card on file
                            <input type="checkbox" id="card-button" name="save-card" value="yes">
                            <span class="mark"></span>
                        </label>
                    </div>

                  </div>
                  
                </div>
                   <div class="button-group mt-sm-5">
                   <button type="submit" class="btn btn-success" id="payBtn">Activate</button>
                  </div>

                </form>

                
                 </div>
              
                 <div class="paypal-form" style="display:none">

                  <a href="https://www.paypal.com/us/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" pa-marked="1">
                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" alt="PayPal-acceptance-mark-picture">
                  </a>
                  <div class="demo-button" style="display:none;" >

                  <?php
//                 $amount =  sanitize_text_field( $_POST['subscriptionplan'] );
// $stype  =  sanitize_text_field( $_POST['subscriptionptype'] );
// $email  =  sanitize_text_field( $_POST['email'] );
// $planfretitle  =  sanitize_text_field( $_POST['planfretitle'] );
                $paymentname = "Home Clean Package";
                ?>
                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                      <input name="charset" type="hidden" value="utf-8" />
                      <input name="cmd" type="hidden" value="_xclick-subscriptions" />
                      <input name="business" type="hidden" value="sb-7kbjh6208971@business.example.com" />
                      <input name="item_name" type="hidden" value="<?php echo $paymentname; ?>" />
                      <input name="item_number" type="hidden" value="<?php echo $item_frequency; ?>" />
                      <input name="a3" type="hidden" value="<?php echo $plan_amount; ?>" />
                      <input name="p3" type="hidden" value="1" />
                      <input name="t3" type="hidden" value="M" />
                      <input name="src" type="hidden" value="1" />
                      <input name="custom" type="hidden" value="<?php echo $emailaddress; ?>" />
                      <input name="currency_code" type="hidden" value="EUR" />
                      <input name="no_note" type="hidden" value="1" />
                      <input name="return" type="hidden" value="http://205.134.254.135/~projectdemoserve/homeservice/my-account/?res=complete" />
                      <input name="notify_url" type="hidden" value="http://205.134.254.135/~projectdemoserve/homeservice/?wp_paypal_ipn=1" />
                      <input name="bn" type="hidden" value="WPPayPal_Subscribe_WPS_US" />
                      <input name="submit" src="http://205.134.254.135/~projectdemoserve/homeservice/wp-content/plugins/wp-paypal/images/subscribe.png" type="image" />
                 </form>
                  </div>
                  <div class="button-group mt-sm-5">
                   <button type="submit" class="btn btn-success" id="payBtnpayment">Submit Payment</button>
                  </div>
                </div>
          </div>

        

          </div>
      </div>
      
    </div>
  </div>
</div></div>
 <?php } ?> 

    <!-- End Account section -->
<div class="modal fade" id="cancelpayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog rounded-box" role="document">
    <div class="modal-content">
      <div class="modal-body" >
      	<div class="popup-payment-content">
      		<div class="payment-filed"><input type="hidden" class="payment-value-id" value="" ></div>
      		<div class="title-cancel"><h2> Oven </h2></div>
	   		<p>To end this subscription or to change the frequency, hit the button. To start a new subscription with a different frequency you’ll need to add it again in Your Subscription.</p>
	      	<div class="button-group mt-sm-5">
	                   <button type="submit" class="cancel-payment-button btn btn-success" >End</button>
	        </div>
		  </div>
     </div>
    </div>
  </div>
</div>   	

 <?php get_template_part( 'template-parts/content', 'middle' ); ?>

  </main>
  <!-- End Content -->

  <?php get_footer(); ?>

  <?php
// Subscription plans 
// Minimum amount is $0.50 US 
// Interval day, week, month or year 
 
/* Stripe API configuration 
 * Remember to switch to your live publishable and secret key in production! 
 * See your keys here: https://dashboard.stripe.com/account/apikeys 
 */ 
define('STRIPE_API_KEY', 'sk_test_51JT1PhJQoyEaQViihNcr4X2TLq8oyZcwD9WK1CJ672xxmMcZp8BumsSaApid3SGHMhwNFMUsqr5KuLco3GH6erkM00BzpFg2z0'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51JT1PhJQoyEaQViitjG8oiy69oPOwa1Mt8eVHvj7b1IrvnViVFDFD3VNM7M7Qkcn5NVVtRPXE3d7ddoPp3MJrdwW00FQMBvHkP');
?>




<script src="https://js.stripe.com/v3/"></script>

<script>
//var stripe = Stripe('<?php //echo STRIPE_PUBLISHABLE_KEY; ?>');
//var elements = stripe.elements();
// Create an instance of the Stripe object
// Set your publishable API key
var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');
var cardholderName = document.getElementById('cardholder-name');
var cardButton = document.getElementById('card-button');
var resultContainer = document.getElementById('card-result');
var resultContainersu = document.getElementById('card-result-succuess');
// Create an instance of elements
var elements = stripe.elements();

var style = {
    base: {
        fontWeight: 400,
        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
        fontSize: '16px',
        lineHeight: '1.4',
        color: '#555',
        backgroundColor: '#fff',
        '::placeholder': {
            color: '#888',
        },
    },
    invalid: {
        color: '#eb1c26',
    }
};

var cardElement = elements.create('cardNumber', {
    style: style
});
cardElement.mount('#card_number');

var exp = elements.create('cardExpiry', {
    'style': style
});
exp.mount('#card_expiry');

var cvc = elements.create('cardCvc', {
    'style': style
});
cvc.mount('#card_cvc');

// Validate input of the card elements
var resultContainer = document.getElementById('paymentResponse');
cardElement.addEventListener('change', function(event) {
    if (event.error) {
        resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
    } else {
        resultContainer.innerHTML = '';
    }
});

cardButton.addEventListener('click', function(ev) {
//alert('okay');
 if($(this).is(':checked')){
    stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
        billing_details: {
          name: cardholderName.value,
        },
      }
    ).then(function(result) {
      if (result.error) {
        // Display error.message in your UI
        resultContainer.textContent = result.error.message;
      } else {
        // You have successfully created a new PaymentMethod
        resultContainersu.textContent = "Created payment method: " + result.paymentMethod.id;
      }
    });
  } 
});

// Get payment form element
var form = document.getElementById('paymentFrm');

// Create a token when the form is submitted.
form.addEventListener('submit', function(e) {
    e.preventDefault();
    createToken();
});

// Create single-use token to charge the user
function createToken() {
    stripe.createToken(cardElement).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error
            resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
        } else {
            // Send the token to your server
            stripeTokenHandler(result.token);
        }
    });
}

// Callback to handle the response from stripe
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
    
    // Submit the form
   form.submit();
}
</script>