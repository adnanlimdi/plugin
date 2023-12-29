<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://techtic.com/
 * @since      1.0.0
 *
 * @package    Tax_calculator
 * @subpackage Tax_calculator/public
 */


/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tax_calculator
 * @subpackage Tax_calculator/public
 * @author     Techtic <techtic.adnan@gmail.com>
 */
class Tax_calculator_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
 	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tax_calculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tax_calculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tax_calculator-public.css', array(), $this->version, 'all' );
		wp_enqueue_style('range-slider-css', plugin_dir_url( __FILE__ ) . 'css/rangeslider.css', array(), $this->version, 'all' );
		wp_enqueue_style("select-2-css",'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tax_calculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tax_calculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tax_calculator-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'range-slider-js', plugin_dir_url( __FILE__ ) . 'js/rangeslider.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('select-2-js','https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js', array( 'jquery' ), $this->version, false );
		// tXT COOKIE VALUE DEFINE.

		$council_tax_band= $_COOKIE['council_tax_band'];
		$housetypes 	 = $_COOKIE['housetypes'];
		$property_type   = $_COOKIE['property_type'];
		$saving_values   = $_COOKIE['saving_values'];
		// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
		wp_localize_script($this->plugin_name, 'tax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ),'council_tax_band' => $council_tax_band,'housetypes' => $housetypes,'property_type' =>$property_type,'saving_values' =>$saving_values ) );

	}

	function tc_add_all_shortcode(){
		add_shortcode( 'tax_calculator', array($this, 'display_calaulator_form') );
	}

	function display_calaulator_form(){
		ob_start();
		global $wpdb;
		$userip     		= $this->getUserIpAddr();
	    $usercounter    	= $this->tc_get_counter_ip($userip);
	    $userdatecounter    = $this->tc_get_counter_date($userip);
	    $dateold    		= $this->tc_get_old_date($userip);
		$content   			= get_option('mycustomeditor');
		// Update Ip Block Days Counter Update code.
	    if(!empty($dateold)){
	    	$userdatecounter    = $this->tc_get_counter_date($userip);
			$todaydate     		= date('Y-m-d');
			$days 				= $this->dateDiffInDays($dateold,$todaydate);
			$dayscount 	   		= $days/30;
	    	if($userdatecounter != $dayscount){
	    		$updated = $this->tc_get_updated_counter($userip,$days);
	    	}
	    }
	    $usercountvalue 	= (int)IPLIMIT;
	    $validationsmessage = get_option('api_block_message');
	    $calbtn 			= get_option('cal_btn_txt');
 do_action( 'litespeed_purge_all' );
		?>

	<div class="search-text">
		<input type="text" maxlength="8" class="postcode" name="postcode" aria-required="true" placeholder="Enter your Postcode" size="40">
		<a class="submit-pincode submit btn border-width-0 btn-fairblue btn-flat btn-shadow-sm" href="JavaScript:void(0)"><i class="fa fa-search3"></i></a>
		<br>
		<span class="error-msg"></span>
	</div>
	<!-- Overlay Code -->

	<div class="loading-class" style="position: absolute; background: #ffffffe8;  z-index: 999;  display:none;  width: 100%;  height: 100%;">
			<?php echo $content; ?>
	</div>

	<div class="search-text-first" style="display:none;">
		<input type="text" maxlength="8" class="postcode" name="postcode" aria-required="true" placeholder="Enter your Postcode" size="40">
		<a class="submit-pincode submit btn border-width-0 btn-fairblue btn-flat btn-shadow-sm" href="JavaScript:void(0)"><i class="fa fa-search3"></i></a>
		<span class="error-msg"></span>
	</div>
	<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
	<div class="tax-box-calculatore txt-images-svg">
		<ul class="housetypes ffw">
		   <li><input checked id="flat"  value="flat" class="property-housetype" type="radio" name="type"><label for="flat" >
		   	<figure>
		    <img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/flat.svg' ?>" class="white-icon-flat white-ic">
		   	<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/flat_.svg' ?>" class="red-icon-flat red-ic">
		   </figure>
		   	<span class="txt-label">Flat</span>
		   </label>

		   </li>
		   <li><input id="terraced" value="terraced" class="property-housetype" type="radio" name="type"><label for="terraced">
			<figure>
		   	<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/terrace.svg' ?>" class="white-icon-terrace white-ic">
		   	<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/terrace_.svg' ?>" class="red-icon-terrace red-ic">
		   </figure>
		   	<span class="txt-label">Terraced</span>

		   </label>

		   </li>
		   <li><input id="semi"  value="semi" class="property-housetype" type="radio" name="type"><label for="semi">
		   	<figure>
		   	<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/semi.svg' ?>" class="white-icon-semi white-ic">
		   	<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/semi_.svg' ?>" class="red-icon-semi red-ic">
		   </figure>
		   	<span class="txt-label">Semi-detached</span></label>


		   </li>
		   <li><input id="detached"  value="detached"  class="property-housetype" type="radio" name="type">
		   	<label for="detached">
		   		<figure>
		   			<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/house.svg' ?>" class="white-icon-house white-ic">
		  		 	<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/house_.svg' ?>" class="red-icon-house red-ic">
		   	</figure>
		   			<span class="txt-label">Detached</span></label>

		   </li>
		</ul>
		<ul class="homerent">
		   <li><label for="owner"><input id="owner" value="owner" type="radio" class="property-select" name="property" checked> I am Homeowner</label></li>
		   <li><label for="renter"><input id="renter" value="renter" type="radio" class="property-select" name="property"> I am a Renter</label></li>
		</ul>
	    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
		<span class="btn-container btn-block"><a href="JavaScript:void(0)" class="click-button-save disabled custom-link btn btn-lg border-width-0 btn-fairblue btn-circle btn-text-skin btn-color-xsdn btn-flat"><?php echo $calbtn; ?></a></span>
		<?php
		if($usercounter >= $usercountvalue){?>
			<input type="hidden" name="block-status" value="blocked">
			<span class="error-msg-show" style="display:none;"><?php echo $validationsmessage;  ?></span>
		<?php
			}
		?>
	</div>
	<hr />
	<div class="user_selections" style="display:none;">
		<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/fslogosmall.png' ?>">
		<div class="user_selections_list">
			<p id="c_address">123 Road Address, Postcode (<span id="c_type">Owner</span>)</p>
			<p class="c_tax">Council Tax Band <b id="c_band">F</b></p>
			<p class="c_value">Estimated Value <b id="c_price">£650,000</b></p>
		</div>
		<a href="JavaScript:void(0)" class="b_start"><i class="menu-icon fa fa-arrow-left"></i> Calculate again</a>
	</div>
	<hr />
    <script src="https://www.google.com/recaptcha/api.js?render=6Lc6afMUAAAAAJD6dnfjEEXKcY7qQnyUvZhZmHT3"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('6Lc6afMUAAAAAJD6dnfjEEXKcY7qQnyUvZhZmHT3', { action: 'contact' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
 	  <?php
		return $htmls.ob_get_clean();
	  ?>
	  <?php
	}

	//Get Select Dropdown Values Using Council Tax api.
	public function tc_select_dropdown(){
		// create curl resource
			$userip        = $this->getUserIpAddr();
			$usercounter   = $this->tc_get_counter_ip($userip);
			$postcode      = $_REQUEST['postcode'];
			$council_tax_api_key = get_option('council_tax_api_key');
			$user_id 		= get_option('property_user_id');
			$body = array();
			$i = 1;
			while ( 1 ){
	    		//call api
			$response = wp_remote_get( 'https://api.counciltaxfinder.com/counciltaxfinder/counciltax/'.$postcode.'?door=&page='.$i.'&userid='.$user_id.'&apikey='.$council_tax_api_key.'' );
			$result = json_decode($response['body']);
			$body[] = json_decode($response['body']);
			$i++;
			if($result) {
			} else {
			break;
			}
	    }
		?>
		<input type="hidden"  value="<?php echo $postcode; ?>" name="postcode" class="postcode-value">
		<?php if(!empty($body[0])){ ?>
		<select class="property-address" id='color' style="width:80%;">
			<option></option>
			<?php
					foreach ($body as  $resultscalcy) {
						foreach ($resultscalcy as $key => $value) {
						# code...
							$address       = $value->Address;
							$Band          = $value->Band;
							$Tax    	   = $value->Tax;
							$lautnumber    = $value->{'Local Authority Reference Number'};
						?>
							<option data-tax="<?php echo $Tax; ?>" data-band="<?php echo $Band; ?>" value='<?php echo $address; ?>'>
								<?php echo ucfirst(strtolower($address)); ?>
							</option>
						<?php
						}
				 }
			?>
		</select>
		<?php }else{ ?>
		<label class="no-match-found">No match found for this address please enter your estimated Council Tax bill.
		</label>
		<input type="text" maxlength="8" class="property-council-tax postcode" name="property-council-tax" aria-required="true" placeholder="Enter your Council Tax Rate" size="40">
		<?php } ?>
		<a class="submit-back-first submit btn border-width-0 btn-fairblue btn-flat btn-shadow-sm" href="JavaScript:void(0)"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

		<?php

		wp_die();

	}

	public function tc_third_steps_html(){
		global $wpdb;
		$Address 	        = $_REQUEST['addressvalue'];
		$htype 		        = $_REQUEST['htype'];
		$band 		        = $_REQUEST['band'];
		$ptype 		        = $_REQUEST['ptype'];
		$postcode 	        = $_REQUEST['postcode'];
		// set the cookies
		setcookie("housetypes",$htype,time() + (86400 * 30), "/");
		setcookie("council_tax_band", $band,time() + (86400 * 30), "/");
		setcookie("property_type", $ptype,time() + (86400 * 30), "/");
		$userip     	    = $this->getUserIpAddr();
		$useripstatus       = $this->tc_get_results_ip($userip);
		$usercounter    	= $this->tc_get_counter_ip($userip);
	    $usercountvalue 	= (int)50;
	    $validationsmessage = get_option('api_block_message');
	    $tbl_visitor = $wpdb->prefix . "taxcal_ipcount";
	    $calbtn 		= get_option('cal_btn_txt');
	    //Recaptcha Verifications Code coming here.
		if ( isset($_REQUEST['recaptcha_response'])) {

			// Build POST request:
			$recaptcha_url 		= 'https://www.google.com/recaptcha/api/siteverify';
			$recaptcha_secret   = '6Lc6afMUAAAAAH-z_wA2vTnwPNE2RjAHi25cx49X';
			$recaptcha_response = $_REQUEST['recaptcha_response'];

			// Make and decode POST request:
			$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
			$recaptcha = json_decode($recaptcha);

			// Take action based on the score returned:
			if ($recaptcha->score >= 0.5) {
			// Verified - send email
				//exit("error");

			} else {
			// Not verified - show form error
			}
		}

		//$postcode   = 'NE52QP';
		$date 		= date('Y-m-d');
		//Insert values When going third step database.
		$table  		= $wpdb->prefix.'tax_calculator';
		$tabletwo       = $wpdb->prefix.'taxcal_ipcount';
		if(!empty($postcode)){
				$data = array('id'=>'','postcode'=>$postcode,'user_ip'=>$userip,'house_type'=>$htype,
			'property_type'=>$ptype,'address'=>$Address,'band'=>$band,'date'=>$date);
				$format 	= array('%d','%s','%s','%s','%s','%s','%s','%s');
				$insert_id  = $wpdb->insert($table,$data,$format);
				$lastid = $wpdb->insert_id;
			//echo "Last Insert id".$lastid;
			 if($useripstatus  == true){
			 	  // Update Ip Code coming Here.
				  $usercounter   = $this->tc_get_counter_ip($userip);
  				  $isid = '';
				  if($usercounter == 4){
				  	$isid = 'add';
				  }
				  $counter       = (int)$usercounter+1;
				  if($counter == $usercountvalue){
				  	 $Is_blocked = 1;

				  }else{
				  	 $Is_blocked = 0;
				  }
				  $update_format = "UPDATE " . $tabletwo . " SET `Is_blocked`='".$Is_blocked."' ,`counter` = '" . $counter . "' WHERE `user_ip` = '" . $userip . "'";
	 		     // echo $update_format;
			      $result = $wpdb->query( $update_format );
			      if($result){
				  		//echo "Update query table";
			      }
				}else{
					$data = array('id'=>'','user_ip'=>$userip,'counter'=>1);
					$format 	= array('%d','%s','%d');
					$resultd  = $wpdb->insert($tabletwo,$data,$format);
			 }

		}else{
			$insert_id='';
		}
		?>
		<div class="third-steps">
		  <input type="hidden" name="userentryid" class="entry-id" value="<?php echo $lastid; ?>">
		  <input type="hidden" name="housetypes" class="house-type" value="<?php echo $htype; ?>">
		 <?php if($Address != 'no'){ ?>
		   <div class="user_selections " >
			  <img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/fslogosmall.png' ?>">
				<div class="user_selections_list">
					<p id="c_address"><?php echo $Address; ?> (<span id="c_type"><?php echo ucfirst($ptype); ?></span>)</p>
					<p class="c_tax">Council Tax Band <b id="c_band"><?php echo $band; ?></b></p>
				</div>
				<a href="JavaScript:void(0)" class="back-2-steps submit-first"><i class="menu-icon fa fa-times-circle"></i></a>
			</div>
		<?php }else{ ?>
		   <div class="user_selections" >
		   		<a href="JavaScript:void(0)" class="back-2-steps right-icon-side b_start"><i class="menu-icon fa fa-arrow-left"></i> Back</a>
			</div>
		<?php } ?>
			<div><label class="title-input">Enter your Estimated Property Value</label></div>
		    <div class="search-input-text">
					<a class="submit btn border-width-0 btn-fairblue btn-flat btn-shadow-sm" href="JavaScript:void(0)">£</a>
					<input type="text"  class="propertyvalue postcode" name="propertyvalue" aria-required="true" placeholder="Property Value" size="40">
					<span class="error-msg"></span>
			</div>
			<?php /*
			<div class="range-slider-property" >
        		<h5>Your Estimated Property Value</h5>
        		<input type="range"  step="10000" min="100000" max="500000" data-rangeslider>
        		<output></output>
    	   </div>
    	   */ ?>
			<div class="user_selections_list" style="display:none;">
				<ul class="homerent">
				   <li><label for="owner"><input id="owner" value="owner" type="radio" class="property-select-two" name="property" <?php if($ptype == 'owner') echo "checked"; ?>> I am Homeowner</label></li>
				   <li><label for="renter"><input id="renter" value="renter" type="radio" class="property-select-two" name="property" <?php if($ptype == 'renter') echo "checked"; ?>> I am a Renter</label></li>
				</ul>
			</div>
			<span class="btn-container btn-block">
				<a href="JavaScript:void(0)" class="btn-calculate custom-link btn btn-lg border-width-0 btn-fairblue btn-circle btn-text-skin btn-color-xsdn btn-flat"><?php echo $calbtn; ?></a>
			</span>
			<?php
			if($isid != 'add' ){
			if($usercounter >= $usercountvalue){?>
			<input type="hidden" name="block-status" value="blocked">
			<span class="error-msg-show" style="display:none;"><?php echo $validationsmessage;  ?></span>
			<?php
			} }
			?>
		</div>
		<?php

		wp_die();

	}

	//Get Back to 2 steps Html code coming her
	public function tc_back_to_second_step_html(){
		$htype 		= $_REQUEST['htype'];
		$ptype 		= $_REQUEST['ptype'];
		$userip     	    = $this->getUserIpAddr();
		$useripstatus       = $this->tc_get_results_ip($userip);
		$usercounter    	= $this->tc_get_counter_ip($userip);
	    $usercountvalue 	= (int)IPLIMIT;
	    $validationsmessage = get_option('api_block_message');
	    $calbtn 			= get_option('cal_btn_txt');
		?>
			<ul class="housetypes ffw">
				<li>
					<input id="flat"  value="flat" class="property-housetype" type="radio" name="type" <?php if($htype == 'flat') echo "checked"; ?> >
					<label for="flat" >
						<figure>
							<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/flat.svg' ?>" class="white-icon-flat white-ic">
							<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/flat_.svg' ?>" class="red-icon-flat red-ic">
						</figure>
					   <span class="txt-label">Flat</span>
					</label>
				</li>
				<li>
					<input id="terraced" value="terraced" class="property-housetype" type="radio" name="type" <?php if($htype == 'terraced') echo "checked"; ?>>
					<label for="terraced">
						<figure>
							<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/terrace.svg' ?>" class="white-icon-terrace white-ic">
							<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/terrace_.svg' ?>" class="red-icon-terrace red-ic">
						</figure>
					<span class="txt-label">Terraced</span>
					</label>
				</li>
				<li>
					<input id="semi"  value="semi" class="property-housetype" type="radio" name="type" <?php if($htype == 'semi') echo "checked"; ?>>
					<label for="semi">
					<figure>
						<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/semi.svg' ?>" class="white-icon-semi white-ic">
						<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/semi_.svg' ?>" class="red-icon-semi red-ic">
					</figure>
					<span class="txt-label">Semi-detached</span>
				</label>

				</li>
				<li> <input id="detached"  value="detached"  class="property-housetype"
				 type="radio" name="type" <?php if($htype == 'detached') echo "checked"; ?>>
					<label for="detached">
						<figure>
							<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/house.svg' ?>" class="white-icon-house white-ic">
							<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/house_.svg' ?>" class="red-icon-house red-ic">
						</figure>
					<span class="txt-label">Detached </span></label>

				</li>

			</ul>
			<ul class="homerent">
			   <li><label for="owner"><input id="owner" value="owner" type="radio" class="property-select" name="property" <?php if($ptype == 'owner') echo "checked"; ?>> I am Homeowner</label></li>
			   <li><label for="renter"><input id="renter" value="renter" type="radio" class="property-select" name="property" <?php if($ptype == 'renter') echo "checked"; ?>> I am a Renter</label></li>
			</ul>
			<span class="btn-container btn-block"><a href="JavaScript:void(0)" class="disabled click-button-save custom-link btn btn-lg border-width-0 btn-fairblue btn-circle btn-text-skin btn-color-xsdn btn-flat"><?php echo $calbtn; ?></a></span>
		    <?php
			if($usercounter >= $usercountvalue){?>
			<input type="hidden" name="block-status" value="blocked">
			<span class="error-msg-show" style="display:none;"><?php echo $validationsmessage;  ?></span>
			<?php
			}
			?>
		<?php
		wp_die();
	}

	public function tc_forth_step_html(){
		$Address 		= $_REQUEST['addressvalue'];
		$postcode       = $_REQUEST['postcode'];
		$htype 			= $_REQUEST['htype'];
		$band 			= $_REQUEST['band'];
		$ptype 			= $_REQUEST['ptype'];
		$propertyvalue  = $_REQUEST['propertyvalue'];
  		$propertyvalue  = round(str_replace(',','',$propertyvalue));
		$propertyvalue11= round($propertyvalue*11/100);
		$propertyvalue  = (int)$propertyvalue - $propertyvalue11;
		$lastinsertid   = $_REQUEST['lastinsertid'];
		$userip     	= $this->getUserIpAddr();
		$status     	= $this->tc_get_results($lastinsertid);
	    $usercounter    = $this->tc_get_counter_ip($userip);
	    $usercountvalue = (int)IPLIMIT;
	    $calbtn 		= get_option('cal_btn_txt');

		$record = '';
		if($status == 1){
			$record = 'added';
		}
		if(isset($_REQUEST['taxvalue'])){
			$ptax 			= $_REQUEST['taxvalue'];
		}else{
			$ptax 			= $_REQUEST['propertytxt'];
			$ptax  			= round(str_replace(',','',$ptax));
		}
		$ptax           = (int)round(str_replace('£', "",$ptax));
		$b2 = (int)$propertyvalue;
		$b3 = round($b2*0.48/100);


		// Stamp Duty Saving Calculations.
	    If($b2 > 1500000){
		      $stampduty = round((93750+($b2-1500000)*12/100)/20);
		}

	  	If($b2 > 925000 && $b2<=1500000){
	    	  $stampduty = round((36250+($b2-925000)*10/100)/20);
	  	}

	  	If($b2 > 250000 && $b2<=925000){
	          $stampduty = round((2500+($b2-250000)*5/100)/20);
	  	}

	  	If($b2 > 125000 && $b2<=250000){
	    	  $stampduty = round((0+($b2-125000)*2/100)/20);
	  	}
	  	If($b2 > 40000 && $b2<=125000){
	    	  $stampduty = 0;
	    }

	    //Actual Saving Values.
	    $actualsaving 		= ($ptax + $stampduty) - $b3 ;
	    $actualsavingvalues = str_replace('-','',$actualsaving);
	    if ($actualsaving < 0){
	    	$winloosetext 	= "RESULTS - LOSER";
	    	$savingtext 	= "Your region is saving";
	    	$label          = 'Loser';
	    }else{
			$winloosetext   = "RESULTS - WINNER";
			$savingtext 	= "You will save";
			$label          = 'Winner';
	    }
		setcookie("housetypes",$htype,time() + (86400 * 30), "/");
		setcookie("council_tax_band",$band,time() + (86400 * 30), "/");
		setcookie("property_type",$ptype,time() + (86400 * 30), "/");
		setcookie("saving_values",$actualsavingvalues,time() + (86400 * 30), "/");
	    // Update Entry Table For database.
	    $itemkey = $lastinsertid;
		global $wpdb;
		$tbltxt      = $wpdb->prefix . "tax_calculator";
		if(empty($record)){
			$update_format = "UPDATE " . $tbltxt . " SET `postcode` = '" . $postcode . "', `user_ip` = '" . $userip . "',`property_value` = '".$propertyvalue."', `council_tax` = '" . $ptax . "',`total_saving` = '" . $actualsavingvalues . "',`new_council_tax` = '" . $b3 . "',`label` = '".$label."',`process_status` = '1',
				`block_ip_status` = '1',`stamp_duty_saving` = '" . $stampduty . "'  WHERE `id` = '" . $itemkey . "'";
			// echo $update_format;
			$result = $wpdb->query( $update_format );
			if($result){
				//echo "Update query table";
			}
		}else{
		  		$staus = 1;
		  		$todaydate 		= date('Y-m-d');
		  		$data = array('id'=>'','postcode'=>$postcode,'user_ip'=>$userip,
		  			'house_type'=>$htype,
			    'property_type'=>$ptype,'address'=>$Address,'label'=>$label,'property_value'=>$propertyvalue,'council_tax'=>$ptax,'stamp_duty_saving'=>$stampduty,'new_council_tax'=>$b3,'total_saving'=>$actualsavingvalues,'band'=>$band,'date'=>$todaydate,'process_status'=>$staus,'block_ip_status'=>$staus);
		  		 $format 	= array('%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
		  		 	'%s','%s','%s','%d','%d');

				$insert_id  = $wpdb->insert($tbltxt,$data,$format);
				$lastid 	= $wpdb->insert_id;

			// Update Counter Table here
			   $tabletwo       = $wpdb->prefix.'taxcal_ipcount';
			   $counter        = (int)$usercounter+1;
			   if($counter >= $usercountvalue){
				  	$Is_blocked = 1;
				  }else{
				  	$Is_blocked = 0;
				}
			   $update_format  = "UPDATE " . $tabletwo . " SET `Is_blocked`='".$Is_blocked."'
			   ,`counter` = '" . $counter . "' WHERE `user_ip` = '" . $userip . "'";
 		     // echo $update_format;
		      $result 		   = $wpdb->query( $update_format );
		      if($result){
			  		//echo "Update query table";
		      }
		}

		 do_action( 'litespeed_purge_all' );
	?>

	<input type="hidden" class="house-type" value="<?php echo $htype; ?>">
	<input type="hidden" class="property-values" value="<?php echo $propertyvalue; ?>">
	<input type="hidden" class="saving-values" value="<?php echo $actualsavingvalues; ?>">
	<div class="user_selections" >
		<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/fslogosmall.png' ?>">
			<div class="user_selections_list">
				<?php if($Address != 'no'){ ?>
				<?php $string =  reset(explode(',',$Address)); ?>
				<p id="c_address"><?php echo str_replace($string.',',$string ,$Address);   ?> (<span class="c_type_val" id="c_type"><?php echo $ptype; ?></span>)</p>
				<p class="c_tax">Council Tax Band <b id="c_band"> <?php echo $band; ?></b></p>
				<?php } ?>
				<p class="c_value">Estimated Value <b id="c_price">£<?php echo number_format($propertyvalue); ?></b>&nbsp;<span class="tooltipinfo"><i class="fa fa-info-circle"></i>
  <span class="tooltiptext">To avoid homeowners challenging estimates of their house value we believe the government will apply a discount to the estimated value. We have done the same to calculate your Council Tax</span>
</span></p>

		</div>
		<a href="JavaScript:void(0)" class="back-3-steps b_start"><i class="menu-icon fa fa-arrow-left"></i> Calculate again</a>
	</div>
	<hr />

	 <div class="user_message">


     <?php if ( $ptype == 'renter' ){ ?>
	<div class="Winner-looser-text">
	<?php if($actualsaving < 0){ ?>
	<p>You may pay more <strong>in tax</strong> but when you next move home but you will not have to pay Stamp Duty. This is the right thing for the country as a whole – both reducing regional inequality and increasing mobility for all.</p>
    <?php }else{ ?>
	<p><strong>GREAT NEWS!</strong> With Fairer Share you will no longer pay Council Tax. Instead, your landlord will pay <span class="text-fairlightblue-color">Proportional Property Tax</span> - it’s only fair that property taxes are paid by those who benefit from property ownership. And you'll never have to pay Stamp Duty if you decide to buy your own home!</p>
	<?php } ?>
    </div>
    <?php }elseif($ptype =='owner' && $actualsaving < 0 ){ ?>
	<p>You may pay more <strong>in tax</strong> but when you next move home but you will not have to pay Stamp Duty. This is the right thing for the country as a whole – both reducing regional inequality and increasing mobility for all.</p>
    <?php }else{ ?>

<h3 class="h3 text-fairlightblue-color text-uppercase"><span>Great News!</span></h3>
			<h4 class="h4 text-fairblue-color">
				<span><?php echo $savingtext; ?></span><br>
				<span class="text-fairlightblue-color">&pound;<?php echo number_format(str_replace('-','',$actualsaving)); ?></span>
			</h4>
			<h4 class="h4 text-fairblue-color">
				<span>every year under Fairer Share.</span>
			</h4>
			<h4 class="h5 text-fairred-color">
				<span>Let's make it happen!</span>
			</h4>
    <?php } ?>

    			<a href="https://fairershare.org.uk/petition/" class="btn btn-lg btn-fairred btn-circle btn-flat btn-icon-left">Sign the Petition Today</a>
			<span class="divider"></span>

	</div>
	 <div class="txt-council">
             <br>
    <?php if($ptype =='renter' && $actualsaving > 0 ){ ?>
        <span>Council Tax Saving</span>
            <span class="text-fairlightblue-color">£<?php echo number_format($ptax);  ?></span>
            <span class="tooltipinfo"><i class="fa fa-info-circle"></i><span class="tooltiptext">You will no longer have to pay Council Tax. Our campaign was completed in early 2020 before the council tax rates were published for 2021.</span></span>
        <?php }else{ ?>
	 		<span>Council Tax (2019/20)</span>
            <span class="text-fairlightblue-color">£<?php echo number_format($ptax);  ?></span>
            <span class="tooltipinfo"><i class="fa fa-info-circle"></i><span class="tooltiptext">The data modelling for our campaign was completed in early 2020 before the council tax rates were published for 2021</span></span>
            <?php } ?>
            <br>

			<span>Annualised Stamp Duty Saving</span>
			<span class="text-fairlightblue-color">£<?php echo number_format($stampduty); ?></span>
			<?php if($stampduty == 0){ ?>
			<span class="tooltipinfo"><i class="fa fa-info-circle"></i>
              <span class="tooltiptext">You are below the current threshold. With Fairer Share you will never have to pay Stamp Duty.</span></span>
              <?php }else{ ?>
            <span class="tooltipinfo"><i class="fa fa-info-circle"></i>
             <span class="tooltiptext">With Fairer Share you'll never pay Stamp Duty when you buy your home. Our model assumes you’d move to a home with the same value as your current rented property and we spread this saving over 20 years which is the average period of time between house sales.</span></span>
			<?php } ?>
			</span>
            <br><br>
            <?php if($ptype != 'renter'){ ?>
            <span><strong class="text-fairlightblue-color">Proportional Property Tax</strong></span>
            <span class="text-fairlightblue-color">£<?php echo number_format($b3); ?></span>
            <span class="tooltipinfo"><i class="fa fa-info-circle"></i><span class="tooltiptext">This is 0.48% of the conservatively estimated value of your property</span></span>
            <?php }else{ ?>
		<span><strong class="text-fairlightblue-color">Proportional Property Tax</strong> (paid by the landlord)</span>
            <span class="text-fairlightblue-color">£<?php echo number_format($b3); ?></span>
            <span class="tooltipinfo"><i class="fa fa-info-circle"></i><span class="tooltiptext">The landlord will pay <?php if($actualsaving < 0){ ?> less <?php }else{ ?> more <?php } ?>  than the current cost of Council Tax. Whilst you won't be paying Council Tax under the new system, some of the PPT may be passed on to you through higher rent.</span></span>
            <?php } ?>


	 </div>
	 <?php
	 wp_die();
	}

	// Back to third Steps code html here coming.
	public function tc_back_to_third_steps_html(){

		$propertyvalue 	= $_REQUEST['propertyvalue'];
		$Address 	    = $_REQUEST['addressvalue'];
		$htype 		    = $_REQUEST['htype'];
		$band 		    = $_REQUEST['band'];
		$ptype 		    = $_REQUEST['ptype'];
		$userip     	= $this->getUserIpAddr();
		$status     	= $this->tc_get_results($lastinsertid);
	    $usercounter    = $this->tc_get_counter_ip($userip);
	    $validationsmessage = get_option('api_block_message');
	    $usercountvalue = (int)IPLIMIT;
	    $calbtn 		= get_option('cal_btn_txt');


		?>
		<div class="third-steps">
		<input type="hidden" name="housetypes" class="house-type" value="<?php echo $htype; ?>">
			<?php if($Address != 'no'){ ?>
		   		<div class="user_selections " >
					<img src="<?php echo  plugin_dir_url( __FILE__ ).'/images/fslogosmall.png' ?>">
					<div class="user_selections_list">
						<p id="c_address"><?php echo $Address; ?> (<span id="c_type"><?php 	echo ucfirst($ptype); ?></span>)</p>
						<p class="c_tax">Council Tax Band <b id="c_band"><?php echo $band; ?></b></p>
					</div>
					<a href="JavaScript:void(0)" class="back-2-steps submit-first"><i class="menu-icon fa fa-times-circle"></i></a>
				</div>
		  <?php }else{ ?>
		   <div class="user_selections" >
				<a href="JavaScript:void(0)" class="back-2-steps right-icon-side b_start"><i class="menu-icon fa fa-arrow-left"></i> Back</a>
			</div>
	    	<?php } ?>

			<div><label class="title-input">Enter Estimated Property Value</label></div>
			<div class="search-input-text">
					<a class="submit btn border-width-0 btn-fairblue btn-flat btn-shadow-sm" href="JavaScript:void(0)">£</a>
					<input type="text" class="propertyvalue postcode" name="propertyvalue" aria-required="true" placeholder="Property Value" size="40">
					<span class="error-msg"></span>
			</div>
			<?php /*
			<div class="range-slider-property">
        		<h5>Your Estimated Property Value</h5>
        		<input value="<?php echo $propertyvalue; ?>" type="range"  step="10000" min="100000" max="500000" data-rangeslider>
        		<output></output>
    	   </div> */ ?>
			<div class="user_selections_list" style="display:none;">
				<ul class="homerent">
				   <li><label for="owner"><input id="owner" value="owner" type="radio" class="property-select-two" name="property" <?php if($ptype == 'owner') echo "checked"; ?>> I am Homeowner</label></li>
				   <li><label for="renter"><input id="renter" value="renter" type="radio" class="property-select-two" name="property" <?php if($ptype == 'renter') echo "checked"; ?>> I am a Renter</label></li>
				</ul>
			</div>
			<span class="btn-container btn-block">
				<a href="JavaScript:void(0)" class="btn-calculate custom-link btn btn-lg border-width-0 btn-fairblue btn-circle btn-text-skin btn-color-xsdn btn-flat"><?php echo $calbtn;  ?></a>
			</span>
			<?php
			if($usercounter >= $usercountvalue){?>
			<input type="hidden" name="block-status" value="blocked">
			<span class="error-msg-show" style="display:none;"><?php echo $validationsmessage;  ?></span>
			<?php
			}
			?>
		</div>
		<?php

		wp_die();

	}

	public function getUserIpAddr(){
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        //ip from share internet
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        //ip pass from proxy
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

	public function tc_get_results($lastid){
		global $wpdb;
		$tbl_visitor = $wpdb->prefix . "tax_calculator";
		$getresults  = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "` WHERE id = '" . $lastid . "'" );
		if(!empty($getresults)){
              $status = $getresults->process_status;
    		}else{
    		$status = 1;
    	}
    	return $status;
	}

	// check ip inserted or not.
	public function tc_get_results_ip($userip){
		global $wpdb;
		$tbl_ipcount       = $wpdb->prefix . "taxcal_ipcount";
		$ipresult  		   = $wpdb->get_row( "SELECT * FROM `" . $tbl_ipcount . "` WHERE user_ip = '" . $userip . "'" );
		  if(!empty($ipresult)){
             	 $status = true;
    		}else{
    			$status   = false;
    		}
    	return $status;
	}

	// Get Counter Values Using Ip Address.
	public function tc_get_counter_ip($userip){
		global $wpdb;
		$tabel_ip    = $wpdb->prefix . "taxcal_ipcount";
		$ipresult    = $wpdb->get_row( "SELECT * FROM `" . $tabel_ip . "` WHERE user_ip = '" . $userip . "'" );
		 if(!empty($ipresult)){
              $countervalue = $ipresult->counter;
    	 }
    	return $countervalue;
	}

	// Date Difference Functions Code.
	 public function dateDiffInDays($date1, $date2)  {
	    // Calulating the difference in timestamps
	    $diff = strtotime($date2) - strtotime($date1);
	    // 1 day = 24 hours
	    // 24 * 60 * 60 = 86400 seconds
	    return abs(round($diff / 86400));
	}

	//Get Old date for Ip Address.
	public function tc_get_old_date($userip){
		global $wpdb;
		$tbl_calculator = $wpdb->prefix . "tax_calculator";
		$getdateresult  = $wpdb->get_row( "SELECT * FROM $tbl_calculator WHERE `user_ip` = '".$userip."' ORDER BY `date` LIMIT 1" );
		$olddate = '';
		if(!empty($getdateresult)){
              $olddate = $getdateresult->date;
    	}
    	return $olddate;
	}
		// Update Counter Code.
	public function tc_get_updated_counter($userip,$days){
			global $wpdb;
			$tabel_ip      = $wpdb->prefix.'taxcal_ipcount';
			$updatevalue   = $days %30;
			$dayscount 	   = $days/30;
			if($updatevalue == 0){
			   $userip         = $userip;
			   $counter        = 0;
			   $Is_blocked 	   = 0;
			   $update_format  = "UPDATE " . $tabel_ip . " SET `Is_blocked`='".$Is_blocked."'
			   ,`counter` = '" . $counter . "' , `date_of_counter`='".$dayscount."'  WHERE  `user_ip` = '" . $userip . "'";
			   $result 		   = $wpdb->query( $update_format );
			}else{
				return "notupdate";
			}
	}
//get days counter Code .
public function tc_get_counter_date($userip){
    global $wpdb;
    $tabel_ip    = $wpdb->prefix . "taxcal_ipcount";
    $ipresult    = $wpdb->get_row( "SELECT * FROM `" . $tabel_ip . "` WHERE user_ip = '" . $userip . "'" );
     if(!empty($ipresult)){
          $countervalue = $ipresult->date_of_counter;
     }
    return $countervalue;
}

public function wcpf_dev_process_complete() {
// Optional, you can limit to specific forms. Below, we restrict output to
// form #5.
if(isset($_REQUEST['emailverify'])){
    $entry_id = $_REQUEST['emailverify'];
}

// Get the full entry object
$entry = wpforms()->entry->get( $entry_id );


// Fields are in JSON, so we decode to an array
$entry_fields = json_decode( $entry->fields, true );

// Check to see if user selected 'yes' for callback
if($entry_fields[7]['value'] == 'NO') {
    // Set the hidden field to 'Needs Callback' to filter through entries
    $entry_fields[7]['value'] = 'YES';
}


// Convert back to json
$entry_fields = json_encode( $entry_fields );


 // Save changes
 wpforms()->entry->update( $entry_id, array( 'fields' => $entry_fields ) );


    if(!empty($entry_id)){
        global $wpdb;
        $tabel_ip      = $wpdb->prefix.'wpforms_entries';
        $update_format  = "UPDATE " . $tabel_ip . " SET  `fields`='".$entry_fields."'  WHERE
        `entry_id` = '" . $entry_id . "'";
        $result 		   = $wpdb->query( $update_format );

    }
}

}
