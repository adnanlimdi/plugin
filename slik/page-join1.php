<?php
/**
* Template Name: Joinus Page template
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
            <div class="wizzard" style="display:none;">
              <ul>
                <li class="first current"></li>
                <li class="second "></li>
                <li class="third "></li>
                <li class="four "></li>
                <li class="five "></li>
                <li class="six "></li>
                <li class="seven "></li>
                <li class="nine "></li>
                <li class="ten "></li>
              </ul>
            </div>
          </div>
          <div class="join-content ">
         <div class="form-common  step-form-init mw320">
                 <p>
               We have limited places. Please enter your referral code to continue.
              </p>
              <form class="mt-md-5 mt-4 p-2" autocomplete="on">
                <div class="form-group referral-form">
                  <input type="text"  class="referral-code form-control" placeholder="Referral code">
                  <span class="error"></span>
                </div>


                <div class="button-group">
                  <button type="button" class="btn border-btn openform">Next</button>
                </div>
         
              </form>
               <p class="sign-up join-wait-list">
                  Don’t have a referral code? <a href="<?php echo home_url(); ?>/wait-list"> Join the waitlist.</a>
                </p>
              </div>

              <!-- first Form start -->
              <div class="form-common step-form-one mw320" style="display:none;">
                 <p>
                You’re a few moments away from a membership. 
              </p>
              <form class="mt-md-5 mt-4 p-2" autocomplete="on">
                <div class="form-group">
                  <input type="text"  class="first-name form-control" placeholder="Your name">
                </div>
                <div class="form-group">
                  <input type="email" class="email-address form-control" placeholder="Email address">
                </div>
                <div class="form-group">
                  <input type="password" class="user-password form-control" placeholder="Password">
                </div>
                <div class="button-group">
                  <button type="button" class="btn border-btn nextbuttonfirst">Next</button>
                </div>
                <p class="sign-up">
                  Already a member? <a href="<?php echo site_url().'/login'; ?>"> Login</a>
                </p>
              </form>
              </div>
              <!-- Second Form End -->

              <!-- Second Form start -->
              <div class="form-common step-form-two mw320" style="display:none;">
                  <p>Tell us where your <span class="reco">home</span> is</p>
                  <div class="alert alert-light postcode-popup" role="alert" style="display:none;">
                      <div class="alert-inner">
                        <div class="alert-left ">
                          <strong>We’re not in your area yet</strong>
                          <span>Want us to let you know when we are?</span>
                        </div>
                        <div class="alert-right">
                          <button class="when-we-are active">Yes</button>
                          <button class="when-we-are">Opt out</button>
                        </div>
                      </div>
                    </div>

                    <form class="mt-3" autocomplete="on">
                      <div class="form-group">
                        <input type="text" class="postcode form-control" placeholder="Postcode">
                      </div>
                      <div class="form-group">
                        <input type="text" class="house-number form-control" placeholder="House number">
                      </div>
                      <div class="form-group">
                        <input type="text" class="street-address form-control" placeholder="Street address">
                      </div>
                      <div class="button-group mt-md-5 pt-md-5">
                        <button type="button" class="btn back prevfirst">Back</button>
                        <button type="button" class="btn next nextbuttonsecond">Next</button>
                      </div>
                    </form>
                </div>
               <!-- Second Form end-->

             <!-- Third Form start -->
              <div class="form-common join-contents mw550 step-form-three" style="display:none">
              <p>
                How many bedrooms do you have?
              </p>

              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                  <a class="bedrooms-value nav-link" id="pills-Studio-tab" data-toggle="pill" href="#pills-Studio" role="tab" aria-controls="pills-Studio" aria-selected="false">Studio</a>
                </li>
                <li class="nav-item">
                  <a class="bedrooms-value nav-link" id="pills-1-tab" data-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-1" aria-selected="false">1</a>
                </li>
                <li class="nav-item">
                  <a class="bedrooms-value nav-link active" id="pills-2-tab" data-toggle="pill" href="#pills-2" role="tab" aria-controls="pills-2" aria-selected="true">2</a>
                </li>
                <li class="nav-item">
                  <a class="bedrooms-value nav-link" id="pills-3-tab" data-toggle="pill" href="#pills-3" role="tab" aria-controls="pills-3" aria-selected="false">3</a>
                </li>
                <li class="nav-item">
                  <a class="bedrooms-value nav-link" id="pills-4-tab" data-toggle="pill" href="#pills-4" role="tab" aria-controls="pills-4" aria-selected="false">4+</a>
                </li>
              </ul>

              <p class="mt-5 pt-md-5">
                And how many bathrooms?
              </p>
              <ul class="nav nav-pills mb-3 pill-4" id="pills-tab" role="tablist">
                <li class="nav-item">
                  <a class="bathrooms-value nav-link active" id="pills-1-tab" data-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-1" aria-selected="true">1</a>
                </li>
                <li class="nav-item">
                  <a class="bathrooms-value nav-link" id="pills-2-tab" data-toggle="pill" href="#pills-2" role="tab" aria-controls="pills-2" aria-selected="false">2</a>
                </li>
                <li class="nav-item">
                  <a class="bathrooms-value nav-link" id="pills-3-tab" data-toggle="pill" href="#pills-3" role="tab" aria-controls="pills-3" aria-selected="false">3</a>
                </li>
                <li class="nav-item">
                  <a class="bathrooms-value nav-link" id="pills-4-tab" data-toggle="pill" href="#pills-4" role="tab" aria-controls="pills-4" aria-selected="false">4+</a>
                </li>
              </ul>
              
                
                <div class="button-group mt-md-5 pt-md-5">
                  <button type="submit" class="btn back prevsecond">Back</button>
                  <button type="submit" class="btn next nextbuttonthird">Next</button>
                </div>
            </div>
            <!-- Third Form End -->
            
          <!-- step 4 html code start here -->
          <div class="form-common join-content mw450 step-form-four" style="display:none">
               
          </div>
          <!-- step 4 html code end -->

          <!-- step 5 html code start here -->
          <div class="form-common join-content mw468 step-form-five" style="display:none">
                <p>
                  We have peak and off-peak days of the week for cleaning and would like you slot you in on the day and a time that makes the most sense.
                </p>
                <p class="mt-4 pt-2">
                  How would you like to proceed?
                </p>

                <form class="mt-md-5 mt-4 p-3" autocomplete="on">
                  <div class="join-option mw219">
                  <label class="custom-radio checked">
                    Sure, I’m flexible
                    <input type="radio" data-id="yes"  class="how-wltp" checked="checked" name="number" value="I’m flexible">
                    <span class="mark"></span>
                  </label>
                  <label class="custom-radio">
                    I’d rather choose the day/time
                    <input type="radio" data-id="no" class="how-wltp" name="number" value="I’d rather choose the day/time">
                    <span class="mark"></span>
                  </label>
                </div>
                  <div class="button-group mt-md-5 pt-md-5">
                    <button type="button"  class="btn back prevfour">Back</button>
                    <button  type="button" class="btn nextbuttonfive">Next</button>
                  </div>
                </form>
              </div> 
              <!-- step 5 html code start here -->


               <!-- step 6 html code start here -->
              <div class="form-common join-content mw468 step-form-six" style="display:none">
                  <form class="mt-md-5 mt-4 p-3 ">
                    <p class="mb-4 pb-md-3">
                      Which day would you prefer?
                    </p>
                    <select class="which-day" name="day" id="day">
                      <option value="">Choose</option>
                      <option value="Monday">Monday</option>
                      <option value="Tuesday">Tuesday</option>
                      <option value="Wednesday">Wednesday</option>
                      <option value="Thursday">Thursday</option>
                      <option value="Friday">Friday</option>
                      <option value="Saturday">Saturday</option>
                      <option value="Sunday">Sunday</option>
                    </select>
                    <p class="mt-5 pt-md-4 mb-4 pb-md-3">
                      What time would you prefer us to arrive?
                    </p>
                    <?php $times = create_time_range('7:00', '21:00', '60 mins'); ?>
                    <select class="what-time" name="date" id="date">
                      <option value="">Choose</option>
                      <?php foreach($times as $key=>$val){ ?>
                      <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                      <?php } ?>
                    </select>
                    <div class="button-group mt-md-5 pt-md-5">
                      <button type="button" class="btn back prevfive">Back</button>
                      <button type="button"  class="btn nextbuttonsix ">Next</button>
                    </div>
                  </form>
                </div>
                <!-- step 6 html code end here -->
                <!-- step 7 html code start here -->
                <div class="form-common join-content mw420 step-form-seven" style="display:none">
                    <p>
                      After our first visit, how shall we get access to your home?
                    </p>
                    <form class="mt-md-5 mt-4 p-3">
                      <div class="join-option mw219">
                      <label class="custom-radio">
                        I will be home every time
                        <input type="radio" class="how-to-access-home" name="how-to-access-home" value="I will be home every time">
                        <span class="mark"></span>
                      </label>
                      <label class="custom-radio">
                        I want Slik to keep a key
                        <input type="radio" class="how-to-access-home" name="how-to-access-home" value="I want Slik to keep a key">
                        <span class="mark"></span>
                      </label>
                      <label class="custom-radio">
                        Leave key in a safe place
                        <input type="radio" class="how-to-access-home" name="how-to-access-home" value="Leave key in a safe place">
                        <span class="mark"></span>
                      </label>
                      <label class="custom-radio checked">
                        Leave key with my porter
                        <input type="radio" class="how-to-access-home" checked="checked" name="how-to-access-home" value="Leave key with my porter">
                        <span class="mark"></span>
                      </label>
                    </div>
                      <div class="button-group mt-md-5 pt-md-4">
                        <button type="button" class="btn back prevsix">Back</button>
                        <button type="button"  class="btn final-submit">Next</a>
                      </div>
                    </form>
              </div>
              <!-- step 7 html code end here -->
              
              <!-- step 8 html code with payemnt -->
              <div class="join-content mw550 signup-final-process">

              </div> 
              <!-- step 8 html code end -->

              
      <div class="join-content mw420 payment step-eight"  style="display:none">
            <p>
              Set up your monthly recurring  payment
            </p>
              <div class="payment-inner">
                <h5 class="price-txt">£200/mo</h5>
                <input type="hidden" name="">
                <div class="form-group">
                  <label class="mb-3">Choose payment method:</label>
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="custom-radio checked">
                        Credit Card
                        <input type="radio"  class="payment-method" checked="checked" name="number" value="stipe">
                        <span class="mark"></span>
                      </label>
                    </div>
                    <div class="col-sm-6" >
                      <label class="custom-radio">
                        PayPal
                        <input type="radio" class="payment-method" name="number" value="paypal">
                        <span class="mark"></span>
                      </label>
                    </div>
                  </div>
                  
                </div>
                <div class="stripe-form">
                <div class="form-group">
                      <div class="panel">

                    <form method="POST"  action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" id="paymentFrm">
                      <input type="hidden" name="subscr_plan_name" class="subscr_plan_name" value="Home Clean package">
                      <input type="hidden" name="subscr_frq_name" class="subscr_frq_name" >
                      <input type="hidden" name="subscr_plan_amount" class="subscr_plan_amount">
                      <input type="hidden" name="subscr_plan_type" class="subscr_plan_type">
                      <input type="hidden" name="subscr_paymentmode" class="subscr_paymentmode">
                            <div class="panel-heading">
                     </div>
                    <div class="panel-body">
                        <!-- Display errors returned by createToken -->
                        <div id="paymentResponse"></div>
                        <div id="card-result"></div>
                        <div id="card-result-succuess"></div>
                        <!-- Payment form -->
                        <div class="form-group">
                            <input type="hidden" name="name" id="name" class="field stripe-firstname form-control" placeholder="Enter name" required="" autofocus="">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="email" id="email" class="field stripe-email form-control" placeholder="Enter email" required="">
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
                   <button type="submit" class="btn btn-success" id="payBtn">Submit Payment</button>
                  </div>

                </form>
              </div>
              
             <div  class="paypal-form" style="display:none">
                    <a href="https://www.paypal.com/us/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" pa-marked="1">
                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" alt="PayPal-acceptance-mark-picture">
                  </a> 
                  <div class="demo-button" style="display:none;">
                     <?php echo do_shortcode( '[wp_paypal button="subscribe" name="Weekly Home Clean" a3="200.00" p3="12" t3="M" src="https://wordpress.org/plugins/wp-paypal/1" return="http://205.134.254.135/~projectdemoserve/homeservice/confirmations/?res=complete&id=100"]' ); ?>
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
    </div>
  </section>
  <!-- end Join section -->
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
      <!-- End plan section -->
  <?php get_template_part( 'template-parts/content', 'middle' ); ?>
  </main>
  <!-- End Content -->

  
<?php get_footer(); ?>
<script type="text/javascript">
  
     


</script>