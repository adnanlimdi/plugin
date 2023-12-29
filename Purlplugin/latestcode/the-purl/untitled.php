<?php
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
                }else{
                    $fname       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[0])));
                    $lname       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[1])));
                    $company       = str_replace(array(':', '\\', '/', '*','"',"'","@"),'',str_replace(',','',str_replace(' ', '',$fildename[2])));
                    $companyname = addslashes($fildename[2]);
                    $email       = Cryptor::Encrypt($fildename[3],CRYPT_KEY);
                    $phonnumber  = Cryptor::Encrypt($fildename[4],CRYPT_KEY);
                    $form_key    = $itemkeys;
                
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
       
    }

  if(isset($_REQUEST['action'])){
            if($_REQUEST['action'] == 'frm_entries_send_email'){
                 $entry_id = $_REQUEST['entry_id'];
                 $pururls = purl_url_get_functions($entry_id);
                 echo $pururls;
            }
        }
    return ob_get_clean();