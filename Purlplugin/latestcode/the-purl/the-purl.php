<?php
/**
 * Plugin Name: The Purl
 * Description: Addon For Formidable Forms
 * Version: 1.3.0
 * Author: Purlplugin
 * Author URI: https://purlplugin.com
 */
?>
<?php
ob_start();

// Crypto Defines
require_once( ABSPATH . 'wp-content/plugins/the-purl/php-openssl-cryptor-master/src/Cryptor.php' );

use ioncube\phpOpensslCryptor\Cryptor;

define( 'FOLDER_NAME', 'the-purl' );

//License
define('PURL_SPECIAL_SECRET_KEY', '5b97dc04b974f8.43557113');
define('PURL_LICENSE_SERVER_URL', 'https://purlplugin.com');
define('PURL_ITEM_REFERENCE', 'Purl Plugin');

// Create database tables
function purl_install() {
    global $wpdb;
    $tbl_visitor        = $wpdb->prefix . "frm_visitors";
    $create_tbl_visitor = "CREATE TABLE IF NOT EXISTS " . $tbl_visitor . " (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`firstname` varchar(200) NOT NULL,
	`lastname` varchar(200) NOT NULL,
	`email` TEXT NOT NULL ,
	`phone` TEXT NOT NULL,
	`company` varchar(200) NOT NULL,
	`company_purl` varchar(200) NOT NULL,
	`purl` TEXT NOT NULL,
	`uniqueid` TEXT NOT NULL,
	`form_id`  INT(11)  NOT NUll,
	`entry_id`  INT(11) NoT NUll,
	`created_at` DATETIME NOT NULL ,
	`updated_at` DATETIME NOT NULL ,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5";

    $tbl_purl            = $wpdb->prefix . "frm_purl";
    $create_purl_formats = "CREATE TABLE IF NOT EXISTS " . $tbl_purl . " (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`url_format` text NOT NULL,
	`select_url` tinyint(2) NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5";


    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $create_tbl_visitor );
    dbDelta( $create_purl_formats );
    $purlget = $wpdb->get_row( "SELECT * FROM `" . $tbl_purl . "` ORDER BY `id` DESC LIMIT 1" );
    $purlid  = $purlget->id;
    if ( empty( $purlid ) ) {
        $insert_format = "INSERT INTO  " . $tbl_purl . " (`id`, `url_format`, `select_url`) VALUES (NULL, 'firstname.lastname', '0'), (NULL, 'firstname.lastname.5digitpin', '0'), (NULL, 'company', '0'), (NULL, 'company.5digitpin', '0'),(NULL, '5digitpin', '0');";
        $wpdb->query( $insert_format );
    }

}

register_activation_hook( __FILE__, "purl_install" );

//Add Plur page on activation:
function install_events_pg() {
    $new_page_title    = 'purlform';
    $new_page_content  = '[purlform]';
    $new_page_template = ''; //ex. template-custom.php. Leave blank if you don't want a custom page template.
    //don't change the code below, unless you know what you're doing
    $page_check = get_page_by_title( $new_page_title );
    $new_page   = array(
        'post_type'    => 'page',
        'post_title'   => $new_page_title,
        'post_content' => $new_page_content,
        'post_status'  => 'publish',
        'post_author'  => 1,
    );
    if ( ! isset( $page_check->ID ) ) {
        $new_page_id = wp_insert_post( $new_page );
        if ( ! empty( $new_page_template ) ) {
            update_post_meta( $new_page_id, '_wp_page_template', $new_page_template );
        }
    }
}//end install_Plur_pg function to add page to wp on plugin activation

register_activation_hook( __FILE__, 'install_events_pg' );


//Define Global variable for here
add_action( 'init', 'purl_gloabal_cf' );

function purl_gloabal_cf() {
    global $frm_encrypted_fields;
    //$encryptedkey = get_option('purl_encryptions_key','',true);
    define( 'CRYPT_KEY', SECURE_AUTH_SALT );
    $formids              = get_option( 'plur_form_encrypt_filed_ids', true );
    $formlist             = array();
    $formplurids          = explode( ",", $formids );
    $formlist             = array_merge( $formlist, $formplurids );
    $frm_encrypted_fields = $formlist;

}

// Add addon menu in the sidebar
function purldisplay() {
    add_submenu_page(
        'formidable', // Third party plugin Slug
        'Purl Settings',
        'Purl Settings',
        'delete_plugins',
        'add_purl',
        'add_purl_info'
    );
}

add_action( 'admin_menu', 'purldisplay' );

function add_purl_info() {
    include( "includes/add_purl.php" );
}

//add_filter( 'frm_pro_available_fields', 'add_pro_field' );
//function add_pro_field( $fields ) {
//	$fields['signature'] = __( 'Signature' ); // the key for the field and the label
//
//	return $fields;
//}

add_action( 'frm_after_create_entry', 'iflair_frm_break_post_content_connection', 60, 2 );
function iflair_frm_break_post_content_connection( $entry_id, $form_id, $args = array() ) {
    global $wpdb;

    $filter_args             = $args;
    $filter_args['entry_id'] = $entry_id;
    $filter_args['form_id']  = $form_id;
    $tbl_item                = $wpdb->prefix . "frm_items";
    $entyformat              = $wpdb->get_row( "SELECT * FROM `" . $tbl_item . "` WHERE id = " . $entry_id . "" );
    if ( !empty( $entyformat ) ) {
        $itemkeys = $entyformat->item_key;
    }

    //if form project come as of project id form id is this.

    $formids     = get_option( 'plur_form_ids', true );
    $formlist    = array();
    $formplurids = explode( ",", $formids );
    $formlist    = array_merge( $formlist, $formplurids );


    if ( in_array( $form_id, $formlist ) ) {


        $form_args = $_POST['item_meta'];


        if ( ! empty( $form_args ) ) {
            foreach ( $form_args as $key ) {
                # code...
                $fildename[] = $key;
            }

            //form Informations get here
            if ( $_REQUEST['frm_action'] == 'create' && isset( $_POST['item_key'] ) ) {
                $fname       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[1])));
                $lname       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[2])));
                $company       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[3])));
                $companyname = addslashes($fildename[3]);
                $email       = Cryptor::Encrypt($fildename[4],CRYPT_KEY);
                $phonnumber  = Cryptor::Encrypt($fildename[5],CRYPT_KEY);
                $form_key    = $_POST['item_key'];
                //  echo $test;
            } else {
                $fname       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[0])));
                $lname       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[1])));
                $company       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[2])));
                $companyname = addslashes($fildename[2]);
                $email       = Cryptor::Encrypt($fildename[3],CRYPT_KEY);
                $phonnumber  = Cryptor::Encrypt($fildename[4],CRYPT_KEY);
                $form_key    = $itemkeys;
            }
            //form Informations End


            $tbl_purl    = $wpdb->prefix . "frm_purl";
            $tbl_visitor = $wpdb->prefix . "frm_visitors";
            //plur Created code here start.
            $purlformat = $wpdb->get_row( "SELECT * FROM `" . $tbl_purl . "` WHERE select_url = '1'" );
            $purkid     = $purlformat->url_format;
            if ( $purkid == 'firstname.lastname' ) //firstname.lastname
            {
                if ( ! empty( $fname ) || ! empty( $lname ) ) {
                    //echo "string";
                    if ( ! empty( $fname ) && ! empty( $lname ) ) {
                        $purl_name = strtolower( $fname ) . '-' . strtolower( $lname ); //both are there
                    } else if ( empty( $lname ) && ! empty( $fname ) ) {
                        $purl_name = strtolower( $fname ); //only firstname there
                    } else if ( empty( $fname ) && ! empty( $lname ) ) {
                        $purl_name = strtolower( $lname ); // only lastname there
                    }
                    $usersql = "SELECT * FROM " . $tbl_visitor . " WHERE  purl LIKE '" . '/' . $purl_name . "%'";
                    //echo $usersql;
                    $username = $wpdb->get_results( $usersql );
                    $usercnt  = count( $username );
                    if ( $usercnt >= 1 ) {
                        $num       = ++ $usercnt;             // Increment $usercnt by 1
                        $purl_name = $purl_name . '-' . $num;  // Add number to username
                    }
                    //echo $plur_name;
                } else {
                    $purl_name = '';
                }
                //$purl_url = get_bloginfo('url');
            } elseif ( $purkid == 'firstname.lastname.5digitpin' ) //firstname.lastname.5digitpin
            {
                $purl_name = strtolower( $fname ) . '-' . strtolower( $lname ) . '-' . $form_key;
            } elseif ( $purkid == 'company' ) //company
            {
                $purl_name = str_replace("'",'',str_replace( ' ', '', strtolower( $company ) ));
                $usersql   = "SELECT * FROM " . $tbl_visitor . " WHERE  purl LIKE '" . '/' . $purl_name . "%'";
                //echo $usersql;
                $username = $wpdb->get_results( $usersql );
                $usercnt  = count( $username );
                if ( $usercnt >= 1 ) {
                    $num       = ++ $usercnt;             // Increment $usercnt by 1
                    $purl_name = $purl_name . '-' . $num;  // Add number to username
                }
                $purl_url = get_bloginfo( 'url' );
            } elseif ( $purkid == 'company.5digitpin' ) //company.5digitpin
            {
                $purl_name = str_replace("'",'',str_replace( ' ', '', strtolower( $company ) )) . '-' . $form_key;
            } elseif ( $purkid == '5digitpin' ) //5digitpin
            {
                $purl_name = $form_key;
            }

            $purl_name = '/' . $purl_name;



            $company  = str_replace("'",'',str_replace( ' ', '', strtolower( $company ) ));
            $add_cust = "INSERT INTO `" . $tbl_visitor . "` (firstname, lastname, email, phone,company,company_purl,purl,form_id,entry_id,uniqueid,created_at)
			VALUES ('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $phonnumber . "', '" . $companyname . "','" . $company . "' ,'" . $purl_name . "'," . $form_id . "," . $entry_id . ",'" . $form_key . "', '" . date( 'Y-m-d H:i' ) . "')";
            $add_info = $wpdb->query( $add_cust );
            //session_start();
            //$_SESSION['msg-save'] = 'added';
            //plur Created  code here End.
        }
        //echo exit();
    }

}

add_action( 'frm_entry_form', 'iflair_add_plur_field', '', 2 );
function iflair_add_plur_field( $form, $form_action ) {
    // echo "<pre>";
    if ( is_admin() ) {
        global $wpdb;
        $pururls  = '';
        $entryid  = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';
        $formpage = isset( $_REQUEST['frm_action'] ) ? $_REQUEST['frm_action'] : '';
        // echo $formpage;
        $tbl_visitor  = $wpdb->prefix . "frm_visitors";
        $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "` ORDER BY `id` DESC LIMIT 1" );
        if ( ! empty( $purlformatid ) ) {
            $lastid = $purlformatid->id;
        }
        if ( ! empty( $entryid ) ) {
            $tbl_visitor = $wpdb->prefix . "frm_visitors";
            $purlformat  = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "` WHERE entry_id = '" . $entryid . "'" );
        } else {
            if ( ! empty( $lastid ) ) {

                $tbl_visitor = $wpdb->prefix . "frm_visitors";
                $purlformat  = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "` WHERE id = '" . $lastid . "'" );

            }
        }
        if ( ! empty( $purlformat ) ) {
           $pururls = site_url() . $purlformat->purl;
        }
        ?>

        <?php
            if ($form_action == 'update' && $formpage == 'create') {
                    echo "<label class='frm_primary_label'>Purl Value</label>";
                    ?>
                    <input type="text" readonly  name="my_field_name" value="<?php echo htmlentities($pururls); ?>">
                <?php
            } else {
                ?>
              <script>
                /*jQuery("input[name='item_key']").hide();
                jQuery("input[name='item_key']").parent().hide();*/
              </script><?php
            }

    }
}


function custom_rewrite_tag() {
    //add_rewrite_tag('%purl%', '([^&]+)');
    add_rewrite_tag( '%purl%', '([^&]+)' );
    // add_rewrite_tag('%uses%', '([^&]+)');
}

add_action( 'init', 'custom_rewrite_tag', 10, 0 );
function custom_rewrite_basic() {
    add_rewrite_rule( '^purlform/([^/]+)/?', 'index.php?pagename=purlform&purl=$matches[1]', 'top' );
    flush_rewrite_rules();
}

add_action( 'init', 'custom_rewrite_basic', 10, 0 );


function plur_form_func( $atts ) {


    global $wpdb, $wp_query;
    $diabledform = '';
    if (isset($wp_query->query_vars['purl'])) :
        $plurfiled   = '/' . $wp_query->query_vars['purl'];
        //echo $wp_query->query_vars['purl'];
        $findfiled = $wp_query->query_vars['purl'];
        //echo $findfiled;
        $totalfileds       = explode( "-", $findfiled );
        $fnamelnameformate = 'no';
        if ( count( $totalfileds ) == 3 ) {
            // echo "first-name and lastname";
            $purlfirstname = $totalfileds[0];
            $purllastname  = $totalfileds[1];
            $tbl_visitor   = $wpdb->prefix . "frm_visitors";
            $purlformatid  = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `firstname` LIKE '" . $purlfirstname . "' and lastname LIKE '" . $purllastname . "' ORDER BY `id` DESC" );
            if ( !empty( $purlformatid ) ) {
                $fnamelnameformate = 'yes';
            }

        }
        ob_start();
        $compnyformate = 'no';
        if ( count( $totalfileds ) == 2 ) {
            // echo "compny";
            $compnyname = $totalfileds[0];
            // $purllastname =  $totalfileds[1];
            $tbl_visitor  = $wpdb->prefix . "frm_visitors";
            $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `company_purl` LIKE '" . $compnyname . "'" );
            if ( !empty( $purlformatid ) ) {
                $compnyformate = 'yes';
            }
            //echo $compnyformate;
        }

        $diabledforms = '';
        //echo "string".$plurfiled;
        $tbl_visitor  = $wpdb->prefix . "frm_visitors";
        $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `purl` LIKE '" . $plurfiled . "' ORDER BY `id` DESC" );
        //print_r($purlformatid);
        $entryid     = $purlformatid->entry_id;
        $form_id     = $purlformatid->form_id;

        $security_id = $purlformatid->uniqueid;
        if ( $security_id == $findfiled ) {
            $diabledform = "true";
        }
        if (  ! empty( $purlformatid ) && ! empty( $security_id ) ) {
            $uniqueidget = strpos( $findfiled, $security_id );
        }
        $tbl_purl = $wpdb->prefix . "frm_purl";

        if ( ! empty( $uniqueidget ) ) {
            $diabledform = "true";
        }


        ?>
        <?php
        if ( isset( $_POST['save'] ) || isset( $_POST['form_id'] ) ) {

            if ( ! isset( $_POST['frm_code'] ) ) {
                $formenetrcode = $security_id;
            } else {
                $formenetrcode = $_POST['frm_code'];
            }
            if ( $formenetrcode != $security_id ) {
                echo "Code Is Invalid";
                ?>
              <div class="fornm" <?php if ( $diabledform == 'true' ) { ?> style="display:none" <?php } ?>>
                <form method="post" action="">
                  <input type="hidden" name="frm_action" value="edit">
                  <input type="hidden" name="entrynumber" value="<?php echo $entryid; ?>">
                  <input type="text"
                         name="frm_code" <?php if ( $diabledform == 'true' ) { ?> value="<?php echo $security_id; ?>" <?php } ?>
                         placeholder="Please Enter your Code">
                  <input type="submit" class="security-class" name="save" value="save">
                </form>
              </div>
                <?php

            } else {
                // echo "<pre>";
                //print_r($_POST['item_meta']);
                if ( isset( $_POST['item_meta'] ) ) {
                    $variable = $_POST['item_meta'];
                    $itemkey  = $_POST['item_key'];


                    // echo "<pre>";
                    // print_r($unsearry);
                    // echo "</pre>";
                    $filedvalues = array();
                    $filedkeyid  = array();
                    $tbl_fildes_postions = $wpdb->prefix . "frm_fields";

                    $formarrays  = $wpdb->get_row( "SELECT * FROM ".$tbl_fildes_postions." WHERE form_id = ".$form_id." AND type ='radio'" );

                    if(!empty($formarrays)){
                        $filedradiokeyid = $formarrays->id;
                    }



                    foreach ( $variable as $key => $value ) {
                        # code...
                        //		echo $key;
                        //		echo $value;
                        if($filedradiokeyid == $key){
                            $radiokey = count($filedkeyid);
                        }
                        $filedkeyid[]  = $key;
                        $filedvalues[] = $value;

                        //echo "</br>";
                    }
                    $fname       = $filedvalues[1];
                    $lname       = $filedvalues[2];
                    $companyname = $filedvalues[3];
                    $email       = Cryptor::Encrypt($filedvalues[4],CRYPT_KEY);
                    $phonnumber  = Cryptor::Encrypt($filedvalues[5],CRYPT_KEY);
                    $redirectid  = '';
                    $radioselectdname = '';
                    if(!empty($radiokey)) {
                        $redirectid      = $filedkeyid[ $radiokey ];
                        $radioselectdname = $filedvalues[ $radiokey ];
                    }
                    global $wpdb;
                    $tbl_fildes = $wpdb->prefix . "frm_fields";
                    $formarray  = $wpdb->get_row( "SELECT 	options FROM " . $tbl_fildes . " WHERE `id` = " . $redirectid . " ORDER BY `id` DESC" );
                    $formarray  = $formarray->options;
                    $unsearry   = unserialize( $formarray );
                    $is         = 1;
                    $urlnumber  = '';
                    $redirct    = array();
                    if ( ! empty( $unsearry ) ) {
                        foreach ( $unsearry as $key => $value ) {
                            # code...
                            $orignalvalue = $value['value'];
                            if ( $orignalvalue == $radioselectdname ) {
                                //echo $value['value'];
                                //echo "<br>";
                                $urlnumber = $is;

                            }
                            //	echo $value['value'];
                            if(!empty($filedvalues[ $radiokey + $is ])) {
                                $redirct[ $is ] = $filedvalues[ $radiokey + $is ];
                            }

                            $is ++;

                        }
                    }
                    if(!empty($urlnumber)) {

                        global $wpdb;
                        $tbl_purl      = $wpdb->prefix . "frm_visitors";
                        $update_format = "UPDATE " . $tbl_purl . " SET `firstname` = '" . $fname . "', `lastname` = '" . $lname . "', `email` = '" . $email . "', `phone` = '" . $phonnumber . "', `company` = '" . $companyname . "'  WHERE `uniqueid` = '" . $itemkey . "'";
                        // echo $update_format;
                        $wpdb->query( $update_format );
                    }

                    if(!empty($urlnumber)) {
                        $rdirecturl = $redirct[ $urlnumber ];
                    }
                    //if(!empty($redircturl)){
                    // We are trying to redirect to another site, using a hard-coded URL.
                    if ( ! empty( $rdirecturl ) ) {
                        wp_redirect( $rdirecturl );
                    }

                    //   }

                }

                //echo "</pre>";
                $_POST['entry'] = $entryid; 

                add_filter( 'frm_user_can_edit', 'check_user_edit_form', 10, 2 );
                // if($_POST['save']){
                echo do_shortcode( '[formidable id="' . $form_id . '" ]' );
                //  }
            }
        } else {
            ?>
          <div class="fornm" <?php if ( $diabledform == 'true' ) { ?> style="display:none" <?php } ?>>
            <form method="Post" action="">
              <input type="hidden" name="frm_action" value="edit">
              <input type="hidden" name="entrynumber" value="<?php echo $entryid;?> " >
              <input type="text"
                     name="frm_code" <?php if ( $diabledform == 'true' ) { ?> value="<?php echo $security_id; ?>" <?php } ?>
                     placeholder="Please Enter your Code">
              <input type="submit" class="security-class" name="save" value="save">
            </form>
          </div>
            <?php
        }

        ?>
        <?php if ( $diabledform == 'true' ) { ?>

      <script type="text/javascript">
        jQuery(document).ready(function () {
          jQuery('.frm-show-form .frm_top_container input').each(function (index, value) {
              <?php if($fnamelnameformate == 'yes'){?>
            if (index == 0 || index == 1) {
              //console.log(index);
              if (jQuery(this).val() != '') {
                jQuery(this).attr('readonly', 'readonly');
              }
            }
              <?php }?>
              <?php if($compnyformate == 'yes'){?>
            if (index == 2) {
              //console.log(index);
              if (jQuery(this).val() != '') {
                jQuery(this).attr('readonly', 'readonly');
              }
            }
              <?php }?>

          });
          jQuery(".security-class").trigger("click");
        });
      </script>
    <?php } ?>
        <?php
        return ob_get_clean();
    endif;
}

add_shortcode( 'purlform', 'plur_form_func' );
function check_user_edit_form( $edit, $args ) {
    return true;
}


add_filter( 'frm_user_can_edit', 'check_user_edits_form', 10, 2 );
function check_user_edits_form( $edit, $args ) {
    $form_id = is_numeric( $args['form'] ) ? $args['form'] : $args['form']->id;

    $formids     = get_option( 'plur_form_ids', true );
    $formlist    = array();
    $formplurids = explode( ",", $formids );
    $formlist    = array_merge( $formlist, $formplurids );

    if ( in_array( $form_id, $formlist ) ) { //change 5 to the ID of your group form
        $edit = true;
    }

    return $edit;
}


//Delete Entry In Plur Table.
add_action( 'frm_before_destroy_entry', 'delete_plur_entry' );
function delete_plur_entry( $entry_id ) {
    global $wpdb;
    $id          = $entry_id;
    $tbl_visitor = $wpdb->prefix . "frm_visitors";
    $wpdb->delete( $tbl_visitor, array( 'entry_id' => $id ) );

}

add_action( 'frm_show_entry', 'show_plur_entry' );

function show_plur_entry( $entry ) {
    global $wpdb;
    $entryid     = $_REQUEST['id'];
    $tbl_visitor = $wpdb->prefix . "frm_visitors";
    $purlformat  = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "` WHERE entry_id = '" . $entryid . "'" );
    $pururls ='';
    if(!empty($purlformat)){
        //if( count($purlformat) >= 1) {
              $pururls = site_url().$purlformat->purl;
        //}
    }
        ?>
      <table class="form-table">
        <tbody>
        <tr>
          <th scope="row">Purl Value:</th>
          <td>
            <a target="_blank" href="<?php echo htmlentities($pururls); ?>"><?php echo $pururls ?></a>
          </td>
        </tr>
        </tbody>
      </table>
        <?php
}

register_deactivation_hook( __FILE__, 'purl_deactivate' );
function purl_deactivate() {
    global $wpdb;
    $tbl_purl      = $wpdb->prefix . "frm_purl";
    $update_format = "UPDATE `" . $tbl_purl . "`  SET `select_url` = '0' WHERE `select_url` = '1'";
    $wpdb->query( $update_format );

    //added 5 digit pincode added
    $purlget = $wpdb->get_row( "SELECT * FROM `" . $tbl_purl . "` WHERE url_format='5digitpin' ORDER BY `id` DESC LIMIT 1 " );
    $purlid  = $purlget->id;
    if ( empty( $purlid ) ) {
        $insert_format = "INSERT INTO  " . $tbl_purl . " (`id`, `url_format`, `select_url`) VALUES (NULL, '5digitpin', '0');";
        $wpdb->query( $insert_format );
    }

}


//allow redirection, even if my theme starts to send output to the browser
add_action( 'init', 'do_output_buffer' );
function do_output_buffer() {
    ob_start();
}


/**
 * Redirect Other Page when User Submit form.
 */
function wpse12535_redirect_sample() {
    global $wpdb, $wp_query;

    $tbl_visitor = $wpdb->prefix . "frm_visitors";
    $purl_name   = $wp_query->query_vars['name'];
    $usersql     = "SELECT * FROM " . $tbl_visitor . " WHERE  purl LIKE '" . '/' . $purl_name . "'";
    //echo $usersql;

    $username = $wpdb->get_results( $usersql );
    $usercnt  = count( $username );
    if ( $usercnt >= 1 ) {

        if ( isset( $_SERVER['HTTPS'] ) && ( $_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1 ) || isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }

        $location = get_site_url() . "/purlform/" . $purl_name;
        if ( ! isset( $_REQUEST['post_type'] ) ) {
            exit( wp_redirect( $location, 301 ) );
        }
    }
}

add_action( 'wp', 'wpse12535_redirect_sample' );


add_filter( 'frm_csv_columns', 'remove_id_column', 10, 2 );

/**
 * @param $headings
 * @param $form_id
 *
 * ADD CSV FILE HEADING HOOK
 * @return array
 */
function remove_id_column( $headings, $form_id ) {
    $formids     = get_option( 'plur_form_ids', true );
    $formlist    = array();
    $formplurids = explode( ",", $formids );
    $formlist    = array_merge( $formlist, $formplurids );


    if ( in_array( $form_id, $formlist ) ) {
        //( ['ids'] ); //change id to the header of the column to be removed
        $arr      = array( 'purlurl' => 'Purl Name' );
        $headings = array_merge( $headings, $arr );

    }


    return $headings;
}

/**
 *
 */
add_filter( 'frm_csv_row', 'remov_id_column', 10, 1 );
function remov_id_column( $row ) {

    global $wpdb;
    $keys        = $row['item_key'];
    $tbl_visitor = $wpdb->prefix . "frm_visitors";
    //$purl_name = $wp_query->query_vars['name'];
    $usersql = "SELECT * FROM " . $tbl_visitor . " WHERE  uniqueid LIKE '" . $keys . "'";
    //echo $usersql;

    $purl_url = $wpdb->get_row( $usersql );

    $purlid = $purl_url->purl;
    if ( ! empty( $purlid ) ) {
        $purlid = site_url() . $purl_url->purl;

    } else {
        $purlid = '';
    }
    $arr = array( 'purlurl' => $purlid );
    $row = array_merge( (array) $row, (array) $arr );


    return $row;
}


/**
 * firstname name  Short code actions.
 */
add_shortcode( 'firstname', 'plur_firstname' );


/**
 * firstname name  Short code Functions.
 */
function plur_firstname() {
    ob_start();
    $entrykey    = '';
    $plurfiled   = '';
    $firstname   = '';
    $security_id = '';
    $formcode    = '';
    if ( isset( $_REQUEST['entrykey'] ) ) {
        $entrykey = $_REQUEST['entrykey'];
    }
    if ( isset( $_REQUEST['entry'] ) ) {
        $entrykey  = $_REQUEST['entry'];
        $firstname = 'yes';
        if ( isset( $_REQUEST['firstname'] ) ) {
            $firstname = $_REQUEST['firstname'];
        }
    }
    global $wp_query, $wpdb;
    if ( isset( $_REQUEST['frm_code'] ) ) {
        $plurfiled = '/' . $wp_query->query_vars['purl'];
        $formcode  = $_REQUEST['frm_code'];

    }

    $tbl_visitor = $wpdb->prefix . "frm_visitors";
    if ( ! empty( $entrykey ) ) {
        if ( ! empty( $firstname ) ) {
            $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `uniqueid` LIKE '" . $entrykey . "' AND firstname = '" . $firstname . "' ORDER BY `id` DESC" );

        } else {
            $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `uniqueid` LIKE '" . $entrykey . "' ORDER BY `id` DESC" );
        }
    } else {
        $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `purl` LIKE '" . $plurfiled . "' ORDER BY `id` DESC" );
        if ( ! empty( $purlformatid ) ) {
            $security_id = $purlformatid->uniqueid;
        }
        if ( $formcode !== $security_id ) {
            $purlformatid = '';

        }

    }
    if ( ! empty( $purlformatid ) ) {
        $firstname = $purlformatid->firstname;
        echo $firstname;

    }

    return ob_get_clean();

}

/**
 * Last name Short code actions
 */
add_shortcode( 'lastname', 'plur_lastname' );

/**
 * Last name Short code Functions
 */
function plur_lastname() {
    ob_start();
    $entrykey  = '';
    $firstname = '';
    if ( isset( $_REQUEST['entrykey'] ) ) {
        $entrykey = $_REQUEST['entrykey'];
    }
    if ( isset( $_REQUEST['entry'] ) ) {
        $entrykey  = $_REQUEST['entry'];
        $firstname = 'yes';
        if ( isset( $_REQUEST['firstname'] ) ) {
            $firstname = $_REQUEST['firstname'];
        }
    }
    global $wp_query, $wpdb;
    if ( isset( $_REQUEST['frm_code'] ) ) {
        $plurfiled = '/' . $wp_query->query_vars['purl'];
        $formcode  = $_REQUEST['frm_code'];

    }

    $tbl_visitor = $wpdb->prefix . "frm_visitors";
    if ( ! empty( $entrykey ) ) {
        if ( ! empty( $firstname ) ) {
            $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `uniqueid` LIKE '" . $entrykey . "' AND firstname = '" . $firstname . "' ORDER BY `id` DESC" );

        } else {
            $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `uniqueid` LIKE '" . $entrykey . "' ORDER BY `id` DESC" );
        }
    } else {
        $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `purl` LIKE '" . $plurfiled . "' ORDER BY `id` DESC" );
        $security_id  = $purlformatid->uniqueid;
        if ( $formcode !== $security_id ) {
            $purlformatid = '';

        }

    }

    if ( ! empty( $purlformatid ) ) {
        $firstname = $purlformatid->lastname;
        echo $firstname;
    }

    return ob_get_clean();

}

/**
 * Company Short code actions
 */
add_shortcode( 'company', 'plur_company' );

/**
 * Company Short code Functions
 */
function plur_company() {
    ob_start();
    $entrykey  = '';
    $formcode  = '';
    $firstname = '';
    if ( isset( $_REQUEST['entrykey'] ) ) {
        $entrykey = $_REQUEST['entrykey'];
    }
    if ( isset( $_REQUEST['entry'] ) ) {
        $entrykey  = $_REQUEST['entry'];
        $firstname = 'yes';
        if ( isset( $_REQUEST['firstname'] ) ) {
            $firstname = $_REQUEST['firstname'];
        }
    }
    global $wp_query, $wpdb;
    if ( isset( $_REQUEST['frm_code'] ) ) {
        $plurfiled = '/' . $wp_query->query_vars['purl'];
        $formcode  = $_REQUEST['frm_code'];

    }


    $tbl_visitor = $wpdb->prefix . "frm_visitors";
    if ( ! empty( $entrykey ) ) {
        if ( ! empty( $firstname ) ) {
            $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `uniqueid` LIKE '" . $entrykey . "' AND firstname = '" . $firstname . "' ORDER BY `id` DESC" );

        } else {
            $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `uniqueid` LIKE '" . $entrykey . "' ORDER BY `id` DESC" );
        }
    } else {
        $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `purl` LIKE '" . $plurfiled . "' ORDER BY `id` DESC" );
        $security_id  = $purlformatid->uniqueid;
        if ( $formcode !== $security_id ) {
            $purlformatid = '';

        }

    }

    if ( ! empty( $purlformatid ) ) {
        $compnyname = $purlformatid->company;
        echo $compnyname;
    }

    return ob_get_clean();

}


/**
 * Telephone number Short code actions.
 */
add_shortcode( 'telephonenumber', 'plur_telephonenumber' );

/**
 * Telephone number Short code Functions.
 */
function plur_telephonenumber() {
    ob_start();
    $entrykey  = '';
    $firstname = '';
    if ( isset( $_REQUEST['entrykey'] ) ) {
        $entrykey = $_REQUEST['entrykey'];
    }
    if ( isset( $_REQUEST['entry'] ) ) {
        $entrykey  = $_REQUEST['entry'];
        $firstname = 'yes';
        if ( isset( $_REQUEST['firstname'] ) ) {
            $firstname = $_REQUEST['firstname'];
        }
    }
    global $wp_query, $wpdb;
    if ( isset( $_REQUEST['frm_code'] ) ) {
        $plurfiled = '/' . $wp_query->query_vars['purl'];
        $formcode  = $_REQUEST['frm_code'];

    }

    $tbl_visitor = $wpdb->prefix . "frm_visitors";
    if ( ! empty( $entrykey ) ) {
        if ( ! empty( $firstname ) ) {
            $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `uniqueid` LIKE '" . $entrykey . "' AND firstname = '" . $firstname . "' ORDER BY `id` DESC" );
        } else {
            $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `uniqueid` LIKE '" . $entrykey . "' ORDER BY `id` DESC" );
        }
    } else {
        $purlformatid = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `purl` LIKE '" . $plurfiled . "' ORDER BY `id` DESC" );
        $security_id  = $purlformatid->uniqueid;
        if ( $formcode !== $security_id ) {
            $purlformatid = '';

        }


    }

    if ( ! empty( $purlformatid ) ) {
        $phonenumber = $purlformatid->phone;
        echo $phonenumber;
    }

    return ob_get_clean();

}


//After Entry Created Entry.
add_action( 'frm_after_update_entry', 'after_entry_created', 30, 2 );

/**
 * After Entery Created  Form actions.
 *
 * @param $entry_id
 * @param $form_id
 *
 */
function after_entry_created( $entry_id, $form_id ) {
    // Form Encryptions code here
    $formids     = get_option( 'plur_form_encrypt_filed_ids', true );
    $formlist    = array();
    $formplurids = explode( ",", $formids );
    $formlist    = array_merge( $formlist, $formplurids );
    $data = '';
    if(!empty($entry_id)){ 
     $_POST['entry'] = $entry_id;
    }

    $frm_encrypted_fields = $formlist;


    //  We need to loop through the fields to determine which are supposed to be enrypted.

    $fields = FrmField::get_all_for_form( $form_id );

    foreach ( $fields as $key => $value ) {

        if ( in_array( $value->id, $frm_encrypted_fields ) ) {
            if(!empty($_POST['item_meta'][ $value->id ])) {
                $data = Cryptor::Encrypt( $_POST['item_meta'][ $value->id ], CRYPT_KEY );
            }
            FrmEntryMeta::update_entry_meta( $entry_id, $value->id, '', $data );

        }

    }

    //echo $entry_id;
    if ( isset( $_POST['item_meta'] ) && ! isset( $_REQUEST['page'] ) ) {
        global  $wpdb;
        $tbl_fildes_postions = $wpdb->prefix . "frm_fields";
        $formarrays  = $wpdb->get_row( "SELECT * FROM ".$tbl_fildes_postions." WHERE form_id = ".$form_id." AND type ='radio'" );

        if(!empty($formarrays)){
            $filedradiokeyid = $formarrays->id;
        }

        $variable    = $_POST['item_meta'];
        $itemkey     = $_POST['item_key'];
        $filedvalues = array();
        $filedkeyid  = array();
        $radiokey = '';


        foreach ( $variable as $key => $value ) {
            # code...
            if($filedradiokeyid == $key){
                $radiokey = count($filedkeyid);
            }
            $filedkeyid[]  = $key;
            $filedvalues[] = $value;

            //echo "</br>";
        }
        $fname       = $filedvalues[1];
        $lname       = $filedvalues[2];
        $companyname = $filedvalues[3];
        $email       = Cryptor::Encrypt($filedvalues[4],CRYPT_KEY);
        $phonnumber  = Cryptor::Encrypt($filedvalues[5],CRYPT_KEY);
        $redirectid  = '';
        $radioselectdname = '';
        if(!empty($radiokey)) {
            $redirectid      = $filedkeyid[ $radiokey ];
            $radioselectdname = $filedvalues[ $radiokey ];
        }
        global $wpdb;
        $tbl_fildes = $wpdb->prefix . "frm_fields";
        $formarray  = $wpdb->get_row( "SELECT 	options FROM " . $tbl_fildes . " WHERE `id` = " . $redirectid . " ORDER BY `id` DESC" );
        $formarray  = $formarray->options;
        $unsearry   = unserialize( $formarray );
        $is         = 1;
        $urlnumber  = '';
        $redirct    = array();
        if ( ! empty( $unsearry ) ) {
            foreach ( $unsearry as $key => $value ) {
                # code...
                $orignalvalue = $value['value'];
                if ( $orignalvalue == $radioselectdname ) {
                    //echo $value['value'];
                    //echo "<br>";
                    $urlnumber = $is;
                }
                //	echo $value['value'];
                if(!empty($filedvalues[ $radiokey + $is ])) {
                    $redirct[ $is ] = $filedvalues[ $radiokey + $is ];
                }
                $is ++;
            }
        }


        if(!empty($urlnumber)) {

            global $wpdb;
            $tbl_purl      = $wpdb->prefix . "frm_visitors";
            $update_format = "UPDATE " . $tbl_purl . " SET `firstname` = '" . $fname . "', `lastname` = '" . $lname . "', `email` = '" . $email . "', `phone` = '" . $phonnumber . "', `company` = '" . $companyname . "'  WHERE `uniqueid` = '" . $itemkey . "'";
            // echo $update_format;
            $wpdb->query( $update_format );


            $rdirecturl = $redirct[ $urlnumber ];
        }
        //if(!empty($redircturl)){
        // We are trying to redirect to another site, using a hard-coded URL.
        if ( isset( $_POST['item_meta'] ) && ! isset( $_REQUEST['page'] ) ) {
            if ( ! empty( $rdirecturl ) ) {
                wp_redirect( $rdirecturl );
            }
        }


        //   }

    }

}

// Encryptions Code Start Here
/*  Add any field ids that should be encrypted to this array. We can figure out a good way to do this from the admin panel if we go this route. */

//$frm_encrypted_fields = array (96, 97);
//  When a new form is submitted, check fields and encrypt if needed.

add_filter( 'frm_add_entry_meta', 'purl_change_due_date' );

function purl_change_due_date( $new_values ) {
    $formids     = get_option( 'plur_form_encrypt_filed_ids', true );
    $formlist    = array();
    $formplurids = explode( ",", $formids );
    $formlist    = array_merge( $formlist, $formplurids );


    $frm_encrypted_fields = $formlist;


    if ( in_array( $new_values['field_id'], $frm_encrypted_fields ) ) {
        if(!empty($new_values['meta_value'])) {
            $new_values['meta_value'] = Cryptor::Encrypt( $new_values['meta_value'], CRYPT_KEY );
        }
    }

    return $new_values;

}

//  When a encrypted data has been updated... uuhhh, encrypt it.

//add_action( 'frm_after_update_entry', 'purl_frm_encrypted_updates', 10, 2 );
//
//function purl_frm_encrypted_updates( $entry_id, $form_id ) {
//
//
//
//}

//  Replace encrypted blob with "Encrypted" wherever the simple shortcode is used on the front-end.

add_filter( 'frmpro_fields_replace_shortcodes', 'purl_frm_encrypted_view_frontend', 10, 4 );

function purl_frm_encrypted_view_frontend( $replace_with, $tag, $atts, $field ) {

    global $frm_encrypted_fields;
    $entryid = $atts['entry_id'];
    if ( in_array( $tag, $frm_encrypted_fields ) ) {

        //$replace_with = ' Encrypted';

        global $wpdb;
        $tbl_meta = $wpdb->prefix . "frm_item_metas";

        $querystr = 'SELECT meta_value FROM ' . $tbl_meta . ' WHERE field_id="' . $field->id . '" AND item_id="' . $entryid . '"';

        //echo $querystr;
        $meta_value = $wpdb->get_var( $querystr );
        //print_r($meta_value);

        if ( $meta_value ) {

            try {
                if(!empty($replace_with)) {
                    $replace_with = Cryptor::Decrypt( $replace_with, CRYPT_KEY );
                }

            } catch ( Exception $e ) {

                //$values['value'] = $e->getMessage() . ' ' . $data;    //  Strictly for troubleshoot exceptions.

            }

            //  If you have the bootstrap addon, you can change the snazzy little icon.

            //$replace_with = '';

        }

    }

    return $replace_with;

}

//  Replace encrypted blob with "Encrypted" on the back-end.

add_filter( 'frm_display_value', 'purl_frm_encrypted_view_backend', 10, 3 );

function purl_frm_encrypted_view_backend( $value, $field, $atts ) {

    global $frm_encrypted_fields;


    if ( in_array( $field->id, $frm_encrypted_fields ) && is_admin() ) {


        $value = ' Encrypted';


    }

    return $value;

}

//  When editing a form, decrypt the data and display it for editing.

add_filter( 'frm_setup_edit_fields_vars', 'purl_frm_show_encrypted_field', 20, 3 );

function purl_frm_show_encrypted_field( $values, $field, $entry_id ) {

    global $frm_encrypted_fields;

    // print_r($field);

    if ( in_array( $field->id, $frm_encrypted_fields ) ) {
        //echo 'adad';
        global $wpdb;
        $tbl_meta = $wpdb->prefix . "frm_item_metas";

        $querystr = 'SELECT meta_value FROM ' . $tbl_meta . ' WHERE field_id="' . $field->id . '" AND item_id="' . $entry_id . '"';

        //echo $querystr;
        $meta_value = $wpdb->get_var( $querystr );
        //print_r($meta_value);

        if ( $meta_value ) {

            //  print_r($values);

            try {
                if(!empty($values['value'])) {
                    $values['value'] = Cryptor::Decrypt( $meta_value, CRYPT_KEY );
                }

            } catch ( Exception $e ) {

                //$values['value'] = $e->getMessage() . ' ' . $data;    //  Strictly for troubleshoot exceptions.

            }

            //  If you have the bootstrap addon, you can change the snazzy little icon.

            $values['btsp']['prepend'] = '';

        }

    }

    return $values;

}

/**
 * Csv values EXPorted values.
 */
//add_filter('frm_csv_value', 'purl_frm_csv_value_update', 10, 2);
//function purl_frm_csv_value_update($value, $atts) {
//
//   global  $frm_encrypted_fields;
//
////	$frm_encrypted_fields = $formlist;
//	if(in_array($atts['field']->id, $frm_encrypted_fields) && is_admin()){
//		$value = Cryptor::Decrypt( $value, CRYPT_KEY );
//	}
//
//	return $value;
//
//}
//
//Email Html Text type filtered
add_filter('frm_display_text_value_custom', 'purl_frm_email_val', 10, 2);
add_filter('frm_display_phone_value_custom', 'purl_phonetype_frm_email_val', 10, 2);
add_filter('frm_display_email_value_custom', 'purl_emailtype_frm_email_val', 10, 2);

function purl_frm_email_val($value, $meta){
    // $meta;
    global $frm_encrypted_fields;
    $formante = '';
    if(!empty($_POST)) {
        $formante = $_POST['frm_action'];
    }
    if ( in_array( $meta['field']->id, $frm_encrypted_fields ) ) {
        //change  to the ID of your field
        if(isset($_REQUEST['frm_action'])){
            $formante = $_REQUEST['frm_action'];
        }

        if($formante == 'show' ){
            $value = $value;
        }else {
            if($formante == 'update' ){
                $value = Cryptor::Encrypt( $value, CRYPT_KEY );
            }
            if (strlen($value) < 35){
                $value = Cryptor::Encrypt( $value, CRYPT_KEY );
              }
            if ( ! empty( $value ) ) {
                $value = Cryptor::Decrypt( $value, CRYPT_KEY ); //change the value here
            }
        }
    }
    return $value;
}

//Email Html   email type filtered
function purl_emailtype_frm_email_val($value, $meta){
    // $meta;
    global $frm_encrypted_fields;
    $formante = '';
    if(!empty($_POST)) {
        $formante = $_POST['frm_action'];
    }
    if ( in_array( $meta['field']->id, $frm_encrypted_fields ) ) {
        //change  to the ID of your field
        if(isset($_REQUEST['frm_action'])){
            $formante = $_REQUEST['frm_action'];
        }
        if($formante == 'show'){
            $value = $value;
        }else {
            if($formante == 'update' ){
                $value = Cryptor::Encrypt( $value, CRYPT_KEY );
            }
            //			if (strlen($value) < 35){
            //				$value = Cryptor::Encrypt( $value, CRYPT_KEY );
            //			}
            if ( ! empty( $value ) ) {

                $value = Cryptor::Decrypt( $value, CRYPT_KEY ); //change the value here
            }
        }
    }
    return $value;
}

//Email Html   email type filtered
function purl_phonetype_frm_email_val($value, $meta){
    // $meta;
    global $frm_encrypted_fields;
    $formante = '';
    if(!empty($_POST)) {
        $formante = $_POST['frm_action'];
    }

    if ( in_array( $meta['field']->id, $frm_encrypted_fields ) ) {
        //change  to the ID of your field
        if(isset($_REQUEST['frm_action'])){
            $formante = $_REQUEST['frm_action'];
        }
        if($formante == 'show'){
            $value = $value;
        }else {
            if($formante == 'update' ){
                $value = Cryptor::Encrypt( $value, CRYPT_KEY );
            }
            //			if (strlen($value) < 35){
            //				$value = Cryptor::Encrypt( $value, CRYPT_KEY );
            //			}
            if ( ! empty( $value ) ) {
                $value = Cryptor::Decrypt( $value, CRYPT_KEY ); //change the value here
            }
        }
    }
    return $value;
}




//add_shortcode('purl','plur_purlurl_shortcode_functions');
/*
*  Purl Url Short Code Functions.
**/
// function plur_purlurl_shortcode_functions(){
// global $wpdb;    
// $tbl_visitor = $wpdb->prefix . "frm_visitors";
// $usersql     = "SELECT * FROM " . $tbl_visitor;
// $dataurls    = $wpdb->get_results( $usersql );
// //echo $usersql;
// $username = $wpdb->get_results( $usersql );
//         echo "string";
//         echo "<pre>";
//         print_r($username);
//         echo "<pre>";

// }


add_shortcode( 'purl', 'plur_purlurl' );
/**
 * firstname name  Short code Functions for purl urls
 */
function plur_purlurl() {
    ob_start();
    global $wpdb;
    if(isset($_REQUEST)){
    $form_id     = $_REQUEST['form_id'];
    $formids     = get_option( 'plur_form_ids', true );
    $formlist    = array();
    $formplurids = explode( ",", $formids );
    $formlist    = array_merge( $formlist, $formplurids );
    if ( $_REQUEST['frm_action'] == 'create'){
        if(is_array($formlist)){

            if ( in_array( $form_id, $formlist ) ) {


                $form_args = $_POST['item_meta'];


                if ( ! empty( $form_args ) ) {
                    foreach ( $form_args as $key ) {
                        # code...
                        $fildename[] = $key;
                    }

                  }
               }   
       

                if ( $_REQUEST['frm_action'] == 'create' && isset( $_POST['item_key'] ) ) {
                    $fname       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[1])));
                    $lname       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[2])));
                    $company       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[3])));
                    $companyname = addslashes($fildename[3]);
                    $email       = Cryptor::Encrypt($fildename[4],CRYPT_KEY);
                    $phonnumber  = Cryptor::Encrypt($fildename[5],CRYPT_KEY);
                    $form_key    = $_POST['item_key'];
                    //  echo $test;
                }


                $tbl_purl    = $wpdb->prefix . "frm_purl";
                $tbl_visitor = $wpdb->prefix . "frm_visitors";
                //plur Created code here start.
                $purlformat = $wpdb->get_row( "SELECT * FROM `" . $tbl_purl . "` WHERE select_url = '1'" );
                $purkid     = $purlformat->url_format;
                if ( $purkid == 'firstname.lastname' ) //firstname.lastname
                {
                    if ( ! empty( $fname ) || ! empty( $lname ) ) {
                        //echo "string";
                        if ( ! empty( $fname ) && ! empty( $lname ) ) {
                            $purl_name = strtolower( $fname ) . '-' . strtolower( $lname ); //both are there
                        } else if ( empty( $lname ) && ! empty( $fname ) ) {
                            $purl_name = strtolower( $fname ); //only firstname there
                        } else if ( empty( $fname ) && ! empty( $lname ) ) {
                            $purl_name = strtolower( $lname ); // only lastname there
                        }
                        $usersql = "SELECT * FROM " . $tbl_visitor . " WHERE  purl LIKE '" . '/' . $purl_name . "%'";
                        //echo $usersql;
                        $username = $wpdb->get_results( $usersql );
                        $usercnt  = count( $username );
                        if ( $usercnt >= 1 ) {
                            $num       = ++ $usercnt;             // Increment $usercnt by 1
                            $purl_name = $purl_name . '-' . $num;  // Add number to username
                        }
                        //echo $plur_name;
                    } else {
                        $purl_name = '';
                    }
                    //$purl_url = get_bloginfo('url');
                } elseif ( $purkid == 'firstname.lastname.5digitpin' ) //firstname.lastname.5digitpin
                {
                    $purl_name = strtolower( $fname ) . '-' . strtolower( $lname ) . '-' . $form_key;
                } elseif ( $purkid == 'company' ) //company
                {
                    $purl_name = str_replace("'",'',str_replace( ' ', '', strtolower( $company ) ));
                    $usersql   = "SELECT * FROM " . $tbl_visitor . " WHERE  purl LIKE '" . '/' . $purl_name . "%'";
                    //echo $usersql;
                    $username = $wpdb->get_results( $usersql );
                    $usercnt  = count( $username );
                    if ( $usercnt >= 1 ) {
                        $num       = ++ $usercnt;             // Increment $usercnt by 1
                        $purl_name = $purl_name . '-' . $num;  // Add number to username
                    }
                    $purl_url = get_bloginfo( 'url' );
                } elseif ( $purkid == 'company.5digitpin' ) //company.5digitpin
                {
                    $purl_name = str_replace("'",'',str_replace( ' ', '', strtolower( $company ) )) . '-' . $form_key;
                } elseif ( $purkid == '5digitpin' ) //5digitpin
                {
                    $purl_name = $form_key;
                }

                $purl_name = '/' . $purl_name;
                $pururls   = site_url() . $purl_name ;
                echo $pururls;
            }
        }
    }else{
        echo "This shortcode work only email when create entry";
    }
    return ob_get_clean();
}


/**
Purl Url get. 
**/
function  purl_url_get_functions($entry_id){


    global $wpdb;
    $entryid     = $entry_id;
    $tbl_visitor = $wpdb->prefix . "frm_visitors";
    $purlformat  = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "` WHERE entry_id = '" . $entryid . "'" );
    $pururls ='';
    if(!empty($purlformat)){
        //if( count($purlformat) >= 1) {
              $pururls = site_url().$purlformat->purl;
        //}
    }
  //  print_r($_REQUEST);
    return $pururls;

}

/**
When Enter RIGHT Password View Will Show code.
**/
add_action('init','purl_security_code_method');
function purl_security_code_method(){
    if(isset($_REQUEST['frm_code']) ){
            if(!empty($_REQUEST['frm_code'])){
                //frm_code
                global $wpdb;
                $entryid       = $_POST['entrynumber'];
                $formenetrcode = $_POST['frm_code'];
                $securitys_id  = purl_security_code_validations($entryid);
                if ( $formenetrcode == $securitys_id ) {
                    $_POST['entry'] = $_POST['entrynumber'];
                }
          }
       }

}


/**
Get Security Code Urls. 
**/
function purl_security_code_validations($entryid){
    global $wpdb;

    $tbl_visitor        = $wpdb->prefix . "frm_visitors";
    $purlformatid       = $wpdb->get_row( "SELECT * FROM `" . $tbl_visitor . "`  WHERE `entry_id` LIKE " . $entryid . " ORDER BY `id` DESC" );
    $entryid            = $purlformatid->uniqueid;
    return $entryid;
}
