<?php
	//#############validate email_address data from browser############START
	
chdir('../../');
error_reporting(0);
/**
 * Set some defaults
 */
  $process = false;
  $zone_name = '';
  $entry_state_has_zones = '';
  $error_state_input = false;
  $state = '';
  $zone_id = 0;
  $error = false;
  
  $process_shipping = false;
  $zone_name_shipping = '';
  $entry_state_has_zones_shipping = '';
  $error_state_input_shipping = false;
  $state_shipping = '';
  $zone_id_shipping = 0;
  
  $suburb='';
  $company='';
  $state='';
  $zone_id=false;
  $telephone='';
  $fax='';
  $dob='';
  //$gender='m';
  
  
	function dou($str){
		return $str=str_replace("'","''",$str);
	}
/**
 * Process form contents
 */
if (isset($_GET['action']) && ($_GET['action'] == 'easy_create_account_further')) {//var_dump($_REQUEST);exit();
	
	require('includes/application_top.php');
  	$email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
  	//$newsletter = (ACCOUNT_NEWSLETTER_STATUS == '1' ? false : true);	//由用户选择
  	
  $process = true;
  
  //get requried data
  $gender = zen_db_prepare_input($_GET['sex_hid']);
  
  $firstname = dou(zen_db_prepare_input($_GET['firstname']));
  $lastname = dou(zen_db_prepare_input($_GET['lastname']));
  
  if (ACCOUNT_TELEPHONE == 'true' && zen_not_null($_GET['telephone'])) {
      $telephone = zen_db_prepare_input($_GET['telephone']);
  }  
  
  $street_address = dou(zen_db_prepare_input($_GET['street_address']));
  $postcode = dou(zen_db_prepare_input($_GET['postcode'])); 
   
  $city = dou(zen_db_prepare_input($_GET['city']));
  
  $country = zen_db_prepare_input($_GET['zone_country_id']);
  
   
  //get optional data
//  if (ACCOUNT_GENDER == 'true') {
//    if (isset($_GET['gender'])) {
//      $gender = zen_db_prepare_input($_GET['gender']);
//    } else {
//      $gender = false;
//    }
//  }  

  if (ACCOUNT_COMPANY == 'true' && zen_not_null($_GET['company'])) $company = dou(zen_db_prepare_input($_GET['company']));//echo ACCOUNT_COMPANY;exit();
 
//  if (ACCOUNT_SUBURB == 'true' && zen_not_null($_GET['suburb'])) $suburb = zen_db_prepare_input($_GET['suburb']);  
  
//  if (ACCOUNT_STATE == 'true' && zen_not_null($_GET['state'])) {
//    $state = zen_db_prepare_input($_GET['state']);
//    if (isset($_GET['zone_id'])) {
//      $zone_id = zen_db_prepare_input($_GET['zone_id']);
//    } else {
//      $zone_id = false;
//    }
//  }
//  
// 出生日期项已取消
//  if (ACCOUNT_DOB == 'true' && zen_not_null($_GET['dob'])){
//      $dob=zen_db_prepare_input($_GET['dob']);
//  }else{
      $dob='0001-01-01 00:00:00';
//  }

//	$fax = zen_db_prepare_input($_GET['fax']);  

  

echo 'var firstname="";var lastname="";';
  //valid required data
  if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;		
		echo 'firstname="'.ENTRY_FIRST_NAME_ERROR.'";';exit();
  }

  if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
    $error = true;
    echo 'lastname="'.ENTRY_LAST_NAME_ERROR.'";';exit();
  }  
//  echo strlen($firstname).'--'.ENTRY_FIRST_NAME_MIN_LENGTH.'--'.ENTRY_FIRST_NAME_ERROR.'--'.ENTRY_LAST_NAME_MIN_LENGTH.'--'.ENTRY_LAST_NAME_ERROR;exit();

echo 'var street_address="";';
  if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
    $error = true;
    echo 'street_address="'.ENTRY_STREET_ADDRESS_ERROR.'";';exit();
  }  
  // BEGIN PO Box Ban 1/1
  if (defined('PO_BOX_ERROR')) {
    if ( preg_match('/PO BOX/si', $street_address) ) {
      $error = true;
      echo 'street_address = "'.POP_PO_BOX_ERROR.'";';exit();
    } else if ( preg_match('/POBOX/si', $street_address) ) {
      $error = true;
      echo 'street_address = "'.POP_PO_BOX_ERROR.'";';exit();
    } else if ( preg_match('/P\.O\./si', $street_address) ) {
      $error = true;
      echo 'street_address = "'.POP_PO_BOX_ERROR.'";';exit();
    } else if ( preg_match('/P\.O/si', $street_address) ) {
      $error = true;
      echo 'street_address = "'.POP_PO_BOX_ERROR.'";';exit();
    } else if ( preg_match('/PO\./si', $street_address) ) {
      $error = true;
      echo 'street_address = "'.POP_PO_BOX_ERROR.'";';exit();
    }
  }
//echo   ENTRY_STREET_ADDRESS_MIN_LENGTH.'--'.ENTRY_STREET_ADDRESS_ERROR.'--'.POP_PO_BOX_ERROR;exit();
  // END PO Box Ban 1/1
  
  
	if(isset($_GET['city'])){
		echo 'var city="";';
		  if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
		    $error = true;
		    echo 'city="'.ENTRY_CITY_ERROR.'";';exit();
		  }
	}	  

echo 'var postcode = "";';
  if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
    $error = true;
    echo 'postcode="'.ENTRY_POST_CODE_ERROR.'";';exit();
  }
  
echo 'var country = "";';  
  if ( (is_numeric($country) == false) || ($country < 1) ) {
    $error = true;
    echo 'country ="'.ENTRY_COUNTRY_ERROR.'";';exit();
  }

//echo ENTRY_CITY_MIN_LENGTH.'--'.ENTRY_CITY_ERROR.'--'.ENTRY_POSTCODE_MIN_LENGTH.'--'.ENTRY_POST_CODE_ERROR.'--'.ENTRY_COUNTRY_ERROR;exit();


  //valid optional data
  /*if (ACCOUNT_GENDER == 'true') {
    if ( ($gender != 'm') && ($gender != 'f') ) {
      $error = true;
      $messageStack->add_session('eca_further', ENTRY_GENDER_ERROR);
    }
  }*/
echo 'var s_company = "";';
  if (ACCOUNT_COMPANY == 'true' && zen_not_null($_GET['company'])) {
    if ((int)ENTRY_COMPANY_MIN_LENGTH > 0 && strlen($company) < ENTRY_COMPANY_MIN_LENGTH) {
      $error = true;
      echo 's_company="'.ENTRY_COMPANY_ERROR.';';exit();
    }
  }
  /*if (ACCOUNT_STATE == 'true'  && zen_not_null($_GET['state'])) {
    $check_query = "SELECT count(*) AS total
                    FROM " . TABLE_ZONES . "
                    WHERE zone_country_id = :zoneCountryID";
    $check_query = $db->bindVars($check_query, ':zoneCountryID', $country, 'integer');
    $check = $db->Execute($check_query);
    $entry_state_has_zones = ($check->fields['total'] > 0);
    if ($entry_state_has_zones == true) {
      $zone_query = "SELECT distinct zone_id, zone_name, zone_code
                     FROM " . TABLE_ZONES . "
                     WHERE zone_country_id = :zoneCountryID
                     AND " .
                     ((trim($state) != '' && $zone_id == 0) ? "(upper(zone_name) like ':zoneState%' OR upper(zone_code) like '%:zoneState%') OR " : "") .
                    "zone_id = :zoneID
                     ORDER BY zone_code ASC, zone_name";

      $zone_query = $db->bindVars($zone_query, ':zoneCountryID', $country, 'integer');
      $zone_query = $db->bindVars($zone_query, ':zoneState', strtoupper($state), 'noquotestring');
      $zone_query = $db->bindVars($zone_query, ':zoneID', $zone_id, 'integer');
      $zone = $db->Execute($zone_query);

      //look for an exact match on zone ISO code
      $found_exact_iso_match = ($zone->RecordCount() == 1);
      if ($zone->RecordCount() > 1) {
        while (!$zone->EOF && !$found_exact_iso_match) {
          if (strtoupper($zone->fields['zone_code']) == strtoupper($state) ) {
            $found_exact_iso_match = true;
            continue;
          }
          $zone->MoveNext();
        }
      }

      if ($found_exact_iso_match) {
        $zone_id = $zone->fields['zone_id'];
        $zone_name = $zone->fields['zone_name'];
      } else {
        $error = true;
        $error_state_input = true;
        $messageStack->add_session('eca_further', ENTRY_STATE_ERROR_SELECT);
      }
    } else {
      if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
        $error = true;
        $error_state_input = true;
        $messageStack->add_session('eca_further', ENTRY_STATE_ERROR);
      }
    }
  }*/

echo 'var s_telephone="";';
  if (ACCOUNT_TELEPHONE == 'true'  && zen_not_null($_GET['telephone'])) {
    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;
      echo 's_telephone="'.ENTRY_TELEPHONE_NUMBER_ERROR.'";';exit();
    }
  }
//echo ACCOUNT_TELEPHONE.'--'.ENTRY_TELEPHONE_MIN_LENGTH.'--'.ENTRY_TELEPHONE_NUMBER_ERROR;exit();
  
  if (isset($_GET['newsletter'])) {
    $newsletter = zen_db_prepare_input($_GET['newsletter']);
  }
  
  if (!$error) {    
//echo 'var status=1;';exit();

    $sql_data_array = array('customers_id' => $_SESSION['customer_id'],
                            'entry_firstname' => $firstname,
                            'entry_lastname' => $lastname,
                            'entry_street_address' => $street_address,
                            'entry_postcode' => $postcode,
                            'entry_city' => $city,
                            'entry_country_id' => $country);

    if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
    if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
    if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;
    if (ACCOUNT_STATE == 'true') {
      if ($zone_id > 0) {
        $sql_data_array['entry_zone_id'] = $zone_id;
        $sql_data_array['entry_state'] = '';
      } else {
        $sql_data_array['entry_zone_id'] = '0';
        $sql_data_array['entry_state'] = $state;
      }
    }

    zen_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

    $address_id = $db->Insert_ID();

    $sql = "update " . TABLE_CUSTOMERS . "
            set   customers_firstname='".$firstname."',
			      customers_lastname='".$lastname."',
				  customers_dob='".$dob."',
				  customers_gender='".$gender."',
				  customers_telephone='".$telephone."',
                            	  customers_newsletter='".$newsletter."',
			      customers_default_address_id = '" . (int)$address_id . "'
            where customers_id = '" . (int)$_SESSION['customer_id'] . "'";

    $db->Execute($sql);
    
    		$customer_emailaddress = $db->Execute("select customers_email_address from  ".TABLE_CUSTOMERS."  where customers_id=".(int)$_SESSION['customer_id']);
		    
		// BEGIN newsletter_subscribe mod 1/1
		// If a newsletter only account exists we update the info,
		// but keep the subscription active, and give them a message that to
		// change they should do so on their account page (after creation).
		    if(defined('NEWSONLY_SUBSCRIPTION_ENABLED') && (NEWSONLY_SUBSCRIPTION_ENABLED=='true')) {
		      $check_subscribers_query = "select count(*) as total from " . TABLE_SUBSCRIBERS . "
		                                  where email_address = '" . $customer_emailaddress->fields['customers_email_address'] . "' ";
		      $check_subscribers = $db->Execute($check_subscribers_query);
		      if ($check_subscribers->fields['total'] > 0) {
		        $sql = "UPDATE " . TABLE_SUBSCRIBERS . " SET
		                customers_id = '" . (int)$_SESSION['customer_id'] . "',
		                email_format = '" . $customer_emailaddress->fields['customers_email_address'] . "',
		                confirmed = '1' 
		                WHERE email_address = '" . $customer_emailaddress->fields['customers_email_address'] . "' ";
		        $db->Execute($sql);
		        $messageStack->add_session('create_account', SUBSCRIBE_MERGED_NEWSONLY_ACCT);
		      } else {
		        if ($newsletter){
		          $sql = "INSERT INTO " . TABLE_SUBSCRIBERS . " 
		                  (customers_id, email_address, email_format, confirmed, subscribed_date)
		                  VALUES ('" . (int)$_SESSION['customer_id'] . "', '" . $customer_emailaddress->fields['customers_email_address'] . "', '" . zen_db_input($email_format) . "', '1', now())";
		          $db->Execute($sql);
		        }
		      }
		    }
		// END newsletter_subscribe mod 1/1    
		
		
    $_SESSION['shipping'] = '';    

    if (SESSION_RECREATE == 'True') {
       zen_session_recreate();
    }

    $_SESSION['customer_first_name'] = $firstname;
	$_SESSION['customer_last_name']=$lastname;
    $_SESSION['customer_default_address_id'] = $address_id;
	$_SESSION['sendto']=$address_id;
    $_SESSION['customer_country_id'] = $country;
    $_SESSION['customer_zone_id'] = $zone_id;
    //$_SESSION['customers_authorization'] = $customers_authorization;

    // restore cart contents
    $_SESSION['cart']->restore_contents();   
    /*if (FEC_STATUS == 'true') {
	     zen_redirect(zen_href_link(FILENAME_CHECKOUT, "&action=null", 'SSL'));
	}*/

  } //endif !error
}
/*
 * Set flags for template use:
 */
  $selected_country = (isset($_GET['zone_country_id']) && $_GET['zone_country_id'] != '') ? $country : SHOW_CREATE_ACCOUNT_DEFAULT_COUNTRY;
  
echo 'var status=1;';
?>