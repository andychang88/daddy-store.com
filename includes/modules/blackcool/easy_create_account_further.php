<?php
/**
 * create_account header_php.php
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 106 2010-03-14 20:55:15Z numinix $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_MODULE_START_EASY_CREATE_ACCOUNT_FURTHER');

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

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
  //$email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
  //$newsletter = (ACCOUNT_NEWSLETTER_STATUS == '1' ? false : true);
  
  $process_shipping = false;
  $zone_name_shipping = '';
  $entry_state_has_zones_shipping = '';
  $error_state_input_shipping = false;
  $state_shipping = '';
  $zone_id_shipping = 0;

/**
 * Process form contents
 */
if (isset($_POST['action']) && ($_POST['action'] == 'easy_create_account_further')) {
  $process = true;

  if (ACCOUNT_GENDER == 'true') {
    if (isset($_POST['gender'])) {
      $gender = zen_db_prepare_input($_POST['gender']);
    } else {
      $gender = false;
    }
  }
  /*if (isset($_POST['email_format'])) {
    $email_format = zen_db_prepare_input($_POST['email_format']);
  }*/

  if (ACCOUNT_COMPANY == 'true') $company = zen_db_prepare_input($_POST['company']);
  $firstname = zen_db_prepare_input($_POST['firstname']);
  $lastname = zen_db_prepare_input($_POST['lastname']);
  //$nick = zen_db_prepare_input($_POST['nick']);
  //modified by john 2010-05-20 no limit for birthdate
  //if (ACCOUNT_DOB == 'true') $dob = (empty($_POST['dob']) ? zen_db_prepare_input('0001-01-01 00:00:00') : zen_db_prepare_input($_POST['dob']));
  //$dob = (empty($_POST['dob']) ? zen_db_prepare_input('0001-01-01 00:00:00') : zen_db_prepare_input($_POST['dob']));
  //end*/
  //$email_address = zen_db_prepare_input($_POST['email_address']);
  $street_address = zen_db_prepare_input($_POST['street_address']);
  if (ACCOUNT_SUBURB == 'true') $suburb = zen_db_prepare_input($_POST['suburb']);
  $postcode = zen_db_prepare_input($_POST['postcode']);
  $city = zen_db_prepare_input($_POST['city']);
  if (ACCOUNT_STATE == 'true') {
    $state = zen_db_prepare_input($_POST['state']);
    if (isset($_POST['zone_id'])) {
      $zone_id = zen_db_prepare_input($_POST['zone_id']);
    } else {
      $zone_id = false;
    }
  }
  $country = zen_db_prepare_input($_POST['zone_country_id']);
  //modified by john 2010-05-20 no limit for telephone
  if (ACCOUNT_TELEPHONE == 'true') {
    $telephone = zen_db_prepare_input($_POST['telephone']);
  }
  /*$telephone = zen_db_prepare_input($_POST['telephone']);
  //end limit for telephone*/
  $fax = zen_db_prepare_input($_POST['fax']);


  if (ACCOUNT_GENDER == 'true') {
    if ( ($gender != 'm') && ($gender != 'f') ) {
      $error = true;
      $messageStack->add_session('login', ENTRY_GENDER_ERROR);
    }
  }
  if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
    $error = true;
    $messageStack->add_session('login', ENTRY_FIRST_NAME_ERROR);
  }

  if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
    $error = true;
    $messageStack->add_session('login', ENTRY_LAST_NAME_ERROR);
  }
  
  if (ACCOUNT_COMPANY == 'true') {
    if ((int)ENTRY_COMPANY_MIN_LENGTH > 0 && strlen($company) < ENTRY_COMPANY_MIN_LENGTH) {
      $error = true;
      $messageStack->add_session('login', ENTRY_COMPANY_ERROR);
    }
  }

  if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
    $error = true;
    $messageStack->add_session('login', ENTRY_STREET_ADDRESS_ERROR);
  }
  
  // BEGIN PO Box Ban 1/1
  if (defined('PO_BOX_ERROR')) {
    if ( preg_match('/PO BOX/si', $street_address) ) {
      $error = true;
      $messageStack->add_session('login', PO_BOX_ERROR);
    } else if ( preg_match('/POBOX/si', $street_address) ) {
      $error = true;
      $messageStack->add_session('login', PO_BOX_ERROR);
    } else if ( preg_match('/P\.O\./si', $street_address) ) {
      $error = true;
      $messageStack->add_session('login', PO_BOX_ERROR);
    } else if ( preg_match('/P\.O/si', $street_address) ) {
      $error = true;
      $messageStack->add_session('login', PO_BOX_ERROR);
    } else if ( preg_match('/PO\./si', $street_address) ) {
      $error = true;
      $messageStack->add_session('login', PO_BOX_ERROR);
    }
  }
  // END PO Box Ban 1/1

  if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
    $error = true;
    $messageStack->add_session('login', ENTRY_CITY_ERROR);
  }
  if (ACCOUNT_STATE == 'true') {
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
        $messageStack->add_session('login', ENTRY_STATE_ERROR_SELECT);
      }
    } else {
      if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
        $error = true;
        $error_state_input = true;
        $messageStack->add_session('login', ENTRY_STATE_ERROR);
      }
    }
  }

  if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
    $error = true;
    $messageStack->add_session('login', ENTRY_POST_CODE_ERROR);
  }

  if ( (is_numeric($country) == false) || ($country < 1) ) {
    $error = true;
    $messageStack->add_session('login', ENTRY_COUNTRY_ERROR);
  }
  /*if (ACCOUNT_TELEPHONE == 'true') {
    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;
      $messageStack->add_session('login', ENTRY_TELEPHONE_NUMBER_ERROR);
    }
  }  */

  if ($error == true) {
    // hook notifier class
    $zco_notifier->notify('NOTIFY_FAILURE_DURING_CREATE_ACCOUNT');
    // redirect back to login page
    zen_redirect(zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
  } else {    

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
				  customers_gender='".$gender."',
				  customers_telephone='".$telephone."',
			      customers_default_address_id = '" . (int)$address_id . "'
            where customers_id = '" . (int)$_SESSION['customer_id'] . "'";

    $db->Execute($sql);
    
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
    if (FEC_STATUS == 'true') {
	     zen_redirect(zen_href_link(FILENAME_CHECKOUT, "&action=null", 'SSL'));
	}
  } //endif !error
}
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_MODULE_END_EASY_CREATE_ACCOUNT_FURTHER');
?>