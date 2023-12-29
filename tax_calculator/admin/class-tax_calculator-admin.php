<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://techtic.com/
 * @since      1.0.0
 *
 * @package    Tax_calculator
 * @subpackage Tax_calculator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tax_calculator
 * @subpackage Tax_calculator/admin
 * @author     Techtic <techtic.adnan@gmail.com>
 */
class Tax_calculator_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tax_calculator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tax_calculator-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name, 'ajax_urlform', admin_url('admin-ajax.php?action=txt_datatables') );


	}

	public function tc_booking_register_settings() {
	   add_option( 'property_api_key', '');
	   add_option( 'council_tax_api_key', '');
	   add_option( 'property_user_id', '');
	   add_option( 'api_block_message','');
	   add_option( 'mycustomeditor','');
	   add_option( 'api_site_key','');
	   add_option( 'api_secret_key','');
	   add_option( 'cal_btn_txt','');
	   
	   register_setting( 'tc_options_group', 'property_api_key', 'tc_callback' );
	   register_setting( 'tc_options_group', 'cal_btn_txt', 'tc_callback' );
	   register_setting( 'tc_options_group', 'council_tax_api_key', 'tc_callback' );
	   register_setting( 'tc_options_group', 'property_user_id', 'tc_callback' );
	   register_setting( 'tc_options_group', 'api_block_message', 'tc_callback' );
	   register_setting( 'tc_options_group', 'api_site_key', 'tc_callback' );
	   register_setting( 'tc_options_group', 'api_secret_key', 'tc_callback' );
	   register_setting( 'tc_options_group', 'mycustomeditor', 'tc_callback' );

	   
	}
	public function tc_booikng_menu_pages(){
	   add_menu_page('Tax Calculator Setting', 'Tax Calculator', 'manage_options', 'tax_calculator', array ( $this, 'tc_options_page' ),'dashicons-editor-paste-text',11);

	  	// Add a submenu to the custom top-level menu:
	   add_submenu_page( 'tax_calculator', __( 'Logs – Tax Calculations', 'tax_calculator' ), __( 'Logs – Tax Calculations', 'menu-test' ), 'manage_options', 'tax-log-entry',array ( $this, 'log_options_page' ));
	   //Add A submenu to Ip Lsit
	   add_submenu_page( 'tax_calculator', __( 'IP Entries', 'tax_calculator' ), __( 'IP Entries', 'menu-test' ), 'manage_options', 'ip-list',array ( $this, 'tc_ip_list_page' ));

	}
	public function tc_options_page() 
	{

		$args = array(
			'sort_order' => 'asc',
			'sort_column' => 'post_title',
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'meta_key' => '',
			'meta_value' => '',
			'authors' => '',
			'child_of' => 0,
			'parent' => -1,
			'exclude_tree' => '',
			'number' => '',
			'offset' => 0,
			'post_type' => 'page',
			'post_status' => 'publish'
		); 
		$pages = get_pages($args); 
	?>
		
		<div class="wrap">
		<h3><?php echo 'Tax Calculator Settings'; ?></h3>
		<form method="post" action="options.php">
			<?php settings_fields( 'tc_options_group' ); ?>
			<table  class="form-table" role="presentation">
				<tr valign="top">
					<th scope="row"><label for="tax_calculator_apikey">Property Api Key</label></th>
					<td>
						<input  class="regular-text" type="text" value="<?php echo get_option('property_api_key'); ?>" id="property_api_key" name="property_api_key">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tax_calculator_council_api_key"> Council Tax Api Key</label></th>
					<td>
						<input  class="regular-text" type="text" value="<?php echo get_option('council_tax_api_key'); ?>"  id="council_tax_api_key" name="council_tax_api_key">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tax_calculator_button_txt">Calulations Button Txt</label></th>
					<td>
						<input  class="regular-text" type="text" value="<?php echo get_option('cal_btn_txt'); ?>"  id="cal_btn_txt" name="cal_btn_txt">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tax_calculator_council_api_key">Council Tax User Id</label></th>
					<td>
						<input  class="regular-text" value="<?php echo get_option('property_user_id'); ?>" type="text"  id="property_user_id" name="property_user_id">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tax_calculator_council_api_key"> Ip Block Validations Message</label></th>
					<td>
						<input  class="regular-text" type="text" value="<?php echo get_option('api_block_message'); ?>"  id="api_block_message" name="api_block_message">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tax_calculator_council_api_key">Loading Screen Message</label></th>
					<td>
								<?php 
									$content   = get_option('mycustomeditor');
								    $settings  = array( 'media_buttons' => false );
								 ?>
								<?php 
									$editor_id = 'mycustomeditor';
									wp_editor( $content, $editor_id ,$settings); 
								?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tax_calculator_council_api_key"> Site Key</label></th>
					<td>
						<input  class="regular-text" type="text" value="<?php echo get_option('api_site_key'); ?>"  id="api_site_key" name="api_site_key">
					</td>
				</tr>
                <tr valign="top">
					<th scope="row"><label for="tax_calculator_council_api_key"> Secret Key </label></th>
					<td>
						<input  class="regular-text" type="text" value="<?php echo get_option('api_secret_key'); ?>"  id="api_secret_key" name="api_secret_key">
					</td>
				</tr>

			</table>
			<?php  submit_button(); ?>
		</form>
		</div>
	<?php 
	} 

public function tc_ip_list_page(){

	global $wpdb;
	$table_name = $wpdb->prefix . "taxcal_ipcount";
	if(isset($_REQUEST['unblockip'])  ){

			   $tabletwo       = $wpdb->prefix.'taxcal_ipcount';
			   $userip         = $_REQUEST['unblockip'];
			   $reasonublock   = $_REQUEST['block-reason'];
			   $counter        = 0;
			   $Is_blocked 	   = 0;
			   $update_format  = "UPDATE " . $tabletwo . " SET `Is_blocked`='".$Is_blocked."' 
			   ,`counter` = '" . $counter . "', `reason_of_unblocked`= '".$reasonublock."' WHERE `user_ip` = '" . $userip . "'";
			    $result 		   = $wpdb->query( $update_format );
				if ( $result ) {
					?>
				<div class="acf-admin-notice notice is-dismissible updated "><p>Options Updated</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
		     <?php }
	}	     



	//SELECT * FROM `ege_review` WHERE `course_id` = 15
	$ipvaluse = $wpdb->get_results( "SELECT * FROM $table_name  ORDER BY `user_ip` ASC" );
	    ?> 
	    <style type="text/css">
			.modal-content {
			width: 70%;
			align-items: center;
			margin-left: 121px;
			}
			div#example_wrapper {
    			width: 98%;
			}
			.button-class.row.col-md-6 {
				margin-top: 24px;
				margin-left: 5px;
			}
	    </style>
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
	<h2> <?php esc_html_e( 'IP Entries', 'textdomain' ); ?></h2>
	<table id="example" class="table table-striped table-bordered" style="width:100%">
	        <thead>
	            <tr>
	                <th>ID</th>
	                <th>IP Address</th>
	                <th>#Counter</th>
	                <th>Status</th>
	                <th>Remove Blocked</th>
	                <th>Reason Of Unblock</th>
	                <th>View Calculations</th>
	            </tr>
	        </thead>
	        <tbody>
	        	    <?php 
	        	     $count=0;
	        	     foreach ($ipvaluse as $value) {
	                    # code...
	                   $count++;
	                   $id                     		= $value->id;
	                   $user_ip                     = $value->user_ip;
	                   $Is_blocked                  = $value->Is_blocked;
	                   $counter                     = $value->counter;
	                   $reason_of_unblocked         = $value->reason_of_unblocked;
	    
	                  // echo get_avatar( $userid );
	                   ?>
			            <tr>
			            	<td><?php echo $count; ?></td>
			                <td ><?php echo $user_ip; ?></td>
			                <td ><?php echo $counter; ?></td>
			                <td > <?php 
									if($Is_blocked == 1){
									?>
									<label style="font-size: 15px;" class="label label-danger">Block</label>
									<?php
									}else{ ?>
									<label style="font-size: 15px;" class="label label-info">Open</label>
									<?php }	
			                	?></td>
			                <td >
				                <?php 
									if($Is_blocked == 1){
									?>
									<button data-toggle="modal" data-target="#myModal<?php echo $count; ?>" class="btn btn-warning">Un Block</button>
									    <!-- Modal -->
								    <div class="modal fade"  id="myModal<?php echo $count; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								        <div class="modal-dialog" role="document">
								            <div class="modal-content">
													<div class="modal-body">
													Are you sure want to  Unblock ?
													</div>
													<div class="modal-footer">
														<form method="post" action="">
															<div class="txt-area" >
																<textarea  rows="4" placeholder="Reason for Unblock" name="block-reason" class="col-md-6"></textarea>
															</div>
															<input type="hidden" name="unblockip" value="<?php echo $user_ip; ?>">
															<div class="button-class row col-md-6" >
																<input type="submit" class="btn btn-primary" value="Unblock"> 
																<button type="button" data-dismiss="modal" class="btn">Cancel</button>
															</div>
														</form>
													</div>
								            </div>
								        </div>
								    </div>
									<?php
									}else{ ?>
								
									<?php  
								}	
			                	?>
			                </td>
			                <td>
			                   	<?php echo $reason_of_unblocked; ?>
			                </td>	
			                </td>
			                    <td><a target="_blank" href="	admin.php?page=tax-log-entry&id=<?php echo $id;   ?>"><button class="accept-review btn btn-info">Details</button></a>
			                </td>
			            </tr>
	       		 <?php } ?>
	        </tbody>
	        <tfoot>
	        	<?php
	        	// echo "<pre>";
	        	// print_r($coursereview);
	        	// echo "</pre>";
	        	?>
	            <tr>
	               	<th>ID</th>
	                <th>IP Address</th>
	                <th>#Counter</th>
	                <th>Status</th>
	                <th>Remove Blocked</th>
	                <th>Reason Of Unblock</th>
	                <th>View Calculations</th>
	            </tr>
	        </tfoot>
	    </table>

	    <script type="text/javascript">
	        jQuery(document).ready(function ($) {
	            jQuery('#example').DataTable();
	        });
	
	    </script>
	    <?php
	}

	
	public function log_options_page(){

	global $wpdb;
	$table_name = $wpdb->prefix . "tax_calculator";
	$tabel_ip    = $wpdb->prefix . "taxcal_ipcount";

	$avarage = 0;
	$totalaverage =0;
	$totalcoursereviws =0;
	//SELECT * FROM `ege_review` WHERE `course_id` = 15
	if(isset($_REQUEST['id'])){
		$id          = $_REQUEST['id'];
		$ipresult    = $wpdb->get_row( "SELECT * FROM `" . $tabel_ip . "` WHERE id = '" .$id. "'" );
		if(!empty($ipresult)){
              $userip = $ipresult->user_ip;
    	}
		//$userip = $_REQUEST['userip']; 
 		$txtcalculorvalue = $wpdb->get_results( "SELECT * FROM $table_name  WHERE `user_ip` LIKE '".$userip."' ORDER BY `id` DESC" );
	}else{
		$txtcalculorvalue = $wpdb->get_results( "SELECT * FROM $table_name  ORDER BY `id` DESC Limit 500" );
	}
	if(isset($_GET['submit'])){
	add_action( 'admin_init', 'csv_export') ;
}
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
	<h2> <?php esc_html_e( 'Logs - Tax Calculations', 'tax_calculator' ); ?></h2>
<a href="<?php echo admin_url( 'admin.php?page=tax-log-entry' ) ?>&action=download_csv&_wpnonce=<?php echo wp_create_nonce( 'download_csv' )?>" class="btn btn-success page-title-action"><?php _e('Export to CSV','my-plugin-slug');?></a>
<br>

	<div class="panel-heading">

    
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Post Code</th>
                <th style="width:110px">Ip Address</th>
                <th>Address</th>
                <th>House Type</th>
                <th>Owner Type</th>
                <th>Property Value</th>
             	<th>Calculations</th>
                <th>Status/Flag</th>
                <th>Process</th>
                <th>Date </th>
            </tr>
        </thead>
        <?php if(isset($_REQUEST['id'])){ ?>
        	        <tbody>
        	    <?php 
        	     $count=0;
        	     foreach ($txtcalculorvalue as $value) {
                    # code...
                   $count++;
                   $postcode        = $value->postcode;
                   $user_ip      	= $value->user_ip;
                   $house_type      = $value->house_type;
                   $property_type   = $value->property_type;
                   $property_value  = $value->property_value;
                   $address       	= $value->address;
                   $band       		= $value->band;
                   $council_tax     = $value->council_tax;
                   $saving     		= $value->total_saving;
                   $stamp_saving    = $value->stamp_duty_saving;
                   $new_council_tax = $value->new_council_tax;
                   $process_status  = $value->process_status;
                   $label  			= $value->label;
                   $create_datetime = date("d F Y", strtotime($value->date)); 
                  // echo get_avatar( $userid );
                   ?>
		            <tr>
		            	<td><?php echo $count; ?></td>
		                <td><?php echo $postcode; ?></td>
		                <td ><?php echo $user_ip; ?></td>
		                <td width="400"><?php echo $address; ?> ,<strong><?php echo $band; ?></strong></td>
		                <td ><?php echo ucfirst($house_type); ?></td>
		                <td ><?php echo ucfirst($property_type); ?></td>
		                <td ><?php echo $property_value; ?></td>
		                <td width="600">
		                	<div><b>Annual  Saving </b> : £<?php echo $saving; ?></div>
		                	<div><b>Current Tax   </b> : £<?php echo $council_tax; ?></div>
		                	<div><b>New Tax Rate  </b> : £<?php echo $new_council_tax; ?>
		                </div>
		                	<div><b>Stamp Duty    </b> : £<?php echo $stamp_saving; ?></div>
		                </td>
		                <td >
			                <?php 
								if($label == 'winner'){ ?>
								<button class="btn btn-success"><?php echo ucfirst($label); ?></button>
								<?php
								}else{ 
								if(empty($label)){
								 $label = 'Pending';
								}	
								?>
								<button class="btn btn-warning"><?php echo ucfirst($label); ?></button>
								<?php
								}
		                	?>
		                </td>
		                <td><?php 
								if($process_status == 1){ ?>
								<button class="btn btn-success">Completed</button>
								<?php
								}else{ ?>
								<button class="btn btn-warning">Dropped Off</button>
								<?php
								}
		                	?>
		                	</td>
		                <td ><?php echo $create_datetime; ?></td>
		            </tr>
       		 <?php } ?>
        </tbody>
        <tfoot>
        	<?php
        	// echo "<pre>";
        	// print_r($coursereview);
        	// echo "</pre>";
        	?>
            <tr>
                <th>ID</th>
                <th>Post Code</th>
                <th>Ip Address</th>
                <th>Address</th>
                <th>House Type</th>
                <th>Owner Type</th>
                <th>Property Value</th>
             	<th>Calculations</th>
                <th>Status/Flag</th>
                <th>Process</th>
                <th>Date </th>
            </tr>
        </tfoot>
        <?php } ?>	
    </table>
	</div>
	<?php 	if(isset($_REQUEST['id'])){ ?>
     <script type="text/javascript">
        jQuery(document).ready(function ($) {
			jQuery('#example').dataTable({
		
			} );
       });
    </script>
<?php  }else{?>
     <script type="text/javascript">
        jQuery(document).ready(function ($) {
			jQuery('#example').dataTable({
			"processing": true,
			"serverSide": true,
			"ajax": ajax_urlform
			} );
       });
    </script>
		<?php
	 }
	} 


	/* Setting page link added in all plugins page */
	public function tc_add_link_to_settings( $links, $file ) {
	   $settings_link = '<a href="admin.php?page=tax_calculator">Settings</a>';
		array_unshift( $links, $settings_link );
	    return $links;
	}



}

function ExportFile($records) {
	$heading = false;
		if(!empty($records))
		  foreach($records as $row) {
			if(!$heading) {
			  // display field/column names as a first row
			  echo implode("\t", array_keys($row)) . "\n";
			  $heading = true;
			}
			echo implode("\t", array_values($row)) . "\n";
		  }
		exit;
}
// Add action hook only if action=download_csv
if ( isset($_GET['action'] ) && $_GET['action'] == 'download_csv' )  {
	// Handle CSV Export
	add_action( 'admin_init', 'csv_export') ;
}
function csv_export() {

    ob_start();
        global $wpdb;
	$table_name = $wpdb->prefix . "tax_calculator";
    $domain = $_SERVER['SERVER_NAME'];
    $filename = 'users-' . $domain . '-' . time() . '.csv';
    
       $header_row = array(
            'S NO.',
            'Post Code',
            'User Ip',
            'Address',
            'Band',
            'House Type',
            'Owner Type',
            'Property Value',
            'Council Tax',
            'Stamp Duty Savings',
            'New Council Tax',
            'Annual Savings',
            'Label',
            'Process',
            'Date'
        );
    $data_rows = array();

     $txtcalculorvalues = $wpdb->get_results( "SELECT * FROM $table_name  ORDER BY `date` ASC","ARRAY_A" );
 	     $count=0;
    foreach ( $txtcalculorvalues as $user ) {
            $count++;
            $process_status = $user['process_status'];
            if($process_status == 1){
            	$processlabel = "Completed";
            }else{
            	$processlabel = "Dropped Off";	
            }
            $label  =  ucfirst($user['label']);
			if(empty($label)){
				$label = 'Pending';
			}
		    $create_datetime = date("d F Y", strtotime($user['date'])); 
            $row = array(
			$count,
            $user['postcode'],
            $user['user_ip'],
            $user['address'],
            $user['band'],
            $user['house_type'],
            $user['property_type'],
            $user['property_value'],
            $user['council_tax'],
            $user['stamp_duty_saving'],
            $user['new_council_tax'],
            $user['total_saving'],
            $label,
            $processlabel,
            $create_datetime,
            );
            $data_rows[] = $row;
    }
    $fh = @fopen( 'php://output', 'w' );
    fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header( 'Content-Description: File Transfer' );
    header( 'Content-type: text/csv' );
    header( "Content-Disposition: attachment; filename={$filename}" );
    header( 'Expires: 0' );
    header( 'Pragma: public' );
    fputcsv( $fh, $header_row );
    foreach ( $data_rows as $data_row ) {
        fputcsv( $fh, $data_row );
    }
    fclose( $fh );
    
    ob_end_flush();
    
    die();
}


add_action('wp_ajax_txt_datatables', 'datatables_server_side_callback');
add_action('wp_ajax_nopriv_txt_datatables', 'datatables_server_side_callback');


function datatables_server_side_callback() {

  header("Content-Type: application/json");
  global $wpdb;
  $table_name        = $wpdb->prefix . "tax_calculator";
  $txtcalculorvalues = $wpdb->get_results( "SELECT * FROM $table_name  ORDER BY `date` ASC","ARRAY_A" );
  $request           = $_GET;
  $totalData         = count($txtcalculorvalues);

	$draw            = $request['draw'];
	$row 		     = $request['start'];
	$rowperpage      = $request['length']; // Rows display per page
	$columnIndex     = $request['order'][0]['column']; // Column index
    $columnName      = $request['columns'][$columnIndex]['data']; // Column name
	$columnSortOrder = $request['order'][0]['dir']; // asc or desc
	$searchValue     = $request['search']['value']; // Search value
	if($columnName == 0){
		$columnName = 16;
	}
	if($columnName == 3){
		$columnName = 6;
	}
	if($columnName == 6){
		$columnName = 12;
	}
	if($columnName == 10){
		$columnName = 16;
	}
	if($columnName == 8){
		$columnName = 13;
	}
	if($columnName == 9){
		$columnName = 13;
	}
	if($columnName == 7){
		$columnName = 11;
	}

	## Search 
	$searchQuery = " ";
	if($searchValue != ''){
		$searchQuery = " and (postcode like '%".$searchValue."%' or 
	        user_ip like '%".$searchValue."%' or 
	        address like'%".$searchValue."%' or address like'%".$searchValue."%' or house_type like'%".$searchValue."%' or property_type like'%".$searchValue."%') ";
	}
    $txtcalculorvalues = $wpdb->get_results( "SELECT * FROM $table_name  WHERE 1 $searchQuery ORDER BY `date` ASC","ARRAY_A" );
    $totalData         = count($txtcalculorvalues);
	$txtcalculorvalues = $wpdb->get_results( "SELECT * FROM $table_name WHERE 1 $searchQuery ORDER BY $columnName  $columnSortOrder  Limit $row , $rowperpage","ARRAY_A" );
	$tabel_ip    = $wpdb->prefix . "taxcal_ipcount";

		if(isset($_REQUEST['id'])){
		$id          = $_REQUEST['id'];
		$ipresult    = $wpdb->get_row( "SELECT * FROM `" . $tabel_ip . "` WHERE id = '" .$id. "'" );
		if(!empty($ipresult)){
              $userip = $ipresult->user_ip;
    	}
		//$userip = $_REQUEST['userip']; 
 		$txtcalculorvalues = $wpdb->get_results( "SELECT * FROM $table_name  WHERE `user_ip` LIKE '".$userip."' ORDER BY `id` DESC" );
	}

 	 $count=$row;
 	if(!empty($txtcalculorvalues)){ 
    foreach ( $txtcalculorvalues as $user ) {
            $count++;
            $process_status = $user['process_status'];
            if($process_status == 1){
            	$processlabel = '<button class="btn btn-success">Completed</button>';
            }else{
            	$processlabel = '<button class="btn btn-warning">Dropped Off</button>';	
            }	
			$create_datetime = date("d F Y", strtotime($user['date'])); 
            $label  =  ucfirst($user['label']);
			if($label == 'Winner'){ 
				$label = '<button class="btn btn-success">'.ucfirst($label).'</button>';
			}else{ 
				if(empty($label)){
				$label = 'Pending';
			  }
			  $label = '<button class="btn btn-warning">'.ucfirst($label).'</button>';
			}

			$council_tax     = $user['council_tax'];
			$saving     	 = $user['total_saving'];
			$stamp_saving    = $user['stamp_duty_saving'];
			$new_council_tax = $user['new_council_tax'];
		    $counciltext     = '<div><b>Annual  Saving </b> : £'.$saving.'</div>
		                	<div><b>Current Tax   </b> : £'.$council_tax.'</div>
		                	<div><b>New Tax Rate  </b> : £'.$new_council_tax.'</div>
		                	<div><b>Stamp Duty    </b> : £'.$stamp_saving.'</div>';
            $row = array(
			$count,
            $user['postcode'],
            $user['user_ip'],
            $user['address'],
            ucfirst($user['house_type']),
            ucfirst($user['property_type']),
            $user['property_value'],
            $counciltext,
            $label,
            $processlabel,
            $create_datetime
            );
            $data_rows[] = $row;
     }
    $json_data = array(
      "draw" => intval($request['draw']),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalData),
      "data" => $data_rows
    );
	}else{
	$json_data = array(
      "data" => array()
    );
  }
  echo json_encode($json_data);
  wp_die();

}