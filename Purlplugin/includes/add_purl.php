<?php
global $wpdb, $current_user;
$tbl_visitor = $wpdb->prefix."frm_visitors";
$tbl_purl    = $wpdb->prefix."frm_purl";

?>

<?php
$selectde_purls = $wpdb->get_row("SELECT * FROM `".$tbl_purl."` WHERE select_url='1' ");
if (isset($_POST['sbt-purl'])) :

    if (isset($_POST['form_id'])) {
        $formid = $_POST['form_id'];
        update_option('plur_form_ids', $formid, true);
        $_SESSION['msg-success'] = 'updated';
    }
    if (isset($_POST['form_filed_id'])) {
        $formfiledid = $_POST['form_filed_id'];
        update_option('plur_form_encrypt_filed_ids', $formfiledid, true);
        $_SESSION['msg-success'] = 'updated';
    }
    if (empty($selectde_purls)) {
        if (isset($_POST['purl-format']) && !empty($_POST['purl-format'])) {
            $wpdb->query("UPDATE `".$tbl_purl."` SET select_url='0' WHERE select_url ='1'");
            $purlval                 = $_POST['purl-format'];
            $up_format               = "UPDATE `".$tbl_purl."` SET select_url='1' WHERE id =".$purlval;
            $up_purl                 = $wpdb->query($up_format);
            $_SESSION['msg-success'] = 'updated';
        } else {
            $_SESSION['msg-warning'] = 'required';
        }
    }

endif;

if (isset($_POST['sbt-cust'])) :
    $fname   = $_POST['firstname'];
    $lname   = $_POST['lastname'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $address = $_POST['address'];
    $company = $_POST['company'];

    $purlformat = $wpdb->get_row("SELECT * FROM `".$tbl_purl."` WHERE select_url = '1'");
    $purkid     = $purlformat->id;
    if ($purkid == '1') //firstname.lastname
    {
        $purl_name = strtolower($fname).'.'.strtolower($lname);
        $purl_url  = get_bloginfo('url');
    } elseif ($purkid == '2') //firstname.lastname.5digitpin
    {
        $purl_name = strtolower($fname).'.'.strtolower($lname);
    } elseif ($purkid == '3') //company
    {
        $purl_name = strtolower($company);
    } elseif ($purkid == '4') //company.5digitpin
    {
        $purl_name = strtolower($company).'.';
    }
    $uniqueid = base64_encode($purl_name);
    $add_cust = "INSERT INTO `".$tbl_visitor."` (firstname, lastname, email, phone, address, company, uniqueid, created_at)
			VALUES ('".$fname."', '".$lname."', '".$email."', '".$phone."', '".$address."', '".$company."', '".$uniqueid."', '".date('Y-m-d H:i')."')";
    $add_info = $wpdb->query($add_cust);
    session_start();
    $_SESSION['msg-save'] = 'added';
endif;

$all_purls      = $wpdb->get_results("SELECT * FROM `".$tbl_purl."` ORDER BY id ASC");
$selectde_purls = $wpdb->get_row("SELECT * FROM `".$tbl_purl."` WHERE select_url='1' ");

?>

<?php
if (isset($_SESSION['msg-warning'])) {
    echo '<div id="message" class="error notice notice-error is-dismissible"><p>Please choose any one format.</p></div>';
    unset($_SESSION['msg-warning']);
} elseif (isset($_SESSION['msg-success'])) {
    echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Format submitted successfully!</p></div>';
    unset($_SESSION['msg-success']);
} elseif (isset($_SESSION['msg-save'])) {
    echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Information submitted successfully!</p></div>';
    unset($_SESSION['msg-save']);
}

// if(empty($all_purls)) { ?>
<div class="wrap">
  <h2><?php _e("Settings") ?></h2>
    <?php
    $license_key = get_option('sample_license_key');

    // echo $license_key;
    if (!empty($license_key)) {
        $api_params = [
            'slm_action'        => 'slm_check',
            'secret_key'        => PURL_SPECIAL_SECRET_KEY,
            'license_key'       => $license_key,
            'registered_domain' => $_SERVER['SERVER_NAME'],
            'item_reference'    => urlencode(PURL_ITEM_REFERENCE),
        ];

        $response = wp_remote_get(add_query_arg($api_params, PURL_LICENSE_SERVER_URL), ['timeout' => 20, 'sslverify' => false]);
    }
    if (isset($_REQUEST['activate_license'])) {

        $license_key = $_REQUEST['sample_license_key'];
        $api_params  = [
            'slm_action'        => 'slm_activate',
            'secret_key'        => PURL_SPECIAL_SECRET_KEY,
            'license_key'       => $license_key,
            'registered_domain' => $_SERVER['SERVER_NAME'],
            'item_reference'    => urlencode(PURL_ITEM_REFERENCE),
        ];
    }
    //       echo $license_key;

    // API query parameters
    if (!empty($license_key)) {
        // Send query to the license manager server
        $query    = esc_url_raw(add_query_arg($api_params, PURL_LICENSE_SERVER_URL));
        $response = wp_remote_get($query, ['timeout' => 20, 'sslverify' => false]);


        // Check for error in the response
        if (is_wp_error($response)) {
            echo "Unexpected Error! The query returned with an error.";
        }

        //var_dump($response);//uncomment it if you want to look at the full response

        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));
        // $license_data->message;

        // TODO - Do something with it.
        // var_dump($license_data);//uncomment it to look at the data
        if (isset($_REQUEST['activate_license'])) {
            if ($license_data->result == 'success') {//Success was returned for the license activation

                //Uncomment the followng line to see the message that returned from the license server
                echo '<div id="success" class="updated notice notice-success is-dismissible"><p>'.$license_data->message.'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';

                //Save the license key in the options table
                update_option('sample_license_key', $license_key);
            } else {

                //Uncomment the followng line to see the message that returned from the license server
                echo '<div id="warning" class="error notice notice-warning is-dismissible"><p>'.$license_data->message.'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                update_option('sample_license_key', '');
            }
        } else {
            //Show error to the user. Probably entered incorrect license key.
            $expire = strtotime($license_data->date_expiry);
            $today  = strtotime("today midnight");
            // print_r($license_data);
            if ($license_data->status != 'blocked') {
                if ($today >= $expire) {
                    $license_data->status = 'expired';
                }
            }

            //print_r($license_data);

            if ($license_data->status != 'active') {
                //Uncomment the followng line to see the message that returned from the license server
                echo '<div id="warning" class="error notice notice-warning is-dismissible"><p>Your Licence Is '.ucfirst($license_data->status).'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                purl_deactivate();

                update_option('sample_license_key', $license_key);
            }
        }
    }

    if (isset($_REQUEST['deactivate_license'])) {
        $license_key = $_REQUEST['sample_license_key'];

        // API query parameters
        $api_params = [
            'slm_action'        => 'slm_deactivate',
            'secret_key'        => PURL_SPECIAL_SECRET_KEY,
            'license_key'       => $license_key,
            'registered_domain' => $_SERVER['SERVER_NAME'],
            'item_reference'    => urlencode(PURL_ITEM_REFERENCE),
        ];

        // Send query to the license manager server
        $query    = esc_url_raw(add_query_arg($api_params, PURL_LICENSE_SERVER_URL));
        $response = wp_remote_get($query, ['timeout' => 20, 'sslverify' => false]);

        // Check for error in the response
        if (is_wp_error($response)) {
            echo "Unexpected Error! The query returned with an error.";
        }

        //var_dump($response);//uncomment it if you want to look at the full response

        // License data.
        $license_data = json_decode(wp_remote_retrieve_body($response));

        // TODO - Do something with it.
        //var_dump($license_data);//uncomment it to look at the data

        if ($license_data->result == 'success') {//Success was returned for the license activation

            //Uncomment the followng line to see the message that returned from the license server
            echo '<div id="success" class="updated notice notice-success is-dismissible"><p>'.$license_data->message.'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';

            //Remove the licensse key from the options table. It will need to be activated again.
            update_option('sample_license_key', '');
            // setting reset functions call
            purl_deactivate();
            $deactivate = 'yes';
        } else {
            //Show error to the user. Probably entered incorrect license key.

            //Uncomment the followng line to see the message that returned from the license server
            echo '<div id="warning" class="error notice notice-warning is-dismissible"><p>'.$license_data->message.'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        }
    }
    ?>

    <?php

    if (isset($_REQUEST['activate_license'])) {
        if (!empty($license_data)) {
            if ($license_data->result == 'success') {
                $licence = 'enable';
            }
        }
    } else {
        if (!empty($license_data)) {

            if ($license_data->status == 'active') {
                $licence = 'enable';
            }
        }
    }
    if ($licence != 'enable' || isset($_REQUEST['deactivate_license'])) {
        ?>
      <p style=" font-weight:bold;font-size: 14px">Please enter the license key for this product to activate it. You
                                                   were
                                                   given a license key when you purchased this
                                                   item.</p>
    <?php } ?>
  <form action="" method="post">
    <table class="form-table">
      <tr>
        <th style="width:100px;"><label for="sample_license_key">License Key</label></th>
        <td><input class="regular-text" type="text" id="sample_license_key" name="sample_license_key" value="<?php

            if (isset($_REQUEST['deactivate_license'])) {
                echo '';
            } else {
                if (isset($_REQUEST['activate_license'])) {
                    echo $license_key = $_REQUEST['sample_license_key'];
                } else {
                    echo get_option('sample_license_key');
                }
            }
            ?> "></td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" name="activate_license" value="Activate" class="button-primary" />
      <input type="submit" name="deactivate_license" value="Deactivate" class="button" />
    </p>
  </form>

    <?php
    $formid      = get_option('plur_form_ids', true);
    $formfiledid = get_option('plur_form_encrypt_filed_ids', '', true);
    $licensekey  = get_option('sample_license_key', true);
    //    $license_data->status == 'active'
    $licence = '';
    if (isset($_REQUEST['activate_license'])) {
        if (!empty($license_data)) {
            if ($license_data->result == 'success') {
                $licence = 'enable';
            }
        }
    } else {
        if (!empty($license_data)) {
            if ($license_data->status == 'active') {
                $licence = 'enable';
            }
        }
    }

    if ($licence === 'enable' && !empty($licensekey)) {
        ?>
      <form id="choose-purl" method="post" class="addform">
        <table class="form-table">
          <tbody>
          <?php if (!empty($selectde_purls)) { ?>
            <tr>
              <th><?php _e("Your purl-format is :"); ?></th>
            </tr>
            <tr>
              <td><?php echo site_url().'/'.$selectde_purls->url_format; ?></td>
            </tr>
            <tr>

              <th><?php _e("Instructions:"); ?></th>
            </tr>
            <tr>
              <td><label> To choose purl format again :</label></br>

                Please deactivate and activate plugin first and choose another format or form after that.</label></td>
            </tr>

          <?php } ?>
          <?php if (empty($selectde_purls)){ ?>
          <tr>

            <th><?php _e("Please choose a purl-format:"); ?></th>
          </tr>
          <?php foreach ($all_purls as $purlinfo) {
              if ($purlinfo->select_url == '1') {
                  $getcheck = "checked";
              } else {
                  $getcheck = "";
              }

              ?>
            <tr>
              <td>
                <label><input type="radio" name="purl-format" value="<?php echo $purlinfo->id; ?>" <?php echo $getcheck; ?>><?php echo site_url().'/'.$purlinfo->url_format; ?>
                </label></td>
            </tr>
          <?php } ?>
          <tr>
              <?php } ?>
          <tr>
            <td><label><?php _e("Enter purl form id here(Example :1,2,8)") ?></label>
              <input type="text" name="form_id" value="<?php echo $formid; ?>" placeholder="Enter Form Id"></td>
          </tr>
          <tr>
            <td><label><?php _e("Enter Encrypt purl form field id here(Example :1,2,8) ") ?></label>
              <input type="text" name="form_filed_id" value="<?php echo $formfiledid; ?>" placeholder="Enter Encrypt Form Filed Id">
            </td>
          </tr>

          <td class="button-bx">
            <input type="submit" class="button button-primary button-large" name="sbt-purl" value="Submit">
          </td>
          </tr>
          </tbody>
        </table>
      </form>
      <div class="clear"></div>
    <?php } ?>
</div>