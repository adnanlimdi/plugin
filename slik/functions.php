<?php
/**
 * Slik functions and definitions
 *
 *
 * @package WordPress
 * @subpackage Slik
 * @since Slik theme 1.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function slik_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'slik-fullscreen', 1980, 9999 );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
			'navigation-widgets',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Twenty, use a find and replace
	 * to change 'slik' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'slik-theme' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );



	/*
	 * Adds starter content to highlight the theme on fresh sites.
	 * This is done conditionally to avoid loading the starter content on every
	 * page load, as it is a one-off operation only needed once in the customizer.
	 */
	// if ( is_customize_preview() ) {
	// 	require get_template_directory() . '/inc/starter-content.php';
	// 	add_theme_support( 'starter-content', slik_get_starter_content() );
	// }

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	

}

add_action( 'after_setup_theme', 'slik_theme_support' );



/**
 * Register and Enqueue Scripts.
 */
function slik_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'slik-jquery-min','https://code.jquery.com/jquery-3.1.1.min.js', array(), $theme_version, true );
	wp_enqueue_script( 'slik-bootstrap-js', get_template_directory_uri() . '/assets/vender/bootstrap/js/bootstrap.min.js', array(), $theme_version, true );
	wp_enqueue_script( 'slik-bundle-js', get_template_directory_uri() . '/assets/vender/swiper/js/swiper-bundle-min.js', array(), $theme_version, true );
	wp_enqueue_script( 'slik-custom-js', get_template_directory_uri() . '/assets/js/custom.js', array(), $theme_version, true );
	wp_enqueue_script( 'slik-wow-js', get_template_directory_uri() . '/assets/js/wow.min.js', array(), $theme_version, true );
	//wp_script_add_data( 'slik-js', 'async', true );
     wp_localize_script( 'slik-custom-js', 'slik_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

}

add_action( 'wp_enqueue_scripts', 'slik_register_scripts' );


/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function slik_menus() {

	$locations = array(
		'primary'  => __( 'Main Menu', 'slik' ),
		'footer'   => __( 'Footer Menu', 'slik' ),
		'social'   => __( 'Social Menu', 'slik' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'slik_menus' );



if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function slik_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __( 'Skip to the content', 'slik' ) . '</a>';
}

add_action( 'wp_body_open', 'slik_skip_link', 5 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function slik_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #1', 'slik' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'slik' ),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #2', 'slik' ),
				'id'          => 'sidebar-2',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'slik' ),
			)
		)
	);

}

add_action( 'widgets_init', 'slik_sidebar_registration' );



if ( version_compare($GLOBALS['wp_version'], '5.0-beta', '>') ) {
    // WP > 5 beta
    add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
} else {
    // WP < 5 beta
    add_filter( 'gutenberg_can_edit_post_type', '__return_false' );
}


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Subscription Plan',
		'menu_title'	=> 'Subscription Plan',
		'menu_slug' 	=> 'subscriptions-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}

function hide_admin_bar_from_front_end(){
  if (is_blog_admin()) {
    return true;
  }
  return false;
}
add_filter( 'show_admin_bar', 'hide_admin_bar_from_front_end' );



//checkemailaddress
add_action("wp_ajax_check_email_address", "check_email_address");
add_action( 'wp_ajax_nopriv_check_email_address', 'check_email_address' );

function check_email_address(){
	$email = $_POST['emailaddress'];
	$exists = email_exists( $email );
	if ( $exists ) {
	    echo 1;
	} else {
	    echo 0;
	}

	wp_die();
}

//check_postcode functions.

add_action("wp_ajax_check_postcode", "slik_check_postcode");
add_action( 'wp_ajax_nopriv_check_postcode', 'slik_check_postcode' );

function slik_check_postcode(){
	$postcode    = $_POST['postcode'];
	$pincodelist = get_field('Postcodes','option');
	if(!empty($pincodelist)){
		$pincode = array();
		foreach ($pincodelist as $key => $value) {
			# code...
			$pincode[] = $value['postcode'];
		}
		//print_r($pincode);	
		if (in_array($postcode, $pincode)){
			echo "yes";
		}else{
			echo "no";
		}
	}
	wp_die();
}

add_action("wp_ajax_add_subscription_plan", "slik_add_subscription_plan");
add_action( 'wp_ajax_nopriv_add_subscription_plan', 'slik_add_subscription_plan' );
function slik_add_subscription_plan(){
	$bedroomsvalue  =  sanitize_text_field($_POST['bedroomsvalue']);
	$bathroomsvalue = (int) sanitize_text_field($_POST['bathroomsvalue']);
	$fixed_fee          = (int) get_field('fixed_fee','option');

	if($bedroomsvalue && $bathroomsvalue){
		if($bedroomsvalue == 'Studio'){
			$studiovalue    = get_field('studio_price','option');
			//echo "Studio";
			$bedroomsvalue  = (int) $studiovalue;
		}else{
			$bedroomsvalue  = (int) get_field('beadroom_price','option') * $bedroomsvalue;
			
		}
		$bathroomsvalue = get_field('bathroom_price','option') * $bathroomsvalue;
	}
	
	?>
	<p>
	  Select your subscription plan
	</p>
	<div class="subscription-plan" >
	  <div class="row " >
	  	<?php
			// Check rows exists.
			if( have_rows('add_subscriptions','option') ):
			$count = 0;	
			// Loop through rows.
			while( have_rows('add_subscriptions','option') ) : the_row();
			// Load sub field value.
			$title        		= get_sub_field('Title');
			$price        		= get_sub_field('Price');
			$clean_price		= get_sub_field('clean_price');
			$descriptions 	    = get_sub_field('descriptions');
			$subscriptions_type = get_sub_field('subscriptions_type');
			$home_plan 			= (int) get_sub_field('home_plan');

			// Do something...
			if($count == 0){ 
					$class  =  "selected"; 	
				    $btntxt = "Selected";
				    $btntclass   = "next";
				    $btntclass1   = "active";
			}else{
					$class =  ""; 	
					$btntxt = "Select";
					$btntclass   = "back";
					$btntclass1 = '';
			}

			
			$fixecost   = $fixed_fee;
			$totalvalue = $bedroomsvalue+$bathroomsvalue+$fixecost;
			$clean_price = $totalvalue;

			if($home_plan === 4){
				$totalvalue = round($totalvalue * 52/12);
			}
			if($home_plan === 2){
				$totalvalue = round($totalvalue * 26/12);
			} 
			
			?>
			<div class="col-sm-6">
			      <div class="subscription-plan-inner <?php echo $class; ?>">
			        <h5><?php echo $title; ?></h5>
			        <div class="subscription-plan-info">
			          <input type="hidden" name="plan-title" class="plan-title <?php echo $btntclass1; ?>" value="<?php echo $title;  ?>">	
			          <input type="hidden" value="<?php echo $totalvalue; ?>" data-ptype="<?php echo $subscriptions_type; ?>" data-payment="month" name="subscription-plan" class="subscription-plan active" >
			          <?php echo $descriptions; ?>	
			          <div class="price">
			            <h6>
			              £<?php echo $totalvalue; ?> <span>/mo</span>
			          </h6>
			          <?php if($clean_price){ 
								if (is_float($clean_price)){
			          	?>
			          <span>£<?php echo number_format((float)$clean_price, 2, '.', ''); ?> per clean</span>
			          			<?php }else{ ?>		
			          <span>£<?php echo $clean_price; ?> per clean</span>
			          <?php } } ?>
			          </div>
			          <div class="button-group">
			            <button class="btn  plan-select <?php echo $btntclass; ?>"><?php echo $btntxt; ?></button>
			          </div>
			      	</div>
			      </div>
			    </div>
			<?php
		    $count ++;
			// End loop.
			endwhile;

			// No value.
			else :
			// Do something...
			endif;
	  	?>
	  </div>
	</div>

	  <div class="button-group mt-md-5 pt-md-5">
	    <button type="submit"  class="btn back prevthird">Back</button>
	    <button type="submit" class="btn next nextbuttonfour">Next</button>
	  </div>
	<?php
	wp_die();
}	
//checkemailaddress
add_action("wp_ajax_update_user_filed", "slik_update_user_filed");
add_action( 'wp_ajax_nopriv_update_user_filed', 'slik_update_user_filed' );
function slik_update_user_filed(){
	$fullname      			= $_POST['fullname'];
	$emailaddress         	= $_POST['email'];
	$streetaddress 			= $_POST['streetaddress'];
	$homedescriptions  	    = $_POST['homedescriptions'];
	$subscription  	  		= $_POST['subscription'];
	$howltp  	   			= $_POST['howltp'];
	$whereyouleavek  	    = $_POST['whereyouleavek'];
	session_start();
	$_SESSION["fullname"] 		   = $fullname;
	$_SESSION["emailaddress"] 	   = $emailaddress;
	$_SESSION["streetaddress"]     = $streetaddress;
	$_SESSION["subscriptionptype"] = $subscription;
	$_SESSION["howltp"]            = $howltp;
	$_SESSION["whereyouleavekey"]  = $whereyouleavek;
	$_SESSION["homedescritions"]   = $homedescriptions;
	wp_die();
}

//Add postcode in post code 
add_action("wp_ajax_add_postcode", "slik_add_postcode");
add_action( 'wp_ajax_nopriv_add_postcode', 'slik_add_postcode' );

function slik_add_postcode(){
	    global $wpdb;
	   // session_destroy();
	    session_start();
	    session_unset();
	    $_SESSION["stepsno"] = 2;

		$fullname  			= sanitize_text_field( $_POST['fullname'] );
		$emailaddress 		= sanitize_text_field( $_POST['emailaddress'] );
		$userpasssword 		= sanitize_text_field( $_POST['password'] );
		$postcode  			= sanitize_text_field( $_POST['postcode'] );
		$table = $wpdb->prefix.'postcode';
	    $datecreated 		= date('Y-m-d H:i:s');
		$data = array('Fullname'=>$fullname,'email'=>$emailaddress,'postcode' =>$postcode, 'date' =>$datecreated);
		$format = array('%s','%s','%s','%s');
		$insert_id =$wpdb->insert($table,$data,$format);
		if($insert_id){
			$lastid = $wpdb->insert_id;
			echo "yes";
		}else{
			echo "error";
		}

	//send mail to admin
	//wp_mail('','')	
	wp_die();
}

//Submit signup process task
add_action("wp_ajax_submit_join_process", "slik_submit_join_process");
add_action( 'wp_ajax_nopriv_submit_join_process', 'slik_submit_join_process' );
function slik_submit_join_process(){

$firstname  		= sanitize_text_field( $_POST['firstname'] );
$emailaddress 		= sanitize_text_field( $_POST['emailaddress'] );
$userpasssword 		= sanitize_text_field( $_POST['userpasssword'] );
$postcode  			= sanitize_text_field( $_POST['postcode'] );
$housenumber 		= sanitize_text_field( $_POST['housenumber'] );
$streetaddress		= sanitize_text_field( $_POST['streetaddress'] );
$bedroomsvalue 		= sanitize_text_field( $_POST['bedroomsvalue'] );
$bathroomsvalue 	= sanitize_text_field( $_POST['bathroomsvalue'] );
$subscriptionplan 	= sanitize_text_field( $_POST['subscriptionplan'] );
$subscriptionptype 	= sanitize_text_field( $_POST['subscriptionptype'] );
$paymentmode 		= sanitize_text_field( $_POST['paymentmode'] );
$howltp 			= sanitize_text_field( $_POST['howltp'] );
$whichday 			= sanitize_text_field( $_POST['whichday'] );
$whichtime 			= sanitize_text_field( $_POST['whattime'] );
$whereyouleavekey 	= sanitize_text_field( $_POST['whereyouleavekey'] );
$homedescritions 	= $bedroomsvalue.' bedrooms '.$bathroomsvalue.' bathrooms';


session_start();
$_SESSION["fullname"] 		  = $firstname;
$_SESSION["emailaddress"] 	  = $emailaddress;
$_SESSION["userpasssword"]    = $userpasssword ;
$_SESSION["postcode"] 		  = $postcode ;
$_SESSION["housenumber"] 	  = $housenumber;
$_SESSION["streetaddress"]    = $streetaddress;
$_SESSION["fulladdress"]      = $housenumber.' '.$streetaddress;
$_SESSION["bedroomsvalue"]    = $bedroomsvalue;
$_SESSION["bathroomsvalue"]   = $bathroomsvalue;
$_SESSION["subscriptionplan"] = $subscriptionplan;
$_SESSION["subscriptionptype"] = $subscriptionptype;
$_SESSION["paymentmode"] 	   = $paymentmode;
$_SESSION["howltp"]            = $howltp;
$_SESSION["whichday"]          = $whichday;
$_SESSION["whattime"]          = $whichtime;

if($hwltp == 'I’m flexible'){
	$_SESSION["howltp"]            = $howltp;
}else{
	$howltp            			   = $whichday.', '.$whichtime;
	$_SESSION["howltp"]            = $howltp;
}
//exit();
$_SESSION["whereyouleavekey"]  = $whereyouleavekey;
$_SESSION["homedescritions"]   = $bedroomsvalue.' bedrooms, '.$bathroomsvalue.' bathrooms';

// Storing session data
// $_SESSION["firstname"] = "Peter";
// $_SESSION["lastname"] = "Parker";
// $user_id   = wp_create_user( trim($firstname), $userpasssword, $emailaddress );
// update_user_meta( $user_id, 'hc_fullname',$firstname, true );
// update_user_meta( $user_id, 'hc_postcode',$postcode, true );
// update_user_meta( $user_id, 'hc_housenumber',$housenumber, true );
// update_user_meta( $user_id, 'hc_streetaddress',$streetaddress, true );
// update_user_meta( $user_id, 'hc_bedroomsvalue',$bedroomsvalue, true );
// update_user_meta( $user_id, 'hc_bathroomsvalue',$bathroomsvalue, true );
// update_user_meta( $user_id, 'hc_bathroomsvalue',$bathroomsvalue, true );
// update_user_meta( $user_id, 'hc_subscriptionplan',$subscriptionplan, true );
// update_user_meta( $user_id, 'hc_subscriptionptype',$subscriptionptype, true );
// update_user_meta( $user_id, 'hc_paymentmode',$paymentmode, true );
// update_user_meta( $user_id, 'hc_howltp',$howltp, true );
// update_user_meta( $user_id, 'hc_whichday',$whichday, true );
// update_user_meta( $user_id, 'hc_whattime',$whattime, true );
// update_user_meta( $user_id, 'hc_whereyouleavekey',$whereyouleavekey, true );
//$homedescritions = $bedroomsvalue.' bedrooms '.$bathroomsvalue.' bathrooms';
// update_user_meta( $user_id, 'hc_homedescritions',$homedescritions, true );

// $single = true;
// $hc_fullname = get_user_meta( $user_id,'hc_fullname', $single ); 
// $streetaddress = get_user_meta( $user_id,'hc_streetaddress', $single ); 
// $bedroomsvalue = get_user_meta( $user_id,'hc_bedroomsvalue', $single ); 
// $bathroomsvalue = get_user_meta( $user_id,'hc_bathroomsvalue', $single ); 
// $subscriptionptype = get_user_meta( $user_id,'hc_subscriptionptype', $single ); 
// $howltp = get_user_meta( $user_id,'hc_howltp', $single ); 
// $whereyouleavekey = get_user_meta( $user_id,'hc_whereyouleavekey', $single ); 

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
?>


			<p>
              Got it! Please check your details below
            </p>
            <input type="hidden" name="user-id" class="user-id" value="<?php echo $user_id;  ?>">
            <div class="table-responsive account-overview">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th>Name</th>
                    <td id="full-name" class="full-name"><input type="hidden" value="<?php echo $firstname; ?>" class="full-name-input form-control" placeholder="Your name">
                    	<span><?php echo $firstname ?></span></td>
                    <td><a data-id="full-name" class="full-name-edit edit-button" href="javascript:void(0);">Edit</a></td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td ><input type="hidden" value="<?php echo $emailaddress; ?>" class="email-input form-control" placeholder="Email"><span><?php echo $emailaddress; ?></span></td>
                    <td><a  data-id="email-address" class="email-address edit-button" href="javascript:void(0);">Edit</a></td>
                  </tr>
                  <tr>
                    <th>Address</th>
                    <td id="street-address" class="street-address"><input type="hidden" value="<?php echo $streetaddress; ?>" class="Street-address form-control " placeholder="Street Address"><span><?php echo $streetaddress; ?></span></td>
                    <td><a  data-id="street-address" class="street-address-edit edit-button" href="javascript:void(0);">Edit</a></td>
                  </tr>
                  <tr>
                    <th>Home desc.</th>
                    <td id="home-descriptions" class="home-descriptions"><input type="hidden" value="<?php echo $bedroomsvalue; ?> bedrooms; <?php echo $bathroomsvalue; ?> bathrooms" class="homedesc-input form-control" placeholder="Home description"><span><?php echo $bedroomsvalue; ?> bedrooms; <?php echo $bathroomsvalue; ?> bathrooms</span></td>
                    <td><a  data-id="home-descriptions" class="edit-button home-descriptions-edit" href="javascript:void(0);">Edit</a></td>
                  </tr>
                  <tr>
                    <th>Subscription</th>
                    <td id="home-subscriptions" class="home-subscriptions"><input type="hidden" value="<?php echo $subscriptionptype; ?>" class="subscriptionp-type form-control" placeholder="Subscription type"><span><?php echo $subscriptionptype; ?></span></td>
                    <td><a data-id="home-subscriptions" class="edit-button home-subscriptions-edit"  href="javascript:void(0);">Edit</a></td>
                  </tr>
                  <tr>
                    <th>Day/time</th>
                    <td id="how-to-help" class="how-to-help"><input type="hidden" value="<?php echo $howltp; ?>" class="howltp form-control " ><span><?php echo $howltp; ?></span></td>
                    <td><a data-id="how-to-help" class="edit-button how-to-help-edit" href="javascript:void(0);">Edit</a></td>
                  </tr>
                  <tr>
                    <th>Keys</th>
                    <td id="whereyouleavekey" class="whereyouleavekey"><input type="hidden" value="<?php echo $whereyouleavekey; ?>" class="whereyou-leavekey form-control" ><span><?php echo $whereyouleavekey;  ?></span></td>
                    <td><a data-id="whereyouleavekey" class="whereyouleavekey  edit-button" href="javascript:void(0);">Edit</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          <div class="button-group mt-md-5">
            <button class="btn nextbuttonseven ">Continue to payment</button>
          </div>
<?php
wp_die();
}


/**
 * WordPress function for redirecting users on login based on user role
 */
function slik_login_redirect( $url, $request, $user ) {
    if ( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
        if ( $user->has_cap( 'administrator' ) ) {
            $url = admin_url();
        } else {
            $url = home_url( '/my-account/' );
        }
    }
    return $url;
}
 
add_filter( 'login_redirect', 'slik_login_redirect', 10, 3 );


// Redirect Login page if not login for account page.
add_action( 'template_redirect', 'redirect_if_user_not_logged_in' );

function redirect_if_user_not_logged_in() {

	if ( is_page(142) && ! is_user_logged_in() ) { //example can be is_page(23) where 23 is page ID
		$url = home_url( '/login' );
		wp_redirect($url); 
 
     exit;// never forget this exit since its very important for the wp_redirect() to have the exit / die
   
   }
   
}

//Update Myaccount Sections.
add_action("wp_ajax_update_user_profile", "slik_update_user_profile");
add_action( 'wp_ajax_nopriv_update_user_profile', 'slik_update_user_profile' );
function slik_update_user_profile(){

	$fullname      		    = sanitize_text_field($_POST['fullname']);
	$emailaddress         	= sanitize_text_field($_POST['email']);
	$fulladdress 			= sanitize_text_field($_POST['address']);
	$hc_homedescritions  	= sanitize_text_field($_POST['homedescriptions']);
	$subscription  	  		= sanitize_text_field($_POST['subscription']);
	$howltp  	   			= sanitize_text_field($_POST['howltp']);
	$whereyouleavek  	    = sanitize_text_field($_POST['whereyouleavek']);
	$bathroomsvalue  	    = sanitize_text_field($_POST['bathroomsvalue']);
	$bedroomsvalue  	    = sanitize_text_field($_POST['bedroomsvalue']);
	$subscriptionptype      = sanitize_text_field($_POST['subscriptionptype']);
	$user_id    			= get_current_user_id();
	update_user_meta( $user_id, 'hc_fullname',$fullname, false );
	update_user_meta( $user_id, 'hc_homedescritions',$hc_homedescritions, false );
	update_user_meta( $user_id, 'hc_subscriptionptype',$subscription, false );
	update_user_meta( $user_id, 'hc_howltp',$howltp, false );
	update_user_meta( $user_id, 'hc_whereyouleavekey',$whereyouleavek, false );
	update_user_meta( $user_id, 'hc_bedroomsvalue',$bedroomsvalue, false );
	update_user_meta( $user_id, 'hc_bathroomsvalue',$bathroomsvalue, false );
	update_user_meta( $user_id, 'hc_subscriptionptype',$subscriptionptype, false );
	
	if (isset( $_POST['email'])) {
    // check if user is really updating the value
    if ($user_email != $_POST['email']) {       
        // check if email is free to use
        if (email_exists( $_POST['email'] )){
            // Email exists, do not update value.
            // Maybe output a warning.
        } else {
            $args = array(
                'ID'         => $user_id,
                'user_email' => esc_attr( $_POST['email'] )
            );            
        	wp_update_user( $args );
	       }   
	   }
	} 

	wp_die();
}

//Admin Login page logo change code.
add_action( 'login_enqueue_scripts', 'themeslug_enqueue_style', 10 );
function themeslug_enqueue_style() { ?>
<style type="text/css">
	#login h1 a,.login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png);
			height:65px;
			width:auto;
			background-repeat: no-repeat;
			padding-bottom: 30px;
	}
</style>
<?php }

// changing the logo link from wordpress.org to your site
function mb_login_url() {  return home_url(); }
add_filter( 'login_headerurl', 'mb_login_url' );

// changing the alt text on the logo to show your site name
function mb_login_title() { return get_option( 'blogname' ); }
add_filter( 'login_headertitle', 'mb_login_title' );


//Stripe Payment Processing actions.
function slik_handle_stripe_form() {

$currency = "EUR";  
//session_start();
// This is where you will control your form after it is submitted, you have access to $_POST here.
define('STRIPE_API_KEY', 'sk_test_51JT1PhJQoyEaQViihNcr4X2TLq8oyZcwD9WK1CJ672xxmMcZp8BumsSaApid3SGHMhwNFMUsqr5KuLco3GH6erkM00BzpFg2z0'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51JT1PhJQoyEaQViitjG8oiy69oPOwa1Mt8eVHvj7b1IrvnViVFDFD3VNM7M7Qkcn5NVVtRPXE3d7ddoPp3MJrdwW00FQMBvHkP');
// Get user ID from current SESSION 
 
$payment_id = $statusMsg = $api_error = ''; 
$ordStatus  = 'error'; 

// Check whether stripe token is not empty 
if(!empty($_POST['subscr_plan_amount']) && !empty($_POST['stripeToken'])){ 

    // Retrieve stripe token and user info from the submitted form data 
    $token  		= sanitize_text_field($_POST['stripeToken']); 
    $name 		    = sanitize_text_field($_POST['name']); 
    $email          = sanitize_text_field($_POST['email']); 
     
    // Plan info 
	// $planID   = $_POST['subscr_plan']; 
	// $planInfo = $plans[$planID];
	$planName      = sanitize_text_field($_POST['subscr_plan_name']); 
	$freqName      = sanitize_text_field($_POST['subscr_frq_name']);

	if($freqName == 1){
		$freqName = 'Once'; 
	}
	if($freqName == 2){
		$freqName = 'Weekly'; 
	}
	if($freqName == 3){
		$freqName = 'Every Other Week'; 
	}
	if($freqName == 4){
		$freqName = 'Monthly';
	}
	$firstpaymentname = $planName.'('.$freqName.')';

	$planPrice     = sanitize_text_field($_POST['subscr_plan_amount']);
	$planInterval  = sanitize_text_field($_POST['subscr_plan_type']); 

    // Include Stripe PHP library 
    require_once get_template_directory() . '/stripe-php/init.php';
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
     
    // Add customer to stripe 
		try {  
			$customer = \Stripe\Customer::create(array( 
		    'email' => $email, 
		    'name'  =>$name,
		    'source'  => $token 
			)); 
		}catch(Exception $e) {  
			$api_error = $e->getMessage();  
		} 

		print_r($api_error);
    if($freqName  == 'Once'){
    // Set API key 

	    $stripe = new \Stripe\StripeClient(STRIPE_API_KEY);
	

        //$result = $charge->create($cardDetailsAry);
      
		try {  
			$result = $stripe->charges->create([
		'amount' => $planPrice*100,
		'customer' => $customer->id,
		'currency' => 'EUR',
		'description' => $firstpaymentname,
		'metadata' => array(
                'currentemail' => $email ,
                'order_id'     => rand(),
          )
		]);
		}catch(Exception $e) {  
			$api_error = $e->getMessage();  
		} 

        $amount 		= $result['amount'];
           
        if(!empty($result) && empty($api_error) ){
        	if($result['status'] == 'Succeeded'){
        		$status = 'active';	
        	}
        	$subscrID 				= ''; 
            $custID 				= $result['customer'];; 
            $planID 				= ''; 
            $planAmount 			= ($result['amount']/100); 
            $planCurrency 			= $result['currency']; 
            $planinterval 			= 'once'; 
            $planIntervalCount 		= ''; 
            $created 				= date("Y-m-d H:i:s"); 
            $current_period_start 	= ''; 
            $current_period_end 	= ''; 
            //$status 				= $result['status']; 
            $payment_method 		= 'Stripe'; 
             if ( is_user_logged_in() ) {
                   $userID                 = get_current_user_id();
                   $stype                  = 2;
                   $_SESSION['meessage-cancel'] = "Your ".$planName." Is Activated Now.";
            }
          
            global $wpdb;
            // Insert transaction data into the database 
           	$table = $wpdb->prefix.'user_subscriptions';
            $sql   = "INSERT INTO $table(user_id,subscriptions_type,payment_method,Item_name,item_frequency,stripe_subscription_id,stripe_customer_id,stripe_plan_id,plan_amount,plan_amount_currency,plan_interval,plan_interval_count,payer_email,created,plan_period_start,plan_period_end,status) VALUES('".$userID."','".$stype."','".$payment_method."','".$planName."','".$freqName."','".$subscrID."','".$custID."','".$planID."','".$planAmount."','".$planCurrency."','".$planinterval."','".$planIntervalCount."','".$email."','".$created."','".$current_period_start."','".$current_period_end."','".$status."')";

            $sqllast  = $wpdb->prepare($sql);
			$wpdb->query($sqllast);
         	wp_redirect(home_url().'/my-account');
		    
        }
       } 
    if(empty($api_error) && $customer){  
     
        // Convert price to cents 
        $priceCents = round($planPrice*100); 
     
        // Create a plan 
        try { 
            $plan = \Stripe\Plan::create(array( 
                "product" => [ 
                    "name" => $planName,
                    "unit_label"=>'Month', 
                    "statement_descriptor"=>$freqName, 
                ], 
                "amount" => $priceCents, 
                "currency" => $currency, 
                "interval" => $planInterval, 
                "interval_count" => 1 
            )); 
        }catch(Exception $e) { 
            $api_error = $e->getMessage(); 
        } 
         
        if(empty($api_error) && $plan){ 
            // Creates a new subscription 
            try { 
                $subscription = \Stripe\Subscription::create(array( 
                    "customer" => $customer->id, 
                    "items" => array( 
                        array( 
                            "plan" => $plan->id, 
                        ), 
                    ), 
                )); 
            }catch(Exception $e) { 
                $api_error = $e->getMessage(); 
            } 
           
            if(empty($api_error) && $subscription){ 
                // Retrieve subscription data 
                $subsData = $subscription->jsonSerialize(); 
         
                // Check whether the subscription activation is successful 
                if($subsData['status'] == 'active'){ 
                    // Subscription info 
                    if ( is_user_logged_in() ) {
                    	$userID                 = get_current_user_id();
                		$stype                  = 2;
                		$_SESSION['meessage-cancel'] = "Your ".$planName." Is Activated Now.";
                	}else{
                		 $userID                = 2;
                		 $stype                 = 1;
                	}

                	if(isset($_POST['subscription-main'])){
                		$stype                 = 1;	
                		$_SESSION['meessage-cancel'] = "Your Subscription Is Activate Now.";
                	}
                	
                    $subscrID 				= $subsData['id']; 
                    $custID 				= $subsData['customer']; 
                    $planID 				= $subsData['plan']['id']; 
                    $planAmount 			= ($subsData['plan']['amount']/100); 
                    $planCurrency 			= $subsData['plan']['currency']; 
                    $planinterval 			= $subsData['plan']['interval']; 
                    $planIntervalCount 		= $subsData['plan']['interval_count']; 
                    $created 				= date("Y-m-d H:i:s", $subsData['created']); 
                    $current_period_start 	= date("Y-m-d H:i:s", $subsData['current_period_start']); 
                    $current_period_end 	= date("Y-m-d H:i:s", $subsData['current_period_end']); 
                    $status 				= $subsData['status']; 
                    $payment_method 		= 'Stripe'; 
                  
                    global $wpdb;
                    // Insert transaction data into the database 
                   	$table = $wpdb->prefix.'user_subscriptions';
                    $sql   = "INSERT INTO $table(user_id,subscriptions_type,payment_method,Item_name,item_frequency,stripe_subscription_id,stripe_customer_id,stripe_plan_id,plan_amount,plan_amount_currency,plan_interval,plan_interval_count,payer_email,created,plan_period_start,plan_period_end,status) VALUES('".$userID."','".$stype."','".$payment_method."','".$planName."','".$freqName."','".$subscrID."','".$custID."','".$planID."','".$planAmount."','".$planCurrency."','".$planinterval."','".$planIntervalCount."','".$email."','".$created."','".$current_period_start."','".$current_period_end."','".$status."')"; 
                    // $insert = $db->query($sql);  
					$sqllast  = $wpdb->prepare($sql);
					$wpdb->query($sqllast);
                    // Update subscription id in the users table  
                    if($insert && !empty($userID)){  
                        $subscription_id = $db->insert_id;  
                     //   $update = $db->query("UPDATE users SET subscription_id = {$subscription_id} WHERE id = {$userID}");  
                    } 
                     
                    $ordStatus = 'success'; 
                    $_SESSION['payment-staus'] = 1;
                    $_SESSION['payment-mode']  = 'stripe';
                    $statusMsg = 'Your Subscription Payment has been Successful!';
                    if(!isset($_POST['page-locations'])){ 
                   	    wp_redirect(home_url().'/confirmations');
                    }else{	
                    	wp_redirect(home_url().'/my-account');
				    }	
                }else{ 
                    $statusMsg = "Subscription activation failed!"; 
                    $_SESSION['error-message'] = $statusMsg;
                } 
            }else{ 
                $statusMsg = "Subscription creation failed! ".$api_error; 
		        $_SESSION['error-message'] = $statusMsg;
            } 
        }else{ 
            $statusMsg = "Plan creation failed! ".$api_error;
            $_SESSION['error-message'] = $statusMsg; 
        } 
    }else{  
        $statusMsg = "Invalid card details! $api_error";  
         $_SESSION['error-message'] = $statusMsg;
    } 
}else{ 
    $statusMsg = "Error on form submission, please try again.";
    $_SESSION['error-message'] = $statusMsg; 
} 


	if(!empty($_SESSION['error-message'])){
		echo $_SESSION['error-message'];
		wp_redirect(home_url().'/failed');
	}
?>
<?php /* testing purpose code 
<div class="container">
    <div class="status">
        <h1 class="<?php echo $ordStatus; ?>"><?php echo $statusMsg; ?></h1>
        <?php if(!empty($subscrID)){ ?>
            <h4>Payment Information</h4>
            <p><b>Reference Number:</b> <?php echo $subscription_id; ?></p>
            <p><b>Transaction ID:</b> <?php echo $subscrID; ?></p>
            <p><b>Amount:</b> <?php echo $planAmount.' '.$planCurrency; ?></p>
            
            <h4>Subscription Information</h4>
            <p><b>Plan Name:</b> <?php echo $planName; ?></p>
            <p><b>Amount:</b> <?php echo $planPrice.' '.$currency; ?></p>
            <p><b>Plan Interval:</b> <?php echo $planInterval; ?></p>
            <p><b>Period Start:</b> <?php echo $current_period_start; ?></p>
            <p><b>Period End:</b> <?php echo $current_period_end; ?></p>
            <p><b>Status:</b> <?php echo $status; ?></p>
        <?php } ?>
    </div>
    <a href="index.php" class="btn-link">Back to Subscription Page</a>
</div>
*/ ?>

 <?php

}
// Use your hidden "action" field value when adding the actions.
add_action( 'admin_post_nopriv_add_stripe_form', 'slik_handle_stripe_form' );
add_action( 'admin_post_add_stripe_form', 'slik_handle_stripe_form' );
add_action( 'wp_ajax_add_stripe_form', 'slik_handle_stripe_form' );

add_action('init', 'start_session', 1);


add_action( 'wp_ajax_cancel_paypment', 'slik_cancel_paypment' );
add_action( 'wp_ajax_nopriv_cancel_paypment', 'slik_cancel_paypment' );

function slik_cancel_paypment(){
	session_start();
	$paymentid = $_POST['postid'];

	global $wpdb;
	$count = 0;
	$table_name     = $wpdb->prefix . "user_subscriptions";
	$paymenthistory = $wpdb->get_results( "SELECT * FROM $table_name 
	WHERE `id` =$paymentid");
	if(!empty($paymenthistory)){
	$paymentmethod 			    = $paymenthistory[0]->payment_method;
	if($paymentmethod  == 'Stripe'){
		$stripe_subscription_id = $paymenthistory[0]->stripe_subscription_id;

			// Include Stripe PHP library 
			require_once get_template_directory() . '/stripe-php/init.php';

			// Set API key 
			\Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
			$stripe = new \Stripe\StripeClient(
			    'sk_test_51JT1PhJQoyEaQViihNcr4X2TLq8oyZcwD9WK1CJ672xxmMcZp8BumsSaApid3SGHMhwNFMUsqr5KuLco3GH6erkM00BzpFg2z0'
			);
			$data =  $stripe->subscriptions->retrieve(
			$stripe_subscription_id,
			[]
			);  


			if($data['status'] != 'canceled'){

			// $stripe = new \Stripe\StripeClient(
			// 'sk_test_51JT1PhJQoyEaQViihNcr4X2TLq8oyZcwD9WK1CJ672xxmMcZp8BumsSaApid3SGHMhwNFMUsqr5KuLco3GH6erkM00BzpFg2z0'
			// );
				$res=    $stripe->subscriptions->cancel(
				$stripe_subscription_id,
				[]
				);
			
				if(!empty($res)){
					global $wpdb;
					if($paymentid){
					//9$_GET['userid'] = $user_id; 
					$sql = "UPDATE `hc_user_subscriptions` SET `status` = 'canceled' WHERE `hc_user_subscriptions`.`id` = '".$paymentid."'"; 
					$sqllast  = $wpdb->prepare($sql);
					$wpdb->query($sqllast);
					}
					echo "Your Membership Is Cancelled Now.";
					$_SESSION['meessage-cancel'] = "Your Membership Is Cancelled Now.";

				}else{
					echo "Error";
				}

			}else{
	 				global $wpdb;
					if($paymentid){
					//9$_GET['userid'] = $user_id; 
					$sql = "UPDATE `hc_user_subscriptions` SET `status` = 'canceled' WHERE `hc_user_subscriptions`.`id` = '".$paymentid."'"; 
					$sqllast  = $wpdb->prepare($sql);
					$wpdb->query($sqllast);
					}
				echo "Your Membership Is Cancelled Now.";
				$_SESSION['meessage-cancel'] = "Your Membership Is Cancelled Now.";

			}
	}else{

		$paypalid = $paymenthistory[0]->stripe_customer_id;	
		$resd 	  = change_subscription_status( $paypalid, 'Cancel' );

		// echo "<pre>";
		// print_r($resd);
		// echo "</pre>";

		if ($resd['ACK'] == 'Failure'){
			echo $resd['L_SHORTMESSAGE0'];
			$_SESSION['meessage-cancel'] = $resd['L_SHORTMESSAGE0'];
			global $wpdb;
			$sql = "UPDATE `hc_user_subscriptions` SET `status` = 'canceled' WHERE `hc_user_subscriptions`.`id` = '".$paymentid."'"; 
			$sqllast  = $wpdb->prepare($sql);
			$wpdb->query($sqllast);

		}else{
			global $wpdb;
			$sql = "UPDATE `hc_user_subscriptions` SET `status` = 'canceled' WHERE `hc_user_subscriptions`.`id` = '".$paymentid."'"; 
			$sqllast  = $wpdb->prepare($sql);
			$wpdb->query($sqllast);
			echo 'Your Membership Is Cancelled Now';
			$_SESSION['meessage-cancel'] = "Your Membership Is Cancelled Now.";
		}
	}

	}
	wp_die();
}



function start_session() {
	if(!session_id()) {
		session_start();
	}
	//$_SESSION["payment-staus"] = 2;
}

//Paypal payment processing code.
 add_action('wp_paypal_ipn_processed','slik_handle_paypal_form',10, 1);
 function 	slik_handle_paypal_form($ipn_response){
 	if(!session_id()) {
		session_start();
	}
	if (isset($ipn_response['payment_status'])) {
            $payment_status = sanitize_text_field($ipn_response['payment_status']);
            wp_paypal_debug_log("Payment Statusssss - " . $ipn_response['order_id'], true);
            wp_paypal_debug_log("Payment Statusssss - " . $_SESSION['emailaddress'], true);
  	}
   setcookie('my_cookie11', 'some default value', strtotime('+1 day'));
   setcookie('my_cookie112', 'some default value', strtotime('+1 day'));
   setcookie('my_cookie121', 'some default value', strtotime('+1 day'));
   setcookie('my_cookie121', 'some default value', strtotime('+1 day'));
// Set or Reset the cookie
	setcookie('wpb_visit_time',  $visit_time, time()+31556926);
  	$_SESSION["payment-staus1"] = 13;
	$_SESSION["payment-staus2"] = 13;
	$_SESSION["payment-staus4"] = 2;


	wp_paypal_debug_log("Payment Statusssss - " . $payment_status, true);

 }

//Show paypal button.
add_action("wp_ajax_show_payment_informations", "slik_show_payment_informations");
add_action( "wp_ajax_nopriv_show_payment_informations","slik_show_payment_informations" );
function slik_show_payment_informations(){

	$amount =  sanitize_text_field( $_POST['subscriptionplan'] );
	$stype  =  sanitize_text_field( $_POST['subscriptionptype'] );
	$email  =  sanitize_text_field( $_POST['email'] );
	$planfretitle  =  sanitize_text_field( $_POST['planfretitle'] );
	$paymentname = "Home Clean Package";
	?>
	<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
			<input name="charset" type="hidden" value="utf-8" />
			<input name="cmd" type="hidden" value="_xclick-subscriptions" />
			<input name="business" type="hidden" value="sb-7kbjh6208971@business.example.com" />
			<input name="item_name" type="hidden" value="<?php echo $paymentname; ?>" />
			<input name="item_number" type="hidden" value="<?php echo $planfretitle ; ?>" />
			<input name="a3" type="hidden" value="<?php echo $amount; ?>" />
			<input name="p3" type="hidden" value="1" />
			<input name="t3" type="hidden" value="M" />
			<input name="src" type="hidden" value="1" />
			<input name="custom" type="hidden" value="<?php echo $email; ?>" />
			<input name="currency_code" type="hidden" value="EUR" />
			<input name="no_note" type="hidden" value="1" />
			<input name="return" type="hidden" value="http://205.134.254.135/~projectdemoserve/homeservice/confirmations/?res=complete" />
			<input name="notify_url" type="hidden" value="http://205.134.254.135/~projectdemoserve/homeservice/?wp_paypal_ipn=1" />
			<input name="bn" type="hidden" value="WPPayPal_Subscribe_WPS_US" />
			<input name="submit" src="http://205.134.254.135/~projectdemoserve/homeservice/wp-content/plugins/wp-paypal/images/subscribe.png" type="image" />
		</form>
	<?php

	//echo do_shortcode( '[wp_paypal  button="subscribe" name="Home Clean Package" custom="'.$email.'" src="1" a3="'.$amount.'" p3="1" t3="M" src="https://wordpress.org/plugins/wp-paypal/1" return="http://205.134.254.135/~projectdemoserve/homeservice/confirmations/?res=complete&id=100"]' );

	wp_die();
}


//Show paypal button.
add_action("wp_ajax_show_paypal_informations", "slik_show_paypal_informations");
add_action( "wp_ajax_nopriv_show_paypal_informations","slik_show_paypal_informations" );
function slik_show_paypal_informations(){

	$amount 		  =  500;
	$postid  		  =  sanitize_text_field( $_POST['postid'] );

	$frequencymethod  =  sanitize_text_field( $_POST['frequencymethod'] );
	$paymentname      =  sanitize_text_field( $_POST['paymentname'] );
	$postid       = sanitize_text_field( $_POST['postid'] );
	$title        = get_the_title($postid);
	$cleanprice   = get_field('per_clean_price', $postid );
	$cleanpricetotal = $cleanprice *4;
	$ptype = 'Monthly';
	if(isset($_POST['frequencymethod'])){
		$frequencymethod       = sanitize_text_field( $_POST['frequencymethod'] );
		if($frequencymethod == '1'){
			$cleanpricetotal = $cleanprice * 1; 
		}

		if($frequencymethod == 2){
			$cleanpricetotal = $cleanprice * 4;	
		}
		if($frequencymethod == 3){
			$cleanpricetotal = $cleanprice * 2;	
		}
		if($frequencymethod == 4){
			$cleanpricetotal = $cleanprice * 1;
		}
	}
	$userid    = get_current_user_id();
	$user_info = get_userdata($userid);
	$display_name = $user_info->display_name;
	$emailaddress = $user_info->user_email;
	if($frequencymethod == '1'){

		?>
		<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
			<input name="charset" type="hidden" value="utf-8" />
			<input name="cmd" type="hidden" value="_xclick" />
			<input name="business" type="hidden" value="sb-7kbjh6208971@business.example.com" />
			<input name="item_name" type="hidden" value="<?php echo $paymentname; ?>" />
			<input name="item_number" type="hidden" value="<?php echo $frequencymethod; ?>" />
			<input name="custom" type="hidden" value="<?php echo $emailaddress; ?>" />
			<input name="currency_code" type="hidden" value="EUR" />
			<input type="hidden" name="amount" value="<?php echo $cleanpricetotal; ?>">
			<input type="hidden" name="quantity" value="1">
			<input name="no_note" type="hidden" value="1" />
			<input name="return" type="hidden" value="http://205.134.254.135/~projectdemoserve/homeservice/my-account/?res=complete" />
			<input name="notify_url" type="hidden" value="http://205.134.254.135/~projectdemoserve/homeservice/?wp_paypal_ipn=1" />
			<input name="bn" type="hidden" value="WPPayPal_Subscribe_WPS_US" />
			<input name="submit" src="http://205.134.254.135/~projectdemoserve/homeservice/wp-content/plugins/wp-paypal/images/subscribe.png" type="image" />
		</form>
		<?php
	//echo do_shortcode( '[wp_paypal button="subscribe" item_number="'.$frequencymethod.'" name="'.$paymentname.'" a3="'.$cleanpricetotal.'" p3="1" t3="M" src="1" return="http://205.134.254.135/~projectdemoserve/homeservice/my-account/?res=complete&id=$userid"]' );

	}else{

	?>
	<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
			<input name="charset" type="hidden" value="utf-8" />
			<input name="cmd" type="hidden" value="_xclick-subscriptions" />
			<input name="business" type="hidden" value="sb-7kbjh6208971@business.example.com" />
			<input name="item_name" type="hidden" value="<?php echo $paymentname; ?>" />
			<input name="item_number" type="hidden" value="<?php echo $frequencymethod; ?>" />
			<input name="a3" type="hidden" value="<?php echo $cleanpricetotal; ?>" />
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
	<?php	
		//echo do_shortcode( '[wp_paypal button="subscribe" item_number="'.$frequencymethod.'" name="'.$paymentname.'" a3="'.$cleanpricetotal.'" p3="1" t3="M" src="1" return="http://205.134.254.135/~projectdemoserve/homeservice/my-account/?res=complete&id=$userid"]' );	
	}

	wp_die();
}

add_action("wp_ajax_show_pament_form", "slik_show_pament_form");
add_action( "wp_ajax_nopriv_show_pament_form","slik_show_pament_form" );
function slik_show_pament_form(){

	$postid       = sanitize_text_field( $_POST['postid'] );
	$title        = get_the_title($postid);
	$content_post = get_post($postid);
	$content 	  = $content_post->post_content;
	$content 	  = apply_filters('the_content', $content);
	$cleanprice   = get_field('per_clean_price', $postid );
	$cleanpricetotal = $cleanprice *4;
	$ptype = 'Monthly';
	if(isset($_POST['frequencymethod'])){
		$frequencymethod       = sanitize_text_field( $_POST['frequencymethod'] );
		if($frequencymethod == '1'){
			$cleanpricetotal = $cleanprice * 1; 
		}

		if($frequencymethod == 2){
			$cleanpricetotal = $cleanprice * 4;	
		}
		if($frequencymethod == 3){
			$cleanpricetotal = $cleanprice * 2;	
		}
		if($frequencymethod == 4){
			$cleanpricetotal = $cleanprice * 1;
		}
	}

 /*           <option <?php if($frequencymethod == 1){ echo "selected"; } ?> value="1">Once</option>
*/ ?>
	    <h3><?php echo $title; ?></h3>
        <p><?php echo $content; ?></p>
        <select data-id="<?php echo $postid; ?>" class="change-frequency">
          <option  value="2">Select frequency</option>
          <option <?php if($frequencymethod == 1){ echo "selected"; } ?> value="1">Once</option>
          <option <?php if($frequencymethod == 2){ echo "selected"; } ?> value="2">Weekly</option>
          <option <?php if($frequencymethod == 3){ echo "selected"; } ?> value="3">Every Other Week</option>
          <option <?php if($frequencymethod == 4){ echo "selected"; } ?> value="4">Monthly</option>
        </select>
        <div class="clean-month">
          <ul>
            <li class="clean_price">
              <strong>£ <?php echo $cleanprice; ?></strong> per clean
            </li>
            <li class="clean_price_month">
              <strong>£ <?php echo $cleanpricetotal; ?></strong> per Month
            </li>
          </ul>
        </div>
        <input type="hidden" class="per-month-price" value="<?php echo $cleanpricetotal; ?>">
        <input type="hidden" class="addon-name" value="<?php echo $title; ?>" >
        <input type="hidden" class="paymnt-type" value="<?php echo $ptype; ?>" >
        <input type="hidden" class="frequencymethod" value="<?php echo $frequencymethod; ?>" >
	<?php

	wp_die();
}
/** 
 * create time range by CodexWorld
 *  
 * @param mixed $start start time, e.g., 7:30am or 7:30 
 * @param mixed $end   end time, e.g., 8:30pm or 20:30 
 * @param string $interval time intervals, 1 hour, 1 mins, 1 secs, etc.
 * @param string $format time format, e.g., 12 or 24
 */ 
function create_time_range($start, $end, $interval = '30 mins', $format = '12') {
    $startTime = strtotime($start); 
    $endTime   = strtotime($end);
    $returnTimeFormat = ($format == '12')?'g:i A':'G:i';

    $current   = time(); 
    $addTime   = strtotime('+'.$interval, $current); 
    $diff      = $addTime - $current;

    $times = array(); 
    while ($startTime < $endTime) { 
        $times[] = date($returnTimeFormat, $startTime); 
        $startTime += $diff; 
    } 
    $times[] = date($returnTimeFormat, $startTime); 
    return $times; 
}

function extra_profile_fields( $user ) { ?>
   
    <h3><?php _e('Home care User Details'); ?></h3>
    <table class="form-table">
    	<tr>
            <th><label for="gmail">Postcode</label></th>
            <td>
            <input type="text" readonly="readonly" name="hc_postcode" id="hc_postcode" value="<?php echo esc_attr( get_the_author_meta( 'hc_postcode', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
    	<tr>
            <th><label for="gmail">House Number</label></th>
            <td>
            <input readonly="readonly" type="text" name="hc_housenumber" id="hc_housenumber" value="<?php echo esc_attr( get_the_author_meta( 'hc_housenumber', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="gmail">Bedrooms</label></th>
            <td>
            <input readonly="readonly" type="text" name="hc_bedroomsvalue" id="hc_bedroomsvalue" value="<?php echo esc_attr( get_the_author_meta( 'hc_bedroomsvalue', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="yahoo">Bathrooms</label></th>
            <td>
            <input readonly="readonly" type="text" name="hc_bathroomsvalue" id="hc_bathroomsvalue" value="<?php echo esc_attr( get_the_author_meta( 'hc_bathroomsvalue', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
                <tr>
            <th><label for="yahoo">Which Day?</label></th>
            <td>
            <input readonly="readonly" type="text" name="hc_whattime" id="hc_whattime" value="<?php echo esc_attr( get_the_author_meta( 'hc_whattime', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
         <tr>
            <th><label for="yahoo">Which time?</label></th>
            <td>
            <input readonly="readonly" type="text" name="hc_whattime" id="hc_whattime" value="<?php echo esc_attr( get_the_author_meta( 'hc_whattime', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
         <tr>
            <th><label for="yahoo">Where you leave key?</label></th>
            <td>
            <input readonly="readonly" type="text" name="hc_whereyouleavekey" id="hc_whereyouleavekey" value="<?php echo esc_attr( get_the_author_meta( 'hc_whereyouleavekey', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
        
    </table>
<?php

}

// Then we hook the function to "show_user_profile" and "edit_user_profile"
add_action( 'show_user_profile', 'extra_profile_fields', 10 );
add_action( 'edit_user_profile', 'extra_profile_fields', 10 );


function save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    /* Edit the following lines according to your set fields */
    update_usermeta( $user_id, 'hc_bathroomsvalue', $_POST['hc_bathroomsvalue'] );
    update_usermeta( $user_id, 'hc_bathroomsvalue', $_POST['hc_bathroomsvalue'] );
    update_usermeta( $user_id, 'hc_postcode', $_POST['hc_postcode'] );
    update_usermeta( $user_id, 'hc_whereyouleavekey', $_POST['hc_whereyouleavekey'] );
    update_usermeta( $user_id, 'hc_housenumber', $_POST['hc_housenumber'] );
}

add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );


add_filter( 'login_url', 'my_login_page', 10, 3 );
function my_login_page( $login_url, $redirect, $force_reauth ) {
    $login_page = home_url( '/login/' );
    $login_url = $login_page;
    return $login_url;
}


add_filter('wp_mail_from_name', 'slik_mail_from_name');
function slik_mail_from_name($old) {
	$site_name = 'Casaclub';
	return $site_name;
}

add_filter( 'wp_mail_from', 'slik_mail_from_email' );
function slik_mail_from_email( $email ) {
	return 'info@casaclub.co.uk';
}


// function disable_password_change_email( $send, $user, $userdata ) {
//     return true;
// }
//add_filter( 'send_password_change_email', 'disable_password_change_email' );



/**
 * Register a custom menu page.
 */
function slik_register_my_custom_menu_page(){
    add_menu_page( 
        __( 'Payment History', 'textdomain' ),
        'Payment History',
        'manage_options',
        'paymenthistory',
        'slik_custom_menu_page',
        '',
        6
    ); 
}
add_action( 'admin_menu', 'slik_register_my_custom_menu_page' );
 
/**
 * Display a custom menu page
 */
function slik_custom_menu_page(){

    global $wpdb;
	$table_name     = $wpdb->prefix . "user_subscriptions";
	$paymenthistory = $wpdb->get_results( "SELECT * FROM $table_name   ORDER BY `id` DESC" );
	$count = 0;
    ?>
    <html>
    <head>
       <link rel="stylesheet" type="text/css"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
       	 <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <style type="text/css">
    	button#show-settings-link {
    		display: none;
		}
		input.btn.btn-success {
    		margin-left: 12px;
		}
    </style>
	<h2> <?php esc_html_e( 'Logs - Payment History', 'tax_calculator' ); ?></h2>

		<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Id</th>
                <th>Item Name</th>
                <th >Payment Method</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Customer id/token</th>
                <th>Price</th>
                <th>Start Time</th>
             	<th>End Time</th>
                <th>Status/Flag</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
        	<?php
        	 foreach ($paymenthistory as $value) {
                    # code...
                   $count++;
                   $userid          = $value->user_id;
                   $paymentmethod   = $value->payment_method;
                   if($paymentmethod  == 'paypal'){
                  	 $stripe_customer_id   = $value->stripe_subscription_id;
                   }else{
                   	$stripe_customer_id  = $value->stripe_customer_id;
                   }
                   $Item_name       = $value->Item_name;
                   $stripe_plan_id  = $value->stripe_plan_id;
                   $plan_amount     = $value->plan_amount;
                   $council_tax     = $value->council_tax;
                   $payer_email   	= $value->payer_email;
                   $created    		= $value->created;
                    $freqName       = $value->item_frequency;
					if($freqName == 1){
					$freqName = 'Once'; 
					}
					if($freqName == 2){
					$freqName = 'Weekly'; 
					}
					if($freqName == 3){
					$freqName = 'Every Other Week'; 
					}
					if($freqName == 4){
					$freqName = 'Monthly';
					}
                   if($freqName == 'Once'){
                   		$plan_period_start = '';
                   		$plan_period_end   = '';
               		}else{
               			$plan_period_start = $value->plan_period_start;
                   		$plan_period_end   = $value->plan_period_end;
               		}
                   $hc_fullname = get_user_meta( $userid,'hc_fullname', true ); 
				   $streetaddress = get_user_meta( $user_id,'hc_streetaddress',true); 
                   $label  			= $value->status;
                   $create_datetime = date("d F Y", strtotime($value->created)); 
                  // echo get_avatar( $userid );
                   ?>
		            <tr>
		            	<td><?php echo $count; ?></td>
		            	<td><a href="<?php echo site_url(); ?>/wp-admin/user-edit.php?user_id=<?php echo $userid; ?>"><?php echo $userid; ?></a></td>
		            	<td><?php echo $Item_name.'('.$freqName.')'; ?></td>
		                <td><?php echo $paymentmethod; ?></td>
		                <td><?php echo $payer_email; ?></td>
		                <td><?php echo $hc_fullname; ?></td>
		                <td><?php echo $stripe_customer_id; ?></td>
		                <td ><?php echo '£'.$plan_amount; ?></td>
		                <td ><?php echo $plan_period_start; ?></td>
		                <td ><?php echo $plan_period_end; ?></td>
		                <td ><?php echo ucfirst($label); ?></td>
		                <td ><?php echo $create_datetime; ?></td>
		             </tr>   

		      <?php   }
		         ?>    
 		</tbody>
        <tfoot>
        	<tr>
                <th>ID</th>
                <th>User Id</th>
                <th>Item Name</th>
                <th >Payment Method</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Customer id/token</th>
                <th>Price</th>
                <th>Start Time</th>
             	<th>End Time</th>
                <th>Status/Flag</th>
                <th>Created Date</th>
            </tr>
        </tfoot>

    </table>

         <script type="text/javascript">
        jQuery(document).ready(function ($) {
			jQuery('#example').dataTable({
		
			} );
       });
    </script>
<?php
       }


/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Addons', 'Post Type General Name', 'slik' ),
        'singular_name'       => _x( 'Addon', 'Post Type Singular Name', 'slik' ),
        'menu_name'           => __( 'Addons', 'slik' ),
        'parent_item_colon'   => __( 'Parent Addon', 'slik' ),
        'all_items'           => __( 'All Addons', 'slik' ),
        'view_item'           => __( 'View Addon', 'slik' ),
        'add_new_item'        => __( 'Add New Addon', 'slik' ),
        'add_new'             => __( 'Add New', 'slik' ),
        'edit_item'           => __( 'Edit Addon', 'slik' ),
        'update_item'         => __( 'Update Addon', 'slik' ),
        'search_items'        => __( 'Search Addon', 'slik' ),
        'not_found'           => __( 'Not Found', 'slik' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'slik' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'Addons', 'slik' ),
        'description'         => __( 'Addon news and reviews', 'slik' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor','author', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'catergorie' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'addons', $args );

    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Referral codes', 'Post Type General Name', 'slik' ),
        'singular_name'       => _x( 'Referral code', 'Post Type Singular Name', 'slik' ),
        'menu_name'           => __( 'Referral codes', 'slik' ),
        'parent_item_colon'   => __( 'Parent Referral code', 'slik' ),
        'all_items'           => __( 'All Referral codes', 'slik' ),
        'view_item'           => __( 'View Referral code', 'slik' ),
        'add_new_item'        => __( 'Add New Referral code', 'slik' ),
        'add_new'             => __( 'Add New', 'slik' ),
        'edit_item'           => __( 'Edit Referral code', 'slik' ),
        'update_item'         => __( 'Update Referral code', 'slik' ),
        'search_items'        => __( 'Search Referral code', 'slik' ),
        'not_found'           => __( 'Not Found', 'slik' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'slik' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'Referral codes', 'slik' ),
        'description'         => __( 'Referral code news and reviews', 'slik' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title','author', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'catergorie' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'referral_codes', $args );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );


function faba_addons_column_headers( $columns ) {

// creating custom column header data
$columns = array(
'cb'=>'<input type="checkbox" />',
'title'=>__('Addon Name'),
'per_clean_price'=>__('Price'),
'author'=>__('Author'),
'date'=>__('Date'),
);

// returning new columns
return $columns;

}
add_filter('manage_edit-addons_columns','faba_addons_column_headers');


add_filter('manage_edit-staff_columns','faba_staff_column_headers');
function faba_addons_column_data( $column, $post_id ) {
   // setup our return text
   $output = '';
   switch( $column ) {
      case 'per_clean_price':
         // get the custom email data
    
         $phone_number = get_field('per_clean_price', $post_id );
         $output .= $phone_number;
         break;
   }
   // echo the output
   echo $output;
}
add_filter('manage_addons_posts_custom_column','faba_addons_column_data',1,2);


// Manage Refferal code condtions here.
add_action("wp_ajax_check_referral_code", "slik_check_referral_code");
add_action( "wp_ajax_nopriv_check_referral_code","slik_check_referral_code" );
function slik_check_referral_code(){
	// echo "check referral codes";
	$post_title = $_POST['refferalcode'];
    global $user_ID, $wpdb;
    $post_id = post_exists( $post_title );
    if($post_id){
        $key_1_value = get_post_meta($post_id, 'user_limit', true );
    	$key_2_value = get_post_meta( $post_id, 'update_referral_cpde', true );
    	if($key_2_value){
    			$key_total_value = $key_2_value +1; 
		    	update_post_meta( $post_id, 'update_referral_cpde',$key_total_value);
    	}else{
    		update_post_meta( $post_id, 'update_referral_cpde',1);
    		$key_2_value = get_post_meta( $post_id, 'update_referral_cpde', true );
    	}
    	if($key_2_value >= $key_1_value){
    		echo "error";
    	}else{
    		echo "success";
    	}
    }else{
    	echo 'error';
    }
    wp_die();
}


// function cancel_subscription{
// 	// require_once 'stripe-php/init.php'; 
     
//  //    // Set API key 
//  //    \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
//  //    $stripe = new \Stripe\StripeClient(
//  //        'sk_test_51JT1PhJQoyEaQViihNcr4X2TLq8oyZcwD9WK1CJ672xxmMcZp8BumsSaApid3SGHMhwNFMUsqr5KuLco3GH6erkM00BzpFg2z0'
//  //    );

//  //    // $stripe = new \Stripe\StripeClient(
//  //    // 'sk_test_51JT1PhJQoyEaQViihNcr4X2TLq8oyZcwD9WK1CJ672xxmMcZp8BumsSaApid3SGHMhwNFMUsqr5KuLco3GH6erkM00BzpFg2z0'
//  //    // );
//  //    $stripe->subscriptions->cancel(
//  //    'sub_K7IIovlCkzWptI',
//  //    []
//  //    );

// }


function change_subscription_status( $profile_id, $action ) {
 
    $api_request = 'USER=' . urlencode( 'sb-7kbjh6208971_api1.business.example.com' )
                .  '&PWD=' . urlencode( 'A7DR5VDTJW2ZWBJB' )
                .  '&SIGNATURE=' . urlencode( 'Arjylf6u.jLyUu4E0IQfUIUcsBW2AnVkj8XJsXh8xB2Uc6LW4M.bDCXz' )
                .  '&VERSION=76.0'
                .  '&METHOD=ManageRecurringPaymentsProfileStatus'
                .  '&PROFILEID=' . urlencode( $profile_id )
                .  '&ACTION=' . urlencode( $action )
                .  '&NOTE=' . urlencode( 'Profile cancelled at store' );
 
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp' ); // For live transactions, change to 'https://api-3t.paypal.com/nvp'
    curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
 
    // Uncomment these to turn off server and peer verification
    // curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
    // curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_POST, 1 );
 
    // Set the API parameters for this transaction
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $api_request );
 
    // Request response from PayPal
    $response = curl_exec( $ch );
 
    // If no response was received from PayPal there is no point parsing the response
    if( ! $response )
        die( 'Calling PayPal to change_subscription_status failed: ' . curl_error( $ch ) . '(' . curl_errno( $ch ) . ')' );
 
    curl_close( $ch );
 
    // An associative array is more usable than a parameter string
    parse_str( $response, $parsed_response );
 
    return $parsed_response;
}

//$daya = change_subscription_status( 'I-N6D1U6T29HK9', 'Cancel' );

function  cancel_subscriptions_stripe($stripe_subscription_id,$paymentid){

			require_once get_template_directory() . '/stripe-php/init.php';

			// Set API key 
			\Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
			$stripe = new \Stripe\StripeClient(
			    'sk_test_51JT1PhJQoyEaQViihNcr4X2TLq8oyZcwD9WK1CJ672xxmMcZp8BumsSaApid3SGHMhwNFMUsqr5KuLco3GH6erkM00BzpFg2z0'
			);
			$data =  $stripe->subscriptions->retrieve(
			$stripe_subscription_id,
			[]
			);  


			if($data['status'] != 'canceled'){

			// $stripe = new \Stripe\StripeClient(
			// 'sk_test_51JT1PhJQoyEaQViihNcr4X2TLq8oyZcwD9WK1CJ672xxmMcZp8BumsSaApid3SGHMhwNFMUsqr5KuLco3GH6erkM00BzpFg2z0'
			// );
				$res=    $stripe->subscriptions->cancel(
				$stripe_subscription_id,
				[]
				);
			
				if(!empty($res)){
					global $wpdb;
					if($paymentid){
					//9$_GET['userid'] = $user_id; 
					$sql = "UPDATE `hc_user_subscriptions` SET `status` = 'canceled' WHERE `hc_user_subscriptions`.`id` = '".$paymentid."'"; 
					$sqllast  = $wpdb->prepare($sql);
					$wpdb->query($sqllast);
					}
					//echo "Your Membership Is Canceled Now.";
					$_SESSION['meessage-cancel'] = "Your Membership Is Cancelled Now.";

				}else{
					echo "Error";
				}

			}else{
	 				global $wpdb;
					if($paymentid){
					//9$_GET['userid'] = $user_id; 
					$sql = "UPDATE `hc_user_subscriptions` SET `status` = 'canceled' WHERE `hc_user_subscriptions`.`id` = '".$paymentid."'"; 
					$sqllast  = $wpdb->prepare($sql);
					$wpdb->query($sqllast);
					}
				//echo "Your Membership Is Canceled Now.";
				$_SESSION['meessage-cancel'] = "Your Membership Is Cancelled Now.";

			}
}



/* Get User activate status is active or not */
function  get_user_account_active_status(){
	$userid    = get_current_user_id();
	global $wpdb;
	$count = 0;
	$table_name     = $wpdb->prefix . "user_subscriptions";
	$paymenthistory = $wpdb->get_results( "SELECT * FROM $table_name 
	WHERE `user_id` = $userid AND `status` = 'active' And subscriptions_type = '1' ORDER BY created");

	if(!empty($paymenthistory)){
	  return 1;
	}else{
	  return 2;
	}

}


//add_filter( 'body_class','slik_body_classes' );
function slik_body_classes( $classes ) {
 		if (!is_user_logged_in() ) {
	   		 $classes[] = 'loggin-page-class';
	    	 return $classes;
		}
     
}

//login in automatically
// function auto_login( $user ) {
//  ob_start();
//  $username = $user;
//  // log in automatically
//  if ( !is_user_logged_in() ) {
//  $user = get_userdatabylogin( $username );
//  $user_id = $user->ID;
//  wp_set_current_user( $user_id, $user_login );
//  wp_set_auth_cookie( $user_id );
//  do_action( 'wp_login', $user_login );
//  } 
//  ob_end_clean();
// }
